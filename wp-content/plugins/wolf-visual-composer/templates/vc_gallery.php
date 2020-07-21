<?php
/**
 * Image gallery shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'images' => '',
	'type' => 'image_grid',
	'metro_pattern' => 'auto',
	'metro_fullheight' => '',
	'metro_bg_size' => 'cover',
	'img_size' => 'medium',
	'custom_img_size' => '',
	'slides_per_view' => '',
	'autoplay' => 'yes',
	'transition' => 'auto',
	'slideshow_speed' => 4000,
	'pause_on_hover' => 'yes',
	'nav_dots_tone' => 'light',
	'nav_arrows_tone' => 'light',
	'nav_bullets' => 'yes',
	'nav_arrows' => 'yes',
	'group_cells' => 'yes',
	'img_padding' => '',
	'hover_effect' => '',
	'add_caption' => '',
	'custom_links' => '',
	'onclick' => '',
	'custom_links_target' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'css_animation_each' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$images = wvc_list_to_array( $images );

$type = ( 'mosaic-alt' === $type ) ? 'metro' : $type; // old metro fallback

if ( array() === $images ) {
	return;
}

$output = $figure_class = $figure_style = $link_start = $link_end = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( $css_animation_each ) {

	if ( ! wvc_is_new_animation( $css_animation ) ) {
		$figure_class .= wvc_get_css_animation( $css_animation );
	}

} else {

	if ( ! wvc_is_new_animation( $css_animation ) ) {
		$class .= wvc_get_css_animation( $css_animation );
		$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
	}
}

/* Custom Size */
if ( 'custom' === $img_size ) {
	$img_size = esc_attr( $custom_img_size );
}

if ( 'carousel' === $type ) {

	wp_enqueue_script( 'flickity' );
	wp_enqueue_script( 'wvc-carousels' );
}

if ( 'masonry' === $type ) {
	wp_enqueue_script( 'imagesloaded' );
	wp_enqueue_script( 'isotope' );
	wp_enqueue_script( 'wvc-galleries' );
}

if ( 'metro' === $type ) {
	wp_enqueue_script( 'imagesloaded' );
	wp_enqueue_script( 'isotope' );
	wp_enqueue_script( 'packery-mode' );
	wp_enqueue_script( 'wvc-galleries' );
}

if ( 'justified' === $type ) {
	wp_enqueue_script( 'flex-images' );
	wp_enqueue_script( 'wvc-galleries' );
}

if ( 'link_image' === $onclick ) {

	wp_enqueue_script( 'prettyphoto' );
	wp_enqueue_style( 'prettyphoto' );

} elseif ( 'swipebox' === $onclick) {

	wp_enqueue_script( 'swipebox' );
	wp_enqueue_style( 'swipebox' );

} elseif ( 'lightbox' === $onclick) {

	wp_enqueue_script( 'swipebox' );
	wp_enqueue_style( 'swipebox' );
}

$pretty_rel_random = ' data-rel="prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']"';
$swipebox_rel_random = ' data-rel="swipebox[rel-' . get_the_ID() . '-' . rand() . ']"';
$lightbox_rel_random = ' data-rel="lightbox[rel-' . get_the_ID() . '-' . rand() . ']"';

if ( 'custom_link' === $onclick ) {
	$custom_links = vc_value_from_safe( $custom_links );
	$custom_links = explode( ',', $custom_links );
}

$class .= " wvc-clearfix wvc-gallery wvc-gallery-$type wvc-gallery-padding-$img_padding wvc-metro-$metro_pattern wvc-element wvc-gallery-add-caption-$add_caption";

if ( 'mosaic' !== $type && 'carousel' !== $type ) {
	$class .= " wvc-gallery-columns-$slides_per_view";
}

if ( 'carousel' === $type ) {
	$class .= " wvc-carousel-columns-$slides_per_view";
}

if ( $metro_fullheight && 'metro' === $type ) {
	$class .= ' wvc-metro-fullheight';
}

$carousel_data = '';

