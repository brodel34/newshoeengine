<?php
/**
 * Tab shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'title' => esc_html__( 'Tab', 'wolf-visual-composer' ),
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

$count = $GLOBALS['wvc_tab_count'];

$GLOBALS['tabs'][ $count ] = array(
	'title' => sprintf( $title, $GLOBALS['wvc_tab_count'] ),
	'content' => wpb_js_remove_wpautop( $content ),
);

$GLOBALS['wvc_tab_count']++;

echo $output;