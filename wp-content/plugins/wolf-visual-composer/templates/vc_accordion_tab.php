<?php
/**
 * Accordion tab shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'title' => '',
	'add_icon' => '',
	'font_family' => '',
	'i_type' => '',
	'i_icon' => 'line-icon-bulb',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$output = $icon_class = $icon_style = '';

vc_icon_element_fonts_enqueue( $i_type );

$icon = ( isset( $atts["i_icon_$i_type"] ) ) ? $atts["i_icon_$i_type"] : '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

$output = '';

$class .= ' wvc-accordion-tab';

if ( $add_icon ) {
	$class .= ' .wvc-at-has-icon';
}

$output .= '<h5 class="' . wvc_sanitize_html_classes( $class ) . '"><a href="#">';

$output .= '<span class="wvc-at-title-container">';

if ( $add_icon ) {
	$icon_class .= ' fa ' . esc_attr( $icon );
	$output .= '<span class="wvc-at-icon-container"><i class="' . wvc_sanitize_html_classes( $icon_class ) . '" style="' . wvc_esc_style_attr( $icon_style ) . '"></i></span>';
}

$output .= '<span class="wvc-at-title-text">';
$output .= sanitize_text_field( $title );
$output .= '</span>';

$output .= '</span>';

$output .= '</a></h5>';
$output .= '<div>';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';

echo $output;