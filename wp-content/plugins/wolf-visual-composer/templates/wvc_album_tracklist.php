<?php
/**
 * Album tracklist shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'show_numbers' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'wvc-album-tracklist' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$class .= " wvc-album-tracklist wvc-element wvc-clearfix";

if ( 'yes' === $show_numbers ) {
	$class .= ' wvc-album-tracklist-ordered';
}

$output = '<div itemscope="" itemtype="http://schema.org/MusicPlaylist" class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

//$output .= '<meta itemprop="numTracks" content="4">';

$output .= '<ol class="wvc-album-tracklist-list">';

$output .= wpb_js_remove_wpautop( $content );

$output .= '</ol></div>';

echo $output;