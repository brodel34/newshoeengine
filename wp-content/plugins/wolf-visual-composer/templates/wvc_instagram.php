<?php
/**
 * Instagram shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wolf_Instagram' ) ) {
	echo sprintf( wvc_kses( __( '<p>Please install <a href="%s" target="_blank">%s</a> plugin to display this element.</p>', 'wolf-visual-composer' ) ),
		'https://wolfthemes.com/plugin/wolf-gram/',
		'Wolf Instagram'
	);
	return;
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'count' => '',
	'columns' => '',
	'username' => '',
	'api_key' => '',
	'tag' => '',
	'follow_button' => '',
	'button_text' => '',
	'hide_meta' => '',
	'add_padding' => '', 
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

$class .= " wvc-i-follow_button-$follow_button wvc-i-padding-$add_padding wvc-i-hide_meta-$hide_meta wvc-wolf-gram-shortcode-container wvc-element";

$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '">';

$output .= apply_filters( 'wvc_instagram_shortcode', do_shortcode( '[wolf_instagram_gallery count="' . $count . '" columns="' . $columns . '" button="' . $follow_button . '" button_text="' . $button_text . '" username="' . $username . '" api_key="' . $api_key . '" tag="' . $tag . '"]' ) );

$output .= '</div><!-- .wvc-wolf-gram-shortcode-container -->';

echo $output;