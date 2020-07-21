<?php
/**
 * Album Tracklist
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Album Tracklist', 'wolf-visual-composer' ),
		'base' => 'wvc_album_tracklist',
		'as_parent' => array( 'only' => 'wvc_album_tracklist_item' ),
		'show_settings_on_create' => false,
		'content_element' => true,
		'description' => esc_html__( 'A tracklist for your album songs', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-playlist-audio',
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Show Tracklist Numbers', 'wolf-visual-composer' ),
				'param_name' => 'show_numbers',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'no',
				),
			),
		), // more params will be added in wvc-elements-additional-settings.php
		'js_view' => 'VcColumnView',
	)
);

class WPBakeryShortCode_Wvc_Album_Tracklist extends WPBakeryShortCodesContainer {}