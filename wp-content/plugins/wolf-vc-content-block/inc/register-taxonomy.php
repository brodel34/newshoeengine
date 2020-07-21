<?php
/**
 * Wolf WPBPB Content Blocks register taxonomy
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVcContentBlock/Admin
 * @version 1.0.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Content Block Taxonomy */
$labels = array(
	'name' => esc_html__( 'Content Block Categories', 'wolf-vc-content-block' ),
	'singular_name' => esc_html__( 'Content Block Category', 'wolf-vc-content-block' ),
	'search_items' => esc_html__( 'Search Content Block Categories', 'wolf-vc-content-block' ),
	'popular_items' => esc_html__( 'Popular Content Block Categories', 'wolf-vc-content-block' ),
	'all_items' => esc_html__( 'All Content Block Categories', 'wolf-vc-content-block' ),
	'parent_item' => esc_html__( 'Parent Content Block Category', 'wolf-vc-content-block' ),
	'parent_item_colon' => esc_html__( 'Parent Content Block Category:', 'wolf-vc-content-block' ),
	'edit_item' => esc_html__( 'Edit Content Block Category', 'wolf-vc-content-block' ),
	'update_item' => esc_html__( 'Update Content Block Category', 'wolf-vc-content-block' ),
	'add_new_item' => esc_html__( 'Add New Content Block Category', 'wolf-vc-content-block' ),
	'new_item_name' => esc_html__( 'New Content Block Category', 'wolf-vc-content-block' ),
	'separate_items_with_commas' => esc_html__( 'Separate content block categories with commas', 'wolf-vc-content-block' ),
	'add_or_remove_items' => esc_html__( 'Add or remove content block categories', 'wolf-vc-content-block' ),
	'choose_from_most_used' => esc_html__( 'Choose from the most used content block categories', 'wolf-vc-content-block' ),
	'menu_name' => esc_html__( 'Categories', 'wolf-vc-content-block' ),
);

$args = array(
	'labels' => $labels,
	'hierarchical' => true,
	'public' => true,
	'show_ui' => true,
	'query_var' => true,
	'rewrite' => array( 'slug' => 'content-block-category', 'with_front' => false ),
);

register_taxonomy( 'wvc_content_block_category', array( 'wvc_content_block' ), $args );