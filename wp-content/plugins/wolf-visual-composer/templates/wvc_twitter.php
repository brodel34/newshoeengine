<?php
/**
 * Twitter shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'username' => '',
	'type' => '',
	'count' => 3,
	'text_align' => 'center',
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

$username = esc_attr( str_replace( '@', '', $username ) );
$count = absint( $count );
$type = esc_attr( $type );

$class .= ' wvc-wolf-twitter-shortcode-container wvc-element';

if ( 'single' === $type ) {
	$class .= " wvc-wolf-twitter-shortcode-text-align-$text_align";
}

$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= apply_filters( 'wvc_twitter_shortcode', do_shortcode( '[wolf_tweet username="' . $username . '" type="' . $type . '" count="' . $count . '"]' ) );

$output .= '</div>';

echo $output;