<?php
/**
 * Prequelle customizer font mods
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
function prequelle_set_font_mods( $mods ) {

	/**
	 * Get Google Fonts from Font loader
	 */
	$_fonts = apply_filters( 'prequelle_mods_fonts', prequelle_get_google_fonts_options() );

	$font_choices = array( 'default' => esc_html__( 'Default', 'prequelle' ) );

	foreach ( $_fonts as $key => $value ) {
		$font_choices[ $key ] = $key;
	}

	$mods['fonts'] = array(
		'id' => 'fonts',
		'title' => esc_html__( 'Fonts', 'prequelle' ),
		'icon' => 'editor-textcolor',
		'options' => array(),
	);

	$mods['fonts']['options']['body_font_name'] = array(
		'label' => esc_html__( 'Body Font Name', 'prequelle' ),
		'id' => 'body_font_name',
		'type' => 'select',
		'choices' => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['body_font_size'] = array(
		'label' => esc_html__( 'Body Font Size', 'prequelle' ),
		'id' => 'body_font_size',
		'type' => 'text',
		'transport' => 'postMessage',
		'description' => esc_html__( 'Don\'t ommit px. Leave empty to use the default font size.', 'prequelle' ),
	);

	/*************************Menu****************************/

	$mods['fonts']['options']['menu_font_name'] = array(
		'id' => 'menu_font_name',
		'label' => esc_html__( 'Menu Font', 'prequelle' ),
		'type' => 'select',
		'choices' => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_weight'] = array(
		'label' => esc_html__( 'Menu Font Weight', 'prequelle' ),
		'id' => 'menu_font_weight',
		'type' => 'text',
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_transform'] = array(
		'id' => 'menu_font_transform',
		'label' => esc_html__( 'Menu Font Transform', 'prequelle' ),
		'type' => 'select',
		'choices' => array(
			'none' => esc_html__( 'None', 'prequelle' ),
			'uppercase' => esc_html__( 'Uppercase', 'prequelle' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_transform'] = array(
		'id' => 'submenu_font_transform',
		'label' => esc_html__( 'Submenu Font Transform', 'prequelle' ),
		'type' => 'select',
		'choices' => array(
			'none' => esc_html__( 'None', 'prequelle' ),
			'uppercase' => esc_html__( 'Uppercase', 'prequelle' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_weight'] = array(
		'label' => esc_html__( 'Submenu Font Weight', 'prequelle' ),
		'id' => 'submenu_font_weight',
		'type' => 'text',
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_letter_spacing'] = array(
		'label' => esc_html__( 'Menu Letter Spacing (omit px)', 'prequelle' ),
		'id' => 'menu_font_letter_spacing',
		'type' => 'int',
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_letter_spacing'] = array(
		'label' => esc_html__( 'Submenu Letter Spacing (omit px)', 'prequelle' ),
		'id' => 'submenu_font_letter_spacing',
		'type' => 'int',
		'transport' => 'postMessage',
	);

	/*************************Heading****************************/

	$mods['fonts']['options']['heading_font_name'] = array(
		'id' => 'heading_font_name',
		'label' => esc_html__( 'Heading Font', 'prequelle' ),
		'type' => 'select',
		'choices' => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_weight'] = array(
		'label' => esc_html__( 'Heading Font weight', 'prequelle' ),
		'id' => 'heading_font_weight',
		'type' => 'text',
		'description' => esc_html__( 'For example: "400" is normal, "700" is bold.The available font weights depend on the font.', 'prequelle' ),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_transform'] = array(
		'id' => 'heading_font_transform',
		'label' => esc_html__( 'Heading Font Transform', 'prequelle' ),
		'type' => 'select',
		'choices' => array(
			'none' => esc_html__( 'None', 'prequelle' ),
			'uppercase' => esc_html__( 'Uppercase', 'prequelle' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_letter_spacing'] = array(
		'label' => esc_html__( 'Heading Letter Spacing (omit px)', 'prequelle' ),
		'id' => 'heading_font_letter_spacing',
		'type' => 'int',
		'transport' => 'postMessage',
	);

	return $mods;

}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_font_mods', 10 );