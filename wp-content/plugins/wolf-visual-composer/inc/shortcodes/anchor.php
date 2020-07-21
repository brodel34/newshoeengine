<?php
/**
 * Anchor shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Shortcodes
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wvc_shortcode_anchor' ) ) {
	/**
	 * Anchor shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wvc_shortcode_anchor( $atts ) {

		extract( shortcode_atts( array(
			'id' => '',
		), $atts ) );

		return '<div id="' . esc_attr( $id ) . '"></div>';
	}
	add_shortcode( 'wvc_anchor', 'wvc_shortcode_anchor' );
}