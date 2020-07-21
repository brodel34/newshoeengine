<?php
/**
 * Testimonial slider shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'text_alignment' => 'center',
	'title' => '',
	'autoplay' => 'yes',
	'transition' => 'slide',
	'slideshow_speed' => 4000,
	'pause_on_hover' => 'yes',
	'nav_bullets' => 'yes',
	'nav_arrows' => 'yes',
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

wp_enqueue_script( 'flickity' );
wp_enqueue_script( 'wvc-carousels' );

$autoplay = esc_attr( $autoplay );
$transition = esc_attr( $transition );
$slideshow_speed = absint( $slideshow_speed );
$pause_on_hover = esc_attr( $pause_on_hover );
$nav_bullets = esc_attr( $nav_bullets );
$nav_arrows = esc_attr( $nav_arrows );
$title = esc_attr( $title );

$class .= " wvc-testimonials-container wvc-testimonials-transition-$transition wvc-testimonials-text-align-$text_alignment wvc-element";

if ( 'true' === $nav_bullets ) {
	$class .= ' wvc-testimonials-container-has-nav-bullets';
}

$slider_data = "data-pause-on-hover='$autoplay'
		data-autoplay='$autoplay'
		data-transition='$transition'
		data-slideshow-speed='$slideshow_speed'
		data-nav-arrows='$nav_arrows'
		data-nav-bullets='$nav_bullets'";

$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= "<div $slider_data class='wvc-testimonials-slider'>";

$output .= wpb_js_remove_wpautop( $content );

$output .= '</div></div>';

echo $output;