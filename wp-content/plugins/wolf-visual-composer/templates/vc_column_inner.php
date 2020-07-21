<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'font_color' => 'inherit',
	'content_type' => 'default',
	'max_width' => '',
	'min_height' => '',
	'content_placement' => '',
	'content_alignment' => 'center',
	'text_alignment' => '',
	'column_style' => '',
	'background_type' => 'default',
	'background_color' => 'default',
	'background_custom_color' => '',
	'background_img' => '',
	'background_position' => 'center center',
	'background_repeat' => 'no-repeat',
	'background_size' => 'cover',
	'background_effect' => '',
	'slideshow_img_ids' => '',
	'slideshow_speed' => 5000,
	'video_bg_url' => '',
	'video_bg_img' => '',
	'video_bg_start_time' => '',
	'video_bg_end_time' => '',
	'video_bg_parallax' => '',
	'video_bg_loop' => true,
	'add_overlay' => '',
	'add_effect' => '', // custom theme effect
	'add_particles' => '',
	'add_noise' => '',
	'overlay_color' => 'black',
	'overlay_custom_color' => '#000000',
	'overlay_opacity' => '',
	'border_color' => '',
	'border_custom_color' => '',
	'border_style' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_id' => '',
	'el_class' => '',
	'link' => '',
	'css' => '',
	'offset' => '',
	'width' => '',
	'inline_style' => '',
), apply_filters( 'wvc_column_inner_atts', $atts ) ) );

$output = $container_inline_style = $inline_style = $inner_css_class = $wrapper_css_class = $container_css_class = '';
$class = $border_class = '';

$inline_style .= wvc_sanitize_css_field( $inline_style );

if ( 'none' !== $border_style && '' !== $border_style ) {
	$inline_style .= 'border-width:0;';
	$inline_style .= "border-style:$border_style;";
}

if ( 'custom' === $border_color && $border_custom_color ) {

	$inline_style .= 'border-color:' . wvc_sanitize_color( $border_custom_color ) . ';';

} else {
	$border_class = "wvc-border-color-$border_color"; // border color class
}

$inline_style .= wvc_shortcode_custom_style( $css );

$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );

$base_width_int = ( absint( preg_replace( '/[^0-9]+/', '', $width ), 10 ) ) ? absint( preg_replace( '/[^0-9]+/', '', $width ), 10 ) : '';

$link = vc_build_link( $link );
$link_url = ( isset( $link['url'] ) ) ? esc_url( $link['url'] ) : '#';
$link_target = ( isset( $link['target'] ) ) ? esc_attr( trim( $link['target'] ) ) : '_self';
$link_title = ( isset( $link['title'] ) ) ? esc_attr( $link['title'] ) : '';
$nofollow = ( isset( $link['rel'] ) && 'nofollow' === $link['rel'] ) ? 'rel="nofollow"' : '';

$class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width, $this->settings['base'], $atts );
//$class .= ' ' . $width;

$class .= ' ' . $el_class;
$class .= " wvc-column wvc-inner-column";

$class  .= " wvc-column-content-placement-$content_placement wvc-column-content-type-$content_type wvc-column-content-alignment-$content_alignment wvc-column-text-alignment-$text_alignment";

$container_css_class .= ' wvc-column-container';

$container_css_class .= "  wvc-column-bg-$background_type wvc-column-bg-effect-$background_effect wvc-font-$font_color wvc-column-style-$column_style $border_class";

if ( ( 'default' !== $background_type || 'inherit' !== $font_color ) && 'transparent' !== $background_type && 'transparent' !== $background_color ) {
	$container_css_class .= ' wvc-column-has-fill';
}

if ( 'custom' !== $background_color ) {
	$container_css_class .= " wvc-background-color-$background_color";
}

if ( '' !== $min_height ) {
	$min_height = wvc_sanitize_css_value( $min_height );
	$inline_style = "min-height:$min_height;";
}

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$container_inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

