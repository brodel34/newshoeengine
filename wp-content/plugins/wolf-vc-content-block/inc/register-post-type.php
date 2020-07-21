<?php
/**
 * Wolf WPBPB Content Blocks register post type
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVcContentBlock/Admin
 * @version 1.0.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Register Content Block post type */
$labels = array(
	'name' => esc_html__( 'Content Blocks', 'wolf-vc-content-block' ),
	'singular_name' => esc_html__( 'Content Block', 'wolf-vc-content-block' ),
	'add_new' => esc_html__( 'Add New', 'wolf-vc-content-block' ),
	'add_new_item' => esc_html__( 'Add New Content Block', 'wolf-vc-content-block' ),
	'all_items'  => esc_html__( 'All Content Blocks', 'wolf-vc-content-block' ),
	'edit_item' => esc_html__( 'Edit Content Block', 'wolf-vc-content-block' ),
	'new_item' => esc_html__( 'New Content Block', 'wolf-vc-content-block' ),
	'view_item' => esc_html__( 'View Content Block', 'wolf-vc-content-block' ),
	'search_items' => esc_html__( 'Search Content Blocks', 'wolf-vc-content-block' ),
	'not_found' => esc_html__( 'No content block found', 'wolf-vc-content-block' ),
	'not_found_in_trash' => esc_html__( 'No content block found in Trash', 'wolf-vc-content-block' ),
	'parent_item_colon' => '',
	'menu_name' => esc_html__( 'Content Block', 'wolf-vc-content-block' ),
);

$args = array(
	'labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true,
	'show_in_menu' => true,
	'query_var' => false,
	'rewrite' => array( 'slug' => 'content-block' ),
	'capability_type' => 'post',
	'has_archive' => false,
	'hierarchical' => false,
	'menu_position' => 5,
	'taxonomies' => array(),
	'supports' => array( 'title', 'editor' ),
	'exclude_from_search' => true,
	'description' => esc_html__( 'Re-usable content for Visual Composer', 'wolf-vc-content-block' ),
	'menu_icon' => 'dashicons-editor-table',
);

register_post_type( 'wvc_content_block', $args );