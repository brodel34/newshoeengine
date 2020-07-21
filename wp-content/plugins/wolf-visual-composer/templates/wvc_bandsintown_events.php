<?php
/**
 * Bandwintown shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'artist' => '',
	'local_dates' => 'true',
	'past_dates' => 'true',
	'display_limit' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'bandsintown', 'https://widget.bandsintown.com/main.min.js', array(), false, true );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$class .= ' wvc-bandwintown-events wvc-element';

$artist = wp_strip_all_tags( do_shortcode( $artist ) );
$artist_slug = sanitize_title( $artist );

$options = array(
	'artist' => $artist,
	'text_color' => '',
	'background_color' => '',
	'display_limit' => $display_limit,
	'link_text_color' => '#ffffff',
	'link_color' => apply_filters( 'wvc_theme_accent_color', '#0073AA' ), // accent color
	'local_dates' => $local_dates,
	'past_dates' => $past_dates,
);

if ( $artist ) {

	$output .= '<div id="wvc-bandwintown-tour-dates-' . $artist_slug . '" class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

	$output .= wvc_element_aos_animation_data_attr( $atts );
	$output .= '>';

	//$output .= '<script type="text/javascript" src="https://widget.bandsintown.com/main.min.js"></script>';
	$output .= '<a class="bit-widget-initializer"'
	. 'data-text-color="' . esc_attr( $options['text_color'] ) . '"'
	. 'data-background-color="' . esc_attr( $options['background_color'] ) . '"'
	. 'data-display-limit="' . esc_attr( $options['display_limit'] ) . '"'
	. 'data-link-text-color="' . esc_attr( $options['link_text_color' ] ) . '"'
	. 'data-popup-background-color="#FFFFFF"'
	. 'data-artist-name="' . esc_attr( $options['artist'] ) . '"'
	. 'data-link-color="' . esc_attr( $options['link_color'] ) . '"'
	. 'data-display-local-dates="' . esc_attr( $options['local_dates'] ) . '"'
	. 'data-display-past-dates="' . esc_attr( $options['past_dates'] ) . '"'
	. 'data-auto-style="false"'
	;
	$output .= '></a>';

	$output .= '</div><!-- .wvc-bandwintown -->';

} else {
	if ( is_user_logged_in() ) {
		$output  = esc_html__( 'Please set an artist.', 'wolf-visual-composer' );
	} else {
		$output  = esc_html__( 'No event scheduled.', 'wolf-visual-composer' );
	}
}

echo $output;