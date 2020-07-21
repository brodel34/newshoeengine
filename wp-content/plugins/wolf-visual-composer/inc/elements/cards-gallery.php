<?php
/**
 * Cards gallery
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Cards Gallery', 'wolf-visual-composer' ),
		'base' => 'wvc_cards_gallery',
		'description' => esc_html__( 'A cascade image gallery', 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-images-alt',
		'category' => esc_html__( 'Media' , 'wolf-visual-composer' ),
		'params' => array(

			array(
				'type' => 'attach_images',
				'heading' => esc_html__( 'Images', 'wolf-visual-composer' ),
				'param_name' => 'images',
				'description' => esc_html__( 'You can set the "large", "medium" and "thumbnail" sizes in the WP media settings.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Image Size', 'wolf-visual-composer' ),
				'param_name' => 'img_size',
				'value' => wvc_get_image_sizes(),
				'description' => esc_html__( 'You can set the "large", "medium" and "thumbnail" sizes in the WP media settings.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Custom Image Size', 'wolf-visual-composer' ),
				'param_name' => 'custom_img_size',
				'description' => esc_html__( 'Enter size in pixels (Example: 200x100 (Width x Height).', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'img_size', 'value' => array( 'custom' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Image Alignment', 'wolf-visual-composer' ),
				'param_name' => 'alignment',
				'value' => array(
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
				),
			),
		)
	)
);

class WPBakeryShortCode_Wvc_Cards_Gallery extends WPBakeryShortCode {}