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
	'add_effect' => '', // custom theme effect
	'overlay_color' => 'black',
	'overlay_custom_color' => '#000000',
	'overlay_opacity' => 40,
	'text' => '',
	'link_image' => '',
	'link_type' => 'text',
	'link' => '', 
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), apply_filters( 'wvc_interactive_link_item_atts', $atts ) ) );

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

$class .= ' wvc-interactive-link-item wvc-element';

$src_image = ( 'video' === $background_type ) ? $video_bg_img : $image;
$src = wvc_get_url_from_attachment_id( $src_image, 'wvc-XL' );

$bg_atts = apply_filters( 'wvc_interactive_link_item_bg_atts', array(
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
	'add_effect' => $add_effect,
	'overlay_color' => $overlay_color,
	'overlay_custom_color' => $overlay_custom_color,
	'overlay_opacity' => $overlay_opacity,
) );

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

$output .= '<li data-bg-src="' . esc_url( $src ) . '" data-bg-atts="' . esc_js( $json_bg_atts ) . '" id="wvc-interactive-link-item-' . absint( $rand_id ) .'" style="' . wvc_esc_style_attr( $inline_style ) . '" class="' . wvc_sanitize_html_classes( $class ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= '<a ' . $nofollow . ' itemprop="url" href="' . $link_url . '" target="' . $link_target . '">';

$output .= '<span class="wvc-ils-item-title" data-title="' . esc_attr( $text ) . '">';

if ( 'image' === $link_type && $link_image ) {
	
	$output .= wp_get_attachment_image( absint( $link_image ), 'full' );

} else {
	$output .= $text;
}

$output .= '</span>';

$output .= '</a>';

$output .= '</li><!--.wvc-interactive-link-item-->';

echo $output;