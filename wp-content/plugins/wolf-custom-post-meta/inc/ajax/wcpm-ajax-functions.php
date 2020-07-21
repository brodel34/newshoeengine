<?php
/**
 * Wolf Custom Post Meta AJAX Functions
 *
 * @author WolfThemes
 * @category Ajax
 * @package WolfCustom Post Meta/Functions
 * @version 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Views
 *
 * Increment views meta
 */
function wolf_custom_post_meta_ajax_increment_views() {

	extract( $_POST );

	if ( isset( $_POST['postId'] ) ){

		$post_id = absint( $_POST['postId'] );
		$views = absint( get_post_meta( $post_id , '_wolf_views_count', true ) );
		$new_views = $views + 1;
		update_post_meta( $post_id, '_wolf_views_count', $new_views );
		echo absint( $new_views );
		exit;
	}
}
add_action( 'wp_ajax_wolf_custom_post_meta_ajax_increment_views', 'wolf_custom_post_meta_ajax_increment_views' );
add_action( 'wp_ajax_nopriv_wolf_custom_post_meta_ajax_increment_views', 'wolf_custom_post_meta_ajax_increment_views' );

/**
 * Likes
 *
 * Increment likes meta
 */
function wolf_custom_post_meta_ajax_increment_likes() {

	extract( $_POST );

	if ( isset( $_POST['postId'] ) ){

		$post_id = absint( $_POST['postId'] );
		$likes = absint( get_post_meta( $post_id , '_wolf_likes_count', true ) );
		$new_likes = $likes + 1;
		update_post_meta( $post_id, '_wolf_likes_count', $new_likes );
		echo wolf_custom_post_meta_format_number( $new_likes );
		exit;
	}
}
add_action( 'wp_ajax_wolf_custom_post_meta_ajax_increment_likes', 'wolf_custom_post_meta_ajax_increment_likes' );
add_action( 'wp_ajax_nopriv_wolf_custom_post_meta_ajax_increment_likes', 'wolf_custom_post_meta_ajax_increment_likes' );