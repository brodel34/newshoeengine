<?php
/**
 * Prequelle frontend utility functions
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get current page URL
 */
function prequelle_get_current_url() {
	global $wp;
	return esc_url( home_url( add_query_arg( array(),$wp->request ) ) );
}

/**
 * Returns the latest post ID (handles sticky post for blog)
 * Allows to display the first image in the metro style grid bigger disregarding the post type
 *
 * @param string $post_type
 */
function prequelle_get_last_post_id( $post_type = 'post' ) {

	$post_id = null;

	if ( $post_type === 'post' ) {
		$args = array(
			'posts_per_page' => 1,
			'post_type' => 'post',
			'post__in'  => get_option( 'sticky_posts' ),
			'ignore_sticky_posts' => 1
		);

	} elseif ( $post_type === 'work' ) {

		$args = array(
			'numberposts' => 1,
			'post_type' => 'work'
		);

	} elseif ( $post_type === 'gallery' ) {

		$args = array(
			'numberposts' => 1,
			'post_type' => 'gallery'
		);
	}

	$recent_post = wp_get_recent_posts( $args, OBJECT );

	if ( $recent_post && isset( $recent_post[0] ) ) {
		$post_id = $recent_post[0]->ID;
	}

	if ( 'post' === $post_type ) {
		wp_reset_postdata();
	}

	return $post_id;
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function prequelle_content_width() {

	$content_width = 1140;

	$GLOBALS['content_width'] = apply_filters( 'prequelle_content_width', $content_width );
}
add_action( 'after_setup_theme', 'prequelle_content_width', 0 );

/**
 * WooCommerce AJAX search result
 */
function prequelle_ajax_search_query( $typed = null ) {

	$args = array(
		'post_type' => apply_filters( 'wollftheme_live_search_post_types', array( 'post' ) ),
		'post_status' => 'publish',
		'posts_per_page' => 5,
		's' => $typed,
	);

	return new WP_Query( $args );
}

/**
 * Get dominant color image
 *
 * @param int $attachment_id
 */
function prequelle_get_image_dominant_color( $attachment_id ) {

	if ( ! $attachment_id ) {
		return;
	}

	$metadata = wp_get_attachment_metadata( $attachment_id );

	if ( ! isset( $metadata['file'] ) ) {
		return 'transparent';
	}

	$upload_dir = wp_upload_dir();
	$filename = $upload_dir['basedir'] . '/' . $metadata['file'];
	$ext = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );

	if ( 'jpg' == $ext || 'jpeg' == $ext ) {

		$image = imagecreatefromjpeg( $filename);

	} elseif ( 'png' == $ext ) {

		$image = imagecreatefrompng( $filename);

	} elseif ( 'gif' == $ext ) {

		$image = imagecreatefromgif( $filename);
	} else {

		return 'transparent';
	}

	$thumb = imagecreatetruecolor( 1,1 );
	imagecopyresampled( $thumb, $image, 0, 0, 0, 0, 1, 1, imagesx( $image ), imagesy( $image ) );
	$main_color = strtoupper( dechex( imagecolorat( $thumb, 0, 0 ) ) );

	return '#' . $main_color;
}

/**
 * Sanitize html style attribute
 *
 * @param string $style
 * @return string
 */
function prequelle_sanitize_style_attr( $style ) {
	return esc_attr( trim( prequelle_compact_css( $style ) ) );
}

/**
 * Create a formatted sample of any text
 *
 * Remove HTML and shortcode, sanitize and shorten a string
 *
 * @param string $text
 * @param int $num_words
 * @param string $more
 * @return string
 */
function prequelle_sample( $text, $num_words = 55, $more = '...' ) {
	$text = wp_strip_all_tags( wp_trim_words( prequelle_clean_post_content( $text ), $num_words, $more ) );
	$text = preg_replace( '/(http:|https:)?\/\/[a-zA-Z0-9\/.?&=-]+/', '', $text );
	return $text;
}

/**
 * Check the type of video from URL
 *
 * Chek if a YouTube, mp4 or Vimeo URL
 */
function prequelle_get_video_url_type( $url ) {

	if ( preg_match( '#youtu#', $url, $match ) ) {

		return 'youtube';

	} elseif ( preg_match( '#vimeo#', $url, $match ) ) {

		return 'vimeo';

	} elseif ( preg_match( '#.mp4#', $url, $match ) ) {

		return 'selfhosted';
	}
}

/**
 * Sanitize color input
 *
 * @link https://github.com/redelivre/wp-divi/blob/master/includes/functions/sanitization.php
 *
 * @param string $color
 * @return string $color
 */
