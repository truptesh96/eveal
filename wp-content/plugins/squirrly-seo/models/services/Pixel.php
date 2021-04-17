<?php

class SQ_Models_Services_Pixel extends SQ_Models_Abstract_Seo {


    public function __construct() {
        parent::__construct();

        if (isset($this->_post->sq->doseo) && $this->_post->sq->doseo) {

            if (!$this->_post->sq->do_fpixel) {
                add_filter('sq_facebook_pixel', array($this, 'returnFalse'));
                return;
            }

            if (function_exists('is_user_logged_in') && is_user_logged_in() && !SQ_Classes_Helpers_Tools::getOption('sq_tracking_logged_users')) {
                return;
            }

            if (SQ_Classes_Helpers_Tools::getOption('sq_auto_amp') && SQ_Classes_Helpers_Tools::isAMPEndpoint()) {
                add_filter('sq_facebook_pixel', array($this, 'returnFalse'));
                add_filter('sq_facebook_pixel_amp', array($this, 'packPixelAMP'), 99);
            }else{
                add_filter('sq_facebook_pixel', array($this, 'generatePixel'));
                add_filter('sq_facebook_pixel', array($this, 'packPixel'), 99);
            }

        } else {
            add_filter('sq_facebook_pixel', array($this, 'returnFalse'));
        }
    }

    public function addOGPrefix($prefix = '') {
        $prefix .= 'og: http://ogp.me/ns#';

        return $prefix;
    }

