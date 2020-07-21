<?php
/**
 * Video opener shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'custom_play_button' => '',
	'button_image' => '',
	'alignment' => 'center',
	'video_url' => '',
	'attention_seeker' => '',
	'caption_position' => '',
	'caption' => '',
	'duration' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'lity' );

$output = $caption_html = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$video_url = esc_url( $video_url );

$class .= " wvc-video-opener-container wvc-video-opener-align-$alignment wvc-element";
$class .= " wvc-video-opener-caption-position-$caption_position";

if ( $attention_seeker ) {
	$class .= ' wvc-video-opener-attention-seeker';
}

if ( ! $custom_play_button ) {
	$class .= ' wvc-video-opener-default';
}

if ( 'none' !== $caption_position ) {
	$caption_html .= '<div class="wvc-video-opener-caption" style="animation-delay:1600ms;-webkit-animation-delay:1600ms">';

	$caption_html .= '<span class="wvc-video-opener-caption-text">';
	$caption_html .= esc_attr( $caption );
	$caption_html .= '</span><!-- .wvc-video-opener-caption-text -->';

	if ( $caption && $duration ) {
		$caption_html .= '<span class="wvc-video-opener-caption-separator">';
		$caption_html .= ' &mdash; ';
		$caption_html .= '</span>';
	}

	if ( $duration ) {
		$caption_html .= '<span class="wvc-video-opener-duration">';
		$caption_html .= esc_attr( $duration );
		$caption_html .= '</span><!-- .wvc-video-opener-duration -->';
	}

	$caption_html .= '</div><!-- .wvc-video-opener-caption -->';
}

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= '<div class="wvc-video-opener-caption-container">';

if ( 'left' === $caption_position || 'top' === $caption_position ) {
	$output .= $caption_html;
}

$output .= '<a href="' . esc_url( $video_url ) . '" class="wvc-video-opener">';

if ( $custom_play_button && $button_image ) {

	$img_class = 'wvc-vo-custom-button-img';
	$img_size = 'full';

	if ( wp_attachment_is_image( $button_image ) ) {
				
		$img = wpb_getImageBySize( array(
			'attach_id' => $button_image,
			'thumb_size' => $img_size,
			'class' => $img_class,
		) );

		$output .= $img['thumbnail'];
	} else {
		$output .= wvc_placeholder_img( $img_size, $img_class );
	}

} else {
	$output .= apply_filters( 'wvc_default_video_opener_button', wvc_animated_svg( WVC_URI .  '/assets/css/lib/linea-icons/svg/_music/_SVG/music_play_button.svg' ) );
}

$output .= '</a>';

if ( 'right' === $caption_position || 'bottom' === $caption_position ) {
	$output .= $caption_html;
}

$output .= '</div><!-- .wvc-video-opener-caption-position -->';

$output .= '</div><!-- .wvc-video-opener -->';

echo $output;