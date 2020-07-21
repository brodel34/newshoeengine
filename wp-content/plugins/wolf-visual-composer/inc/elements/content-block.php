<?php
/**
 * Content Block
 *
 * @package WordPress
 * @subpackage Wolf WPBakery Page Builder Extension
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wolf_Vc_Content_Block' ) ) {
	return;
}

if ( 'wvc_content_block' === wvc_get_current_post_type() ) {
	return;
}

$content_block_posts = get_posts( 'post_type="wvc_content_block"&numberposts=-1' );

$content_blocks = array();
if ( $content_block_posts ) {
	foreach ( $content_block_posts as $content_block_options ) {
		$content_blocks[ $content_block_options->post_title ] = $content_block_options->ID;
	}
} else {
	$content_blocks[ esc_html__( 'No Content Block yet', 'wolf-visual-composer' ) ] = 0;
}

vc_map(
	array(
		'name' => esc_html__( 'Content Block', 'wolf-visual-composer' ),
		'description' => esc_html__( 'A block of content from the Content Block post type', 'wolf-visual-composer' ),
		'base' => 'wvc_content_block',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-editor-table',
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Content Block', 'wolf-visual-composer' ),
				'param_name' => 'id',
				'value' => $content_blocks,
				'admin_label' => true,
			),
		),
		'js_view' => 'WvcContentBlockView',
	)
);

//class WPBakeryShortCode_Wvc_Content_Block extends WPBakeryShortCode {}