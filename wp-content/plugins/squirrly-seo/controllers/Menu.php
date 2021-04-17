<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Controllers_Menu extends SQ_Classes_FrontController {

    /** @var array snippet */
    public $post_type;
    /** @var array snippet */
    var $options = array();

    public function __construct() {
        parent::__construct();

        global $sq_fullscreen, $sq_setting_page;

        //Only on subsites
        if (!is_network_admin()) {
            $sq_fullscreen = $sq_setting_page = false;

            add_action('admin_bar_menu', array($this, 'hookTopmenuDashboard'), 10);
            add_action('admin_bar_menu', array($this, 'hookTopmenuSquirrly'), 91);

            add_action('do_meta_boxes', array($this, 'addMetabox'));
            add_filter('sq_cloudmenu', array($this, 'getCloudMenu'), 10, 2);

            //run compatibility check on Squirrly settings
            if (SQ_Classes_Helpers_Tools::getIsset('page')) {

                //Get all the Squirrly SEO menus
                $menus = $this->model->getMainMenu();
                //Get current accessed page
                $page = apply_filters('sq_page', SQ_Classes_Helpers_Tools::getValue('page'));

                if (in_array($page, array_keys($menus))) {
                    //Set if it's a Squirrly SEO Page
                    $sq_setting_page = true;

                    //Check if the menu requires full screen window
                    if (isset($menus[$page]['fullscreen']) && $menus[$page]['fullscreen']) {
                        $sq_fullscreen = true;
                    }

                    add_action('admin_enqueue_scripts', array(SQ_Classes_ObjController::getClass('SQ_Models_Compatibility'), 'fixEnqueueErrors'), PHP_INT_MAX);
                    add_action('admin_head', array($this, 'setViewport'), PHP_INT_MAX);
                }
            }

            //Hook the Frontend Editors
            $this->hookBuilders();
        }

        add_action('current_screen', function () {
            if (in_array(get_current_screen()->id, array('plugins', 'plugins-network'))) {
                SQ_Classes_ObjController::getClass('SQ_Controllers_Uninstall');
            }
        });
    }

    /**
     * Hook the Admin load
     */
    public function hookInit() {

        /* add the plugin menu in admin */
        if (current_user_can('manage_options')) {
            try {
                //check if activated
                if (get_transient('sq_activate') == 1) {
                    // Delete the redirect transient
                    delete_transient('sq_activate');

                    //Create Qss table if not exists
                    SQ_Classes_ObjController::getClass('SQ_Models_Qss')->checkTableExists();

                    //This option is use for custom Package installs
                    //update text in case of devkit
                    SQ_Classes_ObjController::getClass('SQ_Classes_Helpers_DevKit')->updatePluginData();

                    if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '') {
                        wp_redirect(SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard'));
                        die();
                    }
                }

            } catch (Exception $e) {
                SQ_Classes_Error::setMessage(sprintf(esc_html__("An error occurred during activation. If this error persists, please contact us at: %s", _SQ_PLUGIN_NAME_), _SQ_SUPPORT_URL_));
            }

        }

        //Add Squirrly SEO in  Posts list
        SQ_Classes_ObjController::getClass('SQ_Controllers_PostsList')->init();

        //Hook the post save action
        SQ_Classes_ObjController::getClass('SQ_Controllers_Post')->hookPost();

        //Show Squirrly SEO in Dashboard if connected to Squirrly Cloud
        if (SQ_Classes_Helpers_Tools::getOption('sq_api') <> '') {
            add_action('wp_dashboard_setup', array($this, 'hookDashboardSetup'));
        }

        //Add the Squirrly Class in all Squirrly SEO Pages
        add_filter('admin_body_class', array($this, 'addSquirrlySettingsClass'));

    }

    /**
     * Show the Dashboard link when Full Screen
     * @param \WP_Admin_Bar $wp_admin_bar
     * @return mixed
     */
    public function hookTopmenuDashboard($wp_admin_bar) {
        global $sq_fullscreen;

        if (is_user_logged_in()) {
            if (isset($sq_fullscreen) && $sq_fullscreen) {
                $wp_admin_bar->add_node(array(
                    'parent' => 'site-name',
                    'id' => 'dashboard',
                    'title' => esc_html__("Dashboard"),
                    'href' => admin_url(),
                ));
            }
        }

        return $wp_admin_bar;
    }

    /**
     * Show the Squirrly Menu in toolbar
     * @param \WP_Admin_Bar $wp_admin_bar
     *
     * @return \WP_Admin_Bar
     */
    public function hookTopmenuSquirrly($wp_admin_bar) {
        global $tag;

        if (is_admin()) {

            if (current_user_can('edit_posts')) {
                //Get count local SEO errors
                $errors = apply_filters('sq_seo_errors', 0);

                $wp_admin_bar->add_node(array(
                    'id' => 'sq_toolbar',
                    'title' => '<span class="sq_logo" style="margin-right: 2px"></span>' . esc_html__("Squirrly SEO", _SQ_PLUGIN_NAME_) . (($errors) ? '<span class="sq_errorcount">' . $errors . '</span>' : ''),
                    'href' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard'),
                    'parent' => false
                ));

                $mainmenu = $this->model->getMainMenu();
                if (!empty($mainmenu)) {
                    foreach ($mainmenu as $menuid => $item) {

                        //Check if the menu item is visible on the top
                        if (isset($item['topmenu']) && !$item['topmenu']) {
                            continue;
                        }

                        if ($menuid == 'sq_dashboard' && $errors) {
                            if (is_rtl()) {
                                $item['title'] = '<span class="sq_errorcount" style="margin: 6px 0 0 0 !important; float: left !important;">' . $errors . '</span>' . $item['title'];
                            } else {
                                $item['title'] = $item['title'] . '<span class="sq_errorcount" style="margin: 6px 35px 0 0 !important;">' . $errors . '</span>';
                            }
                        }

                        //make sure the user has the capabilities
                        if (current_user_can($item['capability'])) {
                            $wp_admin_bar->add_node(array(
                                'id' => $menuid,
                                'title' => $item['title'],
                                'href' => SQ_Classes_Helpers_Tools::getAdminUrl($menuid),
                                'parent' => 'sq_toolbar'
                            ));
                            $tabs = $this->model->getTabs($menuid);
                            if (!empty($tabs)) {
                                foreach ($tabs as $id => $tab) {
                                    $array_id = explode('/', $id);
                                    if (count((array)$array_id) == 2) {
                                        $wp_admin_bar->add_node(array(
                                            'id' => $menuid . str_replace('/', '_', $id),
                                            'title' => $tab['title'],
                                            'href' => SQ_Classes_Helpers_Tools::getAdminUrl($array_id[0], $array_id[1]),
                                            'parent' => $menuid
                                        ));
                                    }
                                }
                            }
                        }
                    }
                }

            }

            $current_screen = get_current_screen();
            $post = get_post();
            if ('post' == $current_screen->base
                && ($post_type_object = get_post_type_object($post->post_type))
                && (current_user_can('edit_post', $post->ID) || current_user_can('sq_manage_snippets'))
                && ($post_type_object->public)) {
            } elseif ('edit' == $current_screen->base
                && ($post_type_object = get_post_type_object($current_screen->post_type))
                && ($post_type_object->show_in_admin_bar)
                && !('edit-' . $current_screen->post_type === $current_screen->id)) {
            } elseif ('term' == $current_screen->base
                && isset($tag) && is_object($tag) && !is_wp_error($tag)
                && ($tax = get_taxonomy($tag->taxonomy))
                && $tax->public) {
            } else {
                return $wp_admin_bar;
            }

            $this->model->addMeta(array('sq_blocksnippet',
                '<i class="sq_logo" style="margin-right: 5px"></i>' . ucfirst(_SQ_NAME_) . ' ' . esc_html__("SEO Snippet", _SQ_PLUGIN_NAME_),
                array(SQ_Classes_ObjController::getClass('SQ_Controllers_Snippet'), 'init'),
                null,
                'normal',
                'high'
            ));

            //Dev Kit images
            $style = '';
            if (SQ_Classes_Helpers_Tools::getOption('sq_devkit_logo')) {
                $style = '<style>.sq_logo{background-image:url("' . SQ_Classes_Helpers_Tools::getOption('sq_devkit_logo') . '") !important;background-size: 100%;}</style>';
            }

            $wp_admin_bar->add_node(array(
                'id' => 'sq_bar_menu',
                'title' => $style . '<span class="sq_logo"></span> ' . esc_html__("Custom SEO", _SQ_PLUGIN_NAME_),
                'parent' => 'top-secondary',
            ));


            //Add snippet body
            $wp_admin_bar->add_menu(array(
                'id' => 'sq_bar_submenu',
                'parent' => 'sq_bar_menu',
                'meta' => array(
                    'html' => SQ_Classes_ObjController::getClass('SQ_Controllers_Snippet')->init(),
                    'tabindex' => PHP_INT_MAX,
                ),
            ));
        }

        return $wp_admin_bar;
    }

    public function hookDashboardSetup() {
        wp_add_dashboard_widget(
            'sq_dashboard_widget',
            esc_html__("Squirrly SEO", _SQ_PLUGIN_NAME_),
            array(SQ_Classes_ObjController::getClass('SQ_Controllers_Dashboard'), 'dashboard')
        );

        // Move our widget to top.
        global $wp_meta_boxes;

        $dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
        $ours = array('sq_dashboard_widget' => $dashboard['sq_dashboard_widget']);
        $wp_meta_boxes['dashboard']['normal']['core'] = array_merge($ours, $dashboard);
    }

    /**
     * Creates the Setting menu in Wordpress
     */
    public function hookMenu() {
        //Hook the SEO Errors from Squirrly SEO Check
        add_action('sq_seo_errors', array($this, 'getSEOErrors'));

        //Check the Dev Kit settings
        SQ_Classes_ObjController::getClass('SQ_Classes_Helpers_DevKit');

        //Get all the post types
        $this->post_type = SQ_Classes_Helpers_Tools::getOption('sq_post_types');

        //Get count local SEO errors
        $errors = apply_filters('sq_seo_errors', 0);

        ///////////////
        $this->model->addMenu(array(apply_filters('sq_menu_name', _SQ_MENU_NAME_),
            apply_filters('sq_menu_name', _SQ_MENU_NAME_) . (($errors) ? '<span class="sq_errorcount">' . $errors . '</span>' : ''),
            'edit_posts',
            'sq_dashboard',
            null,
            apply_filters('sq_logo', _SQ_ASSETS_URL_ . 'img/logos/menu_icon_16.png')
        ));

        //Load the Squirrly Menu
        $mainmenu = $this->model->getMainMenu();
        if (!empty($mainmenu)) {
            foreach ($mainmenu as $name => $item) {

                //Check if the menu is set to show in the left side
                if (isset($item['leftmenu'])) {
                    if (is_bool($item['leftmenu'])) {
                        if (!$item['leftmenu'] && SQ_Classes_Helpers_Tools::getValue('page', '') <> $name) {
                            continue;
                        }
                    } else {
                        $item['title'] = $item['leftmenu'];
                    }
                }

                //Add the page
                $this->model->addSubmenu(array($item['parent'],
                    $item['description'],
                    $item['title'],
                    $item['capability'],
                    $name,
                    $item['function'],
                ));

            }

            //Update the external links in the menu
            global $submenu;
            if(!empty($submenu['sq_dashboard'])) {
                foreach ($submenu['sq_dashboard'] as &$item) {
                    if (isset($mainmenu[$item[2]]['href']) && $mainmenu[$item[2]]['href']) {
                        if (parse_url($mainmenu[$item[2]]['href'], PHP_URL_HOST) !== parse_url(home_url(), PHP_URL_HOST)) {
                            $item[0] .= '<i class="dashicons dashicons-external" style="font-size:12px;vertical-align:-2px;height:10px;"></i>';
                        }
                        $item[2] = $mainmenu[$item[2]]['href'];
                    }
                }
            }
        }
    }

    /**
     * Add Post Editor Meta Box
     * Load Squirrly Live Assistant
     */
    public function addMetabox() {
        $types = get_post_types(array('public' => true));

        //Exclude types for SLA
        $excludes = SQ_Classes_Helpers_Tools::getOption('sq_sla_exclude_post_types');
        if (!empty($types) && !empty($excludes)) {
            foreach ($excludes as $exclude) {
                if ($exclude) {
                    if (in_array($exclude, $types)) {
                        unset($types[$exclude]);
                    }
                }
            }
        }

        //Add Live Assistant For Selected Post Types
        if (!empty($types)) {
            foreach ($types as $type) {
                if (is_string($type) && $type <> '' && $metabox = unserialize(SQ_Classes_Helpers_Tools::getUserMeta('meta-box-order_' . $type))) {
                    extract($metabox);

                    if (isset($side) && isset($normal)) {
                        $side = explode(',', $side);
                        $normal = explode(',', $normal);
                        if (in_array('post' . _SQ_NAME_, $normal)) {
                            $side = array_merge(array('post' . _SQ_NAME_), $side);
                            $metabox['side'] = join(',', array_unique($side));

                            $normal = array_diff($normal, array('post' . _SQ_NAME_));
                            $metabox['normal'] = join(',', array_unique($normal));
                            SQ_Classes_Helpers_Tools::saveUserMeta('meta-box-order_' . $type, $metabox);
                        }

                        if (in_array('sq_blocksnippet', $side)) {
                            $normal = array_merge(array('sq_blocksnippet'), $normal);
                            $metabox['normal'] = join(',', array_unique($normal));

                            $side = array_diff($side, array('sq_blocksnippet'));
                            $metabox['side'] = join(',', array_unique($side));
                            SQ_Classes_Helpers_Tools::saveUserMeta('meta-box-order_' . $type, $metabox);
                        }
                    }
                }

                //Load the SLA in Post
                $this->model->addMeta(array('post' . _SQ_NAME_,
                    ucfirst(_SQ_NAME_),
                    array(SQ_Classes_ObjController::getClass('SQ_Controllers_Post'), 'init'),
                    $type,
                    'side',
                    'high'
                ));
            }

        }
    }

    /**
     * Add the Squirrly Setttings Class in all Squirrly SEO Pages
     * Used for personal layout
     *
     * @param $classes
     * @return string
     */
    public function addSquirrlySettingsClass($classes) {
        global $sq_setting_page;

        if (isset($sq_setting_page) && $sq_setting_page) {
            $classes = "$classes squirrly-seo-settings";
        }

        return $classes;
    }

    /**
     * Hook the Head
     */
    public function hookHead() {
        global $sq_fullscreen, $sq_setting_page;

        //Load settings only in the Squirrly Menu
        if (isset($sq_setting_page) && $sq_setting_page) {
            echo '<script type="text/javascript" src="//www.google.com/jsapi"></script>';
            echo '<script>google.load("visualization", "1.0", {packages: ["corechart"]});</script>';
            if (isset($sq_fullscreen) && $sq_fullscreen) {
                SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('fullwidth', array('trigger' => true, 'media' => 'all'));
            }
        }

        //Load the Squirrly Logo on all Dashboard
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('logo');

    }

    /**
     * Set the viewport for a google Squirrly Settings layout
     */
    function setViewport() {
        $page = apply_filters('sq_page', SQ_Classes_Helpers_Tools::getValue('page', ''));
        if ($page == 'sq_dashboard') {
            echo '<meta name="viewport" content="width=900">';
        } else {
            echo '<meta name="viewport" content="width=1200">';
        }
    }

    /**
     * Hook the Elementor Builder
     */
    public function hookBuilders() {
        add_action('elementor/editor/footer', array(SQ_Classes_ObjController::getClass('SQ_Controllers_Post'), 'loadLiveAssistant'), 99);
    }

    /**
     * Count the SEO Errors from SEO Goals
     * @return mixed
     */
    public function getSEOErrors() {
        return SQ_Classes_ObjController::getClass('SQ_Controllers_CheckSeo')->setCategory('sq_dashboard')->getErrorsCount();
    }


    /**
     * Set the cloud.squirrly.co menu based on the client rights
     * @param $url
     * @param $path
     * @return string
     */
    public function getCloudMenu($url, $path) {
        if (function_exists('wp_get_current_user') && SQ_Classes_Helpers_Tools::getOption('sq_api')) {
            if (SQ_Classes_Helpers_Tools::getMenuVisible('show_panel') && current_user_can('sq_manage_settings')) {
                $url .= 'login/?token=' . SQ_Classes_Helpers_Tools::getOption('sq_api') . '&user_url=' . apply_filters('sq_homeurl', get_bloginfo('url')) . '&redirect_to=' . _SQ_DASH_URL_ . 'user/' . $path;
            }
        }

        return $url;
    }
}
