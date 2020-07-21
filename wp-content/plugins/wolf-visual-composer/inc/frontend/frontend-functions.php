<?php
/**
 * Wolf WPBakery Page Builder Extension frontend functions
 *
 * General functions available on frontend
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Frontend
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Ouptut additional post attributes
 */
function wvc_post_attr( $post_attr = '' ) {
	echo apply_filters( 'wvc_post_attr', $post_attr );
}

/**
 * Entry Meta
 *
 * @return string $output
 */
function wvc_entry_meta( $echo = true ) {

	$output  = '';
	$post_id = get_the_ID();

	if ( is_sticky() && is_home() && ! is_paged() )
		$output .= '<span class="wvc-featured-post">' . esc_html__( 'Featured', 'wolf-visual-composer' ) . '</span>';

	if ( 'post' === get_post_type() || is_search() ) {
		$output .= wvc_entry_date( false );
	}
	if ( 'post' === get_post_type() && is_multi_author() ) {

		$output .= '<span class="wvc-author-meta author-meta">';
		$output .='<a class="wvc-author-link author-link" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">';
		$output .= get_avatar( get_the_author_meta( 'user_email' ), 20 );
		$output .= '</a>';

		$output .= sprintf(
			'<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'wolf-visual-composer' ), get_the_author() ) ),
			wvc_the_author( false )
		);

		$output .= '</span><!--.author-meta-->';
	}

	if ( 'work' == get_post_type() ) {
		$categories_list = get_the_term_list( $post_id, 'work_type', '', ', ', '' );

	} elseif ( 'video' == get_post_type() ) {

		$categories_list = get_the_term_list( $post_id, 'video_type', '', ', ', '' );

	} elseif ( 'gallery' == get_post_type() ) {

		$categories_list = get_the_term_list( $post_id, 'gallery_type', '', ', ', '' );

	} elseif ( 'plugin' == get_post_type() ) {

		$categories_list = get_the_term_list( $post_id, 'plugin_cat', '', ', ', '' );

	} elseif ( 'theme' == get_post_type() ) {

		$categories_list = get_the_term_list( $post_id, 'theme_cat', '', ', ', '' );

	} else {
		$categories_list = get_the_category_list( __( ', ', 'wolf-visual-composer' ) );
	}

	if ( $categories_list ) {
		$output .= '<span class="wvc-categories-links categories-links">' . $categories_list . '</span>';
	}
	$tag_list = get_the_tag_list( '', __( ', ', 'wolf-visual-composer' ) );
	if ( $tag_list ) {
		$output .= '<span class="wvc-tags-links tags-links">' . $tag_list . '</span>';
	}

	if ( $echo )
		echo apply_filters( 'wvc_entry_meta' , wp_kses( $output, array(
			'span' => array(
				'class' => array(),
			),
			'a' => array(
				'href' => array(),
				'rel' => array(),
				'class' => array(),
			),
			'time' => array(
				'class' => array(),
				'datetime' => array(),
			),

			'img' => array(
				'src' => array(),
				'class' => array(),
			),
		) ) );

	return $output;
}

/**
 * Get date
 *
 * @param bool $echo
 * @return string $date
 */
function wvc_entry_date( $echo = true, $link = false ) {

	$display_time = get_the_date();
	$modified_display_time = get_the_modified_date();

	$date = $display_time;

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time itemprop="datePublished" class="wvc-published plublished" datetime="%1$s">%2$s</time><time itemprop="dateModified" class="wvc-updated updated" datetime="%3$s">%4$s</time>';
	} else {
		$time_string = '<time itemprop="datePublished" class="wvc-published plublished wvc-updated updated" datetime="%1$s">%2$s</time>';
	}

	$_time = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( $display_time ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( $modified_display_time )
	);

	if ( $link ) {
		$date = sprintf(
			'<span class="wvc-posted-on wvc-date posted-on date"><a href="%1$s" rel="bookmark">%2$s</a></span>',
			esc_url( get_permalink() ),
			$_time
		);
	} else {
		$date = sprintf(
			'<span class="wvc-posted-on wvc-date posted-on date">%2$s</span>',
			esc_url( get_permalink() ),
			$_time
		);
	}

	if ( $echo ) {
		echo apply_filters( 'wvc_entry_date', wvc_kses( $date ) );
	}

	return apply_filters( 'wvc_entry_date', wvc_kses( $date ) );
}

