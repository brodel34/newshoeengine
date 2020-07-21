<?php
/**
 * Next Month shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Shortcodes
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wvc_shortcode_next_month' ) ) {
	/**
	 * Next Month shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wvc_shortcode_next_month( $atts ) {

		$month = ( 12 ===  date( 'm'  ) ) ? '01' : date( 'm' ) + 1;

		return '<span class="wvc-next-month">' .$month . '</span>';
	}
	add_shortcode( 'wvc_next_month', 'wvc_shortcode_next_month' );
}