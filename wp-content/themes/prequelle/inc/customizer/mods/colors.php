<?php
/**
 * Prequelle customizer color mods
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
function prequelle_set_colors_mods( $mods ) {

	$color_scheme = prequelle_get_color_scheme();

	$mods['colors'] = array(
		'id' => 'colors',
		'icon' => 'admin-customizer',
		'title' => esc_html__( 'Colors', 'prequelle' ),
		'options' => array(
			array(
				'label' => esc_html__( 'Color scheme', 'prequelle' ),
				'id' => 'color_scheme',
				'type' => 'select',
				'choices'  => prequelle_get_color_scheme_choices(),
				'transport' => 'postMessage',
			),

			'body_background_color' => array(
				'id' => 'body_background_color',
				'label' => esc_html__( 'Body Background Color', 'prequelle' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[0],
			),

			'page_background_color' => array(
				'id' => 'page_background_color',
				'label' => esc_html__( 'Page Background Color', 'prequelle' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[1],
			),

			'submenu_background_color' => array(
				'id' => 'submenu_background_color',
				'label' => esc_html__( 'Submenu Background Color', 'prequelle' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[2],
			),

			array(
				'id' => 'submenu_font_color',
				'label' => esc_html__( 'Submenu Font Color', 'prequelle' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[3],
			),

			'accent_color' => array(
				'id' => 'accent_color',
				'label' => esc_html__( 'Accent Color', 'prequelle' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[4],
			),
			array(
				'id' => 'main_text_color',
				'label' => esc_html__( 'Main Text Color', 'prequelle' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[5],
			),
			array(
				'id' => 'strong_text_color',
				'label' => esc_html__( 'Strong Text Color', 'prequelle' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[7],
				'description' => esc_html__( 'Heading, "strong" tags etc...', 'prequelle' ),
			),
		),
	);

	return $mods;

}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_colors_mods' );