/**
 * Get the first gallery shortcode, grab the attachments ids and display a slider
 *
 * @param string $size
 */
function wvc_post_gallery_slider( $size = 'large', $tag_id = null, $class = null, $post_id = null  ) {

	wp_enqueue_script( 'flexslider' );
	wp_enqueue_script( 'wvc-sliders' );

	$ids = array();
	$post_id = ( $post_id ) ?  $post_id : get_the_ID();
	$tag_id = ( $tag_id ) ? esc_attr( $tag_id ) : 'wvc-post-gallery-slider-' . rand( 0, 999 );

	$gallery = get_post_gallery( $post_id, false );
	$ids = isset( $gallery['ids'] ) ? wvc_list_to_array( $gallery['ids'] ) : array();

	if ( array() != $ids ) {
		?>
		<div id="<?php echo esc_attr( $tag_id ); ?>-container">
			<div id="<?php echo esc_attr( $tag_id ); ?>" class="flexslider wvc-post-gallery-slider <?php echo sanitize_html_class( $class ); ?>">
				<ul class="slides">
					<?php foreach ( $ids as $attachment_id ) : ?>
					<li class="slide">
						<?php echo wp_get_attachment_image( $attachment_id, 'medium' ); ?>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<?php
	}
	return ob_get_clean();
}

if ( ! function_exists( 'wvc_the_author' ) ) {
	/**
	 * Get the author
	 *
	 * @param bool $echo
	 * @return string $author
	 */
	function wvc_the_author( $echo = true ) {

		global $post;

		if ( ! is_object( $post ) )
			return;

		$author_id = $post->post_author;
		$author = get_the_author_meta( 'user_nicename', $author_id );

		if ( get_the_author_meta( 'nickname', $author_id ) ) {
			$author = get_the_author_meta( 'nickname', $author_id );
		}

		if ( get_the_author_meta( 'first_name', $author_id ) ) {
			$author = get_the_author_meta( 'first_name', $author_id );

			if ( get_the_author_meta( 'last_name', $author_id ) ) {
				$author .= ' ' .  get_the_author_meta( 'last_name', $author_id );
			}
		}

		$author = sprintf( '<span class="vcard author"><span class="fn">%s</span></span>', $author );

		if ( $echo )
			echo wp_kses( $author, array(
				'span' => array(
					'class' => array()
				),
				'a' => array(
					'href' => array(),
					'rel' => array(),
					'class' => array()
				),
			) );

		return $author;

	}
}

/**
 * Honeypot fallback
 */
function wvc_honeypot_fallback() {
	if ( ! function_exists( 'wpcf7_add_form_tag_honeypot' ) ) {
		if ( function_exists( 'wpcf7_add_form_tag' ) ) {
			wpcf7_add_form_tag( 'honeypot', '__return_false', true );
		}
	}
}
add_action( 'wpcf7_init', 'wvc_honeypot_fallback' );


/**
 * Get the content of a file using wp_remote_get
 *
 * @param string $file_url path from theme folder
 */
function wvc_file_get_contents( $file_url ) {

	if ( $file_url ) {
		$response = wp_remote_get( esc_url( $file_url ) );
		if ( is_array( $response ) ) {
			return wp_remote_retrieve_body( $response );
		}
	}
}

/**
 * Disable objectfit if fullpage is enabled
 *
 * @param bool $bool
 * @return bool $bool
 */
