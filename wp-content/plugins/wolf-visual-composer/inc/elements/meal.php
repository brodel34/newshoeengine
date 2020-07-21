<?php
/**
 * Meal
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Meal', 'wolf-visual-composer' ),
		'base' => 'wvc_meal',
		'as_parent' => array( 'only' => 'wvc_meal_item' ),
		'show_settings_on_create' => true,
		'content_element' => true,
		'description' => esc_html__( 'A List of Food item', 'wolf-visual-composer' ),
		'icon' => 'fa fa-cutlery',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
				'param_name' => 'title',
				'placeholder' => 'My Meal',
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Subtitle', 'wolf-visual-composer' ),
				'param_name' => 'subtitle',
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Comment', 'wolf-visual-composer' ),
				'param_name' => 'comment',
			),
		),
		'js_view' => 'VcColumnView',
	)
);

class WPBakeryShortCode_Wvc_Meal extends WPBakeryShortCodesContainer {}