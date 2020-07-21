<?php
/**
 * Workout Program Exercice shortcode template
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
	'instructions' => '',
	'comment' => '',
	'video_url' => '',
	'video_img' => '',
	'images' => '',
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

$class .= " wvc-workout-program-exercice wvc-workout-program-cell";

if ( $link_url ) {
	$class .= ' wvc-wpe-linked';
}

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '">';

	$output .= '<div class="wvc-wpe-content">';

		if ( $link_url ) {

			$output .= '<a class="wvc-wpe-link-mask" href="' . esc_url( $link_url ) . '"';
			$output .= ' target="' . esc_attr( $link_target ) . '"';

			if ( $link_title ) {
				$output .= ' title="' . esc_attr( $link_title ) . '"';
			}

			$output .= '></a>';
		}

		$output .= '<div class="wvc-wpe-name">';
		$output .= sanitize_text_field( $name );
		$output .= '</div>';

		if ( $subtitle ) {
			$output .= '<div class="wvc-wpe-subtitle">';
			$output .= sanitize_text_field( $subtitle );
			$output .= '</div>';
		}

		if ( $instructions ) {
			$output .= '<div class="wvc-wpe-instructions">';
			$output .= sanitize_text_field( $instructions );
			$output .= '</div>';
		}

		if ( $comment ) {
			$output .= '<div class="wvc-wpe-comment">';
			$output .= sanitize_text_field( $comment );
			$output .= '</div>';
		}

	$output .= '</div>';

	if ( $video_url || $images ) {

		$output .= '<div class="wvc-wpe-media wvc-no-print">';

			if ( $video_url ) {

				$output .= '<a class="wvc-wpe-link wvc-wpe-video-link wvc-video-opener" href="' . esc_url( $video_url ) . '">';
				
				if ( $video_img && wp_attachment_is_image( $video_img ) ) {
					
					$img = wpb_getImageBySize( array(
						'attach_id' => $video_img,
						'thumb_size' => 'thumbnail',
						'class' => 'wvc-wpe-thumbnail wvc-wpe-video-thumbnail',
					) );

					$output .= $img['thumbnail'];
				}

				$output .= '</a>';
			}

			if ( $images ) {

				$images = wvc_list_to_array( $images );
				$gallery_cover_id = absint( $images[0] );
				$images_count = count( $images ) - 1;

				$image_params = array();

				foreach ( $images as $attachment_id ) {

						$attachment = get_post( $attachment_id );

						if ( $attachment ) {
							$img_src = esc_url( wvc_get_url_from_attachment_id( $attachment_id, 'WVC-XL' ) );
							$img_title = wptexturize( $attachment->post_title );
							$img_caption = wptexturize( $attachment->post_excerpt );

							$image_params[] = array(
								'src' => $img_src,
								'opts' => array(
									'caption' => $img_caption,
								),
							);
						}
					}

				$link_title = '';

				$output .= '<a class="wvc-wpe-link wvc-wpe-gallery-link wvc-gallery-quickview" data-gallery-params="' . esc_js( json_encode( $image_params ) ) . '" href="#">';

					if ( $gallery_cover_id && wp_attachment_is_image( $gallery_cover_id ) ) {
						$img = wpb_getImageBySize( array(
							'attach_id' => $gallery_cover_id,
							'thumb_size' => 'thumbnail',
							'class' => 'wvc-wpe-thumbnail wvc-wpe-gallery-thumbnail',
						) );

						$output .= $img['thumbnail'];
					}
	
				$output .= '</a>';
			}

		$output .= '</div>';
	}

$output .= '</div>';

echo $output;