<?php
/**
 * Wolf WPBakery Page Builder Extension styles functions
 *
 * Enqueue styles in the frontend
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Frontend
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Enqueue CSS
 *
 * @since Wolf WPBakery Page Builder Extension 1.0
 */
function wvc_enqueue_styles() {

	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : WVC_VERSION;
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	if ( defined( 'AUTOPTIMIZE_PLUGIN_DIR' ) ) {
		$suffix = '';
	}

	/*
	* animate.css
	* @link https://daneden.github.io/animate.css/
	*/
	wp_register_style( 'animate-css', WVC_CSS . '/lib/animate.min.css', array(), '3.3.0' );

	/*
	* aos
	* @link https://github.com/michalsnik/aos
	*/
	wp_register_style( 'aos', WVC_CSS . '/lib/aos.css', array(), '2.3.0' );
	wp_enqueue_style( 'swipebox', WVC_CSS. '/lib/swipebox.min.css', array(), '1.3.0' );
	wp_enqueue_style( 'flexslider' ); // be sure that flexslider CSS file is enqueue BEFORE our plugin styles
	wp_enqueue_style( 'flickity', WVC_CSS . '/lib/flickity.min.css', array(), '2.2.0' );
	wp_enqueue_style( 'lity', WVC_CSS . '/lib/lity.min.css', array(), '2.2.2' );
	if ( apply_filters( 'wvc_force_enqueue_scripts', false ) ) {
		wp_enqueue_style( 'animate-css' );
	}
	wp_enqueue_style( 'wvc-styles', WVC_CSS . '/wvc' . $suffix . '.css', array(), $version );
}
add_action( 'wp_enqueue_scripts', 'wvc_enqueue_styles' );