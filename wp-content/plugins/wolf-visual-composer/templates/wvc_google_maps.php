<?php
/**
 * Google Maps shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'title' => '',
	'locations' => '',
	//'coordinates' => '50.800982, 2.486354',
	'size' => '100%',
	'address' => '',
	'zoom' => 10,
	'map_skin' => 'standard',
	'custom_map_skin' => '',
	'marker' => '',
	'marker_img' => '',
	'marker_color' => 'custom',
	'marker_custom_color' => '#F7584C',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$google_api_key = wolf_vc_get_option( 'google-map', 'google_maps_api_key' );

if ( ! $google_api_key ) {

	if ( is_user_logged_in() ) {
		printf( wp_kses_post( __( '<p class="wvc-text-center">You must set a Google Map API key in the <a style="text-decoration:underline;" href="%s" target="_blank">%s settings</a>. You can get your Google Map API <a style="text-decoration:underline;" href="%s" target="_blank">here</a>.<p>', 'wolf-visual-composer' ) ),
			esc_url( admin_url( 'admin.php?page=wvc-google-map' ) ),
			'Wolf WPBakery Page Builder Extension',
			esc_url( 'https://developers.google.com/maps/documentation/javascript/get-api-key' )
		);
	}

	return;
}

wp_enqueue_script( 'google-maps-api', '//maps.googleapis.com/maps/api/js?key=' . $google_api_key, array(), false, true );
wp_enqueue_script( 'wvc-google-maps' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$size = ( $size ) ? $size : '100%';
$el_height = wvc_sanitize_css_value( $size );
$inline_style .= "height:$el_height;";

$colors = wvc_get_shared_colors_hex();

if ( 'default' === $marker_color ) {

	$marker_color = '#F7584C';

} elseif ( 'custom' === $marker_color ) {

	$marker_color = $marker_custom_color;

} else {
	$marker_color = isset( $colors[ $marker_color ] ) ? $colors[ $marker_color ] : '';
}

$marker_color = wvc_sanitize_color( $marker_color );
//$marker_color = str_replace( '#', '', $marker_color );

$class .= ' wvc-clearfix wvc-element wvc-google-maps-container';

$el_id = uniqid( 'wvc-google-maps-' );

if ( $title ) {

	$output .= wpb_widget_title( array(
		'title' => $title,
		'extraclass' => 'wpb_map_heading',
	) );
}

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );

$output .= '>';

$locations = (array) vc_param_group_parse_atts( $locations );
$locations_formatted = array();

if ( ! $locations ) {
	return;
}

$locations_formatted = array();
foreach ( $locations as $location ) {
	//debug( $location );
	$coordinates = wvc_list_to_array( $location['coordinates'] );
	$latitude = ( isset( $coordinates[0] ) ) ? $coordinates[0] : false;
	$longitude = ( isset( $coordinates[1] ) ) ? $coordinates[1] : false;

	$locations_formatted[] = array(
		$location['name'],
		$latitude,
		$longitude,
	);
}

// $coordinates = wvc_list_to_array( $coordinates );
// $latitude = ( isset( $coordinates[0] ) ) ? $coordinates[0] : false;
// $longitude = ( isset( $coordinates[1] ) ) ? $coordinates[1] : false;

// if ( ! $latitude || ! $longitude ) {
// 	return;
// }

$output .= '<div id="' . esc_attr( $el_id ) . '"
class="wvc-google-maps"
data-locations="' . esc_js( json_encode( $locations_formatted ) ) . '"
data-map-skin="' . esc_attr( $map_skin ) . '"
data-zoom="' . esc_attr( $zoom ) . '"
data-marker-color="' . esc_attr( $marker_color ) . '"';



if ( $custom_map_skin ) {
	$custom_map_skin = wvc_clean_spaces( rawurldecode( base64_decode( strip_tags( $custom_map_skin ) ) ) );
	$output .= ' data-custom-map-skin="' . esc_js( $custom_map_skin ) . '"';
}

if ( $marker_img ) {
	$marker_img_url = wvc_get_url_from_attachment_id( $marker_img );
	$output .= 'data-marker-icon="' . esc_url( $marker_img_url ) . '"';
}

$output .= '></div><!--.wvc-google-maps-->';

if ( $address ) {
	$output .= '<address>';

	$output .= wpb_js_remove_wpautop( $address );

	$output .= '</address>';
}

$output .= '</div><!--.wvc-google-maps-container-->';

echo $output;