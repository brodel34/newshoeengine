<?php
/**
 * Wolf Playlist Manager shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'id' => '',
	'show_tracklist' => '',
	'theme' => '',
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

$attrs = array(
	'show_tracklist' => wvc_shortcode_bool( $show_tracklist ),
	'theme' => $theme,
);

$class .= ' wvc-wolf-playlist-shortcode-container wvc-element';

ob_start();
wpm_playlist( $id, $attrs );
$playlist = ob_get_clean();

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= $playlist . '</div><!-- .wvc-wolf-playlist-shortcode-container -->';

echo $output;