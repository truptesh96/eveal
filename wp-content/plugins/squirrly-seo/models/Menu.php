<?php

class SQ_Models_Menu {

    /** @var array with the menu content
     *
     * $page_title (string) (required) The text to be displayed in the title tags of the page when the menu is selected
     * $menu_title (string) (required) The on-screen name text for the menu
     * $capability (string) (required) The capability required for this menu to be displayed to the user. User levels are deprecated and should not be used here!
     * $menu_slug (string) (required) The slug name to refer to this menu by (should be unique for this menu). Prior to Version 3.0 this was called the file (or handle) parameter. If the function parameter is omitted, the menu_slug should be the PHP file that handles the display of the menu page content.
     * $function The function that displays the page content for the menu page. Technically, the function parameter is optional, but if it is not supplied, then WordPress will basically assume that including the PHP file will generate the administration screen, without calling a function. Most plugin authors choose to put the page-generating code in a function within their main plugin file.:In the event that the function parameter is specified, it is possible to use any string for the file parameter. This allows usage of pages such as ?page=my_super_plugin_page instead of ?page=my-super-plugin/admin-options.php.
     * $icon_url (string) (optional) The url to the icon to be used for this menu. This parameter is optional. Icons should be fairly small, around 16 x 16 pixels for best results. You can use the plugin_dir_url( __FILE__ ) function to get the URL of your plugin directory and then add the image filename to it. You can set $icon_url to "div" to have wordpress generate <br> tag instead of <img>. This can be used for more advanced formating via CSS, such as changing icon on hover.
     * $position (integer) (optional) The position in the menu order this menu should appear. By default, if this parameter is omitted, the menu will appear at the bottom of the menu structure. The higher the number, the lower its position in the menu. WARNING: if 2 menu items use the same position attribute, one of the items may be overwritten so that only one item displays!
     *
     * */
    public $menu = array();

    /** @var array with the menu content
     * $id (string) (required) HTML 'id' attribute of the edit screen section
     * $title (string) (required) Title of the edit screen section, visible to user
     * $callback (callback) (required) Function that prints out the HTML for the edit screen section. Pass function name as a string. Within a class, you can instead pass an array to call one of the class's methods. See the second example under Example below.
     * $post_type (string) (required) The type of Write screen on which to show the edit screen section ('post', 'page', 'link', or 'custom_post_type' where custom_post_type is the custom post type slug)
     * $context (string) (optional) The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side'). (Note that 'side' doesn't exist before 2.7)
     * $priority (string) (optional) The priority within the context where the boxes should show ('high', 'core', 'default' or 'low')
     * $callback_args (array) (optional) Arguments to pass into your callback function. The callback will receive the $post object and whatever parameters are passed through this variable.
     *
     * */
    public $meta = array();

    public function __construct() {

    }

    /**
     * Add a menu in WP admin page
     *
     * @param array $param
     *
     * @return void
     */
    public function addMenu($param = null) {
        if ($param)
            $this->menu = $param;

        if (is_array($this->menu)) {
            if ($this->menu[0] <> '' && $this->menu[1] <> '') {
                /* add the translation */
                if (!isset($this->menu[5]))
                    $this->menu[5] = null;
                if (!isset($this->menu[6]))
                    $this->menu[6] = null;

                /* add the menu with WP */
                add_menu_page($this->menu[0], $this->menu[1], $this->menu[2], $this->menu[3], $this->menu[4], $this->menu[5], $this->menu[6]);
            }
        }
    }

    /**
     * Add a submenumenu in WP admin page
     *
     * @param array $param
     *
     * @return void
     */
    public function addSubmenu($param = null) {
        if ($param)
            $this->menu = $param;

        if (is_array($this->menu)) {

            if ($this->menu[0] <> '' && $this->menu[1] <> '') {
                if (!isset($this->menu[5]))
                    $this->menu[5] = null;

                /* add the menu with WP */
                add_submenu_page($this->menu[0], $this->menu[1], $this->menu[2], $this->menu[3], $this->menu[4], $this->menu[5]);
            }
        }
    }

    /**
     * Add a box Meta in WP
     *
     * @param array $param
     *
     * @return void
     */
    public function addMeta($param = null) {
        if ($param)
            $this->meta = $param;


        if (is_array($this->meta)) {

            if ($this->meta[0] <> '' && $this->meta[1] <> '') {
                if (!isset($this->meta[5]))
                    $this->meta[5] = null;
                if (!isset($this->meta[6]))
                    $this->meta[6] = null;
                /* add the box content with WP */
                add_meta_box($this->meta[0], $this->meta[1], $this->meta[2], $this->meta[3], $this->meta[4], $this->meta[5]);
            }
        }
    }

