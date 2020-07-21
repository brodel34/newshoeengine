<?php
/**
 * Wolf WPBakery Page Builder Extension Theme functions
 *
 * Theme specific functions
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
 * Check if the theme is right
 *
 * @return bool
 */
function wvc_is_right_theme() {

	$right_themes = array( 'wolf-lite', 'protheme', 'loud', 'iyo', 'tune' );

	return in_array( wvc_get_theme_slug(), $right_themes );
}

/**
 * Add logo SVG customizer option
 */
function wvc_add_svg_logo_mod( $mods ) {

	$logo_options = array(
		'id' => 'logo_svg',
		'label' => esc_html__( 'Logo SVG', 'wolf-visual-composer' ),
		'type' => 'image',
		'description' => esc_html__( 'You don\'t need to upload a dark and light version for your logo if you upload an SVG file. The SVG format can contain unsecured content. Be sure that the file you download is safe.', 'wolf-visual-composer' ),
	);

	$mods['logo']['options']['logo_svg'] = $logo_options;

	return $mods;
}
add_filter( 'wolftheme_customizer_mods', 'wvc_add_svg_logo_mod', 11 );
add_filter( wvc_get_theme_slug() . '_customizer_mods', 'wvc_add_svg_logo_mod', 11 );