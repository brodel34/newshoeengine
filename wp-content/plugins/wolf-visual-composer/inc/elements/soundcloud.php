<?php
/**
 * Soundcloud
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Soundcloud', 'wolf-visual-composer' ),
		'base' => 'wvc_soundcloud',
		'description' => esc_html__( 'An embed Soundcloud playlist or song', 'wolf-visual-composer' ),
		'icon' => 'fa fa-soundcloud',
		'deprecated' => '4.6',
		'content_element' => false,
		'category' => esc_html__( 'Music' , 'wolf-visual-composer' ),
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Playlist or Song URL', 'wolf-visual-composer' ),
				'param_name' => 'link',
				'placeholder' => 'https://',
				'admin_label' => true,
			),
		),
	)
);

class WPBakeryShortCode_Wvc_Soundcloud extends WPBakeryShortCode {}