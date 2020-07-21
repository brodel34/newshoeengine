<?php
/**
 * Audio shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'mp3' => '',
	'image' => '',
	'img_size' => '',
	'custom_img_size' => '',
	'preload' => '',
	'autoplay' => '',
	'loop' => '',
	'ogg' => '',
	'skin' => 'default',
	'max_width' => '',
	'alignment' => '',
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

if ( $max_width ) {
	$max_width = wvc_sanitize_css_value( $max_width );
	$inline_style .= "max-width:$max_width;";
}

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$audio_attrs = array(
	'src' => esc_url( $mp3 ),
	'loop' => $loop,
	'autoplay' => $autoplay,
	'preload'  => esc_attr( $preload ),
);

if ( $ogg ) {
	$audio_attrs['ogg'] = esc_url( $ogg );
}

$skin = esc_attr( $skin );
$class .= " wvc-audio-shortcode-container wvc-as-$skin wvc-as-align-$alignment wvc-element";

if ( $image ) {
	$class .= ' wvc-audio-shortcode-container-has-image';
}

$output .= '<div  class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

if ( $image ) {

	$img_id = $image;
	$img_class = '';

	if ( 'custom' === $img_size ) {
		$img_size = esc_attr( $custom_img_size );
	}

	//$output .= wp_get_attachment_image( $image, 'large' );

	if ( ! in_array( $img_size, array( 'thumbnail', 'medium', 'large', 'wvc-XL', 'full' ) ) ) {

		if ( wp_attachment_is_image( $img_id ) ) {
				
			$img = wpb_getImageBySize( array(
				'attach_id' => $img_id,
				'thumb_size' => $img_size,
				'class' => $img_class,
			) );

			$output .= $img['thumbnail'];
		}

	} else {
		if ( wp_attachment_is_image( $img_id ) ) {
			$output .= wp_get_attachment_image( $img_id, $img_size, false, array( 'class' => $img_class ) );
		} else {
			$output .= wvc_placeholder_img( $img_size, $img_class );
		}
	}
}

$output .= wp_audio_shortcode( $audio_attrs );

$output .= '</div><!-- .wvc-audio-shortcode-container -->';

echo $output;