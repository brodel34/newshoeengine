<?php
/**
 * Wolf Portfolio Hooks
 *
 * Action/filter hooks used for WolfPortfolio functions/templates
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
 * Body class
 *
 * @see  wfolio_body_class()
 */
add_filter( 'body_class', 'wfolio_body_class' );

/**
 * WP Header
 *
 * @see  wolf_portfolio_generator_tag()
 */
add_action( 'get_the_generator_html', 'wolf_portfolio_generator_tag', 10, 2 );
add_action( 'get_the_generator_xhtml', 'wolf_portfolio_generator_tag', 10, 2 );

/**
 * Content wrappers
 *
 * @see wolf_portfolio_output_content_wrapper()
 * @see wolf_portfolio_output_content_wrapper_end()
 */
add_action( 'wolf_portfolio_before_main_content', 'wolf_portfolio_output_content_wrapper', 10 );
add_action( 'wolf_portfolio_after_main_content', 'wolf_portfolio_output_content_wrapper_end', 10 );

add_action( 'template_redirect', 'wolf_portfolio_template_redirect', 40 );