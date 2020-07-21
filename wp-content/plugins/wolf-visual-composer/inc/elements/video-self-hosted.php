<?php
/**
 * Video self hosted
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Self-Hosted Video', 'wolf-visual-composer' ),
		'base' => 'wvc_video_self_hosted',
		'description' => esc_html__( 'Self-hosted video player', 'wolf-visual-composer' ),
		'icon' => 'fa fa-video-camera',
		'category' => esc_html__( 'Media', 'wolf-visual-composer' ),
		'params' => array(

			array(
				'type' => 'wvc_video_url',
				'heading' => esc_html__( 'Video', 'wolf-visual-composer' ),
				'param_name' => 'src',
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'wolf-visual-composer' ),
				'param_name' => 'poster',
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Preload', 'wolf-visual-composer' ),
				'param_name' => 'preload',
				'value' => array(
					esc_html__( 'None', 'wolf-visual-composer' ) => '',
					esc_html__( 'Auto', 'wolf-visual-composer' ) => 'auto',
					esc_html__( 'Metadata', 'wolf-visual-composer' ) => 'metadata',
				),
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Autoplay', 'wolf-visual-composer' ),
				'param_name' => 'autoplay',
				'value' => array(
					'' => 'true'
				),
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Loop', 'wolf-visual-composer' ),
				'param_name' => 'loop',
				'value' => array(
					'' => 'true'
				),
			),
		),
	)
);

class WPBakeryShortCode_Wvc_Video_Self_Hosted extends WPBakeryShortCode {}