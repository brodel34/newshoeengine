<?php
/**
 * Meal shortcode template
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
	'subtitle' => '',
	'comment' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'wvc-responsive' );
wp_enqueue_script( 'wvc-print' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$class .= " wvc-meal wvc-printable-element wvc-element";

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

if ( $subtitle || $title ) {
	$output .= '<div class="wvc-meal-head wvc-meal-cell">';

	// Title
	if ( $title ) {
		$output .= '<div class="wvc-meal-title-container">';
			$output .= '<span class="wvc-meal-title">';
			$output .= esc_attr( $title );
			$output .= '</span>';
		$output .= '</div>';
	}

	// Subtitle
	if ( $subtitle ) {
		$output .= '<div class="wvc-meal-subtitle-container">';
			$output .= '<span class="wvc-meal-subtitle">';
			$output .= esc_attr( $subtitle );
			$output .= '</span>';
		$output .= '</div>';
	}

	// Comment
	if ( $comment ) {
		$output .= '<div class="wvc-meal-comment-container">';
			$output .= '<span class="wvc-meal-comment">';
			$output .= esc_attr( $comment );
			$output .= '</span>';
		$output .= '</div>';
	}

	$output .= '<div class="wvc-no-print">';
		$output .= '<button class="' . apply_filters( 'wvc_print_button', '' ) . ' wvc-meal-print-button wvc-do-print">';
			$output .= '<span class="wvc-print-button-text">' . esc_html__( 'Print', 'wolf-visual-composer' ) . '</span>';
		$output .= '</button>';
	$output .= '</div>';

	$output .= '</div>';
}

$output .= wpb_js_remove_wpautop( $content );

$output .= '</div><!-- .wvc-meal -->';

echo $output;