function prequelle_sanitize_color( $color ) {
	$color = str_replace( ' ', '', $color );
	if ( 1 === preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}
	elseif ( 'rgb(' === substr( $color, 0, 4 ) ) {
		sscanf( $color, 'rgb(%d,%d,%d)', $red, $green, $blue );
		if ( ( $red >= 0 && $red <= 255 ) &&
			 ( $green >= 0 && $green <= 255 ) &&
			 ( $blue >= 0 && $blue <= 255 )
			) {
			return "rgb({$red},{$green},{$blue})";
		}
	}
	elseif ( 'rgba(' === substr( $color, 0, 5 ) ) {
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
		if ( ( $red >= 0 && $red <= 255 ) &&
			 ( $green >= 0 && $green <= 255 ) &&
			 ( $blue >= 0 && $blue <= 255 ) &&
			   $alpha >= 0 && $alpha <= 1
			) {
			return "rgba({$red},{$green},{$blue},{$alpha})";
		}
	}
}

/**
 * sanitize_html_class works just fine for a single class
 * Some times le wild <span class="blue hedgehog"> appears, which is when you need this function,
 * to validate both blue and hedgehog,
 * Because sanitize_html_class doesn't allow spaces.
 *
 * @uses sanitize_html_class
 * @param (mixed: string/array) $class   "blue hedgehog goes shopping" or array("blue", "hedgehog", "goes", "shopping")
 * @param (mixed) $fallback Anything you want returned in case of a failure
 * @return (mixed: string / $fallback )
 */
function prequelle_sanitize_html_classes( $class, $fallback = null ) {
	if ( is_string( $class ) ) {
		$class = explode( ' ', $class);
	}

	if ( is_array( $class ) && count( $class ) > 0 ) {
		$class = array_unique( array_map( 'sanitize_html_class', $class ) );
		return trim( implode( ' ', $class ) );
	}
	else {
		return trim( sanitize_html_class( $class, $fallback ) );
	}
}

/**
 * Sanitize html style attribute
 *
 * @param string $style
 * @return string
 */
function prequelle_esc_style_attr( $style ) {

	return esc_attr( trim( prequelle_clean_spaces( $style ) ) );
}

/**
 * Clean post content to get post sample from WPBakery Page Builder Extension content
 *
 * Remove all HTML, shortcode tags and URLs and retrieve any text content from text blocks
 * This function is useful to create an excerpt from a complex post content
 *
 * @param $string
 * @return $string
 */
function prequelle_clean_post_content( $string ) {
$shortcode_regex = '/\[[a-zA-ZŽžšŠÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçČčÌÍÎÏìíîïÙÚÛÜùúûüÿÑñйА-яц一-龯= {}0-9#@|\%_\.:;,+\/\/\?!\'%&€^¨°¤£$§~()`*"-]+\]/';

	$string = wp_strip_all_tags( $string ); // remove HTML
	$string = preg_replace( $shortcode_regex, '', $string ); // remove shortcodes
	$string = preg_replace( '/(http:|https:)?\/\/[a-zA-Z0-9\/.?&=-]+/', '', $string ); // remove URL's

	return $string;
}

/**
 * Get specific shortcode pattern
 */
function prequelle_shortcode_preg_match( $shortcode, $content = '' ) {
	$content = ( $content ) ? $content : get_the_content();

	$pattern = '/\[' . $shortcode . '[a-zA-Z0-9_ -=]+\]/';

	if ( preg_match( $pattern, $content, $match ) ) {
		return $match;
	}
}

/**
 * Wrap audio shortcode
 *
 * @param string $html
 * @return string $html
 */
function prequelle_filter_audio_shortcode_output( $html ) {

	return '<div class="audio-shortcode-container">' . $html . '</div>';
}
add_filter( 'wp_audio_shortcode', 'prequelle_filter_audio_shortcode_output' );

/**
 * Wrap oembed object
 *
 * @param string $html
 * @return string $html
 */
function prequelle_filter_oembed_output( $html, $url, $attr, $post_id ) {

	$oembed_type = 'default';
	$wrap = false;

	if ( preg_match( '/spotify/', $url, $match ) ) {

		$oembed_type = 'spotify';
		$wrap = true;

	} elseif ( preg_match( '/soundcloud/', $url, $match ) ) {

		$oembed_type = 'soundcloud';
		$wrap = true;

	}

	if ( $wrap ) {
		$html = '<p class="oembed-container oembed-type-' . $oembed_type . '">' . $html . '</p>';
	}

	return $html;
}
add_filter( 'embed_oembed_html', 'prequelle_filter_oembed_output', 10, 4 );

/**
 * Wrap video shortcode
 *
 * @param string $html
 * @return string $html
 */
