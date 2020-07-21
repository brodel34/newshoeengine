<?php
/**
 * Core functions
 *
 * General core functions available on admin and frontend
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Gets the ID of the post, even if it's not inside the loop.
 *
 * @uses WP_Query
 * @uses get_queried_object()
 * @extends get_the_ID()
 * @see get_the_ID()
 *
 * @return int
 */
function prequelle_get_the_ID() {
	global $wp_query;

	$post_id = null;
	if ( is_object( $wp_query ) && isset( $wp_query->queried_object ) && isset( $wp_query->queried_object->ID ) ) {
		$post_id = $wp_query->queried_object->ID;
	} else {
		$post_id = get_the_ID();
	}
	
	return $post_id;
}

/**
 * Check if Wolf WPBakery Page Builder Extension is activated
 *
 * @return bool
 */
function prequelle_is_wvc_activated() {
	if ( class_exists( 'Wolf_Visual_Composer' ) && defined( 'WPB_VC_VERSION' ) && defined( 'WVC_OK' ) && WVC_OK ) {
		return true;
	}
}

/**
 * Check if WooCommerce is activated
 *
 * @return bool
 */
function prequelle_is_wc_activated() {
	if ( class_exists( 'WooCommerce' ) ) {
		return true;
	}
}

/**
 * Get default post types to use with VC
 */
function prequelle_get_default_post_types() {
	return array(
		'post',
		'page',
		'work',
		'product',
		'release',
		'gallery',
		'event',
		'video',
		'wvc_content_block',
	);
}

/**
 * Get all available animations
 *
 * @return array
 */
function prequelle_get_animations() {

	return apply_filters( 'prequelle_item_animations', array(
		
		'none' => esc_html__( 'None', 'prequelle' ),
		
		'fade' => esc_html__( 'Fade', 'prequelle' ),
		'fade-up' => esc_html__( 'Fade Up', 'prequelle' ),
		'fade-down' => esc_html__( 'Fade Down', 'prequelle' ),
		'fade-left' => esc_html__( 'Fade Left', 'prequelle' ),
		'fade-right' => esc_html__( 'Fade Right', 'prequelle' ),
		'fade-up-right' => esc_html__( 'Fade Up Right', 'prequelle' ),
		'fade-up-left' => esc_html__( 'Fade Up Left', 'prequelle' ),
		'fade-down-right' => esc_html__( 'Fade Down Right', 'prequelle' ),
		'fade-down-left' => esc_html__( 'Fade Down Left', 'prequelle' ),

		'flip-up' => esc_html__( 'Flip Up', 'prequelle' ),
		'flip-down' => esc_html__( 'Flip Down', 'prequelle' ),
		'flip-left' => esc_html__( 'Flip Left', 'prequelle' ),
		'flip-right' => esc_html__( 'Flip Right', 'prequelle' ),

		'slide-up' => esc_html__( 'Slide Up', 'prequelle' ),
		'slide-down' => esc_html__( 'Slide Down', 'prequelle' ),
		'slide-left' => esc_html__( 'Slide Left', 'prequelle' ),
		'slide-right' => esc_html__( 'Slide Right', 'prequelle' ),

		'zoom-in' => esc_html__( 'Zoom In', 'prequelle' ),
		'zoom-in-up' => esc_html__( 'Zoom In Up', 'prequelle' ),
		'zoom-in-down' => esc_html__( 'Zoom In Down', 'prequelle' ),
		'zoom-in-left' => esc_html__( 'Zoom In Left', 'prequelle' ),
		'zoom-in-right' => esc_html__( 'Zoom In Right', 'prequelle' ),
		'zoom-out' => esc_html__( 'Zoom Out', 'prequelle' ),
		'zoom-out-up' => esc_html__( 'Zoom Out Up', 'prequelle' ),
		'zoom-out-down' => esc_html__( 'Zoom Out Down', 'prequelle' ),
		'zoom-out-left' => esc_html__( 'Zoom Out Left', 'prequelle' ),
		'zoom-out-right' => esc_html__( 'Zoom Out Right', 'prequelle' ),
	) );
}

/**
 * Minimium requirements variables
 *
 * @return array
 */
