<?php
/**
 * Linked image
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Linked Image', 'wolf-visual-composer' ),
		'description' => esc_html__( 'A linked image with a text overlay', 'wolf-visual-composer' ),
		'base' => 'wvc_image_link',
		'category' => esc_html__( 'Media' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-external-link',
		'params' => array(

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'wolf-visual-composer' ),
				'param_name' => 'image',
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Image Size', 'wolf-visual-composer' ),
				'param_name' => 'img_size',
				'value' => wvc_get_image_sizes(),
				'description' => esc_html__( 'You can set the "large", "medium" and "thumbnail" sizes in the WP media settings.', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'image_grid', 'carousel' ) ),
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
					'center' => esc_html__( 'Center', 'wolf-visual-composer' ),
					'left' => esc_html__( 'Left', 'wolf-visual-composer' ),
					'right' => esc_html__( 'Right', 'wolf-visual-composer' ),
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Alignment', 'wolf-visual-composer' ),
				'param_name' => 'text_alignment',
				'value' => array(
					'center' => esc_html__( 'Center', 'wolf-visual-composer' ),
					'left' => esc_html__( 'Left', 'wolf-visual-composer' ),
					'right' => esc_html__( 'Right', 'wolf-visual-composer' ),
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Vertical Alignment', 'wolf-visual-composer' ),
				'param_name' => 'vertical_alignment',
				'value' => array(
					'middle' => esc_html__( 'Middle', 'wolf-visual-composer' ),
					'left' => esc_html__( 'Left', 'wolf-visual-composer' ),
					'right' => esc_html__( 'Right', 'wolf-visual-composer' ),
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Text', 'wolf-visual-composer' ),
				'param_name' => 'text',
			),

			array(
				'type' => 'wvc_font_family',
				'heading' => esc_html__( 'Font', 'wolf-visual-composer' ),
				'param_name' => 'font_family',
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Tagline', 'wolf-visual-composer' ),
				'param_name' => 'secondary_text',
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Tagline as Button', 'wolf-visual-composer' ),
				'param_name' => 'secondary_text_button',
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Tag', 'wolf-visual-composer' ),
				'param_name' => 'text_tag',
				'value' => array(
					'h3',
					'span',
					'h5',
					'h4',
					'h2',
					'h1',
				),
			),

			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Text Color', 'wolf-visual-composer' ),
				'param_name' => 'text_color',
			),

			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Overlay Color', 'wolf-visual-composer' ),
				'param_name' => 'overlay_color',
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Overlay Opacity in Percent', 'wolf-visual-composer' ),
				'param_name' => 'overlay_opacity',
			),

			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Link', 'wolf-visual-composer' ),
				'param_name' => 'link',
			),
		)
	)
);

class WPBakeryShortCode_Wvc_Image_Link extends WPBakeryShortCode {}