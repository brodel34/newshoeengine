<?php
/**
 * Wolf WPBakery Page Builder Extension Admin.
 *
 * @class WVC_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfVisualComposer/Admin
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WVC_Admin class.
 */
class WVC_Admin {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'update' ), 0 );
		add_action( 'init', array( $this, 'includes' ), 0 );
		add_action( 'admin_init', array( $this, 'plugin_update' ) );
	}

	/**
	 * Perform actions on updating the theme id needed
	 */
	public function update() {

		if ( ! defined( 'IFRAME_REQUEST' ) && ! defined( 'DOING_AJAX' ) && ( get_option( 'wolf_vc_version' ) != WVC_VERSION ) ) {
			do_action( 'wolf_vc_do_update' );
			delete_option( 'wolf_vc_version' );
			add_option( 'wolf_vc_version', WVC_VERSION );
			do_action( 'wolf_vc_updated' );
		}
	}

	/**
	 * Add settings link in plugin page
	 */
	public function settings_action_links( $links ) {
		$setting_link = array(
			'<a href="' . admin_url( 'admin.php?page=wolf-vc-settings' ) . '">' . esc_html__( 'Settings', 'wolf-visual-composer' ) . '</a>',
		);
		return array_merge( $links, $setting_link );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		include_once( 'admin-author-functions.php' );
		include_once( 'admin-utility-functions.php' );
		include_once( 'admin-option-functions.php' );
		include_once( 'admin-scripts.php' );
		include_once( 'admin-update.php' );
		include_once( 'class-options.php' );
		include_once( 'admin-options.php' );
		include_once( 'class-tiny-mce-shortcodes.php' );
	}

	/**
	 * Include element files
	 */
	public function include_elements() {
		$elements_slugs = wvc_get_element_list();

		foreach ( $elements_slugs as $slug ) {

			include_once( wvc_locate_file( 'elements/' . sanitize_title_with_dashes( $slug ) . '.php' ) );
		}
	}

	/**
	 * Plugin update
	 */
	public function plugin_update() {
		$plugin_slug = WVC_SLUG;
		$plugin_path = WVC_PATH;
		$remote_path = WVC_UPDATE_URL . '/' . $plugin_slug;
		$plugin_data = get_plugin_data( WVC_DIR . '/' . WVC_SLUG . '.php' );
		$current_version = $plugin_data['Version'];
		include_once( 'class-update.php');
		new WVC_Update( $current_version, $remote_path, $plugin_path );
	}
}

return new WVC_Admin();