function prequelle_get_minimum_required_server_vars() {

	$variables = array(
		'REQUIRED_PHP_VERSION' => '5.6.0',
		'REQUIRED_WP_VERSION' => '4.5',
		'REQUIRED_WP_MEMORY_LIMIT' => '128M',
		'REQUIRED_MEMORY_LIMIT' => '128M',
		'REQUIRED_SERVER_MEMORY_LIMIT' => '128M',
		'REQUIRED_MAX_INPUT_VARS' => 3000,
		'REQUIRED_MAX_EXECUTION_TIME' => 300,
		'REQUIRED_UPLOAD_MAX_FILESIZE' => '128M',
		'REQUIRED_POST_MAX_SIZE' => '128M',
	);

	return $variables;
}

/**
 * Get theme root
 */
function prequelle_get_theme_dirname() {
	return basename( dirname( dirname( __FILE__ ) ) );
}

/**
 * Get theme name
 *
 * @return string
 */
function prequelle_get_theme_name() {
	$theme = wp_get_theme();
	return $theme->get( 'Name' );
}

/**
 * Get parent theme name
 *
 * @return string
 */
function prequelle_get_parent_theme_name() {
	$theme = wp_get_theme( prequelle_get_theme_dirname() );
	return $theme->get( 'Name' );
}

/**
 * Get theme version
 *
 * @return string
 */
function prequelle_get_theme_version() {
	$theme = wp_get_theme();
	return $theme->get( 'Version' );
}

/**
 * Get parent theme version
 *
 * @return string
 */
function prequelle_get_parent_theme_version() {
	$theme = wp_get_theme( prequelle_get_theme_dirname() );
	return $theme->get( 'Version' );
}

/**
 * Get the theme slug
 *
 * @return string
 */
function prequelle_get_theme_slug() {

	return apply_filters( 'prequelle_theme_slug', esc_attr( sanitize_title_with_dashes( get_template() ) ) );
}

/**
 * Get styling option
 *
 * First check if the option is set in post options (metabox) else return theme mod
 * Option key must have the same slug ( e.g '_post_my_option' for metabox and 'my_option' for theme mod )
 */
function prequelle_get_inherit_mod( $key, $default = '' ) {
	$option = prequelle_get_theme_mod( $key, $default );
	if ( get_post_meta( prequelle_get_inherit_post_id(), '_post_' . $key, true ) ) {
		$option = get_post_meta( prequelle_get_inherit_post_id(), '_post_' . $key, true );
	}

	return apply_filters( 'prequelle_' . $key, $option );
}

if ( ! function_exists( 'prequelle_get_theme_mod' ) ) {
	/**
	 * Get theme mod
	 *
	 * @param string $key
	 * @param string $default
	 * @return string
	 */
	function prequelle_get_theme_mod( $key, $default = '' ) {

		if ( isset( $_GET[ $key ] ) && preg_match( "#^[a-zA-Z0-9-_\/]+$#" , $_GET[ $key ] ) ) {

			return esc_attr( $_GET[ $key ] );
		} elseif ( $default && '' == get_theme_mod( $key, $default ) ) {

			return $default;

		} else {
			return apply_filters( 'prequelle_mod_' . $key, get_theme_mod( $key, $default ) );
		}
	}
}

/**
 * Get theme option
 *
 * @param string $key
 * @return mixed
 */
function prequelle_get_option( $index, $key, $default = null ) {

	$theme_slug = prequelle_get_theme_slug();
	$option_name = $theme_slug . '_' . $index . '_settings';
	$settings = get_option( $option_name );

	if ( isset( $settings[ $key ] ) ) {

		return  $settings[ $key ];

	} elseif ( $default ) {

		return $default;
	}
}

/**
 * Inject/update an option in the theme options array
 *
 * @param string $key
 * @param string $value
 */
function prequelle_update_option( $index, $key, $value ) {

	$theme_slug = prequelle_get_theme_slug();
	$option_name = $theme_slug . '_' . $index . '_settings';
	$theme_options = ( get_option( $option_name ) ) ? get_option( $option_name ) : array();
	$theme_options[ $key ] = $value;
	update_option( $option_name, $theme_options );
}

/**
 * Check if a file exists before including it
 *
 * Check if the file exists in the child theme with prequelle_locate_file or else check if the file exists in the parent theme
 *
 * @param string $file
 */
