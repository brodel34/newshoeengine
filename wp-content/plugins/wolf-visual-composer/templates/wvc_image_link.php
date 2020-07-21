<?php
/**
 * Image gallery shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'image' => '',
	'alignment' => 'center',
	'text_alignment' => 'center',
	'image_style' => '',
	'frame_style' => '',
	'link' => '',
	'text' => '',
	'secondary_text' => '',
	'secondary_text_button' => '',
	'overlay_color' => '#000',
	'overlay_opacity' => '33',
	'text_color' => '#fff',
	'text_tag' => 'h3',
	'img_size' => 'medium',
	'custom_img_size' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'css' => '',
	'el_class' => '',
	'inline_style' => '',
), $atts ) );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

// link
$link = vc_build_link( $link );
$link_url = ( isset( $link['url'] ) ) ? esc_url( $link['url'] ) : '#';
$link_target = ( isset( $link['target'] ) ) ? esc_attr( trim( $link['target'] ) ) : '_self';
$link_title = ( isset( $link['title'] ) ) ? esc_attr( $link['title'] ) : '';
$nofollow = ( isset( $link['rel'] ) && 'nofollow' === $link['rel'] ) ? 'rel="nofollow"' : '';

/*Animate */
$class .= wvc_get_css_animation( $css_animation );
$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );

/* Custom Size */
if ( 'custom' === $img_size ) {
	$img_size = esc_attr( $custom_img_size );
}

if ( 'round' === $image_style ) {
	$img_size = '500x500';
}

$class .= " wvc-linked-image wvc-text-$alignment $image_style $frame_style wvc-element";
$overlay_opacity = ( $overlay_opacity ) ? absint( $overlay_opacity ) / 100 : null;
$text = sanitize_text_field( $text );
$secondary_text = sanitize_text_field( $secondary_text );

$secondary_text_class = "wvc-linked-image-secondary-text text-$text_alignment $secondary_text_button";

if ( $secondary_text_button ) {
	$secondary_text_class = 'wvc-linked-image-button';
}

$secondary_text = "<span class='$secondary_text_class' style='color:$text_color'>$secondary_text</span>";

$text_color = ( $text_color ) ? sanitize_text_field( $text_color ) : '#fff';
$caption = "<$text_tag class='wvc-linked-image-caption text-$text_alignment' style='color:$text_color'>$text</$text_tag>";

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '">';

if ( $link_url ) {
	$output .= '<a ' . $nofollow . ' href="' . esc_url( $link_url ) . '" title="' . esc_attr( $link_title ) . '" target="' . esc_attr( $link_target ) . '" class="wvc-image-inner">';

} else {
	$output .= "<div class='wvc-image-inner'>";
}

if ( ! in_array( $img_size, array( 'thumbnail', 'medium', 'large', 'wvc-XL', 'full' ) ) ) {
	$img = wpb_getImageBySize( array(
		'attach_id' => $image,
		'thumb_size' => $img_size,
	) );
	$image = ( isset( $img['thumbnail'] ) ) ? $img['thumbnail'] : '';

} else {
	$image = wp_get_attachment_image( absint( $image ), $img_size );
}

$output .= $image;

$output .= "<span class='wvc-linked-image-overlay' style='opacity:$overlay_opacity;background-color:$overlay_color'></span>";
$output .= "<div class='wvc-linked-image-caption-container'><div class='wvc-linked-image-caption-table'>
<div class='wvc-linked-image-caption-table-cell'>
$caption
$secondary_text
</div>
</div></div>";

if ( $link_url ) {
	$output .= "</a>";
} else {
	$output .= "</div>";
}

$output .= '</div><!-- .wvc-linked-image -->';

echo $output;
