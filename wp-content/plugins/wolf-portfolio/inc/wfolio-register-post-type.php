<?php
/**
 * Wolf Portfolio register post type
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPortfolio/Admin
 * @version 1.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Register Work post type */
$labels = apply_filters( 'wolf_work_post_type_labels', array(
	'name' => esc_html__( 'Works', 'wolf-portfolio' ),
	'singular_name' => esc_html__( 'Work', 'wolf-portfolio' ),
	'add_new' => esc_html__( 'Add New', 'wolf-portfolio' ),
	'add_new_item' => esc_html__( 'Add New Work', 'wolf-portfolio' ),
	'all_items'  => esc_html__( 'All Works', 'wolf-portfolio' ),
	'edit_item' => esc_html__( 'Edit Work', 'wolf-portfolio' ),
	'new_item' => esc_html__( 'New Work', 'wolf-portfolio' ),
	'view_item' => esc_html__( 'View Work', 'wolf-portfolio' ),
	'search_items' => esc_html__( 'Search Works', 'wolf-portfolio' ),
	'not_found' => esc_html__( 'No Works found', 'wolf-portfolio' ),
	'not_found_in_trash' => esc_html__( 'No Works found in Trash', 'wolf-portfolio' ),
	'parent_item_colon' => '',
	'menu_name' => esc_html__( 'Portfolio', 'wolf-portfolio' ),
) );

$args = array(
	'labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true,
	'show_in_menu' => true,
	'query_var' => false,
	'rewrite' => array( 'slug' => 'work' ),
	'capability_type' => 'post',
	'has_archive' => false,
	'hierarchical' => false,
	'menu_position' => 5,
	'taxonomies' => array(),
	'supports' => array( 'title', 'editor', 'author', 'post-formats', 'thumbnail', 'custom-fields', 'excerpt' ),
	'exclude_from_search' => false,
	'description' => esc_html__( 'Present your work', 'wolf-portfolio' ),
	'menu_icon' => 'dashicons-admin-customizer',
);

register_post_type( 'work', $args );