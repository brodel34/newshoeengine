<?php
/**
 * Interactive Overlays shortcode template
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

$class .= " wvc-interactive-overlays wvc-interactive-overlays-container wvc-interactive-overlays-container-align-$align wvc-interactive-overlays-container-valign-$v_align wvc-interactive-overlays-container-display-$display";

$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '">';

$output .= '<div class="wvc-interactive-overlays-image-holder"></div>';

$output .= '<div class="wvc-interactive-overlays-content-holder">';

$output .= '<div class="wvc-interactive-overlays-inner">';

$output .= '<div class="wvc-interactive-overlays-content">';

$output .= wpb_js_remove_wpautop( $content );

$output .= '</div>';

$output .= '</div>';

$output .= '</div>';

$output .= '</div>';

echo $output;