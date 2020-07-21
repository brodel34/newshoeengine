<?php
/**
 * Meal Item
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Meal Item', 'wolf-visual-composer' ),
		'base' => 'wvc_meal_item',
		'as_child' => array( 'only' => 'wvc_meal' ),
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-cutlery',
		'params' => array(
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Name', 'wolf-visual-composer' ),
				'param_name' => 'name',
				'placeholder' => esc_html__( 'Broccoli', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Subtitle', 'wolf-visual-composer' ),
				'param_name' => 'subtitle',
				'placeholder' => esc_html__( 'e.g: 250kCal', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Comment', 'wolf-visual-composer' ),
				'param_name' => 'comment',
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Quantity', 'wolf-visual-composer' ),
				'param_name' => 'quantity',
				'placeholder' => '200g',
				'admin_label' => true,
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'wolf-visual-composer' ),
				'param_name' => 'image',
			),

			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Link', 'wolf-visual-composer' ),
				'param_name' => 'link',
			),
		),
	)
);

class WPBakeryShortCode_Wvc_Meal_Item extends WPBakeryShortCode {}
