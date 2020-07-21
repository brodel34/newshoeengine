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

extract( shortcode_atts( array(
	'title' => esc_html__( 'My Button', 'wolf-visual-composer' ),
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

// Icon
$icon = ( isset( $atts["i_icon_$i_type"] ) ) ? $atts["i_icon_$i_type"] : '';

// Generate button using wvc_generate_button function (inc/wvc-button.php)
$output = wvc_generate_button( array_merge( array( 'icon' => $icon ), $atts ) );

echo $output;