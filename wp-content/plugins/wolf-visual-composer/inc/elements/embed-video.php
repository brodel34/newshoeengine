<?php
/**
 * Embed
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Custom Embed Video', 'wolf-visual-composer' ),
		'base' => 'wvc_embed_video',
		'description' => esc_html__( 'A Vimeo or YouTube video with preview', 'wolf-visual-composer' ),
		'icon' => 'fa fa-play-circle-o',
		'category' => esc_html__( 'Media', 'wolf-visual-composer' ),
		'params' => array(
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Video URL', 'wolf-visual-composer' ),
				'param_name' => 'url',
				'placeholder' => 'https://www.youtube.com/watch?v=fKBweD2hyf4',
				'admin_label' => true,
			),
			
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
				'param_name' => 'title',
				'placeholder' => esc_html__( 'My video title', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Cover Image', 'wolf-visual-composer' ),
				'param_name' => 'image',
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_video_url',
				'heading' => esc_html__( 'Custom Video Preview (optional)', 'wolf-visual-composer' ),
				'param_name' => 'video_preview',
				'description' => esc_html__( 'A short mp4 video file', 'wolf-visual-composer' ),
				'admin_label' => true,
			),
		),
	)
);

class WPBakeryShortCode_Wvc_Embed_Video extends WPBakeryShortCode {}