function prequelle_include( $file ) {
	if ( prequelle_locate_file( $file ) ) {
		return include( prequelle_locate_file( $file ) );
	}
}

/**
 * Locate a file and return the path for inclusion.
 *
 * Used to check if the file exists, is in a parent or child theme folder
 *
 * @param string $filename
 * @return string
 */
function prequelle_locate_file( $filename ) {

	$file = null;

	if ( is_file( get_stylesheet_directory() . '/' . untrailingslashit( $filename ) ) ) {

		$file = get_stylesheet_directory() . '/' . untrailingslashit( $filename );

	} elseif ( is_file( get_template_directory() . '/' . untrailingslashit( $filename ) ) ) {

		$file = get_template_directory() . '/' . untrailingslashit( $filename );
	}

	return apply_filters( 'prequelle_locate_file', $file );
}

/**
 * Check if a file exists in a child theme
 * else returns the URL of the parent theme file
 * Mainly uses for images
 *
 * @param string $file
 * @return string
 */
function prequelle_get_theme_uri( $file = null ) {

	$file = untrailingslashit( $file );

	if ( is_file( get_stylesheet_directory() . '/' . $file ) ) {

		return esc_url( get_stylesheet_directory_uri() . '/' . $file );

	} elseif ( is_file( get_template_directory() . '/' . $file ) ) {

		return esc_url( get_template_directory_uri() . '/' . $file );
	}
}

/**
 * Get the URL of an attachment from its id
 *
 * @param int $id
 * @return string $url
 */
function prequelle_get_url_from_attachment_id( $id, $size = 'thumbnail' ) {

	$src = wp_get_attachment_image_src( $id, $size );
	if ( isset( $src[0] ) ) {
		return esc_url( $src[0] );
	}
}

/**
 * Remove spaces in inline CSS
 *
 * @param string $css
 * @return string
 */
function prequelle_compact_css( $css, $hard = true ) {
	return preg_replace( '/\s+/', ' ', $css );
}

/**
 * Clean a list
 *
 * Remove first and last comma of a list and remove spaces before and after separator
 *
 * @param string $list
 * @return string $list
 */
function prequelle_clean_list( $list, $separator = ',' ) {
	$list = str_replace( array( $separator . ' ', ' ' . $separator ), $separator, $list );
	$list = ltrim( $list, $separator );
	$list = rtrim( $list, $separator );
	return $list;
}

/**
 * Helper method to determine if an attribute is true or false.
 *
 * @param string|int|bool $var Attribute value.
 * @return bool
 */
function prequelle_attr_bool( $var ) {
	$falsey = array( 'false', '0', 'no', 'n', '', ' ' );
	return ( ! $var || in_array( strtolower( $var ), $falsey, true ) ) ? false : true;
}

if ( ! function_exists( 'debug' ) ) {
	/**
	 *  Debug function for developpment
	 *  Display less infos than a var_dump
	 *
	 * @param string $var
	 * @return string
	 */
	function debug( $var ) {
		if ( WP_DEBUG ) {
			echo '<br><pre style="border: 1px solid #ccc; padding:5px; width:98%">';
			print_r( $var );
			echo '</pre>';
		}
	}
}

/**
 * Remove all double spaces
 *
 * This function is mainly used to clean up inline CSS
 *
 * @param string $css
 * @return string
 */
function prequelle_clean_spaces( $string, $hard = true ) {
	return preg_replace( '/\s+/', ' ', $string );
}

/**
 * Convert list of IDs to array
 *
 * @param string $list
 * @return array
 */
function prequelle_list_to_array( $list, $separator = ',' ) {
	return ( $list ) ? explode( ',', trim( prequelle_clean_spaces( prequelle_clean_list( $list ) ) ) ) : array();
}

/**
 * Convert array of ids to list
 *
 * @param string $list
 * @return array
 */
function prequelle_array_to_list( $array, $separator = ',' ) {
	$list = '';

	if ( is_array( $array ) ) {
		$list = rtrim( implode( $separator,  $array ), $separator );
	}

	return prequelle_clean_list( $list );
}

/**
 * Check if a file exists in a child theme
 * else returns the path of the parent theme file
 * Mainly uses for config files
 *
 * @param string $file
 * @return string
 */
