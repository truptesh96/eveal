<?php

class SQ_Models_Services_Robots extends SQ_Models_Abstract_Seo {


    public function __construct() {
        parent::__construct();
        add_filter('sq_robots', array($this, 'generateRobots'));
        add_filter('sq_robots', array($this, 'showRobots'), 11);
    }

    public function generateRobots($robots = '') {
        $robots .= "\n# " . esc_html__("Squirrly SEO Robots", _SQ_PLUGIN_NAME_);

        if (get_option('blog_public') != 1) {
            $robots .= "\n# " . esc_html__("Your blog is not public. Please see Site Visibility on Settings > Reading.", _SQ_PLUGIN_NAME_);
        } else {

            $sq_sitemap = SQ_Classes_Helpers_Tools::getOption('sq_sitemap');
             if (SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap') == 1) {
                foreach ((array)$sq_sitemap as $name => $sitemap) {
                    if ($name == 'sitemap-product' && !SQ_Classes_Helpers_Tools::isEcommerce()) {
                        continue;
                    }
                    if ($sitemap[1] == 1 || $sitemap[1] == 2) {
                        $robots .= "\nSitemap: " . trailingslashit(get_bloginfo('url')) . $sitemap[0];
                    }
                }
            }

            if (empty($sq_sitemap)) {
                $robots .= "\n# " . esc_html__("No Squirrly SEO Robots found.", _SQ_PLUGIN_NAME_);
            }
        }
        $robots .= "\n\n";

        $robots_permission = SQ_Classes_Helpers_Tools::getOption('sq_robots_permission');
        if (!empty($robots_permission)) {
            foreach ((array)$robots_permission as $robot_txt)
                $robots .= $robot_txt . "\n";
        }
        $robots .= "\n\n";

        return apply_filters('sq_custom_robots', $robots);
    }

    public function showRobots($robots = '') {
        /** display robots.txt */
        header('Status: 200 OK', true, 200);
        header('Content-type: text/plain; charset=' . get_bloginfo('charset'));

        echo sanitize_textarea_field($robots);
        exit();
    }
}