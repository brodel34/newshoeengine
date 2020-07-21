<?php
/**
 * Facebook Page Box shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wolf_Facebook_Page_Box' ) ) {
	echo sprintf( wvc_kses( __( '<p>Please install <a href="%s" target="_blank">%s</a> plugin to display this element.</p>', 'wolf-visual-composer' ) ),
		'https://wolfthemes.com/plugin/wolf-facebook-page-box/',
		'Wolf Facebook Page Box'
	);
	return;
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'page_url' => 'https://www.facebook.com/wolfthemes',
	'height' => 400,
	'hide_cover' => 'false',
	'show_posts' => 'true',
	'show_faces' => 'true',
	'small_header' => 'false',
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

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$page_url = esc_url( $page_url );
$height = absint( $height );
$hide_cover = wvc_shortcode_bool( $hide_cover );
$show_posts = wvc_shortcode_bool( $show_posts );
$show_faces = wvc_shortcode_bool( $show_faces );
$small_header = wvc_shortcode_bool( $small_header );

$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= apply_filters( 'wvc_facebook_fanbox_shortcode', do_shortcode( '[wolf_facebook_page_box page_url="' . $page_url . '" height="' . $height . '" hide_cover="' . $hide_cover . '" show_posts="' . $show_posts . '" show_faces="' . $show_faces . '" small_header="' . $small_header . '"]' ) );

$output .= '</div>';

echo $output;