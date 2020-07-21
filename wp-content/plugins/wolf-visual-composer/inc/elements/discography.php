<?php
/**
 * Discography Plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wolf_Discography' ) ) {
	return;
}
vc_map(
	array(
		'name' => esc_html__( 'Last Releases', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Display your discography', 'wolf-visual-composer' ),
		'base' => 'wolf_last_releases',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-album',
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Count', 'wolf-visual-composer' ),
				'param_name' => 'count',
				'value' => 3,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Columns', 'wolf-visual-composer' ),
				'param_name' => 'col',
				'value' => array( 3,2,4 ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'heading', 'wolf-visual-composer' ),
				'param_name' => 'heading',
				'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Band', 'wolf-visual-composer' ),
				'param_name' => 'band',
				'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'wolf-visual-composer' ),
			),
		)
	)
);

vc_map(
	array(
		'name' => esc_html__( 'Last Release', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Display your last release', 'wolf-visual-composer' ),
		'base' => 'wolf_last_release',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-album',
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'heading', 'wolf-visual-composer' ),
				'param_name' => 'heading',
				'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Band', 'wolf-visual-composer' ),
				'param_name' => 'band',
				'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'wolf-visual-composer' ),
			),
		)
	)
);