function wvc_disable_img_lazyload( $bool ) {
	if ( wvc_do_fullpage() ) {
		$bool = false;
	}
	return $bool;
}
add_filter( 'wvc_bg_img_lazyload', 'wvc_disable_img_lazyload' );

/**
 * Disable parallax if fullpage is enabled
 *
 * @param bool $bool
 * @return bool $bool
 */
function wvc_disable_parallax_if_needed( $bool ) {
	if ( wvc_do_fullpage() ) {
		$bool = false;
	}
	return $bool;
}
add_filter( 'wvc_bg_parallax', 'wvc_disable_parallax_if_needed' );

/**
 * Remove p tags around VC shortcodes
 */
function wvc_remove_p_tags_around_vc_row( $content ) {
	$content = str_replace(
		array(
			'<p>[vc_row'
		),
		array(
			'[/vc_row]</p>'
		),
		$content
	);

	return $content;
}

/**
 * Filter YT and Vimeo oembed URL
 *
 * Add custom arguments to YT and Vimeo videos URLs
 *
 * @param string $provider
 * @param string $url
 * @param array $args
 * @return string $provider The URL with the added args
 */
function wvc_oembed_add_args( $provider, $url, $args ) {

	if ( strpos( $provider, 'vimeo.com' ) ) {
		$provider = add_query_arg( array(
			'api' => '1',
			'title' => '0',
			'portrait' => '0',
			'badge' => '0',
			'byline' => '0',
			'color' => str_replace( '#', '', apply_filters( 'wvc_theme_accent_color', '#0073AA' ) ),
			'player_id' => isset( $args['player_id'] ) ? esc_attr( $args['player_id'] ) : 'vimeo-iframe-' . rand( 0, 9999 ),
		), $provider );
	}

	if ( strpos( $provider, 'youtu' ) ) {
		$provider = add_query_arg( array(
			'wmode' => 'transparent'
		), $provider );
	}
	
	return $provider;
}
add_filter( 'oembed_fetch_url', 'wvc_oembed_add_args', 99, 3 );

/**
 * Filter a few parameters into YouTube oEmbed requests
 *
 * @link http://goo.gl/yl5D3
 */
function iweb_modest_youtube_player( $html, $url, $args ) {
	
	debug( $html );
	debug( $url );
	debug( $args );

	if ( strpos( $url, 'vimeo.com' ) ) {
		$html = str_replace(
			'<iframe ',
			sprintf( '<iframe id="%s" ', esc_attr( 'test' ) ),
			$html
		);
	}

	return $html;
}

/**
 * Product images
 */
function wvc_show_product_images() {
	global $product;

	$product_id = $product->get_id();
	?>
	<div class="product-images flexslider">
		<?php do_action( 'wvc_product_image_start' ); ?>
		<?php

			/**
			 * If gallery
			 */
			$attachment_ids = $product->get_gallery_image_ids();
			
			if ( is_array( $attachment_ids ) && ! empty( $attachment_ids ) ) {

				echo '<ul class="slides">';

				if ( has_post_thumbnail( $product_id ) ) {
					?>
					<li class="slide">
						<span class="slide-content">
								<?php echo $product->get_image( 'large' ); ?>
						</span>
					</li>
					<?php
				}
				
				foreach ( $attachment_ids as $attachment_id ) {
					if ( wp_attachment_is_image( $attachment_id ) ) {
						?>
						<li class="slide">
							<span class="slide-content">
								<?php
										echo wc_get_gallery_image_html( $attachment_id, true );
								?>
							</span>
						</li>
						<?php
					}
				}

				echo '</ul>';

			/**
			 * If featured image only
			 */
			} elseif ( has_post_thumbnail( $product_id ) ) {
				?>
				<span class="slide-content">
					<?php echo $product->get_image( 'large' ); ?>
				</span>
				<?php

			/**
			 * Placeholder
			 */
			} else {
				
				$html  = '<span class="slide-content"><span class="woocommerce-product-gallery__image--placeholder">';
				$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
				$html .= '</span></span>';

				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
			}
		?>
	</div>
	<?php
}