function prequelle_filter_video_shortcode_output( $html ) {

	return '<div class="video-shortcode-container">' . $html . '</div>';
}
add_filter( 'wp_video_shortcode', 'prequelle_filter_video_shortcode_output' );

if ( ! function_exists( 'prequelle_format_number' ) ) {
	/**
	 * Format number : 1000 -> 1K
	 *
	 * @since Prequelle 1.0.0
	 * @param int $n
	 * @return string
	 */
	function prequelle_format_number( $n ) {

		$s   = array( 'K', 'M', 'G', 'T' );
		$out = '';
		while ( $n >= 1000 && count( $s ) > 0) {
			$n   = $n / 1000.0;
			$out = array_shift( $s );
		}
		return round( $n, max( 0, 3 - strlen( (int)$n ) ) ) ." $out";
	}
}

/**
 * Get color brightness to adjust font color
 *
 * Used to determine if a background is light enough to use a dark font
 *
 * @param string $hex
 * @return string light|dark
 */
function prequelle_get_color_brightness( $hex ) {

	$hex = str_replace( '#', '', sanitize_hex_color( $hex ) ); // remove #

	$c_r = hexdec( substr( $hex, 0, 2 ) );
	$c_g = hexdec( substr( $hex, 2, 2 ) );
	$c_b = hexdec( substr( $hex, 4, 2 ) );
	$brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

	return $brightness;
}

/**
 * Get color brightness to adjust font color
 *
 * Used to determine if a background is light enough to use a dark font
 *
 * @param string $hex
 * @return string light|dark
 */
function prequelle_get_color_tone( $hex, $index = 215 ) {

	$hex = str_replace( '#', '', sanitize_hex_color( $hex ) ); // remove #

	$c_r = hexdec( substr( $hex, 0, 2 ) );
	$c_g = hexdec( substr( $hex, 2, 2 ) );
	$c_b = hexdec( substr( $hex, 4, 2 ) );
	$brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

	if ( $index < $brightness ) {
		return 'light';
	} else {
		return 'dark';
	}
}

/**
 * Check if color is close to black
 *
 * @param string $hex
 * @return bool
 */
function prequelle_color_is_black( $hex ) {

	$hex = str_replace( '#', '', sanitize_hex_color( $hex ) ); // remove #

	$c_r = hexdec( substr( $hex, 0, 2 ) );
	$c_g = hexdec( substr( $hex, 2, 2 ) );
	$c_b = hexdec( substr( $hex, 4, 2 ) );
	$brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

	if ( 30 > $brightness ) {
		return true;
	}
}

/**
 * Check if color is close to white
 *
 * @param string $hex
 * @return bool
 */
function prequelle_color_is_white( $hex ) {

	$hex = str_replace( '#', '', sanitize_hex_color( $hex ) ); // remove #

	$c_r = hexdec( substr( $hex, 0, 2 ) );
	$c_g = hexdec( substr( $hex, 2, 2 ) );
	$c_b = hexdec( substr( $hex, 4, 2 ) );
	$brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

	if ( 220 < $brightness ) {
		return true;
	}
}

/**
 * Brightness color function simiar to sass lighten and darken
 *
 * @param string $hex
 * @param int $percent
 * @return string
 */
function prequelle_color_brightness( $hex, $percent ) {

	$steps = ( ceil( ( $percent * 200 ) / 100 ) ) * 2;
	$steps = max( -255, min( 255, $steps ) );
	$hex = str_replace( '#', '', prequelle_sanitize_color( $hex ) );
	if ( strlen( $hex ) === 3 ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ).str_repeat( substr( $hex, 1, 1 ), 2 ).str_repeat( substr( $hex, 2, 1 ), 2 );
	}
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );
	$r = max( 0, min( 255, $r + $steps ) );
	$g = max( 0, min( 255, $g + $steps ) );
	$b = max( 0, min( 255, $b + $steps ) );

	$r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
	$g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
	$b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

	return '#' . $r_hex . $g_hex . $b_hex;
}

/**
 * Sanitize css value
 *
 * Be sure that the unit of a value ic correct (e.g: 100px)
 *
 * @param string $value
 * @param string $default_unit
 * @param string $default_value
 * @return string $value
 */
function prequelle_sanitize_css_value( $value, $default_unit = 'px', $default_value = '1' ) {

	$pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
	$regexr = preg_match( $pattern, $value, $matches );
	$value = isset( $matches[1] ) ? absint( $matches[1] ) : $default_value;
	$unit = isset( $matches[2] ) ? esc_attr( $matches[2] ) : $default_unit;
	$value = $value . $unit;

	return $value;
}