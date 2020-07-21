<?php
/**
 * Wolf Share Admin.
 *
 * @class Wolf_Share_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfShare/Admin
 * @version 1.0.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Wolf_Share_Admin class.
 */
class Wolf_Share_Admin {
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
		include_once( 'class-ws-options.php' );
	}

	/**
	 * Admin init
	 */
	public function admin_init_hooks() {

		// Plugin settings link
		add_filter( 'plugin_action_links_' . plugin_basename( WS_PATH ), array( $this, 'settings_action_links' ) );

		// Plugin update notifications
		add_action( 'admin_init', array( $this, 'plugin_update' ) );
	}

	/**
	 * Add settings link in plugin page
	 */
	public function settings_action_links( $links ) {
		$setting_link = array(
			'<a href="' . admin_url( 'themes.php?page=wolf-share-settings' ) . '">' . esc_html__( 'Settings', 'wolf-share' ) . '</a>',
		);
		return array_merge( $links, $setting_link );
	}

	/**
	 * Plugin update
	 */
	public function plugin_update() {

		$plugin_name = WS_SLUG;
		$plugin_slug = WS_SLUG;
		$plugin_path = WS_PATH;
		$remote_path = WS_UPDATE_URL . '/' . $plugin_slug;
		$plugin_data = get_plugin_data( WS_DIR . '/' . WS_SLUG . '.php' );
		$current_version = $plugin_data['Version'];
		include_once( 'class-ws-update.php');
		new Wolf_Share_Update( $current_version, $remote_path, $plugin_path );
	}
}

return new Wolf_Share_Admin();