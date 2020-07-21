<?php
/**
 * Album disc shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'type' => 'cd', // CD or vinyl
	'alignment' => '',
	'worn_border' => 'yes',
	'rotate' => '',
	'rotation_speed' => '',
	'cover_image' => '',
	'disc_image' => '',
	'link' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$output = '';

// Disc animation
wp_enqueue_script( 'wow' );
wp_enqueue_script( 'waypoints' );
wp_enqueue_style( 'animate-css' );

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/* Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

// Link
$link = vc_build_link( $link );
$link_url = ( isset( $link['url'] ) ) ? esc_url( $link['url'] ) : '#';
$link_target = ( isset( $link['target'] ) ) ? esc_attr( trim( $link['target'] ) ) : '_self';
$link_title = ( isset( $link['title'] ) ) ? esc_attr( $link['title'] ) : '';
$nofollow = ( isset( $link['rel'] ) && 'nofollow' === $link['rel'] ) ? 'rel="nofollow"' : '';

$class .= " wvc-album-disc wvc-ad-align-$alignment wvc-ad-$type wvc-ad-worn-border-$worn_border wvc-ad-rotate-$rotate wvc-element";

if ( $link_url && '#' !== $link_url ) {
	$class .= ' wvc-ad-has-link';
}

$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

if ( $link_url ) {
	$output .= '<a ' . $nofollow . ' class="wvc-ad-link-mask"';

	if ( $link_target ) {
		$output .= ' target="' . esc_attr( $link_target ) . '"';
	}
	$output .= ' href="' . esc_url( $link_url ) . '" title="' . esc_attr( $link_title ) . '"></a>';
}

$img_size = '600x600';

	$output .= '<div class="wvc-ad-cover-container">';

if ( ! $disc_image ) {
	$disc_image = $cover_image;
}

if ( $disc_image ) {

	$disc_animation_delay = ( absint( $css_animation_delay ) + 400 ) / 1000 . 's';

	$output .= '<div class="wvc-ad-disc-container wow wvc-ad-reveal" style="' . wvc_esc_style_attr( 'transition-delay:' . $disc_animation_delay ) . ';">';

	$inner_style = '';
	if ( $rotation_speed ) {
		$rotation_speed = absint( $rotation_speed ) / 1000 . 's';
		$inner_style = ' style="animation-duration:' . esc_attr( $rotation_speed ) . ';"';
	}

	$output .= '<div class="wvc-ad-disc-inner" ' . $inner_style . '>';

	if ( wp_attachment_is_image( $disc_image ) ) {
		
		$img = wpb_getImageBySize( array(
			'attach_id' => $disc_image,
			'thumb_size' => $img_size,
			'class' => 'wvc-ad-disc-img',
		) );

		$output .= $img['thumbnail'];
	} else {
		$output .= wvc_placeholder_img( $img_size, 'wvc-ad-disc-img' );
	}

	if ( 'cd' === $type ) {
		$output .= '<div class="wvc-ad-disc-text"></div>';
		$output .= '<div class="wvc-ad-disc-hole"></div>';
	}

	if ( 'vinyl' === $type ) {
		$output .= '<div class="wvc-vinyl"></div>';
	}

	$output .= '</div>';

	$output .= '</div>';
}

if ( $cover_image ) {

	$output .= '<div class="wvc-ad-cover-inner">';

	if ( wp_attachment_is_image( $cover_image ) ) {

		$img = wpb_getImageBySize( array(
			'attach_id' => $cover_image,
			'thumb_size' => $img_size,
			'class' => 'wvc-ad-cover-img',
		) );

		$output .= $img['thumbnail'];
	} else {
		$output .= wvc_placeholder_img( $img_size, 'wvc-ad-cover-img' );
	}

	$output .= '<div class="wvc-ad-cover-border"></div>';
	$output .= '</div><!-- .wvc-ad-cover-inner -->';
}

$output .= '</div><!-- .wvc-ad-cover-container -->';

$output .= '</div><!-- .wvc-album-disc -->';

echo $output;