<?php
/**
 * Accordion shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'active_tab' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'jquery-ui-accordion' );
wp_enqueue_script( 'wvc-accordion' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$class .= ' wvc-accordion wvc-clearfix wvc-element';

$output .= '<div data-active-tab="' . esc_attr( $active_tab ) . '"';

if ( $inline_style ) {
	$output .= ' style="' . wvc_esc_style_attr( $inline_style ) . '"';
}

if ( $class ) {
	$output .= ' class="' . wvc_sanitize_html_classes( $class ) . '"';
}

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= wpb_js_remove_wpautop( $content );

$output .= '</div><!--.wvc-accordion-->';

echo $output;