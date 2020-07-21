<?php
/**
 * Interactive Link Item shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'background_type' => 'image',
	'background_color' => '',
	'background_custom_color' => '',
	//'background_img' => '',
	'image' => '',
	'background_position' => 'center center',
	'background_repeat' => 'no-repeat',
	'background_size' => 'cover',
	'video_bg_url' => '',
	'video_bg_img' => '',
	'video_bg_img_mobile' => '',
	'video_bg_start_time' => '',
	'add_overlay' => 'yes',
	'overlay_color' => 'black',
	'overlay_custom_color' => '#000000',
	'overlay_opacity' => 40,
	'text' => '',
	'tagline' => '',
	'button_text' => '',
	'link_image' => '',
	'link_type' => 'text',
	'link' => '', 
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

/* Link */
$link = vc_build_link( $link );
$link_url = ( isset( $link['url'] ) ) ? esc_url( $link['url'] ) : '#';
$link_target = ( isset( $link['target'] ) ) ? esc_attr( trim( $link['target'] ) ) : '_self';
$link_title = ( isset( $link['title'] ) ) ? esc_attr( $link['title'] ) : '';
$nofollow = ( isset( $link['rel'] ) && 'nofollow' === $link['rel'] ) ? 'rel="nofollow"' : '';

$rand_id = rand( 0,999 );

$class .= ' wvc-showcase-vertical-carousel-item wvc-element';

$src_image = ( 'video' === $background_type ) ? $video_bg_img : $image;
$src = wvc_get_url_from_attachment_id( $src_image, 'wvc-XL' );

$bg_atts = array(
	'background_type' => $background_type,
	'background_color' => $background_color,
	'background_custom_color' => $background_custom_color,
	'background_img' => $image,
	'background_position' => $background_position,
	'background_repeat' => $background_repeat,
	'background_size' => $background_size,
	'video_bg_url' => $video_bg_url,
	'video_bg_img' => $video_bg_img,
	'video_bg_img_mobile' => $video_bg_img_mobile,
	'video_bg_start_time' => $video_bg_start_time,
	'add_overlay' => $add_overlay,
	'overlay_color' => $overlay_color,
	'overlay_custom_color' => $overlay_custom_color,
	'overlay_opacity' => $overlay_opacity,
);

$clean_bg_atts = array_filter( $bg_atts, function( $var ) { return ( $var ); } ); // clean empty atts for json params

$json_bg_atts = json_encode( $clean_bg_atts );

$video_bg_type = '';

if ( 'video' === $background_type ) {
	
	if ( 'selfhosted' === wvc_get_video_url_type( $video_bg_url ) ) {

		$video_bg_type = 'selfhosted';

	} elseif ( 'youtube' === wvc_get_video_url_type( $video_bg_url ) ) {

		$video_bg_type = 'youtube';

	} elseif ( 'vimeo' === wvc_get_video_url_type( $video_bg_url ) ) {

		$video_bg_type = 'vimeo';
	}
}

$output .= '<li data-bg-src="' . esc_url( $src ) . '" data-bg-atts="' . esc_js( $json_bg_atts ) . '" id="wvc-showcase-vertical-carousel-item-' . absint( $rand_id ) .'" style="' . wvc_esc_style_attr( $inline_style ) . '" class="' . wvc_sanitize_html_classes( $class ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= '<a ' . $nofollow . '  class="wvc-svc-item-link" itemprop="url" href="' . $link_url . '" target="' . $link_target . '"></a>';

$output .= '<span class="wvc-svc-text-wrapper">';

if ( $tagline ) {
	$output .= '<span class="wvc-svc-item-tagline wvc-item-text-cell">';

		$output .= wvc_kses( $tagline );

	$output .= '</span>';
}

if ( $text ) {
	$output .= '<span class="wvc-svc-item-title wvc-item-text-cell">';

		$output .= wvc_kses( $text );

	$output .= '</span>';
}


if ( $button_text ) {


	
	$output .= '<span class="wvc-svc-item-button wvc-item-text-cell">';
	
	$button_class = apply_filters( 'wvc_showcase_vertical_carousel_button_class', '' );
	
	$output .= '<span class="' . esc_attr( $button_class ) . '"><span>';
	$output .= wvc_kses( $button_text );
	$output .= '</span></span>';

	$output .= '</span>';
}

$output .= '</span>';

$output .= '</li><!--.wvc-showcase-vertical-carousel-item-->';

echo $output;