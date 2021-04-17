<?php

class SQ_Models_Services_Favicon extends SQ_Models_Abstract_Seo {

    public function __construct() {
        parent::__construct();

        if (isset($this->_post->sq->doseo) && $this->_post->sq->doseo) {
            add_filter('sq_favicon', array($this, 'generateFavicon'));
            add_filter('sq_favicon', array($this, 'packFavicon'), 99);
        } else {
            add_filter('sq_favicon', array($this, 'returnFalse'));
        }
    }

    public function generateFavicon($favicons = array()) {
        $rnd = '';

        if (current_user_can('sq_manage_settings')) {
            $rnd = '?' . md5(SQ_Classes_Helpers_Tools::getOption('favicon'));
        }

        if (SQ_Classes_Helpers_Tools::getOption('favicon') <> '' && file_exists(_SQ_CACHE_DIR_ . SQ_Classes_Helpers_Tools::getOption('favicon'))) {
            if (!get_option('permalink_structure')) {
                $favicon = home_url() . '/index.php?sq_get=favicon';
                $touchicon = home_url() . '/index.php?sq_get=touchicon';
            } else {
                $favicon = home_url() . '/favicon.icon' . $rnd;
                $touchicon = home_url() . '/touch-icon.png' . $rnd;
            }

            $favicons['shortcut icon'] = $favicon;

            if(SQ_Classes_Helpers_Tools::getOption('sq_favicon_apple')) {
                $favicons['apple-touch-icon']['32'] = $touchicon;

                $appleSizes = preg_split('/[,]+/', _SQ_MOBILE_ICON_SIZES);
                foreach ($appleSizes as $size) {
                    if (!get_option('permalink_structure')) {
                        $favicon = home_url() . '/index.php?sq_get=touchicon&sq_size=' . $size;
                    } else {
                        $favicon = home_url() . '/touch-icon' . $size . '.png' . $rnd;
                    }
                    $favicons['apple-touch-icon'][$size] = $favicon;
                }
            }
        } else {
            if (file_exists(ABSPATH . 'favicon.ico')) {
                $favicons['shortcut icon'] = home_url() . '/favicon.ico';
            }
        }

        return $favicons;
    }

    public function packFavicon($favicons = array()) {
        $allfavicons = array();
        if (!empty($favicons)) {
            foreach ($favicons as $key => $favicon) {
                if (!is_array($favicon)) {
                    $allfavicons[] = sprintf('<link rel="%s" href="%s" />', $key, $favicon);
                } elseif (!empty($favicon)) {
                    foreach ($favicon as $size => $value) {
                        $allfavicons[] = sprintf('<link rel="%s" sizes="%s" href="%s" />', $key, $size . 'x' . $size, $value);
                    }
                }
            }

            return "\n" . join("\n", array_values($allfavicons));
        }

        return false;
    }

}