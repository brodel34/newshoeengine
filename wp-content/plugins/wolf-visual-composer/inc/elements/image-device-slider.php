<?php
/**
 * Images device slider
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Image Slider', 'wolf-visual-composer' ),
		'description' => esc_html__( 'An elegant image slideshow', 'wolf-visual-composer' ),
		'base' => 'wvc_image_device_slider',
		'category' => esc_html__( 'Media' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-laptop',
		'params' => array(
			array(
				'type' => 'attach_images',
				'heading' => esc_html__( 'Images', 'wolf-visual-composer' ),
				'param_name' => 'images',
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Slider Height in Percent', 'wolf-visual-composer' ),
				'param_name' => 'height',
				'placeholder' => 60,
			),

			array(
				'type' => 'hidden',
				'heading' => esc_html__( 'Layout', 'wolf-visual-composer' ),
				'param_name' => 'device',
				'value' => 'default',
			),
		)
	)
);

class WPBakeryShortCode_Wvc_Image_Device_Slider extends WPBakeryShortCode {}