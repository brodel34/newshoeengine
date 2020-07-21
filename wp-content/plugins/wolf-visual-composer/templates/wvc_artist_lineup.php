<?php
/**
 * List shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'before_text' => '',
	'separator' => '',
	'text_align' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );


$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$content = wvc_clean_spaces( $content );
$new_content = '';

$array = explode( '<li>', $content );

if ( $array && is_array( $array ) ) {

	//First element will be empty, so remove it
	unset( $array[0] );
	$array_length = count( $array );

	$new_content .= '<ul>';

	foreach ( $array as $key => $item ) {
			
		$new_content .= '<li>';

		$new_content .= trim( wp_kses( $item, array(
			'strong' => array(),
		) ) );

		if ( $separator && $key !== $array_length ) {
			$new_content .= '<span class="wvc-alu-separator">' . esc_attr( $separator ) . '</span>';
		}

		$new_content .= '</li>';
	}

	$new_content .= '</ul>';

	//var_dump( $new_content );
}

$class .= ' wvc-artist-lineup wvc-element wvc-alu-text-align-' . $text_align;

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

if ( $before_text ) {
	$output .= '<span class="wvc-alu-before-text">' . sanitize_text_field( $before_text ) . '</span>';
}

$output .= wpb_js_remove_wpautop( $new_content );

$output .= '</div><!--.wvc-artist-linup-->';

echo $output;