<?php
/**
 * WC cateogories shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'thumbnail_id' => 'thumbnail_id',
	'type' => 'grid',
	'metro_pattern' => 'auto',
	'metro_fullheight' => '',
	'metro_bg_size' => 'cover',
	'img_size' => 'medium',
	'custom_img_size' => '',
	'parent' => 0,
	'font_tone' => '',

	'hide_count' => '',
	'hide_desc' => '',

	'count' => 0, 
	'orderby' => 'count',
	'order' => 'DESC',
	'include' => '',
	'exclude' => '',

	't_align' => '',
	'v_align' => '',

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
	'css_animation' => '',
	'css_animation_delay' => '',
	'css_animation_each' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), apply_filters( 'wvc_wc_categories_atts', $atts ) ) );

$output = $figure_class = $figure_style = '';

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

$class .= " wvc-wc-category-gallery wvc-clearfix wvc-gallery wvc-gallery-$type wvc-gallery-padding-$img_padding wvc-metro-$metro_pattern wvc-element";

if ( $t_align ) {
	$class .= " wvc-wc-category-gallery-t-align-$t_align";
}

if ( $v_align ) {
	$class .= " wvc-wc-category-gallery-v-align-$v_align";
}

if ( 'mosaic' !== $type && 'carousel' !== $type ) {
	$class .= " wvc-gallery-columns-$slides_per_view";
}

if ( 'carousel' === $type ) {
	$class .= " wvc-carousel-columns-$slides_per_view";
}

$figure_class .= ' wvc-wc-category';

$carousel_data = '';

/* Add carousel attributes */
if ( 'carousel' === $type ) {
	$carousel_data = "data-pause-on-hover='$autoplay'
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

$hide_empty = ( WP_DEBUG ) ? false : true;

$include_ids = array();
if ( $include ) {
	$include_array  = wvc_list_to_array( $include );

	foreach ( $include_array as $include_term_slug ) {

		$include_term = get_term_by( 'slug', $include_term_slug, 'product_cat' );

		//debug( $include_term_slug );
		//debug( $include_term );

		if ( $include_term ) {
			$include_ids[] = $include_term->term_id;
		}
 	}
}

$exclude_ids = array();

if ( $exclude ) {
	
	$exclude_array  = wvc_list_to_array( $exclude );

	foreach ( $exclude_array as $exclude_term_slug ) {
		$exclude_term = get_term_by( 'slug', $exclude_term_slug, 'product_cat' );

		if ( $exclude_term ) {
			$exclude_ids[] = $exclude_term->term_id;
		}
 	}
}

$cat_args = array(
	'orderby' => $orderby,
	'order' => $order,
	'taxonomy' => 'product_cat',
	//'parent' => $parent,
	'hide_empty' => 0,
);

if ( $parent ) {
	$cat_args['parent'] = $parent;
}

if ( $include ) {
	$cat_args['include'] = $include_ids;
}

if ( $exclude ) {
	$cat_args['exclude'] = $exclude_ids;
}

$terms = get_terms( $cat_args );

$i = 0;
foreach( $terms as $term ) {

	if ( $count && $i == $count ) {
		break;
	}

	//$img_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
	$term_meta_img = apply_filters( 'wvc_wc_category_img', $thumbnail_id );
	$img_id = get_term_meta( $term->term_id, $term_meta_img, true );
	$link = get_term_link( $term );
	$title = $term->name;
	$description =  $term->description;
	$count = $term->count;

	if ( ! $img_id || ! wp_attachment_is_image( $img_id ) ) {
		if ( ! WP_DEBUG ) {
			continue;
		}
	}

	$img_dominant_colot = wvc_get_image_dominant_color( $img_id );
	$img_color_tone = wvc_get_color_tone( $img_dominant_colot, 180 );

	if ( $font_tone ) {
		$img_color_tone = $font_tone;
	}

	$metro_class = '';
	
	if ( 'metro' === $type ) {

		$img_class = 'wvc-img-cover';
		$img_size = wvc_get_metro_img_size( $metro_pattern, $i );

		$metro_class .= 'wvc-metro-item wvc-metro-item-bg-size-' . $metro_bg_size;
		
		if ( 'auto' === $metro_pattern ) {

			$metadata = wp_get_attachment_metadata( $img_id );

			if ( isset( $metadata['width'] ) ) {

				$width = $metadata['width'];
				$height = $metadata['height'];

				if ( $height > $width ) {
					$metro_class .= ' wvc-metro-item-portrait';
				}

				if ( $width > $height ) {
					if ( ( $width / $height ) > 1.6 ) {
						$metro_class .= ' wvc-metro-item-landscape';
					}
				}
			}
		}
	}

	/* Item */
	if ( ! wvc_is_new_animation( $css_animation ) ) {
		$figure_style = 'animation-delay:' . absint( $single_animation_delay ) . 'ms;';
	}

	$single_animation_delay = $single_animation_delay + 200;

	$output .= "<figure class='$figure_class wvc-wc-tone-$img_color_tone $metro_class wvc-img-$type' style='$figure_style'";
			
		if ( $css_animation_each ) {
			$atts['css_animation_delay'] = $single_animation_delay;
			$output .= wvc_element_aos_animation_data_attr( $atts );
			
		}

		if ( 'justified' === $type ) {

			$metadata = wp_get_attachment_metadata( $img_id );

			if ( isset( $metadata['sizes']['wvc-photo'] ) ) {

				$width = $metadata['sizes']['wvc-photo']['width'];
				$height = $metadata['sizes']['wvc-photo']['height'];

				$output .= 'data-w="' . esc_attr( $width ) . '" data-h="' . esc_attr( $height ) . '"';
			} else {
				$output .= 'data-w="500" data-h="500"'; // fallback
			}
		}

	$output .= '>'; // end opening tag


	if ( 'metro' === $type ) {
		$output .= '<div class="wvc-metro-box wvc-img-metro-box">';
		$output .= '<div class="wvc-img-metro-outer">';
		$output .= '<div class="wvc-img-metro-inner">';
	}

	// Link
	//$output .= '<a href="' . esc_url( $link ) . '" class="wvc-wc-cat-link-mask"></a>';
	$output .= '<a class="wvc-img wvc-img-hover-effect-' . $hover_effect . '" href="' . esc_url( $link ) . '">';

	if ( ! in_array( $img_size, array( 'thumbnail', 'medium', 'large', 'wvc-XL', 'full', 'wvc-photo' ) ) ) {

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

	} else {
			
		if ( wp_attachment_is_image( $img_id ) ) {
			$output .= wp_get_attachment_image( $img_id, $img_size, false, array(
				'class' => $img_class,
			) );
		} else {
			$output .= wvc_placeholder_img( $img_size, $img_class );
		}
	}
	$output .= '<div class="wvc-wc-cat-text-container">';
		$output .= '<div class="wvc-wc-cat-title-container">';
		$output .= '<span class="wvc-wc-cat-title">' . esc_attr( $title ) . '</span>';
		$output .= '</div>';

		if ( $description && ! $hide_desc ) {
			$output .= '<div class="wvc-wc-cat-desc-container">';
			$output .= '<span class="wvc-wc-cat-desc">' . esc_attr( $description ) . '</span>';
			$output .= '</div>';
		}

		if ( $count && ! $hide_count ) {
			$output .= '<div class="wvc-wc-cat-count-container">';
			$output .= '<span class="wvc-wc-cat-count">' . sprintf( _n( '%s product', '%s products', $count, 'wolf-visual-composer' ), number_format_i18n( $count ) ) . '</span>';
			$output .= '</div>';
		}

	$output .= '</div>';

	$output .= '</a>';

	// closing tags
	if ( 'metro' === $type ) {
		$output .= '</div></div></div>';
	}

	$output .= '</figure>';

	$i++;
} // endforeach

$output .= '</div><!--.wvc-wc-categories-->';

echo $output;