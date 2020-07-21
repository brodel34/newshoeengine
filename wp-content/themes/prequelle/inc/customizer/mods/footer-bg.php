<?php
/**
 * Prequelle footer_bg
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function prequelle_set_footer_bg_mods( $mods ) {

	$mods['footer_bg'] = array(
		'id' =>'footer_bg',
		'label' => esc_html__( 'Footer Background', 'prequelle' ),
		'background' => true,
		'font_color' => true,
		'icon' => 'format-image',
	);

	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_footer_bg_mods' );