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
	'src' => '',
	'poster' => '',
	'preload' => '',
	'autoplay' => '',
	'loop' => '',
	'ogg' => '',
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

$video_attrs = array(
	'src' => esc_url( $src ),
	'poster' => wvc_get_url_from_attachment_id( $poster, 'large' ),
	'loop' => $loop,
	'autoplay' => $autoplay,
	'preload'  => esc_attr( $preload ),
);

$class .= ' wvc-video-shortcode-container wvc-element';

$output .= '<div  class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= wp_video_shortcode( $video_attrs );

$output .= '</div><!-- .wvc-video-shortcode-container -->';

echo $output;