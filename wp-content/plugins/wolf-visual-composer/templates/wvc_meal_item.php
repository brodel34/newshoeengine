<?php
/**
 * Meal Item shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'name' => '',
	'subtitle' => '',
	'comment' => '',
	'quantity' => '',
	'image' => '',
	'link' => '',
	'el_class' => '',
), $atts ) );

$output = $inline_style = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );

/* Link */
$link = vc_build_link( $link );
$link_url = esc_url( $link['url'] );
$link_target = ( isset( $link['target'] ) && $link['target'] ) ? esc_attr( $link['target'] )  : '_self';
$link_title = esc_attr( $link['title'] );

$class .= " wvc-meal-item wvc-meal-cell";

if ( $link_url ) {
	$class .= ' wvc-mi-linked';
}

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '">';

	$output .= '<div class="wvc-mi-content">';

		if ( $link_url ) {

			$output .= '<a class="wvc-mi-link-mask" href="' . esc_url( $link_url ) . '"';
			$output .= ' target="' . esc_attr( $link_target ) . '"';

			if ( $link_title ) {
				$output .= ' title="' . esc_attr( $link_title ) . '"';
			}

			$output .= '></a>';
		}

		$output .= '<div class="wvc-mi-name">';
		$output .= sanitize_text_field( $name );

			if ( $quantity ) {
				$output .= ' <span class="wvc-mi-quantity">';
				$output .= '&nbsp;' . sanitize_text_field( $quantity );
				$output .= '</span>';
			}
		$output .= '</div>';

		if ( $subtitle ) {
			$output .= '<div class="wvc-mi-subtitle">';
			$output .= sanitize_text_field( $subtitle );
			$output .= '</div>';
		}

		if ( $comment ) {
			$output .= '<div class="wvc-mi-comment">';
			$output .= sanitize_text_field( $comment );
			$output .= '</div>';
		}

	$output .= '</div>';

	if ( $image ) {

		$output .= '<div class="wvc-mi-media wvc-no-print">';

				$output .= '<a class="wvc-mi-link wvc-mi-video-link wvc-video-opener" href="' . wvc_get_url_from_attachment_id( $image, 'wvc-XL' ) . '">';
				
				if ( wp_attachment_is_image( $image ) ) {
					
					$img = wpb_getImageBySize( array(
						'attach_id' => $image,
						'thumb_size' => 'thumbnail',
						'class' => 'wvc-mi-thumbnail wvc-mi-video-thumbnail',
					) );

					$output .= $img['thumbnail'];

				$output .= '</a>';
			}

		$output .= '</div>';
	}

$output .= '</div>';

echo $output;