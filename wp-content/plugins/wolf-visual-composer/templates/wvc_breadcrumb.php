<?php
/**
 * Breadcrumb shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'align' => '',
	'font_size' => '',
	'font_weight' => '',
	'text_transform' => '',
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

if ( $font_size ) {
	$font_size = wvc_sanitize_css_value( $font_size );
	$inline_style .= "font-size:$font_size;";
}

if ( $text_transform ) {
	$inline_style .= 'text-transform:' . esc_attr( $text_transform ) . ';';
}

if ( $font_weight ) {
	$inline_style .= 'font-weight:' . absint( $font_weight ) . ';';
}

$class .= ' wvc-breadcrumb wvc-element';

$class .= " wvc-text-$align";

$output .= '<div  class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );

$output .= '>';

$output .= wvc_breadcrumb();

$output .= '</div>';

echo $output;