<?php
/**
 * Wolf Portfolio core functions
 *
 * General core functions available on admin and frontend
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPortfolio/Core
 * @version 1.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add image sizes
 *
 * These size will be ued for works
 */
function wfolio_add_image_sizes() {

	// add portfolio image sizes
	add_image_size( 'portfolio-thumb', 600, 450, true );
	add_image_size( 'portfolio-video-thumb', 480, 360, true );
	add_image_size( 'portfolio-image', 1200, 5000, false );
}
add_action( 'init', 'wfolio_add_image_sizes' );

/**
 * wolf_portfolio page ID
 *
 * retrieve page id - used for the main portfolio page
 *
 *
 * @return int
 */
function wolf_portfolio_get_page_id() {

	$page_id = -1;

	if ( -1 != get_option( '_wolf_portfolio_page_id' ) && get_option( '_wolf_portfolio_page_id' ) ) {

		$page_id = get_option( '_wolf_portfolio_page_id' );
	}

	if ( -1 != $page_id ) {
		$page_id = apply_filters( 'wpml_object_id', absint( $page_id ), 'page', true ); // filter for WPML
	}

	return $page_id;
}

if ( ! function_exists( 'wolf_get_portfolio_url' ) ) {
	/**
	 * Returns the URL of the portfolio page
	 */
	function wolf_get_portfolio_url() {

		$page_id = wolf_portfolio_get_page_id();

		if ( -1 != $page_id ) {
			return get_permalink( $page_id );
		}
	}
}

/**
 * Get template part (for templates like the work-loop).
 *
 * @param mixed $slug
 * @param string $name (default: '')
 * @return void
 */
function wolf_portfolio_get_template_part( $slug, $name = '' ) {
	
	$template = '';

	$wolf_portfolio = WFOLIO();

	// Look in yourtheme/slug-name.php and yourtheme/wolf-portfolio/slug-name.php
	if ( $name )
		$template = locate_template( array( "{$slug}-{$name}.php", "{$wolf_portfolio->template_url}{$slug}-{$name}.php" ) );

	// Get default slug-name.php
	if ( ! $template && $name && file_exists( $wolf_portfolio->plugin_path() . "/templates/{$slug}-{$name}.php" ) )
		$template = $wolf_portfolio->plugin_path() . "/templates/{$slug}-{$name}.php";

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/wolf-portfolio/slug.php
	if ( ! $template )
		$template = locate_template( array( "{$slug}.php", "{$wolf_portfolio->template_url}{$slug}.php" ) );

	if ( $template )
		load_template( $template, false );
}

/**
 * Get other templates (e.g. ticket attributes) passing attributes and including the file.
 *
 * @param mixed $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return void
 */
function wolf_portfolio_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {

	if ( $args && is_array($args) )
		extract( $args );

	$located = wolf_portfolio_locate_template( $template_name, $template_path, $default_path );

	do_action( 'wolf_portfolio_before_template_part', $template_name, $template_path, $located, $args );

	include( $located );

	do_action( 'wolf_portfolio_after_template_part', $template_name, $template_path, $located, $args );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 * yourtheme/$template_path/$template_name
 * yourtheme/$template_name
 * $default_path/$template_name
 *
 * @param mixed $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function wolf_portfolio_locate_template( $template_name, $template_path = '', $default_path = '' ) {

	if ( ! $template_path ) $template_path = WFOLIO()->template_url;
	if ( ! $default_path ) $default_path = WFOLIO()->plugin_path() . '/templates/';

	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template )
		$template = $default_path . $template_name;

	// Return what we found
	return apply_filters( 'wolf_portfolio_locate_template', $template, $template_name, $template_path );
}

/**
 * Get options
 *
 * @param string $value
 * @param string $default
 * @return string
 */
function wolf_portfolio_get_option( $value, $default = null ) {

	$wolf_portfolio_settings = get_option( 'wolf_portfolio_settings' );
	
	if ( isset( $wolf_portfolio_settings[ $value ] ) && '' != $wolf_portfolio_settings[ $value ] ) {
		
		return $wolf_portfolio_settings[ $value ];
	
	} elseif ( $default ) {

		return $default;
	}
}

/**
 * Overwrite post type slug
 *
 * @param array $args
 * @return array $args
 */
function wfolio_overwrite_post_type( $args, $post_type ) {
	
	if ( wolf_portfolio_get_option( 'slug' ) && 'work' === $post_type ) {
		$args['rewrite']['slug'] = sanitize_title_with_dashes( wolf_portfolio_get_option( 'slug' ) );
	}

	if ( wolf_portfolio_get_option( 'name' ) && 'work' === $post_type ) {
		$args['labels']['singular_name'] = esc_attr( wolf_portfolio_get_option( 'name' ) );
	}

	return $args;
}
add_filter( 'register_post_type_args', 'wfolio_overwrite_post_type', 20, 2 );