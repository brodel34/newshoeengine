<?php
/**
 * Call to action
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
$button_params = vc_map_integrate_shortcode(
	wvc_button_params(),
	'btn_',
	esc_html( 'Button', 'wolf-visual-composer' ),
	array(
		'exclude' => array(
			'align',
			'button_block',
			'css_animation',
			'css_anmation_delay',
			'css',
		),
	)
);

vc_map(
	array(
		'name' => esc_html__( 'Call to Action', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Catch visitors attention with CTA block', 'wolf-visual-composer' ),
		'base' => 'vc_cta',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-thumbs-o-up',
		'params' => array_merge(
			array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Text Alignment', 'wolf-visual-composer' ),
					'param_name' => 'txt_align',
					'value' => array(
						esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
						esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
						esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
					),
					'description' => esc_html__( 'Select text alignment in "Call to Action" block.', 'wolf-visual-composer' ),
					'weight' => 100, 
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Heading', 'wolf-visual-composer' ),
					'admin_label' => true,
					'param_name' => 'h2',
					'value' => esc_html__( 'Hey! I am first heading line feel free to change me', 'wolf-visual-composer' ),
					'description' => esc_html__( 'Enter text for heading line.', 'wolf-visual-composer' ),
					'weight' => 100, 
				),

				array(
					'type' => 'wvc_font_family',
					'heading' => esc_html__( 'Font', 'wolf-visual-composer' ),
					'param_name' => 'font_family',
					'admin_label' => true,
					'weight' => 100,
					'std' => apply_filters( 'wvc_default_cta_font_family', '' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Font Weight', 'wolf-visual-composer' ),
					'param_name' => 'font_weight',
					'placeholder' => 700,
					'weight' => 100, 
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Font Size', 'wolf-visual-composer' ),
					'param_name' => 'font_size',
					'description' => esc_html__( 'Leave empty to use the default heading font sizes.', 'wolf-visual-composer' ),
					'weight' => 100, 
					'std' => apply_filters( 'wvc_default_cta_font_size', '' ),
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
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Line Height', 'wolf-visual-composer' ),
					'param_name' => 'line_height',
					'placeholder' => '1',
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Subheading', 'wolf-visual-composer' ),
					'admin_label' => true,
					'param_name' => 'h4',
					'placeholder' => esc_html__( 'Optional tagline', 'wolf-visual-composer' ),
					'weight' => 100, 
				),
			),
			$button_params
		),
	)
);