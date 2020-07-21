<?php
/**
 * Twitter plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wolf_Twitter' ) ) {
	return;
}
vc_map(
	array(
		'name' => esc_html__( 'Twitter Feed', 'wolf-visual-composer' ),
		'base' => 'wvc_twitter',
		'description' => esc_html__( 'Your last tweets', 'wolf-visual-composer' ),
		'tags' => 'twitter',
		'category' => esc_html__( 'Social' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-twitter',
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Username', 'wolf-visual-composer' ),
				'param_name' => 'username',
				'value' => wvc_get_twitter_usename(),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Type', 'wolf-visual-composer' ),
				'param_name' => 'type',
				'value' => array(
					esc_html__( 'Single', 'wolf-visual-composer' ) => 'single',
					esc_html__( 'List', 'wolf-visual-composer' ) => 'list',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Alignment', 'wolf-visual-composer' ),
				'param_name' => 'text_align',
				'value' => array(
					esc_html__( 'Default', 'wolf-visual-composer' ) => 'default',
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
				),
				'dependency' => array( 'element' => 'type', 'value' => array( 'single' ) ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Count', 'wolf-visual-composer' ),
				'param_name' => 'count',
				'value' => 3,
				'dependency' => array( 'element' => 'type', 'value' => array( 'list' ) ),
			),
		)
	)
);

class WPBakeryShortCode_Wvc_Twitter extends WPBakeryShortCode {}