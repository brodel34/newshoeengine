<?php
/**
 * Anything Slide
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Anything Slide', 'wolf-visual-composer' ),
		'base' => 'wvc_anything_slide',
		'as_child' => array( 'only' => 'wvc_anything_slider' ),
		'as_parent' => array ( 'only' => 'vc_button, vc_column_text, vc_custom_heading, vc_empty_space, vc_icon, vc_single_image, vc_video, wvc_album_disc, wvc_audio, wvc_audio_embed, wvc_bigtext, wvc_countdown, wvc_counter, wvc_embed_video, wvc_hours, wvc_item_price, wvc_list, wvc_mailchimp, wvc_playlist, wvc_social_icons, wvc_social_icons_custom, wvc_team_member, wvc_twitter, wvc_video_opener, wvc_video_self_hosted' ),
		'is_container' => true,
		'content_element' => true,
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-slides',
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Background', 'wolf-visual-composer' ),
				'param_name' => 'background_type',
				'value' => array(
					esc_html__( 'Image and Color', 'wolf-visual-composer' ) => 'image',
					esc_html__( 'Video', 'wolf-visual-composer' ) => 'video',
				),
				'admin_label' => true,
				'weight' => 100,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Background Color', 'wolf-visual-composer' ),
				'param_name' => 'background_color',
				'value' => array_merge( wvc_get_shared_colors(), array(
						esc_html__( 'Default', 'wolf-visual-composer' ) => 'default',
						esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom',
					)
				),
				'std' => 'default',
				'description' => esc_html__( 'Select a background color.', 'wolf-visual-composer' ),
				'param_holder_class' => 'wvc_colored-dropdown',
				'dependency' => array( 'element' => 'background_type', 'value' => array( 'image' ) ),
				'weight' => 100,
			),

			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Background Color', 'wolf-visual-composer' ),
				'param_name' => 'background_custom_color',
				'dependency' => array( 'element' => 'background_type', 'value' => array( 'image' ) ),
				'dependency' => array(
					'element' => 'background_color',
					'value' => 'custom',
				),
				'weight' => 100,
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Background', 'wolf-visual-composer' ),
				'param_name' => 'background_img',
				'dependency' => array( 'element' => 'background_type', 'value' => array( 'image' ) ),
				'weight' => 100,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Background position', 'wolf-visual-composer' ),
				'param_name' => 'background_position',
				'value' => array(
					esc_html__( 'center center', 'wolf-visual-composer' ) => 'center center',
					esc_html__( 'center top', 'wolf-visual-composer' )  => 'center top',
					esc_html__( 'left top', 'wolf-visual-composer' ) => 'left top',
					esc_html__( 'right top', 'wolf-visual-composer' )  => 'right top',
					esc_html__( 'center bottom', 'wolf-visual-composer' )  => 'center bottom',
					esc_html__( 'left bottom', 'wolf-visual-composer' )  => 'left bottom',
					esc_html__( 'right bottom', 'wolf-visual-composer' ) => 'right bottom',
					esc_html__( 'left center', 'wolf-visual-composer' ) => 'left center',
					esc_html__( 'right center', 'wolf-visual-composer' ) => 'right center',
				),
				'dependency' => array( 'element' => 'background_type', 'value' => array( 'image' ) ),
				'weight' => 100,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Background repeat', 'wolf-visual-composer' ),
				'param_name' => 'background_repeat',
				'value' => array(
					esc_html__( 'no repeat', 'wolf-visual-composer' ) => 'no-repeat',
					esc_html__( 'repeat', 'wolf-visual-composer' ) => 'repeat',
					esc_html__( 'repeat-x', 'wolf-visual-composer' ) => 'repeat-x',
					esc_html__( 'repeat-y', 'wolf-visual-composer' ) => 'repeat-y',
				),
				'dependency' => array( 'element' => 'background_type', 'value' => array( 'image' ) ),
				'weight' => 100,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Background size', 'wolf-visual-composer' ),
				'param_name' => 'background_size',
				'value' => array(
					esc_html__( 'cover', 'wolf-visual-composer' ) => 'cover',
					esc_html__( 'default', 'wolf-visual-composer' ) => 'default',
					esc_html__( 'contain', 'wolf-visual-composer' ) => 'contain',
				),
				'dependency' => array( 'element' => 'background_type', 'value' => array( 'image' ) ),
				'weight' => 100,
			),

			array(
				'type' => 'wvc_video_url',
				'heading' => esc_html__( 'Video URL', 'wolf-visual-composer' ),
				'param_name' => 'video_bg_url',
				'description' => esc_html__( 'A YouTube or mp4 URL.', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'background_type', 'value' => array( 'video' ) ),
				'weight' => 100,
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Video Image Fallback', 'wolf-visual-composer' ),
				'param_name' => 'video_bg_img',
				'description' => esc_html__( 'Used in case the video can\'t be displayed.', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'background_type', 'value' => array( 'video' ) ),
				'weight' => 100,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Add Overlay', 'wolf-visual-composer' ),
				'param_name' => 'add_overlay',
				'value' => array(
					esc_html__( 'No', 'wolf-visual-composer' ) => '',
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
				),
				'weight' => 100,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Overlay Color', 'wolf-visual-composer' ),
				'param_name' => 'overlay_color',
				'value' => array_merge(
					array( esc_html__( 'Auto', 'wolf-visual-composer' ) => 'auto', ),
					wvc_get_shared_gradient_colors(),
					wvc_get_shared_colors(),
					array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
				),
				'std' => 'black',
				'description' => esc_html__( 'Select an overlay color.', 'wolf-visual-composer' ),
				'param_holder_class' => 'wvc_colored-dropdown',
				'dependency' => array( 'element' => 'add_overlay', 'value' => array( 'yes' ) ),
				'weight' => 100,
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Overlay Custom Color', 'wolf-visual-composer' ),
				'param_name' => 'overlay_custom_color',
				'dependency' => array( 'element' => 'add_overlay', 'value' => array( 'yes' ) ),
				'dependency' => array(
					'element' => 'overlay_color',
					'value' => 'custom',
				),
				'weight' => 100,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Overlay Opacity in Percent', 'wolf-visual-composer' ),
				'param_name' => 'overlay_opacity',
				'value' => '40',
				'dependency' => array( 'element' => 'add_overlay', 'value' => array( 'yes' ) ),
				'weight' => 100,
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

class WPBakeryShortCode_Wvc_Anything_Slide extends WPBakeryShortCodesContainer {}