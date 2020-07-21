<?php
/**
 * Last Post Big Slider
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$enabled_post_types = array();
$available_post_types = array(
	esc_html__( 'Post', 'wolf-visual-composer' ) => 'post',
	esc_html__( 'Gallery', 'wolf-visual-composer' ) => 'gallery',
	esc_html__( 'Video', 'wolf-visual-composer' ) => 'video',
	esc_html__( 'Event', 'wolf-visual-composer' ) => 'event',
	esc_html__( 'Release', 'wolf-visual-composer' ) => 'release',
	esc_html__( 'Work', 'wolf-visual-composer' ) => 'work',
	esc_html__( 'Artist', 'wolf-visual-composer' ) => 'artist',
	esc_html__( 'Product', 'wolf-visual-composer' ) => 'product',
);

foreach ( $available_post_types as $post_type_name => $post_type ) {
	if ( post_type_exists( $post_type ) ) {
		$enabled_post_types[ $post_type_name ] = $post_type;
	}
}

vc_map(
	array(
		'name' => esc_html__( 'Post Slider', 'wolf-visual-composer' ),
		'base' => 'wvc_post_slider',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'description' => esc_html__( 'Display your last posts in a slider', 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-slides',
		'params' => array(

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Post Type', 'wolf-visual-composer' ),
				'param_name' => 'post_type',
				'value' => $enabled_post_types,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Slider Height', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Enter a value in % or px', 'wolf-visual-composer' ),
				'param_name' => 'slider_height',
				'value' => '650px',
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Count', 'wolf-visual-composer' ),
				'param_name' => 'count',
				'description' => esc_html__( 'Number of post to display', 'wolf-visual-composer' ),
				'value' => 3,
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_font_family',
				'heading' => esc_html__( 'Font', 'wolf-visual-composer' ),
				'param_name' => 'font_family',
				'admin_label' => true,
				'std' => apply_filters( 'wvc_default_custom_heading_font_family', '' ),
				'group' => esc_html( 'Title Font', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Font Weight', 'wolf-visual-composer' ),
				'param_name' => 'font_weight',
				'value' => 700,
				'group' => esc_html( 'Title Font', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Transform', 'wolf-visual-composer' ),
				'param_name' => 'text_transform',
				'value' => array(
					esc_html__( 'Uppercase', 'wolf-visual-composer' ) => 'uppercase',
					esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
				),
				'admin_label' => true,
				'group' => esc_html( 'Title Font', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Behavior', 'wolf-visual-composer' ),
				'param_name' => 'responsive',
				'value' => array(
					esc_html__( 'Responsive', 'wolf-visual-composer' ) => 'yes',
					esc_html__( 'Static', 'wolf-visual-composer' ) => '',
				),
				'group' => esc_html( 'Title Font', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Font Size', 'wolf-visual-composer' ),
				'param_name' => 'font_size',
				'value' => apply_filters( 'wvc_default_custom_heading_font_size', 60 ),
				'group' => esc_html( 'Title Font', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Letter Spacing', 'wolf-visual-composer' ),
				'param_name' => 'letter_spacing',
				'group' => esc_html( 'Title Font', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Offset', 'wolf-visual-composer' ),
				'param_name' => 'offset',
				'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query. If an offset is set, sticky posts will be ignored.', 'wolf-visual-composer' ),
				'group' => esc_html( 'Query', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Ignore Sticky Posts', 'wolf-visual-composer' ),
				'param_name' => 'ignore_sticky_posts',
				'admin_label' => true,
				'group' => esc_html( 'Query', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Post IDs', 'wolf-visual-composer' ),
				'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'wolf-visual-composer' ),
				'param_name' => 'ids',
				'group' => esc_html( 'Query', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Exclude Post IDs', 'wolf-visual-composer' ),
				'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'wolf-visual-composer' ),
				'param_name' => 'exclude_ids',
				'group' => esc_html( 'Query', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Category', 'wolf-visual-composer' ),
				'param_name' => 'category',
				'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'wolf-visual-composer' ),
				'placeholder' => esc_html__( 'my-category, other-category', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'post_type', 'value' => array( 'post' ) ),
				'group' => esc_html( 'Query', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Tags', 'wolf-visual-composer' ),
				'param_name' => 'tag',
				'description' => esc_html__( 'Include only one or several tags. Paste tag slug(s) separated by a comma', 'wolf-visual-composer' ),
				'placeholder' => esc_html__( 'my-tag, other-tag', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'post_type', 'value' => array( 'post' ) ),
				'group' => esc_html( 'Query', 'wolf-visual-composer' ),
			),
		),
	)
);

class WPBakeryShortCode_Wvc_Post_Slider extends WPBakeryShortCode {}