<?php
/**
 * Autotyping
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Autotyping', 'wolf-visual-composer' ),
		'description' => esc_html__( 'An animated typing text', 'wolf-visual-composer' ),
		'base' => 'wvc_typed',
		'category' => esc_html__( 'Typography' , 'wolf-visual-composer' ),
		'icon' => 'fa-i-cursor',
		'params' => array(

			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Animated Text', 'wolf-visual-composer' ),
				'param_name' => 'text',
				'description' => esc_html__( 'Enter one sentence per line.' ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Text Before', 'wolf-visual-composer' ),
				'param_name' => 'text_before',
				'placeholder' => esc_html__( 'My sentence starts with this', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Text After', 'wolf-visual-composer' ),
				'param_name' => 'text_after',
				'placeholder' => esc_html__( 'My sentence ends with this', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Cursor', 'wolf-visual-composer' ),
				'param_name' => 'cursor',
				'value' => '|',
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Alignment', 'wolf-visual-composer' ),
				'param_name' => 'text_alignment',
				'value' => array(
					esc_html__( 'left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'right', 'wolf-visual-composer' ) => 'right',
					esc_html__( 'center', 'wolf-visual-composer' ) => 'center',
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Font Weight', 'wolf-visual-composer' ),
				'param_name' => 'font_weight',
				'value' => 700,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Font Size', 'wolf-visual-composer' ),
				'param_name' => 'font_size',
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Style', 'wolf-visual-composer' ),
				'param_name' => 'font_style',
				'value' => array(
					esc_html__( 'normal', 'wolf-visual-composer' ) => 'normal',
					esc_html__( 'italic', 'wolf-visual-composer' ) => 'italic',

				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Transform', 'wolf-visual-composer' ),
				'param_name' => 'text_transform',
				'value' => array(
					esc_html__( 'uppercase', 'wolf-visual-composer' ) => 'uppercase',
					esc_html__( 'none', 'wolf-visual-composer' ) => 'none',

				),
			),

			array(
				'type' => 'wvc_font_family',
				'heading' => esc_html__( 'Font', 'wolf-visual-composer' ),
				'param_name' => 'font_family',
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Tag', 'wolf-visual-composer' ),
				'param_name' => 'tag',
				'value' => array(
					'h2',
					'p',
					'h5',
					'h4',
					'h3',
					'h1',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Loop', 'wolf-visual-composer' ),
				'param_name' => 'loop',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Speed in ms', 'wolf-visual-composer' ),
				'param_name' => 'speed',
				'value' => 100,
			),
		)
	)
);
class WPBakeryShortCode_Wvc_Typed extends WPBakeryShortCode {}