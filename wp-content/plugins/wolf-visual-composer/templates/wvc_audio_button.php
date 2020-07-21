<?php
/**
 * Button shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

$atts = apply_filters( 'wvc_audio_button_atts', $atts );

extract( shortcode_atts( array(
	'mp3' => '',
	'title' => esc_html__( 'Play', 'wolf-visual-composer' ),
	'link' => '',
	'color' => '',
	'custom_color' => '',
	'shape' => '',
	'style' => '',
	'size' => '',
	'align' => '',
	'button_block' => '',
	'hover_effect' => '',
	'font_weight' => '',
	'scroll_to_anchor' => '',
	'add_icon' => '',
	'i_align' => '',
	'i_type' => '',
	'i_hover' => '',
	'icon' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

vc_icon_element_fonts_enqueue( $i_type );

wp_enqueue_script( 'wvc-audio-button' );

// Icon
$icon = ( isset( $atts["i_icon_$i_type"] ) ) ? $atts["i_icon_$i_type"] : '';

// Custom class
$atts['el_class'] = $el_class . ' wvc-audio-button';
//$atts['title'] = esc_html__( 'Play', 'wolf-visual-composer' );

// Generate button using wvc_generate_button function (inc/wvc-button.php)
$output = apply_filters( 'wvc_audio_button_html', wvc_generate_button( array_merge( array( 'icon' => $icon ), $atts ) ), $atts );

// Player
if ( $mp3 ) {
	$output .= '<audio class="wvc-audio-button-player" id="wvc-audio-button-player-' . absint( rand( 1, 9999 ) ) . '" src="' . esc_url( $mp3 ) . '"></audio>';
}

echo $output;