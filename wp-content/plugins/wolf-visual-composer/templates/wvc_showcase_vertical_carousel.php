<?php
/**
 * Interactive Links shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'wvc-youtube-video-bg' );
//wp_enqueue_script( 'froogaloop' );
wp_enqueue_script( 'vimeo-player' );
wp_enqueue_script( 'wvc-vimeo' );
wp_enqueue_script( 'wvc-showcase-vertical-carousel' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

$class .= " wvc-showcase-vertical-carousel";

$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '">';

$output .= '<div class="wvc-showcase-vertical-carousel-bg-holder wvc-svc-bg-holder-loading"></div>';

$output .= '<div class="wvc-showcase-vertical-carousel-content-holder">';

$output .= '<div class="wvc-showcase-vertical-carousel-inner">';

$output .= '<ul class="wvc-showcase-vertical-carousel-content">';

$output .= wpb_js_remove_wpautop( $content );

$output .= '</ul>';

$output .= '</div>';

$output .= '</div>';

$output .= '</div>';

echo $output;