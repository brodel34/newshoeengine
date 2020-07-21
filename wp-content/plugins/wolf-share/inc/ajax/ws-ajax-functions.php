<?php
/**
 * Wolf Share AJAX Functions
 *
 * @author WolfThemes
 * @category Ajax
 * @package WolfShare/Functions
 * @version 1.0.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shares
 *
 * Increment shares meta
 */
function wolf_share_ajax_increment_shares_count() {
	extract( $_POST );
	if ( isset( $_POST['postId'] ) ){
		$post_id = absint( $_POST['postId'] );
		$shares = absint( get_post_meta( $post_id , '_wolf_shares_count', true ) );
		$new_shares = $shares + 1;
		update_post_meta( $post_id, '_wolf_shares_count', $new_shares );
		echo absint( $new_shares );
		exit;
	}
}
add_action( 'wp_ajax_wolf_share_ajax_increment_shares_count', 'wolf_share_ajax_increment_shares_count' );
add_action( 'wp_ajax_nopriv_wolf_share_ajax_increment_shares_count', 'wolf_share_ajax_increment_shares_count' );