<?php

namespace Barn2\Plugin\WC_Product_Tabs_Free\Admin\Wizard\Steps;

use Barn2\Plugin\WC_Product_Tabs_Free\Dependencies\Setup_Wizard\Steps\Ready;

/**
 * Completed Step.
 *
 * @package   Barn2/woocommerce-product-options
 * @author    Barn2 Plugins <info@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Completed extends Ready {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->set_name( esc_html__( 'Ready', 'woocommerce-product-tabs' ) );
		$this->set_title( esc_html__( 'Complete setup', 'woocommerce-product-tabs' ) );

		$this->set_description( $this->get_custom_description() );
	}

	/**
	 * Retrieves the description.
	 *
	 * @return string
	 */
	private function get_custom_description() {

		return esc_html__( 'Congratulations, you have finished setting up the plugin. You can create additional tabs and choose which categories to display them on.', 'woocommerce-product-tabs' );
	}

}
