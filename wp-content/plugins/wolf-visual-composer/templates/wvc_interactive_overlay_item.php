<?php
/**
 * Interactive Overlay Item shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'font_color' => 'light',
	'content_width' => 'standard',
	'image' => '',
	'text' => '',
	'link_image' => '',
	'link_type' => 'text',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'wvc-interactive-overlays' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$rand_id = rand( 0,999 );

$class .= ' wvc-interactive-overlay-item wvc-element';

$src = wvc_get_url_from_attachment_id( $image, 'wvc-XL' );

$output .= '<div data-bg-src="' . esc_url( $src ) . '" id="wvc-interactive-overlay-item-' . absint( $rand_id ) .'" style="' . wvc_esc_style_attr( $inline_style ) . '" class="' . wvc_sanitize_html_classes( $class ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
	$output .= '>';


/* Get revslider ID if any */

$item_content_data = ( wvc_get_first_revslider_id( $content ) ) ? 'data-revslider-id="' . wvc_get_first_revslider_id( $content ) . '"' : '';

$overlay_content = '';
$output .= '<div class="wvc-io-item-content" ' . $item_content_data . '>';
	
	$overlay_content .= '[vc_row content_placement="middle" columns_placement="middle" full_height="yes" content_width="' . $content_width . '" font_color="' . $font_color . '" background_type="transparent"][vc_column]';
		$overlay_content .= wpb_js_remove_wpautop( $content );
	$overlay_content .= '[/vc_column][/vc_row]';

	$output .= do_shortcode( $overlay_content ); 

$output .= '</div><!-- .wvc-io-item-content -->';

$output .= '<a rel="nofollow" class="wvc-io-item-link" href="#">';

$output .= '<span class="wvc-io-item-title">';

if ( 'image' === $link_type && $link_image ) {
	
	$output .= wp_get_attachment_image( absint( $link_image ), 'full' );

} else {
	$output .= $text;
}

$output .= '</span>';

$output .= '</a>';

$output .= '</div><!--.wvc-interactive-link-item-->';

echo $output;