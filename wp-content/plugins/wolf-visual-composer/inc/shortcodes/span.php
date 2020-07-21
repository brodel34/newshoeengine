<?php
/**
 * Span shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Shortcodes
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wvc_shortcode_span' ) ) {
	/**
	 * Span shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wvc_shortcode_span( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'id' => '',
			'class' => '',
			'style' => '',
		), $atts ) );

		$output = '<span id="' . esc_attr( $id ) . '" class="' . wvc_sanitize_html_classes( $class ) . '" style="' . esc_attr( $style ) . '">' . do_shortcode( $content )  . '</span>';

		return $output;
	}
	add_shortcode( 'wvc_span', 'wvc_shortcode_span' );
}