<?php
/*
Plugin Name: Related Products Manager for WooCommerce
Plugin URI: https://wpfactory.com/item/related-products-manager-woocommerce/
Description: Manage related products in WooCommerce, beautifully.
Version: 1.4.4
Author: ProWCPlugins
Author URI: https://prowcplugins.com
Text Domain: related-products-manager-woocommerce
Domain Path: /langs
Copyright: � 2019 ProWCPlugins.com
WC tested up to: 3.7
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Check if WooCommerce is active
$plugin = 'woocommerce/woocommerce.php';
if (
	! in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins', array() ) ) ) &&
	! ( is_multisite() && array_key_exists( $plugin, get_site_option( 'active_sitewide_plugins', array() ) ) )
) {
	return;
}

if ( 'related-products-manager-for-woocommerce.php' === basename( __FILE__ ) ) {
	// Check if Pro is active, if so then return
	$plugin = 'related-products-manager-for-woocommerce-pro/related-products-manager-for-woocommerce-pro.php';
	if (
		in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins', array() ) ) ) ||
		( is_multisite() && array_key_exists( $plugin, get_site_option( 'active_sitewide_plugins', array() ) ) )
	) {
		return;
	}
}

if ( ! class_exists( 'Alg_WC_Related_Products_Manager' ) ) :

/**
 * Main Alg_WC_Related_Products_Manager Class
 *
 * @class   Alg_WC_Related_Products_Manager
 * @version 1.4.0
 * @since   1.0.0
 */
final class Alg_WC_Related_Products_Manager {

	/**
	 * Plugin version.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	public $version = '1.4.4';

	/**
	 * @var   Alg_WC_Related_Products_Manager The single instance of the class
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main Alg_WC_Related_Products_Manager Instance
	 *
	 * Ensures only one instance of Alg_WC_Related_Products_Manager is loaded or can be loaded.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @static
	 * @return  Alg_WC_Related_Products_Manager - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Alg_WC_Related_Products_Manager Constructor.
	 *
	 * @version 1.4.0
	 * @since   1.0.0
	 * @access  public
	 */
	function __construct() {

		// Set up localisation
		load_plugin_textdomain( 'related-products-manager-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/' );

		// Core
		$this->core = require_once( 'includes/class-alg-wc-related-products-manager-core.php' );

		// Admin
		if ( is_admin() ) {
			$this->admin();
		}

	}

	/**
	 * admin.
	 *
	 * @version 1.3.0
	 * @since   1.3.0
	 */
	function admin() {
		// Action links
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'action_links' ) );
		// Settings
		add_filter( 'woocommerce_get_settings_pages', array( $this, 'add_woocommerce_settings_tab' ) );
		require_once( 'includes/settings/class-alg-wc-related-products-manager-settings-per-product.php' );
		require_once( 'includes/settings/class-alg-wc-related-products-manager-settings-section.php' );
		$this->settings = array();
		$this->settings['general'] = require_once( 'includes/settings/class-alg-wc-related-products-manager-settings-general.php' );
		// Version updated
		if ( get_option( 'alg_wc_related_products_manager_version', '' ) !== $this->version ) {
			add_action( 'admin_init', array( $this, 'version_updated' ) );
		}
	}

	/**
	 * Show action links on the plugin screen.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 * @param   mixed $links
	 * @return  array
	 */
	function action_links( $links ) {
		$custom_links = array();
		$custom_links[] = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=alg_wc_related_products_manager' ) . '">' . __( 'Settings', 'woocommerce' ) . '</a>';
		if ( 'related-products-manager-for-woocommerce.php' === basename( __FILE__ ) ) {
			$custom_links[] = '<a href="https://wpfactory.com/item/related-products-manager-woocommerce/">' . __( 'Unlock All', 'related-products-manager-woocommerce' ) . '</a>';
		}
		return array_merge( $custom_links, $links );
	}

	/**
	 * Add Related Products Manager settings tab to WooCommerce settings.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 */
	function add_woocommerce_settings_tab( $settings ) {
		$settings[] = require_once( 'includes/settings/class-alg-wc-settings-related-products-manager.php' );
		return $settings;
	}

	/**
	 * version_updated.
	 *
	 * @version 1.3.0
	 * @since   1.2.0
	 */
	function version_updated() {
		update_option( 'alg_wc_related_products_manager_version', $this->version );
	}

	/**
	 * Get the plugin url.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  string
	 */
	function plugin_url() {
		return untrailingslashit( plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  string
	 */
	function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

}

endif;

if ( ! function_exists( 'alg_wc_related_products_manager' ) ) {
	/**
	 * Returns the main instance of Alg_WC_Related_Products_Manager to prevent the need to use globals.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  Alg_WC_Related_Products_Manager
	 */
	function alg_wc_related_products_manager() {
		return Alg_WC_Related_Products_Manager::instance();
	}
}

alg_wc_related_products_manager();
