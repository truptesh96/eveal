<?php

/**
 * Shown in the Post page (called from SQ_Controllers_Menu)
 *
 */
class SQ_Models_Post {

    /**
     * Search for posts in the local blog
     *
     * @param array $args
     * @return array|WP_Error
     */
    public function searchPost($args) {
        wp_reset_query();
        $wp_query = new WP_Query($args);
        return $wp_query->get_posts();
    }

    /**
     * Returns the attachment from the file URL
     *
     * @param $image_url
     * @return mixed
     */
    function findAttachmentByUrl($image_url) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE `post_type` = %s AND `guid` like '%%%s';", 'attachment', $image_url));
    }

    /**
     * Add the image for Open Graph
     *
     * @param string $file
     * @return array [name (the name of the file), image (the path of the image), message (the returned message)]
     *
     */
    function addImage(&$file, $overrides = false, $time = null) {
        // The default error handler.
        if (!function_exists('wp_handle_upload_error')) {

            function wp_handle_upload_error(&$file, $message) {
                return array('error' => $message);
            }

        }

        /**
         * Filter data for the current file to upload.
         *
         * @since 2.9.0
         *
         * @param array $file An array of data for a single file.
         */
        $file = apply_filters('wp_handle_upload_prefilter', $file);

        // You may define your own function and pass the name in $overrides['upload_error_handler']
        $upload_error_handler = 'wp_handle_upload_error';

        // You may have had one or more 'wp_handle_upload_prefilter' functions error out the file. Handle that gracefully.
        if (isset($file['error']) && !is_numeric($file['error']) && $file['error'])
            return $upload_error_handler($file, $file['error']);

        // You may define your own function and pass the name in $overrides['unique_filename_callback']
        $unique_filename_callback = null;

        // $_POST['action'] must be set and its value must equal $overrides['action'] or this:
        $action = 'sq_ajax_save_ogimage';

        // Courtesy of php.net, the strings that describe the error indicated in $_FILES[{form field}]['error'].
        $upload_error_strings = array(false,
            esc_html__("The uploaded file exceeds the upload_max_filesize directive in php.ini."),
            esc_html__("The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form."),
            esc_html__("The uploaded file was only partially uploaded."),
            esc_html__("No file was uploaded."),
            '',
            esc_html__("Missing a temporary folder."),
            esc_html__("Failed to write file to disk."),
            esc_html__("File upload stopped by extension."));

        // All tests are on by default. Most can be turned off by $overrides[{test_name}] = false;
        $test_form = true;
        $test_size = true;
        $test_upload = true;

        // If you override this, you must provide $ext and $type!!!!
        $test_type = true;
        $mimes = false;

        // Install user overrides. Did we mention that this voids your warranty?
        if (is_array($overrides))
            extract($overrides, EXTR_OVERWRITE);

        // A correct form post will pass this test.
        if ($test_form && (!isset($_POST['action']) || ($_POST['action'] != $action)))
            return call_user_func($upload_error_handler, $file, esc_html__("Invalid form submission."));

        // A successful upload will pass this test. It makes no sense to override this one.
        if (isset($file['error']) && $file['error'] > 0) {
            return call_user_func($upload_error_handler, $file, $upload_error_strings[$file['error']]);
        }

        // A non-empty file will pass this test.
        if ($test_size && !($file['size'] > 0)) {
            if (is_multisite())
                $error_msg = esc_html__("File is empty. Please upload something more substantial.", _SQ_PLUGIN_NAME_);
            else
                $error_msg = esc_html__("File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your php.ini or by post_max_size being defined as smaller than upload_max_filesize in php.ini.", _SQ_PLUGIN_NAME_);
            return call_user_func($upload_error_handler, $file, $error_msg);
        }

        // A properly uploaded file will pass this test. There should be no reason to override this one.
        if ($test_upload && !@ is_uploaded_file($file['tmp_name']))
            return call_user_func($upload_error_handler, $file, esc_html__("Specified file failed upload test.", _SQ_PLUGIN_NAME_));

        // A correct MIME type will pass this test. Override $mimes or use the upload_mimes filter.
        if ($test_type) {
            $wp_filetype = wp_check_filetype_and_ext($file['tmp_name'], $file['name'], $mimes);

            extract($wp_filetype);

            // Check to see if wp_check_filetype_and_ext() determined the filename was incorrect
            if (isset($proper_filename) && $proper_filename <> '')
                $file['name'] = $proper_filename;

            if ((!isset($type) || !isset($ext)) && !current_user_can('unfiltered_upload'))
                return call_user_func($upload_error_handler, $file, esc_html__("Sorry, this file type is not permitted for security reasons.", _SQ_PLUGIN_NAME_));

            if (!$ext)
                $ext = ltrim(strrchr($file['name'], '.'), '.');

            if (!$type)
                $type = $file['type'];
        } else {
            $type = '';
        }

        // A writable uploads dir will pass this test. Again, there's no point overriding this one.
        if (!(($uploads = wp_upload_dir($time)) && false === $uploads['error']))
            return call_user_func($upload_error_handler, $file, $uploads['error']);

        $filename = wp_unique_filename($uploads['path'], $file['name'], $unique_filename_callback);

        // Move the file to the uploads dir
        $new_file = $uploads['path'] . "/$filename";
        if (false === @ move_uploaded_file($file['tmp_name'], $new_file)) {
            if (0 === strpos($uploads['basedir'], ABSPATH))
                $error_path = str_replace(ABSPATH, '', $uploads['basedir']) . $uploads['subdir'];
            else
                $error_path = basename($uploads['basedir']) . $uploads['subdir'];

            return $upload_error_handler($file, sprintf(esc_html__("The uploaded file could not be moved to %s.", _SQ_PLUGIN_NAME_), $error_path));
        }

        // Set correct file permissions
        $stat = stat(dirname($new_file));
        $perms = $stat['mode'] & 0000666;
        @ chmod($new_file, $perms);

        // Compute the URL
        $url = $uploads['url'] . "/$filename";

        if (is_multisite())
            delete_transient('dirsize_cache');

        /**
         * Filter the data array for the uploaded file.
         *
         * @since 2.1.0
         *
         * @param array $upload {
         *     Array of upload data.
         *
         * @type string $file Filename of the newly-uploaded file.
         * @type string $url URL of the uploaded file.
         * @type string $type File type.
         * }
         * @param string $context The type of upload action. Accepts 'upload' or 'sideload'.
         */
        return apply_filters('wp_handle_upload', array('file' => $new_file, 'url' => $url, 'type' => $type), 'upload');
    }

    /**
     * Upload the image on server from version 2.0.4
     *
     * @param $url
     * @param bool $basename
     * @return array|bool
     */
    public function upload_image($url, $basename) {
        if (strpos($url, 'http') === false && strpos($url, '//') !== false) {
            $url = 'http:' . $url;
        }

        $filename = false;
        $response = wp_remote_get($url, array('timeout' => 15));
        $body = wp_remote_retrieve_body($response);
        $type = wp_remote_retrieve_header($response, 'content-type');

        $extension = pathinfo($url, PATHINFO_EXTENSION);
        $mimes = get_allowed_mime_types();
        foreach ($mimes as $extensions => $mime) {
            if (in_array($extension, explode('|', $extensions))) {
                $filename = $basename . '.' . $extension;
                break;
            }
        }
        if (!$filename) {
            foreach ($mimes as $extensions => $mime) {
                if ($mime == $type) {
                    $filename = $basename . '.' . current(explode('|', $extensions));
                    break;
                }
            }
        }

        if (!$filename) return false;

        $file = wp_upload_bits($filename, null, $body, null);

        if (!isset($file['error']) || $file['error'] == '')
            if (isset($file['url']) && $file['url'] <> '') {
                $file['filename'] = $filename;
                $file['type'] = $type;
                return $file;
            }

        return false;
    }

    public function getTasks() {
        $sla_tasks = array(
            "" => array(
                'longtail_keyword' => array(
                    'title' => esc_html__("Keyword with 2 or more words", _SQ_PLUGIN_NAME_),
                    'help' => esc_html__("Even if a long tail keyword won't bring as many visitors as one keyword would, the traffic those keywords will bring will be better, and more focused towards what you're selling.", _SQ_PLUGIN_NAME_),
                )
            ),
            esc_html__("Domain", _SQ_PLUGIN_NAME_) => array(
                'pinguin_url' => array(
                    'title' => esc_html__("Keyword is present in the URL", _SQ_PLUGIN_NAME_),
                    'help' => esc_html__("The keywords must be present in the URL for a better ranking. You should  consider not to add a keyword more than once.", _SQ_PLUGIN_NAME_),
                ),
            ),
            esc_html__("Clean & Friendly", _SQ_PLUGIN_NAME_) => array(
                'density_title' => array(
                    'title' => sprintf(esc_html__("Title is Google Friendly %s: more keywords %s: over-optimized! %s", _SQ_PLUGIN_NAME_), "<span id='sq_density_title_val'></span><span id='sq_density_title_low' style='display: none'>", "</span><span id='sq_density_title_high' style='display: none'>", "</span><span id='sq_density_title_longtail' style='display: none'></span><span id='sq_density_title_done' style='display: none'></span>"),
                    'help' => esc_html__("It calculates the right number of times your keyword should appear mentioned in the text and makes sure you do not over-optimize.", _SQ_PLUGIN_NAME_),
                ),
                'density' => array(
                    'title' => sprintf(esc_html__("Content is Google Friendly %s: more keywords %s: over-optimized! %s", _SQ_PLUGIN_NAME_), "<span id='sq_density_val'></span><span id='sq_density_low' style='display: none'>", "</span><span id='sq_density_high' style='display: none'>", "</span><span id='sq_density_done' style='display: none'></span>"),
                    'help' => esc_html__("It calculates the right number of times your keyword should appear mentioned in the text and makes sure you do not over-optimize", _SQ_PLUGIN_NAME_),
                ),
                'over_density' => array(
                    'title' => sprintf(esc_html__("Over Optimization %s", _SQ_PLUGIN_NAME_), "<span id='sq_over_density_val'></span><span id='sq_over_density_done' style='display: none'></span>"),
                    'help' => esc_html__("Checks if there are words in the whole text that appear way too many times", _SQ_PLUGIN_NAME_),
                ),
                'human_friendly' => array(
                    'title' => sprintf(esc_html__("Human Friendly %s", _SQ_PLUGIN_NAME_), "<span id='sq_human_friendly_val'></span><span id='sq_human_friendly_done' style='display: none'></span>"),
                    'help' => esc_html__("Your readers (who are not search engine bots) should find a clear text, with a rich vocabulary, that takes into account some basic rules of writing: such as having an introduction, a conclusion (in which you state the topic you're writing about). Also, you can improve their reading experience by avoiding repetitions.", _SQ_PLUGIN_NAME_),
                ),
            ),
            esc_html__("Title", _SQ_PLUGIN_NAME_) => array(
                'title' => array(
                    'title' => esc_html__("Keywords are used in Title", _SQ_PLUGIN_NAME_),
                    'help' => esc_html__("The keywords need to appear in the title of the article", _SQ_PLUGIN_NAME_),
                ),
                'title_length' => array(
                    'title' => esc_html__("Title length is between 10-75 chars", _SQ_PLUGIN_NAME_),
                    'help' => esc_html__("The optimum length for Title is between 10-75 chars on major search engines.", _SQ_PLUGIN_NAME_),
                ),
                'pinguin_title' => array(
                    'title' => esc_html__("Title is different from domain name", _SQ_PLUGIN_NAME_),
                    'help' => esc_html__("Since the Google Penguin Update, the title must be different from the domain name, or you might get banned soon.", _SQ_PLUGIN_NAME_),
                ),
            ),
            esc_html__("Content", _SQ_PLUGIN_NAME_) => array(
                'body' => array(
                    'title' => esc_html__("Keywords are used in Content", _SQ_PLUGIN_NAME_),
                    'help' => esc_html__("The keyword must appear in the body of the article, at least once", _SQ_PLUGIN_NAME_),
                ),
                'strong' => array(
                    'title' => sprintf(esc_html__("Bold one of the keywords %s", _SQ_PLUGIN_NAME_), '<strong><span class="sq_request_highlight_key" style="color:lightcoral; text-decoration:underline; cursor: pointer;"></span></strong>'),
                    'help' => esc_html__("Bolding your keywords will help search engines figure out what your content is about and what topic you cover. It's also useful for your Human readers to bold some of the most important ideas.", _SQ_PLUGIN_NAME_),
                ),
                'h2_6' => array(
                    'title' => esc_html__("Keywords used in headline", _SQ_PLUGIN_NAME_),
                    'help' => esc_html__("The keywords should be used in headings like H2, H3, H4. Try NOT to use them all, for it will seem to be a SEO abuse. You can use your H2 button from the editor to do this. It works like the Bold, Italic or Underline buttons.", _SQ_PLUGIN_NAME_),
                ),
                'img' => array(
                    'title' => esc_html__("Use image(s) in content or featured image", _SQ_PLUGIN_NAME_),
                    'help' => esc_html__("Articles need to be optimized for human beings as well, so you should place an image at the begining of your article.", _SQ_PLUGIN_NAME_),
                ),
                'alt' => array(
                    'title' => esc_html__("Use keywords in the Alternative Text field of the image", _SQ_PLUGIN_NAME_),
                    'help' => esc_html__("Add at least one image in your article. Now use your keyword in the description of the image.  The Alternative Text field of the image.", _SQ_PLUGIN_NAME_),
                ),
            ),
        );

        //for PHP 7.3.1 version
        $sla_tasks = array_filter($sla_tasks);

        return $sla_tasks;
    }
}
