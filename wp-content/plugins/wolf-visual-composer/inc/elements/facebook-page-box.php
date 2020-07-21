<?php
/**
 * Facebook plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => 'Facebook Page Box',
		'base' => 'wvc_facebook_page_box',
		'description' => esc_html__( 'Display a facebook fan box', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Social' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-facebook',
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Facebook Page URL', 'wolf-visual-composer' ),
				'param_name' => 'page_url',
				'value' => wolf_vc_get_option( 'socials', 'facebook' ),
				'admin_label' => true,
			),

			array(
				'heading' => esc_html__( 'Height', 'wolf-visual-composer' ),
				'type' => 'wvc_textfield',
				'param_name' => 'height',
				'value' => 400,
				'admin_label' => true,
			),

			array(
				'heading' => esc_html__( 'Show posts', 'wolf-visual-composer' ),
				'class' => 'wvc-col-6 wvc-first',
				'type' => 'checkbox',
				'param_name' => 'show_posts',
				'value' => 'true',
				'admin_label' => true,
			),

			array(
				'heading' => esc_html__( 'Show faces', 'wolf-visual-composer' ),
				'class' => 'wvc-col-6 wvc-last',
				'type' => 'checkbox',
				'param_name' => 'show_faces',
				'value' => 'true',
				'admin_label' => true,
			),

			array(
				'heading' => esc_html__( 'Hide cover', 'wolf-visual-composer' ),
				'class' => 'wvc-col-6 wvc-first',
				'type' => 'checkbox',
				'param_name' => 'hide_cover',
				'value' => '',
				'admin_label' => true,
			),

			array(
				'heading' => esc_html__( 'Small header', 'wolf-visual-composer' ),
				'class' => 'wvc-col-6 wvc-last',
				'type' => 'checkbox',
				'param_name' => 'small_header',
				'value' => 'false',
				'admin_label' => true,
			),
		)
	)
);

class WPBakeryShortCode_Wvc_Facebook_Page_Box extends WPBakeryShortCode {}
