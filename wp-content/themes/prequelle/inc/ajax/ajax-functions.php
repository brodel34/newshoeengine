<?php
/**
 * Prequelle AJAX Functions
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get next page link for load more pagination
 *
 * Use a good ol' regex to get the next page link from current URL
 */
function prequelle_ajax_get_next_page_link() {

	extract( $_POST );

	if ( isset( $_POST['href'] ) ) {
		
		$response = array();
		$href = esc_url( $_POST['href'] );
		$regex = ( get_option( 'permalink_structure' ) ) ? '/page\/([0-9+])/' : '/paged=([0-9+])/';

		if ( preg_match( $regex, $href, $match ) ) {
			
			if ( isset( $match[1] ) ) {

				$response['href'] = str_replace( $match[1], ( absint( $match[1] ) + 1 ), $href );
				$response['currentPage'] = absint( $match[1] ) + 1;
				$response['nextPage'] = absint( $match[1] ) + 2;
				
				echo json_encode( $response );
			}
		}
	}
	exit;

}
add_action( 'wp_ajax_prequelle_ajax_get_next_page_link', 'prequelle_ajax_get_next_page_link' );
add_action( 'wp_ajax_nopriv_prequelle_ajax_get_next_page_link', 'prequelle_ajax_get_next_page_link' );

/**
 * Get loop content for AJAX category filter
 */
function prequelle_ajax_get_post_index_content() {

	extract( $_POST );

	if ( isset( $_POST['params'] ) ) {
		$paged = ( isset( $_POST['params'] ) ) ? absint( $_POST['paged'] ) : 1;
		$params = $_POST['params']; // JSON params
		$params['paged'] = $paged;
		prequelle_output_posts( $params );
	}
	exit;

}
add_action( 'wp_ajax_prequelle_ajax_get_post_index_content', 'prequelle_ajax_get_post_index_content' );
add_action( 'wp_ajax_nopriv_prequelle_ajax_get_post_index_content', 'prequelle_ajax_get_post_index_content' );

/**
 * Get page markup by URL for AJAX navigation
 */
function prequelle_ajax_get_page_markup() {

	extract( $_POST );

	if ( isset( $_POST['url'] ) ) {

		$url = esc_url( $_POST['url'] );
		$url = str_replace( '&#038;', '&', $url ); // decode URL parameters
		$cookies = array();

		/*
		Cookie comes empty in wp_remote_get response if we do nothing
		Pass cookies in case we need them
		*/
		foreach ( $_COOKIE as $name => $value ) {
			$cookies[] = new WP_Http_Cookie( array( 'name' => $name, 'value' => $value ) );
		}
		$response = wp_remote_get( $url , array(
				'timeout' => 10,
				'cookies' => $cookies,
			)
		);
		if ( ! is_wp_error( $response ) && is_array( $response ) ) {
			$html = wp_remote_retrieve_body( $response ); // use the content
			ob_start();
			print( $html ); // output page HTML content
			header( 'Content-Length: ' . ob_get_length() ); // set lenght for progress bar
			header( 'Accept-Ranges: bytes');
		} else {
			echo 'error';
		}
	}
	exit;
}
add_action( 'wp_ajax_prequelle_ajax_get_page_markup', 'prequelle_ajax_get_page_markup' );
add_action( 'wp_ajax_nopriv_prequelle_ajax_get_page_markup', 'prequelle_ajax_get_page_markup' );

/**
 * Get Video URL for AJAX request
 */
function prequelle_ajax_get_video_url_from_post_id() {

	extract( $_POST );

	if ( isset( $_POST['id'] ) ) {
		$post_id = absint( $_POST['id'] );
		echo esc_url( prequelle_get_first_video_url( $post_id ) );
	}

	exit;

}
add_action( 'wp_ajax_prequelle_ajax_get_video_url_from_post_id', 'prequelle_ajax_get_video_url_from_post_id' );
add_action( 'wp_ajax_nopriv_prequelle_ajax_get_video_url_from_post_id', 'prequelle_ajax_get_video_url_from_post_id' );

/**
 * AJAX search
 */
