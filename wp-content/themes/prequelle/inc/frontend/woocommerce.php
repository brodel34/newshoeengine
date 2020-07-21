<?php
/**
 * Prequelle WooCommerce functions
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

/**
 * Enable WC features
 */
function prequelle_enable_wc_feature() {
	
	/* Disable Woocommerce CSS */
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'woocommerce_init', 'prequelle_enable_wc_feature' );

/**
 * Add Disabled product zoom class to single_product_image_gallery
 */
function prequelle_add_disabled_product_zoom_class( $classes ) {

	if ( ! prequelle_do_single_product_easyzoom() ) {
		$classes[] = 'woocommerce-single-product-zoom-disabled';
	}

	return $classes;
}
add_filter( 'woocommerce_single_product_image_gallery_classes', 'prequelle_add_disabled_product_zoom_class' );

/**
 * Enable filter product carousel params
 *
 * @param array $options
 * @return array $options
 */
function prequelle_wc_filter_single_product_carousel_options( $options ){

	$options['animation'] = 'fade';
	$options['directionNav'] = true;
	$options['smoothHeight'] = false;

	return $options;
}
add_filter( 'woocommerce_single_product_carousel_options', 'prequelle_wc_filter_single_product_carousel_options' );

/**
 * WooCommerce AJAX search result
 *
 * @param string $typed
 */
function prequelle_woocommerce_ajax_search_query( $typed = null ) {

	$args = array(
		'post_type' => array( 'product' ),
		'post_status' => 'publish',
		'posts_per_page' => 5,
		's' => $typed,
	);
	add_filter( 'posts_search', 'prequelle_product_search_by_title_only', 500, 2 );

	return new WP_Query( $args );
}

/**
 * Search by title only for WooCommerce AJAX live search
 *
 * @param string $search
 * @param object $wp_query
 * @return string $search
 */
function prequelle_product_search_by_title_only( $search, &$wp_query ) {
	global $wpdb;
	if ( empty( $search ) )
	    	return $search; // skip processing - no search term in query
		$q = $wp_query->query_vars;
		$n = ! empty( $q['exact'] ) ? '' : '%';
		$search = '';
		$searchand = '';
	foreach ( (array) $q['search_terms'] as $term ) {
		$term = esc_sql( $wpdb->esc_like( $term ) );
		$search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
		$searchand = ' AND ';
	}
	if ( ! empty( $search ) ) {
		$search = " AND ({$search}) ";

		if ( ! is_user_logged_in() )
			$search .= " AND ($wpdb->posts.post_password = '') ";
	}
	return $search;
}

/**
 * Get alternative product thumbnail using the first image from product gallery
 *
 * @param string $size
 * @param bool $echo
 * @return string $output
 */
function prequelle_woocommerce_second_product_thumbnail( $size = 'shop_catalog', $echo = true ) {
	global $post, $product;

	$output = '';
	$attachment_ids = $product->get_gallery_image_ids();
	$image_size = apply_filters( 'single_product_large_thumbnail_size', $size );

	if ( $attachment_ids && isset( $attachment_ids[0] ) ) {

		$attachment_id = $attachment_ids[0];

		$props = wc_get_product_attachment_props( $attachment_id, $post );

		if ( ! $props['url'] ) {
			return;
		}

		$output .= apply_filters(
			'prequelle_woocommerce_single_product_image_slide_html',
			sprintf(
				'<div class="product-second-thumbnail">%s</div>',
				wp_get_attachment_image( $attachment_id, $image_size )
			)
		);
	}

	if ( $echo ) {
		echo wp_kses_post( $output );
	}

	return $output;
}

/**
 * Filter WooCommerce apgination arguments
 *
 * @param array $args
 * @return array $args
 */
function prequelle_filter_woocommerce_pagination_args( $args ) {

	$args['prev_text'] = '<i class="pagination-icon-prev"></i>';
	$args['next_text'] = '<i class="pagination-icon-next"></i>';

	return $args;
}
add_filter( 'woocommerce_pagination_args', 'prequelle_filter_woocommerce_pagination_args' );

/**
 * Set products per page
 *
 * @return int
 */
function prequelle_products_per_page() {

	/* Posts per page from option else return 12 */
	return apply_filters( 'prequelle_products_per_page', prequelle_get_theme_mod( 'products_per_page', 12 ) );

}
add_filter( 'loop_shop_per_page', 'prequelle_products_per_page', 20 );

/**
 * Set related products count
 *
 * @return int
 */
function prequelle_related_products_args( $args ) {

	$single_product_sidebar_layout = array( 'sidebar', 'sidebar-left', 'sidebar-right' );
	$single_product_layout = prequelle_get_inherit_mod( 'product_single_layout' );

	if ( in_array( $single_product_layout, $single_product_sidebar_layout ) ) {

		$args['posts_per_page'] = 3;

	} elseif ( 'fullwidth' === $single_product_layout  ) {

		$args['posts_per_page'] = 6;

	} else {
		$args['posts_per_page'] = 4;
	}

	if ( prequelle_get_theme_mod( 'related_products_carousel' ) ) {
		$args['posts_per_page'] = 12;
	}

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'prequelle_related_products_args' );

/**
 * Number of product per row
 *
 *  @return int
 */
function prequelle_loop_columns() {

	return 99999; // set inifinite number to handle this with CSS
}
add_filter( 'loop_shop_columns', 'prequelle_loop_columns' );

/**
 * Get WooCommerce shop page id
 *
 * @return int
 */
function prequelle_get_woocommerce_shop_page_id() {

	$page_id = null;

	if ( class_exists( 'Woocommerce' ) ) {
		$page_id = get_option( 'woocommerce_shop_page_id' );
	}

	return $page_id;
}

/**
 * Remove "sale" label on single product page
 *
 * Added manually in the product-image.php file
 */
function prequelle_wc_remove_sale_label() {
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
}
add_action( 'init', 'prequelle_wc_remove_sale_label' );


/**
 * Remove wishlist button hook from single product
 *
 * We will add it in the template
 */
function prequelle_wc_remove_single_wishlist() {
	remove_action( 'woocommerce_after_add_to_cart_button', 'www_output_add_to_cart_button' );
}
add_action( 'init', 'prequelle_wc_remove_single_wishlist' );

/**
 *  Add Woocommece ajax Cart feature
 */
if ( ! function_exists( 'prequelle_woocommerce_add_to_cart_fragment_item_count' ) ) {
	/**
	 * Ensure cart contents update when products are added to the cart via AJAX
	 * @see http://docs.woothemes.com/document/show-cart-contents-total/
	 */
	function prequelle_woocommerce_add_to_cart_fragment_item_count( $fragments ) {
		ob_start();
		?>
		<span class="cart-icon-product-count"><?php echo absint( WC()->cart->cart_contents_count ); ?></span>
		<?php
		$fragments['.cart-icon-product-count'] = ob_get_clean();

		return $fragments;

	}
	add_filter( 'add_to_cart_fragments', 'prequelle_woocommerce_add_to_cart_fragment_item_count' );
}

if ( ! function_exists( 'prequelle_woocommerce_add_to_cart_fragment_panel' ) ) {
	/**
	 * Ensure cart contents update when products are added to the cart via AJAX
	 * @see http://docs.woothemes.com/document/show-cart-contents-total/
	 */
	function prequelle_woocommerce_add_to_cart_fragment_panel( $fragments ) {

		$fragments['.cart-panel'] = prequelle_cart_panel();

		return $fragments;

	}
	add_filter( 'add_to_cart_fragments', 'prequelle_woocommerce_add_to_cart_fragment_panel' );
}