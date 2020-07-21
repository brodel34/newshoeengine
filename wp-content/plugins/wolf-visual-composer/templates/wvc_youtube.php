<?php
/**
 * YouTube shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'title' => '',
	'url' => '',
	'image' => '',
	'video_preview' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'wvc-youtube' );

$output = $cover_style = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$embed = wp_oembed_get( $url );

$class .= " wvc-youtube-container wvc-element";

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) .'"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= $embed;

$output .= '<div class="wvc-youtube-cover">';

if ( wp_attachment_is_image( $image ) && ! $video_preview ) {

	$image_url = wvc_get_url_from_attachment_id( $image, 'wvc-XL' );
	$cover_style .= 'background-image:url(' . esc_url( $image_url ) . ');';

	$image_dominant_color = wvc_get_image_dominant_color( $image );

	if ( $image_dominant_color ) {
		$cover_style .= 'background-color:#' .$image_dominant_color  . '';
	}

	$output .= '<div class="wvc-youtube-cover-image" style="' . wvc_esc_style_attr( $cover_style ) . '"></div>';
}

if ( $video_preview ) {
	$output .= wvc_background_video(
		array(
			'video_bg_url' => $video_preview,
			'video_bg_img' => $image,
		)
	);
}

$output .= '<span class="wvc-youtube-play-button"><i class="fa fa-youtube-play" aria-hidden="true"></i>';

if ( $title ) {
	$output .= sprintf( esc_html__( 'Watch %s', 'wolf-visual-composer' ), $title );
} else {
	$output .= esc_html__( 'Play Video', 'wolf-visual-composer' );
}

$output .= '</span><!-- .wvc-youtube-play-button -->';

$output .= '</div><!-- .wvc-youtube-cover -->';

$output .= '</div><!-- .wvc-youtube-container -->';

echo $output;