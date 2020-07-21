<?php
/**
 * Receipe
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Recipe', 'wolf-visual-composer' ),
		'base' => 'wvc_recipe',
		'description' => esc_html__( 'How to prepare a dish', 'wolf-visual-composer' ),
		'icon' => 'fa fa-cutlery',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
				'param_name' => 'title',
				'placeholder' => 'My Recipe',
				'admin_label' => true,
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'wolf-visual-composer' ),
				'param_name' => 'image',
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Subtitle', 'wolf-visual-composer' ),
				'param_name' => 'subtitle',
			),

			array(
				'type' => 'wvc_int_textfield',
				'heading' => esc_html__( 'Calories', 'wolf-visual-composer' ),
				'param_name' => 'calories',
				'edit_field_class' => 'vc_col-xs-6',
			),

			array(
				'type' => 'wvc_int_textfield',
				'heading' => esc_html__( 'Servings', 'wolf-visual-composer' ),
				'param_name' => 'servings',
				'edit_field_class' => 'vc_col-xs-6',
			),

			array(
				'type' => 'wvc_int_textfield',
				'heading' => esc_html__( 'Protein (in grams)', 'wolf-visual-composer' ),
				'param_name' => 'protein',
				'edit_field_class' => 'vc_col-xs-4',
			),

			array(
				'type' => 'wvc_int_textfield',
				'heading' => esc_html__( 'Carbs (in grams)', 'wolf-visual-composer' ),
				'param_name' => 'carbs',
				'edit_field_class' => 'vc_col-xs-4',
			),

			array(
				'type' => 'wvc_int_textfield',
				'heading' => esc_html__( 'Fat (in grams)', 'wolf-visual-composer' ),
				'param_name' => 'fat',
				'edit_field_class' => 'vc_col-xs-4',
			),

			array(
				'type' => 'wvc_int_textfield',
				'heading' => esc_html__( 'Prep Time (in minutes)', 'wolf-visual-composer' ),
				'param_name' => 'prep_time',
				'edit_field_class' => 'vc_col-xs-6',
			),

			array(
				'type' => 'wvc_int_textfield',
				'heading' => esc_html__( 'Cook Time (in minutes)', 'wolf-visual-composer' ),
				'param_name' => 'cook_time',
				'edit_field_class' => 'vc_col-xs-6',
			),

			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Description', 'wolf-visual-composer' ),
				'param_name' => 'description',
			),

			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Ingredients', 'wolf-visual-composer' ),
				'param_name' => 'ingredients',
				'description' => esc_html__( 'One ingredient per line.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Instructions', 'wolf-visual-composer' ),
				'param_name' => 'instructions',
				'description' => esc_html__( 'One instruction per line.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Notes', 'wolf-visual-composer' ),
				'param_name' => 'notes',
			),
		),
	)
);

class WPBakeryShortCode_Wvc_Recipe extends WPBakeryShortCode {}