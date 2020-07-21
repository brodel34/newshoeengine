<?php
/**
 * Prequelle extra
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function prequelle_set_extra_mods( $mods ) {

	$mods['extra'] = array(

		'id' => 'extra',
		'title' => esc_html__( 'Extra', 'prequelle' ),
		'icon' => 'plus-alt',
		'options' => array(
			array(
				'label'	=> esc_html__( 'Enable Scroll Animations on Mobile (not recommended)', 'prequelle' ),
				'id'	=> 'enable_mobile_animations',
				'type'	=> 'checkbox',
			),
			array(
				'label'	=> esc_html__( 'Enable Parallax on Mobile (not recommended)', 'prequelle' ),
				'id'	=> 'enable_mobile_parallax',
				'type'	=> 'checkbox',
			),
		),
	);
	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_extra_mods' );