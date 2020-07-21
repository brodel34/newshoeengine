<?php
/**
 * Message box shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'type' => 'info',
	//'content' => '',
	'close' => '',
	'display_icon' => 'yes',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'wvc-message' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$type = esc_attr( $type );

$class .= " wvc-notification wvc-$type wvc-element wvc-clearfix";
$icon = '';

if ( 'alert' === $type ) {

	$icon = 'fa-exclamation-circle';

} elseif ( 'info' === $type ) {

	$icon = 'fa-info-circle';

} elseif ( 'success' === $type ) {

	$icon = 'fa-thumbs-o-up';

} elseif ( 'error' === $type ) {

	$icon = 'fa-exclamation-triangle';
}

if ( 'yes' == $display_icon ) {
	$class .= ' wvc-notification-has-icon';
}

$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );

$output .= '>';

if ( 'yes' == $display_icon ) {
	$output .= "<i class='fa $icon fa-lg'></i>";
}

$output .= '<div class="wvc-notification-content"><p>';

$output .= esc_attr( $content );

$output .= '<p></div>';

if ( 'yes' == $close ) {
	$output .= '<span class="wvc-notification-close">&times;</span>';
}

$output .= '</div><!--.wvc-notification-->';

echo $output;