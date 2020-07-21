<?php
/**
 * Section params
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Section general params
 */
function wvc_section_general_params() {
	return array(

		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Min Height', 'wolf-visual-composer' ),
			'param_name' => 'min_height',
			'placeholder' => 'auto',
			'description' => esc_html__( 'Insert the row minimum height in pixel.', 'wolf-visual-composer' ),
			'weight' => 1,
		),

		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Full height section?', 'wolf-visual-composer' ),
			'param_name' => 'full_height',
			'description' => esc_html__( 'If checked section will be set to full height.', 'wolf-visual-composer' ),
			'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes' ),
			'weight' => 1,
		),

		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Add pointing down arrow', 'wolf-visual-composer' ),
			'description' => esc_html__( 'Allow user to scroll to the next section when clicking on the arrow', 'wolf-visual-composer' ),
			'param_name' => 'arrow_down',
			'weight' => 1,
		),

		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Arrow Caption', 'wolf-visual-composer' ),
			'param_name' => 'arrow_down_text',
			'placeholder' => esc_html__( 'Continue', 'wolf-visual-composer' ),
			'weight' => 1,
		),
		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Section name', 'wolf-visual-composer' ),
			'param_name' => 'row_name',
			'description' => esc_html__( 'Required for the onepage scroll, this gives the name to the section.', 'wolf-visual-composer' ),
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
	);
}

/**
 * Section custom params
 */
function wvc_section_custom_params() {
	return array(
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'CSS box', 'wolf-visual-composer' ),
			'param_name' => 'css',
			'group' => esc_html__( 'Custom', 'wolf-visual-composer' ),
			'weight' => -1,
		),
	);
}