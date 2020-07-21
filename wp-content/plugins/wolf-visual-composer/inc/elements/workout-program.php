<?php
/**
 * Workout Program
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Workout Program', 'wolf-visual-composer' ),
		'base' => 'wvc_workout_program',
		'as_parent' => array( 'only' => 'wvc_workout_program_exercice' ),
		'show_settings_on_create' => true,
		'content_element' => true,
		'description' => esc_html__( 'A Lits of Exercices', 'wolf-visual-composer' ),
		'icon' => 'fa dripicons-lifting',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
				'param_name' => 'title',
				'placeholder' => 'My Workout',
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Subtitle', 'wolf-visual-composer' ),
				'param_name' => 'subtitle',
			),
		),
		'js_view' => 'VcColumnView',
	)
);

class WPBakeryShortCode_Wvc_Workout_Program extends WPBakeryShortCodesContainer {}