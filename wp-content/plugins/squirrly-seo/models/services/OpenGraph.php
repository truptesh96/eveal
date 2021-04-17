<?php

class SQ_Models_Services_OpenGraph extends SQ_Models_Abstract_Seo {

    public function __construct() {
        parent::__construct();

        if (isset($this->_post->sq->doseo) && $this->_post->sq->doseo) {
            if (!$this->_post->sq->do_og) {
                add_filter('sq_open_graph', array($this, 'returnFalse'));
                return;
            }

            add_filter('sq_locale', array($this, 'setLocale'));
            add_filter('sq_html_prefix', array($this, 'addOGPrefix'));

            add_filter('sq_open_graph', array($this, 'generateOpenGraph'));
            add_filter('sq_open_graph', array($this, 'packOpenGraph'), 99);
        } else {
            add_filter('sq_open_graph', array($this, 'returnFalse'));
        }

    }

    public function addOGPrefix($prefix = '') {
        $prefix .= 'og: http://ogp.me/ns#';
        if (!empty($this->_post->socials->fb_admins) || $this->_post->socials->fbadminapp <> '') {
            $prefix .= ' fb: http://ogp.me/ns/fb#';
        }

        return $prefix;
    }

    public function generateOpenGraph($og = array()) {
        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook')) {
            if ($this->_post->url <> '') {
                $og['og:url'] = urldecode(esc_url($this->_post->url));
            }

            if ($this->_post->sq->og_title <> '') {
                $og['og:title'] = SQ_Classes_Helpers_Sanitize::clearTitle($this->_post->sq->og_title);
            } else {
                $og['og:title'] = SQ_Classes_Helpers_Sanitize::clearTitle($this->_post->sq->title);
                if ($og['og:title'] <> '' && strlen($og['og:title']) > $this->_post->sq->og_title_maxlength) {
                    $og['og:title'] = $this->truncate($og['og:title'], 10, $this->_post->sq->og_title_maxlength);
                }
            }

            if ($this->_post->sq->og_description <> '') {
                $og['og:description'] = SQ_Classes_Helpers_Sanitize::clearDescription($this->_post->sq->og_description);
            } else {
                $og['og:description'] = SQ_Classes_Helpers_Sanitize::clearDescription($this->_post->sq->description);
                if ($og['og:description'] <> '' && strlen($og['og:description']) > $this->_post->sq->og_description_maxlength) {
                    $og['og:description'] = $this->truncate($og['og:description'], 10, $this->_post->sq->og_description_maxlength);
                }
            }

            if ($this->_post->sq->og_type <> '') {
                if ($this->_post->sq->og_type == 'newsarticle') {
                    $og['og:type'] = 'article';
                } else {
                    $og['og:type'] = $this->_post->sq->og_type;
                }
            } else {
                $og['og:type'] = 'website';
            }

            if ($this->_post->sq->og_media <> '') {
                $og['og:image'] = $this->_post->sq->og_media;
                $og['og:image:width'] = '500';

                $imagetype = $this->getImageType($this->_post->sq->og_media);
                if ($imagetype) {
                    $og['og:image:type'] = $imagetype;
                }

                if ($og['og:type'] == 'video') {
                    $this->_setMedia($og);
                }
            } else {
                $this->_setMedia($og);
            }

            //Get the default global image for Open Graph
            if (SQ_Classes_Helpers_Tools::getOption('sq_og_image')) {
                if (!isset($og['og:image'])) {
                    $og['og:image'] = SQ_Classes_Helpers_Tools::getOption('sq_og_image');
                    $og['og:image:width'] = '500';

                    $imagetype = $this->getImageType(SQ_Classes_Helpers_Tools::getOption('sq_og_image'));
                    if ($imagetype) {
                        $og['og:image:type'] = $imagetype;
                    }
                }
            }

            $og['og:site_name'] = get_bloginfo('title');
            $og['og:locale'] = $this->get_locale();

            if ($this->_post->socials->fbadminapp <> '') {
                $og['fb:app_id'] = $this->_post->socials->fbadminapp;
            }

            if (!empty($this->_post->socials->fb_admins)) {
                foreach ($this->_post->socials->fb_admins as $admin) {
                    if (isset($admin->id)) {
                        $og['fb:admins'][] = $admin->id;
                    }
                }
            }

            if ($this->_post->sq->og_type == 'article') {
                if (isset($this->_post->post_date) && $this->_post->post_date <> '') {
                    $og['article:published_time'] = $this->_post->post_date;
                }
                if (isset($this->_post->post_modified) && $this->_post->post_modified <> '') {
                    $og['article:modified_time'] = $this->_post->post_modified;
                }
                if (isset($this->_post->category) && $this->_post->category <> '') {
                    $og['article:section'] = $this->_post->category;
                } else {
                    $category = get_the_category($this->_post->ID);
                    if (!empty($category) && $category[0]->cat_name <> 'Uncategorized') {
                        $og['article:section'] = $category[0]->cat_name;
                    }
                }

                if ($this->_post->sq->keywords <> '') {
                    $keywords = explode(',', $this->_post->sq->keywords);
                }
                if (!empty($keywords)) {
                    foreach ($keywords as $keyword) {
                        $og['article:tag'][] = $keyword;
                    }
                }

                if (SQ_Classes_Helpers_Tools::getOption('sq_keywordtag')) {
                    $posttags = get_the_tags($this->_post->post_id);
                    if (!empty($posttags)) {
                        foreach ($posttags as $tag) {
                            $og['article:tag'][] = $tag->name;
                        }
                    }
                }

            } elseif ($this->_post->post_type == 'profile' && $this->_post->post_author <> '') {
                if (strpos($this->_post->post_author, " ") !== false) {
                    $author = explode(" ", $this->_post->post_author);
                } else {
                    $author = array($this->_post->post_author);
                }
                $og['profile:first_name'] = $author[0];
                if (isset($author[1])) $og['profile:last_name'] = $author[1];
            } elseif ($this->_post->post_type === 'product') {
                if ($this->_post->category <> '') {
                    $og['product:category'] = $this->_post->category;
                }

                global $product;
                if (class_exists('WC_Product') && $product instanceof WC_Product) {
                    $currency = 'USD';
                    $regular_price = $sale_price = $price = $sales_price_from = $sales_price_to = 0;

                    if (method_exists($product, 'get_regular_price')) {
                        $regular_price = $product->get_regular_price();
                    }
                    if (method_exists($product, 'get_sale_price')) {
                        $sale_price = $product->get_sale_price();
                        if ($sale_price > 0 && method_exists($product, 'get_date_on_sale_from') && method_exists($product, 'get_date_on_sale_to')) {
                            $sales_price_from = $product->get_date_on_sale_from();
                            $sales_price_to = $product->get_date_on_sale_to();
                            if (is_a($sales_price_from, 'WC_DateTime') && method_exists($sales_price_from, 'getTimestamp')) {
                                $sales_price_from = $sales_price_from->getTimestamp();
                            }
                            if (is_a($sales_price_to, 'WC_DateTime') && method_exists($sales_price_to, 'getTimestamp')) {
                                $sales_price_to = $sales_price_to->getTimestamp();
                            }
                        }
                    }
                    if (method_exists($product, 'get_price')) {
                        $price = $product->get_price();
                    }

                    if (function_exists('get_woocommerce_currency')) {
                        $currency = get_woocommerce_currency();
                    }

                    if ($regular_price > 0 && $regular_price <> $price) {
                        $og['product:original_price:amount'] = wc_format_decimal($regular_price, wc_get_price_decimals());
                        $og['product:original_price:currency'] = $currency;
                    }

                    if ($price > 0) {
                        $og['product:price:amount'] = wc_format_decimal($price, wc_get_price_decimals());
                        $og['product:price:currency'] = $currency;
                    }

                    if ($sale_price > 0) {
                        $og['product:sale_price:amount'] = wc_format_decimal($sale_price, wc_get_price_decimals());
                        $og['product:sale_price:currency'] = $currency;

                        if ($sales_price_from > 0) {
                            $og['product:sale_price:start'] = date("Y-m-d", $sales_price_from);
                        }
                        if ($sales_price_to) {
                            $og['product:sale_price:end'] = date("Y-m-d", $sales_price_to);
                        }

                    }


                }
            }

        }
        return $og;
    }

    protected function _setMedia(&$og) {
        if ($og['og:type'] == 'video') {
            $videos = $this->getPostVideos();
            if (!empty($videos)) {
                $video = current($videos);
                if ($video <> '') {
                    $video = preg_replace('/(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"\'>\s]+)/si', "https://www.youtube.com/v/$1", $video);

                    $og['og:video'] = $video;
                    $og['og:video:width'] = '500';
                    $og['og:video:height'] = '280';
                }
            }
        } else {
            $images = $this->getPostImages();
            if (!empty($images)) {
                $image = current($images);
                if (isset($image['src'])) {
                    $og['og:image'] = $image['src'];
                    if (isset($image['width'])) {
                        $og['og:image:width'] = $image['width'];
                    }
                    if (isset($image['height'])) {
                        $og['og:image:height'] = $image['height'];
                    }

                    $imagetype = $this->getImageType($image['src']);
                    if ($imagetype) {
                        $og['og:image:type'] = $imagetype;
                    }
                }
            }
        }
    }

    public function setLocale($locale) {
        //set locale from Squirrly > Settings > Social Media > Locale
        $locale = SQ_Classes_Helpers_Tools::getOption('sq_og_locale');

        //if WPML is installed, get the local language
        if (function_exists('wpml_get_language_information') && (int)$this->_post->ID > 0) {
            if ($language = wpml_get_language_information((int)$this->_post->ID)) {
                if (!is_wp_error($language) && isset($language['locale'])) {
                    if ($locale <> 'en') {
                        $locale = $language['locale'];
                    }
                }
            }
        }

        return $locale;
    }

    /**
     * Retrieves the current locale.
     *
     * If the locale is set, then it will filter the locale in the {@see 'locale'}
     * filter hook and return the value.
     *
     * If the locale is not set already, then the WPLANG constant is used if it is
     * defined. Then it is filtered through the {@see 'locale'} filter hook and
     * the value for the locale global set and the locale is returned.
     *
     * The process to get the locale should only be done once, but the locale will
     * always be filtered using the {@see 'locale'} hook.
     *
     * @since 1.5.0
     *
     * @global string $locale
     * @global string $wp_local_package
     *
     * @return string The locale of the blog or from the {@see 'locale'} hook.
     */
    function get_locale() {
        global $locale, $wp_local_package;

        if (isset($locale)) {
            /**
             * Filters the locale ID of the WordPress installation.
             *
             * @since 1.5.0
             *
             * @param string $locale The locale ID.
             */
            return apply_filters('sq_locale', $locale);
        }

        if (isset($wp_local_package)) {
            $locale = $wp_local_package;
        }

        // WPLANG was defined in wp-config.
        if (defined('WPLANG')) {
            $locale = WPLANG;
        }

        // If multisite, check options.
        if (is_multisite()) {
            // Don't check blog option when installing.
            if (wp_installing() || (false === $ms_locale = get_option('WPLANG'))) {
                $ms_locale = get_site_option('WPLANG');
            }

            if ($ms_locale !== false) {
                $locale = $ms_locale;
            }
        } else {
            $db_locale = get_option('WPLANG');
            if ($db_locale !== false) {
                $locale = $db_locale;
            }
        }

        if (empty($locale)) {
            $locale = 'en_US';
        }

        /** This filter is documented in wp-includes/l10n.php */
        return apply_filters('sq_locale', $locale);
    }

    /**
     * Pack the OpenGraph to meta format
     * @param array $og
     * @return bool|string
     */
    public function packOpenGraph($og = array()) {
        if (!empty($og)) {
            foreach ($og as $key => &$value) {
                if (is_array($value)) {
                    $str = '';
                    foreach ($value as $subvalue) {
                        $str .= '<meta property="' . $key . '" content="' . $subvalue . '" />' . ((count((array)$value) > 1) ? "\n" : '');
                    }
                    $value = $str;
                } else {
                    $value = '<meta property="' . $key . '" content="' . $value . '" />';
                }
            }
            return "\n" . join("\n", array_values($og));
        }

        return false;
    }

}