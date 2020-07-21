<?php
/**
 * Dropcap shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Shortcodes
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wvc_shortcode_dropcap' ) ) {
	/**
	 * Dropcap shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wvc_shortcode_dropcap( $atts ) {

		extract( shortcode_atts( array(
			'text' => '',
			'font' => '',
			'font_style' => 'normal',
		), $atts ) );

		$style = '';
		$style .= "font-style:$font_style;";

		if ( $font ) {
			$style .= "font-family:$font;";
		}

		return '<span class="wvc-dropcap" style="'. wvc_esc_style_attr( $style ) .'">' . sanitize_text_field( $text ) . '</span>';
	}
	add_shortcode( 'wvc_dropcap', 'wvc_shortcode_dropcap' );
}