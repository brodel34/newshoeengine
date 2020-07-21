<?php
/**
 * Separator
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Separator', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Horizontal divider', 'wolf-visual-composer' ),
		'base' => 'vc_separator',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-arrows-h',
		'params' => array(
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Element Width', 'wolf-visual-composer' ),
				'param_name' => 'el_width',
				'value' => apply_filters( 'wvc_separator_default_width', '50px' ),
				'description' => sprintf( __( 'Separator width (in %s or %s).', 'wolf-visual-composer' ), 'px', '%' ),
				'std' => apply_filters( 'wvc_separator_default_width', '50px' ),
			),
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Element Height', 'wolf-visual-composer' ),
				'param_name' => 'el_height',
				'value' => apply_filters( 'wvc_separator_default_height', '50px' ),
				'description' => sprintf( __( 'Separator width (in %s or %s).', 'wolf-visual-composer' ), 'px', '%' ),
				'std' => apply_filters( 'wvc_separator_default_height', '1px' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Style', 'wolf-visual-composer' ),
				'param_name' => 'border_style',
				'value' => array(
					esc_html__( 'Solid', 'wolf-visual-composer' ) => 'solid',
					esc_html__( 'Dotted', 'wolf-visual-composer' ) => 'dotted',
					esc_html__( 'Dashed', 'wolf-visual-composer' ) => 'dashed',
					esc_html__( 'Double', 'wolf-visual-composer' ) => 'double',
				),
				'description' => esc_html__( 'This will be disabled if a gradient color is used.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Alignment', 'wolf-visual-composer' ),
				'param_name' => 'align',
				'value' => array(
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'align_center',
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'align_left',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'align_right',
				),
				'description' => esc_html__( 'Select separator alignment.', 'wolf-visual-composer' ),
			),


			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Color', 'wolf-visual-composer' ),
				'param_name' => 'color',
				'value' => array_merge(
					array( esc_html__( 'Default', 'wolf-visual-composer' ) => 'default', ),
					wvc_get_shared_colors(),
					wvc_get_shared_gradient_colors(),
					array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
				),
				'description' => esc_html__( 'Select icon color.', 'wolf-visual-composer' ),
				'param_holder_class' => 'wvc_colored-dropdown',
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
		),
	)
);