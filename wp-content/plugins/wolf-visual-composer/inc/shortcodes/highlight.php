<?php
/**
 * Highlight shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Shortcodes
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Highlight  shortcode
 *
 * @param array $atts
 * @param array $content
 * @return string
 */
function wvc_shortcode_highlight( $atts, $content = null ) {

	$color = ( isset( $atts['color'] ) ) ? $atts['color'] : 'yellow';
	return '<span class="wvc-highlight wvc-highlight-' . esc_attr( $atts['color'] ) . '">' . sanitize_text_field( $content ) . '</span>';
}
add_shortcode( 'wvc_highlight', 'wvc_shortcode_highlight' );
