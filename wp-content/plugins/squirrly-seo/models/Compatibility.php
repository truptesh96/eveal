<?php

/**
 * Compatibility with other plugins and themes
 * Class SQ_Models_Compatibility
 */
class SQ_Models_Compatibility {
    /** @var set Woocommerce custom fields */
    public $wc_inventory_fields;
    public $wc_advanced_fields;

    /**
     * Check compatibility for late loading buffer
     */
    public function checkCompatibility() {
        //compatible with other cache plugins
        if (defined('CE_FILE')) {
            add_filter('sq_lateloading', '__return_true');
        }

        //Compatibility with Hummingbird Plugin
        if (SQ_Classes_Helpers_Tools::isPluginInstalled('hummingbird-performance/wp-hummingbird.php')) {
            add_filter('sq_lateloading', '__return_true');
        }

        //Compatibility with Buddypress Plugin
        if (SQ_Classes_Helpers_Tools::isPluginInstalled('buddypress/bp-loader.php')) {
            add_filter('sq_lateloading', '__return_true');
            add_action('template_redirect', array($this, 'setBuddyPressPage'), PHP_INT_MAX);
        }

        //Compatibility with Cachify plugin
        if (SQ_Classes_Helpers_Tools::isPluginInstalled('cachify/cachify.php')) {
            add_filter('sq_lateloading', '__return_true');
        }

        //Compatibility with WP Super Cache plugin
        global $wp_super_cache_late_init;
        if (isset($wp_super_cache_late_init) && $wp_super_cache_late_init == 1 && !did_action('init')) {
            add_filter('sq_lateloading', '__return_true');
        }

        //Compatibility with Ezoic
        if (SQ_Classes_Helpers_Tools::isPluginInstalled('ezoic-integration/ezoic-integration.php')) {
            remove_all_actions('shutdown');
        }

        //Compatibility with BuddyPress plugin
        if (defined('BP_REQUIRED_PHP_VERSION')) {
            add_action('template_redirect', array(SQ_Classes_ObjController::getClass('SQ_Models_Frontend'), 'setPost'), 10);
        }


    }

    public function checkWooCommerce() {
        if (SQ_Classes_Helpers_Tools::isPluginInstalled('woocommerce/woocommerce.php')) {
            $this->wc_inventory_fields = array(
                'mpn' => array(
                    'label' => __('MPN', _SQ_PLUGIN_NAME_),
                    'description' => __('Add Manufacturer Part Number (MPN)', _SQ_PLUGIN_NAME_),
                ),
                'gtin' => array(
                    'label' => __('GTIN', _SQ_PLUGIN_NAME_),
                    'description' => __('Add Global Trade Item Number (GTIN)', _SQ_PLUGIN_NAME_),
                ),
                'ean' => array(
                    'label' => __('EAN (GTIN-13)', _SQ_PLUGIN_NAME_),
                    'description' => __('Add Global Trade Item Number (GTIN) for the major GTIN used outside of North America', _SQ_PLUGIN_NAME_),
                ),
                'upc' => array(
                    'label' => __('UPC (GTIN-12)', _SQ_PLUGIN_NAME_),
                    'description' => __('Add Global Trade Item Number (GTIN) for North America', _SQ_PLUGIN_NAME_),
                ),
                'isbn' => array(
                    'label' => __('ISBN', _SQ_PLUGIN_NAME_),
                    'description' => __('Add Global Trade Item Number (GTIN) for books', _SQ_PLUGIN_NAME_),
                ),
            );
            $this->wc_advanced_fields = array(
                'brand' => array(
                    'label' => __('Brand Name', _SQ_PLUGIN_NAME_),
                    'description' => __('Add Product Brand Name', _SQ_PLUGIN_NAME_),
                ),
            );
            add_action('woocommerce_product_options_inventory_product_data', array($this, 'addWCInventoryFields'));

            if (!SQ_Classes_Helpers_Tools::isPluginInstalled('perfect-woocommerce-brands/perfect-woocommerce-brands.php') &&
                !SQ_Classes_Helpers_Tools::isPluginInstalled('yith-woocommerce-brands-add-on/init.php')) {
                add_action('woocommerce_product_options_advanced', array($this, 'addWCAdvancedFields'));
            }

            add_filter('sq_seo_before_save', array($this, 'saveWCCustomFields'), 11, 2);

        }
    }

