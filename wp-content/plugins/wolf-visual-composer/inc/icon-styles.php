<?php
/**
 * Wolf WPBakery Page Builder Extension icon styles functions
 *
 * Enqueue icon styles in both frontend and admin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Register Custom Icons CSS to use in frontend conditionaly
 */
function wvc_register_icon_styles() {
	wp_register_style( 'linea-icons', WVC_CSS. '/lib/linea-icons/linea-icons.min.css', array(), '1.0.0' );
	wp_register_style( 'linearicons', WVC_CSS. '/lib/linearicons/linearicons.min.css', array(), '1.0.0' );
	wp_register_style( 'socicon', WVC_CSS. '/lib/socicon/socicon.min.css', array(), '3.5' );
	wp_register_style( 'wolficons', WVC_CSS. '/lib/wolficons/wolficons.min.css', array(), '1.0.0' );
	wp_register_style( 'elegant-icons', WVC_CSS. '/lib/elegant-icons/elegant-icons.min.css', array(), '1.0.0' );
	wp_register_style( 'ionicons', WVC_CSS. '/lib/ionicons/ionicons.min.css', array(), '2.0.0' );
	wp_register_style( 'dripicons', WVC_CSS. '/lib/dripicons/dripicons.min.css', array(), '2.0.0' );

	if ( apply_filters( 'wvc_force_enqueue_scripts', false ) ) {
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'vc_openiconic' );
		wp_enqueue_style( 'vc_typicons' );
		wp_enqueue_style( 'vc_entypo' );
		wp_enqueue_style( 'vc_linecons' );
		wp_enqueue_style( 'vc_material' );
		wp_enqueue_style( 'linea-icons' );
		wp_enqueue_style( 'linearicons' );
		wp_enqueue_style( 'socicon' );
		wp_enqueue_style( 'wolficons' );
		wp_enqueue_style( 'elegant-icons' );
		wp_enqueue_style( 'ionicons' );
		wp_enqueue_style( 'dripicons' );
	}
}
add_action( 'wp_enqueue_scripts', 'wvc_register_icon_styles' );

/**
 * Enqueue Custom Icons CSS
 */
function wvc_admin_icon_styles() {
	wp_enqueue_style( 'linea-icons', WVC_CSS. '/lib/linea-icons/linea-icons.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'linearicons', WVC_CSS. '/lib/linearicons/linearicons.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'socicon', WVC_CSS. '/lib/socicon/socicon.min.css', array(), '3.5' );
	wp_enqueue_style( 'wolficons', WVC_CSS. '/lib/wolficons/wolficons.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'elegant-icons', WVC_CSS. '/lib/elegant-icons/elegant-icons.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'ionicons', WVC_CSS. '/lib/ionicons/ionicons.min.css', array(), '2.0.0' );
	wp_enqueue_style( 'dripicons', WVC_CSS. '/lib/dripicons/dripicons.min.css', array(), '2.0.0' );
}
add_action( 'admin_enqueue_scripts', 'wvc_admin_icon_styles' );