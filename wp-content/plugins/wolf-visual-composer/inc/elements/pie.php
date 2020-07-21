<?php
/**
 * Pie
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_add_params(
	'vc_pie',
	array(

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Bar Color', 'wolf-visual-composer' ),
			'param_name' => 'bar_color',
			'value' => array_merge(
				wvc_get_shared_colors(),
				array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
			),
			'description' => esc_html__( 'Select pie chart bar color.', 'wolf-visual-composer' ),
			'admin_label' => true,
			'param_holder_class' => 'wvc_colored-dropdown',
			'std' => 'custom',
		),

		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Custom Color', 'wolf-visual-composer' ),
			'param_name' => 'bar_custom_color',
			'description' => esc_html__( 'Select custom single pie chart track color.', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'bar_color',
				'value' => array( 'custom' ),
			),
			'std' => '#eeeeee',
		),

		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Line Width', 'wolf-visual-composer' ),
			'param_name' => 'line_width',
			'placeholder' => apply_filters( 'wvc_default_pie_chart_line_width', 5 ),
		),

		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Font Size', 'wolf-visual-composer' ),
			'param_name' => 'font_size',
			'value' => apply_filters( 'wvc_default_pie_font_size', 34 ),
			'placeholder' => apply_filters( 'wvc_default_pie_font_size', 34 ),
		),

		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Font Weight', 'wolf-visual-composer' ),
			'param_name' => 'font_weight',
			'value' => apply_filters( 'wvc_default_pie_font_weight', 700 ),
			'placeholder' => apply_filters( 'wvc_default_pie_font_weight', 700 ),
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Track Color', 'wolf-visual-composer' ),
			'param_name' => 'color',
			'value' => array_merge(
				wvc_get_shared_colors(),
				array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
			),
			'description' => esc_html__( 'Select pie chart track color.', 'wolf-visual-composer' ),
			'admin_label' => true,
			'param_holder_class' => 'wvc_colored-dropdown',
		),

		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Custom Color', 'wolf-visual-composer' ),
			'param_name' => 'custom_color',
			'description' => esc_html__( 'Select custom single pie chart track color.', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'color',
				'value' => array( 'custom' ),
			),
		),
	)
);