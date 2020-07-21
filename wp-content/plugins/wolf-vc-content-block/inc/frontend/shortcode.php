<?php
/**
 * Content Block Shortcode
 *
 * @author WolfThemes
 * @category Frontend
 * @package WolfVcContentBlock/Frontend
 * @version 1.0.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wvb_shortcode' ) ) {
	/**
	 * Content Block Shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wvb_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'id' => '0',
		), $atts ) );

		return wccb_block( $id );
	}
	add_shortcode( 'wvc_content_block', 'wvb_shortcode' );
}