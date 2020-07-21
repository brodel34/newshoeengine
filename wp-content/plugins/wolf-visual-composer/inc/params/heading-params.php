<?php
/**
 * Wolf WPBakery Page Builder Extension custom heading params
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get heading params
 *
 * @return array
 */
function wvc_heading_params() {
	return apply_filters( 'wvc_custom_heading_params', array(
		'name' => esc_html__( 'Heading', 'wolf-visual-composer' ),
		'description' => esc_html__( 'A big title with flexible font size', 'wolf-visual-composer' ),
		'base' => 'vc_custom_heading',
		'category' => esc_html__( 'Typography' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-text-width',
		'params' => array(

			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Text', 'wolf-visual-composer' ),
				'param_name' => 'text',
				'value' => esc_html__( 'My Headline', 'wolf-visual-composer' ),
				'admin_label' => true,
				'description' => sprintf( esc_html__( 'You can use the %s short tag to display the current page title.', 'wolf-visual-composer' ), '{{post_title}}' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Font Size', 'wolf-visual-composer' ),
				'param_name' => 'font_size',
				'value' => apply_filters( 'wvc_default_custom_heading_font_size', 48 ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Behavior', 'wolf-visual-composer' ),
				'param_name' => 'responsive',
				'value' => array(
					esc_html__( 'Static', 'wolf-visual-composer' ) => 'no',
					esc_html__( 'Responsive', 'wolf-visual-composer' ) => 'yes',
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Minimum Font Size', 'wolf-visual-composer' ),
				'param_name' => 'min_font_size',
				'value' => 18,
				'dependency' => array(
					'element' => 'responsive',
					'value' => 'yes',
				),
			),

			array(
				'type' => 'wvc_font_family',
				'heading' => esc_html__( 'Font', 'wolf-visual-composer' ),
				'param_name' => 'font_family',
				'admin_label' => true,
				'std' => apply_filters( 'wvc_default_custom_heading_font_family', '' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Alignment', 'wolf-visual-composer' ),
				'param_name' => 'text_align',
				'value' => array(
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Color', 'wolf-visual-composer' ),
				'param_name' => 'color',
				'value' => array_merge( wvc_get_shared_colors(), array(
						esc_html__( 'Default color', 'wolf-visual-composer' ) => 'default',
						esc_html__( 'Gradient Red', 'wolf-visual-composer' ) => 'gradient-red',
						esc_html__( 'Gradient Green', 'wolf-visual-composer' ) => 'gradient-green',
						esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom',
					)
				),
				'std' => 'default',
				'description' => esc_html__( 'Select a text color.', 'wolf-visual-composer' ),
				'param_holder_class' => 'wvc_colored-dropdown',
			),

			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Text Color', 'wolf-visual-composer' ),
				'param_name' => 'custom_color',
				'dependency' => array(
					'element' => 'color',
					'value' => 'custom',
				),
			),


			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Font Weight', 'wolf-visual-composer' ),
				'param_name' => 'font_weight',
				'value' => apply_filters( 'wvc_default_custom_heading_font_weight', 700 ),
				'placeholder' => apply_filters( 'wvc_default_custom_heading_font_weight', 700 ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Transform', 'wolf-visual-composer' ),
				'param_name' => 'text_transform',
				'value' => array(
					esc_html__( 'Default', 'wolf-visual-composer' ) => '',
					esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
					esc_html__( 'Uppercase', 'wolf-visual-composer' ) => 'uppercase',
				),
				'std' => apply_filters( 'wvc_default_custom_heading_text_transform', '' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Font Style', 'wolf-visual-composer' ),
				'param_name' => 'font_style',
				'value' => array(
					esc_html__( 'Default', 'wolf-visual-composer' ) => '',
					esc_html__( 'Italic', 'wolf-visual-composer' ) => 'italic',
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Letter Spacing', 'wolf-visual-composer' ),
				'param_name' => 'letter_spacing',
				'value' => apply_filters( 'wvc_default_custom_heading_letter_spacing', '' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Line Height', 'wolf-visual-composer' ),
				'param_name' => 'line_height',
				'placeholder' => '1',
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
				'type' => 'vc_link',
				'heading' => esc_html__( 'Link', 'wolf-visual-composer' ),
				'param_name' => 'link',
				'placeholder' => 'http://',
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Add Image Background?', 'wolf-visual-composer' ),
				'param_name' => 'add_background',
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Background Image', 'wolf-visual-composer' ),
				'param_name' => 'background_img',
				'value' => '',
				'dependency' => array( 'element' => 'add_background', 'value' => array( 'true' ) ),
				'group' => esc_html__( 'Background', 'wolf-visual-composer' ),
				'weight' => 0,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Background position', 'wolf-visual-composer' ),
				'param_name' => 'background_position',
				'value' => array(
					esc_html__( 'center center', 'wolf-visual-composer' ) => 'center center',
					esc_html__( 'center top', 'wolf-visual-composer' )  => 'center top',
					esc_html__( 'left top', 'wolf-visual-composer' ) => 'left top',
					esc_html__( 'right top', 'wolf-visual-composer' )  => 'right top',
					esc_html__( 'center bottom', 'wolf-visual-composer' )  => 'center bottom',
					esc_html__( 'left bottom', 'wolf-visual-composer' )  => 'left bottom',
					esc_html__( 'right bottom', 'wolf-visual-composer' ) => 'right bottom',
					esc_html__( 'left center', 'wolf-visual-composer' ) => 'left center',
					esc_html__( 'right center', 'wolf-visual-composer' ) => 'right center',
				),
				'dependency' => array( 'element' => 'add_background', 'value' => array( 'true' ) ),
				'group' => esc_html__( 'Background', 'wolf-visual-composer' ),
				'weight' => 0,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Background repeat', 'wolf-visual-composer' ),
				'param_name' => 'background_repeat',
				'value' => array(
					esc_html__( 'no repeat', 'wolf-visual-composer' ) => 'no-repeat',
					esc_html__( 'repeat', 'wolf-visual-composer' ) => 'repeat',
					esc_html__( 'repeat-x', 'wolf-visual-composer' ) => 'repeat-x',
					esc_html__( 'repeat-y', 'wolf-visual-composer' ) => 'repeat-y',
				),
				'dependency' => array( 'element' => 'add_background', 'value' => array( 'true' ) ),
				'group' => esc_html__( 'Background', 'wolf-visual-composer' ),
				'weight' => 0,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Background size', 'wolf-visual-composer' ),
				'param_name' => 'background_size',
				'value' => array(
					esc_html__( 'default', 'wolf-visual-composer' ) => 'inherit',
					esc_html__( 'cover', 'wolf-visual-composer' ) => 'cover',
					esc_html__( 'contain', 'wolf-visual-composer' ) => 'contain',
				),
				'dependency' => array( 'element' => 'add_background', 'value' => array( 'true' ) ),
				'group' => esc_html__( 'Background', 'wolf-visual-composer' ),
				'weight' => 0,
			),
		)
	) );
}