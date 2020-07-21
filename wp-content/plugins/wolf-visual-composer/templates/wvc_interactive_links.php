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
	'display' => 'block',
	'align' => 'left',
	'v_align' => 'center',
	'font_family' => '',
	'font_size' => '',
	'font_weight' => '',
	'text_transform' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'wvc-youtube-video-bg' );
//wp_enqueue_script( 'froogaloop' );
wp_enqueue_script( 'vimeo-player' );
wp_enqueue_script( 'wvc-vimeo' );
wp_enqueue_script( 'wvc-interactive-links' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

if ( $font_family ) {
	$font_family = esc_attr( $font_family );
	$inline_style .= "font-family:$font_family;";
}

if ( $font_size ) {
	$font_size = wvc_sanitize_css_value( $font_size );
	$inline_style .= "font-size:$font_size;";
}

if ( $font_weight ) {
	$font_weight = absint( $font_weight );
	$inline_style .= "font-weight:$font_weight;";
}

if ( $text_transform ) {
	$text_transform = esc_attr( $text_transform );
	$inline_style .= "text-transform:$text_transform;";
}

$class .= " wvc-interactive-links wvc-interactive-links-container wvc-interactive-links-container-align-$align wvc-interactive-links-container-valign-$v_align wvc-interactive-links-container-display-$display";

$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '">';

$output .= '<div class="wvc-interactive-links-bg-holder wvc-il-bg-holder-loading"></div>';

$output .= '<div class="wvc-interactive-links-content-holder">';

$output .= '<div class="wvc-interactive-links-inner">';

$output .= '<ul class="wvc-interactive-links-content">';

$output .= wpb_js_remove_wpautop( $content );

$output .= '</ul>';

$output .= '</div>';

$output .= '</div>';

$output .= '</div>';

echo $output;