<?php
/**
 * Video shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'link' => 'http://vimeo.com/86571319',
	'no_cookie' => '',
	'max_width' => 'none',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$url = esc_url( $link );
$max_width = esc_attr( $max_width );

$embed = wp_oembed_get( $url );

$class .= ' wvc-video-container wvc-element';

if ( 'youtube' === wvc_get_video_url_type( $url ) ) {

	$class .= ' wvc-yt';

	if ( $no_cookie ) {
		$embed = str_replace( 'youtube', 'youtube-nocookie', $embed );
	}

} elseif ( 'vimeo' === wvc_get_video_url_type( $url ) ) {
	
	$class .= ' wvc-vimeo';
}

if ( $max_width ) {
	$max_width = ( is_numeric( $max_width ) ) ? $max_width . 'px' : $max_width;
	$inline_style .= "max-width:$max_width;";
}

$output .= '<div  class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= $embed . '</div>';

echo $output;