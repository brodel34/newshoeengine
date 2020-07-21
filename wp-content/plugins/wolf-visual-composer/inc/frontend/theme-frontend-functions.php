<?php
/**
 * Wolf WPBakery Page Builder Extension Theme functions
 *
 * Theme specific functions to use on frontend
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Remove scripts
 */
function wvc_remove_vc_scripts() {

	$theme_slug = sanitize_title_with_dashes( get_template() );
	if ( wvc_is_right_theme() ) {
		wp_dequeue_script( 'swipebox' );
		wp_deregister_script( 'swipebox' );
		wp_dequeue_style( 'swipebox' );
		wp_deregister_style( 'swipebox' );
	}

}
add_action( 'wp_enqueue_scripts', 'wvc_remove_vc_scripts', 100 );