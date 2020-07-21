<?php
/**
 * Wolf WPBakery Page Builder Extension row params
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Row general params
 */
function wvc_row_general_params() {
	return array(

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Column Type', 'wolf-visual-composer' ),
			'param_name' => 'column_type',
			'value' => array(
				esc_html__( 'Columns', 'wolf-visual-composer' ) => 'column',
				esc_html__( 'Blocks', 'wolf-visual-composer' ) => 'block',
			),
			'std' => 'column',
			'description' => esc_html__( 'This will set a default style for your columns.', 'wolf-visual-composer' ),
			'weight' => 1,
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Container Width', 'wolf-visual-composer' ),
			'param_name' => 'container_width',
			'value' => array(
				esc_html__( 'Wide', 'wolf-visual-composer' ) => 'wide',
				esc_html__( 'Boxed', 'wolf-visual-composer' ) => 'boxed',
				esc_html__( 'Small Boxed', 'wolf-visual-composer' ) => 'boxed-small',
				esc_html__( 'Large Boxed', 'wolf-visual-composer' ) => 'boxed-large',
			),
			'std' => 'wide',
			'dependency' => array( 'element' => 'column_type', 'value' => array( 'column' ), ),
			'weight' => 1,
		),

		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Box Shadow', 'wolf-visual-composer' ),
			'param_name' => 'box_shadow',
			'dependency' => array(
				'element' => 'container_width',
				'value_not_equal_to' => array( 'wide' ),
			),
			'weight' => 1,
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Content Width', 'wolf-visual-composer' ),
			'param_name' => 'content_width',
			'value' => array(
				sprintf( esc_html__( 'Standard width (%s centered)', 'wolf-visual-composer' ), apply_filters( 'wvc_row_standard_width', '1140px' ) ) => 'standard',
				sprintf( esc_html__( 'Small width (%s centered)', 'wolf-visual-composer' ), apply_filters( 'wvc_row_small_width', '750px' ) ) => 'small',
				sprintf( esc_html__( 'Large width (%s centered)', 'wolf-visual-composer' ), '98%' ) => 'large',
				sprintf( esc_html__( 'Full width (%s)', 'wolf-visual-composer' ), '100%' ) => 'full',
			),
			'std' => apply_filters( 'wvc_default_row_content_width', 'standard' ),
			'dependency' => array( 'element' => 'container_width', 'value' => array( 'wide' ), ),
			'weight' => 1,
		),

		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Min Height', 'wolf-visual-composer' ),
			'param_name' => 'min_height',
			'placeholder' => 'auto',
			'description' => esc_html__( 'Insert the row minimum height.', 'wolf-visual-composer' ),
			'weight' => 1,
		),

		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Full height row?', 'wolf-visual-composer' ),
			'param_name' => 'full_height',
			'description' => esc_html__( 'If checked row will be set to full height.', 'wolf-visual-composer' ),
			'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes' ),
			'weight' => 1,
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns Position', 'wolf-visual-composer' ),
			'param_name' => 'columns_placement',
			'value' => array(
				esc_html__( 'Default', 'wolf-visual-composer' ) => 'default',
				esc_html__( 'Middle', 'wolf-visual-composer' ) => 'middle',
				esc_html__( 'Top', 'wolf-visual-composer' ) => 'top',
				esc_html__( 'Bottom', 'wolf-visual-composer' ) => 'bottom',
				esc_html__( 'Stretch', 'wolf-visual-composer' ) => 'stretch',
			),
			'description' => esc_html__( 'Select columns position within row.', 'wolf-visual-composer' ),
			'weight' => 1,
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Content Position', 'wolf-visual-composer' ),
			'param_name' => 'content_placement',
			'value' => array(
				esc_html__( 'Default', 'wolf-visual-composer' ) => 'default',
				esc_html__( 'Top', 'wolf-visual-composer' ) => 'top',
				esc_html__( 'Middle', 'wolf-visual-composer' ) => 'middle',
				esc_html__( 'Bottom', 'wolf-visual-composer' ) => 'bottom',
			),
			'description' => esc_html__( 'Select content position within columns.', 'wolf-visual-composer' ),
			'dependency' => array( 'element' => 'column_type', 'value' => array( 'column' ) ),
		),

		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Add pointing down arrow', 'wolf-visual-composer' ),
			'description' => esc_html__( 'Allow user to scroll to the next section when clicking on the arrow', 'wolf-visual-composer' ),
			'param_name' => 'arrow_down',
			'dependency' => array( 'element' => 'column_type', 'value' => array( 'column' ), ),
			'weight' => 1,
		),

		/*array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Mousewheel Scroll Down (beta)', 'wolf-visual-composer' ),
			'description' => esc_html__( 'Scroll to the next section automatically when scrolling down', 'wolf-visual-composer' ),
			'param_name' => 'mousewheel_down',
			'dependency' => array( 'element' => 'column_type', 'value' => array( 'column' ), ),
			'weight' => 1,
		),*/

		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Arrow Caption', 'wolf-visual-composer' ),
			'param_name' => 'arrow_down_text',
			'placeholder' => esc_html__( 'Continue', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'arrow_down',
				'not_empty' => true,
			),
			'weight' => 1,
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Arrow Alignement', 'wolf-visual-composer' ),
			'param_name' => 'arrow_down_alignement',
			'value' => array(
				esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
				esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
				esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
			),
			'dependency' => array(
				'element' => 'arrow_down',
				'not_empty' => true,
			),
			'weight' => 1,
		),

		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Equal height', 'wolf-visual-composer' ),
			'param_name' => 'equal_height',
			'description' => esc_html__( 'If checked columns will be set to equal height.', 'wolf-visual-composer' ),
			'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes' ),
			'std' => 'no',
			'dependency' => array( 'element' => 'column_type', 'value' => array( 'column' ), ),
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
			'type' => 'checkbox',
			'heading' => esc_html__( 'Disable row', 'wolf-visual-composer' ),
			'param_name' => 'disable_element',
			'description' => esc_html__( 'If checked the row won\'t be visible on the public side of your website. You can switch it back any time.', 'wolf-visual-composer' ),
			'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes' ),
		),
		array(
			'type' => 'wvc_numeric_slider',
			'heading' => esc_html__( 'Shift Y-Axis', 'wolf-visual-composer' ),
			'param_name' => 'shift_y',
			'min' => -1000,
			'max' => 1000,
			'step' => 10,
			'std' => 0,
			'group' => esc_html( 'Off-Grid', 'wolf-visual-composer' ),
			'weight' => -100,
		),

		array(
			'type' => 'wvc_numeric_slider',
			'heading' => esc_html__( 'Custom Z-Index', 'wolf-visual-composer' ),
			'param_name' => 'z_index',
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'std' => 0,
			'group' => esc_html( 'Off-Grid', 'wolf-visual-composer' ),
			'weight' => -100,
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
 * Row extra params
 */
function wvc_row_extra_params() {
	return array(
		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Custom Column Gap', 'wolf-visual-composer' ),
			'param_name' => 'gap',
			'description' => esc_html__( 'The space gap between columns.', 'wolf-visual-composer' ),
			'weight' => -5,
			'std' => '',
			'group' => esc_html__( 'Advanced', 'wolf-visual-composer' ),
		),
		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Section name', 'wolf-visual-composer' ),
			'param_name' => 'row_name',
			'description' => esc_html__( 'Required for the onepage scroll, this gives the name to the section.', 'wolf-visual-composer' ),
			'weight' => -5,
			'group' => esc_html__( 'Advanced', 'wolf-visual-composer' ),
		),
	);
}

