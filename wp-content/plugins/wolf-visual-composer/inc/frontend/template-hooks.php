<?php
/**
 * Wolf WPBakery Page Builder Extension Template Hooks
 *
 * Action/filter hooks used for Wolf WPBakery Page Builder Extension functions/templates
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Body class
 *
 * @see  wvc_body_class()
 */
add_filter( 'body_class', 'wvc_body_class' );

/**
 * WP Header
 *
 * @see  wvc_generator_tag()
 */
add_action( 'get_the_generator_html', 'wvc_generator_tag', 10, 2 );
add_action( 'get_the_generator_xhtml', 'wvc_generator_tag', 10, 2 );