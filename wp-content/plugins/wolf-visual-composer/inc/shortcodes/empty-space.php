<?php
/**
 * Empty space shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Shortcodes
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wvc_shortcode_empty_space' ) ) {
	/**
	 * Empty space shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wvc_shortcode_empty_space( $atts ) {

		extract( shortcode_atts( array(
			'el_height' => 50,
			'el_class' => '',
		), $atts ) );

		$el_height = absint( $el_height );
		$el_height = ( is_numeric( $el_height ) ) ? absint( $el_height ) . 'px' : $el_height;

		$inline_style = '';
		$style .= " height:$el_height;";
		$class = $el_class;
		$class .= ' wvc-clear';

		$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"></div>';

		return $output;
	}
	add_shortcode( 'wvc_empty_space', 'wvc_shortcode_empty_space' );
}