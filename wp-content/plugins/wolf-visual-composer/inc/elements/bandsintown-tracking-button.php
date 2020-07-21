<?php
/**
 * Bandsintown Tracking Button
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => 'Bandsintown Tracking Button',
		'base' => 'wvc_bandsintown_tracking_button',
		'description' => esc_html__( 'Display your Bandsintown Tracking Button', 'wolf-visual-composer' ),
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
				'type' => 'dropdown',
				'heading' => esc_html__( 'Size', 'wolf-visual-composer' ),
				'param_name' => 'size',
				'value' => array(
					esc_html__( 'Large', 'wolf-visual-composer' ) => 'large',
					esc_html__( 'Small', 'wolf-visual-composer' ) => 'small',
				),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Alignment', 'wolf-visual-composer' ),
				'param_name' => 'alignment',
				'value' => array(
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
				),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Background Color', 'wolf-visual-composer' ),
				'param_name' => 'background_color',
				'value' => array_merge( wvc_get_shared_colors(), array(
						esc_html__( 'Default', 'wolf-visual-composer' ) => 'default',
						esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom',
					)
				),
				'std' => 'default',
				'description' => esc_html__( 'Select a background color.', 'wolf-visual-composer' ),
				'param_holder_class' => 'wvc_colored-dropdown',
			),

			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Background Color', 'wolf-visual-composer' ),
				'param_name' => 'background_custom_color',
				'dependency' => array(
					'element' => 'background_color',
					'value' => 'custom',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Color', 'wolf-visual-composer' ),
				'param_name' => 'text_color',
				'value' => array_merge( wvc_get_shared_colors(), array(
						esc_html__( 'Default', 'wolf-visual-composer' ) => 'default',
						esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom',
					)
				),
				'std' => 'default',
				'description' => esc_html__( 'Select a background color.', 'wolf-visual-composer' ),
				'param_holder_class' => 'wvc_colored-dropdown',
			),

			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Text Color', 'wolf-visual-composer' ),
				'param_name' => 'text_custom_color',
				'dependency' => array(
					'element' => 'text_color',
					'value' => 'custom',
				),
			),
		),
	)
);
class WPBakeryShortCode_Wvc_Bandsintown_Tracking_Button extends WPBakeryShortCode {}