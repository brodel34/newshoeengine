<?php
/**
 * Tabs shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'tabs_align' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'jquery-ui-tabs', true );
wp_enqueue_script( 'wvc-tabs' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$class .= ' wvc-tabs wvc-clearfix wvc-element';
$class .= " wvc-tabs-alignment-$tabs_align";
$rand = rand( 0,9999 );

wp_enqueue_script( 'jquery-ui-tabs', true );
wp_enqueue_script( 'wvc-tabs' );

$GLOBALS['wvc_tab_count'] = 0;
$i = 0;
wpb_js_remove_wpautop( $content );

if ( is_array( $GLOBALS['tabs'] ) ) {
	foreach( $GLOBALS['tabs'] as $tab ) {
		$i++;
		$tabs[] = '<li><a class="" href="#wvc-tab-' . absint( $rand ) . '-' . $i . '">' . sanitize_text_field( $tab['title'] ) . '</a></li>';
		$panels[] = '<div id="wvc-tab-' . absint( $rand ) . '-' . $i . '" class="wvc-tab">' . wpb_js_remove_wpautop( $tab['content'] ) . '</div>';
	}
	$return = "\n".'<!-- tabs -->
	<ul class="wvc-tabs-menu">' . implode( "\n", $tabs ) . '</ul>
	<div class="wvc-clear"></div>
	<div class="wvc-tabs-container">' . implode( "\n", $panels ) . '</div>' . "\n";
}
$output .= '<div id="wvc-tabs-' . absint( $rand ) . '" class="' . wvc_sanitize_html_classes( $class ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );

$output .= '>';

$output .= $return . '</div>';

echo $output;

$GLOBALS['tabs'] = array();
$GLOBALS['wvc_tab_count'] = 0;