<?php
/**
 * Item price shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'day' => '',
	'hours' => '',
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

$class .= " wvc-hours wvc-clearfix";

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= '<div class="wvc-h-container">';

$output .= '<span class="wvc-h-day">' . sanitize_text_field( $day ) . '</span>';

$output .= '<span class="wvc-h-line"><span class="wvc-h-line-content"></span></span>';

$output .= '<span class="wvc-h-hours">' . sanitize_text_field( $hours ) . '</span>';

$output .= '</div><!-- .wvc-h-container -->';

$output .= '</div><!--.wvc-hours-->';

echo $output;