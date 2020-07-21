<?php
/**
 * Banner product shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'product_id' => null,
	'image' => '',
	'img_size' => '',
	'custom_img_size' => '',
	'alignment' => '',
	'max_width' => '',
	'link' => '',
	'overlay_color' => '',
	'overlay_custom_color' => '',
	'overlay_text_color' => '',
	'overlay_text_custom_color' => '',
	'overlay_opacity' => '',
	'txt_align' => '',
	'txt_v_align' => '',
	'title' => '',
	'title_font_size' => '',
	'title_tag' => 'h3',
	'tagline' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

if ( ! $product_id || 'publish' !== get_post_status( $product_id ) ) {
	return;
}

$product = wc_get_product( absint( $product_id ) );

$title = $product->get_name();
$tagline = $product->get_short_description();
$price = $product->get_price_html();

$output = $img_class = $text_color = $text_style = $title_style = '';

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


$img_id = ( $image ) ? $image : $product->get_image_id();

if ( $max_width ) {
	$max_width = wvc_sanitize_css_value( $max_width );
	$inline_style .= "max-width:$max_width;";
}

if ( $overlay_text_color ) {
	$text_color = wvc_convert_color_class_to_hex_value( $overlay_text_color, $overlay_text_custom_color );
	if ( $text_color ) {
		$title_style .= 'color:' . wvc_sanitize_color( $text_color ) . ';';
		$text_style .= 'color:' . wvc_sanitize_color( $text_color ) . ';';
	}
}

if ( $title_font_size ) {
	$title_style .= 'font-size:' . wvc_sanitize_css_value( $title_font_size ) . ';';
}

/* Link */
$link_url = get_permalink( $product_id );
$link_target = '';
$link_title = '';

$class .= ' wvc-banner wvc-element';
$class .= " wvc-banner-alignment-$alignment wvc-banner-text-align-$txt_align wvc-banner-text-vertical-align-$txt_v_align";

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

if ( $link_url ) {

	$output .= '<a class="wvc-banner-link-mask" href="' . esc_url( $link_url ) . '" target="' . esc_attr( $link_target ) . '" title="' . esc_attr( $link_title ) . '"></a>';

}

$output .= '<div class="wvc-banner-image">';

// Image
if ( ! in_array( $img_size, array( 'thumbnail', 'medium', 'large', 'wvc-XL', 'full' ) ) ) {

	if ( wp_attachment_is_image( $img_id ) ) {
			
		$img = wpb_getImageBySize( array(
			'attach_id' => $img_id,
			'thumb_size' => $img_size,
			'class' => $img_class,
		) );

		$output .= $img['thumbnail'];
	} else {
		$output .= wvc_placeholder_img( $img_size, $img_class );
	}

} else {
	if ( wp_attachment_is_image( $img_id ) ) {
		$output .= wp_get_attachment_image( $img_id, $img_size, false, array( 'class' => $img_class ) );
	} else {
		$output .= wvc_placeholder_img( $img_size, $img_class );
	}
}

$output .= '</div><!--.wvc-banner-image-->';

// Overlay
$dominant_color = wvc_get_image_dominant_color( get_post_thumbnail_id() );

if ( $dominant_color && 'auto' === $overlay_color ) {
	$overlay_custom_color = $dominant_color;
}

$output .= wvc_background_overlay( array(
	'overlay_color' => $overlay_color,
	'overlay_custom_color' => $overlay_custom_color,
	'overlay_opacity' => $overlay_opacity, )
);

$output .= '<div class="wvc-banner-caption">';

$output .= '<div class="wvc-banner-caption-table">';

$output .= '<div class="wvc-banner-caption-table-cell">';

if ( $title ) {
	$output .= '<' . esc_attr( $title_tag ) . ' class="wvc-banner-title" style="' . wvc_esc_style_attr( $title_style ) . '">';

	$output .= sanitize_text_field( $title );

	$output .= '</' . esc_attr( $title_tag ) . '>';
}

if ( $tagline ) {
	$output .= '<span class="wvc-banner-tagline" style="' . wvc_esc_style_attr( $text_style ) . '">';

	$output .= wvc_sample( $tagline, 10 );

	$output .= '</span>';
}

if ( $price ) {
	$output .= '<span class="wvc-banner-price" style="' . wvc_esc_style_attr( $text_style ) . '">';

	$output .= wvc_kses( $price );

	$output .= '</span>';
}

$output .= '</div><!--.wvc-banner-caption-table-cell-->';

$output .= '</div><!--.wvc-banner-caption-table-->';

$output .= '</div><!--.wvc-banner-caption-->';

$output .= '</div><!--.wvc-banner-->';

echo $output;