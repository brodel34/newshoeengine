<?php
/**
 * RevSlider shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $alias
 * @var $el_class
 * Shortcode class
 * @var $this WPBakeryShortCode_Rev_Slider
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'alias' => '',
	'el_class' => '',
	'inline_style' => '',
), $atts ) );

$output = '';

$class = $el_class;
$inline_style = ( $inline_style ) ? wvc_sanitize_css_field( $inline_style ) : '';

$class .= ' wvc-revslider-container wvc-slider-revolution';

$class = apply_filters( 'wvc_revslider_container_class', $class, $atts );

if ( wvc_get_revslider_id_by_alias( $alias ) ) {
	
	$output .= '<div data-revslider-id="' . absint( wvc_get_revslider_id_by_alias( $alias ) ) . '" class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '">';
	$output .= apply_filters( 'vc_revslider_shortcode', do_shortcode( '[rev_slider ' . $alias . ']' ) );
	$output .= '</div>';

} else {
	// help error message
	$output .= '<div style="margin: auto; line-height: 40px; font-size: 14px; color: #FFF; padding: 15px; background: #E74C3C; margin: 100px auto; width:92%; max-width:750px;">';

	$output .= sprintf( __( 'This slider is missing. If you have imported one of our theme demo content, you can import the slider by following the instruction <a href="%s" target="_blank"><strong>HERE</strong>.</a>', 'wolf-visual-composer' ),
		'https://wolfthemes.ticksy.com/article/12739/'
	);

	$output .= '</div>';
}

echo $output;