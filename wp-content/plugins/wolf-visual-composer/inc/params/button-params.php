<?php
/**
 * Wolf WPBakery Page Builder Extension button params
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get bigtext params
 *
 * @return array
 */
function wvc_button_params() {
	$icons_params = vc_map_integrate_shortcode( wvc_icon_params(), 'i_', '', array(
		'include_only_regex' => '/^(type|icon_\w*)/',
	), array(
		'element' => 'add_icon',
		'value' => 'true',
	) );
	if ( is_array( $icons_params ) && ! empty( $icons_params ) ) {
		foreach ( $icons_params as $key => $param ) {
			if ( is_array( $param ) && ! empty( $param ) ) {

				if ( ! isset( $param['group'] ) ) {
				}

				if ( 'i_type' == $param['param_name'] ) {
					$icons_params[ $key ]['dependency'] = array(
						'element' => 'add_icon',
						'value' => 'true',
					);
				}

				if ( isset( $param['admin_label'] ) ) {
					unset( $icons_params[ $key ]['admin_label'] );
				}
			}
		}
	}

	return array(
		'name' => esc_html__( 'Button', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Eye catching button', 'wolf-visual-composer' ),
		'base' => 'vc_button',
		'category' => esc_html__( 'Content', 'wolf-visual-composer' ),
		'icon' => 'fa fa-square',
		'params' => array_merge(
			array(

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Text', 'wolf-visual-composer' ),
					'param_name' => 'title',
					'value' => esc_html__( 'My Button', 'wolf-visual-composer' ),
					'admin_label' => true,
				),

				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'URL (Link)', 'wolf-visual-composer' ),
					'param_name' => 'link',
					'description' => esc_html__( 'Add link to button.', 'wolf-visual-composer' ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Color', 'wolf-visual-composer' ),
					'param_name' => 'color',
					'value' => array_merge(
							wvc_get_shared_colors(),
							wvc_get_shared_gradient_colors(),
							array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
					),
					'description' => esc_html__( 'Select button color.', 'wolf-visual-composer' ),
					'param_holder_class' => 'wvc_colored-dropdown',
				),
				
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Custom color', 'wolf-visual-composer' ),
					'param_name' => 'custom_color',
					'description' => esc_html__( 'Select custom button color.', 'wolf-visual-composer' ),
					'dependency' => array(
						'element' => 'color',
						'value' => 'custom',
					),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Shape', 'wolf-visual-composer' ),
					'description' => esc_html__( 'Select button shape.', 'wolf-visual-composer' ),
					'param_name' => 'shape',
					'std' => apply_filters( 'wvc_default_button_shape', 'standard' ),
					'value' => array(
						esc_html__( 'Standard', 'wolf-visual-composer' ) => 'standard',
						esc_html__( 'Round', 'wolf-visual-composer' ) => 'rounded',
						esc_html__( 'Square', 'wolf-visual-composer' ) => 'boxed',
						esc_html__( 'Rounded', 'wolf-visual-composer' ) => 'rounded-less',
						esc_html__( 'Outline Standard', 'wolf-visual-composer' ) => 'standard-outline',
						esc_html__( 'Outline Round', 'wolf-visual-composer' ) => 'rounded-outline',
						esc_html__( 'Outline Square', 'wolf-visual-composer' ) => 'boxed-outline',
						esc_html__( 'Outline Rounded', 'wolf-visual-composer' ) => 'rounded-less-outline',
					),
					'description' => esc_html__( 'Select background shape and style for button.', 'wolf-visual-composer' ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Size', 'wolf-visual-composer' ),
					'param_name' => 'size',
					'description' => esc_html__( 'Select button display size.', 'wolf-visual-composer' ),
					'std' => 'sm',
					'value' => array(
						esc_html( 'Small', 'wolf-visual-composer' ) => 'xs',
						esc_html( 'Normal', 'wolf-visual-composer' ) => 'sm',
						esc_html( 'Large', 'wolf-visual-composer' ) => 'md',
						esc_html( 'Extra Large', 'wolf-visual-composer' ) => 'lg',
					),
					'admin_label' => true,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Alignment', 'wolf-visual-composer' ),
					'param_name' => 'align',
					'description' => esc_html__( 'Select button alignment.', 'wolf-visual-composer' ),
					'value' => array(
						esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
						esc_html__( 'Inline', 'wolf-visual-composer' ) => 'inline',
						esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
						esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
					),
					'admin_label' => true,
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Set full width button?', 'wolf-visual-composer' ),
					'param_name' => 'button_block',
					'dependency' => array(
						'element' => 'align',
						'value_not_equal_to' => 'inline',
					),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Hover effect', 'wolf-visual-composer' ),
					'param_name' => 'hover_effect',
					'value' => array(
						esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
						esc_html__( 'Opacity', 'wolf-visual-composer' ) => 'opacity',
						esc_html__( 'Background', 'wolf-visual-composer' ) => 'background',
						esc_html__( 'Up', 'wolf-visual-composer' ) => 'upper',
						esc_html__( 'Fill Vertical', 'wolf-visual-composer' ) => 'fill-vertical',
						esc_html__( 'Fill Horizontal', 'wolf-visual-composer' ) => 'fill-horizontal',
					),
					'admin_label' => true,
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Add icon?', 'wolf-visual-composer' ),
					'param_name' => 'add_icon',
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon Alignment', 'wolf-visual-composer' ),
					'description' => esc_html__( 'Select icon alignment.', 'wolf-visual-composer' ),
					'param_name' => 'i_align',
					'value' => array(
						esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
						esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
					),
					'dependency' => array(
						'element' => 'add_icon',
						'value' => 'true',
					),
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Reveal Icon on Hover', 'wolf-visual-composer' ),
					'description' => esc_html__( 'The icon will be visible on hover only.', 'wolf-visual-composer' ),
					'param_name' => 'i_hover',
					'dependency' => array(
						'element' => 'add_icon',
						'value' => 'true',
					),
				),
			),
			$icons_params,
			array(
				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Font Weight', 'wolf-visual-composer' ),
					'param_name' => 'font_weight',
					'placeholder' => '400',
					'admin_label' => true,
					'weight' => -1000,
					'group' => esc_html__( 'Extra', 'wolf-visual-composer' ),
					'std' => apply_filters( 'wvc_button_default_font_weight', 400 ),
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Scroll to anchor?', 'wolf-visual-composer' ),
					'param_name' => 'scroll_to_anchor',
					'weight' => -1000,
					'group' => esc_html__( 'Extra', 'wolf-visual-composer' ),
				),
			)
		),
	);
}