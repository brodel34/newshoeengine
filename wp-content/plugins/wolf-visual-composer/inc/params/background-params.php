<?php
/**
 * Background params for containers
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sackground params
 */
function wvc_background_params() {
	return array(

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background type', 'wolf-visual-composer' ),
			'param_name' => 'background_type',
			'value' => array(
				esc_html__( 'Default', 'wolf-visual-composer' ) => 'default',
				esc_html__( 'Image and Color', 'wolf-visual-composer' ) => 'image',
				esc_html__( 'Slideshow', 'wolf-visual-composer' ) => 'slideshow',
				esc_html__( 'Video', 'wolf-visual-composer' ) => 'video',
				esc_html__( 'No Background', 'wolf-visual-composer' ) => 'transparent',
				esc_html__( 'Post Featured Image', 'wolf-visual-composer' ) => 'featured_image',
				esc_html__( 'Default WordPress Header', 'wolf-visual-composer' ) => 'default_header',
			),
			'std' => apply_filters( 'wvc_default_background_type', 'default' ),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background Color', 'wolf-visual-composer' ),
			'param_name' => 'background_color',
			'value' => array_merge(
				array( esc_html__( 'Default', 'wolf-visual-composer' ) => 'default', ),
				wvc_get_shared_colors(),
				array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', ),
				array( esc_html__( 'Transparent', 'wolf-visual-composer' ) => 'transparent', )
			),
			'std' => 'default',
			'description' => esc_html__( 'Select a background color.', 'wolf-visual-composer' ),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'param_holder_class' => 'wvc_colored-dropdown',
			'dependency' => array( 'element' => 'background_type', 'value' => array( 'image' ) ),
		),

		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Background Color', 'wolf-visual-composer' ),
			'param_name' => 'background_custom_color',
			'dependency' => array( 'element' => 'background_type', 'value' => array( 'image' ) ),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
			'dependency' => array(
				'element' => 'background_color',
				'value' => 'custom',
			),
		),

		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Background Image', 'wolf-visual-composer' ),
			'param_name' => 'background_img',
			'value' => '',
			'dependency' => array( 'element' => 'background_type', 'value' => array( 'image' ) ),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
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
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
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
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background Size', 'wolf-visual-composer' ),
			'param_name' => 'background_size',
			'value' => array(
				esc_html__( 'cover', 'wolf-visual-composer' ) => 'cover',
				esc_html__( 'default', 'wolf-visual-composer' ) => 'default',
				esc_html__( 'contain', 'wolf-visual-composer' ) => 'contain',
			),
			'dependency' => array( 'element' => 'background_type', 'value' => array( 'image' ) ),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background Effect', 'wolf-visual-composer' ),
			'param_name' => 'background_effect',
			'value' => apply_filters( 'wvc_background_effects', array(
				esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
				esc_html__( 'Parallax', 'wolf-visual-composer' ) => 'parallax',
				esc_html__( 'Zoom', 'wolf-visual-composer' ) => 'zoomin',
				esc_html__( 'Fixed', 'wolf-visual-composer' ) => 'fixed',
				esc_html__( 'Marquee', 'wolf-visual-composer' ) => 'marquee',
				esc_html__( 'Blur', 'wolf-visual-composer' ) => 'blur',
			) ),
			'dependency' => array( 'element' => 'background_type', 'value' => array( 'image', 'default_header', 'featured_image' ) ),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Marquee Image Position', 'wolf-visual-composer' ),
			'param_name' => 'background_marquee_position',
			'value' => array(
				esc_html__( 'stretch', 'wolf-visual-composer' ) => 'stretch',
				esc_html__( 'top', 'wolf-visual-composer' ) => 'top',
				esc_html__( 'middle', 'wolf-visual-composer' ) => 'middle',
				esc_html__( 'bottom', 'wolf-visual-composer' ) => 'bottom',
			),
			'dependency' => array( 'element' => 'background_effect', 'value' => array( 'marquee' ) ),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
		),

		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'LazyLoad', 'wolf-visual-composer' ),
			'param_name' => 'background_img_lazyload',
			'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => true ),
			'std' => true,
			'dependency' => array( 'element' => 'background_type', 'value' => array( 'image', 'default_header', 'featured_image' ) ),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
		),
		array(
			'type' => 'wvc_video_url',
			'heading' => esc_html__( 'Video URL', 'wolf-visual-composer' ),
			'param_name' => 'video_bg_url',
			'value' => '',
			'description' => esc_html__( 'A YouTube, Vimeo, or mp4 URL.', 'wolf-visual-composer' ),
			'dependency' => array( 'element' => 'background_type', 'value' => array( 'video' ) ),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
		),

		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Video Start Time', 'wolf-visual-composer' ),
			'param_name' => 'video_bg_start_time',
			'value' => '',
			'description' => esc_html__( 'Set at which second the video will start (beta).', 'wolf-visual-composer' ),
			'dependency' => array( 'element' => 'background_type', 'value' => array( 'video' ) ),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
		),

		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Video End Time', 'wolf-visual-composer' ),
			'param_name' => 'video_bg_end_time',
			'value' => '',
			'description' => esc_html__( 'Set at which second the video will end (beta).', 'wolf-visual-composer' ),
			'dependency' => array( 'element' => 'background_type', 'value' => array( 'video' ) ),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
		),

		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Video Parallax', 'wolf-visual-composer' ),
			'param_name' => 'video_bg_parallax',
			'value' => '',
			'dependency' => array(
				'element' => 'background_type',
				'value' => array( 'video' )
			),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Loop video.', 'wolf-visual-composer' ),
			'param_name' => 'video_bg_loop',
			'value' => array(
				esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
				esc_html__( 'No', 'wolf-visual-composer' ) => 'no',
			),
			'dependency' => array(
				'element' => 'background_type',
				'value' => array( 'video' )
			),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
			'description' => esc_html__( 'Beta: If set to "No", the video will stop at the end only for YouTube video when parallax is not enabled.', 'wolf-visual-composer' ),
		),

		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Video Image Fallback', 'wolf-visual-composer' ),
			'param_name' => 'video_bg_img',
			'value' => '',
			'description' => esc_html__( 'An image to display when the video is loading.', 'wolf-visual-composer' ),
			'dependency' => array( 'element' => 'background_type', 'value' => array( 'video' ) ),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
		),

		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Video Image Mobile Fallback', 'wolf-visual-composer' ),
			'param_name' => 'video_bg_img_mobile',
			'value' => '',
			'description' => esc_html__( 'An image to display when the video can\'t be played. The image above will be used if empty.', 'wolf-visual-composer' ),
			'dependency' => array( 'element' => 'background_type', 'value' => array( 'video' ) ),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
		),
		array(
			'type' => 'attach_images',
			'heading' => esc_html__( 'Slideshow Images', 'wolf-visual-composer' ),
			'param_name' => 'slideshow_img_ids',
			'dependency' => array( 'element' => 'background_type', 'value' => array( 'slideshow' ) ),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
		),
		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Slideshow Speed', 'wolf-visual-composer' ),
			'param_name' => 'slideshow_speed',
			'description' => esc_html__( 'In milliseconds.', 'wolf-visual-composer' ),
			'placeholder' => 5000,
			'std' => '5000',
			'dependency' => array( 'element' => 'background_type', 'value' => array( 'slideshow' ) ),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Add Overlay', 'wolf-visual-composer' ),
			'param_name' => 'add_overlay',
			'value' => array(
				esc_html__( 'No', 'wolf-visual-composer' ) => '',
				esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
			),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
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
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'param_holder_class' => 'wvc_colored-dropdown',
			'dependency' => array( 'element' => 'add_overlay', 'value' => array( 'yes' ) ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Overlay Custom Color', 'wolf-visual-composer' ),
			'param_name' => 'overlay_custom_color',
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'overlay_color',
				'value' => 'custom',
			),
		),
		array(
			'type' => 'wvc_numeric_slider',
			'heading' => esc_html__( 'Overlay Opacity in Percent', 'wolf-visual-composer' ),
			'param_name' => 'overlay_opacity',
			'description' => '',
			'value' => 60,
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'dependency' => array( 'element' => 'add_overlay', 'value' => array( 'yes' ) ),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Add Top Shape Divider', 'wolf-visual-composer' ),
			'param_name' => 'add_top_shape_divider',
			'value' => array(
				esc_html__( 'No', 'wolf-visual-composer' ) => '',
				esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
			),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Add Bottom Shape Divider', 'wolf-visual-composer' ),
			'param_name' => 'add_bottom_shape_divider',
			'value' => array(
				esc_html__( 'No', 'wolf-visual-composer' ) => '',
				esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
			),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
			'weight' => 0,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Add Particles', 'wolf-visual-composer' ),
			'param_name' => 'add_particles',
			'value' => array(
				esc_html__( 'No', 'wolf-visual-composer' ) => '',
				esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
			),
			'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
		),
	);
}