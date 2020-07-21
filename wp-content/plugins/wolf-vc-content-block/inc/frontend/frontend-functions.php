<?php
/**
 * Frontend functions
 *
 * @author WolfThemes
 * @category Frontend
 * @package WolfVcContentBlock/Frontend
 * @version 1.0.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return block content
 */
function wccb_block( $id ) {

	$id = absint( apply_filters( 'wpml_object_id', $id, 'post' ) ); // WPML compatibility

	// Be sure that the post exists and that it is not the current post
	if ( get_post_status( $id ) && $id !== get_the_ID() && 'wvc_content_block' === get_post_type( $id ) ) {
		return wvccb_js_remove_wpautop( get_post_field( 'post_content', $id ) );
	}
}

/**
 * Straight from VC
 *
 * @param $content
 * @param bool $autop
 * @return string
 */
function wvccb_js_remove_wpautop( $content, $autop = false ) {

	if ( $autop ) { // Possible to use !preg_match('('.WPBMap::getTagsRegexp().')', $content)
		$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
	}

	return do_shortcode( shortcode_unautop( $content ) );
}