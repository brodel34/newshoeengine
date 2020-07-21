<?php
/**
 * Wolf WPBakery Page Builder Extension big text params
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
function wvc_bigtext_params() {

	return array(
		'name' => esc_html__( 'Big Text', 'wolf-visual-composer' ),
		'base' => 'wvc_bigtext',
		'description' => esc_html__( 'A big line of text that will take the full width of its container', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Typography' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-text-width',
		'show_settings_on_create' => true,
		'params' => array(

			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Text', 'wolf-visual-composer' ),
				'param_name' => 'text',
				'value' => esc_html__( 'My mega big text', 'wolf-visual-composer' ),
				'admin_label' => true,
				'description' => esc_html__( 'You can add several lines of text.', 'wolf-visual-composer' ) . '<br>' . sprintf( esc_html__( 'You can use the %s short tag to display the current page title.', 'wolf-visual-composer' ), '{{post_title}}' ),
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
				'value' => apply_filters( 'wvc_default_bigtext_font_weight', 700 ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Transform', 'wolf-visual-composer' ),
				'param_name' => 'text_transform',
				'value' => array(
					esc_html__( 'Uppercase', 'wolf-visual-composer' ) => 'uppercase',
					esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
				),
				'admin_label' => true,
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
				'type' => 'dropdown',
				'heading' => esc_html__( 'Font Style', 'wolf-visual-composer' ),
				'param_name' => 'font_style',
				'value' => array(
					esc_html__( 'Default', 'wolf-visual-composer' ) => '',
					esc_html__( 'Italic', 'wolf-visual-composer' ) => 'italic',
				),
			),

			array(
				'type' => 'wvc_font_family',
				'heading' => esc_html__( 'Font', 'wolf-visual-composer' ),
				'param_name' => 'font_family',
				'admin_label' => true,
				'std' => apply_filters( 'wvc_default_bigtext_font_family', '' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Tag', 'wolf-visual-composer' ),
				'param_name' => 'title_tag',
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
		)
	);
}