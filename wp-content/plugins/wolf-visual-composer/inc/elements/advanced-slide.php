<?php
/**
 * Advanced Slide
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
$button_1_params = vc_map_integrate_shortcode(
	wvc_button_params(),
	'b1_',
	'',
	array(
		'exclude' => array(
			'align',
			'button_block',
			'css_animation',
			'css_anmation_delay',
			'css',
		),
	),
	array(
		'element' => 'add_button_1',
		'value' => 'true',
	)
);
if ( is_array( $button_1_params ) && ! empty( $button_1_params ) ) {
	foreach ( $button_1_params as $key => $param ) {
		if ( is_array( $param ) && ! empty( $param ) ) {
			$button_1_params[ $key ]['group'] = sprintf( esc_html__( 'Button %d', 'wolf-visual-composer' ), 1 );

			if ( isset( $param['admin_label'] ) ) {
				unset( $button_1_params[ $key ]['admin_label'] );
			}
		}
	}
}

$button_2_params = vc_map_integrate_shortcode(
	wvc_button_params(),
	'b2_',
	'',
	array(
		'exclude' => array(
			'align',
			'button_block',
			'css_animation',
			'css_anmation_delay',
			'css',
		),
	),
	array(
		'element' => 'add_button_2',
		'value' => 'true',
	)
);

if ( is_array( $button_2_params ) && ! empty( $button_2_params ) ) {
	foreach ( $button_2_params as $key => $param ) {
		if ( is_array( $param ) && ! empty( $param ) ) {
			$button_2_params[ $key ]['group'] = sprintf( esc_html__( 'Button %d', 'wolf-visual-composer' ), 2 );

			if ( isset( $param['admin_label'] ) ) {
				unset( $button_2_params[ $key ]['admin_label'] );
			}
		}
	}
}
vc_map(
	array(
		'name' => esc_html__( 'Advanced Slide', 'wolf-visual-composer' ),
		'base' => 'wvc_advanced_slide',
		'as_child' => array( 'only' => 'wvc_advanced_slider' ),
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-slides',
		'params' => array_merge(
			array(
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
					'type' => 'checkbox',
					'heading' => esc_html__( 'Video mute button (beta)', 'wolf-visual-composer' ),
					'param_name' => 'video_bg_mute_button',
					'dependency' => array( 'element' => 'background_type', 'value' => array( 'video' ) ),
				),

				/*array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Unmute video by default', 'wolf-visual-composer' ),
					'param_name' => 'video_bg_unmute',
					'dependency' => array( 'element' => 'background_type', 'value' => array( 'video' ) ),
				),*/

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
					'heading' => esc_html__( 'Font Color', 'wolf-visual-composer' ),
					'param_name' => 'font_color',
					'value' => array(
						esc_html__( 'Light', 'wolf-visual-composer' ) => 'light',
						esc_html__( 'Dark', 'wolf-visual-composer' ) => 'dark',
					),
					'group' => esc_html__( 'Caption', 'wolf-visual-composer' ),
					'weight' => 100,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title Type', 'wolf-visual-composer' ),
					'param_name' => 'title_type',
					'value' => array(
						esc_html__( 'Textfield', 'wolf-visual-composer' ) => 'textfield',
						esc_html__( 'Image', 'wolf-visual-composer' ) => 'image',
					),
					'group' => esc_html__( 'Caption', 'wolf-visual-composer' ),
					'weight' => 100,
				),

				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image', 'wolf-visual-composer' ),
					'param_name' => 'image',
					'dependency' => array(
						'element' => 'title_type',
						'value' => array( 'image' ),
					),
					'group' => esc_html__( 'Caption', 'wolf-visual-composer' ),
					'weight' => 100,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
					'param_name' => 'title',
					'placeholder' => esc_html__( 'My Awesome Title', 'wolf-visual-composer' ),
					'display' => true,
					'dependency' => array(
						'element' => 'title_type',
						'value' => array( 'textfield' ),
					),
					'admin_label' => true,
					'group' => esc_html__( 'Caption', 'wolf-visual-composer' ),
					'weight' => 100,
				),

				array(
					'type' => 'wvc_font_family',
					'heading' => esc_html__( 'Title Font', 'wolf-visual-composer' ),
					'param_name' => 'title_font_family',
					'display' => true,
					'dependency' => array(
						'element' => 'title_type',
						'value' => array( 'textfield' ),
					),
					'std' => apply_filters( 'wvc_default_advanced_slide_title_font_family', '' ),
					'group' => esc_html__( 'Caption', 'wolf-visual-composer' ),
					'weight' => 100,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Title Font Weight', 'wolf-visual-composer' ),
					'param_name' => 'title_font_weight',
					'value' => apply_filters( 'wvc_default_advanced_slide_title_font_weight', 700 ),
					'group' => esc_html__( 'Caption', 'wolf-visual-composer' ),
					'weight' => 100,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Title Font Size', 'wolf-visual-composer' ),
					'param_name' => 'title_font_size',
					'value' => apply_filters( 'wvc_default_advanced_slide_title_font_size', 60 ),
					'group' => esc_html__( 'Caption', 'wolf-visual-composer' ),
					'weight' => 100,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title Text Transform', 'wolf-visual-composer' ),
					'param_name' => 'title_text_transform',
					'value' => array(
						esc_html__( 'Default', 'wolf-visual-composer' ) => '',
						esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
						esc_html__( 'Uppercase', 'wolf-visual-composer' ) => 'uppercase',
					),
					'std' => apply_filters( 'wvc_default_advanced_slide_title_text_trasnform', '' ),
					'group' => esc_html__( 'Caption', 'wolf-visual-composer' ),
					'weight' => 100,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Letter Spacing', 'wolf-visual-composer' ),
					'param_name' => 'title_letter_spacing',
					'std' => apply_filters( 'wvc_default_advanced_slide_title_letter_spacing', '' ),
					'group' => esc_html__( 'Caption', 'wolf-visual-composer' ),
					'weight' => 100,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Caption Type', 'wolf-visual-composer' ),
					'param_name' => 'caption_type',
					'value' => array(
						esc_html__( 'Standard text', 'wolf-visual-composer' ) => 'textfield',
						esc_html__( 'Bigger text with semi-transparent background', 'wolf-visual-composer' ) => 'big-text',
					),
					'group' => esc_html__( 'Caption', 'wolf-visual-composer' ),
					'weight' => 100,
				),

				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Caption Text', 'wolf-visual-composer' ),
					'param_name' => 'caption',
					'display' => true,
					'admin_label' => true,
					'group' => esc_html__( 'Caption', 'wolf-visual-composer' ),
					'weight' => 100,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Caption Text Alignment', 'wolf-visual-composer' ),
					'param_name' => 'caption_alignment',
					'value' => array(
						esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
						esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
						esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
					),
					'group' => esc_html__( 'Caption', 'wolf-visual-composer' ),
					'weight' => 100,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Caption Width', 'wolf-visual-composer' ),
					'param_name' => 'caption_width',
					'value' => array(
						esc_html__( 'Large', 'wolf-visual-composer' ) => 'large',
						esc_html__( 'Small', 'wolf-visual-composer' ) => 'small',
						esc_html__( 'Full Width', 'wolf-visual-composer' ) => 'full',
					),
					'group' => esc_html__( 'Caption', 'wolf-visual-composer' ),
					'weight' => 100,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Caption Position', 'wolf-visual-composer' ),
					'param_name' => 'caption_position',
					'value' => array(
						esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
						esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
						esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
					),
					'group' => esc_html__( 'Caption', 'wolf-visual-composer' ),
					'weight' => 100,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Caption Vertical Position', 'wolf-visual-composer' ),
					'param_name' => 'caption_v_align',
					'value' => array(
						esc_html__( 'Middle', 'wolf-visual-composer' ) => 'middle',
						esc_html__( 'Bottom', 'wolf-visual-composer' ) => 'bottom',
						esc_html__( 'Top', 'wolf-visual-composer' ) => 'top',
					),
					'group' => esc_html__( 'Caption', 'wolf-visual-composer' ),
					'weight' => 100,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Caption Order', 'wolf-visual-composer' ),
					'param_name' => 'caption_order',
					'value' => array(
						esc_html__( 'After Title', 'wolf-visual-composer' ) => 'after_title',
						esc_html__( 'Before Title', 'wolf-visual-composer' ) => 'before_title',
					),
					'group' => esc_html__( 'Caption', 'wolf-visual-composer' ),
					'weight' => 100,
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Add a First Button', 'wolf-visual-composer' ),
					'param_name' => 'add_button_1',
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Add a Second Button', 'wolf-visual-composer' ),
					'param_name' => 'add_button_2',
				),
			),
			$button_1_params,
			$button_2_params
		),
	)
);

class WPBakeryShortCode_Wvc_Advanced_Slide extends WPBakeryShortCode {}