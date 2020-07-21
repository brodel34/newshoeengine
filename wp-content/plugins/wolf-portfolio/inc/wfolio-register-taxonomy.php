<?php
/**
 * Wolf Portfolio register taxonomy
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPortfolio/Admin
 * @version 1.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Portfolio Taxonomy */
$labels = array(
	'name' => esc_html__( 'Portfolio Categories', 'wolf-portfolio' ),
	'singular_name' => esc_html__( 'Portfolio Category', 'wolf-portfolio' ),
	'search_items' => esc_html__( 'Search Portfolio Categories', 'wolf-portfolio' ),
	'popular_items' => esc_html__( 'Popular Portfolio Categories', 'wolf-portfolio' ),
	'all_items' => esc_html__( 'All Portfolio Categories', 'wolf-portfolio' ),
	'parent_item' => esc_html__( 'Parent Portfolio Category', 'wolf-portfolio' ),
	'parent_item_colon' => esc_html__( 'Parent Portfolio Category:', 'wolf-portfolio' ),
	'edit_item' => esc_html__( 'Edit Portfolio Category', 'wolf-portfolio' ),
	'update_item' => esc_html__( 'Update Portfolio Category', 'wolf-portfolio' ),
	'add_new_item' => esc_html__( 'Add New Portfolio Category', 'wolf-portfolio' ),
	'new_item_name' => esc_html__( 'New Portfolio Category', 'wolf-portfolio' ),
	'separate_items_with_commas' => esc_html__( 'Separate portfolio categories with commas', 'wolf-portfolio' ),
	'add_or_remove_items' => esc_html__( 'Add or remove portfolio categories', 'wolf-portfolio' ),
	'choose_from_most_used' => esc_html__( 'Choose from the most used portfolio categories', 'wolf-portfolio' ),
	'not_found' => esc_html__( 'No categories found', 'wolf-portfolio' ),
	'menu_name' => esc_html__( 'Categories', 'wolf-portfolio' ),
);

$args = array(
	'labels' => $labels,
	'hierarchical' => true,
	'public' => true,
	'show_ui' => true,
	'query_var' => true,
	'rewrite' => array( 'slug' => 'work-type', 'with_front' => false ),
);

register_taxonomy( 'work_type', array( 'work' ), $args );