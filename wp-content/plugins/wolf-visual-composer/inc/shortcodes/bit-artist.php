<?php
/**
 * BIT artist shortcode shortcode (for demo purpose)
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Shortcodes
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wvc_shortcode_bit_artist' ) ) {
	/**
	 * Current Year shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wvc_shortcode_bit_artist( $atts ) {

		return 'Rammstein';
	}
	add_shortcode( 'wvc_bit_artist', 'wvc_shortcode_bit_artist' );
}