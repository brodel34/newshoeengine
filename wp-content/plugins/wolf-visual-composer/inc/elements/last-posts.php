<?php
/**
 * Last posts
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$last_posts_params = array(

	array(
		'type' => 'wvc_textfield',
		'heading' => esc_html__( 'Count', 'wolf-visual-composer' ),
		'param_name' => 'count',
		'description' => esc_html__( 'Number of post to display', 'wolf-visual-composer' ),
		'value' => 3,
	),

	array(
		'type' => 'wvc_textfield',
		'heading' => esc_html__( 'Post IDs', 'wolf-visual-composer' ),
		'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'wolf-visual-composer' ),
		'param_name' => 'include_ids',
	),

	array(
		'type' => 'wvc_textfield',
		'heading' => esc_html__( 'Exclude Post IDs', 'wolf-visual-composer' ),
		'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'wolf-visual-composer' ),
		'param_name' => 'exclude_ids',
	),

	array(
		'type' => 'wvc_textfield',
		'heading' => esc_html__( 'Category', 'wolf-visual-composer' ),
		'param_name' => 'category',
		'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'wolf-visual-composer' ),
		'placeholder' => esc_html__( 'my-category, other-category', 'wolf-visual-composer' ),
	),

	array(
		'type' => 'wvc_textfield',
		'heading' => esc_html__( 'Tags', 'wolf-visual-composer' ),
		'param_name' => 'tag',
		'description' => esc_html__( 'Include only one or several tags. Paste tag slug(s) separated by a comma', 'wolf-visual-composer' ),
		'placeholder' => esc_html__( 'my-tag, other-tag', 'wolf-visual-composer' ),
	),

	array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Hide Category', 'wolf-visual-composer' ),
		'param_name' => 'hide_category',
		'class' => 'wvc-col-6 wvc-first',
	),

	array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Hide Tags', 'wolf-visual-composer' ),
		'param_name' => 'hide_tag',
		'class' => 'wvc-col-6 wvc-last',
	),

	array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Hide Thumbnail Image', 'wolf-visual-composer' ),
		'param_name' => 'hide_cover',
		'class' => 'wvc-col-6 wvc-first',
	),

	array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Hide Author', 'wolf-visual-composer' ),
		'param_name' => 'hide_author',
		'class' => 'wvc-col-6 wvc-last',
	),

	array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Hide Text', 'wolf-visual-composer' ),
		'param_name' => 'hide_summary',
	),
);
vc_map(
	array(
		'name' => esc_html__( 'Last Posts', 'wolf-visual-composer' ),
		'base' => 'wvc_last_posts',
		'description' => esc_html__( 'Display your last posts in grid or carousel', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa dashicons-before dashicons-admin-post',
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Columns', 'wolf-visual-composer' ),
				'param_name' => 'columns',
				'description' => esc_html__( 'Number of column to display', 'wolf-visual-composer' ),
				'value' => array(
					3,2,4,5,6
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Display', 'wolf-visual-composer' ),
				'param_name' => 'display',
				'value' => array(
					esc_html__( 'Standard', 'wolf-visual-composer' ) => 'standard',
					esc_html__( 'Carousel', 'wolf-visual-composer' ) => 'carousel',
				),
			),
		),
	)
);
vc_add_params( 'wvc_last_posts', $last_posts_params );

class WPBakeryShortCode_Wvc_Last_Posts extends WPBakeryShortCode {}