    public function getMainMenu() {
        $menu = array(
            'sq_dashboard' => array(
                'title' => ((SQ_Classes_Helpers_Tools::getOption('sq_api') == '') ? esc_html__("First Step", _SQ_PLUGIN_NAME_) : esc_html__("Overview", _SQ_PLUGIN_NAME_)),
                'description' => ucfirst(_SQ_NAME_) . ' ' . esc_html__("Overview", _SQ_PLUGIN_NAME_),
                'parent' => 'sq_dashboard',
                'capability' => 'edit_posts',
                'function' => array(SQ_Classes_ObjController::getClass('SQ_Controllers_Overview'), 'init'),
                'href' => false,
                'icon' => '',
                'topmenu' => true,
                'leftmenu' => true,
                'fullscreen' => false
            ),
            'sq_features' => array(
                'title' => esc_html__("All Features", _SQ_PLUGIN_NAME_),
                'description' => ucfirst(_SQ_NAME_) . ' ' . esc_html__("All Features", _SQ_PLUGIN_NAME_),
                'parent' => 'sq_dashboard',
                'capability' => 'edit_posts',
                'function' => array(SQ_Classes_ObjController::getClass('SQ_Controllers_Features'), 'init'),
                'href' => false,
                'icon' => '',
                'topmenu' => false,
                'leftmenu' => true,
                'fullscreen' => false
            ),
            'sq_research' => array(
                'title' => esc_html__("Research", _SQ_PLUGIN_NAME_),
                'description' => ucfirst(_SQ_NAME_) . ' ' . esc_html__("Research", _SQ_PLUGIN_NAME_),
                'parent' => 'sq_dashboard',
                'capability' => 'sq_manage_snippet',
                'function' => array(SQ_Classes_ObjController::getClass('SQ_Controllers_Research'), 'init'),
                'href' => false,
                'icon' => '',
                'topmenu' => true,
                'leftmenu' => esc_html__("Keyword Research", _SQ_PLUGIN_NAME_),
                'fullscreen' => true
            ),
            'sq_briefcase' => array(
                'title' => esc_html__("Briefcase", _SQ_PLUGIN_NAME_),
                'description' => ucfirst(_SQ_NAME_) . ' ' . esc_html__("Briefcase", _SQ_PLUGIN_NAME_),
                'parent' => 'sq_dashboard',
                'capability' => 'sq_manage_snippet',
                'function' => array(SQ_Classes_ObjController::getClass('SQ_Controllers_Research'), 'init'),
                'href' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase'),
                'icon' => '',
                'topmenu' => false,
                'leftmenu' => true,
                'fullscreen' => true
            ),
            'sq_assistant' => array(
                'title' => esc_html__("Live Assistant", _SQ_PLUGIN_NAME_),
                'description' => ucfirst(_SQ_NAME_) . ' ' . esc_html__("Live Assistant", _SQ_PLUGIN_NAME_),
                'parent' => 'sq_dashboard',
                'capability' => 'sq_manage_snippet',
                'function' => array(SQ_Classes_ObjController::getClass('SQ_Controllers_Assistant'), 'init'),
                'href' => false,
                'icon' => '',
                'topmenu' => true,
                'leftmenu' => true,
                'fullscreen' => true
            ),
            'sq_bulkseo' => array(
                'title' => esc_html__("All Snippets", _SQ_PLUGIN_NAME_),
                'description' => ucfirst(_SQ_NAME_) . ' ' . esc_html__("Bulk SEO", _SQ_PLUGIN_NAME_),
                'parent' => 'sq_dashboard',
                'capability' => 'sq_manage_snippet',
                'function' => array(SQ_Classes_ObjController::getClass('SQ_Controllers_BulkSeo'), 'init'),
                'href' => false,
                'icon' => '',
                'topmenu' => true,
                'leftmenu' => esc_html__("Bulk SEO", _SQ_PLUGIN_NAME_),
                'fullscreen' => true
            ),
            'sq_seosettings' => array(
                'title' => esc_html__("SEO Settings", _SQ_PLUGIN_NAME_),
                'description' => ucfirst(_SQ_NAME_) . ' ' . esc_html__("SEO Settings", _SQ_PLUGIN_NAME_),
                'parent' => 'sq_dashboard',
                'capability' => 'sq_manage_snippet',
                'function' => array(SQ_Classes_ObjController::getClass('SQ_Controllers_SeoSettings'), 'init'),
                'href' => false,
                'icon' => '',
                'topmenu' => true,
                'leftmenu' => true,
                'fullscreen' => true
            ),
            'sq_sitemap' => array(
                'title' => esc_html__("Sitemap XML", _SQ_PLUGIN_NAME_),
                'description' => ucfirst(_SQ_NAME_) . ' ' . esc_html__("Sitemap XML", _SQ_PLUGIN_NAME_),
                'parent' => 'sq_dashboard',
                'capability' => 'sq_manage_settings',
                'function' => array(SQ_Classes_ObjController::getClass('SQ_Controllers_SeoSettings'), 'init'),
                'href' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'sitemap'),
                'icon' => '',
                'topmenu' => false,
                'leftmenu' => true,
                'fullscreen' => false
            ),
            'sq_jsonld' => array(
                'title' => esc_html__("Local SEO", _SQ_PLUGIN_NAME_),
                'description' => ucfirst(_SQ_NAME_) . ' ' . esc_html__("Local SEO", _SQ_PLUGIN_NAME_),
                'parent' => 'sq_dashboard',
                'capability' => 'sq_manage_settings',
                'function' => array(SQ_Classes_ObjController::getClass('SQ_Controllers_SeoSettings'), 'init'),
                'href' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'jsonld'),
                'icon' => '',
                'topmenu' => false,
                'leftmenu' => true,
                'fullscreen' => false
            ),
            'sq_focuspages' => array(
                'title' => esc_html__("Focus Pages", _SQ_PLUGIN_NAME_),
                'description' => ucfirst(_SQ_NAME_) . ' ' . esc_html__("Focus Pages", _SQ_PLUGIN_NAME_),
                'parent' => 'sq_dashboard',
                'capability' => 'sq_manage_snippet',
                'function' => array(SQ_Classes_ObjController::getClass('SQ_Controllers_FocusPages'), 'init'),
                'href' => false,
                'icon' => '',
                'topmenu' => true,
                'leftmenu' => true,
                'fullscreen' => true
            ),
            'sq_audits' => array(
                'title' => esc_html__("SEO Audit", _SQ_PLUGIN_NAME_),
                'description' => ucfirst(_SQ_NAME_) . ' ' . esc_html__("SEO Audit", _SQ_PLUGIN_NAME_),
                'parent' => 'sq_dashboard',
                'capability' => 'sq_manage_snippet',
                'function' => array(SQ_Classes_ObjController::getClass('SQ_Controllers_Audits'), 'init'),
                'href' => false,
                'icon' => '',
                'topmenu' => true,
                'leftmenu' => true,
                'fullscreen' => true
            ),
            'sq_rankings' => array(
                'title' => esc_html__("Rankings", _SQ_PLUGIN_NAME_),
                'description' => ucfirst(_SQ_NAME_) . ' ' . esc_html__("Rankings", _SQ_PLUGIN_NAME_),
                'parent' => 'sq_dashboard',
                'capability' => 'sq_manage_snippet',
                'function' => array(SQ_Classes_ObjController::getClass('SQ_Controllers_Ranking'), 'init'),
                'href' => false,
                'icon' => '',
                'topmenu' => true,
                'leftmenu' => esc_html__("Google Rankings", _SQ_PLUGIN_NAME_),
                'fullscreen' => true
            ),
            'sq_onboarding' => array(
                'title' => esc_html__("Onboarding", _SQ_PLUGIN_NAME_),
                'description' => ucfirst(_SQ_NAME_) . ' ' . esc_html__("Onboarding", _SQ_PLUGIN_NAME_),
                'parent' => 'sq_dashboard',
                'capability' => 'read',
                'function' => array(SQ_Classes_ObjController::getClass('SQ_Controllers_Onboarding'), 'init'),
                'href' => false,
                'icon' => '',
                'topmenu' => false,
                'leftmenu' => false,
                'fullscreen' => true
            ),
            'sq_import' => array(
                'title' => esc_html__("Import & Export SEO", _SQ_PLUGIN_NAME_),
                'description' => ucfirst(_SQ_NAME_) . ' ' . esc_html__("Import & Export SEO", _SQ_PLUGIN_NAME_),
                'parent' => 'sq_dashboard',
                'capability' => 'sq_manage_settings',
                'function' => array(SQ_Classes_ObjController::getClass('SQ_Controllers_SeoSettings'), 'init'),
                'href' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'backup'),
                'icon' => '',
                'topmenu' => false,
                'leftmenu' => true,
                'fullscreen' => false
            ),
            'sq_account' => array(
                'title' => esc_html__("Account Info", _SQ_PLUGIN_NAME_),
                'description' => ucfirst(_SQ_NAME_) . ' ' . esc_html__("Account Info", _SQ_PLUGIN_NAME_),
                'parent' => 'sq_dashboard',
                'capability' => 'manage_options',
                'function' => false,
                'href' => SQ_Classes_RemoteController::getMySquirrlyLink('account'),
                'icon' => '',
                'topmenu' => false,
                'leftmenu' => true,
                'fullscreen' => false
            ),
            'sq_help' => array(
                'title' => esc_html__("How To & Support", _SQ_PLUGIN_NAME_),
                'description' => ucfirst(_SQ_NAME_) . ' ' . esc_html__("Help & Support", _SQ_PLUGIN_NAME_),
                'parent' => 'sq_dashboard',
                'capability' => 'edit_posts',
                'function' => false,
                'href' => _SQ_HOWTO_URL_,
                'icon' => '',
                'topmenu' => false,
                'leftmenu' => true,
                'fullscreen' => false
            ),


        );

        //for PHP 7.3.1 version
        $menu = array_filter($menu);

        return apply_filters('sq_menu', $menu);
    }

    /**
     * Get the admin Menu Tabs
     * @param string $category
     * @return array
     */
    public function getTabs($category) {
        $tabs = array();
        $tabs['sq_research'] = array(
            'sq_research/research' => array(
                'title' => esc_html__("Find Keywords", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("do a keyword research", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_snippet',
                'icon' => 'kr_92.png'
            ),
            'sq_research/briefcase' => array(
                'title' => esc_html__("Briefcase", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("save the best Keywords", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_snippet',
                'icon' => 'briefcase_92.png'
            ),
            'sq_research/labels' => array(
                'title' => esc_html__("Labels", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("group keywords", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_snippet',
                'icon' => 'labels_92.png'
            ),
            'sq_research/suggested' => array(
                'title' => esc_html__("Suggested", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("better keywords found", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_snippet',
                'icon' => 'suggested_92.png'
            ),
            'sq_research/history' => array(
                'title' => esc_html__("History", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("keyword research history", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_snippet',
                'icon' => 'history_92.png'
            ),
        );
        $tabs['sq_assistant'] = array(
            'sq_assistant/assistant' => array(
                'title' => esc_html__("Optimize Posts", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("use the Live Assistant", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_snippet',
                'icon' => 'sla_92.png'
            ),
            'sq_assistant/settings' => array(
                'title' => esc_html__("Settings", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("live assistant setup", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_settings',
                'icon' => 'settings_92.png'
            ),
        );
        $tabs['sq_focuspages'] = array(
            'sq_focuspages/pagelist' => array(
                'title' => esc_html__("Focus Pages", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("all my focus pages", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_snippet',
                'icon' => 'focuspages_92.png'
            ),
//            'sq_focuspages/bestpractice' => array(
//                'title' => esc_html__("Best Practices", _SQ_PLUGIN_NAME_),
//                'description' => esc_html__("for maximum results", _SQ_PLUGIN_NAME_),
//                'capability' => 'sq_manage_focuspages',
//                'icon' => 'boostpages_92.png'
//            ),
            'sq_focuspages/addpage' => array(
                'title' => esc_html__("Add New Page", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("add page in focus pages", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_focuspages',
                'icon' => 'addpage_92.png'
            ),
        );
        $tabs['sq_audits'] = array(
            'sq_audits/audits' => array(
                'title' => esc_html__("Overview", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("See all the SEO audits", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_snippet',
                'icon' => 'audit_92.png'
            ),
            'sq_audits/addpage' => array(
                'title' => esc_html__("Add New Page", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("add page in audit", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_focuspages',
                'icon' => 'addpage_92.png'
            ),
            'sq_audits/settings' => array(
                'title' => esc_html__("Settings", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("Audit settings", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_settings',
                'icon' => 'settings_92.png'
            ),
        );
        $tabs['sq_rankings'] = array(
            'sq_rankings/rankings' => array(
                'title' => esc_html__("Rankings", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("See Google ranking", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_snippet',
                'icon' => 'ranking_92.png'
            ),
            'sq_research/briefcase' => array(
                'title' => esc_html__("Add Keywords", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("Add briefcase keywords", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_focuspages',
                'icon' => 'addpage_92.png'
            ),
            'sq_rankings/gscsync' => array(
                'title' => esc_html__("Sync Keywords", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("Sync Keywords from GSC", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_focuspages',
                'icon' => 'addpage_92.png'
            ),
            'sq_rankings/settings' => array(
                'title' => esc_html__("Settings", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("Ranking settings", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_settings',
                'icon' => 'settings_92.png'
            ),

        );

        $tabs['sq_bulkseo'] = array(
            'sq_bulkseo/bulkseo' => array(
                'title' => esc_html__("Bulk SEO", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("optimize all pages", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_snippet',
                'icon' => 'bulkseo_92.png'
            ),
        );

        $tabs['sq_seosettings'] = array(
            'sq_seosettings/automation' => array(
                'title' => esc_html__("Automation", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("patterns & automation", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_settings',
                'icon' => 'automation_92.png'
            ),
            'sq_seosettings/links' => array(
                'title' => esc_html__("SEO Links", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("manage website links", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_settings',
                'icon' => 'links_92.png'
            ),
            'sq_seosettings/metas' => array(
                'title' => esc_html__("SEO Metas", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("required on-page metas", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_settings',
                'icon' => 'metas_92.png'
            ),
           'sq_seosettings/jsonld' => array(
                'title' => esc_html__("JSON-LD", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("rich snippets & schema", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_settings',
                'icon' => 'jsonld_92.png'
            ),
            'sq_seosettings/social' => array(
                'title' => esc_html__("Social Media", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("social share options", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_settings',
                'icon' => 'social_92.png'
            ),
            'sq_seosettings/tracking' => array(
                'title' => esc_html__("Tracking Tools", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("google analytics, pixel, etc.", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_settings',
                'icon' => 'traffic_92.png'
            ),
            'sq_seosettings/webmaster' => array(
                'title' => esc_html__("Webmaster Tools", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("connect to webmasters", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_settings',
                'icon' => 'websites_92.png'
            ),
            'sq_seosettings/sitemap' => array(
                'title' => esc_html__("Sitemap XML", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("setup the sitemap", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_settings',
                'icon' => 'sitemap_92.png'
            ),
            'sq_seosettings/robots' => array(
                'title' => esc_html__("Robots.txt", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("search engine filters", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_settings',
                'icon' => 'robots_92.png'
            ),
            'sq_seosettings/favicon' => array(
                'title' => esc_html__("Favicon", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("add website icon", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_settings',
                'icon' => 'favicon_92.png'
            ),
            'sq_seosettings/backup' => array(
                'title' => esc_html__("Import/Export", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("import & export SEO", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_settings',
                'icon' => 'settings_92.png'
            ),
        );

        //add advanced section for advanced users
        if (SQ_Classes_Helpers_Tools::getOption('sq_seoexpert')) {
            $tabs['sq_seosettings']['sq_seosettings/advanced'] = array(
                'title' => esc_html__("Advanced", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("Advanced SEO Settings", _SQ_PLUGIN_NAME_),
                'capability' => 'sq_manage_settings',
                'icon' => 'settings_92.png'
            );
        }

        $tabs['sq_onboarding'] = array(
            'sq_onboarding/step1' => array(
                'title' => esc_html__("First Step", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("website details", _SQ_PLUGIN_NAME_),
                'capability' => 'edit_posts',
                'icon' => '../onboarding/1.png'
            ),
            'sq_onboarding/step2' => array(
                'title' => esc_html__("SEO Automation", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("build SEO Automation", _SQ_PLUGIN_NAME_),
                'capability' => 'edit_posts',
                'icon' => '../onboarding/1.png'
            ),
            'sq_onboarding/step3' => array(
                'title' => esc_html__("Import SEO", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("import settings and SEO", _SQ_PLUGIN_NAME_),
                'capability' => 'edit_posts',
                'icon' => '../onboarding/2.png'
            ),
            'sq_onboarding/step4' => array(
                'title' => esc_html__("Final Step", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("check today SEO goals", _SQ_PLUGIN_NAME_),
                'capability' => 'edit_posts',
                'icon' => '../onboarding/3.png'
            ),

        );

        $tabs['sq_audit'] = array(
            'blogging' => array(
                'title' => esc_html__("Blogging", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("Blogging overwiew", _SQ_PLUGIN_NAME_),
                'capability' => 'edit_posts',
                'icon' => 'sla_92.png'
            ),
            'traffic' => array(
                'title' => esc_html__("Traffic", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("Weekly website traffic", _SQ_PLUGIN_NAME_),
                'capability' => 'edit_posts',
                'icon' => 'traffic_92.png'
            ),
            'seo' => array(
                'title' => esc_html__("SEO", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("On-Page optimization", _SQ_PLUGIN_NAME_),
                'capability' => 'edit_posts',
                'icon' => 'bulkseo_92.png'
            ),
            'social' => array(
                'title' => esc_html__("Social", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("Social signals and shares", _SQ_PLUGIN_NAME_),
                'capability' => 'edit_posts',
                'icon' => 'analytics_92.png'
            ),
            'links' => array(
                'title' => esc_html__("Links", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("Backlinks and Innerlinks", _SQ_PLUGIN_NAME_),
                'capability' => 'edit_posts',
                'icon' => 'links_92.png'
            ),
            'authority' => array(
                'title' => esc_html__("Authority", _SQ_PLUGIN_NAME_),
                'description' => esc_html__("Website Off-Page score", _SQ_PLUGIN_NAME_),
                'capability' => 'edit_posts',
                'icon' => 'authority_92.png'
            ),
        );

        //for PHP 7.3.1 version
        $tabs = array_filter($tabs);

        if (isset($tabs[$category])) {
            return apply_filters('sq_menu_' . $category, $tabs[$category]);

        }

        return array();
    }

    public function getAuditTabs() {
        $tabs = $this->getTabs('sq_audit');
        $content = '';
        $content .= '<div class="sq_nav d-flex flex-column bg-nav mb-3 sticky">';

        foreach ($tabs as $location => $row) {
            $content .= '<a class="m-0 p-4 font-dark sq_nav_item ' . $location . '" data-id="' . $location . '" href="javascript:void(0);" >
                <img class="sq_nav_item_icon" src="' . _SQ_THEME_URL_ . 'assets/img/logos/' . $row['icon'] . '">
                <span class="sq_nav_item_title">' . $row['title'] . '</span>
                <span class="sq_nav_item_description">' . $row['description'] . '</span>
            </a>';
        }

        $content .= '</div>';
        return $content;
    }

    public function getVisitedMenu() {
        $menu_visited = SQ_Classes_Helpers_Tools::getOption('sq_menu_visited');
        $menuid = apply_filters('sq_page', SQ_Classes_Helpers_Tools::getValue('page', false));

        if (!in_array($menuid, $menu_visited)) {
            array_push($menu_visited, $menuid);
        }

        SQ_Classes_Helpers_Tools::saveOptions('sq_menu_visited', $menu_visited);

        return SQ_Classes_Helpers_Tools::getOption('sq_menu_visited');
    }

    /**
     * Get the Squirrly admin menu based on selected category
     * @param null $current
     * @param string $category
     * @return string
     */
    public function getAdminTabs($current = null, $category = 'sq_research') {
        //Add the Menu Tabs in variable if not set before
        $tabs = $this->getTabs($category);

        $content = '';
        $content .= '<div class="sq_nav d-flex flex-column bg-nav mb-3">';

        if (!empty($tabs)) {
            foreach ($tabs as $location => $row) {
                if (!current_user_can($row['capability'])) continue;

                if ($current == $location || $current == substr($location, strpos($location, '/') + 1)) {
                    $class = 'active';
                } else {
                    $class = '';
                }

                $tab = null;
                if (strpos($location, '/')) {
                    list($location, $tab) = explode('/', $location);
                }

                $content .= '<a class="m-0 p-4 font-dark sq_nav_item ' . $class . '" href="' . SQ_Classes_Helpers_Tools::getAdminUrl($location, $tab) . '">
                <img class="sq_nav_item_icon" src="' . _SQ_THEME_URL_ . 'assets/img/logos/' . $row['icon'] . '">
                <span class="sq_nav_item_title">' . $row['title'] . '</span>
                <span class="sq_nav_item_description">' . $row['description'] . '</span>
            </a>';
            }
        }

        $content .= '</div>';

        //return the menu
        return $content;
    }

}
