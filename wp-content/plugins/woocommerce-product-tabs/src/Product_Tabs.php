<?php

namespace Barn2\Plugin\WC_Product_Tabs_Free;

use Barn2\Plugin\WC_Product_Tabs_Free\Dependencies\Lib\Registerable;
use Barn2\Plugin\WC_Product_Tabs_Free\Dependencies\Lib\Service\Standard_Service;
use WP_Embed;

/**
 * Show the tabs on the single product page
 *
 * @package   Barn2/woocommerce-product-tabs
 * @author    Barn2 Plugins <info@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Product_Tabs implements Registerable, Standard_Service {

	private $product_tabs_list;

	public function register() {
		// Public custom hooks
		add_filter( 'woocommerce_product_tabs', [ $this, 'custom_woocommerce_product_tabs' ], 20 );
		add_filter( 'wc_quick_view_pro_quick_view_tabs_enabled', [ $this, 'custom_woocommerce_product_tabs' ], 20 );

		add_filter( 'wpt_filter_product_tabs', [ $this, 'tab_status_check' ] );

		if ( $this->enable_the_content_filter() ) {
			add_filter( 'wpt_use_the_content_filter', '__return_false' );
			add_filter( 'wpt_filter_tab_content', [ $this, 'product_tabs_filter_content' ], 10, 1 );
		}
	}

	public function custom_woocommerce_product_tabs( $tabs ) {
		global $product;

		$this->product_tabs_list = get_posts(
			[
				'post_type'      => 'woo_product_tab',
				'posts_per_page' => -1,
				'orderby'        => 'menu_order',
				'order'          => 'asc',
				'suppress_filters' => 0
			]
		);

		if ( ! empty( $this->product_tabs_list ) ) {
			foreach ( $this->product_tabs_list as $key => $t ) {
				$this->product_tabs_list[ $key ]->post_meta = get_post_meta( $this->product_tabs_list[ $key ]->ID );
			}
		}

		if ( empty( $this->product_tabs_list ) ) {
			return $tabs;
		}

		$wpt_tabs = [];
		foreach ( $this->product_tabs_list as $key => $prd ) {
			$wpt_tabs[ $key ]['id']                  = $prd->post_name;
			$wpt_tabs[ $key ]['title']               = esc_attr( $prd->post_title );
			$wpt_tabs[ $key ]['priority']            = esc_attr( $prd->menu_order );
			$wpt_tabs[ $key ]['conditions_category'] = get_post_meta( $prd->ID, '_wpt_conditions_category', true );
			$wpt_tabs[ $key ]['display_globally']    = esc_attr( Util::is_tab_global( $prd->ID ) );
		}

		$wpt_tabs = apply_filters( 'wpt_filter_product_tabs', $wpt_tabs );

		if ( ! empty( $wpt_tabs ) ) {

			foreach ( $wpt_tabs as $key => $tab ) {
				$tab_temp             = [];
				$tab_temp['title']    = $tab['title'];
				$tab_temp['priority'] = $tab['priority'];
				$tab_temp['callback'] = [ $this, 'callback' ];
				$tabs[ $tab['id'] ]   = $tab_temp;
			}
		}

		return $tabs;
	}

	public function tab_status_check( $tabs ) {

		global $product;

		if ( ! empty( $tabs ) && is_array( $tabs ) ) {

			foreach ( $tabs as $tab_key => $tab ) {
				$key = $tab['id'];

				$tab_post = get_page_by_path( $key, OBJECT, 'woo_product_tab' );

				if ( ! empty( $tab_post ) ) {

					$tab_default_value = $tab_post->post_content;

					$content_to_show = $tab_default_value;

					if ( Util::is_tab_overridden( $key, $product->get_id() ) ) {
						$tab_value = get_post_meta( $product->get_id(), '_wpt_field_' . $key, true );
						if ( ! empty( $tab_value ) ) {
							$content_to_show = $tab_value;
						}
					}

					if ( empty( $content_to_show ) ) {
						unset( $tabs[ $tab_key ] );
					}

					if ( ! empty( $tab['conditions_category'] ) && isset( $tabs[ $tab_key ] ) && $tab['display_globally'] === 'no' ) {

						$conditions_categories = Util::get_all_categories( $tab['conditions_category'] );

						// check category condition
						$cat_list = wp_get_post_terms( $product->get_id(), 'product_cat', [ 'fields' => 'ids' ] );

						if ( ! array_intersect( $cat_list, $conditions_categories ) ) {
							unset( $tabs[ $tab_key ] );
						}
					}
				}
			} // end foreach
		}
		return $tabs;
	}

	public function callback( $key, $tab ) {
		global $product;

		$tab_post = get_page_by_path( $key, OBJECT, 'woo_product_tab' );
		if ( empty( $tab_post ) ) {
			return;
		}

		$override_content = Util::is_tab_overridden( $key, $product->get_id() );

		if ( ! $override_content ) {
			// Display default tab content.
			echo $this->get_filter_content( $tab_post->post_content );
		} else {
			$tab_value = get_post_meta( $product->get_id(), '_wpt_field_' . $key, true );
			echo $this->get_filter_content( $tab_value );
		}
	}

	/**
	 * Filter the tab content.
	 *
	 * @param string $content Content for the current tab.
	 * @return string Tab content.
	 * @since 2.0.2
	 */
	public function product_tabs_filter_content( $content ) {
		$content = function_exists( 'capital_P_dangit' ) ? capital_P_dangit( $content ) : $content;
		$content = function_exists( 'wptexturize' ) ? wptexturize( $content ) : $content;
		$content = function_exists( 'convert_smilies' ) ? convert_smilies( $content ) : $content;
		$content = function_exists( 'wpautop' ) ? wpautop( $content ) : $content;
		$content = function_exists( 'shortcode_unautop' ) ? shortcode_unautop( $content ) : $content;
		$content = function_exists( 'prepend_attachment' ) ? prepend_attachment( $content ) : $content;
		$content = function_exists( 'wp_filter_content_tags' ) ? wp_filter_content_tags( $content ) : $content;
		$content = function_exists( 'do_shortcode' ) ? do_shortcode( $content ) : $content;

		if ( class_exists( 'WP_Embed' ) ) {
			$embed   = new \WP_Embed();
			$content = method_exists( $embed, 'autoembed' ) ? $embed->autoembed( $content ) : $content;
		}

		return $content;
	}

	/**
	 * Get filter for the content.
	 *
	 * @param string $content Content to apply filter.
	 * @return string $content Tab content.
	 * @since 2.0.2
	 */
	public function get_filter_content( $content ) {
		$use_the_content_filter = apply_filters( 'wpt_use_the_content_filter', true );

		if ( $use_the_content_filter === true ) {
			$content = apply_filters( 'the_content', $content );
		} else {
			$content = apply_filters( 'wpt_filter_tab_content', $content );
		}
		return $content;
	}

	/**
	 * Check to enable custom filter for the content.
	 *
	 * @since 2.0.2
	 */
	public function enable_the_content_filter() {
		$disable_the_content_filter = Util::get_option( 'disable_content_filter' );
		$output                     = false;

		if ( empty( $disable_the_content_filter ) || $disable_the_content_filter !== '1' ) {
			$output = false;
		} else {
			$output = true;
		}

		return $output;
	}
}
