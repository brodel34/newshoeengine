<?php
/**
 * Separator shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'el_width' => '100%',
	'el_height' => '1px',
	'border_style' => 'solid',
	'color' => '',
	'align' => '',
	'custom_color' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), apply_filters( 'wvc_separator_atts', $atts ) ) );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$el_width = wvc_sanitize_css_value( $el_width );
$el_height = wvc_sanitize_css_value( $el_height );

$class  .= " wvc-separator-$align wvc-separator wvc-clearfix" ;

/* Border color */
if ( 'custom' === $color && $custom_color ) {
	$custom_color = wvc_sanitize_color( $custom_color );
	$inline_style .= "border-color:$custom_color;";
} else {
	$class .= " wvc-border-color-$color";
}

/* Separator vertical */
if ( absint( $el_height ) > absint( $el_width ) ) {
	$class  .= " wvc-separator-vertical";

	$inline_style .= "border-left-width:$el_width;";
	$inline_style .= 'border-right-width: 0;';
	$inline_style .= "height:$el_height;";
	$inline_style .= "width:0;";

/* Separator horizontal */
} else {
	$class  .= " wvc-separator-horizontal";

	$inline_style .= "border-bottom-width:$el_height;";
	$inline_style .= 'border-top-width: 0;';
	$inline_style .= "width:$el_width;";
	$inline_style .= "height:0;";
}

$inline_style .= "border-style:$border_style;";

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );

$output .= '>';

$output .= '</div><!--.wvc-separator-->';

echo $output;