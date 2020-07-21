<?php
/**
 * Video Switcher
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Video Switcher', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Showcase your last videos', 'wolf-visual-composer' ),
		'base' => 'wvc_video_switcher',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-youtube-play',
		'params' => array(
			
		),
	)
);

class WPBakeryShortCode_Wvc_Video_Switcher extends WPBakeryShortCode {}