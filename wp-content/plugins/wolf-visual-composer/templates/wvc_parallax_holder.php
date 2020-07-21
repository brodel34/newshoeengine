<?php
/**
 * Parallax holder shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'y_axis' => '-120',
	'smoothness' => '20',
	'z_index' => 0,
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'parallax-scroll' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

if ( $z_index ) {
	$inline_style .= 'z-index:' . absint( $z_index ) . ';';
}

$class .= ' wvc-parallax-holder';

$output = '<div data-parallax="' . esc_js( '{"y":' . $y_axis . ', "smoothness":' . $smoothness . '}' ) . '" class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= wpb_js_remove_wpautop( $content );

$output .= '</div>';

echo $output;