<?php
/**
 * Prequelle background_image
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function prequelle_set_background_image_mods( $mods ) {
	$mods['background_image'] = array(
		'icon' => 'format-image',
		'id' => 'background_image',
		'title' => esc_html__( 'Background Image', 'prequelle' ),
		'options' => array(),
	);

	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_background_image_mods' );