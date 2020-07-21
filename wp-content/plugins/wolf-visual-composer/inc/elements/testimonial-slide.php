<?php
/**
 * Testimonials slide
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Testimonial', 'wolf-visual-composer' ),
		'base' => 'wvc_testimonial_slide',
		'as_child' => array( 'only' => 'wvc_testimonial_slider' ),
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-testimonial',
		'params' => array(
			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Text', 'wolf-visual-composer' ),
				'param_name' => 'text',
				'value' => esc_html__( 'I am very happy with everything.', 'wolf-visual-composer' ),
				'admin_label' => true,
			),
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Signature', 'wolf-visual-composer' ),
				'param_name' => 'name',
				'value' => esc_html__( 'A happy customer', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Avatar', 'wolf-visual-composer' ),
				'param_name' => 'avatar',
			),

			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Link', 'wolf-visual-composer' ),
				'param_name' => 'link',
			),
		),
	)
);

class WPBakeryShortCode_Wvc_Testimonial_Slide extends WPBakeryShortCode {}
