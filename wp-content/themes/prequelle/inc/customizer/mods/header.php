<?php
/**
 * Prequelle header_settings
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function prequelle_set_header_settings_mods( $mods ) {

	$mods['header_settings'] = array(

		'id' => 'header_settings',
		'title' => esc_html__( 'Header Layout', 'prequelle' ),
		'icon' => 'editor-table',
		'options' => array(

			'hero_layout' => array(
				'label'	=> esc_html__( 'Page Header Layout', 'prequelle' ),
				'id'	=> 'hero_layout',
				'type'	=> 'select',
				'choices' => array(
					'standard' => esc_html__( 'Standard', 'prequelle' ),
					'big' => esc_html__( 'Big', 'prequelle' ),
					'small' => esc_html__( 'Small', 'prequelle' ),
					'fullheight' => esc_html__( 'Full Height', 'prequelle' ),
					'none' => esc_html__( 'No header', 'prequelle' ),
				),
				'transport' => 'postMessage',
			),

			'hero_background_effect' => array(
				'id' =>'hero_background_effect',
				'label' => esc_html__( 'Header Image Effect', 'prequelle' ),
				'type' => 'select',
				'choices' => array(
					'parallax' => esc_html__( 'Parallax', 'prequelle' ),
					'zoomin' => esc_html__( 'Zoom', 'prequelle' ),
					'none' => esc_html__( 'None', 'prequelle' ),
				),
			),

			'hero_scrolldown_arrow' => array(
				'id' =>'hero_scrolldown_arrow',
				'label' => esc_html__( 'Scroll Down arrow', 'prequelle' ),
				'type' => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'prequelle' ),
					'' => esc_html__( 'No', 'prequelle' ),
				),
			),

			array(
				'label'	=> esc_html__( 'Header Overlay', 'prequelle' ),
				'id'	=> 'hero_overlay',
				'type'	=> 'select',
				'choices' => array(
					'' => esc_html__( 'Default', 'prequelle' ),
					'custom' => esc_html__( 'Custom', 'prequelle' ),
					'none' => esc_html__( 'None', 'prequelle' ),
				),
			),

			array(
				'label'	=> esc_html__( 'Overlay Color', 'prequelle' ),
				'id'	=> 'hero_overlay_color',
				'type'	=> 'color',
				'value' 	=> '#000000',
			),

			array(
				'label'	=> esc_html__( 'Overlay Opacity (in percent)', 'prequelle' ),
				'id'	=> 'hero_overlay_opacity',
				'desc'	=> esc_html__( 'Adapt the header overlay opacity if needed', 'prequelle' ),
				'type'	=> 'text',
				'value'	=> 40,
			),
		),
	);

	if ( class_exists( 'Wolf_Vc_Content_Block' ) ) {
		$mods['header_settings']['options']['hero_layout']['description'] = sprintf(
			prequelle_kses(
				__( 'The header can be overwritten by a <a href="%s" target="_blank">content block</a> on all pages or on specific pages. See the customizer "Layout" tab or the page options below your text editor.', 'prequelle' )
			),
			'http://wlfthm.es/content-blocks'
		); 
	}

	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_header_settings_mods' );