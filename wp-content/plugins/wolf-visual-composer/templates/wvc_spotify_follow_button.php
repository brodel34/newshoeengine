<?php
/**
 * Spotify follow button shortcode template
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
	'size' => 'detail',
	'show_count' => true,
	'theme' => 'light',
	'alignment' => '',
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

$class .= " wvc-spotify-follow-button-container wvc-align-$alignment wvc-element";

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) .'"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$width = 300;
$height = 56;

if ( 'basic' === $size ) {
	$width = 200;
	$height = 25;
}

if ( preg_match( '/https:\/\/open.spotify.com\/artist\/([A-Za-z0-9]+)/', $url, $match ) ) {
	if ( isset( $match[1] ) ) {

		$show_count = wvc_shortcode_bool( $show_count );
		
		$output .= '<iframe src="https://open.spotify.com/follow/1/?uri=spotify:artist:' . esc_attr( $match[1] ) . '&size=' . esc_attr( $size ) . '&theme=' . esc_attr( $theme ) . '&show-count=' . esc_attr( $show_count ) . '" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" scrolling="no" frameborder="0" style="border:none; overflow:hidden;" allowtransparency="true"></iframe>';
	}
}

$output .= '</div><!-- .wvc-spotify-container -->';

echo $output;