/* Add carousel attributes */
if ( 'carousel' === $type ) {
	$carousel_data = "data-pause-on-hover='$pause_on_hover'
		data-autoplay='$autoplay'
		data-transition='$transition'
		data-slideshow-speed='$slideshow_speed'
		data-nav-arrows='$nav_arrows'
		data-nav-bullets='$nav_bullets'
		data-group-cells='$group_cells'";

	//$carousel_data .= 'data-flickity="' . esc_js( '{ "lazyLoad": true }' ) . '"';

	$class .= " wvc-carousel-nav-dots-tone-$nav_dots_tone wvc-carousel-nav-arrows-tone-$nav_arrows_tone";

	if ( 'true' === $nav_bullets ) {
		$class .= ' wvc-carousel-has-bullet';
	}
}

$output .= '<div ' . $carousel_data . ' class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

if ( ! $css_animation_each ) {
	$output .= wvc_element_aos_animation_data_attr( $atts );
}

$output .= '>';

$single_animation_delay = ( $css_animation_delay ) ? $css_animation_delay : 0;

$img_class = '';

if ( 'justified' === $type ) {
	$img_size = 'wvc-photo';
}

if ( 'masonry' === $type ) {
	$img_size = 'wvc-masonry';
}

$i = 0;
$j = 0;

