<?php
/**
 * Post hooks functions
 *
 * A function that returns any loop of any post type and push it to the prequelle_posts hook
 * Cool right?
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Output posts
 */
function prequelle_output_posts( $atts ) {
	$atts = wp_parse_args( $atts, array(
		'post_type' => 'post',
		'posts_per_page' => -1,
		'paged' => null,
		'grid_padding' => prequelle_get_theme_mod( 'post_grid_padding', 'yes' ),
		'item_animation' => prequelle_get_theme_mod( 'post_item_animation' ),
		'columns' => 'default',
		'include_ids' => '',
		'exclude_ids' => '',
		'ignore_sticky_posts' => false,
		'exclude_sticky_posts' => false,
		'offset' => 0,
		'overlay_color' => apply_filters( 'wvc_default_item_overlay_color', 'black' ),
		'overlay_custom_color' => '',
		'overlay_text_color' => apply_filters( 'wvc_default_item_overlay_text_color', 'white' ),
		'overlay_text_custom_color' => '',
		'overlay_opacity' => apply_filters( 'wvc_default_item_overlay_opacity', 44 ),
		'caption_text_alignment' =>  apply_filters( 'wvc_default_caption_text_align', 'center' ),
		'caption_v_align' => apply_filters( 'wvc_default_caption_v_align', 'middle' ),
		'post_index' => false,
		'post_display' => prequelle_get_theme_mod( 'post_display', 'standard' ),
		'product_metro_pattern' => 'auto',
		'post_module' => 'grid',
		'post_thumbnail_size' => 'standard',
		'post_layout' => 'standard',
		'post_category_filter' => prequelle_get_theme_mod( 'post_category_filter', false ),
		'post_excerpt_type' => 'auto', // for standard post type
		'post_excerpt_length' => 'shorten',
		'post_display_elements' => prequelle_get_theme_mod( 'post_display_elements', 'show_thumbnail,show_date,show_text,show_author,show_category' ),
		'post_alternate_thumbnail_position' => '',
		'category' => '',
		'set_category_var' => '',
		'tag' => '',
		'pagination' => 'none',
		'page_display' => apply_filters( 'page_post_display', 'grid' ),
		'page_by_parent' => '',
		'work_index' => false,
		'work_display' => prequelle_get_theme_mod( 'work_display', 'grid' ),
		'work_module' => 'grid',
		'work_thumbnail_size' => 'standard',
		'work_layout' => 'overlay',
		'work_category_filter' => prequelle_get_theme_mod( 'work_category_filter', true ),
		'work_category_filter_text_alignment' => 'center',
		'work_hover_effect' =>  apply_filters( 'work_default_hover_effect', 'default' ),
		'work_type_include' => '',
		'work_type_exclude' => '',
		'product_index' => false,
		'product_display' => prequelle_get_theme_mod( 'product_display', 'grid_classic' ),
		'product_metro_pattern' => 'pattern-1',
		'product_text_align' => '',
		'product_module' => 'grid',
		'product_cat' => '',
		'product_meta' => '',
		'product_category_link_id' => '',
		'orderby' => '',
		'order' => '',
		'release_index' => false,
		'release_display' => prequelle_get_theme_mod( 'release_display', 'grid' ),
		'release_hover_effect' =>  apply_filters( 'release_default_hover_effect', 'default' ),
		'release_category_filter' => prequelle_get_theme_mod( 'release_category_filter', false ),
		'release_category_filter_text_alignment' => 'center',
		'release_module' => 'grid',
		'release_thumbnail_size' => 'square',
		'release_layout' => 'standard',
		'release_alternate_thumbnail_position' => '',
		'release_add_buy_links' => false,
		'band_include' => '',
		'band_exclude' => '',
		'label_include' => '',
		'label_exclude' => '',
		'event_index' => false,
		'event_display' => prequelle_get_theme_mod( 'event_display', 'list' ),
		'event_module' => 'grid',
		'event_thumbnail_size' => 'standard',
		'event_location' => 'location',
		'artist_include' => '',
		'artist_exclude' => '',
		'timeline' => 'future',
		'video_index' => false,
		'video_display' => prequelle_get_theme_mod( 'video_display', 'grid' ),
		'video_module' => 'grid',
		'video_preview' => false,
		'video_onclick' => prequelle_get_theme_mod( 'video_onclick', 'lightbox' ),
		'video_category_filter' => prequelle_get_theme_mod( 'video_category_filter', false ),
		'video_category_filter_text_alignment' => 'center',
		'video_type_include' => '',
		'video_type_exclude' => '',
		'artist_index' => false,
		'artist_display' => prequelle_get_theme_mod( 'artist_display', 'list' ),
		'artist_hover_effect' =>  apply_filters( 'artist_default_hover_effect', 'default' ),
		'artist_module' => 'grid',
		'artist_thumbnail_size' => 'standard',
		'artist_genre_include' => '',
		'artist_genre_exclude' => '',
		'gallery_index' => false,
		'gallery_display' => prequelle_get_theme_mod( 'gallery_display', 'grid' ),
		'gallery_module' => 'grid',
		'gallery_thumbnail_size' => 'standard',
		'gallery_layout' => 'standard',
		'gallery_category_filter' => prequelle_get_theme_mod( 'gallery_category_filter', true ),
		'gallery_category_filter_text_alignment' => 'center',
		'gallery_hover_effect' =>  apply_filters( 'gallery_default_hover_effect', 'default' ),
		'gallery_type_include' => '',
		'gallery_type_exclude' => '',
		'gallery_type_set' => '',
		'attachment_index' => false,
		'attachment_display' => prequelle_get_theme_mod( 'attachment_display', 'masonry_horizontal' ),
		'attachment_thumbnail_size' => 'standard',
		'attachemnt_orderby' => '',
		'attachment_photo_category_include' => '',
		'attachment_photo_category_exclude' => '',
		'attachment_photo_tag_include' => '',
		'attachment_photo_tag_exclude' => '',
		'attachment_author' => '',
		'inline_style' => '',
		'el_class' => '',
		'el_id' => '',
		'css' => '',
	) );
	
	$clean_atts = array_filter( $atts, function( $var ) { return ( $var ); } ); // clean empty atts for json params
	$json_params = json_encode( $clean_atts );

	$atts = apply_filters( 'prequelle_post_module_atts', $atts );
	
	extract( $atts );
	$posts_per_page = ( isset( ${$post_type . 's_per_page'} ) ) ? ${$post_type . 's_per_page'} : $posts_per_page;
	$posts_per_page = ( $posts_per_page ) ? $posts_per_page : -1;
	$unique_id = uniqid( 'items-' . esc_attr( $post_type ) . '-' );
	$id = ( $el_id ) ? $el_id : $unique_id;
	$layout = ( isset( ${$post_type . '_layout'} ) ) ? ${$post_type . '_layout'} : 'standard';
	$layout = apply_filters( 'prequelle_post_module_layout', $layout, $atts );
	$display = ( isset( ${$post_type . '_display'} ) ) ? ${$post_type . '_display'} : 'standard';
	$display = apply_filters( 'prequelle_post_module_display', $display, $atts );
	$metro_pattern = ( isset( ${$post_type . '_metro_pattern'} ) ) ? ${$post_type . '_metro_pattern'} : 'auto';
	$metro_pattern = apply_filters( 'prequelle_post_module_metro_pattern', $metro_pattern, $atts );
	$module = ( isset( ${$post_type . '_module'} ) ) ? ${$post_type . '_module'} : 'grid';
	$module = apply_filters( 'prequelle_post_module_module', $module, $atts );
	$category_filter = ( isset( ${$post_type . '_category_filter'} ) ) ? prequelle_attr_bool( ${$post_type . '_category_filter'} ) : false;
	
	$thumbnail_size = ( isset( ${$post_type . '_thumbnail_size'} ) ) ? ${$post_type . '_thumbnail_size'} : 'standard';
	
	$is_index = ( isset( ${$post_type . '_index'} ) ) ? prequelle_attr_bool( ${$post_type . '_index'} ) : false;

	if ( prequelle_is_wvc_activated() ) {
		if ( function_exists( 'wvc_sanitize_css_field' ) ) {
			$inline_style = wvc_sanitize_css_field( $inline_style ); // sanitize user CSS input
		}

		if ( function_exists( 'wvc_shortcode_custom_style' ) ) {
			$inline_style .= wvc_shortcode_custom_style( $css ); // add VC CSS from custom class
		}
	}
	$class = $el_class;
	$class .= " clearfix items wvc-element";
	$class .= ' ' . $post_type . '-items';
	$class .= ' ' . $post_type . 's';
	$class .= " caption-text-align-$caption_text_alignment";
	$class .= " caption-valign-$caption_v_align";

	$class .= " grid-padding-$grid_padding"; // padding

	$class .= " display-$display";
	$class .= " $post_type-display-$display";

	$class .= " metro-pattern-$metro_pattern";
	$class .= " $post_type-metro-pattern-$metro_pattern";

	$class .= " module-$module";
	$class .= " $post_type-module-$module";

	$class .= " items-thumbnail-size-$thumbnail_size";

	$class .= " layout-$layout";
	$class .= " $post_type-layout-$layout";

	$paginated_post_types = array( 'post', 'product', 'event', 'release', 'attachment', 'gallery', 'video', 'work' );
	$pagination = ( in_array( $post_type, $paginated_post_types ) ) ? $pagination : 'none';

	$class .= " pagination-$pagination";
	$not_grid = array( 'masonry_horizontal', 'list', 'list_minimal', 'metro', 'metro_modern', 'mosaic', 'standard', 'standard_modern', 'lateral', 'offgrid', 'metro_overlay_quickview', 'metro_modern_alt' );

	$is_list = in_array( $display, array( 'list', 'list_minimal', 'text-background' ) );

	if ( $is_list ) {
		$class .= ' list';
	}

	$metro_display = array( 'metro', 'metro_modern', 'metro_overlay_quickview', 'metro_modern_alt' );

	if ( ! in_array( $display, $not_grid ) ) {
		
		$class .= ' grid';
	
	} elseif ( in_array( $display, $metro_display ) ) {
		
		$class .= ' metro';
	
	} else {
		
		$class .= ' list';
	}

	$masonry_display = array( 'masonry', 'masonry_modern', 'metro', 'metro_modern', 'masonry_overlay_quickview' , 'metro_overlay_quickview', 'metro_modern_alt' );

	if ( in_array( $display, $masonry_display ) || 'page' === $post_type ) { // always masonry for pages for now
		$class .= ' masonry-container';
	}

	if ( 'masonry_horizontal' === $display ) {
		$class .= ' fleximages-container';
	}
	if ( 'carousel' === $module ) {
		$pagination = 'none';
		$category_filter = null;
	}

	if ( $category_filter && ( 'work' === $post_type || 'video' === $post_type || 'gallery' === $post_type || 'release' === $post_type ) ) {
		$class .= ' filtered-content';
	}

	if ( $category_filter && 'post' === $post_type ) {
		$class .= ' ajax-filtered-content';
	}
	if ( isset( $_GET['wpage'] ) && isset( $_GET['index'] ) && $id == esc_attr( $_GET['index'] ) ) {
		$paged = absint( $_GET['wpage'] );
	}

	if ( ! $paged ) {
		/* Fixed in  4.8 ? */
		$page_var = ( is_front_page() ) ? 'page' : 'paged';
		$paged = ( get_query_var( $page_var ) ) ? get_query_var( $page_var ) : 1;
	}
	if ( $offset ) {

		$sticky_posts = ( get_option( 'sticky_posts' ) && is_array( get_option( 'sticky_posts' ) ) ) ? get_option( 'sticky_posts' ) : array();
		$sticky_posts_count = ( 'post' === $post_type ) ? count( $sticky_posts ) : 0;

		$offset = $offset + absint( $sticky_posts_count );
		if ( -1 === $posts_per_page ) {
			$posts_per_page = get_option( 'posts_per_page' );
		}

		if ( 1 === $paged ) {

		} else {
			$offset = $offset + ( ( $paged - 1 ) * $posts_per_page );
		}
	}

	if ( $category_filter && 'post' !== $post_type ) {
		$posts_per_page = -1;
		$pagination_type = 'none';
	}
	$args = array(
		'post_type' => $post_type,
		'post_status' => array( 'publish' ), // published post only
		'posts_per_page' => $posts_per_page,
		'ignore_sticky_posts' => $ignore_sticky_posts,
		'paged' => $paged,
	);

	if ( $offset ) {
		$args['offset'] = $offset;
		$args['ignore_sticky_posts'] = 1; // force ignoring sticky posts
	}
	if ( $include_ids ) {
		$args['post__in'] = prequelle_list_to_array( $include_ids );
	}
	$exclude_ids_array = array();
	$exclude_ids_array[] = prequelle_get_the_ID(); // exclude current post, obviously or the internet will explode

	if ( $exclude_sticky_posts ) {
		$exclude_ids_array = array_merge( $exclude_ids_array, get_option( 'sticky_posts' ) );
	}

	if ( $exclude_ids ) {
		$exclude_ids_array = array_merge( $exclude_ids_array, prequelle_list_to_array( $exclude_ids ) );
	}
	
	$exclude_ids_array = array_unique( $exclude_ids_array );

	$args['post__not_in'] = $exclude_ids_array;

	/*---------------------------------
		POST
	------------------------------------*/

	if ( 'post' === $post_type ) {
		if ( $set_category_var ) {

			if ( 'all' === $set_category_var ) {
				$is_index = false;
				$category = '';
				$tag = '';

			} else {
				$is_index = false;
				$category = $set_category_var;
			}
		}

		if ( $category  ) {
			$args['category_name'] = prequelle_clean_list( $category );
		}
		if ( $tag ) {
			$args['tag'] = prequelle_clean_list( $tag );
		}
		$force_featured_image_post_display = array( 'mosaic', 'grid_square', 'metro', 'offgrid' );

		if ( in_array( $post_display, $force_featured_image_post_display ) ) {
			$args['meta_key'] = '_thumbnail_id';
		}
	}

	/*---------------------------------
		WORK
	------------------------------------*/

	if ( 'work' === $post_type ) {
		if ( $work_type_include ) {
			$args['work_type'] = prequelle_clean_list( $work_type_include );
		}
		if ( $work_type_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'work_type',
					'terms' => array( prequelle_clean_list( $work_type_exclude ) ),
					'field' => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}

		$args['meta_key'] = '_thumbnail_id'; // force post with thumbnail

		$class .= " hover-effect-$work_hover_effect";
		$class .= " work-hover-effect-$work_hover_effect";
	}

	/*---------------------------------
		VIDEO
	------------------------------------*/

	if ( 'video' === $post_type ) {

		$class .= " video-preview-$video_preview";
		if ( $video_type_include ) {
			$args['video_type'] = prequelle_clean_list( $video_type_include );
		}
		if ( $video_type_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'video_type',
					'terms' => array( prequelle_clean_list( $video_type_exclude ) ),
					'field' => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}

		$args['meta_key'] = '_thumbnail_id'; // force post with thumbnail
	}

	/*---------------------------------
		GALLERY
	------------------------------------*/

	if ( 'gallery' === $post_type ) {
		if ( $gallery_type_include ) {
			$args['gallery_type'] = prequelle_clean_list( $gallery_type_include );
		}
		if ( $gallery_type_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'gallery_type',
					'terms' => array( prequelle_clean_list( $gallery_type_exclude ) ),
					'field' => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}

		$args['meta_key'] = '_thumbnail_id'; // force post with thumbnail

		$class .= " hover-effect-$gallery_hover_effect";
		$class .= " gallery-hover-effect-$gallery_hover_effect";
	}

	/*---------------------------------
		RELEASE
	------------------------------------*/

	if ( 'release' === $post_type ) {
		if ( $band_include ) {
			$args['band'] = prequelle_clean_list( $band_include );
		}
		if ( $band_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'band',
					'terms' => array( prequelle_clean_list( $band_exclude ) ),
					'field' => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}
		if ( $label_include ) {
			$args['label'] = prequelle_clean_list( $label_include );
		}
		if ( $label_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'label',
					'terms' => array( prequelle_clean_list( $label_exclude ) ),
					'field' => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}

		$args['meta_key'] = '_thumbnail_id'; // force post with thumbnail

		$class .= " hover-effect-$release_hover_effect";
		$class .= " release-hover-effect-$release_hover_effect";
	}

	/*---------------------------------
		ARTIST
	------------------------------------*/

	if ( 'artist' === $post_type ) {
		if ( $artist_genre_include ) {
			$args['artist_genre'] = prequelle_clean_list( $artist_genre_include );
		}
		if ( $artist_genre_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'artist_genre',
					'terms' => array( prequelle_clean_list( $artist_genre_exclude ) ),
					'field' => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}

		$class .= " hover-effect-$artist_hover_effect";
		$class .= " artist-hover-effect-$artist_hover_effect";
	}

	/*---------------------------------
		PAGE
	------------------------------------*/

	if ( 'page' === $post_type ) {
		$force_featured_image_page_display = array( 'grid', 'grid_overlay', 'masonry', 'carousel' );

		if ( $page_by_parent ) {

			$parent_page_id = absint( $page_by_parent );

			$child_page_ids = array( $parent_page_id );
			
			$child_pages = get_page_children( $parent_page_id, get_posts( array('post_type' => 'page', 'posts_per_page' => '-1') ) );

			foreach ( $child_pages as $child_page ) {
				$child_page_ids[] = $child_page->ID;
			}
			
			$args['post__in'] = $child_page_ids;
		}

		if ( in_array( $page_display, $force_featured_image_page_display ) ) {
			$args['meta_key'] = '_thumbnail_id';
		}
	}

	/*---------------------------------
		EVENT
	------------------------------------*/

	if ( 'event' === $post_type ) {

		$args['meta_key'] = '_wolf_event_start_date';
		
		$args['orderby'] = 'meta_value';

		if ( 'past' === $timeline ) {
			$args['order'] = 'DESC';
		} else {
			$args['order'] = 'ASC';
		}
		if ( $artist_include ) {
			$args['we_artist'] = prequelle_clean_list( $artist_include );
		}
		if ( $artist_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'we_artist',
					'terms' => array( prequelle_clean_list( $artist_exclude ) ),
					'field' => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}
	}

	/*---------------------------------
		PRODUCT
	------------------------------------*/

	$product_thumbnail_size = 'woocommerce_thumbnail';
	if ( 'product' === $post_type ) {

		$class .= " product-text-align-$product_text_align"; // new

		if ( 'featured' === $product_meta ) {

			$meta_query  = WC()->query->get_meta_query();
			$tax_query   = WC()->query->get_tax_query();
			$tax_query[] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
				'operator' => 'IN',
			);

			$args['meta_query'] = $meta_query;
			$args['tax_query'] = $tax_query;

		} elseif ( 'onsale' === $product_meta ) {

			$meta_query   = WC()->query->get_meta_query();
			$meta_query[] = array(
				'relation' => 'OR',
					array( // Simple products type
						'key'           => '_sale_price',
						'value'         => 0,
						'compare'       => '>',
						'type'          => 'numeric'
					),
					array( // Variable products type
						'key'           => '_min_variation_sale_price',
						'value'         => 0,
						'compare'       => '>',
						'type'          => 'numeric'
					)
			);

			$args['meta_query'] = $meta_query;
		}

		if ( $product_cat ) {
			$args['product_cat'] = prequelle_clean_list( $product_cat );
		}

		if ( 2 == $columns ) {
		}
	}

	/*---------------------------------
		ATTACHMENTS
	------------------------------------*/

	if ( 'attachment' === $post_type ) {

		$item_animation = 'none';

		$args['post_status'] = 'inherit'; // query all first

		$tag_terms = array();
		$cat_terms = array();
		$taxonomy_tag = 'photo_tag';
		$taxonomy_cat = 'photo_category';

		if ( taxonomy_exists( 'photo_tag' ) && taxonomy_exists( 'photo_category' ) ) {
			$taxonomy_tag_terms = get_terms( $taxonomy_tag, array( 'hide_empty' => false, ) );
			foreach ( $taxonomy_tag_terms as $taxonomy_tag_term ) {
				$tag_terms[] = $taxonomy_tag_term->slug;
			}

			$taxonomy_cat_terms = get_terms( $taxonomy_cat, array( 'hide_empty' => false, ) );
			foreach ( $taxonomy_cat_terms as $taxonomy_cat_term ) {
				$cat_terms[] = $taxonomy_cat_term->slug;
			}
		}
		if ( isset( $_GET['s'] ) ) {

			$search_term = esc_attr( $_GET['s'] );
			$search_terms = explode( ' ', $search_term );
			$args['meta_key'] = '_wolf_views_count';
			$args['orderby'] = 'meta_value_num date';
			$args['order'] = 'DESC';

			$args['tax_query'] = array(
				'relation' => 'OR',
		  		array(
					'taxonomy' => 'photo_tag',
					'field' => 'slug',
					'terms' => $search_terms,
				),
				array(
					'taxonomy' => $taxonomy_cat,
					'field' => 'slug',
					'terms' => $search_terms,
				),
			);

			$tax_query = new WP_Query( apply_filters( 'prequelle_post_module_query_args', $args ) );
			if ( 0 === $tax_query->post_count ) {

				$args['s'] = $search_term; // regular search query
				$args['tax_query'] = array(
			  		'relation' => 'OR',
					array(
						'taxonomy' => $taxonomy_tag,
						'field' => 'slug',
						'terms' => $tag_terms,
					),

					array(
						'taxonomy' => $taxonomy_cat,
						'field' => 'slug',
						'terms' => $cat_terms,
					),
				);
			}

		} else {

			if ( $attachment_author ) {
				$args['author'] = absint( $attachment_author );
			}

			if ( 'popular' === $attachemnt_orderby ) {
				$args['meta_key'] = '_wolf_views_count';
				$args['orderby'] = 'meta_value_num date';
				$args['order'] = 'DESC';
			}

			$args['tax_query'] = array(
				'relation' => 'OR',
				array(
					'taxonomy' => $taxonomy_tag,
					'field' => 'slug',
					'terms' => $tag_terms,
				),

				array(
					'taxonomy' => $taxonomy_cat,
					'field' => 'slug',
					'terms' => $cat_terms,
				),
			);
		} // regular query
	}

	/*--------------------------------------------------------------*/
	if ( $orderby ) {
		$args['orderby'] = $orderby;
	}

	if ( $order ) {
		$args['order'] = $order;
	}

	if ( $is_index ) { // is index page

		global $wp_query;
		$query = $wp_query;

	} else { // custom query

		add_filter( 'found_posts', 'prequelle_offset_pagination_fix', 10, 2 );
		if ( 'event' === $post_type && function_exists( 'we_order_by' ) && function_exists( 'we_future_where' ) ) {
		
			add_filter( 'posts_orderby', 'we_order_by', 10, 1 );

			if ( 'past' === $timeline ) {
				
				add_filter( 'posts_where', 'we_past_where', 10, 1 );
			} else {
				add_filter( 'posts_where', 'we_future_where', 10, 1 );
			}
		}

		/* The query */
		$query = new WP_Query( $args );

		if ( 'event' === $post_type && function_exists( 'we_order_by' ) && function_exists( 'we_future_where' ) ) {
			
			if ( 'past' === $timeline ) {
				
				remove_filter( 'posts_where', 'we_past_where', 10, 1 );
			
			} else {
				
				remove_filter( 'posts_where', 'we_future_where', 10, 1 );
			}
		}

		remove_filter( 'found_posts', 'prequelle_offset_pagination_fix', 10, 2 );
	}
	if ( $query->have_posts() ) {
		if ( in_array( $display, $masonry_display ) || 'page' === $post_type ) {
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'isotope' );

			if ( in_array( $display, $metro_display ) ) {
				wp_enqueue_script( 'packery-mode' );
			}

			wp_enqueue_script( 'prequelle-masonry' );
		}

		if ( 'masonry_horizontal' === $display ) {
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'flex-images' );
			wp_enqueue_script( 'prequelle-masonry' );
		}

		if ( 'carousel' === $module ) {
			wp_enqueue_script( 'flickity' );
			wp_enqueue_script( 'prequelle-carousels' );
		}

		if ( 'attachment' === $post_type ) {
			wp_enqueue_script( 'infinitescroll' );
			wp_enqueue_script( 'lazyloadxt' );
		}

		if ( $category_filter ) {
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'isotope' );
			wp_enqueue_script( 'prequelle-category-filter' );

			/*
			 * Pass args to filter template. Cool stuff.
			 */
			set_query_var( 'filter_args', array(

				/* Post */
				'category' => prequelle_clean_list( $category ),

				/* Work */
				'work_type_include' => prequelle_clean_list( $work_type_include ),
				'work_type_exclude' => prequelle_clean_list( $work_type_exclude ),
				'work_category_filter_text_alignment' => $work_category_filter_text_alignment,

				/* Albums */
				'gallery_type_include' => prequelle_clean_list( $gallery_type_include ),
				'gallery_type_exclude' => prequelle_clean_list( $gallery_type_exclude ),
				'gallery_category_filter_text_alignment' => $gallery_category_filter_text_alignment,

				/* Video */
				'video_type_include' => prequelle_clean_list( $video_type_include ),
				'video_type_exclude' => prequelle_clean_list( $video_type_exclude ),
				'video_category_filter_text_alignment' => $video_category_filter_text_alignment,

				/* Release */
				'band_include' => prequelle_clean_list( $band_include ),
				'band_exclude' => prequelle_clean_list( $band_exclude ),
				'release_category_filter_text_alignment' => $release_category_filter_text_alignment,
			) );

			/**
			 * Category filter
			 */
			get_template_part( 'components/filter/filter', $post_type );
		}

		$tag = ( $is_list ) ? 'ul' : 'div';
		echo '<' . $tag . ' id="' . esc_attr( $id ) . '" data-post-type="' . esc_attr( $post_type ) . '" data-params="' . esc_js( $json_params ) . '" class="' . prequelle_sanitize_html_classes( $class ) . '" style="' . prequelle_esc_style_attr( $inline_style ) . '">';


		/**
		 * Filter default post display options from customizer to output the right post class through post_class() function
		 * @see inc/frontent/post-attributes.php
		 */
		add_filter( 'prequelle_post_display', function( $default ) use ( $display ) { return $display; } );
		add_filter( 'prequelle_post_item_animation', function( $default ) use ( $item_animation ) { return prequelle_animation_fallback( $item_animation ); } );
		add_filter( 'prequelle_post_columns', function( $default ) use ( $columns ) { return $columns; } );
		add_filter( 'prequelle_post_force_loop_class', function() { return true; } );

		$i = 0;

		if ( ( $posts_per_page % 2 !== 0 ) && ( $paged !== 1 ) ) {
			$i = 1;
		}

		while ( $query->have_posts() ) {

			$i++;

			$query->the_post();

			/*
			 * Pass args to template
			 */
			set_query_var( 'template_args', array(

				'display' => $display,
				'layout' => $layout,

				'overlay_color' => $overlay_color,
				'overlay_custom_color' => $overlay_custom_color,
				'overlay_opacity' => $overlay_opacity,
				'overlay_text_color' => $overlay_text_color,
				'overlay_text_custom_color' => $overlay_text_custom_color,
				'post_excerpt_type' => $post_excerpt_type,
				'post_excerpt_length' => $post_excerpt_length,
				'post_display_elements' => $post_display_elements,
				'post_alternate_thumbnail_position' => $post_alternate_thumbnail_position,
				
				'release_alternate_thumbnail_position' => $release_alternate_thumbnail_position,
				'release_add_buy_links' => $release_add_buy_links,

				'index' => $i,

				'video_onclick' => $video_onclick,
				'video_preview' => $video_preview,

				'event_location' => $event_location,
				'event_timeline' => $timeline,

				/* Product */
				'product_thumbnail_size' => $product_thumbnail_size,
			) );

			/*
			 * Include the template part for the content.
			 */
			get_template_part( 'components/' . $post_type . '/display/content', $display );

		}

		echo '</' . $tag . '><!--.items-->';
		remove_all_filters( 'prequelle_post_display' );
		remove_all_filters( 'prequelle_post_item_animation' );
		remove_all_filters( 'prequelle_post_columns' );
		if ( 'none' !== $pagination ) {
			$pagination_args = array(
				'post_type' => $post_type,
				'pagination_type' => $pagination,
				'product_category_link_id' => $product_category_link_id,
				'paged' => $paged,
				'container_id' => $id,
			);
			do_action( 'prequelle_pagination', $query, $pagination_args  );
		}

	} else {
		/* No result */
		if ( 'event' === $post_type ) {

			if ( 'past' === $timeline ) {

				apply_filters( 'prequelle_no_past_event_text', esc_html__( 'No past event.', 'prequelle' ) );

			} else {
				if ( function_exists( 'we_get_option' ) ) {
					echo we_get_option( 'no_event_text', esc_html__( 'No upcoming shows scheduled.', 'prequelle' ) );
				}
			}

		} elseif ( 'release' === $post_type ) {

			echo apply_filters( 'prequelle_no_release_text', esc_html__( 'No release yet.', 'prequelle' ) );

			if ( is_user_logged_in() ) {
				echo '&nbsp;';
				echo apply_filters( 'prequelle_no_release_user_text', esc_html__( 'Is there a featured image set for each of your releases?', 'prequelle' ) );
			}

		} elseif ( 'video' === $post_type ) {

			echo apply_filters( 'prequelle_no_video_text', esc_html__( 'No video yet.', 'prequelle' ) );

			if ( is_user_logged_in() ) {
				echo '&nbsp;';
				echo apply_filters( 'prequelle_no_video_user_text', esc_html__( 'Is there a featured image set for each of your videos?', 'prequelle' ) );
			}

		} elseif ( 'work' === $post_type ) {

			echo apply_filters( 'prequelle_no_work_text', esc_html__( 'No work yet.', 'prequelle' ) );

		} elseif ( 'page' !== $post_type ) {

			get_template_part( 'components/post/content', 'none' );
		}
	}
	wp_reset_postdata();
}
add_action( 'prequelle_posts', 'prequelle_output_posts' );