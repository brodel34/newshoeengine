<?php
/**
 * Wolf Gram Admin.
 *
 * @class WG_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfGram/Admin
 * @version 1.5.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WG_Admin class.
 */
class WG_Admin {
	/**
	 * Constructor
	 */
	public function __construct() {

		// Includes files
		$this->includes();

		// Admin init hooks
		$this->admin_init_hooks();
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		include_once( 'class-wg-options.php' );
		include_once( 'wg-admin-functions.php' );
	}

	/**
	 * Admin init
	 */
	public function admin_init_hooks() {

		add_filter( 'plugin_action_links_' . plugin_basename( WG_PATH ), array( $this, 'settings_action_links' ) );

		// Plugin update notifications
		add_action( 'admin_init', array( $this, 'plugin_update' ) );
	}

	/**
	 * Add settings link in plugin page
	 */
	public function settings_action_links( $links ) {
		$setting_link = array(
			'<a href="' . admin_url( 'admin.php?page=wolf-gram-options' ) . '">' . esc_html__( 'Settings', 'wolf-gram' ) . '</a>',
		);
		return array_merge( $links, $setting_link );
	}

	/**
	 * Plugin update
	 */
	public function plugin_update() {

		$plugin_name = WG_SLUG;
		$plugin_slug = WG_SLUG;
		$plugin_path = WG_PATH;
		$remote_path = WG_UPDATE_URL . '/' . $plugin_slug;
		$plugin_data = get_plugin_data( WG_DIR . '/' . WG_SLUG . '.php' );
		$current_version = $plugin_data['Version'];
		include_once( 'class-wg-update.php');
		new WG_Update( $current_version, $remote_path, $plugin_path );
	}
}

return new WG_Admin();