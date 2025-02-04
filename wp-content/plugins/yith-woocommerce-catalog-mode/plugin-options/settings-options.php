<?php
/**
 * Base settings options tab
 *
 * @package YITH\CatalogMode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

return array(
	'settings' => array(
		'step_one_title'          => array(
			'name' => esc_html__( 'Settings', 'yith-woocommerce-catalog-mode' ),
			'type' => 'title',
		),
		'catalog_mode_admin_view' => array(
			'name'      => esc_html__( 'Catalog mode for administrators', 'yith-woocommerce-catalog-mode' ),
			'type'      => 'yith-field',
			'yith-type' => 'onoff',
			'desc'      => esc_html__( 'If enabled, the Catalog Mode rules will also work for admin users.', 'yith-woocommerce-catalog-mode' ),
			'id'        => 'ywctm_admin_view',
			'default'   => 'yes',
		),
		'disable_shop'            => array(
			'name'      => esc_html__( 'Disable shop', 'yith-woocommerce-catalog-mode' ),
			'type'      => 'yith-field',
			'yith-type' => 'onoff',
			'desc'      => esc_html__( 'Use this option to hide the "Cart" page, "Checkout" page and all the "Add to Cart" buttons in the shop.', 'yith-woocommerce-catalog-mode' ),
			'id'        => 'ywctm_disable_shop',
			'default'   => 'no',
		),
		'hide_add_to_cart'        => array(
			'type'      => 'yith-field',
			'yith-type' => 'inline-fields',
			'name'      => esc_html__( 'Hide "Add to Cart" in:', 'yith-woocommerce-catalog-mode' ),
			'desc'      => esc_html__( 'Choose where to hide "Add to Cart".', 'yith-woocommerce-catalog-mode' ),
			'id'        => 'ywctm_hide_add_to_cart_settings',
			'fields'    => array(
				'action' => array(
					'std'  => 'hide',
					'type' => 'hidden',
				),
				'where'  => array(
					'options' => array(
						'all'     => esc_html__( 'All pages', 'yith-woocommerce-catalog-mode' ),
						'shop'    => esc_html__( 'Shop page', 'yith-woocommerce-catalog-mode' ),
						'product' => esc_html__( 'Product page', 'yith-woocommerce-catalog-mode' ),
					),
					'std'     => 'all',
					'type'    => 'select',
				),
				'items'  => array(
					'std'  => 'all',
					'type' => 'hidden',
				),
			),
			'deps'      => array(
				'id'    => 'ywctm_disable_shop',
				'value' => 'no',
				'type'  => 'hide-disable',
			),
			'class'     => 'ywctm-inline-selects',
		),
		'hide_variations'         => array(
			'name'      => esc_html__( 'Hide product variations', 'yith-woocommerce-catalog-mode' ),
			'type'      => 'yith-field',
			'yith-type' => 'onoff',
			'desc'      => esc_html__( 'Use this option to hide product variations where "Add to cart" is hidden.', 'yith-woocommerce-catalog-mode' ),
			'id'        => 'ywctm_hide_variations',
			'default'   => 'no',
		),
		'step_one_end'            => array(
			'type' => 'sectionend',
		),
	),
);
