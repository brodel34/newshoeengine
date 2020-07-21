<?php
/**
 * Text block shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), apply_filters( 'wvc_raw_column_text_atts', $atts ) );

extract( shortcode_atts( array(
	'css_animation' => '',
	'css_animation_delay' => '',
	'hide_class' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), apply_filters( 'wvc_column_text_atts', $atts ) ) );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

$class .= " $hide_class"; // device visibility class

$class .= " wvc-text-block wvc-clearfix wvc-element";

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );

$output .= '>';

$output .= '<div class="wbp_wrapper">';

$output .= wpb_js_remove_wpautop( wvc_sanitize_text_block( $content ), true );

$output .= '</div><!--.wbp_wrapper-->';

$output .= '</div><!--.wvc-text-block-->';

echo $output;