function wolf_get_theme_dir( $file = null ) {

	$file = untrailingslashit( $file );

	if ( is_file( get_stylesheet_directory() . '/' . $file ) ) {

		return get_stylesheet_directory() . '/' . $file;

	} elseif ( is_file( get_template_directory() . '/' . $file ) ) {

		return get_template_directory() . '/' . $file;
	}
}

/**
 * Get post attributes
 *
 * @param int $post_id
 * @return array $post_attrs
 */
function prequelle_get_post_attr( $post_id ) {

	$post_attrs = array();

	$post_attrs['id'] = 'post-' . $post_id;
	$post_attrs['class'] = prequelle_array_to_list( get_post_class(), ' ' );
	$post_attrs['data-post-id'] = $post_id;
	$post_attrs['itemscope'] = '';
	$post_attrs['itemtype'] = 'http://schema.org/CreativeWork';

	if ( 'release' === get_post_type() ) {
		$post_attrs['itemtype'] = 'http://schema.org/MusicAlbum';
	}

	if ( 'event' === get_post_type() ) {
		$post_attrs['itemtype'] = 'http://schema.org/Event';
	}

	if ( 'product' === get_post_type() ) {
		$post_attrs['itemtype'] = 'http://schema.org/Product';
	}

	return apply_filters( 'prequelle_post_attrs', $post_attrs, $post_id );
}

/**
 * Output post attributes
 *
 * @param int $post_id
 */
function prequelle_post_attr( $class = '', $post_id = null ) {

	$post_id = ( $post_id ) ? $post_id : get_the_ID();
	$attrs = prequelle_get_post_attr( $post_id );
	$output = '';

	$classes = array();
	
	if ( $class ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
			$classes = array_map( 'esc_attr', $class );
		} else {
		$class = array();
	}

	foreach ( $attrs as $attr => $value ) {
		if ( $value ) {

			if ( array() !== $classes && 'class' === $attr ) {
				$classes = array_unique( $classes );
				
				foreach ( $classes as $class ) {
					$value .= ' ' . $class;
				}
			}

			echo esc_attr( $attr ) . '="' . esc_attr( $value ) . '" ';

		} else {
			echo esc_attr( $attr ) . ' ';
		}
	}
}

/**
 * Sanitize string with wp_kses
 *
 * @param string $output
 * @return sring $output
 */
function prequelle_kses( $output ) {

	return wp_kses( $output,
		array(
			'div' => array(
				'class' => array(),
				'id' => array(),
				'itemscope' => array(),
				'itemtype' => array(),
			),
			'p' => array(
				'class' => array(),
				'id' => array(),
			),
			'ul' => array(
				'class' => array(),
				'id' => array(),
				'style' => array(),
			),
			'ol' => array(
				'class' => array(),
				'id' => array(),
				'style' => array(),
			),
			'li' => array(
				'class' => array(),
				'id' => array(),
			),
			'span' => array(
				'class' => array(),
				'id' => array(),
				'data-post-id' => array(),
				'itemprop' => array(),
				'title' => array(),
			),
			'i' => array(
				'class' => array(),
				'id' => array(),
				'aria-hidden' => array(),
			),
			'time' => array(
				'class' => array(),
				'datetime' => array(),
				'itemprop' => array(),
			),
			'blockquote' => array(
				'class' => array(),
				'id' => array(),
			),
			'hr' => array(
				'class' => array(),
				'id' => array(),
			),
			'strong' => array(
				'class' => array(),
				'id' => array(),
			),
			'br' => array(),
			'img' => array(
				'src' => array(),
				'srcset' => array(),
				'class' => array(),
				'id' => array(),
				'width' => array(),
				'height' => array(),
				'sizes' => array(),
				'alt' => array(),
				'title' => array(),
				'data-src' => array(),
			),
			'a' => array(
				'class' => array(),
				'id' => array(),
				'href' => array(),
				'data-fancybox' => array(),
				'rel' => array(),
				'title' => array(),
				'target' => array(),
				'data-mega-menu-tagline' => array(),
				'itemprop' => array(),
			),
			'h1' => array(
				'class' => array(),
				'id' => array(),
				'itemprop' => array(),
				'style' => array(),
			),
			'h2' => array(
				'class' => array(),
				'id' => array(),
				'itemprop' => array(),
				'style' => array(),
			),
			'h3' => array(
				'class' => array(),
				'id' => array(),
				'itemprop' => array(),
				'style' => array(),
			),
			'h4' => array(
				'class' => array(),
				'id' => array(),
				'itemprop' => array(),
				'style' => array(),
			),
			'h5' => array(
				'class' => array(),
				'id' => array(),
				'itemprop' => array(),
				'style' => array(),
			),
			'h6' => array(
				'class' => array(),
				'id' => array(),
				'itemprop' => array(),
				'style' => array(),
			),
			'ins' => array(
				'class' => array(),
				'id' => array(),
				'itemprop' => array(),
				'style' => array(),
			),
			'del' => array(
				'class' => array(),
				'id' => array(),
				'itemprop' => array(),
				'style' => array(),
			),
		)
	);
}

