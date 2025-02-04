<?php

namespace Barn2\Plugin\WC_Product_Tabs_Free\Admin;

use Barn2\Plugin\WC_Product_Tabs_Free\Dependencies\Lib\Conditional;
use Barn2\Plugin\WC_Product_Tabs_Free\Dependencies\Lib\Plugin\Plugin;
use Barn2\Plugin\WC_Product_Tabs_Free\Dependencies\Lib\Admin\Settings_Util;
use Barn2\Plugin\WC_Product_Tabs_Free\Dependencies\Lib\Registerable;
use Barn2\Plugin\WC_Product_Tabs_Free\Dependencies\Lib\Service\Standard_Service;
use Barn2\Plugin\WC_Product_Tabs_Free\Dependencies\Lib\Util as Lib_Util;
use Barn2\Plugin\WC_Product_Tabs_Free\Util;

/**
 * The settings page.
 *
 * @package   Barn2\woocommerce-product-tabs
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Settings_Page implements Standard_Service, Registerable, Conditional {

	/**
	 * Plugin handling the page.
	 *
	 * @var Plugin
	 */
	public $plugin;

	/**
	 * List of settings.
	 *
	 * @var array
	 */
	public $registered_settings = [];

	/**
	 * Constructor.
	 *
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_required() {
		return Lib_Util::is_admin();
	}

	/**
	 * {@inheritdoc}
	 */
	public function register() {
		add_filter( 'in_admin_header', [ $this, 'in_admin_header' ] );
		add_action( 'admin_menu', [ $this, 'register_product_tab_menu' ] );
		add_action( 'admin_init', [ $this, 'register_plugin_option_fields' ] );
		add_filter( 'barn2_plugin_settings_help_links', [ $this, 'change_support_url' ], 10, 2 );
	}

	public function in_admin_header( $actions ) {
		$current_screen = get_current_screen();

		if ( $current_screen->id !== 'edit-woo_product_tab' ) {
			return;
		}

		echo $this->get_wta_admin_header_html();
	}

	public function get_wta_admin_header_html() {
		?>
		<div class="woocommerce-product-tabs-layout__header">
			<div class="woocommerce-product-tabs-layout__header-wrapper">
				<h3 class="woocommerce-product-tabs-layout__header-heading">
					Product Tabs
				</h3>
				<div class="links-area">
					<?php $this->support_links(); ?>
				</div>
			</div>
		</div>

		<h2 class="woocommerce-product-tabs-nav-tab-wrapper">
			<a href="<?php echo admin_url( 'edit.php?post_type=woo_product_tab' ); ?>" class="nav-tab nav-tab-active">Product Tabs</a>
			<a href="<?php echo admin_url( 'admin.php?page=wta_settings' ); ?>" class="nav-tab">Settings</a>
		</h2>
		<?php
	}

	/**
	 * Output the Barn2 Support Links.
	 */
	public function support_links(): void {
		printf(
			'<p>%s %s</p>',
			Settings_Util::get_help_links( $this->plugin ),
			''
		);
	}

	public function get_settings_page_footer() {
		do_action( 'barn2_after_plugin_settings', $this->plugin->get_id() );
		?>
		</div><!-- .tabs-stage -->

		</div><!-- #post-body-content -->

		</div><!-- #post-body -->
		</div><!-- #poststuff -->

		</div><!-- .wrap -->
		<?php
	}

	/**
	 * Add Menu Page Reorder.
	 *
	 * @since 1.0.0
	 */
	function register_product_tab_menu() {
		add_submenu_page(
			'wpt-options',
			__( 'Settings - Product Tabs', 'woocommerce-product-tabs' ),
			__( 'Settings', 'woocommerce-product-tabs' ),
			'manage_options',
			'wta_settings',
			[ $this, 'admin_product_tabs_options_page' ]
		);
	}

	function register_plugin_option_fields() {
		register_setting( 'wpt_group', 'wpt_options', 'validate_plugin_options' );
		add_settings_section( 'wpt_option_section', __( 'Tab options', 'woocommerce-product-tabs' ), [], 'wpt-options' );
		add_settings_field( 'disable_content_filter', __( 'Page builder support', 'woocommerce-product-tabs' ), [ $this, 'disable_content_filter' ], 'wpt-options', 'wpt_option_section' );
		add_settings_field(
			'delete_data',
			__( 'Uninstalling ' . $this->plugin->get_name(), 'woocommerce-product-tabs' ),
			[ $this, 'delete_data' ],
			'wpt-options',
			'wpt_option_section'
		);
	}

	/**
	 * Register disable_content_filter field.
	 *
	 * @since 1.0.0
	 */
	function disable_content_filter() {
		$disable_content_filter = Util::get_option( 'disable_content_filter' );
		?>
		<label for="disable_content_filter">
		<input type="checkbox" name="wpt_options[disable_content_filter]" id="disable_content_filter" value="1" <?php checked( 1, $disable_content_filter ); ?> />
		<?php esc_html_e( 'Enable compatibility mode for page builders', 'woocommerce-product-tabs' ); ?>
		<span data-tip="<?php _e( 'Enable this if you have problems displaying tab content correctly using a page builder', 'woocommerce-product-tabs' ); ?>" class="barn2-help-tip"></span>
		</label>
		<?php
	}

	public function get_settings_page_header( $current ) {
		$message = '';
		if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] === 'true' ) {
			$message = '<div id="message" class="notice notice-success updated inline is-dismissible"><p><strong>Your settings have been saved.</strong></p></div>';
		}
		do_action( 'barn2_before_plugin_settings', $this->plugin->get_id() );

		?>
		<div class="woocommerce-product-tabs-layout__header">
			<div class="woocommerce-product-tabs-layout__header-wrapper">
				<h3 class="woocommerce-product-tabs-layout__header-heading">
					<?php _e( 'Product Tabs', 'woocommerce-product-tabs' ); ?>
				</h3>
				<div class="links-area">
					<?php $this->support_links(); ?>
				</div>
			</div>
		</div>
		<div class="wrap wpt-options barn2-settings">

		<div id="poststuff">

			<div id="post-body" class="metabox-holder">

			<div id="post-body-content">
				<div class="tabs-stage">
				<h2 class="woocommerce-product-tabs-nav-tab-wrapper">
					<a href="<?php echo admin_url( 'edit.php?post_type=woo_product_tab' ); ?>" class="nav-tab">Product Tabs</a>
					<a href="<?php echo admin_url( 'admin.php?page=wta_settings' ); ?>" class="nav-tab <?php echo $current === 'wta_settings' ? 'nav-tab-active' : ''; ?>">Settings</a>
				</h2>
		<?php
		echo $message;
	}

	function admin_product_tabs_options_page() {
		$this->get_settings_page_header( 'wta_settings' );
		?>
		<div id="tab-settings" class="meta-box-sortables tab-ui-sortable">
			<div>
				<div class="inside">
					<form action="options.php" method="post">
					<?php settings_fields( 'wpt_group' ); ?>
					<?php do_settings_sections( 'wpt-options' ); ?>
					<?php submit_button( __( 'Save Changes', 'woocommerce-product-tabs' ) ); ?>
					</form>

					<div class="upgrade-to-pro">
						<h3><?php _e( 'Advanced options for your product tabs', 'woocommerce-product-tabs' ); ?></h3>
						<p>For additional settings, you can upgrade to the <a target="_blank" href="https://barn2.com/wordpress-plugins/woocommerce-product-tabs/?utm_source=settings&utm_medium=settings&utm_campaign=settingsinline&amp;utm_content=wta-settings">Pro version</a> which has a range of advanced settings, including:</p>
						<ul class="normal-list">
							<li><?php _e( 'Rename the default WooCommerce tabs (Description, Additional Information and Reviews).', 'woocommerce-product-tabs' ); ?></li>
							<li><?php _e( 'Hide or remove the default WooCommerce tabs.', 'woocommerce-product-tabs' ); ?></li>
							<li><?php _e( 'Change the tab order by drag and drop.', 'woocommerce-product-tabs' ); ?></li>
							<li><?php _e( 'Add tab icons.', 'woocommerce-product-tabs' ); ?></li>
							<li><?php _e( 'Display tabs for specific products or tags.', 'woocommerce-product-tabs' ); ?></li>
							<li><?php _e( 'Choose between a horizontal or vertical tab layout.', 'woocommerce-product-tabs' ); ?> </li>
							<li><?php _e( 'Allow customers to search by tab title and tab content.', 'woocommerce-product-tabs' ); ?> </li>
						</ul>
					</div>
				</div><!-- .inside -->
			</div><!-- .postbox -->
		</div>
		<?php
		$this->get_settings_page_footer();
	}

	public function delete_data() {
		echo '<fieldset>';
		$delete_data = Util::get_option( 'delete_data' );
		echo '<label class="checkbox-row" for="delete_data">';
		?>
		<input type="checkbox" name="wpt_options[delete_data]" id="delete_data" value="1" <?php checked( 1, $delete_data ); ?> />
		<?php
		_e( 'Permanently delete all ' . $this->plugin->get_name() . ' settings and data when uninstalling the plugin', 'woocommerce-product-tabs' );
		echo ' </label><br /></fieldset>';
	}

	/**
	 * Change the default support link to the WordPress repository
	 */
	public function change_support_url( $links, $plugin ) {
		if ( $plugin->get_id() === $this->plugin->get_id() ) {
			$links['support']['url'] = 'https://wordpress.org/support/plugin/woocommerce-product-tabs/';
		}
		return $links;
	}
}
