<?php
/**
 * BMIC
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'BMI Calculator', 'wolf-visual-composer' ),
		'description' => esc_html__( 'A BMI Calculator Form', 'wolf-visual-composer' ),
		'base' => 'wvc_bmi_calculator',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa dripicons-lifting',
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Calculator Form Subtitle', 'wolf-visual-composer' ),
				'param_name' => 'unit',
				'value' => array(
					esc_html__( 'Metric', 'wolf-visual-composer' ) => 'metric',
					esc_html__( 'Imperial', 'wolf-visual-composer' ) => 'imperial',
				),
			),
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Calculator Form Title', 'wolf-visual-composer' ),
				'param_name' => 'title',
				'value' => esc_html__( 'Calculate Your BMI', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'textarea_html',
				'heading' => esc_html__( 'Calculator Form Subtitle', 'wolf-visual-composer' ),
				'param_name' => 'content',
			),
		),
	)
);

class WPBakeryShortCode_Wvc_BMI_Calculator extends WPBakeryShortCode {}