<?php
/**
 * Info Table shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'values' => '',
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

$values = (array) vc_param_group_parse_atts( $values );

$class .= " wvc-info-table wvc-element";

$output .= '<div  class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );

$output .= '><ul>';

foreach ( $values as $data ) {
	$output .= '<li>';

	$output .= '<span class="wvc-it-label">';
	$output .= sanitize_text_field( $data['label'] );
	$output .= '</span>';

	$output .= '<span class="wvc-it-value">';
	$output .= sanitize_text_field( $data['value'] );
	$output .= '</span>';

	$output .= '</li>';
}

$output .= '</ul></div><!-- .wvc-info-table -->';

echo $output;