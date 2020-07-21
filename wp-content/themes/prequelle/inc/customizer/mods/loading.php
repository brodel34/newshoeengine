<?php
/**
 * Prequelle loading
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function prequelle_set_loading_mods( $mods ) {

	$mods['loading'] = array(

		'id' => 'loading',
		'title' => esc_html__( 'Loading', 'prequelle' ),
		'icon' => 'update',
		'options' => array(

			array(
				'label' => esc_html__( 'Loading Animation Type', 'prequelle' ),
				'id' => 'loading_animation_type',
				'type' => 'select',
				'choices' => array(
					'spinner' => esc_html__( 'Spinner', 'prequelle' ),
		 			'none' => esc_html__( 'None', 'prequelle' ),
				),
			),
		),
	);
	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_loading_mods' );