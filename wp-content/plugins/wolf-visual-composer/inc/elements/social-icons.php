<?php
/**
 * Social icons
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Social Icons', 'wolf-visual-composer' ),
		'base' => 'wvc_social_icons',
		'icon' => 'fa fa-share-alt',
		'description' => esc_html__( 'A set of icons linked to your social profiles', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Social', 'wolf-visual-composer' ),
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Services', 'wolf-visual-composer' ),
				'param_name' => 'services',
				'value' => 'facebook,twitter,instagram',
				'description' => sprintf(
					wp_kses(
						__( 'Enter the service names separated by a comma. Leave empty to display them all.<br>You can set your profiles in the <a href="%s" target="_blank">customizer</a>.', 'wolf-visual-composer' ),
						array( 'br' => array(), 'a' => array( 'href' => array(), 'target' => array() ) )
					),
					esc_url( admin_url( 'customize.php' ) )
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
				'heading' => esc_html__( 'Target', 'wolf-visual-composer' ),
				'param_name' => 'target',
				'value' => ( function_exists( 'wvc_target_param_list' ) ) ? wvc_target_param_list() : '',
			),

			array(
				'type' => 'checkbox',
				'heading' => sprintf( wvc_kses( __( 'Add %s attribute', 'wolf-visual-composer' ) ), '"noreferrer, noopener" rel' ),
				'param_name' => 'rel',
				'value' => 'yes',
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Background shape', 'wolf-visual-composer' ),
				'param_name' => 'background_style',
				'value' => array(
					esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
					esc_html__( 'Circle', 'wolf-visual-composer' ) => 'rounded',
					esc_html__( 'Square', 'wolf-visual-composer' ) => 'boxed',
					esc_html__( 'Rounded', 'wolf-visual-composer' ) => 'rounded-less',
					esc_html__( 'Outline Circle', 'wolf-visual-composer' ) => 'rounded-outline',
					esc_html__( 'Outline Square', 'wolf-visual-composer' ) => 'boxed-outline',
					esc_html__( 'Outline Rounded', 'wolf-visual-composer' ) => 'rounded-less-outline',
				),
				'description' => esc_html__( 'Select background shape and style for icon.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon color', 'wolf-visual-composer' ),
				'param_name' => 'color',
				'value' => array_merge(
					array(
						esc_html__( 'Default color', 'wolf-visual-composer' ) => 'default',
					),
					wvc_get_shared_colors(),
					array(
						esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom',
					)
				),
				'description' => esc_html__( 'Select icon color.', 'wolf-visual-composer' ),
				'param_holder_class' => 'wvc_colored-dropdown',
				'dependency' => array(
					'element' => 'background_style',
					'value' => 'none',
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Custom color', 'wolf-visual-composer' ),
				'param_name' => 'custom_color',
				'description' => esc_html__( 'Select custom icon color.', 'wolf-visual-composer' ),
				'dependency' => array(
					'element' => 'color',
					'value' => 'custom',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Background color', 'wolf-visual-composer' ),
				'param_name' => 'background_color',
				'value' => array_merge(
					array( esc_html__( 'Default color', 'wolf-visual-composer' ) => 'default', ),
					wvc_get_shared_colors(),
					array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
				),
				'description' => esc_html__( 'Select background color for icon.', 'wolf-visual-composer' ),
				'param_holder_class' => 'wvc_colored-dropdown',
				'dependency' => array(
					'element' => 'background_style',
					'value_not_equal_to' => array( 'none' ),
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Custom background color', 'wolf-visual-composer' ),
				'param_name' => 'custom_background_color',
				'description' => esc_html__( 'Select custom icon background color.', 'wolf-visual-composer' ),
				'dependency' => array(
					'element' => 'background_color',
					'value' => 'custom',
				),
			),
			
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Size', 'wolf-visual-composer' ),
				'param_name' => 'size',
				'value' => array(
					esc_html__( 'Tiny', 'wolf-visual-composer' ) => 'fa-1x',
					esc_html__( 'Small', 'wolf-visual-composer' ) => 'fa-2x',
					esc_html__( 'Medium', 'wolf-visual-composer' ) => 'fa-3x',
					esc_html__( 'Large', 'wolf-visual-composer' ) => 'fa-4x',
					esc_html__( 'Very Large', 'wolf-visual-composer' ) => 'fa-5x',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Hover Transition', 'wolf-visual-composer' ),
				'param_name' => 'hover_effect',
				'value' => array(
					esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
					esc_html__( 'Opacity', 'wolf-visual-composer' ) => 'opacity',
					esc_html__( 'Inset border', 'wolf-visual-composer' ) => 'border-inset',
					esc_html__( 'Sonar', 'wolf-visual-composer' ) => 'sonar',
					esc_html__( 'Fill', 'wolf-visual-composer' ) => 'fill',
					esc_html__( 'Pop', 'wolf-visual-composer' ) => 'pop',
					esc_html__( 'Rotate', 'wolf-visual-composer' ) => 'rotate',
				),
				'dependency' => array(
					'element' => 'background_style',
					'not_empty' => true,
				),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Direction', 'wolf-visual-composer' ),
				'param_name' => 'direction',
				'std' => 'horizontal',
				'value' => array(
					esc_html__( 'Horizontal', 'wolf-visual-composer' ) => 'horizontal',
					esc_html__( 'Vertical', 'wolf-visual-composer' ) => 'vertical',
				),
				'admin_label' => true,
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Animate Icons One By One', 'wolf-visual-composer' ),
				'param_name' => 'css_animation_each',
				'group' => esc_html__( 'Animation', 'wolf-visual-composer' ),
				'weight' => -5,
			),
		)
	)
);

class WPBakeryShortCode_Wvc_Social_Icons extends WPBakeryShortCode {}