/**
 * Load wc action for quick view product template
 */
function wvc_view_action_template() {
	add_action( 'wvc_product_image', 'woocommerce_show_product_sale_flash', 10 );
	add_action( 'wvc_product_image', 'wvc_show_product_images', 5 );
	add_action( 'wvc_product_summary', 'wvc_single_title', 5 );
	
	add_action( 'wvc_product_summary', 'woocommerce_template_single_rating', 10 );
	add_action( 'wvc_product_summary', 'woocommerce_template_single_price', 15 );
	add_action( 'wvc_product_summary', 'woocommerce_template_single_excerpt', 20 );
	add_action( 'wvc_product_summary', 'woocommerce_template_single_add_to_cart', 25 );
	add_action( 'wvc_product_summary', 'woocommerce_template_single_meta', 30 );
}
add_action( 'woocommerce_init', 'wvc_view_action_template' );

/**
 * Custom excerpt length
 *
 * @param $excerpt
 * @return $excerpt
 */
function wvc_filter_product_description( $excerpt ) {
	return wvc_sample( $excerpt, apply_filters( 'wvc_excerpt_length', 18 ) );
}

/**
 * Filter image sizer
 *
 * @param $size
 * @return $size
 */
function wvc_filter_image_size( $size ) {
	return 'large';
}

/**
 * Product title linked to page
 */
function wvc_single_title() {
	the_title( '<h2 class="product_title entry-title"><a class="entry-link" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
}

/**
 * @param int $height
 * @param int $weight
 * @return int
 */
function wvc_bmi( $height, $weight, $unit = 'metric' ) {
	
	if ( 'imperial' === $unit ) {
		$weight = $weight / 2.205;
		$height = $height * 2.54;
	}

	return round( absint( $weight ) / ( absint( $height ) / 100 * absint( $height ) / 100 ), 1 );
}

/**
 * @param int $height
 * @param int $weight
 * @param int $age
 * @param string $sex

 * @return int
 */
function wvc_bmr( $height, $weight, $age, $sex, $unit = 'metric' ) {

	$result = '';

	if ( 'imperial' === $unit ) {
		$weight = $weight / 2.205;
		$height = $height * 2.54;
	}

	if ( 'female' == $sex ) {
		
		$result = 655 + ( 9.6 * absint( $weight ) ) + (1.8 * absint( $height ) ) - ( 4.7  * absint( $age ) );
	
	} elseif ( 'male' == $sex ) {

		$result = 66 + ( 13.7 * absint( $weight ) ) + ( 5 * absint( $height ) ) - ( 6.8  * absint( $age ) );
	}

	return $result;
}

/**
 * @param string $bmr
 * @param string $activity
 * @return int
 */
function wvc_daily_calorie_needs( $bmr, $af ) {

	$activity_factor = array(
		'inactive' => 1.2,
		'low' => 1.375,
		'moderate' => 1.55,
		'high' => 1.725,
		'very-high' => 1.9,
	);

	return absint( $bmr * $activity_factor[ $af ] ) . ' kCal';
}

/**
 * @param int $height
 * @param int $weight
 * @param int $age
 * @param string $sex
 * @param string $activity
 * @return int
 */
function wvc_bmi_status( $bmi ) {
	$status = esc_html__( 'healthy' );

	if ( $bmi < 18.5 ) {

		$status = esc_html__( 'underweight' );

	} elseif ( $bmi > 18.5 && $bmi < 24.9 ) {

		$status = esc_html__( 'healthy' );

	} elseif ( $bmi > 25 && $bmi < 29.9 ) {

		$status = esc_html__( 'overweight' );

	} elseif ( $bmi > 30 ) {

		$status = esc_html__( 'obese' );
	}

	return $status;
}