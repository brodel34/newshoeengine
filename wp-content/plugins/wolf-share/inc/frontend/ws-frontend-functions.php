<?php
/**
 * Wolf Share Frontend Functions
 *
 * @author WolfThemes
 * @category Core
 * @package WolfShare/Functions
 * @since 10.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output social sharing button
 */
function wolf_share_output_social_buttons( $content ) {

	$selected_post_types = wolf_share_get_option( 'post_types' );
	$post_type = get_post_type();
	$condition = ( is_single() && isset( $selected_post_types[ $post_type ] ) );

	$new_content = '';

	if ( $condition ) {
		$new_content .= wolf_share();
	}

	$new_content .= $content;

	if ( $condition ) {
		$new_content .= wolf_share();
	}

	return $new_content;

}
add_filter( 'the_content', 'wolf_share_output_social_buttons' );

/**
 * Output share buttons from templates
 */
function wolf_share( $echo = true ) {
	ob_start();

	do_action( 'wolf_share_before_buttons' );

	include( WS_DIR . '/templates/share-buttons.php' );

	do_action( 'wolf_share_after_buttons' );

	$output = ob_get_clean();

	if ( $echo ) {
		echo $output;
	}

	return $output;
}

/**
 * Get share count
 */
function wolf_share_count( $echo = true ) {

	if ( $echo ) {
		echo wolf_share_format_number( get_post_meta( get_the_ID(), '_wolf_shares_count', true ) );
	}

	return wolf_share_format_number( get_post_meta( get_the_ID(), '_wolf_shares_count', true ) );
}



/**
 * Format number : 1000 -> 1K
 *
 * @param int $n
 * @return string
 */
function wolf_share_format_number( $n = 0 ) {

	$s = array( 'K', 'M', 'G', 'T' );
	$out = '';
	while ( $n >= 1000 && count( $s ) > 0) {
		$n   = $n / 1000.0;
		$out = array_shift( $s );
	}
	return round( $n, max( 0, 3 - strlen( (int)$n ) ) ) ." $out";
}

/**
 * Add custom body classes
 */
function wolf_share_add_body_class( $classes ) {

	// theme slug body class for default WP themes styling
	$classes[] = sanitize_title_with_dashes( get_template() );

	return $classes;
}
add_filter( 'body_class', 'wolf_share_add_body_class' );

/**
 * Enqeue styles and scripts
 */
function wolf_share_enqueue_scripts() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : WS_VERSION;

	// Styles
	wp_enqueue_style( 'wolf-share', WS_CSS . '/share' . $suffix . '.css', array(), $version, 'all' );

	// Scripts
	wp_enqueue_script( 'wolf-share', WS_JS . '/share' . $suffix . '.js', array( 'jquery' ), $version, true );

	// Add JS global variables
	wp_localize_script(
		'wolf-share', 'WolfShareJSParams', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		)
	);
}
add_action( 'wp_enqueue_scripts',  'wolf_share_enqueue_scripts' );