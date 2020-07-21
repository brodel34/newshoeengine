<?php
/**
 * Spotify shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'url' => '',
	'type' => '',
	'width' => '',
	'height' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$output = $cover_style = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$class .= " wvc-spotify-player-container wvc-element";

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) .'"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

if ( 'compact' === $type ) {
	$height = 80;
}

if ( preg_match( '/https:\/\/open.spotify.com\/(artist|album|track|playlist)\/([A-Za-z0-9]+)/', $url, $match ) ) {
	if ( isset( $match[1] ) && isset( $match[2] ) ) {
		
		$output .= '<iframe src="https://open.spotify.com/embed/' . esc_attr( $match[1] ) . '/' . esc_attr( $match[2] ) . '" width="' . absint( $width ) . '" height="' . absint( $height ) . '" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>';
	}
}

$output .= '</div><!-- .wvc-spotify-container -->';

echo $output;