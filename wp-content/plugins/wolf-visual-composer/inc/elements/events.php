<?php
/**
 * Tour Dates Plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wolf_Events' ) ) {
	return;
}

vc_map(
	array(
		'name' => esc_html__( 'Event List', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Display your event list from the Wolf Events plugin', 'wolf-visual-composer' ),
		'base' => 'wolf_event_list',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-calendar',
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Count', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Leave empty to display all', 'wolf-visual-composer' ),
				'param_name' => 'count',
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Link to Single Event Page', 'wolf-visual-composer' ),
				'param_name' => 'link',
				'value' => array(
					'false' => esc_html__( 'No', 'wolf-visual-composer' ),
					'true' => esc_html__( 'Yes', 'wolf-visual-composer' ),
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Display Past Events', 'wolf-visual-composer' ),
				'param_name' => 'past',
				'value' => array(
					'false' => esc_html__( 'No', 'wolf-visual-composer' ),
					'true' => esc_html__( 'Yes', 'wolf-visual-composer' ),
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Artist Slug', 'wolf-visual-composer' ),
				'param_name' => 'artist',
			),
		),
	)
);