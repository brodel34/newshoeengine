<?php
/**
 * Bandwintown tracking button shortcode template
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
	'size' => 'large',
	'alignment' => 'center',
	'background_color' => '',
	'background_custom_color' => '',
	'text_color' => '',
	'text_custom_color' => '',
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

$class .= ' wvc-bandwintown-tracking-button wvc-element';
$class .= " wvc-btb-align-$alignment";

$artist = wp_strip_all_tags( do_shortcode( $artist ) );
$artist_slug = sanitize_title( $artist );

if ( 'default' === $background_color ) {

	$background_color = '#00B4B3';

} else {
	$background_color = wvc_convert_color_class_to_hex_value( $background_color, $background_custom_color );
}

$background_color = wvc_sanitize_color( $background_color );

$hover_color = wvc_color_brightness( $background_color, -7 );

if ( 'default' === $text_color ) {

	$text_color = '#FFFFFF';

} else {
	$text_color = wvc_convert_color_class_to_hex_value( $text_color, $text_custom_color );
}

$text_color = wvc_sanitize_color( $text_color );

if ( $artist ) {

	$artist = urldecode( $artist );

	$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

	$output .= wvc_element_aos_animation_data_attr( $atts );
	$output .= '>';
	
	ob_start(); ?>
	<iframe src="https://www.bandsintown.com/artist/<?php echo esc_attr( $artist ); ?>/track_button?size=<?php echo esc_attr( $size ); ?>&display_tracker_count=true&text_color=<?php echo urlencode( $text_color ); ?>&background_color=<?php echo urlencode( $background_color ); ?>&hover_color=<?php echo urlencode( $hover_color ); ?>" height="32" width="165" scrolling="no" frameborder="0" style="border:none; overflow:hidden; display:block;"; allowtransparency="true" ></iframe>
	<?php
	$output .= ob_get_clean();

	$output .= '</div>';

} else {
	if ( is_user_logged_in() ) {
		$output  = esc_html__( 'Please set an artist.', 'wolf-visual-composer' );
	}
}

echo $output;