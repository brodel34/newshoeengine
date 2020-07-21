<?php
/**
 * Prequelle customizer logo mods
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Set color schemes
 */
function prequelle_set_logo_mods( $mods ) {

	$mods['logo'] = array(
		'id' => 'logo',
		'title' => esc_html__( 'Logo', 'prequelle' ),
		'icon' => 'visibility',
		'description' => sprintf(
			wp_kses(
				__( 'Your theme recommends a logo size of <strong>%d &times; %d</strong> pixels.', 'prequelle' ),
				array(
					'strong' => array(),
				)
			),
			180, 80
		),
		'options' => array(

			'logo_dark' => array(
				'id' => 'logo_dark',
				'label' => esc_html__( 'Logo - Dark Version', 'prequelle' ),
				'type' => 'image',
			),

			'logo_light' => array(
				'id' => 'logo_light',
				'label' => esc_html__( 'Logo - Light Version', 'prequelle' ),
				'type' => 'image',
			),

			'logo_max_width' => array(
				'id' => 'logo_max_width',
				'label' => esc_html__( 'Logo Max Width (don\'t ommit px )', 'prequelle' ),
				'type' => 'text',
			),

			'logo_visibility' => array(
				'id' => 'logo_visibility',
				'label' => esc_html__( 'Visibility', 'prequelle' ),
				'type' => 'select',
				'choices' => array(
					'always' => esc_html__( 'Always', 'prequelle' ),
					'sticky_menu' => esc_html__( 'When menu is sticky only', 'prequelle' ),
				),
				'transport' => 'postMessage',
			),
		),
	);

	return $mods;

}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_logo_mods' );