<?php
/**
 * Typed shortcode template
 *
 * Autotyping text
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'text' => '',
	'tag' => 'h2',
	'text_transform' => '',
	'text_alignment' => 'center',
	'font_weight' => '',
	'font_family' => '',
	'font_size' => '',
	'font_style' => '',
	'text_before' => '',
	'text_after' => '',
	'loop' => true,
	'cursor' => '|',
	'speed' => 100,
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'typed' );
wp_enqueue_script( 'wvc-typed' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$class .= " wvc-typed-container wvc-text-$text_alignment wvc-element";
$text_style = '';
$speed = ( $speed ) ? $speed : 100; //  be sure that speed is not null

$text_style = "font-style:$font_style;font-family:$font_family;font-weight:$font_weight;font-style:$font_style;text-transform:$text_transform;";

if ( $font_size ) {
	$text_style .= 'font-size:' . absint( $font_size ) . 'px;';
}

$rand_id = rand( 0,999 );
$output = '';

$strings_data = '';

$strings_array = wvc_texarea_lines_to_array( $text );
foreach ( $strings_array as $string ) {
	$strings_data .= '"' . trim( $string ) . '",';
}

$strings_data = substr( $strings_data, 0, -1 );

$output .= '<section class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= '<' . $tag . '>';

if ( $text_before ) {
	$output .= $text_before . ' ';
}

$output .= '<span';
$output .= ' data-string="[' . esc_js( $strings_data ) . ']"
data-cursor="' . esc_attr( $cursor ) . '"
data-loop="' . wvc_shortcode_bool( $loop ) . '"
data-speed="' . absint( $speed ) . '"';

$output .= ' class="wvc-typed" id="wvc-typed-' . absint( $rand_id ) .'" style="' . wvc_esc_style_attr( $text_style ) . '"></span>';

if ( $text_after ) {
	$output .= '' . $text_after;
}

$output .= '</' . $tag . '>';

$output .= '</section>';

echo $output;