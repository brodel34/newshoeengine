<?php
/**
 * Twentytwenty
 *
 * Comparison Images Slider
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Before/After Images Slider', 'wolf-visual-composer' ),
		'description' => esc_html__( 'A before and after images slider', 'wolf-visual-composer' ),
		'base' => 'wvc_comparison_slider',
		'category' => esc_html__( 'Media' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-columns',
		'params' => array(

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Before Image', 'wolf-visual-composer' ),
				'param_name' => 'before_image',
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'After Image', 'wolf-visual-composer' ),
				'param_name' => 'after_image',
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Image Size', 'wolf-visual-composer' ),
				'param_name' => 'img_size',
				'value' => wvc_get_image_sizes(),
				'description' => esc_html__( 'You can set the "large", "medium" and "thumbnail" sizes in the WP media settings.', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Custom Image Size', 'wolf-visual-composer' ),
				'param_name' => 'custom_img_size',
				'description' => esc_html__( 'Enter size in pixels (Example: 200x100 (Width x Height).', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'img_size', 'value' => array( 'custom' ) ),
			),
		)
	)
);

class WPBakeryShortCode_Wvc_Comparison_Slider extends WPBakeryShortCode {}