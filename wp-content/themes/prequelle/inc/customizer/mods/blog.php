<?php
/**
 * Prequelle customizer blog mods
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function prequelle_set_post_mods( $mods ) {

	$mods['blog'] = array(
		'id' => 'blog',
		'icon' => 'welcome-write-blog',
		'title' => esc_html__( 'Blog', 'prequelle' ),
		'options' => array(

			'post_layout' => array(
				'id' =>'post_layout',
				'label' => esc_html__( 'Blog Archive Layout', 'prequelle' ),
				'type' => 'select',
				'choices' => array(
					'standard' => esc_html__( 'Standard', 'prequelle' ),
					'fullwidth' => esc_html__( 'Full width', 'prequelle' ),
					'sidebar-right' => esc_html__( 'Sidebar at right', 'prequelle' ),
					'sidebar-left' => esc_html__( 'Sidebar at left', 'prequelle' ),
				),
				'transport' => 'postMessage',
				'description' => esc_html__( 'For "Sidebar" layouts, the sidebar will be visible if it contains widgets.', 'prequelle' ),
			),

			'post_display' => array(
				'id' =>'post_display',
				'label' => esc_html__( 'Blog Archive Display', 'prequelle' ),
				'type' => 'select',
				'choices' => apply_filters( 'prequelle_post_display_options', array(
					'standard' => esc_html__( 'Standard', 'prequelle' ),
				) ),
			),

			'post_grid_padding' => array(
				'id' => 'post_grid_padding',
				'label' => esc_html__( 'Padding (for grid style display only)', 'prequelle' ),
				'type' => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'prequelle' ),
					'no' => esc_html__( 'No', 'prequelle' ),
				),
				'transport' => 'postMessage',
			),

			'post_pagination' => array(
				'id' => 'post_pagination',
				'label' => esc_html__( 'Blog Archive Pagination', 'prequelle' ),
				'type' => 'select',
				'choices' => array(
					'standard_pagination' => esc_html__( 'Numeric Pagination', 'prequelle' ),
					'load_more' => esc_html__( 'Load More Button', 'prequelle' ),
				),
			),

			'post_excerpt_type' => array(
				'id' =>'post_excerpt_type',
				'label' => esc_html__( 'Blog Archive Post Excerpt Type', 'prequelle' ),
				'type' => 'select',
				'choices' => array(
					'auto' => esc_html__( 'Auto', 'prequelle' ),
					'manual' => esc_html__( 'Manual', 'prequelle' ),
				),
				'description' => sprintf( prequelle_kses( __( 'Only for the "Standard" display type. To split your post manually, you can use the <a href="%s" target="_blank">"read more"</a> tag.', 'prequelle' ) ), 'https://codex.wordpress.org/Customizing_the_Read_More' ),
			),

			'post_single_layout' => array(
				'id' =>'post_single_layout',
				'label' => esc_html__( 'Single Post Layout', 'prequelle' ),
				'type' => 'select',
				'choices' => array(
					'sidebar-right' => esc_html__( 'Sidebar Right', 'prequelle' ),
					'sidebar-left' => esc_html__( 'Sidebar Left', 'prequelle' ),
					'no-sidebar' => esc_html__( 'No Sidebar', 'prequelle' ),
					'fullwidth' => esc_html__( 'Full width', 'prequelle' ),
				),
			),

			'post_author_box' => array(
				'id' =>'post_author_box',
				'label' => esc_html__( 'Single Post Author Box', 'prequelle' ),
				'type' => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'prequelle' ),
					'no' => esc_html__( 'No', 'prequelle' ),
				),
			),

			'post_related_posts' => array(
				'id' =>'post_related_posts',
				'label' => esc_html__( 'Single Post Related Posts', 'prequelle' ),
				'type' => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'prequelle' ),
					'no' => esc_html__( 'No', 'prequelle' ),
				),
			),

			'post_item_animation' => array(
				'label' => esc_html__( 'Blog Archive Item Animation', 'prequelle' ),
				'id' => 'post_item_animation',
				'type' => 'select',
				'choices' => prequelle_get_animations(),
			),

			'post_display_elements' => array(
				'id' => 'post_display_elements',
				'label' => esc_html__( 'Elements to show by default', 'prequelle' ),
				'type' => 'group_checkbox',
				'choices' => array(
					'show_thumbnail' => esc_html__( 'Thumbnail', 'prequelle' ),
					'show_date' => esc_html__( 'Date', 'prequelle' ),
					'show_text' => esc_html__( 'Text', 'prequelle' ),
					'show_category' => esc_html__( 'Category', 'prequelle' ),
					'show_author' => esc_html__( 'Author', 'prequelle' ),
					'show_tags' => esc_html__( 'Tags', 'prequelle' ),
					'show_extra_meta' => esc_html__( 'Extra Meta', 'prequelle' ),
				),
				'description' => esc_html__( 'Note that some options may be ignored depending on the post display.', 'prequelle' ),
			),
		),
	);

	if ( class_exists( 'Wolf_Custom_Post_Meta' ) ) {

		$mods['blog']['options'][] = array(
			'label' => esc_html__( 'Enable Custom Post Meta', 'prequelle' ),
			'id' => 'enable_custom_post_meta',
			'type' => 'group_checkbox',
			'choices' => array(
				'post_enable_views' => esc_html__( 'Views', 'prequelle' ),
				'post_enable_likes' => esc_html__( 'Likes', 'prequelle' ),
				'post_enable_reading_time' => esc_html__( 'Reading Time', 'prequelle' ),
			),
		);
	}


	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_post_mods' );