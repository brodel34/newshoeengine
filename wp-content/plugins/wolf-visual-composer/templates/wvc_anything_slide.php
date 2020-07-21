<?php
/**
 * Anything slide shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'font_color' => 'light',
	'background_color' => '',
	'background_type' => 'image',
	'background_color' => 'default',
	'background_custom_color' => '',
	'background_img' => '',
	'background_position' => 'center center',
	'background_repeat' => 'no-repeat',
	'background_size' => 'cover',
	'background_effect' => '',
	'video_bg_url' => '',
	'video_bg_img' => '',
	'video_bg_controls' => '',
	'add_overlay' => '',
	'overlay_color' => 'black',
	'overlay_custom_color' => '#000000',
	'overlay_opacity' => '',
	'el_class' => '',
	'inline_style' => '',
), $atts ) );

$output = '';

$output = $image_url = $overlay_style = '';
$rand = rand( 0, 9999 );

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );

$class .= " slide wvc-anything-slide wvc-font-$font_color wvc-$background_type-slide";

if ( 'custom' !== $background_color ) {
	$class .= " wvc-background-color-$background_color";
}

$output .= '<li id="wvc-anything-slide-' . absint( $rand ) . '" class="' . wvc_sanitize_html_classes( $class ) . '">';

	if ( 'image' === $background_type ) {

		$img_bg_args = array(
			'background_img' => $background_img,
			'background_color' => ( 'custom' === $background_color ) ? $background_custom_color : '',
			'background_position' => $background_position,
			'background_repeat' => $background_repeat,
			'background_size' => $background_size,
			'background_effect' => 'none',
		);

		$output .= wvc_background_img( $img_bg_args );

	// video background
	} elseif ( 'video' === $background_type ) {

		$video_bg_args = array(
			'video_bg_url' => $video_bg_url,
			'video_bg_img' => $video_bg_img,
			//'video_bg_pause_on_start' => true,
			//'video_bg_controls' => $video_bg_controls,
		);

		$output .= wvc_background_video( $video_bg_args );
	}

	if ( 'yes' === $add_overlay ) {

		$main_image = ( 'video' === $background_type ) ? $video_bg_img : $background_img;
		$dominant_color = wvc_get_image_dominant_color( $main_image );

		if ('auto' === $overlay_color ) {
			$overlay_custom_color = ( $dominant_color ) ? $dominant_color : '#000000';
		}

		$output .= wvc_background_overlay( array( 'overlay_color' => $overlay_color, 'overlay_custom_color' => $overlay_custom_color, 'overlay_opacity' => $overlay_opacity, ) );
	}


	/* Content */
	$slide_content = '';
	$slide_content .= '[vc_row min_height="1" content_width="standard" font_color="light" background_type="transparent"][vc_column]';
		$slide_content .= wpb_js_remove_wpautop( $content );
	$slide_content .= '[/vc_column][/vc_row]';

	$output .= '<div class="wvc-as-content-table">'; 
		$output .= '<div class="wvc-as-content-table-cell">'; 
			$output .= '<div class="wvc-as-content">'; 
			$output .= do_shortcode( $slide_content );
			$output .= '</div>';
		$output .= '</div>'; 
	$output .= '</div>'; 

$output .= '</li><!--.slide-->';

echo $output;