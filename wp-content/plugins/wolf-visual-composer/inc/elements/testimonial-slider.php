<?php
/**
 * Testimonials Slider
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Testimonials Slider', 'wolf-visual-composer' ),
		'base' => 'wvc_testimonial_slider',
		'as_parent' => array( 'only' => 'wvc_testimonial_slide' ),
		'show_settings_on_create' => false,
		'content_element' => true,
		'description' => esc_html__( 'Show the feedbacks submitted by your happy customers', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-testimonial',
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Alignment', 'wolf-visual-composer' ),
				'param_name' => 'text_alignment',
				'value' => array(
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
				),
				'std' => apply_filters( 'wvc_default_testimonial_slider_text_alignment', 'center' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Transition', 'wolf-visual-composer' ),
				'param_name' => 'transition',
				'value' => array(
					esc_html__( 'Slide', 'wolf-visual-composer' ) => 'slide',
					esc_html__( 'Fade', 'wolf-visual-composer' ) => 'fade',
				),
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
			),
		), // more params will be added in wvc-elements-additional-settings.php
		'js_view' => 'VcColumnView',
	)
);

class WPBakeryShortCode_Wvc_Testimonial_Slider extends WPBakeryShortCodesContainer {}