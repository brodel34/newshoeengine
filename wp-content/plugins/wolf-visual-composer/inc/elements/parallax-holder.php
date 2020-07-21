<?php
/**
 * Parallax Holder
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Parallax Holder', 'wolf-visual-composer' ),
		'description' => esc_html__( '', 'wolf-visual-composer' ),
		'base' => 'wvc_parallax_holder',
		'as_parent' => array(),
		'is_container' => true,
		'content_element' => true,
		'show_settings_on_create' => true,
		'icon' => 'fa fa-align-center ',
		'params' => array(
			array(
				'type' => 'wvc_numeric_slider',
				'heading' => esc_html__( 'Y-Axis', 'wolf-visual-composer' ),
				'param_name' => 'y_axis',
				'min' => -1000,
				'max' => 1000,
				'step' => 20,
				'std' => -120,
			),

			array(
				'type' => 'wvc_numeric_slider',
				'heading' => esc_html__( 'Smoothness', 'wolf-visual-composer' ),
				'param_name' => 'smoothness',
				'min' => 10,
				'max' => 100,
				'step' => 20,
				'std' => 50,
			),

			array(
				'type' => 'wvc_numeric_slider',
				'heading' => esc_html__( 'Z-Index', 'wolf-visual-composer' ),
				'param_name' => 'z_index',
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'std' => 0,
			),
		),
		'js_view' => 'VcColumnView',
	)
);

class WPBakeryShortCode_Wvc_Parallax_Holder extends WPBakeryShortCodesContainer {}