<?php
/**
 * Wolf WPBakery Page Builder Extension Tiny MCE shortcode.
 *
 * @class WVC_Tiny_Mce_Shortcodes
 * @author WolfThemes
 * @category Admin
 * @package WolfVisualComposer/Admin
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Main WVC_Tiny_Mce_Shortcodes Class
 *
 * Contains the main functions for WVC_Tiny_Mce_Shortcodes
 *
 * @class WVC_Tiny_Mce_Shortcodes
 * @package Wolf WPBakery Page Builder Extension
 * @author WolfThemes
 */
class WVC_Tiny_Mce_Shortcodes {

	/**
	 * WVC_Tiny_Mce_Shortcodes Constructor.
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'mce_init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Registers TinyMCE rich editor buttons.
	 */
	public function mce_init() {

		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
			return;
		}

		if ( 'true' == get_user_option( 'rich_editing' ) ) {
			add_filter( 'mce_external_plugins', array( $this, 'add_plugin' ) );
			add_filter( 'mce_buttons', array( $this, 'register_button' ) );
			add_filter( 'tiny_mce_before_init', array( $this, 'font_list' ) );
		}
	}

	/**
	 * Defines TinyMCE rich editor js plugin.
	 *
	 * @param array $plugin_array
	 */
	public function add_plugin( $plugin_array ) {

		$plugin_array['WVCShortcodesTinyMce'] = esc_url( WVC_URI . '/inc/admin/tinymce/plugin.js' );

		return $plugin_array;
	}

	/**
	 * Adds TinyMCE rich editor buttons.
	 *
	 * @param array $button
	 */
	public function register_button( $buttons ) {
		$buttons[] = 'wvc_shortcodes_tiny_mce_button';
		$buttons[] = 'fontselect';
		$buttons[] = 'fontsizeselect';
		return $buttons;
	}

	/**
	 * Adds google font dropdown
	 *
	 * @param array $params
	 */
	public function font_list( $params ) {

		$wvc_google_fonts = apply_filters( 'wvc_fonts', wvc_get_google_fonts_options(), 20 );

		$fonts = '';

		if ( is_array( $wvc_google_fonts ) ) {
			foreach ( $wvc_google_fonts as $key => $value ) {
				if ( '' != $value ) {
					$fonts .= "$key=$key;";
				}
			}
		}

		$params['font_formats'] = $fonts;

		return $params;
	}

	/**
	 * Register/queue admin scripts.
	 */
	public function admin_scripts() {

		wp_localize_script( 'jquery', 'WVC_Tiny_Mce', array( 'plugin_folder' => WVC_URI . '/inc/admin/tinymce/' ) );

		wp_enqueue_script( 'wpb-tinymce', WVC_JS . '/admin/tinymce.js', array( 'jquery' ), WVC_VERSION, true );
		wp_localize_script(
			'wpb-tinymce', 'WVCTinyMceParams', array(
				'anchor' => esc_html__( 'Anchor', 'wolf-visual-composer' ),
				'dropcap' => esc_html__( 'Dropcap', 'wolf-visual-composer' ),
				'button' => esc_html__( 'Button', 'wolf-visual-composer' ),
				'alert' => esc_html__( 'Notifications', 'wolf-visual-composer' ),
				'highlight' => esc_html__( 'Highlight', 'wolf-visual-composer' ),
				'spacer' => esc_html__( 'Spacer', 'wolf-visual-composer' ),
				'fittext' => esc_html__( 'Headline', 'wolf-visual-composer' ),
				'socials' => esc_html__( 'Socials', 'wolf-visual-composer' ),
				'fonts' => esc_html__( 'Fonts', 'wolf-visual-composer' ),
				'insertText' => esc_html__( 'Insert a shortcode', 'wolf-visual-composer' ),
			)
		);
	}
} // end class

return new WVC_Tiny_Mce_Shortcodes();