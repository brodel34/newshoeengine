<?php
/**
 * Prequelle featured media function
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get post featured media
 *
 * Output opst media depending on post format and content available
 */
function prequelle_featured_media() {
	$output = '';
	$post_id = get_the_ID();
	$post_format = ( get_post_format() ) ? get_post_format() : 'standard';
	$has_post_thumbnail = ( has_post_thumbnail() );
	$permalink = get_permalink();

	$default_thumbnail = '';

	if ( $has_post_thumbnail ) {

		$default_thumbnail .= '<div class="entry-thumbnail">';
			$default_thumbnail .= '<a href="' . esc_url( $permalink ) . '" class="entry-link" title="' . esc_attr( sprintf( __( 'Permalink to %s', 'prequelle' ), the_title_attribute( 'echo=0' ) ) ) . '">';
			$default_thumbnail .= get_the_post_thumbnail( '', 'large' );
			$default_thumbnail .= '<span class="entry-thumbnail-overlay"></span><!-- .entry-thumbnail-overlay -->';
			$default_thumbnail .= '</a>';
		$default_thumbnail .= '</div><!-- .entry-thumbnail -->';
	}

	if ( 'standard' === $post_format || 'chat' === $post_format ) {

		if ( $default_thumbnail ) {

			$output .= $default_thumbnail;
		}

	} elseif ( 'image' === $post_format ) {

		if ( prequelle_is_instagram_post() ) {

			/**
			 * Embed Instagram
			 */
			$output .= prequelle_get_instagram_image( prequelle_get_first_url() );

		} elseif ( $has_post_thumbnail ) {

			/**
			 * Featured image
			 */
			$large_img_src = get_the_post_thumbnail_url( '', 'prequelle-XL' );
			$output .= '<div class="entry-thumbnail">';
			$output .= '<a href="' . esc_url( $large_img_src ) . '" data-fancybox="' . esc_attr( get_the_title() ) . '" class="lightbox" title="' .  the_title_attribute( 'echo=0' ) . '">';

			$output .= get_the_post_thumbnail( '', 'large' );

			$output .= '<span class="entry-thumbnail-overlay"></span><!-- .entry-thumbnail-overlay -->';

			$output .= '</a>';
			$output .= '</div><!-- .entry-thumbnail -->';
		}

	} elseif ( 'gallery' === $post_format ) {

		if ( prequelle_entry_slider() ) {

			$output .= prequelle_entry_slider();

		} elseif ( $default_thumbnail ) {

			$output .= $default_thumbnail;
		}

	} elseif ( 'video' === $post_format ) {

		$content = apply_filters( 'the_content', get_the_content() );
		$video = get_media_embedded_in_content( $content, array( 'video', 'object', 'embed', 'iframe' ) );
		if ( ! empty( $video ) && isset( $video[0] ) ) {
			$output .= '<div class="entry-video">';
				$output .= $video[0];
			$output .= '</div>';
		}

	} elseif ( 'audio' === $post_format ) {

		/* If it's not a playlist, we show the featured image */
		if ( ! prequelle_is_playlist_audio_player() ) {
			$output .= $default_thumbnail;
		}

		/* Highlight the audio file. */
		if ( prequelle_get_audio_embed_content() ) {
			$output .= prequelle_get_audio_embed_content();
		}

	} elseif ( 'quote' === $post_format ) {

		if ( prequelle_get_first_quote() ) {
			$output .= '<div class="entry-thumbnail">';
				$output .= '<a href="' . esc_url( $permalink ) . '" class="entry-link-mask" title="' . esc_attr( sprintf( __( 'Permalink to %s', 'prequelle' ), the_title_attribute( 'echo=0' ) ) ) . '"></a>';
				$output .= prequelle_background_img();

				$output .= '<div class="entry-summary-overlay">';
					$output .= '<blockquote class="entry-featured-quote">';
						$output .= prequelle_get_first_quote();
					$output .= '</blockquote><!-- .entry-featured-quote -->';
				$output .= '</div><!-- .entry-summary-overlay -->';
			$output .= '</div><!-- .entry-thumbnail -->';
		}

	} elseif ( 'link' === $post_format ) {

		if ( prequelle_get_first_url() ) {
			$output .= '<div class="entry-thumbnail">';
				$output .= '<a href="' . esc_url( prequelle_get_first_url() ) . '" target="_blank" class="entry-link-mask"></a>';
				$output .= prequelle_background_img();
				$output .= '<div class="entry-summary-overlay">';
					$output .= '<h2 class="entry-featured-link">';
						$output .= get_the_title();
						$output .= '<span class="meta-icon format-link-title-icon"></span>';
					$output .= '</h2><!-- .entry-featured-link -->';
				$output .= '</div><!-- .entry-summary-overlay -->';
			$output .= '</div><!-- .entry-thumbnail -->';
		}

	} elseif ( 'aside' === $post_format || 'status' === $post_format ) {

		if ( get_the_content() ) {
			$output .= '<div class="entry-thumbnail">';
				$output .= '<a href="' . esc_url( $permalink ) . '" class="entry-link-mask" title="' . esc_attr( sprintf( __( 'Permalink to %s', 'prequelle' ), the_title_attribute( 'echo=0' ) ) ) . '"></a>';
				$output .= prequelle_background_img();

				$output .= '<div class="entry-summary-overlay">';
					$output .= '<div class="entry-featured-status">';
						$output .= prequelle_sample( get_the_content(), 33 );
					$output .= '</div><!-- .entry-featured-status -->';
					$output .= '<div class="author-meta">';
							/**
							 * Avatar
							 */
							$output .= get_avatar( get_the_author_meta( 'user_email' ), 20 );
							$output .= sprintf(
								'<span class="author vcard">by %s</span>',
								get_the_author()
							);
					$output .= '</div>';
				$output .= '</div><!-- .entry-summary-overlay -->';
			$output .= '</div><!-- .entry-thumbnail -->';
		}


	}

	if ( class_exists( 'WPBMap' ) && method_exists( 'WPBMap', 'addAllMappedShortcodes' ) ) {
		WPBMap::addAllMappedShortcodes();
	}

	return $output;
}