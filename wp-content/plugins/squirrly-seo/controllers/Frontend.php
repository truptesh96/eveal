<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Controllers_Frontend extends SQ_Classes_FrontController {

    /** @var  SQ_Models_Frontend */
    public $model;

    public function __construct() {
        if (is_admin() || is_network_admin() || SQ_Classes_Helpers_Tools::isAjax()) {
            return;
        }

        //load the hooks
        parent::__construct();

        //For favicon and Robots
        $this->hookCheckFiles();

        //Check cache plugin compatibility
        SQ_Classes_ObjController::getClass('SQ_Models_Compatibility')->checkCompatibility();

        //Check if late loading is on
        if (!apply_filters('sq_lateloading', SQ_Classes_Helpers_Tools::getOption('sq_laterload'))) {
            //Hook the buffer on both actions in case one fails
            add_action('plugins_loaded', array($this, 'hookBuffer'), 9);
        }

        //In case plugins_loaded hook is disabled
        add_action('template_redirect', array($this, 'hookBuffer'), 1);

        //Set the post so that Squirrly will know which one to process
        add_action('template_redirect', array($this->model, 'setPost'), 9);

        //Check the old permalink and redirect to the new permalink
        if (SQ_Classes_Helpers_Tools::getOption('sq_permalink_redirect')) {
            add_action('template_redirect', array($this->model, 'redirectPermalinks'), 10);
        }

        /* Check if sitemap is on and Load the Sitemap */
        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap')) {
            add_filter('wp_sitemaps_enabled', '__return_false');
            SQ_Classes_ObjController::getClass('SQ_Controllers_Sitemaps');
        }

        if(SQ_Classes_Helpers_Tools::getOption('sq_auto_links')) {

            //Check if attachment to image redirect is needed
            if (SQ_Classes_Helpers_Tools::getOption('sq_attachment_redirect')) {
                add_action('template_redirect', array($this->model, 'redirectAttachments'), 10);
            }

            /* Fix the Links in content */
            if (SQ_Classes_Helpers_Tools::getOption('sq_external_nofollow') || SQ_Classes_Helpers_Tools::getOption('sq_external_blank')) {
                add_action('the_content', array($this, 'fixNofollowLinks'), 11);
            }

        }
    }

    /**
     * HOOK THE BUFFER
     */
    public function hookBuffer() {
        //remove the action is already hocked in plugins_loaded
        if (!did_action('template_redirect')) {
            remove_action('template_redirect', array($this, 'hookBuffer'), 1);
        }

        $this->model->startBuffer();
    }

    /**
     * Called after plugins are loaded
     */
    public function hookCheckFiles() {
        //Check for sitemap and robots
        if ($basename = $this->getFileName($_SERVER['REQUEST_URI'])) {
            if (SQ_Classes_Helpers_Tools::getOption('sq_auto_robots') == 1) {
                if ($basename == "robots.txt") {
                    SQ_Classes_ObjController::getClass('SQ_Models_Services_Robots');
                    apply_filters('sq_robots', false);
                    exit();
                }
            }

            if (SQ_Classes_Helpers_Tools::getOption('sq_auto_favicon') && SQ_Classes_Helpers_Tools::getOption('favicon') <> '') {
                if ($basename == "favicon.icon") {
                    SQ_Classes_Helpers_Tools::setHeader('ico');
                    @readfile(_SQ_CACHE_DIR_ . SQ_Classes_Helpers_Tools::getOption('favicon'));
                    exit();
                } elseif ($basename == "touch-icon.png") {
                    SQ_Classes_Helpers_Tools::setHeader('png');
                    @readfile(_SQ_CACHE_DIR_ . SQ_Classes_Helpers_Tools::getOption('favicon'));
                    exit();
                } else {
                    $appleSizes = preg_split('/[,]+/', _SQ_MOBILE_ICON_SIZES);
                    foreach ($appleSizes as $appleSize) {
                        if ($basename == "touch-icon$appleSize.png") {
                            SQ_Classes_Helpers_Tools::setHeader('png');
                            @readfile(_SQ_CACHE_DIR_ . SQ_Classes_Helpers_Tools::getOption('favicon') . $appleSize);
                            exit();
                        }
                    }
                }
            }

        }

    }


    /**
     * Hook the Header load
     */
    public function hookFronthead() {
        if (!is_admin() && (!SQ_Classes_Helpers_Tools::getOption('sq_load_css') || defined('SQ_NOCSS') && SQ_NOCSS)) {
            return;
        }

        if (!SQ_Classes_Helpers_Tools::isAjax()) {
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia(_SQ_ASSETS_URL_ . 'css/frontend' . (SQ_DEBUG ? '' : '.min') . '.css');
        }
    }


    /**
     * Change the image path to absolute when in feed
     * @param string $content
     *
     * @return string
     */
    public function fixNofollowLinks($content) {

        if (!is_feed() && !is_404()) {
            preg_match_all('/<a[^>]*href=[\'"]([^\'"]+)[\'"][^>]*>/i', $content, $out);
            if (empty($out) || empty($out[0])) {
                return $content;
            }

            $domain = parse_url(home_url(), PHP_URL_HOST);

            foreach ($out[0] as $index => $link) {
                $newlink = $link;

                //only for external links
                if (isset($out[1][$index])) {
                    //If it's not a valid link
                    if(!$linkdomain = parse_url($out[1][$index], PHP_URL_HOST)){
                        continue;
                    }

                    //If it's not an external link
                    if (strpos($linkdomain, $domain) !== false) {
                        continue;
                    }

                    //If it's not an exception link
                    $exceptions = SQ_Classes_Helpers_Tools::getOption('sq_external_exception');
                    if(!empty($exceptions)){
                        foreach ($exceptions as $exception){
                            if (strpos($exception, $linkdomain) !== false) {
                                continue 2;
                            }
                        }
                    }
                }

                //If nofollow rel is set
                if (SQ_Classes_Helpers_Tools::getOption('sq_external_nofollow')) {

                    if (strpos($newlink, 'rel=') === false) {
                        $newlink = str_replace('<a', '<a rel="nofollow" ', $newlink);
                    } elseif (strpos($newlink, 'nofollow') === false) {
                        $newlink = preg_replace('/(rel=[\'"])([^\'"]+)([\'"])/i', '$1nofollow $2$3', $newlink);
                    }

                }

                //if force external open
                if (SQ_Classes_Helpers_Tools::getOption('sq_external_blank')) {

                    if (strpos($newlink, 'target=') === false) {
                        $newlink = str_replace('<a', '<a target="_blank" ', $newlink);
                    } elseif (strpos($link, '_blank') === false) {
                        $newlink = preg_replace('/(target=[\'"])([^\'"]+)([\'"])/i', '$1_blank$3', $newlink);
                    }

                }

                //Check the link and replace it
                if ($newlink <> $link) {
                    $content = str_replace($link, $newlink, $content);
                }
            }

        }
        return $content;
    }

    /**
     * Hook the footer
     */
    public function hookFrontfooter() {
        echo (string)$this->model->getFooter();
    }

    /**
     * Get the File Name if itțs a file in URL
     * @param null $url
     * @return bool|string|null
     */
    public function getFileName($url = null) {
        if (isset($url) && $url <> '') {
            $url = basename($url);
            if (strpos($url, '?') <> '') {
                $url = substr($url, 0, strpos($url, '?'));
            }

            $files = array('ico', 'icon', 'txt', 'jpg', 'jpeg', 'png', 'bmp', 'gif', 'webp',
                'css', 'scss', 'js',
                'pdf', 'doc', 'docx', 'csv', 'xls', 'xslx',
                'mp4', 'mpeg',
                'zip', 'rar');

            if (strrpos($url, '.') !== false) {
                $ext = substr($url, strrpos($url, '.') + 1);
                if (in_array($ext, $files)) {
                    return $url;
                }
            }
        }

        return false;

    }
}