/**
 * Check if the home page is set to posts
 *
 * @return bool
 */
function prequelle_is_home_as_blog() {
	return ( 'posts' === get_option( 'show_on_front' ) && is_home() );
}

/**
 * Check if we're on the blog index page
 *
 * @return bool
 */
function prequelle_is_blog_index() {

	return prequelle_is_home_as_blog() || ( prequelle_get_the_ID() == get_option( 'page_for_posts' ) );
}

/**
 * Check if we're on a blog page
 *
 * @return bool
 */
function prequelle_is_blog() {

	$is_blog = ( prequelle_is_home_as_blog() || prequelle_is_blog_index() || is_search() || is_archive() ) && ! prequelle_is_woocommerce_page() && 'post' == get_post_type();
	return ( true === $is_blog );
}

/**
 * Get the post ID to use to display a header
 *
 * For example, if a header is set for the blog, we will use it for the archive and search page
 *
 * @return int $id
 */
function prequelle_get_inherit_post_id() {

	if ( is_404() ) {
		return;
	}

	$post_id = null;
	$shop_page_id = ( function_exists( 'prequelle_get_woocommerce_shop_page_id' ) ) ? prequelle_get_woocommerce_shop_page_id() : false;
	
	$is_shop_page = function_exists( 'is_shop' ) ? is_shop() || is_cart() || is_checkout() || is_account_page() || is_product_category() || is_product_tag() || ( function_exists( 'wolf_wishlist_get_page_id' ) && is_page( wolf_wishlist_get_page_id() ) ) : false;
	
	$is_product_taxonomy = function_exists( 'is_product_taxonomy' ) ? is_product_taxonomy() : false;
	$is_single_product = function_exists( 'is_product' ) ? is_product() : false;
	if ( ( prequelle_is_blog() || is_search() ) && false === $is_shop_page && false === $is_product_taxonomy ) {

		$post_id = get_option( 'page_for_posts' );
	} elseif ( $is_shop_page ) {

		$post_id = $shop_page_id;
	} elseif ( ( is_tax( 'band' ) || is_tax( 'label' ) ) && function_exists( 'wolf_discography_get_page_id' ) ) {

		$post_id = wolf_discography_get_page_id();
	} elseif ( is_tax( 'video_type' ) || is_tax( 'video_tag' ) && function_exists( 'wolf_videos_get_page_id' ) ) {

		$post_id = wolf_videos_get_page_id();
	} elseif ( is_tax( 'we_artist' ) && function_exists( 'wolf_events_get_page_id' ) ) {

		$post_id = wolf_events_get_page_id();
	} elseif ( is_tax( 'work_type' ) && function_exists( 'wolf_portfolio_get_page_id' ) ) {

		$post_id = wolf_portfolio_get_page_id();
	} elseif ( is_tax( 'gallery_type' ) && function_exists( 'wolf_albums_get_page_id' ) ) {

		$post_id = wolf_albums_get_page_id();

	} else {
		$post_id = prequelle_get_the_ID();
	}

	return $post_id;
}

/**
 * Get attachment ID from title
 *
 * @param string $title the attachment title
 * @return int | null the attachment ID
 */
