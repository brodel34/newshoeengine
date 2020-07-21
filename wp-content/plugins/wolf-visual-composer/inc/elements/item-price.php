<?php
/**
 * Item price
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Item Price', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Presentation of an item or service for sale', 'wolf-visual-composer' ),
		'base' => 'wvc_item_price',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-usd',
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
				'param_name' => 'title',
				'placeholder' => esc_html__( 'Our special', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Title Tag', 'wolf-visual-composer' ),
				'param_name' => 'title_tag',
				'value' => array(
					'h3',
					'h1',
					'h2',
					'h4',
					'h5',
					'h6',
					'span',
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Price', 'wolf-visual-composer' ),
				'param_name' => 'price',
				'placeholder' => '$10.75',
				'admin_label' => true,
			),

			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Text', 'wolf-visual-composer' ),
				'param_name' => 'text',
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Layout', 'wolf-visual-composer' ),
				'param_name' => 'layout',
				'value' => array(
					esc_html__( 'Text only', 'wolf-visual-composer' ) => 'text',
					esc_html__( 'Image at the Top', 'wolf-visual-composer' ) => 'image-top',
					esc_html__( 'Image at Left', 'wolf-visual-composer' ) => 'image-left',
					esc_html__( 'Image at Right', 'wolf-visual-composer' ) => 'image-right',
				),
				'admin_label' => true,
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'wolf-visual-composer' ),
				'param_name' => 'image',
				'dependency' => array(
					'element' => 'layout',
					'value_not_equal_to' => array( 'text' )
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Image Size', 'wolf-visual-composer' ),
				'param_name' => 'img_size',
				'value' => wvc_get_image_sizes(),
				'description' => esc_html__( 'You can set the "large", "medium" and "thumbnail" sizes in the WP media settings.', 'wolf-visual-composer' ),
				'admin_label' => true,
				'dependency' => array(
					'element' => 'layout',
					'value_not_equal_to' => array( 'text' ) ),
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

class WPBakeryShortCode_Wvc_Item_Price extends WPBakeryShortCode {}