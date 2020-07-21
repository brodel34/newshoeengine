<?php
/**
 * Process item shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'type' => 'icon',
	'title' => '',
	'text' => '',
	'color' => '',
	'custom_color' => '',
	'i_type' => '',
	'i_icon' => 'line-icon-bulb',
	'background_image' => '',
	'title_tag' => '',
	'link' => '',
	'el_class' => '',
	'inline_style' => '',
), $atts ) );

vc_icon_element_fonts_enqueue( $i_type );

$icon = ( isset( $atts["i_icon_$i_type"] ) ) ? $atts["i_icon_$i_type"] : '';

//wp_enqueue_script( 'wvc-process' );

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );

$headings_array = array( 'h2', 'h3', 'h4', 'h5', 'h6' );
$title_tag = ( in_array( $title_tag, $headings_array ) ) ? esc_attr( $title_tag ) : 'h3';
$link = vc_build_link( $link );
$link_url = ( isset( $link['url'] ) ) ? esc_url( $link['url'] ) : '#';
$link_target = ( isset( $link['target'] ) ) ? esc_attr( trim( $link['target'] ) ) : '_self';
$link_title = ( isset( $link['title'] ) ) ? esc_attr( $link['title'] ) : '';
$nofollow = ( isset( $link['rel'] ) && 'nofollow' === $link['rel'] ) ? 'rel="nofollow"' : '';

$graphic_inline_style = $graphic_class = '';

if ( 'custom' === $color ) {
	$graphic_inline_style .= "color:$custom_color;";
} else {
	$graphic_class .= " wvc-text-color-$color"; // color class
}

$container_class = 'wvc-process-item';

if ( ! $text ) {
	$container_class .= ' wvc-process-item-no-text';
}

$output = '<li class="' . wvc_sanitize_html_classes( $container_class ) . '">';

$class .= ' wvc-icon-box wvc-icon-position-top wvc-icon-background-style-rounded-outline ';

if ( $link_url ) {
	$class .= ' wvc-icon-hover-fill';
}

$bg_style = '';
$icon_container_class = 'wvc-process-icon-container wvc-icon-container fa-stack wvc-icon-container-type-' . $type;

if ( $background_image ) {
	$_bg = wvc_get_url_from_attachment_id( absint( $background_image ), 'medium' );
	$bg_style .= 'background-image:url(' . $_bg . ')';
	$icon_container_class .= ' wvc-pi-has-bg';
}

$output .= '<span class="' . wvc_sanitize_html_classes( $class ) . '">
<span class="wvc-icon-holder">';

if ( $link_url ) {
	$output .= '<a ' . $nofollow . ' class="wvc-process-item-inner" href="' . esc_attr( $link_url ) . '" target="' . esc_attr( $link_target ) . '">';
} else {
	$output .= '<span class="wvc-process-item-inner">';
}

$output .= '<span class="wvc-process-item-line-before"></span>';

$output .= '<span class="' . wvc_sanitize_html_classes( $icon_container_class ) .'" style="' . wvc_esc_style_attr( $bg_style ) . '">';

if ( 'icon' === $type ) {
	
	$output .= '<i class="wvc-icon fa ' . $icon . ' ' . wvc_sanitize_html_classes( $graphic_class ) . '" style="' . wvc_esc_style_attr( $graphic_inline_style ) . '"></i>';

} elseif ( 'number' === $type ) {
	
	$output .= '<span class="wvc-process-number  ' . wvc_sanitize_html_classes( $graphic_class ) . '" style="' . wvc_esc_style_attr( $graphic_inline_style ) . '"></span>';
}

if ( $link_url ) {
	$output .= '</a>';
} else {
	$output .= '</span>';
}

$output .= '<span class="wvc-process-item-line-after"></span>';

$output .= '</span><!--.wvc-icon-holder-->
</span><!--.wvc-icon-box-->';

$output .= '<span class="wvc-process-caption">';
$output .= '<span class="wvc-process-caption-inner">';

$output .= '<' . esc_attr( $title_tag ) . ' class="wvc-process-title">' . esc_attr( $title ) . '</' . esc_attr( $title_tag ) . '>';

$output .= '<p class="wvc-process-text">' . sanitize_text_field( $text ) . '</p>';

$output .= '</span><!--.wvc-process-caption-inner-->';
$output .= '</span><!--.wvc-process-caption-->';

$output .= '</li>';

echo $output;