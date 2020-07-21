<?php
/**
 * Album tracklist item shortcode template
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
	'duration' => '',
	'price' => '',
	'mp3' => '',
	'ogg' => '',
	'video_url' => '',
	'action' => '',
	'itunes_url' => '',
	'amazon_url' => '',
	'googleplay_url' => '',
	'buy_url' => '',
	'product_id' => '',
), $atts ) );

$output = '';
$rand = rand( 0, 99999 );

if ( $video_url ) {
	wp_enqueue_script( 'lity' );
}

$output .= '<li class="wvc-album-tracklist-item" itemprop="track" itemscope="" itemtype="http://schema.org/MusicRecording"><span class="wvc-ati-table">';

// Title
$output .= '<span class="wvc-ati-cell wvc-ati-title-cell">';

if ( $title ) {
	$output .= '<span class="wvc-ati-title">' . sanitize_text_field( $title ) . '</span>';
}

$output .= '</span>';

// Duration
$output .= '<span class="wvc-ati-cell wvc-ati-duration-cell">';

if ( $duration ) {
	$output .= '' . sanitize_text_field( $duration ) . '';
}

$output .= '</span>';

// Play
$output .= '<span class="wvc-ati-cell wvc-ati-audio-cell">';

if ( $mp3 || $ogg ) {

	
	$output .= '<a href="#" class="wvc-ati-play-button">';
	$output .= '<i class="wvc-ati-icon wvc-ati-play"></i><i class="wvc-ati-icon wvc-ati-pause"></i>';
	
	$output .= '</a>';

	if ( $mp3 ) {
		$output .= '<audio class="wvc-ati-audio" id="wvc-ati-audio-' . absint( $rand ) . '" src="' . $mp3 . '"></audio>';
	}

	if ( $ogg ) {
		//$output .= '<src="' . $ogg . '">'
	}
}

$output .= '</span>';

// Video
$output .= '<span class="wvc-ati-cell wvc-ati-video-cell">';

if ( $video_url ) {
	$output .= '<a class="wvc-video-opener wvc-ati-link" title="' . esc_html( 'Watch the video', 'wolf-visual-composer' ) . '" href="' . esc_url( $video_url ) . '">';
	$output .= '<i class="wvc-ati-icon wvc-ati-video"></i>';
	$output .= '</a>';
}

$output .= '</span>';

// Action
$output .= '<span class="wvc-ati-cell wvc-ati-action-cell">';

if ( 'download' === $action && $mp3 ) {

	$file_name = parse_url( $mp3, PHP_URL_QUERY );

	$output .= '<a class="wvc-ati-link" title="' . esc_html__( 'Download', 'wolf-visual-composer' ) . '" href="' . esc_url( $mp3 ) . '" download="' . esc_attr( $file_name ) . '"><i class="wvc-ati-icon wvc-ati-download"></i></a>';

} elseif ( 'link' === $action ) {

	if ( $price ) {
		$output .= '<span class="wvc-ati-price">' . sanitize_text_field( $price ) . '</span>';
	}

	if ( $itunes_url ) {
		$output .= '<a class="wvc-ati-link" title="' . sprintf( esc_html__( 'Buy on %s', 'wolf-visual-composer' ), 'iTunes' ) . '" href="' . esc_url( $itunes_url ) . '" target="_blank"><i class="wvc-ati-icon wvc-ati-itunes"></i></a>';
	}

	if ( $amazon_url ) {
		$output .= '<a class="wvc-ati-link" title="' . sprintf( esc_html__( 'Buy on %s', 'wolf-visual-composer' ), 'amazon' ) . '" href="' . esc_url( $amazon_url ) . '" target="_blank"><i class="wvc-ati-icon wvc-ati-amazon"></i></a>';
	}

	if ( $googleplay_url ) {
		$output .= '<a class="wvc-ati-link" title="' . sprintf( esc_html__( 'Buy on %s', 'wolf-visual-composer' ), 'Google Play' ) . '" href="' . esc_url( $googleplay_url ) . '" target="_blank"><i class="wvc-ati-icon wvc-ati-googleplay"></i></a>';
	}

	if ( $buy_url ) {
		$output .= '<a class="wvc-ati-link" title="' . esc_html__( 'Buy', 'wolf-visual-composer' ) . '" href="' . esc_url( $buy_url ) . '" target="_blank"><i class="wvc-ati-icon wvc-ati-buy"></i></a>';
	}

	if ( $product_id ) {
		$output .= wvc_add_to_cart( $product_id, 'wvc-ati-link wvc-ati-add-to-cart-button', '<span class="wvc-ati-add-to-cart-button-title" title="' . esc_html__( 'Add to cart', 'wolf-visual-composer' ) . '"></span><i class="wvc-ati-icon wvc-ati-add-to-cart"></i>' );
	}

} elseif ( 'add_to_cart' === $action && absint( $product_id ) ) {
	$output .= '<i class="wvc-ati-icon wvc-ati-add-to-cart-icon"></i>';
}

$output .= '</span>';

$output .= '</span></li>';

echo $output;