    public function saveWCCustomFields($sq, $post_id) {

        if ($post_id) {
            $sq_woocommerce = array();
            foreach ($this->wc_inventory_fields as $field => $details) {
                if ($value = SQ_Classes_Helpers_Tools::getValue('_sq_wc_' . $field, false)) {
                    $sq_woocommerce[$field] = $value;
                }
            }
            foreach ($this->wc_advanced_fields as $field => $details) {
                if ($value = SQ_Classes_Helpers_Tools::getValue('_sq_wc_' . $field, false)) {
                    $sq_woocommerce[$field] = $value;
                }
            }
            if (!empty($sq_woocommerce)) {
                update_post_meta($post_id, '_sq_woocommerce', $sq_woocommerce);
            }
        }

        return $sq;
    }

    /**
     * Add the custom fields in WooCommerce Inventory section
     */
    public function addWCInventoryFields() {
        global $post;

        if (!isset($post->ID)) {
            return;
        }

        //Get the meta values
        $sq_woocommerce = get_post_meta($post->ID, '_sq_woocommerce', true);

        if (function_exists('woocommerce_wp_text_input')) {
            foreach ($this->wc_inventory_fields as $field => $details) {
                ?>
                <div class="options_group">
                    <?php woocommerce_wp_text_input(
                        array(
                            'id' => '_sq_wc_' . $field,
                            'value' => (isset($sq_woocommerce[$field]) ? $sq_woocommerce[$field] : ''),
                            'label' => $details['label'],
                            'desc_tip' => true,
                            'description' => $details['description'],
                            'type' => 'text',
                        )
                    ); ?>
                </div>
                <?php
            }
        }
    }

    /**
     * Add the custom fields in WooCommerce Advanced section
     */
    public function addWCAdvancedFields() {
        global $post;

        if (!isset($post->ID)) {
            return;
        }

        //Get the meta values
        $sq_woocommerce = get_post_meta($post->ID, '_sq_woocommerce', true);

        if (function_exists('woocommerce_wp_text_input')) {
            foreach ($this->wc_advanced_fields as $field => $details) {
                ?>
                <div class="options_group">
                    <?php woocommerce_wp_text_input(
                        array(
                            'id' => '_sq_wc_' . $field,
                            'value' => (isset($sq_woocommerce[$field]) ? $sq_woocommerce[$field] : ''),
                            'label' => $details['label'],
                            'desc_tip' => true,
                            'description' => $details['description'],
                            'type' => 'text',
                        )
                    ); ?>
                </div>
                <?php
            }
        }
    }

    /**
     * Set compatibility with BuddyPress
     * Set the page according to BuddyPress slug
     */
    public function setBuddyPressPage() {
        if (function_exists('bp_get_root_slug')) {
            if ($slug = bp_get_root_slug()) {
                if ($page = get_page_by_path($slug)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Frontend')->setPost($page);
                }
            }
        }
    }

    /**
     * Prevent other plugins from loading styles in Squirrly SEO Settings
     * > Only called on Squirrly Settings pages
     */
    public function fixEnqueueErrors() {
        global $sq_fullscreen, $wp_styles;

        //exclude known plugins that affect the layout in Squirrly SEO
        $exclude = array('boostrap',
            'wpcd-admin-js', 'ampforwp_admin_js', '__ytprefs_admin__', 'wpf-graphics-admin-style',
            'wpf_admin_style', 'wpf_bootstrap_script', 'wpf_wpfb-front_script', 'auxin-admin-style',
            'wdc-styles-extras', 'wdc-styles-main', 'wp-color-picker-alpha', //collor picker compatibility
        );

        //dequeue styles and scripts that affect the layout in Squirrly SEO pages
        foreach ($exclude as $name) {
            wp_dequeue_script($name);
            wp_dequeue_style($name);
        }

        //deregister other plugins styles to prevent layout issues in Squirrly SEO pages
        if ($sq_fullscreen) {
            if (isset($wp_styles->registered) && !empty($wp_styles->registered)) {
                foreach ($wp_styles->registered as $name => $style) {
                    if (isset($style->src)
                        && (strpos($style->src, 'wp-content/plugins') !== false || strpos($style->src, 'wp-content/themes') !== false)
                        && strpos($style->src, 'squirrly-seo') === false
                        && strpos($style->src, 'monitor') === false
                        && strpos($style->src, 'debug') === false
                        && strpos($style->src, 'wc-admin') === false
                        && strpos($style->src, 'ma-admin') === false) {
                        wp_deregister_script($name);
                        wp_deregister_style($name);
                    }
                }
            }
        }

    }
}
