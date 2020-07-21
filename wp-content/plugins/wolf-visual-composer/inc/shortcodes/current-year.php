<?php
/**
 * Current Year shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Shortcodes
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wvc_shortcode_current_year' ) ) {
	/**
	 * Current Year shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wvc_shortcode_current_year( $atts ) {

		return '<span class="wvc-current-year">' . date( 'Y' ) . '</span>';
	}
	add_shortcode( 'wvc_current_year', 'wvc_shortcode_current_year' );
}