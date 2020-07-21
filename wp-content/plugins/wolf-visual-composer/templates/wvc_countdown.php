<?php
/**
 * Count Down shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'date' => '12/24/2020 12:00:00',
	'format' => 'dHMS',
	'custom_format' => '',
	'offset' => -5,
	'message' => esc_html__( 'Done!', 'wolf-visual-composer' ),
	'font_family' => '',
	'font_size' => '',
	'font_weight' => '',
	'number_font_color' => '',
	'number_font_custom_color' => '',
	'text_font_color' => '',
	'text_font_custom_color' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$output = $style_tag = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

$data_number_inline_style = '';

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

wp_enqueue_script( 'countdown' );
wp_enqueue_script( 'wvc-countdown' );

$date = esc_attr( $date );
$offset = esc_attr( $offset );
$message = sanitize_text_field( $message );

$rand_id = rand( 0,999 );
$output = '';

/* Format date */
$date = wp_strip_all_tags( do_shortcode( $date ) );
$format_date = explode( ' ' , $date );
$date = $format_date[0];
$hours =  $format_date[1];
$date = explode( '/', $date );
$year = $date[2];
$month = $date[0];
$day = $date[1];
$hours = explode( ':', $hours );
$hour = $hours[0];
$min = $hours[1];
$sec = $hours[2];

// class
if ( 'custom' === $format && $custom_format ) {
	$format = $custom_format;
}

$format_class = sanitize_title_with_dashes( $format );
$class .= " wvc-countdown-container wvc-cd-$format_class wvc-clearfix wvc-element";

$text_style = 'color:#ffffff;';
$text_style = $text_class = '';

if ( $font_family && 'default' !== $font_family ) {
	$font_family = esc_attr( $font_family );
	$text_style .= "font-family:$font_family;";
}

if ( $font_size ) {
	$font_size = wvc_sanitize_css_value( $font_size );
	$style_tag .= "@media screen and (min-width: 1200px) { #wvc-countdown-$rand_id{ font-size:$font_size;} }";
}

if ( $font_weight ) {
	$font_weight = absint( $font_weight );
	$text_style .= "font-weight:$font_weight;";
}

$colors = wvc_get_shared_colors_hex();

/* Number color */
if ( 'custom' === $number_font_color ) {
	$number_font_color = $number_font_custom_color;
} else {
	$number_font_color = isset( $colors[ $number_font_color ] ) ? $colors[ $number_font_color ] : '';
}

if ( $number_font_color ) {
	$style_tag .= '#wvc-countdown-' . absint( $rand_id ) . ' .countdown-amount{ color:' . wvc_sanitize_color( $number_font_color ) . '; }';
}

/* Text color */
if ( 'custom' === $text_font_color ) {
	$text_font_color = $text_font_custom_color;
} else {
	$text_font_color = isset( $colors[ $text_font_color ] ) ? $colors[ $text_font_color ] : '';
}

if ( $text_font_color ) {
	$style_tag .= '#wvc-countdown-' . absint( $rand_id ) . ' .countdown-period{ color:' . wvc_sanitize_color( $text_font_color ) . '; }';
}

/* Style tag */
if ( $style_tag ) {
	$output .= '<style>';
	$output .= $style_tag;
	$output .= '</style>';
}

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';
$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';
$output .= '<div
	data-format="' . esc_attr( $format ) . '"
	data-year="' . absint( $year ) . '"
	data-month="' . absint( $month ) . '"
	data-day="' . absint( $day ) . '"
	data-hour="' . absint( $hour ) . '"
	data-min="' . absint( $min ) . '"
	data-sec="' . absint( $sec ) . '"
	data-offset="' . intval( $offset ) . '"
	class="wvc-countdown ' . wvc_sanitize_html_classes( $text_class ) . '" id="wvc-countdown-' . absint( $rand_id ) .'" style="' . wvc_esc_style_attr( $text_style ) . '"></div>';
$output .= '</div>';

echo $output;