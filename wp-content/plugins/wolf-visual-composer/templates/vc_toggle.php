<?php
/**
 * Video shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'h4' => '',
	//'content' => '',
	'open' => false,
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'wvc-toggles' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$title = $h4;

wp_enqueue_script( 'wvc-toggles' );

$class .= ' wvc-toggle wvc-element';
$content_class = 'wvc-toggle-content';

if ( $open ) {
	$class .= ' wvc-toggle-open';
} else {
	$class .= ' wvc-toggle-close';
}

/*Animate */
//$class .= wvc_get_css_animation( $css_animation );

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );

$output .= '>';

	$output .= '<h5 class="wvc-toggle-title"><span class="wvc-toggle-plus"></span><span class="wvc-toggle-title-text">' . sanitize_text_field( $title ) . '</span></h5>';
	$output .= '<div class="' . wvc_sanitize_html_classes( $content_class ) . '">';
	$output .= wpb_js_remove_wpautop( apply_filters( 'the_content', $content ), true );
	$output .= '</div><!--.wvc-toggle-content-->';
$output .= '</div>';

echo $output;