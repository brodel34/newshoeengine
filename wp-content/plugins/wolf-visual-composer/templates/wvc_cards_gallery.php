<?php
/**
 * Cards gallery shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'alignment' => '',
	'images' => '',
	'img_size' => '',
	'custom_img_size' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$images = wvc_list_to_array( $images );

if ( array() === $images ) {
	return;
}

$output = $class = '';

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

/* Custom Size */
if ( 'custom' === $img_size ) {
	$img_size = esc_attr( $custom_img_size );
}

$class .= " wvc-cards-gallery wvc-cg-alignment-$alignment wvc-element";

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';
$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

foreach ( $images as $img_id ) {
	$output .= '<div class="wvc-card-item">';

	if ( wp_attachment_is_image( $img_id ) ) {
				
		$img = wpb_getImageBySize( array(
			'attach_id' => $img_id,
			'thumb_size' => $img_size,
			//'class' => $img_class,
		) );

		$output .= $img['thumbnail'];
	
	} else {
		$output .= wvc_placeholder_img( $img_size, $img_class );
	}

	$output .= '</div>';
}

$output .= '</div><!--.wvc-cards-gallery-->';

$output .= '<div class="wvc-fake-card">';
	if ( wp_attachment_is_image( $images[0] ) ) {
				
		$img = wpb_getImageBySize( array(
			'attach_id' => $images[0],
			'thumb_size' => $img_size,
			//'class' => $img_class,
		) );

		$output .= $img['thumbnail'];
	
	} else {
		$output .= wvc_placeholder_img( $img_size, $img_class );
	}
$output .= '</div>';

echo $output;