<?php
/**
 * Iframe opener shortcode template
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
	'iframe_url' => '',
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

$iframe_url = esc_url( $iframe_url );
$iframe = wp_oembed_get( $iframe_url ); 
$iframe_src = wvc_get_iframe_src( $iframe );

if ( ! $iframe_src ) {
	return;
}

$class .= " wvc-iframe-opener-container wvc-iframe-opener-align-$alignment wvc-element";
$class .= " wvc-iframe-opener-caption-position-$caption_position";

if ( $attention_seeker ) {
	$class .= ' wvc-iframe-opener-attention-seeker';
}

if ( ! $custom_play_button ) {
	$class .= ' wvc-iframe-opener-default';
}

if ( 'none' !== $caption_position ) {
	$caption_html .= '<div class="wvc-iframe-opener-caption">';

	//wow fadeIn" style="animation-delay:1600ms;-webkit-animation-delay:1600ms">';

	$caption_html .= '<span class="wvc-iframe-opener-caption-text">';
	$caption_html .= esc_attr( $caption );
	$caption_html .= '</span><!-- .wvc-iframe-opener-caption-text -->';

	if ( $caption && $duration ) {
		$caption_html .= '<span class="wvc-iframe-opener-caption-separator">';
		$caption_html .= ' &mdash; ';
		$caption_html .= '</span>';
	}

	if ( $duration ) {
		$caption_html .= '<span class="wvc-iframe-opener-duration">';
		$caption_html .= esc_attr( $duration );
		$caption_html .= '</span><!-- .wvc-iframe-opener-duration -->';
	}

	$caption_html .= '</div><!-- .wvc-iframe-opener-caption -->';
}

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= '<div class="wvc-iframe-opener-caption-container">';

if ( 'left' === $caption_position || 'top' === $caption_position ) {
	$output .= $caption_html;
}

$output .= '<a data-fancybox data-type="iframe" data-src="' . esc_url( $iframe_src ) . '" href="javascript:;" class="wvc-lightbox-iframe">';

if ( $custom_play_button && $button_image ) {

	$img_class = 'wvc-iframe-custom-button-img';
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
	$output .= apply_filters( 'wvc_default_iframe_opener_button', wvc_animated_svg( WVC_URI .  '/assets/css/lib/linea-icons/svg/_music/_SVG/music_play_button.svg' ) );
}

$output .= '</a>';

if ( 'right' === $caption_position || 'bottom' === $caption_position ) {
	$output .= $caption_html;
}

$output .= '</div><!-- .wvc-iframe-opener-caption-position -->';

$output .= '</div><!-- .wvc-iframe-opener -->';

echo $output;