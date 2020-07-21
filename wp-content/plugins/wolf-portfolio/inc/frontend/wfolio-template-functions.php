<?php
/**
 * Wolf Portfolio Template Functions
 *
 * Functions used in the template files to output content - in most cases hooked in via the template actions. All functions are pluggable.
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPortfolio/Templates
 * @since 1.1.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Output generator tag to aid debugging.
 */
function wolf_portfolio_generator_tag( $gen, $type ) {
	switch ( $type ) {
		case 'html':
			$gen .= "\n" . '<meta name="generator" content="WolfPortfolio ' . esc_attr( WFOLIO_VERSION ) . '">';
			break;
		case 'xhtml':
			$gen .= "\n" . '<meta name="generator" content="WolfPortfolio ' . esc_attr( WFOLIO_VERSION ) . '" />';
			break;
	}
	return $gen;
}

/**
 * Add specific class to the body when we're on the portfolio pages
 *
 * @since 1.1.6
 * @param array $classes
 * @return array $classes
 */
function wfolio_body_class( $classes ) {

	if (
		! is_singular( 'work' )
		&& ( 'work' == get_post_type() || ( function_exists( 'wolf_portfolio_get_page_id' ) && is_page( wolf_portfolio_get_page_id() ) ) )
		&& ! is_search()
	) {
		$classes[] = 'wolf-portfolio';
		$classes[] = 'wolf-portfolio-cols-' . wolf_portfolio_get_option( 'col', 3 );
	}

	return $classes;
}


if ( ! function_exists( 'wolf_portfolio_output_content_wrapper' ) ) {

	/**
	 * Output the start of the page wrapper.
	 *
	 */
	function wolf_portfolio_output_content_wrapper() {
		wolf_portfolio_get_template( 'global/wrapper-start.php' );
	}
}


if ( ! function_exists( 'wolf_portfolio_output_content_wrapper_end' ) ) {

	/**
	 * Output the end of the page wrapper.
	 *
	 */
	function wolf_portfolio_output_content_wrapper_end() {
		wolf_portfolio_get_template( 'global/wrapper-end.php' );
	}
}

if ( ! function_exists( 'wolf_portfolio_loop_start' ) ) {

	/**
	 * Output the start of a ticket loop. By default this is a UL
	 *
	 */
	function wolf_portfolio_loop_start( $echo = true ) {
		ob_start();
		wolf_portfolio_get_template( 'loop/loop-start.php' );
		if ( $echo )
			echo ob_get_clean();
		else
			return ob_get_clean();
	}
}


if ( ! function_exists( 'wolf_portfolio_loop_end' ) ) {

	/**
	 * Output the end of a ticket loop. By default this is a UL
	 *
	 */
	function wolf_portfolio_loop_end( $echo = true ) {
		ob_start();

		wolf_portfolio_get_template( 'loop/loop-end.php' );

		if ( $echo )
			echo ob_get_clean();
		else
			return ob_get_clean();
	}
}