function prequelle_ajax_live_search() {

	extract( $_POST );

	if ( isset( $_POST['s'] ) && '' != $_POST['s'] ) {

		$typed = esc_attr( $_POST['s'] );

		if ( 2 < strlen( $typed ) ) {

			$query = prequelle_ajax_search_query( $typed, true );

			if ( $query && $query->have_posts() ) {

				while ( $query->have_posts() ) {

					$query->the_post();

					$title = str_ireplace( $typed, '<strong>' . $typed . '</strong>', get_the_title() );
					$title = get_the_title();

					$terms = explode( ' ', $typed );

					$words = array();
					$strong_words = array();

					foreach ( $terms as $t ) {
						$words[] = ucfirst( $t );
						$words[] = $t;
					}

					foreach ( $words as $w ) {
						$strong_words[] = "<strong>$w</strong>";
					}

					$words = array_diff( $words, array( 'strong', 's', 'st', 'str', 'stron' ) );

					$title = get_the_title();
					$title = str_replace( $words, $strong_words, $title );
					?>
					<li>
						<a href="<?php the_permalink(); ?>" class="ajax-link post-search-link">
							<div class="post-search-title">
								<?php echo wp_kses( $title, array(
									'strong' => array(),
								) ); ?>
							</div>
						</a>
					</li>
					<?php
				} // endwhile

			} // endif
		}
	}
	exit;
}
add_action( 'wp_ajax_prequelle_ajax_live_search', 'prequelle_ajax_live_search' );
add_action( 'wp_ajax_nopriv_prequelle_ajax_live_search', 'prequelle_ajax_live_search' );

/**
 * WooCommerce AJAX search
 */
function prequelle_ajax_woocommerce_live_search() {

	extract( $_POST );

	if ( isset( $_POST['s'] ) && '' != $_POST['s'] ) {

		$typed = esc_attr( $_POST['s'] );

		if ( 2 < strlen( $typed ) ) {

			$query = prequelle_woocommerce_ajax_search_query( $typed, true );

			if ( $query && $query->have_posts() ) {

				while ( $query->have_posts() ) {

					$query->the_post();
					$product = wc_get_product( get_the_ID() );
					if ( $product && $product->exists() ) {

						$title = str_ireplace( $typed, '<strong>' . $typed . '</strong>', get_the_title() );
						$title = get_the_title();

						$terms = explode( ' ', $typed );

						$words = array();
						$strong_words = array();

						foreach ( $terms as $t ) {
							$words[] = ucfirst( $t );
							$words[] = $t;
						}

						foreach ( $words as $w ) {
							$strong_words[] = "<strong>$w</strong>";
						}

						$words = array_diff( $words, array( 'strong', 's', 'st', 'str', 'stron' ) );

						$title = get_the_title();
						$title = str_replace( $words, $strong_words, $title );
						?>
						<li>
							<a href="<?php the_permalink(); ?>" class="ajax-link product-search-link">
								<div class="product-search-image">
									<?php echo wp_kses_post( $product->get_image() ); ?>
								</div>
								<div class="product-search-title">
									<?php echo wp_kses( $title, array(
										'strong' => array(),
									) ); ?>
								</div>
								<div class="product-search-price">
									<?php
									if( is_a( $product, 'WC_Product_Bundle' ) ){
										if ( $product->min_price != $product->max_price ){
											printf( '%s - %s', wc_price( $product->min_price ), wc_price( $product->max_price ) );
										} else{
											echo wp_striptags( wc_price( $product->min_price ) );
										}
									} elseif ( $product->price != '0' ) {
										echo wp_kses_post( $product->get_price_html() );
									}
									?>
								</div>
							</a>
						</li>
						<?php
					}
				} // endwhile

			} // endif
		}
	}
	exit;
}
add_action( 'wp_ajax_prequelle_ajax_woocommerce_live_search', 'prequelle_ajax_woocommerce_live_search' );
add_action( 'wp_ajax_nopriv_prequelle_ajax_woocommerce_live_search', 'prequelle_ajax_woocommerce_live_search' );

/**
 * Delete customizer init function to force customizer to reset to default theme options
 */
function prequelle_ajax_customizer_reset() {

	if ( ! is_customize_preview() ) {
		wp_send_json_error( 'not_preview' );
		echo 'preview error';
	}

	if ( ! check_ajax_referer( 'prequelle-customizer-reset', 'nonce', false ) ) {
		wp_send_json_error( 'invalid_nonce' );
		echo 'nonce';
	}

	$theme_slug = ( is_child_theme() ) ? prequelle_get_theme_slug() . '_child' : prequelle_get_theme_slug();

	if ( delete_option( $theme_slug . '_customizer_init' ) ) {
		echo 'OK';
	}
	exit;
}
add_action( 'wp_ajax_prequelle_ajax_customizer_reset', 'prequelle_ajax_customizer_reset' );

/**
 * Get URL of an attachment post by ID
 */
function prequelle_ajax_get_url_from_attachment_id() {

	extract( $_POST );

	if ( isset( $_POST['attachmentId'] ) ) {
		$attachment_id = absint( $_POST['attachmentId'] );
		$size = (  isset( $_POST['size'] ) ) ? sanitize_text_field( $_POST['size'] ) : 'medium';
		if ( prequelle_get_url_from_attachment_id( $attachment_id, $size ) ) {
			echo prequelle_get_url_from_attachment_id( $attachment_id, $size );
		}
	}
	exit;
}
add_action( 'wp_ajax_prequelle_ajax_get_url_from_attachment_id', 'prequelle_ajax_get_url_from_attachment_id' );