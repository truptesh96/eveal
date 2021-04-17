<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Classes_Helpers_DevKit {

    public static $plugin;
    public static $package;

    public function __construct() {
        if (SQ_Classes_Helpers_Tools::getOption('sq_devkit_name') <> '') {
            if (isset($_SERVER['REQUEST_URI']) && function_exists('get_plugin_data')) {
                if (strpos($_SERVER['REQUEST_URI'], '/plugins.php') !== false) {
                    $data = get_plugin_data(_SQ_ROOT_DIR_ . 'squirrly.php');
                    if (isset($data['Name'])) {
                        self::$plugin['name'] = $data['Name'];
                        add_filter('pre_kses', array($this, 'changeString'), 1, 1);
                    }
                }
            }
        }

        //Hook DevKit options
        add_filter('admin_head', array($this, 'hookHead'));
        add_filter('sq_menu', array($this, 'manageMenu'));
        add_filter('sq_features', array($this, 'manageFeatures'));
        add_filter('sq_logo', array($this, 'getCustomLogo'));
        add_filter('sq_name', array($this, 'getCustomName'));
        add_filter('sq_menu_name', array($this, 'getCustomMenuName'));
        add_filter('sq_audit_success_task', array($this, 'getCustomAuditSuccessTask'));
        add_filter('sq_audit_fail_task', array($this, 'getCustomAuditFailTask'));

    }

    /**
     * Customize the Audit task
     * @param $task
     * @return mixed
     */
    public function getCustomAuditSuccessTask($task){

        if(SQ_Classes_Helpers_Tools::getOption('sq_devkit_audit_success')) {
            if ($customTask = SQ_Classes_Helpers_Tools::getOption('sq_devkit_audit_success')) {
                foreach ($customTask as $key => $value) {
                    if ($value <> ''|| $value === false) {
                        $task->$key = stripslashes($value);
                    }
                }
            }
        }

        return $task;
    }

    /**
     * Customize the Audit task
     * @param $task
     * @return mixed
     */
    public function getCustomAuditFailTask($task){

        if(SQ_Classes_Helpers_Tools::getOption('sq_devkit_audit_fail')) {
            if ($customTask = SQ_Classes_Helpers_Tools::getOption('sq_devkit_audit_fail')) {
                foreach ($customTask as $key => $value) {
                    if ($value <> ''|| $value === false) {
                        $task->$key = stripslashes($value);
                    }
                }
            }
        }

        return $task;
    }

    /**
     * Hook the head
     */
    public function hookHead() {
        //Hide the ads
        if (!SQ_Classes_Helpers_Tools::getMenuVisible('show_ads')) {
            echo '<style>.sq_offer {display: none !important;}</style>';
        }

        //Dev Kit images
        if (SQ_Classes_Helpers_Tools::getOption('sq_devkit_logo')) {
            echo '<style>.toplevel_page_sq_dashboard .wp-menu-image img{max-width: 24px !important;}.sq_logo{background-image:url("' . SQ_Classes_Helpers_Tools::getOption('sq_devkit_logo') . '") !important;background-size: 100%;}</style>';
        }
    }

    /**
     * Change the Squirrly SEO logo in DevKit
     * @param $logo
     * @return mixed
     */
    public function getCustomLogo($logo) {

        if (SQ_Classes_Helpers_Tools::getOption('sq_devkit_logo')) {
            $logo = SQ_Classes_Helpers_Tools::getOption('sq_devkit_logo');
        }

        return $logo;
    }

    /**
     * Get Plugin Custom Name
     * @param $name
     * @return string
     */
    public function getCustomName($name) {

        if (SQ_Classes_Helpers_Tools::getOption('sq_devkit_name')) {
            $name = SQ_Classes_Helpers_Tools::getOption('sq_devkit_name');
        }

        return $name;
    }

    /**
     * Get Plugin Custom Menu Name
     * @param $name
     * @return string
     */
    public function getCustomMenuName($name) {

        if (SQ_Classes_Helpers_Tools::getOption('sq_devkit_menu_name')) {
            $name = SQ_Classes_Helpers_Tools::getOption('sq_devkit_menu_name');
        }

        return $name;
    }

    //Change the features
    public function manageFeatures($features){
        if (!SQ_Classes_Helpers_Tools::getMenuVisible('show_panel')) {
            unset($features[0]); //remove the Cloud App features
        }

        return $features;
    }

    /**
     * Manage the menu visibility
     */
    public function manageMenu($menu) {
        if (!SQ_Classes_Helpers_Tools::getMenuVisible('show_tutorial')) {
            $menu['sq_onboarding']['leftmenu'] = false;
            $menu['sq_onboarding']['topmenu'] = false;
        }
        if (!SQ_Classes_Helpers_Tools::getMenuVisible('show_audit')) {
            $menu['sq_audits']['leftmenu'] = false;
            $menu['sq_audits']['topmenu'] = false;
        }
        if (!SQ_Classes_Helpers_Tools::getMenuVisible('show_rankings')) {
            $menu['sq_rankings']['leftmenu'] = false;
            $menu['sq_rankings']['topmenu'] = false;
        }
        if (!SQ_Classes_Helpers_Tools::getMenuVisible('show_focuspages')) {
            $menu['sq_focuspages']['leftmenu'] = false;
            $menu['sq_focuspages']['topmenu'] = false;
        }
        if (!SQ_Classes_Helpers_Tools::getMenuVisible('show_account_info')) {
            $menu['sq_account']['leftmenu'] = false;
            $menu['sq_account']['topmenu'] = false;
        }

        return $menu;
    }

    /**
     * Check if Dev Kit is installed
     *
     * @return bool
     */
    public function updatePluginData() {

        $wp_filesystem = SQ_Classes_Helpers_Tools::initFilesystem();

        $package_file = _SQ_ROOT_DIR_ . 'package.json';
        if (!$wp_filesystem->exists($package_file)) {
            return false;
        }

        /* load configuration blocks data from core config files */
        $config = json_decode($wp_filesystem->get_contents($package_file), 1);
        if (isset($config['package'])) {
            self::$package = $config['package'];

            if (isset(self::$package['settings']) && !empty(SQ_Classes_Helpers_Tools::$options) && function_exists('array_replace_recursive')) {
                SQ_Classes_Helpers_Tools::$options = array_replace_recursive((array)SQ_Classes_Helpers_Tools::$options, (array)self::$package['settings']);

                SQ_Classes_Helpers_Tools::saveOptions();
                unlink($package_file);

                wp_redirect(SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard'));
                exit();
            }
        }


        //remove the package after activation
        unlink($package_file);

        return true;
    }

    /**
     * Change the plugin name
     * @param $string
     * @return mixed
     */
    public function changeString($string) {
        if (isset(self::$plugin['name'])) {
            return str_replace(self::$plugin['name'], apply_filters('sq_name', self::$plugin['name']), $string);
        }
        return $string;
    }

    //Get the package info in case of custom details
    public function getPackageInfo($key) {
        if (isset(self::$package[$key])) {
            return self::$package[$key];
        }

        return false;
    }

}
