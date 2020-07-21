<?php
/**
 * Anything Slider
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Anything Slider', 'wolf-visual-composer' ),
		'base' => 'wvc_anything_slider',
		'as_parent' => array( 'only' => 'wvc_anything_slide' ),
		'content_element' => true,
		'description' => esc_html__( 'Add any element to your slides', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Media' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-slides',
		'params' => array(
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Slider Height', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Enter a value in % or px. 100% for a full height slider.', 'wolf-visual-composer' ),
				'param_name' => 'slider_height',
				'value' => '650px',
			),
		),
		'js_view' => 'VcColumnView',
	)
);

class WPBakeryShortCode_Wvc_Anything_Slider extends WPBakeryShortCodesContainer {}