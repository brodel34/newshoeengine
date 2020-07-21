<?php
/**
 * Counter shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'number' => '',
	'easing' => 'false',
	'grouping' => 'true',
	'text_alignment' => 'center',
	'font_size' => 36,
	'font_weight' => '',
	'seperator' => ',',
	'decimal' => '.',
	'prefix' => '',
	'suffix' => '',
	'shortcode' => '',
	'duration' => '',
	'delay' => '',
	'text' => '',
	'prefix' => '',
	'suffix' => '',
	'add_icon' => '',
	'font_family' => '',
	'i_type' => '',
	'i_icon' => 'line-icon-bulb',
	'text_color' => '',
	'text_custom_color' => '',
	'number_color' => '',
	'number_custom_color' => '',
	'icon_color' => '',
	'icon_custom_color' => '',
	'prefix_color' => '',
	'prefix_custom_color' => '',
	'suffix_color' => '',
	'suffix_custom_color' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'waypoints' );
//wp_enqueue_script( 'jquery-waypoints' );
wp_enqueue_script( 'countup' );
wp_enqueue_script( 'wvc-counter' );

vc_icon_element_fonts_enqueue( $i_type );

$icon = ( isset( $atts["i_icon_$i_type"] ) ) ? $atts["i_icon_$i_type"] : '';

$output = $text_style = $text_class = $number_style = $number_class = $icon_style = $icon_class = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

/* Font */
if ( $font_family ) {
	$font_family = esc_attr( $font_family );
	$number_style .= "font-family:$font_family;";
}

if ( $font_size ) {
	$font_size = wvc_sanitize_css_value( $font_size );
	$number_style .= "font-size:$font_size;";
}

if ( $font_weight ) {
	$font_weight = absint( $font_weight );
	$number_style .= "font-weight:$font_weight;";
}

/* Text color */
if ( 'custom' === $text_color && $text_custom_color ) {
	$text_style .= 'color:' . wvc_sanitize_color( $text_custom_color ) . ';';
} else {
	$text_class .= " wvc-text-color-$text_color"; // color class
}

/* Number color */
if ( 'custom' === $number_color && $number_custom_color ) {
	$number_style .= 'color:' . wvc_sanitize_color( $number_custom_color ) . ';';
} else {
	$number_class .= " wvc-text-color-$number_color"; // color class
}

/* Icon color */
if ( 'custom' === $icon_color && $icon_custom_color ) {
	$icon_style .= 'color:' . wvc_sanitize_color( $icon_custom_color ) . ';';
} else {
	$icon_class .= " wvc-text-color-$icon_color"; // color class
}

$class .= " wvc-counter-container wvc-ct-text-align-$text_alignment wvc-element";
$output = '';
$rand_id = rand( 0,999 );
$duration = ( $duration ) ? float( $duration ) : null;
$delay = ( $delay ) ? absint( $delay ) : null;

$output = '';

$number = ( $shortcode ) ? "[$number]" : $number;

$output .= '<div id="wvc-counter-container-' . absint( $rand_id ) .'" style="' . wvc_esc_style_attr( $inline_style ) . '" class="' . wvc_sanitize_html_classes( $class ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

if ( $add_icon ) {
	
	$icon_class .= ' fa ' . esc_attr( $icon ) . ' fa-3x';
	$output .= '<span class="wvc-counter-icon-container"><i class="' . wvc_sanitize_html_classes( $icon_class ) . '" style="' . wvc_esc_style_attr( $icon_style ) . '"></i></span>';
}

$number_class .= ' wvc-counter';

$output .= '<span class="' . wvc_sanitize_html_classes( $number_class ) . '" style="' . wvc_esc_style_attr( $number_style ) . '" data-prefix="' . esc_attr( $prefix ) . '" data-suffix="' . esc_attr( $suffix ) . '" data-end="' . absint( do_shortcode( $number ) ) . '" data-duration="' . $duration . '" data-delay="' . $delay . '" id="wvc-counter-' . absint( $rand_id ) .'">0</span>';


$text_class .= ' wvc-counter-text';

$output .= '<span style="' . wvc_esc_style_attr( $text_style ) . '" class="' . wvc_sanitize_html_classes( $text_class ) . '">' . sanitize_text_field( $text ) . '</span>';
$output .= '</div><!--.wvc-counter-container-->';

echo $output;