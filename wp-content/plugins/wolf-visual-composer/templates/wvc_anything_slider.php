<?php
/**
 * Anything slider shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'autoplay' => '',
	'transition' => 'auto',
	'autoplay' => 'yes',
	'transition' => 'auto',
	'slideshow_speed' => 4000,
	'pause_on_hover' => 'yes',
	'nav_tone' => 'light',
	'nav_bullets' => 'yes',
	'nav_arrows' => 'yes',
	'slider_height' => '100%',
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

wp_enqueue_style( 'linea-icons' );

wp_enqueue_style( 'flexslider' );
wp_enqueue_script( 'flexslider' );
wp_enqueue_script( 'wvc-advanced-slider' );
wp_enqueue_script( 'wvc-sliders' );
wp_enqueue_script( 'wvc-anything-slider' );

$slider_height_unit = 'px';

// percent
if ( '%' === substr( $slider_height, -1 ) ) {
	$slider_height_unit = '%';

	if ( 100 < absint( $slider_height ) ) {
		$slider_height = 100;
	}
// em
} elseif ( 'em' === substr( $slider_height, -2 ) ) {
	$slider_height_unit = 'em';

} elseif ( 'vh' === substr( $slider_height, -2 ) ) {
	$slider_height_unit = 'vh';

//px
} elseif ( 'px' === substr( $slider_height, -2 ) ) {
	$slider_height_unit = 'px';
}

$slider_height = absint( $slider_height );

// debug( $slider_height );

$output = '';
$style = '';
$rand = rand( 0, 9999 );

$class .= " wvc-anything-slider-container wvc-slider-nav-font-tone-$nav_tone wvc-element";

if ( '100%' == $slider_height ) {
	$class .= ' wvc-fullscreen-slider';
}

$slider_data = "
data-autoplay='$autoplay'
data-transition='$transition'
data-slideshow-speed='$slideshow_speed'
data-nav-arrows='$nav_arrows'
data-nav-bullets='$nav_bullets'
data-height='$slider_height'
data-height-unit='$slider_height_unit'
data-pause-on-hover='$pause_on_hover'";

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

	$output .= "<div $slider_data class='flexslider wvc-anything-slider' id='wvc-anything-slider-$rand'>";
		$output .= '<ul class="slides">';

			$output .= wpb_js_remove_wpautop( $content );

		$output .= '</ul><!--.slides-->';
	$output .= '</div><!--.wvc-anything-slider-->';
$output .= '</div><!--.wvc-anything-slider-container-->';

echo $output;