//$inner_css_class .= ' wvc-column-inner ' . esc_attr( trim( vc_shortcode_custom_css_class( $css ) ) );

$inner_css_class .= ' wvc-column-inner';
$wrapper_css_class = 'wvc-column-wrapper wpb_wrapper';

$el_id = ( '' !== $el_id ) ? $el_id : 'wvc-col-' . rand( 0, 9999 );

$output .= '<div id="' . esc_attr( $el_id ) . '" class="' . wvc_sanitize_html_classes( $class ) . '" data-base-width-int="' . esc_attr( $base_width_int ) . '" style="' . wvc_esc_style_attr( $container_inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= '<div class="' . wvc_sanitize_html_classes( $container_css_class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '">';

if ( 'image' === $background_type ) {

	$background_hex_color = null;
	if ( 'custom' === $background_color ) {
		$background_hex_color = $background_custom_color;
	}

	$img_bg_args = array(
		'background_img' => $background_img,
		'background_color' => $background_hex_color,
		'background_position' => $background_position,
		'background_repeat' => $background_repeat,
		'background_size' => $background_size,
		'background_effect' => $background_effect,
	);

	$output .= wvc_background_img( $img_bg_args );

// video background
} elseif ( 'video' === $background_type ) {

	$video_bg_args = array(
		'video_bg_url' => $video_bg_url,
		'video_bg_img' => $video_bg_img,
		'video_bg_start_time' => $video_bg_start_time,
		'video_bg_end_time' => $video_bg_end_time,
		'video_bg_parallax' => $video_bg_parallax,
		'video_bg_loop' => $video_bg_loop,
	);

	$output .= wvc_background_video( $video_bg_args );

} elseif ( 'slideshow' === $background_type ) {

	$slideshow_args = array(
		'slideshow_img_ids' => $slideshow_img_ids,
		'slideshow_speed' => $slideshow_speed,
	);

	$output .= wvc_background_slideshow( $slideshow_args );
}

if ( 'yes' === $add_overlay ) {

	$main_image = ( 'video' === $background_type ) ? $video_bg_img : $background_img;
	$dominant_color = wvc_get_image_dominant_color( $main_image );

	if ('auto' === $overlay_color ) {
		$overlay_custom_color = ( $dominant_color ) ? $dominant_color : '#000000';
	}

	$output .= wvc_background_overlay( array( 'overlay_color' => $overlay_color, 'overlay_custom_color' => $overlay_custom_color, 'overlay_opacity' => $overlay_opacity, ) );
}

if ( 'yes' === $add_particles ) {

	wp_enqueue_script( 'particles' );
	wp_enqueue_script( 'wvc-particles' );

	$particles_rand = 'wvc-particles-' . rand( 0, 9999 );

	$output .= '<div class="wvc-bg-overlay wvc-particles" id="' . esc_attr( $particles_rand ) . '"></div>';
}

if ( $add_noise ) {
	$output .= '<div class="noise"></div>';
}

if ( $add_effect ) {
	$output .= apply_filters( 'wvc_background_effect', '', $atts );
}

$wrapper_inline_style = '';

if ( $max_width ) {
	$max_width = wvc_sanitize_css_value( $max_width );
	$wrapper_inline_style = "max-width:$max_width;";
}

if ( $link_url ) {
	$output .= '<a ' . $nofollow . ' href="' . esc_url( $link_url ) . '" target="' . esc_attr( $link_target ) . '" class="wvc-column-link-mask"></a>';
}

$output .= '<div class="' . wvc_sanitize_html_classes( $inner_css_class ) . '">';

$output .= '<div class="' . wvc_sanitize_html_classes( $wrapper_css_class ) . '" style="' . wvc_esc_style_attr( $wrapper_inline_style ) . '">';

$output .= wpb_js_remove_wpautop( $content );

$output .= '</div><!--.wvc-column-wrapper-->';
$output .= '</div><!--.wvc-column-inner-->';
$output .= '</div><!--.wvc-column-container-->';
$output .= '</div><!--.wvc-column-->';

echo $output;