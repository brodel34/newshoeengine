<?php
/**
 * Row inner params
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Row inner general params
 */
function wvc_row_inner_general_params() {
	return array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Row Width', 'wolf-visual-composer' ),
			'param_name' => 'container_width',
			'value' => array(
				sprintf( esc_html__( 'Inherit', 'wolf-visual-composer' ), apply_filters( 'wvc_row_standard_width', '1140px' ) ) => 'inherit',
				sprintf( esc_html__( 'Standard width (%s centered)', 'wolf-visual-composer' ), apply_filters( 'wvc_row_standard_width', '1140px' ) ) => 'standard',
				sprintf( esc_html__( 'Small width (%s centered)', 'wolf-visual-composer' ), apply_filters( 'wvc_row_small_width', '750px' ) ) => 'small',
			),
			'weight' => 1,
		),

		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Min Height', 'wolf-visual-composer' ),
			'param_name' => 'min_height',
			'placeholder' => 'auto',
			'description' => esc_html__( 'Insert the row minimum height in pixel.', 'wolf-visual-composer' ),
			'weight' => 1,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Visibility', 'wolf-visual-composer' ),
			'param_name' => 'hide_class',
			'value' => array(
				esc_html__( 'Always visible', 'wolf-visual-composer' ) => '',
				esc_html__( 'Hide on tablet and mobile', 'wolf-visual-composer' ) => 'wvc-hide-tablet',
				esc_html__( 'Hide on mobile', 'wolf-visual-composer' ) => 'wvc-hide-mobile',
				esc_html__( 'Show on tablet and mobile only', 'wolf-visual-composer' ) => 'wvc-show-tablet',
				esc_html__( 'Show on mobile only', 'wolf-visual-composer' ) => 'wvc-show-mobile',
				esc_html__( 'Always hidden', 'wolf-visual-composer' ) => 'wvc-hide',
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'wolf-visual-composer' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'wolf-visual-composer' ),
		),

		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Disable row', 'wolf-visual-composer' ),
			'param_name' => 'disable_element',
			'description' => esc_html__( 'If checked the row won\'t be visible on the public side of your website. You can switch it back any time.', 'wolf-visual-composer' ),
			'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes' ),
		),
	);
}