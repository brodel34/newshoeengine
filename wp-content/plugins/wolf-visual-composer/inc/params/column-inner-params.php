<?php
/**
 * Wolf WPBakery Page Builder Extension Column inner params
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Column general params
 */
function wvc_column_inner_general_params() {
	return array(

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Vertical Position', 'wolf-visual-composer' ),
			'param_name' => 'content_placement',
			'value' => array(
				esc_html__( 'Default', 'wolf-visual-composer' ) => 'default',
				esc_html__( 'Top', 'wolf-visual-composer' ) => 'top',
				esc_html__( 'Middle', 'wolf-visual-composer' ) => 'middle',
				esc_html__( 'Bottom', 'wolf-visual-composer' ) => 'bottom',
			),
			'description' => esc_html__( 'Select the vertical position of the content.', 'wolf-visual-composer' ),
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Horizontal Position', 'wolf-visual-composer' ),
			'param_name' => 'content_placement',
			'value' => array(
				esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
				esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
				esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
			),
			'description' => esc_html__( 'Select the horizontal position of the content.', 'wolf-visual-composer' ),
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Default Text Alignment', 'wolf-visual-composer' ),
			'param_name' => 'text_alignment',
			'value' => array(
				esc_html__( 'Default', 'wolf-visual-composer' ) => 'default',
				esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
				esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
				esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
			),
			'description' => esc_html__( 'Specify the text alignment inside the column. It can be overwritten in some elements.', 'wolf-visual-composer' ),
		),

		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Content Min Height', 'wolf-visual-composer' ),
			'param_name' => 'min_height',
			'placeholder' => 'auto',
		),

		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Content Max Width', 'wolf-visual-composer' ),
			'param_name' => 'max_width',
			'placeholder' => 'auto',
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Column Style', 'wolf-visual-composer' ),
			'param_name' => 'column_style',
			'value' => array(
				esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
				esc_html__( 'Box Shadow', 'wolf-visual-composer' ) => 'box-shadow',
				esc_html__( 'Boxed with Hover Effect', 'wolf-visual-composer' ) => 'boxed',
			),
			'description' => esc_html__( 'Select the horizontal position of the content.', 'wolf-visual-composer' ),
		),

		array(
			'type' => 'dropdown',
			'heading' => __( 'Width', 'wolf-visual-composer' ),
			'edit_field_class' => 'wvc-hidden',
			'param_name' => 'width',
			'value' => array(
				esc_html__( '1 column - 1/12', 'wolf-visual-composer' ) => '1/12',
				esc_html__( '2 columns - 1/6', 'wolf-visual-composer' ) => '1/6',
				esc_html__( '3 columns - 1/4', 'wolf-visual-composer' ) => '1/4',
				esc_html__( '4 columns - 1/3', 'wolf-visual-composer' ) => '1/3',
				esc_html__( '5 columns - 5/12', 'wolf-visual-composer' ) => '5/12',
				esc_html__( '6 columns - 1/2', 'wolf-visual-composer' ) => '1/2',
				esc_html__( '7 columns - 7/12', 'wolf-visual-composer' ) => '7/12',
				esc_html__( '8 columns - 2/3', 'wolf-visual-composer' ) => '2/3',
				esc_html__( '9 columns - 3/4', 'wolf-visual-composer' ) => '3/4',
				esc_html__( '10 columns - 5/6', 'wolf-visual-composer' ) => '5/6',
				esc_html__( '11 columns - 11/12', 'wolf-visual-composer' ) => '11/12',
				esc_html__( '12 columns - 1/1', 'wolf-visual-composer' ) => '1/1',
			),
			'description' => __( 'Select column width.', 'wolf-visual-composer' ),
			'std' => '1/1',
		),
	);
}