<?php
/**
 * Interactive Overlay Item
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Interactive Overlay Item', 'wolf-visual-composer' ),
		'base' => 'wvc_interactive_overlay_item',
		'as_child' => array( 'only' => 'wvc_interactive_overlays' ),
		'as_parent' => array ( 'only' => 'vc_button, vc_column_text, vc_custom_heading, vc_empty_space, vc_icon, vc_single_image, vc_video, wvc_album_disc, wvc_audio, wvc_audio_embed, wvc_bigtext, wvc_countdown, wvc_counter, wvc_embed_video, wvc_hours, wvc_item_price, wvc_list, wvc_mailchimp, wvc_playlist, wvc_social_icons, wvc_social_icons_custom, wvc_team_member, wvc_twitter, wvc_video_opener, wvc_video_self_hosted, wvc_advanced_slider, wvc_image_device_slider, rev_slider_vc, wvc_testimonial_slider' ),
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'is_container' => true,
		'content_element' => true,
		'icon' => 'fa fa-television',
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Background Image', 'wolf-visual-composer' ),
				'param_name' => 'image',
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Link Type', 'wolf-visual-composer' ),
				'param_name' => 'link_type',
				'value' => array(
					esc_html__( 'Text', 'wolf-visual-composer' ) => 'text',
					esc_html__( 'Image', 'wolf-visual-composer' ) => 'image',
				),
				'admin_label' => true,
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Link Image', 'wolf-visual-composer' ),
				'param_name' => 'link_image',
				'admin_label' => true,
				'dependency' => array(
					'element' => 'link_type',
					'value' => 'image',
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Text', 'wolf-visual-composer' ),
				'param_name' => 'text',
				'value' => esc_html__( 'About', 'wolf-visual-composer' ),
				'admin_label' => true,
				'dependency' => array(
					'element' => 'link_type',
					'value' => 'text',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Content Skin Tone', 'wolf-visual-composer' ),
				'param_name' => 'font_color',
				'value' => array(
					esc_html__( 'Light Font', 'wolf-visual-composer' ) => 'light',
					esc_html__( 'Dark Font', 'wolf-visual-composer' ) => 'dark',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Content Width', 'wolf-visual-composer' ),
				'param_name' => 'content_width',
				'value' => array(
					sprintf( esc_html__( 'Standard width (%s centered)', 'wolf-visual-composer' ), '1140px' ) => 'standard',
					sprintf( esc_html__( 'Small width (%s centered)', 'wolf-visual-composer' ), '750px' ) => 'small',
					sprintf( esc_html__( 'Large width (%s centered)', 'wolf-visual-composer' ), '98%' ) => 'large',
					sprintf( esc_html__( 'Full width (%s)', 'wolf-visual-composer' ), '100%' ) => 'full',
				),
				'std' => 'standard',
			),
		),
	)
);

class WPBakeryShortCode_Wvc_Interactive_Overlay_Item extends WPBakeryShortCodesContainer {}