    public function generatePixel($events = array()) {

        $codes = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('codes')));

        if (isset($codes->facebook_pixel) && $codes->facebook_pixel <> '') {
            $domain = str_replace(array('http://', 'http://', 'www.'), '', get_bloginfo('url'));

            if ($this->isHomePage()) {
                $events[] = array(
                    'type' => 'track',
                    'name' => 'PageView',
                    'params' => array('page' => get_bloginfo('url'), 'domain' => $domain)
                );
            } else {
                if (isset($this->_post->ID)) {
                    $params['content_ids'] = array((string)$this->_post->ID);
                }

                $params['content_type'] = $this->_post->post_type;

                if ($this->_post->post_type == 'category') {
                    $category = get_category(get_query_var('cat'), false);
                    if (isset($category->name)) {
                        $params['content_category'] = $category->name;
                    }
                } elseif ($this->_post->post_type == 'product') {
                    $params['content_name'] = $this->_post->post_title;
                    $cat = get_the_terms($this->_post->ID, 'product_cat');
                    if (!empty($cat) && !is_wp_error($cat)) {
                        $params['content_category'] = $cat[0]->name;
                    }

                    try {
                        if (!empty($_POST) && isset($params['content_ids']) && !empty($params['content_ids']) && isset($params['content_type'])) {
                            if (function_exists('wc_get_product') && function_exists('get_woocommerce_currency')) {
                                foreach ($params['content_ids'] as $product_id) {
                                    if ($product = wc_get_product((int)$product_id)) {
                                        $params['content_name'] = $product->get_name();
                                        $params['value'] = $product->get_price();
                                        $params['currency'] = get_woocommerce_currency();
                                    }
                                }
                            }

                            $events[] = array(
                                'type' => 'track',
                                'name' => 'AddToCart',
                                'params' => $params
                            );
                        }
                    }catch (Exception $e){

                    }

                } elseif ($this->_post->post_type == 'search') {
                    $search = get_search_query(true);
                    if ($search <> '') {
                        $params['search_string'] = $search;
                        $events[] = array(
                            'type' => 'track',
                            'name' => 'Search',
                            'params' => $params
                        );
                    }
                } elseif (function_exists('is_checkout') && is_checkout() && isset($this->_post->ID)) {
                    global $woocommerce;
                    if (isset($woocommerce->cart->total) && $woocommerce->cart->total > 0) {
                        $params['value'] = $woocommerce->cart->total;

                        if (isset($woocommerce->cart->cart_contents) && !empty($woocommerce->cart->cart_contents)) {
                            $quantity = 0;
                            foreach ($woocommerce->cart->cart_contents as $product) {
                                $quantity += $product['quantity'];
                            }
                            if ($quantity > 0) {
                                $params['num_items'] = $quantity;
                            }
                        }
                        $events[] = array(
                            'type' => 'track',
                            'name' => 'InitiateCheckout',
                            'params' => $params
                        );
                    } elseif (SQ_Classes_Helpers_Tools::getIsset('key')) {
                        $params['content_type'] = 'purchase';
                        global $wpdb;

                        if ($post = $wpdb->get_row($wpdb->prepare("SELECT `post_id` FROM `$wpdb->postmeta` WHERE `meta_key` = %s AND `meta_value`= %s", '_order_key', SQ_Classes_Helpers_Tools::getValue('key')))) {

                            if ($order = wc_get_order($post->post_id)) {
                                $params['content_type'] = "checkout";
                                $params['value'] = $order->get_total();
                                $params['currency'] = $order->get_order_currency();

                                $events[] = array(
                                    'type' => 'track',
                                    'name' => 'Purchase',
                                    'params' => $params
                                );
                            }
                        }
                    }


                } else {
                    $cat = get_the_terms($this->_post->ID, 'category');
                    if (!empty($cat) && !is_wp_error($cat)) {
                        $params['content_category'] = $cat[0]->name;
                    }
                }

                $params['page'] = $this->_post->url;
                $params['domain'] = $domain;

                if (isset($params['content_ids']) && isset($params['content_type'])) {
                    $events[] = array(
                        'type' => 'track',
                        'name' => 'ViewContent',
                        'params' => $params
                    );
                } else {
                    $events[] = array(
                        'type' => 'trackCustom',
                        'name' => 'GeneralEvent',
                        'params' => $params
                    );
                }

                $events[] = array(
                    'type' => 'track',
                    'name' => 'PageView',
                    'params' => array('page' => $params['page'], 'domain' => $params['domain'])
                );
            }
        }

        return $this->clean($events);
    }

    public function clean($var) {
        if (is_array($var)) {
            return array_map(array($this, 'clean'), $var);
        } else {
            return is_string($var) ? ((strpos($var, '://') !== false) ? esc_url($var) : sanitize_text_field($var)) : $var;
        }
    }

    public function packPixel($events = '') {
        //If custom Facebook Pixel is set
        if ($this->_post->sq->fpixel) {
            return $this->_post->sq->fpixel;
        } else {

            //Compatibility with ACF
            if (SQ_Classes_Helpers_Tools::isPluginInstalled('advanced-custom-fields/acf.php')) {
                if (isset($this->_post->ID) && $this->_post->ID) {
                    if ($_sq_pixel_custom = get_post_meta($this->_post->ID, '_sq_pixel_custom', true)) {
                        if (strpos($_sq_pixel_custom, '<script>') !== false) {
                            return $_sq_pixel_custom;
                        }else{
                            return '<script>' . $_sq_pixel_custom . '</script>';
                        }
                    }
                }
            }

            if (!empty($events)) {
                $codes = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('codes')));

                $track = '';
                foreach ($events as $event) {
                    $track .= "fbq('" . $event['type'] . "', '" . $event['name'] . "', '" . wp_json_encode($event['params']) . "');";
                }

                return sprintf("<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init', '%s');%s</script><noscript><img height='1' width='1' style='display:none'src='https://www.facebook.com/tr?id=%s&ev=PageView&noscript=1'/></noscript>" . "\n", $codes->facebook_pixel, $track, $codes->facebook_pixel);
            }
        }

        return false;
    }


    public function packPixelAMP() {
        $codes = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('codes')));

        if (isset($codes->facebook_pixel) && $codes->facebook_pixel <> '') {
            $events = $this->generatePixel();
            $track = '';

            foreach ($events as $event) {
                if (isset($event['params'])) {
                    $cd = '';
                    foreach ($event['params'] as $key => $value) {
                        if (is_array($value) && !empty($value)) {
                            $cd .= sprintf('&cd[%s]=%s', $key, join(',', $value));
                        } else {
                            $cd .= sprintf('&cd[%s]=%s', $key, urlencode($value));
                        }
                    }
                }
                $track .= sprintf('<amp-pixel src="https://www.facebook.com/tr?id=%s&ev=%s%s&noscript=1"></amp-pixel>', $codes->facebook_pixel, $event['name'], $cd) . "\n";

            }

            return $track;
        }

        return false;
    }
}