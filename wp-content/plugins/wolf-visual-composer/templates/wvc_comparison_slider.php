<?php
/**
 * Comprison slider shortcode template
 *
 * Twentytwenty image slider
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'before_image' => '',
	'after_image' => '',
	'img_size' => 'wvc-XL',
	'custom_img_size' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'event-move' );
wp_enqueue_script( 'twentytwenty' );
wp_enqueue_script( 'wvc-twentytwenty' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

/* Custom Size */
if ( 'custom' === $img_size ) {
	$img_size = esc_attr( $custom_img_size );
}

$class .= ' wvc-twentytwenty twentytwenty wvc-element';

if ( ! $before_image || ! $after_image ) {
	return;
}

$output = '';

if ( ! in_array( $img_size, array( 'thumbnail', 'medium', 'large', 'wvc-XL', 'full' ) ) ) {

	$before_img = wpb_getImageBySize( array(
		'attach_id' => $before_image,
		'thumb_size' => $img_size,
	) );
	$before_image = ( isset( $before_img['thumbnail'] ) ) ? $before_img['thumbnail'] : '';

	$after_img = wpb_getImageBySize( array(
		'attach_id' => $after_image,
		'thumb_size' => $img_size,
	) );
	$after_image = ( isset( $after_img['thumbnail'] ) ) ? $after_img['thumbnail'] : '';

} else {
	$before_image = wp_get_attachment_image( absint( $before_image ), $img_size );
	$after_image = wp_get_attachment_image( absint( $after_image ), $img_size );
}

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';
$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';
	$output .= $before_image;
	$output .= $after_image;
$output .= '</div>';

echo $output;