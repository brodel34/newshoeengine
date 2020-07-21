<?php
/**
 * Wolf Custom Post Meta Frontend Functions
 *
 * @author WolfThemes
 * @category Core
 * @package WolfCustom Post Meta/Functions
 * @since 10.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get views
 */
function wolf_custom_post_meta_get_views( $post_id = null ) {

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$views = get_post_meta( $post_id, '_wolf_views_count', true );

	return wolf_custom_post_meta_format_number( $views );
}

/**
 * Get likes
 */
function wolf_custom_post_meta_get_likes( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$likes = get_post_meta( $post_id, '_wolf_likes_count', true );

	return wolf_custom_post_meta_format_number( $likes );
}

/**
 * Get estimated postread time
 */
function wolf_custom_post_meta_get_post_reading_time() {

	$words_per_minute = apply_filters( 'wolf_custom_post_meta_words_per_minute', 200 );
	$words_per_second = absint( $words_per_minute / 60 );

	$post_id = get_the_ID();

	// Clean post content
	$content = wcpm_clean_post_content( get_post_field( 'post_content', $post_id ) );

	$num_words = str_word_count( $content );

	$reading_time_in_seconds = $num_words / $words_per_second;
	$reading_time_in_minutes = ceil( $reading_time_in_seconds / 60 );

	return $reading_time_in_minutes;
}

/**
 * Clean post content
 *
 * @param $string
 * @return $string
 */
function wcpm_clean_post_content( $string ) {

	// Shortcode regex to get a maximum of shortcodes but keeping content
	$shortcode_regex = '/\[[a-zA-ZŽžšŠÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçČčÌÍÎÏìíîïÙÚÛÜùúûüÿÑñйА-яц一-龯= {}0-9#@|\%_\.:;,+\/\/\?!\'%&€^¨°¤£$§~()`*"-]+\]/';

	$string = wp_strip_all_tags( $string ); // remove HTML
	$string = preg_replace( $shortcode_regex, '', $string ); // remove shortcodes
	$string = preg_replace( '/(http:|https:)?\/\/[a-zA-Z0-9\/.?&=-]+/', '', $string ); // remove URL's

	return $string;
}

/**
 * Get all custom meta
 */
function wolf_custom_post_meta( $echo = true ) {

	$output = '<div class="wolf-custom-post-meta">';

	$output .= '<span class="wolf-like-this" data-post-id="' . esc_attr( get_the_ID() ) . '">' . wolf_custom_post_meta_get_views() . ' views </span>';

	$output .= wolf_custom_post_meta_get_likes() . ' likes ';

	$output .= wolf_custom_post_meta_get_post_reading_time() . ' min read';

	$output .= '</div>';

	if ( $echo ) {
		echo $output;
	}

	return $output;
}

/**
 * Output social sharing button
 */
function wolf_output_custom_post_meta( $content ) {

	$selected_post_types = wolf_custom_post_meta_get_option( 'post_types' );
	$post_type = get_post_type();
	$condition = ( is_single() && isset( $selected_post_types[ $post_type ] ) );

	$new_content = '';

	if ( $condition ) {
		$new_content .= wolf_custom_post_meta( false );
	}

	$new_content .= $content;

	if ( $condition ) {
		$new_content .= wolf_custom_post_meta( false );
	}

	return $new_content;

}
add_filter( 'the_content', 'wolf_output_custom_post_meta' );

/**
 * Format number : 1000 -> 1K
 *
 * @param int $n
 * @return string
 */
function wolf_custom_post_meta_format_number( $n = 0 ) {

	$s = array( 'K', 'M', 'G', 'T' );
	$out = '';
	while ( $n >= 1000 && count( $s ) > 0) {
		$n   = $n / 1000.0;
		$out = array_shift( $s );
	}
	return round( $n, max( 0, 3 - strlen( (int)$n ) ) ) ." $out";
}

/**
 * Enqeue styles and scripts
 */
function wolf_custom_post_meta_enqueue_scripts() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : WCPM_VERSION;

	// Styles
	wp_enqueue_style( 'wolf-custom-post-meta', WCPM_CSS . '/wcpm' . $suffix . '.css', array(), $version, 'all' );

	// Scripts
	wp_enqueue_script( 'js-cookie', WCPM_JS . '/lib/js.cookie.min.js', array(), '2.1.4', true );
	wp_enqueue_script( 'wolf-custom-post-meta', WCPM_JS . '/wcpm' . $suffix . '.js', array( 'jquery' ), $version, true );

	// Add JS global variables
	wp_localize_script(
		'wolf-custom-post-meta', 'WolfCustomPostMetaJSParams', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'themeSlug' => esc_attr( sanitize_title_with_dashes( get_template() ) ),
		)
	);
}
add_action( 'wp_enqueue_scripts',  'wolf_custom_post_meta_enqueue_scripts' );