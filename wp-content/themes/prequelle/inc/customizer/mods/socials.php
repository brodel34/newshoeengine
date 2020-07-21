<?php
/**
 * Prequelle Socials
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function prequelle_set_socials_mods( $mods ) {

	if ( function_exists( 'wvc_get_socials' ) ) {

		$socials = wvc_get_socials();

		$mods['socials'] = array(
			'id' => 'socials',
			'title' => esc_html__( 'Social Networks', 'prequelle' ),
			'icon' => 'share',
			'options' => array(),
		);

		foreach ( $socials as $social ) {
			$mods['socials']['options'][ $social ] = array(
				'id' => $social,
				'label' => ucfirst( $social ),
				'type' => 'text',
			);
		}
	}

	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_socials_mods' );