<?php
/**
 * Videos plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wolf_Videos' ) ) {
	return;
}
vc_map(
	array(
		'name' => esc_html__( 'Last Videos', 'wolf-visual-composer' ),
		'description' => esc_html__( 'The last videos from your video gallery', 'wolf-visual-composer' ),
		'base' => 'wolf_last_videos',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-format-video',
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Count', 'wolf-visual-composer' ),
				'param_name' => 'count',
				'value' => 4,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Columns', 'wolf-visual-composer' ),
				'param_name' => 'col',
				'value' => array( 4,3,2 ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Category', 'wolf-visual-composer' ),
				'param_name' => 'category',
				'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'wolf-visual-composer' ),
			),
		)
	)
);