foreach ( $images as $img_id ) {

	if ( 'metro' === $type ) {

		$img_class = 'wvc-img-cover';

		if ( 0 === $i || 1 === $i ) {

			//$img_size = 'large';

		} else {
			//$img_size = 'medium';
		}

		$img_size = wvc_get_metro_img_size( $metro_pattern, $j );
	}

	if ( 'mosaic' === $type ) {

		$img_class = 'wvc-img-cover';

		if ( $i%6 == 0) {
			if ( $i == 0 ) {
				$output .= "\n";
				$output .= '<div class="wvc-mosaic-block">';
				$output .= "\n";
			} elseif ( $i != count( $images ) ) {
				$output .= '</div><!--.wvc-mosaic-block-->';
				$output .= "\n";
				$output .= '<div class="wvc-mosaic-block">';
				$output .= "\n";
			} else {
				$output .= '</div><!--.wvc-mosaic-block-->';
				$output .= "\n";
			}
		}

		/* Images sizes */
		if ( $i%6 == 2 ) {
			$img_size = 'medium'; // small square

		} elseif( $i%6 == 4 ) {

			$img_size = 'medium'; // small square

		} else {
			$img_size = 'large';
		}

		$i++;
	}

	//if ( wp_attachment_is_image( $img_id ) ) {

	if ( 1 === 1 ) {

		if ( ! wvc_is_new_animation( $css_animation ) ) {
			$figure_style = 'animation-delay:' . absint( $single_animation_delay ) . 'ms;';
		}
		
		
		$single_animation_delay = $single_animation_delay + 200;

		$large_img_src = wvc_get_url_from_attachment_id( $img_id, 'wvc-XL' );

		$attachment = get_post( $img_id );
		$attachment_page_url = ( $attachment ) ? get_attachment_link( $img_id ) : '#';
		$title_attr = ( is_object( $attachment ) ) ? wptexturize( $attachment->post_title ) : '';
		$caption = ( is_object( $attachment ) ) ? wptexturize( $attachment->post_excerpt ) : '';

		switch ( $onclick ) {
			case 'none':
				$link_start = '<span class="wvc-img wvc-img-hover-effect-' . $hover_effect . '" title="' . esc_attr( $title_attr ) . '">';
				$link_end = '</span>';
				break;

			case 'attachment_page':
				$link_start = '<a class="wvc-img wvc-img-hover-effect-' . $hover_effect . '" href="' . esc_url( $attachment_page_url ) . '" title="' . esc_attr( $title_attr ) . '">';
				$link_end = '</a>';
				break;

			case 'img_link_large':
				$link_start = '<a class="wvc-img wvc-img-hover-effect-' . $hover_effect . '" href="' . esc_url( $large_img_src ) . '" title="' . esc_attr( $title_attr ) . '">';
				$link_end = '</a>';
				break;

			case 'link_image':
				$link_start = '<a class="wvc-img wvc-img-hover-effect-' . $hover_effect . ' prettyphoto" href="' . esc_url( $large_img_src ) . '"' . $pretty_rel_random . ' title="' . esc_attr( $title_attr ) . '">';
				$link_end = '</a>';
				break;
			
			case 'swipebox':
				$link_start = '<a class="wvc-img wvc-img-hover-effect-' . $hover_effect . ' wvc-swipebox" href="' . esc_url( $large_img_src ) . '"' . $swipebox_rel_random . ' title="' . esc_attr( $title_attr ) . '">';
				$link_end = '</a>';
				break;
			
			case 'lightbox':
				$link_start = '<a class="wvc-img wvc-img-hover-effect-' . $hover_effect . ' wvc-lightbox" href="' . esc_url( $large_img_src ) . '"' . $lightbox_rel_random . ' title="' . esc_attr( $title_attr ) . '" data-caption="' . esc_attr( $caption ) . '">';
				$link_end = '</a>';
				break;

			case 'custom_link':

				if ( ! empty( $custom_links[ $j ] ) ) {
					$target = ( $custom_links_target ) ? $custom_links_target : '_self';
					$link_start = '<a class="wvc-img wvc-img-hover-effect-' . $hover_effect . '" href="' . esc_url( $custom_links[ $j ] ) . '" title="' . esc_attr( $title_attr ) . '" target="' . $target . '">';
					$link_end = '</a>';
				}
				break;
		}

		$j++;

		//$dominant_color = wvc_get_image_dominant_color( $img_id );
		//$figure_style .= 'background-color:' . wvc_sanitize_color( $dominant_color ) . '';

		// Custom metro class
		$metro_class = '';
		
		if ( 'metro' === $type ) {

			$metro_class .= 'wvc-metro-item wvc-metro-item-bg-size-' . $metro_bg_size;
			

			if ( 'auto' === $metro_pattern ) {
				$metadata = wp_get_attachment_metadata( $img_id );

				if ( isset( $metadata['width'] ) ) {

					$width = $metadata['width'];
					$height = $metadata['height'];

					if ( $height > $width ) {
						$metro_class .= ' wvc-metro-item-portrait';
						//var_dump( 'portrait' );
					}

					if ( $width > $height ) {
						if ( ( $width / $height ) > 1.6 ) {
							$metro_class .= ' wvc-metro-item-landscape';
						}
					}
				}
			}
		}

		$output .= "<figure class='$figure_class $metro_class wvc-img-$type' style='$figure_style'";
			
			if ( $css_animation_each ) {
				$atts['css_animation_delay'] = $single_animation_delay;
				$output .= wvc_element_aos_animation_data_attr( $atts );
			}

			if ( 'justified' === $type ) {

				$metadata = wp_get_attachment_metadata( $img_id );

				if ( isset( $metadata['sizes']['wvc-photo'] ) ) {

					$width = $metadata['sizes']['wvc-photo']['width'];
					$height = $metadata['sizes']['wvc-photo']['height'];

					$output .= ' data-w="' . esc_attr( $width ) . '" data-h="' . esc_attr( $height ) . '"';
				} else {
					$output .= ' data-w="500" data-h="500"'; // fallback
				}
			}

		$output .= '>';

		if ( 'mosaic' === $type ) {
			$output .= '<span class="wvc-img-mosaic-padding-frame">';
		}

		if ( 'masonry' === $type ) {
			$output .= '<div class="wvc-img-masonry-outer">';
		}

		if ( 'metro' === $type ) {
			$output .= '<div class="wvc-metro-box wvc-img-metro-box">';
			$output .= '<div class="wvc-img-metro-outer">';
			$output .= '<div class="wvc-img-metro-inner">';
		}

		$output .= $link_start;

		if ( 'justified' !== $type && ! in_array( $img_size, array( 'thumbnail', 'medium', 'large', 'wvc-XL', 'full', 'wvc-photo' ) ) ) {

			if ( wp_attachment_is_image( $img_id ) ) {
				
				$img = wpb_getImageBySize( array(
					'attach_id' => $img_id,
					'thumb_size' => $img_size,
					'class' => $img_class,
				) );

				$output .= $img['thumbnail'];
			} else {
				$output .= wvc_placeholder_img( $img_size, $img_class );
			}

		} elseif ( 'justified' === $type ) {
				
			$blank = WVC_URI . '/assets/img/blank.gif';
			$src = wvc_get_url_from_attachment_id( $img_id, $img_size );
			$alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true);
			$title = get_the_title( $img_id );

			if ( ! in_array( $img_size, array( 'thumbnail', 'medium', 'large', 'wvc-XL', 'full', 'wvc-photo' ) ) ) {
				
				if ( wp_attachment_is_image(  ) ) {
					$img = wpb_getImageBySize( array(
						'attach_id' => $img_id,
						'thumb_size' => $img_size,
						'class' => $img_class,
					) );
				} else {
					$img = wvc_placeholder_img( $img_size, $img_class );
				}

				/**
				 * Get src from image tag (yep, dirty, but no other way)
				 */
				if ( preg_match( '/src=("|\')?([a-zA-Z0-9:\/?!=.+%-]+)("|\')?"/', $img['thumbnail'], $match ) ) {
					if ( isset( $match[2] ) ) {
						$src = $match[2];
					}
				} else {
					$src = wvc_placeholder_img_url( $img_sizes );
				}
			}

			if ( 'carouselllll' === $type ) { // disabled

				$output .= '<img
					src="' . esc_url( $blank ) . '"
					data-flickity-lazyload="' . esc_url( $src ) .'"
					title="' . esc_attr( $title ) . '"
					alt="' . esc_attr( $alt ) .'">';

			} elseif ( 'justified' === $type ) {

				$metadata = wp_get_attachment_metadata( $img_id );

				if ( isset( $metadata['sizes']['wvc-photo'] ) ) {

					$width = $metadata['sizes']['wvc-photo']['width'];
					$height = $metadata['sizes']['wvc-photo']['height'];

					$output .= '<img
						class="lazy-hidden"
						width="' . esc_attr( $width ) . '"
						height="' . esc_attr( $height ) . '"
						src="' . esc_url( $blank ) . '"
						data-src="' . esc_url( $src ) .'"
						title="' . esc_attr( $title ) . '"
						alt="' . esc_attr( $alt ) .'">';

				} else {
					// fallback
					$src = wvc_placeholder_img_url( $img_size );

					$output .= '<img
						class="lazy-hidden"
						width="500"
						height="500"
						src="' . esc_url( $blank ) . '"
						data-src="' . esc_url( $src ) .'"
						alt="placeholder">';
				}
			}
			
		} else {
			
			if ( wp_attachment_is_image( $img_id ) ) {
				$output .= wp_get_attachment_image( $img_id, $img_size, false, array(
					'class' => $img_class,
				) );
			} else {
				$output .= wvc_placeholder_img( $img_size, $img_class );
			}
		}

		$output .= $link_end;

		if ( 'mosaic' === $type ) {
			$output .= '</span>';
		}

		if ( 'masonry' === $type ) {
			$output .= '</div>';
		}

		if ( 'metro' === $type ) {
			$output .= '</div></div></div>';
		}

		if ( $add_caption ) {
	
			if ( $title_attr || $caption ) {
				$output .= '<figcaption class="wvc-gallery-image-caption">';
				
				$output .= esc_attr( $title_attr );
				$output .= '<br>';
				$output .= esc_attr( $caption );
				
				$output .= '</figcaption>';
			}
		}

		$output .= '</figure>';
	}
}

if ( 'mosaic' === $type ) {
	$output .= '</div>'; // close mosaic block
}

$output .= '</div><!--.vc_gallery-->';

echo $output;