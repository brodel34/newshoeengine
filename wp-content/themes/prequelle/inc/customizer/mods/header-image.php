<?php
/**
 * Prequelle header_image
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


function prequelle_set_header_image_mods( $mods ) {

	/* Move header image setting here and rename the section title */
	$mods['header_image'] = array(
		'id' => 'header_image',
		'title' => esc_html__( 'Header Image', 'prequelle' ),
		'icon' => 'format-image',
		'options' => array(),
	);

	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_header_image_mods' );