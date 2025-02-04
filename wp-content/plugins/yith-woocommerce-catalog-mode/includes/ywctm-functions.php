<?php
/**
 * Plugin base functions
 *
 * @package YITH\CatalogMode
 * @author  YITH <plugins@yithemes.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'ywctm_get_theme_name' ) ) {

	/**
	 * Get the current theme name
	 *
	 * @return  string
	 * @since   2.0.0
	 */
	function ywctm_get_theme_name() {
		$wp_theme = wp_get_theme();

		return is_child_theme() ? $wp_theme->get_template() : strtolower( $wp_theme->get( 'Name' ) );
	}
}

/**
 * WPML RELATED FUNCTIONS
 */
if ( ! function_exists( 'ywctm_is_wpml_active' ) ) {

	/**
	 * Check if WPML is active
	 *
	 * @return  boolean
	 * @since   2.0.0
	 */
	function ywctm_is_wpml_active() {
		global $sitepress;

		return ! empty( $sitepress ) ? true : false;
	}
}
