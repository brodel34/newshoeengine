<?php
/**
 * Prequelle admin scripts
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Admin scripts
 */
function prequelle_admin_scripts() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : prequelle_get_theme_version();

	/* Admin styles */
	wp_enqueue_style( 'chosen', get_template_directory_uri() . '/assets/js/admin/chosen/chosen.min.css',  array(), '1.1.0' );
	wp_enqueue_style( 'prequelle-admin', get_template_directory_uri() . '/assets/css/admin/admin' . $suffix . '.css', array(), $version );

	/* Admins scripts */
	wp_enqueue_media();
	wp_enqueue_script( 'chosen', get_template_directory_uri() . '/assets/js/admin/chosen/chosen.jquery.min.js', array( 'jquery' ), true, '1.1.0' );
	wp_enqueue_script( 'js-cookie', get_template_directory_uri() . '/assets/js/lib/js.cookie.min.js', array( 'jquery' ), '1.4.1' );

	if ( isset( $_GET['page'] ) && ( $_GET['page'] === prequelle_get_theme_slug() . '-about') ) {
		wp_enqueue_script( 'prequelle-tabs', get_template_directory_uri() . '/assets/js/admin/tabs.js', array( 'jquery' ), $version, true );
	}

	wp_enqueue_script( 'prequelle-admin', get_template_directory_uri() . '/assets/js/admin/admin.js', array( 'jquery', 'jquery-ui-sortable', 'wp-color-picker' ), $version, true );

	/*
	* Check the uer capabilities to avoid enabling the customizer reset button in guest mod with Customizer Preview for Theme Demo plugin
	*/
	if ( current_user_can( 'manage_options' ) ) {
		wp_enqueue_script( 'prequelle-reset-customizer-button', get_template_directory_uri() . '/assets/js/admin/reset-customizer-button' . $suffix . '.js', array( 'jquery' ), $version, true );
	}

	wp_localize_script( 'prequelle-admin', 'PrequelleAdminParams', array(
		'ajaxUrl' => esc_url( admin_url( 'admin-ajax.php' ) ),
		'noResult' => esc_html__( 'No result', 'prequelle' ),
		'resetModsText' => esc_html__( 'Reset', 'prequelle' ),
		'subHeadingPlaceholder' => esc_html__( 'Subheading', 'prequelle' ),
		'confirm' => esc_html__( 'Are you sure to want to reset all mods to default? There is no way back.', 'prequelle' ),
		'nonce' => array(
			'reset' => wp_create_nonce( 'prequelle-customizer-reset' ),
		),
	) );
}
add_action( 'admin_enqueue_scripts', 'prequelle_admin_scripts' );

/**
 * Additional custom CSS
 *
 * @see prequelle_get_theme_uri
 */
function prequelle_admin_custom_css() {

	$css = '';

	$accent = get_theme_mod( 'accent_color' );

	if ( $accent ) {
		$css .= "
			.accent{
				color:$accent;
			}

			.wvc_colored-dropdown .accent{
				background-color:$accent;
				color:#fff;
			}
		";
	}

	if ( is_file( get_template_directory() . '/config/badge.png' ) ) {

		$badge_url = get_template_directory_uri() . '/config/badge.png';

		$css .= "
			.prequelle-about-page-logo{
				background-image: url($badge_url)!important;
			}
		";
	}

	if ( ! SCRIPT_DEBUG ) {
		$css = prequelle_compact_css( apply_filters( 'prequelle_admin_custom_css', $css ) );
	}

	wp_add_inline_style( 'prequelle-admin', $css );
}
add_action( 'admin_enqueue_scripts', 'prequelle_admin_custom_css' );