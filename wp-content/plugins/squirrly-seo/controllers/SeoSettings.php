<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Controllers_SeoSettings extends SQ_Classes_FrontController {

    public $pages = array();

    function init() {
        $tab = SQ_Classes_Helpers_Tools::getValue('tab', 'automation');

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap-reboot');
        if (is_rtl()) {
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('popper');
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap.rtl');
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('rtl');
        } else {
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap');
        }
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap-select');

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('switchery');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('fontawesome');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('global');

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('assistant');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('navbar');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('seosettings');

        if (method_exists($this, $tab)) {
            call_user_func(array($this, $tab));
        }

        if (function_exists('wp_enqueue_media')) {
            wp_enqueue_media();
            wp_enqueue_style('media-views');
        }

        //@ob_flush();
        echo $this->getView('SeoSettings/' . ucfirst($tab));

        //get the modal window for the assistant popup
        echo SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->getModal();
    }

    public function gotoImport() {
        $_GET['tab'] = 'backup';
        return $this->init();
    }

    public function automation() {
        add_action('sq_form_notices', array($this, 'getNotificationBar'));

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('highlight');
        SQ_Classes_ObjController::getClass('SQ_Controllers_Patterns')->init();
    }

    public function metas() {
        add_action('sq_form_notices', array($this, 'getNotificationBar'));

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('highlight');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('snippet');
    }

    public function links() {
        add_action('sq_form_notices', array($this, 'getNotificationBar'));

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('highlight');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('snippet');
    }

    public function jsonld() {
        add_action('sq_form_notices', array($this, 'getNotificationBar'));
    }

    public function social() {
        add_action('sq_form_notices', array($this, 'getNotificationBar'));
    }

    public function tracking() {
        add_action('sq_form_notices', array($this, 'getNotificationBar'));
    }

    public function webmaster() {
        add_action('sq_form_notices', array($this, 'getNotificationBar'));
    }

    public function sitemap() {
        add_action('sq_form_notices', array($this, 'getNotificationBar'));
    }

    public function robots() {
        add_action('sq_form_notices', array($this, 'getNotificationBar'));
    }

    public function favicon() {
        add_action('sq_form_notices', array($this, 'getNotificationBar'));
    }

    public function backup() {
        add_filter('sq_themes', array(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport'), 'getAvailableThemes'), 10, 1);
        add_filter('sq_importList', array(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport'), 'importList'));
    }


    public function hookFooter() {
        if (!SQ_Classes_Helpers_Tools::getOption('sq_seoexpert')) {
            echo "<script>jQuery('.sq_advanced').hide();</script>";
        } else {
            echo "<script>jQuery('.sq_advanced').show();</script>";
        }
    }

    /**
     * Called when action is triggered
     *
     * @return void
     */
    public function action() {
        parent::action();

        switch (SQ_Classes_Helpers_Tools::getValue('action')) {

            case 'sq_seosettings_links':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //Save the settings
                if (!empty($_POST)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }

                //Save custom robots
                $links = SQ_Classes_Helpers_Tools::getValue('links_permission', '', true);
                $links = explode(PHP_EOL, $links);
                $links = str_replace("\r", "", $links);

                if (!empty($links)) {
                    SQ_Classes_Helpers_Tools::$options['sq_external_exception'] = array_unique($links);
                }

                //save the options in database
                SQ_Classes_Helpers_Tools::saveOptions();

                //show the saved message
                if (!SQ_Classes_Error::isError()) SQ_Classes_Error::setMessage(esc_html__("Saved", _SQ_PLUGIN_NAME_));

                break;

            ///////////////////////////////////////////SEO SETTINGS METAS
            case 'sq_seosettings_metas':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //Save the settings
                if (!empty($_POST)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }

                ///////////////////////////////////////////
                /////////////////////////////FIRST PAGE OPTIMIZATION
                $url = home_url();
                $post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setHomePage();

                $post->sq->doseo = 1;
                $post->sq->title = urldecode(SQ_Classes_Helpers_Tools::getValue('sq_fp_title', false));
                $post->sq->description = urldecode(SQ_Classes_Helpers_Tools::getValue('sq_fp_description', false));
                $post->sq->keywords = SQ_Classes_Helpers_Tools::getValue('sq_fp_keywords', false);

                if (SQ_Classes_Helpers_Tools::getIsset('sq_fp_ogimage')) {
                    $post->sq->og_media = SQ_Classes_Helpers_Tools::getValue('sq_fp_ogimage', '');
                }

                SQ_Classes_ObjController::getClass('SQ_Models_Qss')->saveSqSEO(
                    $url,
                    md5('wp_homepage'),
                    maybe_serialize(array(
                        'ID' => 0,
                        'post_type' => 'home',
                        'term_id' => 0,
                        'taxonomy' => '',
                    )),
                    maybe_serialize($post->sq->toArray()),
                    gmdate('Y-m-d H:i:s')
                );

                //reset the report time
                SQ_Classes_Helpers_Tools::saveOptions('seoreport_time', false);

                //show the saved message
                if (!SQ_Classes_Error::isError()) SQ_Classes_Error::setMessage(esc_html__("Saved", _SQ_PLUGIN_NAME_));

                break;

            ///////////////////////////////////////////SEO SETTINGS AUTOMATION
            case 'sq_seosettings_automation':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //Save the settings
                if (!empty($_POST)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }


                //show the saved message
                if (!SQ_Classes_Error::isError()) SQ_Classes_Error::setMessage(esc_html__("Saved", _SQ_PLUGIN_NAME_));

                break;
            ///////////////////////////////////////////SEO SETTINGS METAS
            case 'sq_seosettings_social':
            case 'sq_seosettings_tracking':
            case 'sq_seosettings_webmaster':
            case 'sq_seosettings_advanced':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //Save the settings
                if (!empty($_POST)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }

                //save the options in database
                SQ_Classes_Helpers_Tools::saveOptions();

                //reset the report time
                SQ_Classes_Helpers_Tools::saveOptions('seoreport_time', false);

                //show the saved message
                if (!SQ_Classes_Error::isError()) SQ_Classes_Error::setMessage(esc_html__("Saved", _SQ_PLUGIN_NAME_));


                break;

            ///////////////////////////////////////////SEO SETTINGS METAS
            case 'sq_seosettings_sitemap':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //Save the settings
                if (!empty($_POST)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }

                //Make sure we get the Sitemap data from the form
                if ($sitemap = SQ_Classes_Helpers_Tools::getValue('sitemap', false)) {
                    foreach (SQ_Classes_Helpers_Tools::$options['sq_sitemap'] as $key => $value) {
                        if (isset($sitemap[$key])) {
                            SQ_Classes_Helpers_Tools::$options['sq_sitemap'][$key][1] = (int)$sitemap[$key];
                        } elseif ($key <> 'sitemap') {
                            SQ_Classes_Helpers_Tools::$options['sq_sitemap'][$key][1] = 0;
                        }
                    }
                }

                //save the options in database
                SQ_Classes_Helpers_Tools::saveOptions();

                //delete other sitemap xml files from root
                if (SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap') && file_exists(ABSPATH . "/" . 'sitemap.xml')) {
                    @rename(ABSPATH . "/" . 'sitemap.xml', ABSPATH . "/" . 'sitemap_ren' . time() . '.xml');
                }

                //reset the report time
                SQ_Classes_Helpers_Tools::saveOptions('seoreport_time', false);

                //show the saved message
                if (!SQ_Classes_Error::isError()) SQ_Classes_Error::setMessage(esc_html__("Saved", _SQ_PLUGIN_NAME_));

                break;

            //Save the JSON-LD page from SEO Settings
            case 'sq_seosettings_jsonld':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //Save the settings
                if (!empty($_POST)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }

                if (SQ_Classes_Helpers_Tools::$options['sq_jsonld']['Person']['telephone'] <> '') {
                    SQ_Classes_Helpers_Tools::$options['sq_jsonld']['Person']['telephone'] = '+' . ltrim(SQ_Classes_Helpers_Tools::$options['sq_jsonld']['Person']['telephone'], '+');
                }
                if (SQ_Classes_Helpers_Tools::$options['sq_jsonld']['Organization']['contactPoint']['telephone'] <> '') {
                    SQ_Classes_Helpers_Tools::$options['sq_jsonld']['Organization']['contactPoint']['telephone'] = '+' . ltrim(SQ_Classes_Helpers_Tools::$options['sq_jsonld']['Organization']['contactPoint']['telephone'], '+');
                }

                //save the options in database
                SQ_Classes_Helpers_Tools::saveOptions();

                //reset the report time
                SQ_Classes_Helpers_Tools::saveOptions('seoreport_time', false);

                //show the saved message
                if (!SQ_Classes_Error::isError()) SQ_Classes_Error::setMessage(esc_html__("Saved", _SQ_PLUGIN_NAME_));

                break;

            //Save the Robots permissions
            case 'sq_seosettings_robots':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //Save the settings
                if (!empty($_POST)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }

                //Save custom robots
                $robots = SQ_Classes_Helpers_Tools::getValue('robots_permission', '', true);
                $robots = explode(PHP_EOL, $robots);
                $robots = str_replace("\r", "", $robots);

                if (!empty($robots)) {
                    SQ_Classes_Helpers_Tools::$options['sq_robots_permission'] = array_unique($robots);
                }

                //save the options in database
                SQ_Classes_Helpers_Tools::saveOptions();

                //reset the report time
                SQ_Classes_Helpers_Tools::saveOptions('seoreport_time', false);

                //show the saved message
                if (!SQ_Classes_Error::isError()) SQ_Classes_Error::setMessage(esc_html__("Saved", _SQ_PLUGIN_NAME_));


                break;

            //Save the Favicon image
            case 'sq_seosettings_favicon':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //If the favicon is turned off delete the favicon image created
                if (!SQ_Classes_Helpers_Tools::getValue('sq_auto_favicon') &&
                    SQ_Classes_Helpers_Tools::getOption('sq_auto_favicon') &&
                    SQ_Classes_Helpers_Tools::getOption('favicon') <> '' &&
                    file_exists(ABSPATH . "/" . 'favicon.ico')) {
                    @rename(ABSPATH . "/" . 'favicon.ico', ABSPATH . "/" . 'favicon_ren' . time() . '.ico');
                }

                //Save the settings
                if (!empty($_POST)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }

                /* if there is an icon to upload */
                if (!empty($_FILES['favicon'])) {
                    if ($return = SQ_Classes_ObjController::getClass('SQ_Models_Ico')->addFavicon($_FILES['favicon'])) {
                        if ($return['favicon'] <> '') {
                            SQ_Classes_Helpers_Tools::saveOptions('favicon', strtolower(basename($return['favicon'])));
                        }
                    }
                }


                break;
            case 'sq_seosettings_ga_revoke':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //remove connection with Google Analytics
                $response = SQ_Classes_RemoteController::revokeGaConnection();
                if (!is_wp_error($response)) {
                    SQ_Classes_Error::setError(esc_html__("Google Analytics account is disconnected.", _SQ_PLUGIN_NAME_) . " <br /> ", 'success');
                } else {
                    SQ_Classes_Error::setError(esc_html__("Error! Could not disconnect the account.", _SQ_PLUGIN_NAME_) . " <br /> ");
                }
                break;
            case 'sq_seosettings_gsc_revoke':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //remove connection with Google Search Console
                $response = SQ_Classes_RemoteController::revokeGscConnection();
                if (!is_wp_error($response)) {
                    SQ_Classes_Error::setError(esc_html__("Google Search Console account is disconnected.", _SQ_PLUGIN_NAME_) . " <br /> ", 'success');
                } else {
                    SQ_Classes_Error::setError(esc_html__("Error! Could not disconnect the account.", _SQ_PLUGIN_NAME_) . " <br /> ");
                }
                break;
            case 'sq_seosettings_ga_check':
            case 'sq_seosettings_gsc_check':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }
                //Refresh the checkin on login
                delete_transient('sq_checkin');

                break;

            case 'sq_seosettings_backupsettings':
                if (!current_user_can('sq_manage_settings')) {
                    $response['error'] = SQ_Classes_Error::showNotices(esc_html__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo wp_json_encode($response);
                    exit();
                }

                SQ_Classes_Helpers_Tools::setHeader('text');
                header("Content-Disposition: attachment; filename=squirrly-settings-" . gmdate('Y-m-d') . ".txt");

                if (function_exists('base64_encode')) {
                    echo base64_encode(wp_json_encode(SQ_Classes_Helpers_Tools::$options));
                } else {
                    echo wp_json_encode(SQ_Classes_Helpers_Tools::$options);
                }
                exit();
            case 'sq_seosettings_restoresettings':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                if (!empty($_FILES['sq_options']) && $_FILES['sq_options']['tmp_name'] <> '') {
                    $fp = fopen($_FILES['sq_options']['tmp_name'], 'rb');
                    $options = '';
                    while (($line = fgets($fp)) !== false) {
                        $options .= $line;
                    }
                    try {
                        if (function_exists('base64_encode') && base64_decode($options) <> '') {
                            $options = @base64_decode($options);
                        }
                        $options = json_decode($options, true);
                        if (is_array($options) && isset($options['sq_api'])) {
                            if (SQ_Classes_Helpers_Tools::getOption('sq_api') <> '') {
                                $options['sq_api'] = SQ_Classes_Helpers_Tools::getOption('sq_api');
                            }
                            if (SQ_Classes_Helpers_Tools::getOption('sq_seojourney') <> '') {
                                $options['sq_seojourney'] = SQ_Classes_Helpers_Tools::getOption('sq_seojourney');
                            }
                            SQ_Classes_Helpers_Tools::$options = $options;
                            SQ_Classes_Helpers_Tools::saveOptions();

                            //Check if there is an old backup from Squirrly
                            SQ_Classes_Helpers_Tools::getOptions();

                            //reset the report time
                            SQ_Classes_Helpers_Tools::saveOptions('seoreport_time', false);

                            SQ_Classes_Error::setError(esc_html__("Great! The backup is restored.", _SQ_PLUGIN_NAME_) . " <br /> ", 'success');
                        } else {
                            SQ_Classes_Error::setError(esc_html__("Error! The backup is not valid.", _SQ_PLUGIN_NAME_) . " <br /> ");
                        }
                    } catch (Exception $e) {
                        SQ_Classes_Error::setError(esc_html__("Error! The backup is not valid.", _SQ_PLUGIN_NAME_) . " <br /> ");
                    }
                } else {
                    SQ_Classes_Error::setError(esc_html__("Error! You have to enter a previously saved backup file.", _SQ_PLUGIN_NAME_) . " <br /> ");
                }
                break;
            case 'sq_seosettings_backupseo':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                header('Content-Type: application/octet-stream');
                header("Content-Transfer-Encoding: Binary");
                header("Content-Disposition: attachment; filename=squirrly-seo-" . gmdate('Y-m-d') . ".sql");

                if (function_exists('base64_encode')) {
                    echo base64_encode(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->createTableBackup());
                } else {
                    echo SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->createTableBackup();
                }
                exit();
            case 'sq_seosettings_restoreseo':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                if (!empty($_FILES['sq_sql']) && $_FILES['sq_sql']['tmp_name'] <> '') {
                    $fp = fopen($_FILES['sq_sql']['tmp_name'], 'rb');
                    $sql_file = '';
                    while (($line = fgets($fp)) !== false) {
                        $sql_file .= $line;
                    }

                    if (function_exists('base64_encode')) {
                        $sql_file = @base64_decode($sql_file);
                    }

                    if ($sql_file <> '' && strpos($sql_file, 'INSERT INTO') !== false) {
                        try {

                            $queries = explode("INSERT INTO", $sql_file);
                            SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->executeSql($queries);
                            SQ_Classes_Error::setError(esc_html__("Great! The SEO backup is restored.", _SQ_PLUGIN_NAME_) . " <br /> ", 'success');

                        } catch (Exception $e) {
                            SQ_Classes_Error::setError(esc_html__("Error! The backup is not valid.", _SQ_PLUGIN_NAME_) . " <br /> ");
                        }
                    } else {
                        SQ_Classes_Error::setError(esc_html__("Error! The backup is not valid.", _SQ_PLUGIN_NAME_) . " <br /> ");
                    }
                } else {
                    SQ_Classes_Error::setError(esc_html__("Error! You have to enter a previously saved backup file.", _SQ_PLUGIN_NAME_) . " <br /> ");
                }
                break;
            case 'sq_seosettings_importall':
                $platform = SQ_Classes_Helpers_Tools::getValue('sq_import_platform', '');
                if ($platform <> '') {
                    try {
                        SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->importDBSettings($platform);
                        $seo = SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->importDBSeo($platform);
                        if (!empty($seo)) {
                            //Check if the Squirrly Table Exists
                            SQ_Classes_ObjController::getClass('SQ_Models_Qss')->checkTableExists();

                            foreach ($seo as $sq_hash => $metas) {
                                SQ_Classes_ObjController::getClass('SQ_Models_Qss')->saveSqSEO(
                                    (isset($metas['url']) ? $metas['url'] : ''),
                                    $sq_hash,
                                    maybe_serialize(array(
                                        'ID' => (isset($metas['post_id']) ? (int)$metas['post_id'] : 0),
                                        'post_type' => (isset($metas['post_type']) ? $metas['post_type'] : ''),
                                        'term_id' => (isset($metas['term_id']) ? (int)$metas['term_id'] : 0),
                                        'taxonomy' => (isset($metas['taxonomy']) ? $metas['taxonomy'] : ''),
                                    )),
                                    maybe_serialize($metas),
                                    gmdate('Y-m-d H:i:s'));
                            }
                        }

                        SQ_Classes_Error::setMessage(sprintf(esc_html__("Success! The import from %s was completed successfully and your SEO is safe!", _SQ_PLUGIN_NAME_), SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->getName($platform)));
                    } catch (Exception $e) {
                        SQ_Classes_Error::setMessage(esc_html__("Error! An error occured while import. Please try again.", _SQ_PLUGIN_NAME_));
                    }
                }
                break;
            case 'sq_seosettings_importsettings':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                $platform = SQ_Classes_Helpers_Tools::getValue('sq_import_platform', '');
                if ($platform <> '') {
                    if (SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->importDBSettings($platform)) {
                        SQ_Classes_Error::setMessage(esc_html__("All the Plugin settings were imported successfuly!", _SQ_PLUGIN_NAME_));
                    } else {
                        SQ_Classes_Error::setMessage(esc_html__("No settings found for this plugin/theme.", _SQ_PLUGIN_NAME_));
                    }
                }
                break;
            case 'sq_seosettings_importseo':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                $platform = SQ_Classes_Helpers_Tools::getValue('sq_import_platform', '');
                $overwrite = SQ_Classes_Helpers_Tools::getValue('sq_import_overwrite', false);

                if ($platform <> '') {
                    $seo = SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->importDBSeo($platform);
                    if (!empty($seo)) {
                        foreach ($seo as $sq_hash => $metas) {
                            $sq = SQ_Classes_ObjController::getClass('SQ_Models_Qss')->getSqSeo($sq_hash);
                            if ($overwrite || !($sq->title && $sq->description)) {

                                SQ_Classes_ObjController::getClass('SQ_Models_Qss')->saveSqSEO(
                                    (isset($metas['url']) ? $metas['url'] : ''),
                                    $sq_hash,
                                    maybe_serialize(array(
                                        'ID' => (isset($metas['post_id']) ? (int)$metas['post_id'] : 0),
                                        'post_type' => (isset($metas['post_type']) ? $metas['post_type'] : ''),
                                        'term_id' => (isset($metas['term_id']) ? (int)$metas['term_id'] : 0),
                                        'taxonomy' => (isset($metas['taxonomy']) ? $metas['taxonomy'] : ''),
                                    )),
                                    maybe_serialize($metas),
                                    gmdate('Y-m-d H:i:s'));

                            }
                        }
                    }

                    SQ_Classes_Error::setMessage(sprintf(esc_html__("Success! The import from %s was completed successfully and your SEO is safe!", _SQ_PLUGIN_NAME_), SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->getName($platform)));
                }
                break;
            case 'sq_rollback':
                SQ_Classes_Helpers_Tools::setHeader('html');
                $plugin_slug = basename(_SQ_PLUGIN_NAME_, '.php');


                $rollback = SQ_Classes_ObjController::getClass('SQ_Models_Rollback');

                $rollback->set_plugin(array(
                    'version' => SQ_STABLE_VERSION,
                    'plugin_name' => _SQ_ROOT_DIR_,
                    'plugin_slug' => $plugin_slug,
                    'package_url' => sprintf('https://downloads.wordpress.org/plugin/%s.%s.zip', $plugin_slug, SQ_STABLE_VERSION),
                ));

                $rollback->run();

                wp_die(
                    '', esc_html__("Rollback to Previous Version", _SQ_PLUGIN_NAME_), [
                        'response' => 200,
                    ]
                );
                exit();
            case 'sq_reinstall':
                SQ_Classes_Helpers_Tools::setHeader('html');
                $plugin_slug = basename(_SQ_PLUGIN_NAME_, '.php');


                $rollback = SQ_Classes_ObjController::getClass('SQ_Models_Rollback');

                $rollback->set_plugin(array(
                    'version' => SQ_VERSION,
                    'plugin_name' => _SQ_ROOT_DIR_,
                    'plugin_slug' => $plugin_slug,
                    'package_url' => sprintf('https://downloads.wordpress.org/plugin/%s.%s.zip', $plugin_slug, SQ_VERSION),
                ));

                $rollback->run();

                wp_die(
                    '', esc_html__("Reinstall Current Version", _SQ_PLUGIN_NAME_), [
                        'response' => 200,
                    ]
                );
                exit();
            case 'sq_alerts_close':
                //remove the specified alert from showing again
                if ($alert = SQ_Classes_Helpers_Tools::getValue('alert', false)) {
                    if (in_array($alert, array('sq_alert_overview', 'sq_alert_journey'))) {
                        SQ_Classes_Helpers_Tools::saveOptions($alert, false);
                    }
                }
                break;
            /**************************** Ajax *******************************************************/
            case 'sq_ajax_seosettings_save':
                SQ_Classes_Helpers_Tools::setHeader('json');
                $response = array();
                if (!current_user_can('sq_manage_settings')) {
                    $response['error'] = SQ_Classes_Error::showNotices(esc_html__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    echo wp_json_encode($response);
                    exit();
                }


                $name = SQ_Classes_Helpers_Tools::getValue('input', false);
                $value = SQ_Classes_Helpers_Tools::getValue('value', false);

                if (isset(SQ_Classes_Helpers_Tools::$options[$name])) {
                    SQ_Classes_Helpers_Tools::saveOptions($name, $value);
                    $response['data'] = SQ_Classes_Error::showNotices(esc_html__("Saved", _SQ_PLUGIN_NAME_), 'sq_success');
                } else {
                    $response['data'] = SQ_Classes_Error::showNotices(esc_html__("Could not save the changes", _SQ_PLUGIN_NAME_), 'sq_error');

                }

                echo wp_json_encode($response);
                exit();
            case 'sq_ajax_sla_sticky':
                SQ_Classes_Helpers_Tools::setHeader('json');

                $response = array();
                if (!current_user_can('sq_manage_snippet')) {
                    $response['error'] = SQ_Classes_Error::showNotices(esc_html__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    echo wp_json_encode($response);
                    exit();
                }

                SQ_Classes_Helpers_Tools::saveUserMeta('sq_auto_sticky', (int)SQ_Classes_Helpers_Tools::getValue('sq_auto_sticky'));
                echo wp_json_encode(array());
                exit();
            case 'sq_ajax_gsc_code':
                SQ_Classes_Helpers_Tools::setHeader('json');

                $response = array();
                if (!current_user_can('sq_manage_snippet')) {
                    $response['error'] = SQ_Classes_Error::showNotices(esc_html__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    echo wp_json_encode($response);
                    exit();
                }

                //remove connection with Google Analytics
                $code = SQ_Classes_RemoteController::getGSCToken();

                if (!is_wp_error($code) && $code) {
                    $response['code'] = SQ_Classes_Helpers_Sanitize::checkGoogleWTCode($code);
                } else {
                    $response['error'] = SQ_Classes_Error::showNotices(esc_html__("Error! Could not get the code. Connect to Google Search Console and validate the connection.", _SQ_PLUGIN_NAME_), 'sq_error');
                }

                echo wp_json_encode($response);
                exit();
            case 'sq_ajax_ga_code':
                SQ_Classes_Helpers_Tools::setHeader('json');

                $response = array();
                if (!current_user_can('sq_manage_snippet')) {
                    $response['error'] = SQ_Classes_Error::showNotices(esc_html__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    echo wp_json_encode($response);
                    exit();
                }

                //remove connection with Google Analytics
                $code = SQ_Classes_RemoteController::getGAToken();
                if (!is_wp_error($code) && $code) {
                    $response['code'] = $code;
                } else {
                    $response['error'] = SQ_Classes_Error::showNotices(esc_html__("Error! Could not get the tracking code. Connect to Google Analytics and get the website tracking code from Admin area.", _SQ_PLUGIN_NAME_), 'sq_error');
                }
                echo wp_json_encode($response);
                exit();
            case 'sq_ajax_connection_check':
                SQ_Classes_Helpers_Tools::setHeader('json');

                $response = array();
                if (!current_user_can('sq_manage_snippet')) {
                    $response['error'] = SQ_Classes_Error::showNotices(esc_html__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    echo wp_json_encode($response);
                    exit();
                }

                //delete local checking cache
                delete_transient('sq_checkin');
                //check the connection again
                SQ_Classes_RemoteController::checkin();

                echo wp_json_encode(array());
                exit();

            /************************ Automation ********************************************************/
            case 'sq_ajax_automation_addpostype':
                SQ_Classes_Helpers_Tools::setHeader('json');
                $response = array();
                if (!current_user_can('sq_manage_settings')) {
                    $response['error'] = SQ_Classes_Error::showNotices(esc_html__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    echo wp_json_encode($response);
                    exit();
                }

                //Get the new post type
                $posttype = SQ_Classes_Helpers_Tools::getValue('value', false);
                $filter = array('public' => true, '_builtin' => false);
                $types = get_post_types($filter);

                $filter = array('public' => true,);
                $taxonomies = get_taxonomies($filter);
                foreach ($taxonomies as $pattern => $type) {
                    $types['tax-' . $pattern] = 'tax-' . $pattern;
                }

                //If the post type is in the list of types
                if ($posttype && in_array($posttype, $types)) {
                    $patterns = SQ_Classes_Helpers_Tools::getOption('patterns');
                    //if the post type does not already exists
                    if (!isset($patterns[$posttype])) {
                        //add the custom rights to the new post type
                        $patterns[$posttype] = $patterns['custom'];
                        $patterns[$posttype]['protected'] = 0;
                        //save the options in database
                        SQ_Classes_Helpers_Tools::saveOptions('patterns', $patterns);

                        $response['data'] = SQ_Classes_Error::showNotices(esc_html__("Saved", _SQ_PLUGIN_NAME_), 'sq_success');
                        echo wp_json_encode($response);
                        exit();
                    }
                }


                //Return error in case the post is not saved
                $response['data'] = SQ_Classes_Error::showNotices(esc_html__("Could not add the post type.", _SQ_PLUGIN_NAME_), 'sq_error');
                echo wp_json_encode($response);
                exit();
            case 'sq_ajax_automation_deletepostype':
                SQ_Classes_Helpers_Tools::setHeader('json');
                $response = array();
                if (!current_user_can('sq_manage_settings')) {
                    $response['error'] = SQ_Classes_Error::showNotices(esc_html__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    echo wp_json_encode($response);
                    exit();
                }


                //Get the new post type
                $posttype = SQ_Classes_Helpers_Tools::getValue('value', false);

                //If the post type is in the list of types
                if ($posttype && $posttype <> '') {
                    $patterns = SQ_Classes_Helpers_Tools::getOption('patterns');
                    //if the post type exists in the patterns
                    if (isset($patterns[$posttype])) {
                        //add the custom rights to the new post type
                        unset($patterns[$posttype]);

                        //save the options in database
                        SQ_Classes_Helpers_Tools::saveOptions('patterns', $patterns);

                        $response['data'] = SQ_Classes_Error::showNotices(esc_html__("Saved", _SQ_PLUGIN_NAME_), 'sq_success');
                        echo wp_json_encode($response);
                        exit();
                    }
                }


                //Return error in case the post is not saved
                $response['data'] = SQ_Classes_Error::showNotices(esc_html__("Could not add the post type.", _SQ_PLUGIN_NAME_), 'sq_error');
                echo wp_json_encode($response);
                exit();

        }

    }

}
