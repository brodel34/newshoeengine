<?php
/**
 * Row inner shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'column_type' => 'column',
	'font_color' => 'dark',
	'container_width' => 'standard',
	'content_placement' => 'default',
	'columns_placement' => '',
	'gap' => '',
	'equal_height' => '',
	'min_height' => '',
	'background_type' => 'default',
	'background_color' => '',
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
	'add_effect' => '', // custom theme effect
	'add_overlay' => '',
	'overlay_color' => 'black',
	'overlay_custom_color' => '#000000',
	'overlay_opacity' => '',

	'rtl_reverse' => '',

	'border_color' => '',
	'border_custom_color' => '',
	'border_style' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'hide_class' => '',
	'disable_element' => '',
	'css' => '',
	'el_id' => '',
	'el_class' => '',
	'inline_style' => '',
), apply_filters( 'wvc_row_inner_atts', $atts ) ) );

if ( 'yes' === $disable_element && ! vc_is_page_editable() ) {
	return;
}

$output = $border_class = '';

$slideshow_speed = ( $slideshow_speed ) ? $slideshow_speed : 5000;

wp_enqueue_script( 'wpb_composer_front_js' );

$el_class = $this->getExtraClass( $el_class );

$inline_style = wvc_sanitize_css_field( $inline_style );

if ( 'none' !== $border_style && '' !== $border_style ) {
	$inline_style .= 'border-width:0;';
	$inline_style .= "border-style:$border_style;";
}

if ( ! wvc_is_new_animation( $css_animation ) ) {
	$el_class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$css_classes = array(
	'wvc-clearfix',
	$el_class,
	'wvc-row-inner',
	'wvc-row-content',
	"wvc-row-inner-layout-$column_type",
	"wvc-font-$font_color",
	"wvc-row-bg-$background_type",
	"wvc-row-bg-effect-$background_effect",
	$hide_class
);

if ( 'yes' === $disable_element && vc_is_page_editable() ) {
	$css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
}

if ( $min_height ) {
	$css_classes[] = 'wvc-row-min-height';
	$min_height = wvc_sanitize_css_value( $min_height );
	$inline_style .= "min-height:$min_height;";
}

if ( $video_bg_parallax ) {
	$css_classes[] = "wvc-row-bg-video-parallax";
}

if ( $rtl_reverse ) {
	$css_classes[] = 'wvc_rtl-columns-reverse';
}

$inline_style .= wvc_shortcode_custom_style( $css );

if ( 'custom' === $border_color && $border_custom_color ) {

	$inline_style .= 'border-color:' . wvc_sanitize_color( $border_custom_color ) . ';';

} else {
	$border_class = "wvc-border-color-$border_color"; // border color class
}

$css_classes[] = $border_class;

$wrapper_css_classes = array(
	'wvc-row-inner-wrapper',
	"wvc-row-inner-wrapper-width-$container_width",
);

$wrapper_attributes = array();

$wrapper_css_classes[] = "wvc-row-inner-column-equal-height-$equal_height";

$wrapper_css_classes[] = 'wvc-row-inner-content-placement-' . $content_placement;

if ( 'custom' !== $background_color ) {
	$wrapper_css_classes[] = "wvc-background-color-$background_color";
	$background_color = '';
}

if ( '' !== $gap && '35' !== $gap ) {
	$wrapper_attributes[] = 'data-column-gap="' . esc_attr( $gap ) . '"';
	$gap = absint( $gap ) . 'px';
	$gap_margin = absint( $gap ) * 2 . 'px';
}

$row_css_class = wvc_array_to_list( $css_classes, ' ' );

$wrapper_css_classes = wvc_array_to_list( $wrapper_css_classes, ' ' );

$wrapper_attributes[] = 'class="' . wvc_sanitize_html_classes( $row_css_class ) . '"';

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . ' style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );

$output .= '>';

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

	if ( 'auto' === $overlay_color ) {
		$overlay_custom_color = ( $dominant_color ) ? $dominant_color : '#000000';
	}

	$output .= wvc_background_overlay( array( 'overlay_color' => $overlay_color, 'overlay_custom_color' => $overlay_custom_color, 'overlay_opacity' => $overlay_opacity, ) );
}

if ( $add_effect ) {
	$output .= apply_filters( 'wvc_background_effect', '', $atts );
}

$output .= '<div class="' . wvc_sanitize_html_classes( $wrapper_css_classes ) . '">'; // wrapper

$output .= '<div class="wvc-row-inner-content">';

$output .= wpb_js_remove_wpautop( $content );

$output .= '</div><!--.wvc-row-content-->';
$output .= '</div><!--.wvc-row-inner-wrapper-->';
$output .= '</div><!--.wvc-row-->';

echo wpb_js_remove_wpautop( $output );