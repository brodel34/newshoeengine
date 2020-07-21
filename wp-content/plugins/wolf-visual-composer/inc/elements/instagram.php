<?php
/**
 * Instagram element
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Instagram', 'wolf-visual-composer' ),
		'base' => 'wvc_instagram',
		'description' => esc_html__( 'Your last instagram photos', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Social' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-instagram',
		'params' => array(
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Image Count', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Note that the instagram API may limit the number of image to display.', 'wolf-visual-composer' ),
				'param_name' => 'count',
				'value' => 18,
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Columns', 'wolf-visual-composer' ),
				'param_name' => 'columns',
				'value' => array( 6, 4, 3, 2 ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Username (optional)', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Leave empty to use the default username', 'wolf-visual-composer' ),
				'param_name' => 'username',
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'API key (optional)', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Leave empty to use the default API key', 'wolf-visual-composer' ),
				'param_name' => 'api_key',
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Hashtag', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Only one hashtag allowed', 'wolf-visual-composer' ),
				'param_name' => 'tag',
				'admin_label' => true,
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Display follow button', 'wolf-visual-composer' ),
				'param_name' => 'follow_button',
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Button Text', 'wolf-visual-composer' ),
				'param_name' => 'button_text',
				'dependency' => array( 'element' => 'follow_button', 'value' => array( 'true' ) ),
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Add padding', 'wolf-visual-composer' ),
				'param_name' => 'add_padding',
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Hide meta (comments and likes count)', 'wolf-visual-composer' ),
				'param_name' => 'hide_meta',
			),
		)
	)
);

class WPBakeryShortCode_Wvc_Instagram extends WPBakeryShortCode {}
