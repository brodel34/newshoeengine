<?php
/**
 * Prequelle footer
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function prequelle_set_footer_mods( $mods ) {

	$mods['footer'] = array(

		'id' => 'footer',
		'title' => esc_html__( 'Footer', 'prequelle' ),
		'icon' => 'welcome-widgets-menus',
		'options' => array(

			'footer_type' => array(
				'label' => esc_html__( 'Footer Type', 'prequelle' ),
				'id' => 'footer_type',
				'type' => 'select',
				'choices' => array(
		 			'standard' => esc_html__( 'Standard', 'prequelle' ),
					'uncover' => esc_html__( 'Uncover', 'prequelle' ),
					'hidden' => esc_html__( 'No Footer', 'prequelle' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label' => esc_html__( 'Footer Width', 'prequelle' ),
				'id' => 'footer_layout',
				'type' => 'select',
				'choices' => array(
		 			'boxed' => esc_html__( 'Boxed', 'prequelle' ),
					'wide' => esc_html__( 'Wide', 'prequelle' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label' => esc_html__( 'Foot Widgets Layout', 'prequelle' ),
				'id' => 'footer_widgets_layout',
				'type' => 'select',
				'choices' => array(
		 			'3-cols' => esc_html__( '3 Columns', 'prequelle' ),
					'4-cols' => esc_html__( '4 Columns', 'prequelle' ),
					'one-half-two-quarter' => esc_html__( '1 Half/2 Quarters', 'prequelle' ),
					'two-quarter-one-half' => esc_html__( '2 Quarters/1 Half', 'prequelle' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label' => esc_html__( 'Bottom Bar Layout', 'prequelle' ),
				'id' => 'bottom_bar_layout',
				'type' => 'select',
				'choices' => array(
					'centered' => esc_html__( 'Centered', 'prequelle' ),
					'inline' => esc_html__( 'Inline', 'prequelle' ),
				),
				'transport' => 'postMessage',
			),

			'footer_socials' => array(
				'id' => 'footer_socials',
				'label' => esc_html__( 'Socials', 'prequelle' ),
				'type' => 'text',
				'description' => esc_html__( 'The list of social services to display in the bottom bar. (eg: facebook,twitter,instagram)', 'prequelle' ),
			),

			'copyright' => array(
				'id' => 'copyright',
				'label' => esc_html__( 'Copyright Text', 'prequelle' ),
				'type' => 'text',
			),
		),
	);

	if ( class_exists( 'Wolf_Vc_Content_Block' ) ) {
		$mods['footer']['options']['footer_type']['description'] = sprintf(
			prequelle_kses(
				__( 'This is the default footer settings. You can leave the fields below empty and use a <a href="%s" target="_blank">content block</a> instead for more flexibility. See the customizer "Layout" tab or the page options below your text editor.', 'prequelle' )
			),
			'http://wlfthm.es/content-blocks'
		); 
	}

	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_footer_mods' );