function prequelle_get_attachement_id_from_title( $title ) {
	
	global $wpdb;
	
	$_attachment = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE post_title = '$title' AND post_type = 'attachment' ", OBJECT ) );

	$attachment = $_attachment ? array_pop( $_attachment ) : null;

	return ( $attachment  && is_object( $attachment ) ) ? $attachment->ID : '';
}

/**
 * Add to cart tag
 *
 * @param int $product_id
 * @param string $text link text content
 * @param string $class button class
 * @return string
 */
function prequelle_add_to_cart( $product_id, $classes = '', $text = '' ) {
	$wc_url = untrailingslashit( prequelle_get_current_url() ) . '/?add-to-cart=' . absint( $product_id );

	$classes .= ' product_type_simple add_to_cart_button ajax_add_to_cart';

	return '<a
		href="' . esc_url( $wc_url ) . '"
		rel="nofollow"
		data-quantity="1" data-product_id="' . absint( $product_id ) . '"
		class="' . prequelle_sanitize_html_classes( $classes ) . '">' . $text . '</a>';
}

/**
 * gets the current post type in the WordPress Admin
 */
function prequelle_get_admin_current_post_type() {

	$post_type = null;

	if ( is_admin() ) {
		
		if ( isset( $_GET['post'] ) ) {
			$post_type = get_post_type( absint( $_GET['post'] ) );
		
		} else if ( isset( $_GET['post_type'] ) ) {
			$post_type = esc_attr( $_GET['post_type'] );
		}
	}

	return $post_type;
}


/**
 * Get lists of categories.
 *
 * @see js_composer/include/classes/vendors/class-vc-vendor-woocommerce.php
 *
 * @param $parent_id
 * @param array $array
 * @param $level
 * @param array $dropdown - passed by  reference
 */
function prequelle_get_category_childs_full( $parent_id, $array, $level, &$dropdown ) {
	$keys = array_keys( $array );
	$i = 0;
	while ( $i < count( $array ) ) {
		$key = $keys[ $i ];
		$item = $array[ $key ];
		$i ++;
		if ( $item->category_parent == $parent_id ) {
			$name = str_repeat( '- ', $level ) . $item->name;
			$value = $item->term_id;
			$dropdown[] = array(
				'label' => $name . ' (' . $item->term_id . ')',
				'value' => $value,
			);
			unset( $array[ $key ] );
			$array = prequelle_get_category_childs_full( $item->term_id, $array, $level + 1, $dropdown );
			$keys = array_keys( $array );
			$i = 0;
		}
	}

	return $array;
}

/**
 * Get product category dropdown options
 */
function prequelle_get_product_cat_dropdown_options() {
	
	$product_categories_dropdown = array();
	$product_cat_args = array(
		'type' => 'post',
		'child_of' => 0,
		'parent' => '',
		'orderby' => 'name',
		'order' => 'ASC',
		'hide_empty' => false,
		'hierarchical' => 1,
		'exclude' => '',
		'include' => '',
		'number' => '',
		'taxonomy' => 'product_cat',
		'pad_counts' => false,

	);

	$categories = get_categories( $product_cat_args );

	$product_categories_dropdown = array();
	prequelle_get_category_childs_full( 0, $categories, 0, $product_categories_dropdown );

	return $product_categories_dropdown;
}

/**
 * Get metro pattern options
 */
function prequelle_get_metro_patterns() {
	return array_flip( apply_filters( 'prequelle_metro_pattern_options', array(
		'auto' => esc_html__( 'Auto', 'prequelle' ),
		'pattern-1' => sprintf( esc_html__( 'Pattern %d (loop of %d)', 'prequelle' ), 1, 6 ),
		'pattern-2' => sprintf( esc_html__( 'Pattern %d (loop of %d)', 'prequelle' ), 2, 8 ),
		'pattern-3' => sprintf( esc_html__( 'Pattern %d (loop of %d)', 'prequelle' ), 3, 10 ),
		'pattern-4' => sprintf( esc_html__( 'Pattern %d (loop of %d)', 'prequelle' ), 4, 8 ),
		'pattern-5' => sprintf( esc_html__( 'Pattern %d (loop of %d)', 'prequelle' ), 5, 5 ),
		'pattern-6' => sprintf( esc_html__( 'Pattern %d (loop of %d)', 'prequelle' ), 6, 5 ),
	) ) );
}