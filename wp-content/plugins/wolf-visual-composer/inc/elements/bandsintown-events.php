<?php
/**
 * Bandsintown Plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => 'Bandsintown',
		'base' => 'wvc_bandsintown_events',
		'description' => esc_html__( 'Display your Bandsintown event list', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Music' , 'wolf-visual-composer' ),
		'icon' => 'fa wolficon-bandsintown',
		'show_settings_on_create' => true,
		'params' => array(
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Artist Name', 'wolf-visual-composer' ),
				'param_name' => 'artist',
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Display Limit', 'wolf-visual-composer' ),
				'param_name' => 'display_limit',
				'admin_label' => true,
				'description' => esc_html__( 'Leave empty to display all shows', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Display Local Dates', 'wolf-visual-composer' ),
				'param_name' => 'local_dates',
				'value' => array(
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Display Past Dates', 'wolf-visual-composer' ),
				'param_name' => 'past_dates',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
			),
		),
	)
);
class WPBakeryShortCode_Wvc_Bandsintown_Events extends WPBakeryShortCode {}