<?php
/**
 * Call to action shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'h2' => '',
	'h4' => '',
	'title_tag' => 'h2',
	'font_size' => '',
	'font_family' => '',
	'font_weight' => '',
	'text_transform' => '',
	'line_height' => '',
	'txt_align' => '',
	'btn_title' => esc_html__( 'My Button', 'wolf-visual-composer' ),
	'btn_link' => '',
	'btn_color' => '',
	'btn_custom_color' => '',
	'btn_shape' => '',
	'btn_style' => '',
	'btn_size' => '',
	'btn_align' => '',
	'btn_button_block' => '',
	'btn_hover_effect' => '',
	'btn_font_weight' => '',
	'btn_scroll_to_anchor' => '',
	'btn_add_icon' => '',
	'btn_i_align' => '',
	'btn_i_type' => '',
	'btn_i_icon' => '',
	'btn_i_hover' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$output = $cta_button = $cta_text = '';

vc_icon_element_fonts_enqueue( $btn_i_type );

if ( $font_size ) {
	wp_enqueue_script( 'fittext' );
	wp_enqueue_script( 'wvc-fittext' );
}

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

$class .= " wvc-call-to-action wvc-call-to-action-align-$txt_align wvc-clearfix wvc-element";

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

// Button
$button_params = array(
	'title' => $btn_title,
	'link' => $btn_link,
	'color' => $btn_color,
	'custom_color' => $btn_custom_color,
	'shape' => $btn_shape,
	'style' => $btn_style,
	'size' => $btn_size,
	'align' => $btn_align,
	'button_block' => $btn_button_block,
	'hover_effect' => $btn_hover_effect,
	'add_icon' => $btn_add_icon,
	'font_weight' => $btn_font_weight,
	'i_align' => $btn_i_align,
	'i_type' => $btn_i_type,
	'i_hover' => $btn_i_hover,
	'el_class' => '',
);

$icon = ( isset( $atts["btn_i_icon_$btn_i_type"] ) ) ? $atts["btn_i_icon_$btn_i_type"] : '';

$button_params = apply_filters( 'wvc_cta_button_atts', $button_params, $atts );

$cta_button .= '<div class="wvc-call-to-action-button">';
$cta_button .= wvc_generate_button( array_merge( array( 'icon' => $icon ), $button_params ) );
$cta_button .= '</div><!-- .wvc-call-to-action-button -->';

// Text
$main_text = $h2;
$main_tagline = $h4;

$cta_text .= '<div class="wvc-call-to-action-text">';

$cta_title_class = 'wvc-call-to-action-title';

if ( $font_size ) {
	$cta_title_class .= ' wvc-fittext';
}

//$cta_text .= '<' . esc_attr( $title_tag ) . ' data-max-font-size="' . absint( $font_size ) . '" class="' . wvc_sanitize_html_classes( $cta_title_class ) . '">' . sanitize_text_field( $main_text ) . '</' . esc_attr( $title_tag ) . '>';

$heading_atts = array(
	'tag' => $title_tag,
	'font_family' => $font_family,
	'font_size' => $font_size,
	'text' => $main_text,
	'font_weight' => $font_weight,
	'text_transform' => $text_transform,
	'line_height' => $line_height,
	'el_class' => $cta_title_class,
	'container' => false,
);

$cta_text .= wvc_heading( $heading_atts );

if ( $main_tagline ) {
	$cta_text .= '<p class="wvc-cta-tagline">' . sanitize_text_field( $main_tagline ) . '</p>';
}

$cta_text .= '</div><!-- .wvc-call-to-action-text -->';

$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

if ( 'right' === $txt_align ) {

	$output .= $cta_button;
	$output .= $cta_text;

} else {
	$output .= $cta_text;
	$output .= $cta_button;
}

$output .= '</div><!--.wvc-call-to-action-->';

echo $output;