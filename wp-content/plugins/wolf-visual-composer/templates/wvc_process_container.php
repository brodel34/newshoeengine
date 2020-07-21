<?php
/**
 * Process container shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'show_line' => 'yes',
	'layout' => 'horizontal',
	'size' => 'medium',
	'align' => 'left',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'wvc-process' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$class .= " wvc-process-container wvc-process-container-layout-$layout wvc-process-container-size-$size wvc-process-container-align-$align wvc-process-container-show-line-$show_line wvc-element";

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= '<ol class="wvc-process-list wvc-clearfix">';

$output .= wpb_js_remove_wpautop( $content );

$output .= '</ol></div>';

echo $output;