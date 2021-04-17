<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Controllers_Post extends SQ_Classes_FrontController {

    public $saved;

    public function init() {
        parent::init();

        if (is_rtl()) {
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('rtl');
        }

        //load the draggable script in post edit for the floating SLA
        wp_enqueue_script("jquery-ui-core");
        wp_enqueue_script("jquery-ui-draggable");
    }

    /**
     * Hook the post save
     */
    public function hookPost() {
        if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '')
            return;

        //Hook and save the Snippet and Keywords for Attachment Pages
        add_action('wp_insert_attachment_data', array($this, 'hookAttachmentSave'), 12, 2);

        //if the option to save the images locally is activated
        if (SQ_Classes_Helpers_Tools::getOption('sq_local_images')) {
            add_filter('wp_insert_post_data', array($this, 'checkImage'), 13, 2);
        }

        //Remove the SLA highlight from post
        add_filter('wp_insert_post_data', array($this, 'removeHighlight'), 12, 2);

        //Hook the save post action
        add_action('save_post', array($this, 'hookSavePost'), 11, 2);

        //Hook the Move To Trash action
        add_action('wp_trash_post', array(SQ_Classes_ObjController::getClass('SQ_Models_PostsList'), 'hookUpdateStatus'));

        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap')) {
            add_action('transition_post_status', array(SQ_Classes_ObjController::getClass('SQ_Controllers_Sitemaps'), 'refreshSitemap'), PHP_INT_MAX, 3);
        }

        //Check the compatibility with Woocommerce
        if (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_product_custom')) {
            SQ_Classes_ObjController::getClass('SQ_Models_Compatibility')->checkWooCommerce();
        }

        //Make sure the URL is local and not changed by other plugins
        add_filter('sq_homeurl', array($this, 'getHomeUrl'));
    }

    /**
     * Get the current Home URL
     * @param $url
     * @return mixed
     */
    public function getHomeUrl($url) {
        if (defined('WP_HOME')) {
            return WP_HOME;
        } else {
            return get_option('home');
        }
    }

    /**
     * Initialize the TinyMCE editor for the current use
     *
     * @return void
     */
    public function hookEditor() {
        $this->saved = array();
    }

    /**
     * Remove the Squirrly Highlights in case there are some left
     * @param array $post_data
     * @param array $postarr
     * @return array
     */
    public function removeHighlight($post_data, $postarr) {

        if (isset($post_data['post_type']) && $post_data['post_type'] <> '') {
            //Exclude types for SLA
            $excludes = SQ_Classes_Helpers_Tools::getOption('sq_sla_exclude_post_types');
            if (in_array($post_data['post_type'], $excludes)) {
                return $post_data;
            }
        }

        if (!isset($post_data['post_content']) || !isset($postarr['ID'])) {
            return $post_data;
        }

        if (strpos($post_data['post_content'], '<mark') !== false) {
            $post_data['post_content'] = preg_replace('/<mark[^>]*(data-markjs|mark_counter)[^>]*>([^<]*)<\/mark>/i', '$2', $post_data['post_content']);
        }
        return $post_data;
    }

    /**
     * Check if the image is a remote image and save it locally
     *
     * @param array $post_data
     * @param array $postarr
     * @return array
     */
    public function checkImage($post_data, $postarr) {

        if (!isset($post_data['post_content']) || !isset($postarr['ID'])) {
            return $post_data;
        }

        if (isset($post_data['post_type']) && $post_data['post_type'] <> '') {
            //Exclude types for SLA
            $excludes = SQ_Classes_Helpers_Tools::getOption('sq_sla_exclude_post_types');
            if (in_array($post_data['post_type'], $excludes)) {
                return $post_data;
            }
        }

        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $urls = array();
        if (function_exists('preg_match_all')) {
            @preg_match_all('/<img[^>]*src=[\'"]([^\'"]+)[\'"][^>]*>/i', stripslashes($post_data['post_content']), $out);

            if (!empty($out)) {
                if (!is_array($out[1]) || count((array)$out[1]) == 0) {
                    return $post_data;
                }

                if (get_bloginfo('wpurl') <> '') {
                    $domain = parse_url(home_url(), PHP_URL_HOST);

                    foreach ($out[1] as $row) {
                        if (strpos($row, '//') !== false && strpos($row, $domain) === false) {
                            if (!in_array($row, $urls)) {
                                $urls[] = $row;
                            }
                        }
                    }
                }
            }
        }

        if (!is_array($urls) || (is_array($urls) && count((array)$urls) == 0)) {
            return $post_data;
        }

        if (count((array)$urls) > 1) {
            $urls = array_unique($urls);
        }

        $time = microtime(true);

        //get the already downloaded images
        $images = get_post_meta((int)$postarr['ID'], '_sq_image_downloaded');

        foreach ($urls as $url) {

            //Set the title and filename
            $basename = md5(basename($url));
            $keyword = SQ_Classes_Helpers_Tools::getValue('sq_keyword', false);
            if ($keyword) {
                $title = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\[\]\\x80-\\xff ]|i', '', $keyword);
                $basename = preg_replace('|[^a-z0-9-_]|i', '', str_replace(' ', '-', strtolower($keyword)));
            }

            //check the images
            if (!empty($images)) {
                foreach ($images as $key => $local) {
                    $local = json_decode($local, true);
                    if ($local['url'] == md5($url)) {

                        //replace the image in the content
                        $post_data['post_content'] = str_replace($url, $local['file'], $post_data['post_content']);

                        continue 2;
                    }
                }
            }

            //Upload the image on server
            if ($file = $this->model->upload_image($url, $basename)) {
                if (!file_is_valid_image($file['file']))
                    continue;

                $local_file = $file['url'];
                if ($local_file !== false) {

                    //save as downloaded image to avoid duplicates
                    add_post_meta((int)$postarr['ID'], '_sq_image_downloaded', wp_json_encode(array('url' => md5($url), 'file' => $local_file)));

                    //replace the image in the content
                    $post_data['post_content'] = str_replace($url, $local_file, $post_data['post_content']);

                    //add the attachment image
                    $attach_id = wp_insert_attachment(array(
                        'post_mime_type' => $file['type'],
                        'post_title' => $title,
                        'post_content' => '',
                        'post_status' => 'inherit',
                        'guid' => $local_file
                    ), $file['file'], $postarr['ID']);

                    $attach_data = wp_generate_attachment_metadata($attach_id, $file['file']);
                    wp_update_attachment_metadata($attach_id, $attach_data);

                }
            }

            if (microtime(true) - $time >= 10) {
                break;
            }

        }

        return $post_data;
    }

    /**
     * Hook the Attachment save data
     * Don't use it for post save
     *
     * @param array $post_data
     * @param array $postarr
     * @return array
     */
    public function hookAttachmentSave($post_data, $postarr) {

        if (isset($postarr['ID']) && $post = get_post($postarr['ID'])) {
            //If the post is a new or edited post
            if (wp_is_post_autosave($post->ID) == '' &&
                get_post_status($post->ID) <> 'auto-draft' &&
                get_post_status($post->ID) <> 'inherit'
            ) {

                if ($post_data['post_type'] == 'attachment') {
                    //Save the SEO
                    SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->saveSEO($post->ID);

                    //Send the optimization when attachment page
                    $this->sendSeo($post);
                }
            }
        }

        return $post_data;
    }

    /**
     * Hook after save post to make sure the data is saved
     * @param $post_id
     */
    public function hookSavePost($post_id) {

        if ($post_id && $post = get_post($post_id)) {
            //If the post is a new or edited post
            if (wp_is_post_autosave($post->ID) == '' &&
                get_post_status($post->ID) <> 'auto-draft' &&
                get_post_status($post->ID) <> 'inherit'
            ) {

                //Exclude types for SLA
                if (isset($post->post_type) && $post->post_type <> '') {
                    $excludes = SQ_Classes_Helpers_Tools::getOption('sq_sla_exclude_post_types');
                    if (in_array($post->post_type, $excludes)) {
                        return;
                    }
                }

                //Update the SEO Keywords from Live Assistant and Permalink
                add_filter('sq_seo_before_save', array($this, 'addSeoKeywords'), 11, 1);
                //Update the redirect to old slugs
                add_filter('sq_url_before_save', array($this, 'checkOldSlugs'), 11, 2);

                //Save the SEO
                SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->saveSEO($post->ID);

                //Send the optimization when attachment page
                $this->sendSeo($post);
            }
        }

    }

    /**
     * Send the Post to Squirrly API
     * @param $post
     */
    public function sendSeo($post) {
        $args = array();

        $seo = SQ_Classes_Helpers_Tools::getValue('sq_seo', '');

        if (is_array($seo) && count((array)$seo) > 0) {
            $args['seo'] = implode(',', $seo);
        }

        $args['keyword'] = SQ_Classes_Helpers_Tools::getValue('sq_keyword', '');
        $args['status'] = $post->post_status;
        $args['permalink'] = get_permalink($post->ID);
        $args['author'] = $post->post_author;
        $args['post_id'] = $post->ID;
        $args['referer'] = 'edit';

        if ($args['permalink']) {
            SQ_Classes_RemoteController::savePost($args);
        }

    }

    /**
     * Called when Post action is triggered
     *
     * @return void
     */
    public function action() {
        parent::action();
        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            case 'sq_create_demo':
                if (!current_user_can('sq_manage_snippet')) {
                    SQ_Classes_Error::setError(esc_html__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    break;
                }

                $post_type = 'post';
                if (post_type_exists($post_type)) {
                    $wp_filesystem = SQ_Classes_Helpers_Tools::initFilesystem();

                    if ($wp_filesystem->exists(_SQ_ROOT_DIR_ . 'demo.json')) {
                        $json = json_decode($wp_filesystem->get_contents(_SQ_ROOT_DIR_ . 'demo.json'));

                        if (isset($json->demo->title) && isset($json->demo->content)) {
                            $args = array();
                            $args['s'] = '"' . addslashes($json->demo->title) . '"';
                            $args['post_type'] = $post_type;
                            //if the post doesn't exists already or is changed
                            if (!$posts = SQ_Classes_ObjController::getClass('SQ_Models_Post')->searchPost($args)) {

                                // Create post object
                                $post = array(
                                    'post_title' => $json->demo->title,
                                    'post_content' => $json->demo->content,
                                    'post_status' => 'draft',
                                    'comment_status' => 'closed',
                                    'ping_status' => 'closed',
                                    'post_type' => $post_type,
                                    'post_author' => get_current_user_id(),
                                    'post_category' => array()
                                );

                                if ($post_id = wp_insert_post($post)) {
                                    if (!is_wp_error($post_id)) {
                                        wp_redirect(admin_url("post.php?post=" . $post_id . "&action=edit&post_type=" . $post_type . "&keyword=" . SQ_Classes_Helpers_Sanitize::escapeKeyword($json->demo->keyword, 'url')));
                                        exit();

                                    }
                                }
                            } else {
                                foreach ($posts as $post) {
                                    wp_redirect(admin_url("post.php?post=" . $post->ID . "&action=edit&post_type=" . $post_type . "&keyword=" . SQ_Classes_Helpers_Sanitize::escapeKeyword($json->demo->keyword, 'url')));
                                    exit();
                                }
                            }

                        }
                    }
                }
                SQ_Classes_Error::setError(esc_html__("Could not add the demo post.", _SQ_PLUGIN_NAME_));
                break;

            /**************************** AJAX CALLS *************************/
            case 'sq_ajax_save_ogimage':
                if (!current_user_can('sq_manage_snippet')) {
                    $response['error'] = SQ_Classes_Error::showNotices(esc_html__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo wp_json_encode($response);
                    exit();
                }

                if (!empty($_FILES['ogimage'])) {
                    $return = $this->model->addImage($_FILES['ogimage']);
                }
                if (isset($return['file'])) {
                    $return['filename'] = basename($return['file']);
                    $local_file = str_replace($return['filename'], urlencode($return['filename']), $return['url']);
                    $attach_id = wp_insert_attachment(array(
                        'post_mime_type' => $return['type'],
                        'post_title' => preg_replace('/\.[^.]+$/', '', $return['filename']),
                        'post_content' => '',
                        'post_status' => 'inherit',
                        'guid' => $local_file
                    ), $return['file'], SQ_Classes_Helpers_Tools::getValue('post_id'));

                    $attach_data = wp_generate_attachment_metadata($attach_id, $return['file']);
                    wp_update_attachment_metadata($attach_id, $attach_data);
                }
                SQ_Classes_Helpers_Tools::setHeader('json');

                echo wp_json_encode($return);
                exit();
            case 'sq_ajax_save_post':
                SQ_Classes_Helpers_Tools::setHeader('json');

                if (!current_user_can('sq_manage_snippet')) {
                    $response['error'] = SQ_Classes_Error::showNotices(esc_html__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    echo wp_json_encode($response);
                    exit();
                }

                $post_id = (int)SQ_Classes_Helpers_Tools::getValue('post_id');
                $referer = SQ_Classes_Helpers_Tools::getValue('referer', false);

                if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->getCurrentSnippet($post_id)) {

                    if (wp_is_post_autosave($post->ID) == '' &&
                        get_post_status($post->ID) <> 'auto-draft' &&
                        get_post_status($post->ID) <> 'inherit'
                    ) {

                        //Send the post optimization to Squirrly API
                        $this->sendSeo($post);

                        //save the reference for this post ID
                        if ($referer) update_post_meta($post_id, '_sq_sla', $referer);
                    }

                    echo wp_json_encode($post->toArray());
                } else {
                    $response['error'] = SQ_Classes_Error::showNotices(esc_html__("Can't get the post URL", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo wp_json_encode($response);
                }

                echo wp_json_encode(array());
                exit();
            case 'sq_ajax_get_post':
                SQ_Classes_Helpers_Tools::setHeader('json');

                if (!current_user_can('sq_manage_snippet')) {
                    $response['error'] = SQ_Classes_Error::showNotices(esc_html__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    echo wp_json_encode($response);
                    exit();
                }

                $post_id = (int)SQ_Classes_Helpers_Tools::getValue('post_id');

                if ($post_id > 0) {
                    if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->getCurrentSnippet($post_id)) {
                        if ($post->post_status <> 'publish') {
                            $post->url = sanitize_title($post->post_title);
                        }
                        echo wp_json_encode($post->toArray());
                    } else {
                        $response['error'] = SQ_Classes_Error::showNotices(esc_html__("Can't get the post URL", _SQ_PLUGIN_NAME_), 'sq_error');
                        SQ_Classes_Helpers_Tools::setHeader('json');
                        echo wp_json_encode($response);
                    }
                } else {
                    $response['error'] = SQ_Classes_Error::showNotices(esc_html__("Invalid request", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo wp_json_encode($response);
                }
                exit();
            case 'sq_ajax_type_click':
                SQ_Classes_Helpers_Tools::saveOptions('sq_img_licence', SQ_Classes_Helpers_Tools::getValue('licence'));
                exit();
            case 'sq_ajax_search_blog':
                $args = array();
                $args['post_type'] = 'post';
                $args['post_status'] = 'publish';

                if (SQ_Classes_Helpers_Tools::getValue('exclude') && SQ_Classes_Helpers_Tools::getValue('exclude') <> 'undefined') {
                    $args['post__not_in'] = array((int)SQ_Classes_Helpers_Tools::getValue('exclude'));
                }
                if (SQ_Classes_Helpers_Tools::getValue('start'))
                    $args['start'] = array((int)SQ_Classes_Helpers_Tools::getValue('start'));

                if (SQ_Classes_Helpers_Tools::getValue('nrb'))
                    $args['posts_per_page'] = (int)SQ_Classes_Helpers_Tools::getValue('nrb');

                if (SQ_Classes_Helpers_Tools::getValue('q') <> '')
                    $args['s'] = SQ_Classes_Helpers_Tools::getValue('q');

                $responce = array();
                if ($posts = SQ_Classes_ObjController::getClass('SQ_Models_Post')->searchPost($args)) {
                    foreach ($posts as $post) {
                        $responce['results'][] = array('id' => $post->ID,
                            'url' => get_permalink($post->ID),
                            'title' => $post->post_title,
                            'content' => SQ_Classes_Helpers_Sanitize::truncate($post->post_content, 50),
                            'date' => $post->post_date_gmt);
                    }
                }

                echo wp_json_encode($responce);
                exit();
        }
    }

    /**
     * Save the keywords from briefcase into the meta keywords if there are no keywords saved
     * @param SQ_Models_Domain_Sq $sq
     * @return SQ_Models_Domain_Sq
     */
    public function addSeoKeywords($sq) {
        if (empty($sq->keywords)) {
            $keywords = (array)SQ_Classes_Helpers_Tools::getValue('sq_briefcase_keyword', array());

            if (SQ_Classes_Helpers_Tools::getValue('sq_keyword', false)) {
                array_unshift($keywords, SQ_Classes_Helpers_Tools::getValue('sq_keyword'));
            }

            $keywords = array_filter($keywords);
            $keywords = array_unique($keywords);
            $sq->keywords = join(',', $keywords);
        }

        return $sq;
    }

    /**
     * Rewrite the function for pages and other post types
     *
     * @param string $url
     * @param string $sq_hash
     * @return string
     */
    public function checkOldSlugs($url, $sq_hash) {

        // Don't bother if it hasn't changed.
        $post = SQ_Classes_ObjController::getClass('SQ_Models_Qss')->getSqPost($sq_hash);
        $patterns = (array)SQ_Classes_Helpers_Tools::getOption('patterns');

        if (!isset($post->ID)) {
            return $url;
        }

        if (!empty($patterns) && $permalink = get_permalink($post->ID)) {
            if ($post->ID > 0 && get_post_status($post->ID) === 'publish' && $permalink <> $post->url) {

                //Get the Squirrly SEO Patterns
                foreach ($patterns as $pattern => $type) {
                    if (get_post_type($post->ID) == $pattern) {
                        if (isset($type['do_redirects']) && $type['do_redirects']) {

                            //do_redirects
                            $post_name = basename($post->url);
                            $old_slugs = (array)get_post_meta($post->ID, '_sq_old_slug');

                            // If we haven't added this old slug before, add it now.
                            if (!empty($post_name) && !in_array($post_name, $old_slugs)) {
                                add_post_meta($post->ID, '_sq_old_slug', $post_name);
                            }

                            // If the new slug was used previously, delete it from the list.
                            if (in_array($post->post_name, $old_slugs)) {
                                delete_post_meta($post->ID, '_sq_old_slug', $post->post_name);
                            }

                        }
                    }
                }

            }
        }

        return get_permalink($post->ID);
    }

    /**
     * Load Squirrly Assistant in frontend
     */
    public function loadLiveAssistant() {
        //Load the Frontend Assistant for the current post
        if (SQ_Classes_Helpers_Tools::getOption('sq_sla_frontend')) {

            $elementor = (SQ_Classes_Helpers_Tools::getValue('action', false) == 'elementor');

            if (($elementor && is_admin())) {
                global $post;

                if (isset($post->ID) && isset($post->post_type)) {
                    $types = get_post_types(array('public' => true));

                    //Exclude types for SLA
                    $excludes = SQ_Classes_Helpers_Tools::getOption('sq_sla_exclude_post_types');
                    if (!empty($types) && !empty($excludes)) {
                        foreach ($excludes as $exclude) {
                            if (in_array($exclude, $types)) {
                                unset($types[$exclude]);
                            }
                        }
                    }

                    if (in_array($post->post_type, (array)$types)) {
                        //Load the assistant for frontend
                        if (!wp_script_is('jquery')) {
                            wp_enqueue_script('jquery');
                        }

                        SQ_Classes_ObjController::getClass('SQ_Classes_RemoteController');
                        SQ_Classes_ObjController::getClass('SQ_Classes_ActionController')->hookHead();

                        //Load post style in post edit
                        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('post');
                        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('fontawesome');
                        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('slaseo');
                        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('slasearch');
                        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('slaresearch');

                        //load the draggable script in post edit for the floating SLA
                        wp_enqueue_script("jquery-ui-core");
                        wp_enqueue_script("jquery-ui-draggable");

                        echo $this->getView('Frontend/Assistant');
                    }

                }
            }

        }
    }

}
