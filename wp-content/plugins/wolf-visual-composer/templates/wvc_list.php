<?php
/**
 * List shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'i_type' => '',
	'hide_icon' => '',
	'icon' => '',
	'icon_animate' => '',
	'icon_color' => '',
	'icon_custom_color' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

vc_icon_element_fonts_enqueue( $i_type );

// Icon
$icon = ( isset( $atts["i_icon_$i_type"] ) ) ? $atts["i_icon_$i_type"] : '';

$output = $icon_style = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$class .= ' wvc-list wvc-element';

if ( $hide_icon ) {
	$class .= ' wvc-list-no-icon';
}

if ( $icon_animate ) {
	$class .= ' wvc-list-animate-icon';
}

$colors = wvc_get_shared_colors_hex();

if ( 'custom' === $icon_color ) {
	$icon_color = $icon_custom_color;
} else {
	$icon_color = isset( $colors[ $icon_color ] ) ? $colors[ $icon_color ] : '';
}

if ( '' !== $icon && ! $hide_icon ) {

	if ( $icon_color ) {
		$icon_style .= 'color:' . wvc_sanitize_color( $icon_color ) .'';
	}

	$icon = '<i class="fa ' . esc_attr( $icon ) . '" style="' . wvc_esc_style_attr( $icon_style ) . '"></i>';
	$content = preg_replace( '/<li>/', '<li>' . $icon, $content );
	$class .= ' wvc-list-has-icon';
}

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= wpb_js_remove_wpautop( $content );

$output .= '</div><!--.wvc-list-->';

echo $output;