<?php
/**
 * Wolf Custom Post Meta Admin.
 *
 * @class Wolf_Custom_Post_Meta_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfCustom Post Meta/Admin
 * @version 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Wolf_Custom_Post_Meta_Admin class.
 */
class Wolf_Custom_Post_Meta_Admin {
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
		include_once( 'class-wcpm-options.php' );
	}

	/**
	 * Admin init
	 */
	public function admin_init_hooks() {

		// Plugin settings link
		add_filter( 'plugin_action_links_' . plugin_basename( WCPM_PATH ), array( $this, 'settings_action_links' ) );

		// Plugin update notifications
		add_action( 'admin_init', array( $this, 'plugin_update' ) );

		// Add columns to post list
		//add_filter( 'manage_posts_custom_column', array( $this, 'admin_columns_head_likes' ) );
		//add_action( 'manage_posts_columns', array( $this, 'admin_columns_content_likes' ) );
	}

	/**
	 * Add settings link in plugin page
	 */
	public function settings_action_links( $links ) {
		$setting_link = array(
			'<a href="' . admin_url( 'themes.php?page=wolf-custom-post-meta-settings' ) . '">' . esc_html__( 'Settings', 'wolf-custom-post-meta' ) . '</a>',
		);
		return array_merge( $links, $setting_link );
	}

	/**
	 * Add thumbnail column head in admin posts list
	 *
	 * @param array $columns
	 * @return array $columns
	 */
	public function admin_columns_head_likes( $columns ) {

		$columns['wolf_likes']   = esc_html__( 'Likes', 'wolf-custom-post-meta' );
		return $columns;
	}

	/**
	 * Add thumbnail column in admin posts list
	 *
	 * @param string $column_name
	 * @param int $post_id
	 */
	public function admin_columns_content_likes( $column_name, $post_id ) {

		$thumbnail = get_the_post_thumbnail();

		if ( 'wolf_likes' === $column_name ) {

			$likes = get_post_meta( get_the_ID(), '_wolf_likes_count', true );

			if ( $likes ) echo absint( $likes );
		}
	}

	/**
	 * Plugin update
	 */
	public function plugin_update() {

		$plugin_name = WCPM_SLUG;
		$plugin_slug = WCPM_SLUG;
		$plugin_path = WCPM_PATH;
		$remote_path = WCPM_UPDATE_URL . '/' . $plugin_slug;
		$plugin_data = get_plugin_data( WCPM_DIR . '/' . WCPM_SLUG . '.php' );
		$current_version = $plugin_data['Version'];
		include_once( 'class-wcpm-update.php');
		new Wolf_Custom_Post_Meta_Update( $current_version, $remote_path, $plugin_path );
	}
}

return new Wolf_Custom_Post_Meta_Admin();