/**
 * Row shape divider params
 */
function wvc_row_shape_dividers_params() {

	$sd_top = array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Type', 'wolf-visual-composer' ),
			'param_name' => 'sd_top_type',
			'value' => array(
				esc_html__( 'Disabled', 'wolf-visual-composer' ) => 'disabled',
				esc_html__( 'Default', 'wolf-visual-composer' ) => 'default',
				esc_html__( 'Custom Image', 'wolf-visual-composer' ) => 'image',
			),
			'weight' => -5,
			'group' => esc_html__( 'Divider Top', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'add_top_shape_divider',
				'value' => array( 'yes' )
			),
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Shape', 'wolf-visual-composer' ),
			'param_name' => 'sd_top_shape',
			'value' => wvc_get_shape_divider_options(),
			'weight' => -5,
			'group' => esc_html__( 'Divider Top', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'sd_top_type',
				'value' => array( 'default' ),
			),
		),

		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Image', 'wolf-visual-composer' ),
			'param_name' => 'sd_top_img',
			'weight' => -5,
			'group' => esc_html__( 'Divider Top', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'sd_top_type',
				'value' => array( 'image' ),
			),
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Shape Inverted', 'wolf-visual-composer' ),
			'param_name' => 'sd_top_inverted',
			'value' => array(
				esc_html__( 'No', 'wolf-visual-composer' ) => '',
				esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
			),
			'weight' => -5,
			'group' => esc_html__( 'Divider Top', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'sd_top_type',
				'value_not_equal_to' => array( 'disabled' )
			),
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Shape Flip', 'wolf-visual-composer' ),
			'param_name' => 'sd_top_flip',
			'value' => array(
				esc_html__( 'No', 'wolf-visual-composer' ) => '',
				esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
			),
			'weight' => -5,
			'group' => esc_html__( 'Divider Top', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'sd_top_type',
				'value_not_equal_to' => array( 'disabled' )
			),
		),


		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Shape Height', 'wolf-visual-composer' ),
			'param_name' => 'sd_top_height',
			'description' => esc_html__( 'Enter a value in % or px.', 'wolf-visual-composer' ),
			'weight' => -5,
			'placeholder' => '25%',
			'group' => esc_html__( 'Divider Top', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'sd_top_type',
				'value_not_equal_to' => array( 'disabled' )
			),
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Shape Color', 'wolf-visual-composer' ),
			'param_name' => 'sd_top_color',
			'value' => array_merge(
				array( esc_html__( 'Default', 'wolf-visual-composer' ) => 'default', ),
				wvc_get_shared_colors(),
				array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', ),
				array( esc_html__( 'Transparent', 'wolf-visual-composer' ) => 'transparent', )
			),
			'std' => 'default',
			'description' => esc_html__( 'Select a color.', 'wolf-visual-composer' ),
			'group' => esc_html__( 'Divider Top', 'wolf-visual-composer' ),
			'param_holder_class' => 'wvc_colored-dropdown',
			'weight' => -5,
			'dependency' => array(
				'element' => 'sd_top_type',
				'value' => array( 'default' ),
			),
		),

		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Shape Custom Color', 'wolf-visual-composer' ),
			'param_name' => 'sd_top_custom_color',
			'dependency' => array(
				'element' => 'sd_top_color',
				'value' => 'custom',
			),
			'group' => esc_html__( 'Divider Top', 'wolf-visual-composer' ),
			'weight' => -5,
		),

		array(
			'type' => 'wvc_numeric_slider',
			'heading' => esc_html__( 'Shape Opacity', 'wolf-visual-composer' ),
			'param_name' => 'sd_top_opacity',
			'weight' => -5,
			'std' => '',
			'group' => esc_html__( 'Divider Top', 'wolf-visual-composer' ),
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'std' => 100,
			'dependency' => array(
				'element' => 'sd_top_type',
				'value_not_equal_to' => array( 'disabled' )
			),
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Shape Ratio', 'wolf-visual-composer' ),
			'param_name' => 'sd_top_ratio',
			'value' => array(
				esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
				esc_html__( 'No', 'wolf-visual-composer' ) => 'no',
			),
			'weight' => -5,
			'std' => 'yes',
			'group' => esc_html__( 'Divider Top', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'sd_top_type',
				'value_not_equal_to' => array( 'disabled' ),
			),
		),

		array(
			'type' => 'wvc_numeric_slider',
			'heading' => esc_html__( 'Shape Z-Index', 'wolf-visual-composer' ),
			'param_name' => 'sd_top_zindex',
			'weight' => -5,
			'std' => '',
			'group' => esc_html__( 'Divider Top', 'wolf-visual-composer' ),
			'min' => 0,
			'max' => 10,
			'step' => 1,
			'std' => 0,
			'dependency' => array(
				'element' => 'sd_top_type',
				'value_not_equal_to' => array( 'disabled' )
			),
		),
	);

	$sd_bottom = array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Type', 'wolf-visual-composer' ),
			'param_name' => 'sd_bottom_type',
			'value' => array(
				esc_html__( 'Disabled', 'wolf-visual-composer' ) => 'disabled',
				esc_html__( 'Default', 'wolf-visual-composer' ) => 'default',
				esc_html__( 'Custom Image', 'wolf-visual-composer' ) => 'image',
			),
			'weight' => -5,
			'group' => esc_html__( 'Divider Bottom', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'add_bottom_shape_divider',
				'value' => array( 'yes' )
			),
		),

		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Image', 'wolf-visual-composer' ),
			'param_name' => 'sd_bottom_img',
			'weight' => -5,
			'group' => esc_html__( 'Divider Bottom', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'sd_bottom_type',
				'value' => array( 'image' ),
			),
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Shape', 'wolf-visual-composer' ),
			'param_name' => 'sd_bottom_shape',
			'value' => wvc_get_shape_divider_options(),
			'weight' => -5,
			'group' => esc_html__( 'Divider Bottom', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'sd_bottom_type',
				'value' => array( 'default' ),
			),
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Shape Inverted', 'wolf-visual-composer' ),
			'param_name' => 'sd_bottom_inverted',
			'value' => array(
				esc_html__( 'No', 'wolf-visual-composer' ) => '',
				esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
			),
			'weight' => -5,
			'group' => esc_html__( 'Divider Bottom', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'sd_bottom_type',
				'value_not_equal_to' => array( 'disabled' )
			),
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Shape Flip', 'wolf-visual-composer' ),
			'param_name' => 'sd_bottom_flip',
			'value' => array(
				esc_html__( 'No', 'wolf-visual-composer' ) => '',
				esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
			),
			'weight' => -5,
			'group' => esc_html__( 'Divider Bottom', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'sd_bottom_type',
				'value_not_equal_to' => array( 'disabled' )
			),
		),


		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Shape Height', 'wolf-visual-composer' ),
			'param_name' => 'sd_bottom_height',
			'description' => esc_html__( 'Enter a value in % or px.', 'wolf-visual-composer' ),
			'weight' => -5,
			'placeholder' => '25%',
			'group' => esc_html__( 'Divider Bottom', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'sd_bottom_type',
				'value_not_equal_to' => array( 'disabled' )
			),
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Shape Color', 'wolf-visual-composer' ),
			'param_name' => 'sd_bottom_color',
			'value' => array_merge(
				array( esc_html__( 'Default', 'wolf-visual-composer' ) => 'default', ),
				wvc_get_shared_colors(),
				array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', ),
				array( esc_html__( 'Transparent', 'wolf-visual-composer' ) => 'transparent', )
			),
			'std' => 'default',
			'description' => esc_html__( 'Select a color.', 'wolf-visual-composer' ),
			'group' => esc_html__( 'Divider Bottom', 'wolf-visual-composer' ),
			'param_holder_class' => 'wvc_colored-dropdown',
			'weight' => -5,
			'dependency' => array(
				'element' => 'sd_bottom_type',
				'value' => array( 'default' ),
			),
		),

		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Shape Custom Color', 'wolf-visual-composer' ),
			'param_name' => 'sd_bottom_custom_color',
			'dependency' => array(
				'element' => 'sd_bottom_color',
				'value' => 'custom',
			),
			'group' => esc_html__( 'Divider Bottom', 'wolf-visual-composer' ),
			'weight' => -5,
		),

		array(
			'type' => 'wvc_numeric_slider',
			'heading' => esc_html__( 'Shape Opacity', 'wolf-visual-composer' ),
			'param_name' => 'sd_bottom_opacity',
			'weight' => -5,
			'std' => '',
			'group' => esc_html__( 'Divider Bottom', 'wolf-visual-composer' ),
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'std' => 100,
			'dependency' => array(
				'element' => 'sd_bottom_type',
				'value_not_equal_to' => array( 'disabled' )
			),
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Shape Ratio', 'wolf-visual-composer' ),
			'param_name' => 'sd_bottom_ratio',
			'value' => array(
				esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
				esc_html__( 'No', 'wolf-visual-composer' ) => 'no',
			),
			'weight' => -5,
			'std' => 'yes',
			'group' => esc_html__( 'Divider Bottom', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'sd_bottom_type',
				'value_not_equal_to' => array( 'disabled' )
			),
		),

		array(
			'type' => 'wvc_numeric_slider',
			'heading' => esc_html__( 'Shape Z-Index', 'wolf-visual-composer' ),
			'param_name' => 'sd_bottom_zindex',
			'weight' => -5,
			'std' => '',
			'group' => esc_html__( 'Divider Bottom', 'wolf-visual-composer' ),
			'min' => 0,
			'max' => 10,
			'step' => 1,
			'std' => 0,
			'dependency' => array(
				'element' => 'sd_bottom_type',
				'value_not_equal_to' => array( 'disabled' )
			),
		),
	);

	return array_merge(
		$sd_top, $sd_bottom
	);
}