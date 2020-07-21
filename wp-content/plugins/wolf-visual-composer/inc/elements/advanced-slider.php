<?php
/**
 * Advanced Slider
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Advanced Slider', 'wolf-visual-composer' ),
		'base' => 'wvc_advanced_slider',
		'as_parent' => array( 'only' => 'wvc_advanced_slide' ),
		'content_element' => true,
		'description' => esc_html__( 'A powerful image/video slider', 'wolf-visual-composer' ),
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

class WPBakeryShortCode_Wvc_Advanced_Slider extends WPBakeryShortCodesContainer {}