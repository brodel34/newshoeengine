<?php
/**
 * Item price shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'layout' => 'text',
	'image' => '',
	'img_size' => 'large',
	'custom_img_size' => '',
	'title' => '',
	'title_tag' => 'h3',
	'text' => '',
	'price' => '',
	'content' => '',
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

$class .= " wvc-item-price wvc-clearfix wvc-item-price-layout-$layout wvc-element";

$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

if ( $image && 'text' !== $layout ) {

	$image_id = $image;

	/* Custom Size */
	if ( 'custom' === $img_size ) {
		$img_size = esc_attr( $custom_img_size );
	}

	if ( ! in_array( $img_size, array( 'thumbnail', 'medium', 'large', 'wvc-XL', 'full' ) ) ) {
		$img = wpb_getImageBySize( array(
			'attach_id' => $image_id,
			'thumb_size' => $img_size,
			'class' => '',
		) );
		$image = ( isset( $img['thumbnail'] ) ) ? $img['thumbnail'] : '';

	} else {
		$image = wp_get_attachment_image( absint( $image_id ), $img_size, array() );
	}

	$full_size_src = wvc_get_url_from_attachment_id( absint( $image_id ), 'wvc-XL' );

	$output .= '<div class="wvc-item-price-image-container">';

	$output .= '<a class="wvc-swipebox" href="' . esc_url( $full_size_src ) . '" title="' . esc_attr( $title ) . '" data-wvc-rel="' . esc_attr( 'item-price' ) . '">';

	$output .= $image;

	$output .= '</a>';
	$output .= '</div><!--.wvc-item-price-image-container-->';
}

$output .= '<div class="wvc-item-price-text-container">';

if ( $title ) {
	$output .= '<div class="wvc-item-price-title-container">';

		$output .= '<div class="wvc-item-price-title">' . sanitize_text_field( $title ) . '</div>';

		$output .= '<div class="wvc-item-price-dots"></div>';

	if ( $price ) {
		$output .= '<div class="wvc-item-price-price">' . sanitize_text_field( $price ) . '</div>';
	}

	$output .= '</div>';
}

//$output .= '<div class="wvc-clear"></div>';

if ( $text ) {
	$output .= '<div class="wvc-item-price-text">' . sanitize_text_field( $text ) . '</div>';
}

if ( $content ) {
	$output .= '<div class="wvc-item-price-content">' . sanitize_text_field( $content ) . '</div>';
}

$output .= '</div><!--.wvc-item-price-text-->';

$output .= '</div><!--.wvc-item-price-->';

echo $output;