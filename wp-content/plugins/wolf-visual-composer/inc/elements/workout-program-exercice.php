<?php
/**
 * Workout Program Exercice
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Exercice', 'wolf-visual-composer' ),
		'base' => 'wvc_workout_program_exercice',
		'as_child' => array( 'only' => 'wvc_workout_program' ),
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa dripicons-lifting',
		'params' => array(
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Name', 'wolf-visual-composer' ),
				'param_name' => 'name',
				'placeholder' => esc_html__( 'Benchpress', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Subtitle', 'wolf-visual-composer' ),
				'param_name' => 'subtitle',
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Instructions', 'wolf-visual-composer' ),
				'param_name' => 'instructions',
				'placeholder' => esc_html__( '4 sets of 8 reps with 1m30 timeout', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Comment', 'wolf-visual-composer' ),
				'param_name' => 'comment',
			),

			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Link', 'wolf-visual-composer' ),
				'param_name' => 'link',
				'description' => esc_html__( 'Link the exercice to a page.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_video_url',
				'heading' => esc_html__( 'Video', 'wolf-visual-composer' ),
				'param_name' => 'video_url',
				'description' => esc_html__( 'An optional YouTube, Vimeo, or mp4 URL to describe the exercice.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Video Image', 'wolf-visual-composer' ),
				'param_name' => 'video_img',
				'description' => esc_html__( 'A thumbnail of the video above.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'attach_images',
				'heading' => esc_html__( 'Gallery', 'wolf-visual-composer' ),
				'param_name' => 'images',
				'description' => esc_html__( 'One or several images that illustrate the exercice.', 'wolf-visual-composer' ),
			),
		),
	)
);

class WPBakeryShortCode_Wvc_Workout_Program_Exercice extends WPBakeryShortCode {}
