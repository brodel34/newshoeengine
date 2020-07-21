<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/** @var array $atts */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'color' => '',
	'custom_color' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );


//$class_to_filter .= vc_shortcode_custom_css_class( $atts['css'], ' ' ) . $this->getExtraClass( $atts['el_class'] ) . $this->getCSSAnimation( $atts['css_animation'] );

//$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$class .= ' wvc-zigzag vc-zigzag-wrapper wvc-element';

$wrapper_attributes = array();
if ( ! empty( $atts['align'] ) ) {
	$class .= ' vc-zigzag-align-' . esc_attr( $atts['align'] );
}
if ( ! empty( $atts['el_id'] ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $atts['el_id'] ) . '"';
}

$colors = wvc_get_shared_colors_hex();

if ( 'custom' === $color ) {
	$color = $custom_color;
} else {
	$color = isset( $colors[ $color ] ) ? $colors[ $color ] : '';
}

if ( ! $color ) {
	$color = $colors['grey'];
}

$width = '100%';
if ( ! empty( $atts['el_width'] ) ) {
	$width = esc_attr( $atts['el_width'] ) . '%';
}
$border_width = '10';
if ( ! empty( $atts['el_border_width'] ) ) {
	$border_width = esc_attr( $atts['el_border_width'] );
}
$minheight = 2 + intval( $border_width );
$svg = '<?xml version="1.0" encoding="utf-8"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"><svg width="' . ( intval( $border_width ) + 2 ) . 'px' . '" height="' . intval( $border_width ) . 'px' . '" viewBox="0 0 18 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polygon id="Combined-Shape" fill="' . esc_attr( $color ) . '" points="8.98762301 0 0 9.12771969 0 14.519983 9 5.40479869 18 14.519983 18 9.12771969"></polygon></svg>';
?>
<div class="<?php echo esc_attr( $class ); ?>"<?php echo ! empty( $atts['el_id'] ) ? ' id="' . esc_attr( $atts['el_id'] ) . '"' : false; ?>>
	<div class="vc-zigzag-inner"
			style="<?php echo esc_attr( 'width: ' . esc_attr( $width ) . ';min-height: ' . $minheight . 'px;background: 0 repeat-x url(\'data:image/svg+xml;utf-8,' . rawurlencode( $svg ) . '\');' ); ?>">
	</div>
</div>
