<?php
/**
 * Service table shortcode template
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
	'background_color' => '',
	'background_custom_color' => '',
	'background_image' => '',
	'title_color' => '',
	'title_custom_color' => '',
	'font_color' => '',
	'font_custom_color' => '',
	'add_icon' => '',
	'link' => '',
	'i_type' => '',
	'i_icon' => 'line-icon-bulb',
	'i_color' => '',
	'i_color_custom' => '',
	'title_tag' => 'h3',
	'services' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

vc_icon_element_fonts_enqueue( $i_type );

$icon = ( isset( $atts["i_icon_$i_type"] ) ) ? $atts["i_icon_$i_type"] : '';

$output = $icon_style = $icon_class = $title_class = $title_style = '';

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

$class .= ' wvc-service-table wvc-element';

if ( 'custom' === $background_color ) {
	$inline_style .= "background-color:$background_custom_color;";
} else {
	$class .= " wvc-background-color-$background_color"; // color class
}

if ( 'custom' === $font_color ) {
	$inline_style .= "color:$font_custom_color;";
	$title_style .= "color:$font_custom_color;";
} else {
	$class .= " wvc-text-color-$font_color"; // color class
	$title_class .= " wvc-text-color-$font_color"; // color class
}

$title_class .= ' wvc-service-title';

if ( 'custom' === $title_color ) {
	$title_style .= "color:$title_custom_color;";
} else {
	$title_class .= " wvc-text-color-$title_color"; // color class
}

if ( 'custom' === $i_color ) {
	$icon_style .= "color:$i_color_custom;";
} else {
	$icon_class .= " wvc-text-color-$i_color"; // color class
}

if ( $background_image ) {
	$_bg = wvc_get_url_from_attachment_id( absint( $background_image ), 'large' );
	$inline_style .= 'background-image:url(' . $_bg . ')';
	$class .= ' wvc-st-has-bg';
}

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

if ( $link_url ) {
	$output .= "<a $nofollow class='wvc-st-link-mask' href='$link_url' target='$link_target'></a>";
}

if ( $background_image ) {
	$output .= '<div class="wvc-st-overlay"></div>';
}

$output .= '<ul>';

$headings_array = array( 'h2', 'h3', 'h4', 'h5', 'h6' );
$title_tag = ( in_array( $title_tag, $headings_array ) ) ? esc_attr( $title_tag ) : 'h3';

if ( $title )
	$output .= '<li class="wvc-service-title-container">
		<' . esc_attr( $title_tag ) .' class="' . wvc_sanitize_html_classes( $title_class ). '" style="' . wvc_esc_style_attr( $title_style ) . '">' . sanitize_text_field( $title ) . '
		</' . esc_attr( $title_tag ) .'>
		</li>';

if ( $icon )
	$output .= '<li class="wvc-service-icon-container"><i class="fa fa-3x ' . esc_attr( $icon ) . '" style="' . wvc_esc_style_attr( $icon_style ) . '" class="' . wvc_sanitize_html_classes( $icon_class ) . '"></i></li>';

if ( $services ) {
	$services = wvc_texarea_lines_to_array( $services );
	foreach ( $services as $service ) {
		$output .= '<li>';
		$output .= ( $service ) ? $service : '-';
		$output .= '</li>';
	}
}

$output .= '</ul>';

$output .= '</div><!--.wvc-service-table-->';

echo $output;