<?php
/**
 * Wolf WPBakery Page Builder Extension template functions
 *
 * Functions for the templating system.
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Functions
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Output generator tag to aid debugging.
 */
function wvc_generator_tag( $gen, $type ) {
	switch ( $type ) {
		case 'html':
			$gen .= "\n" . '<meta name="generator" content="WolfWPBakeryPageBuilderExtension ' . esc_attr( WVC_VERSION ) . '">';
			break;
		case 'xhtml':
			$gen .= "\n" . '<meta name="generator" content="WolfWPBakeryPageBuilderExtension ' . esc_attr( WVC_VERSION ) . '" />';
			break;
	}
	return $gen;
}

/**
 * Add body classes for WPB pages
 *
 * @param  array $classes
 * @return array
 */
function wvc_body_class( $classes ) {

	$classes = ( array ) $classes;

	if ( wvc_is_vc() ) {
		$classes[] = 'wolf-visual-composer';
		$classes[] = 'wvc-' . str_replace( '.', '-', WVC_VERSION );
		$classes[] = sanitize_title_with_dashes( get_template() ); // theme slug

		if ( get_post_meta( get_the_ID(), '_post_scroller', true ) ) {
			$classes[] = 'wvc-one-pager';
		}

		if ( wvc_is_edge() ) {
			$classes[] = 'wvc-is-edge';
		} else {
			$classes[] = 'wvc-not-edge';
		}

		if ( wvc_is_firefox() ) {
			$classes[] = 'wvc-is-firefox';
		} else {
			$classes[] = 'wvc-not-firefox';
		}

		if ( wvc_do_fullpage() ) {
			$classes[] = 'wvc-fullpage';
			$classes[] = 'wvc-fullpage-slide';
		}
	}

	return $classes;
}

/**
 * Get template part
 *
 * @param mixed $slug
 * @param string $name (default: '')
 * @return void
 */
function wvc_get_template_part( $slug, $name = '' ) {

	$template = '';
	if ( $name ) {
		$template = locate_template( array( "{$slug}-{$name}.php", WVC()->template_path() . "{$slug}-{$name}.php" ) );
	}
	if ( ! $template && $name && file_exists( WVC()->plugin_path() . "/views/{$slug}-{$name}.php" ) ) {
		$template = WVC()->plugin_path() . "/views/{$slug}-{$name}.php";
	}
	if ( ! $template ) {
		$template = locate_template( array( "{$slug}.php", WVC()->template_path() . "{$slug}.php" ) );
	}
	if ( $template ) {
		$template = apply_filters( 'wvc_get_template_part', $template, $slug, $name );
	}

	if ( $template ) {
		load_template( $template, false );
	}
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *	yourtheme/	$template_path	/	$template_name
 *	yourtheme/	$template_name
 *	$default_path/	$template_name
 *
 * @param string $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function wvc_locate_template( $template_name, $template_path = '', $default_path = '' ) {


	if ( ! $template_path ) {
		$template_path = WVC()->template_path();
	}

	if ( ! $default_path ) {
		$default_path = WVC()->plugin_path() . '/views/';
	}
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}
	return apply_filters( 'wvc_locate_template', $template, $template_name, $template_path );
}

/**
 * Get other templates passing attributes and including the file.
 *
 * @param string $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return void
 */
function wvc_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	if ( $args && is_array( $args ) ) {
		extract( $args );
	}

	$located = wvc_locate_template( $template_name, $template_path, $default_path );

	if ( ! file_exists( $located ) ) {
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '3.1.1' );
		return;
	}
	$located = apply_filters( 'wvc_get_template', $located, $template_name, $args, $template_path, $default_path );

	do_action( 'wvc_before_template_part', $template_name, $template_path, $located, $args );

	include( $located );

	do_action( 'wvc_after_template_part', $template_name, $template_path, $located, $args );
}