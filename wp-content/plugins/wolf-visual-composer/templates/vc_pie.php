<?php
/**
 * Pie chart
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
	'value' => '',
	'label_value' => '',
	'units' => '',
	'line_width' => '',
	'font_size' => '',
	'font_weight' => '',
	'bar_color' => '#eeeeee',
	'bar_custom_color' => '',
	'color' => '',
	'custom_color' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_id' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'waypoints' );
wp_enqueue_script( 'easypiechart' );
wp_enqueue_script( 'countup' );
wp_enqueue_script( 'wvc-pie' );

$output = $text_style = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$colors = wvc_get_shared_colors_hex();

if ( 'custom' === $bar_color ) {
	$bar_color = $bar_custom_color;
} else {
	$bar_color = isset( $colors[ $bar_color ] ) ? $colors[ $bar_color ] : '';
}

if ( ! $color ) {
	$color = $colors['grey'];
}

if ( 'custom' === $color ) {
	$color = $custom_color;
} else {
	$color = isset( $colors[ $color ] ) ? $colors[ $color ] : '';
}

if ( ! $color ) {
	$color = $colors['grey'];
}

$rand_id = rand( 0,999 );

$class .= ' wvc-pie-container wvc-element';

$output .= '<div id="wvc-pie-' . absint( $rand_id ) .'" class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );

$output .= '>';

if ( '' === $label_value ) {
	$label_value = $value;
}

$output .= '<div class="wvc-pie" data-percent="' . absint( $value ) . '" data-percent-label="' . absint( $label_value ) . '"';

if ( $line_width ) {
	$output .= ' data-line-width="' . absint( $line_width ) . '"';
}

$output .= ' data-unit="' . esc_attr( $units ) . '"';

$output .= ' data-bar-color="' . wvc_sanitize_color( $color ) . '" data-track-color="' . wvc_sanitize_color( $bar_color ) . '"';

$output .= '>';

if ( $font_weight ) {
	$text_style .= 'font-weight:' . absint( $font_weight ) . ';';
}

if ( $font_size ) {
	$text_style .= 'font-size:' . absint( $font_size ) . 'px;';
}

$output .= '<span id="wvc-pie-counter-' . absint( $rand_id ) .'" class="wvc-pie-counter" style="' . wvc_esc_style_attr( $text_style ) . '">0</span>';

$output .= '</div><!-- .wvc-pie -->';

if ( '' !== $title ) {
	$output .= '<h4 class="wvc-heading wvc-pie-heading">' . $title . '</h4>';
}

$output .= '</div><!-- .wvc-pie-container -->';

echo $output;