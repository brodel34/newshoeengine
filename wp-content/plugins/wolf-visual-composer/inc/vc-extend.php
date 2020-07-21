<?php
/**
 * Wolf WPBakery Page Builder Extension VC presets functions
 *
 * Set default setttings values for in-built elements
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Filtering template path for each shortcode
 *
 * Using vc_set_shortcodes_templates_dir will prevent the theme from having a VC template directory.
 * We filter the template path for each shortcode so we can have our shortcode templates in the plugin AND in the theme
 *
 */
function wvc_hook_template_dir() {

	$template_dir = WVC_DIR . '/templates';
	$elements_slugs = wvc_get_element_list();

	if ( is_dir( $template_dir ) ) {

		foreach ( $elements_slugs as $slug ) {

			$slug = str_replace( '-', '_', basename( $slug ) );

			$vc_filename = wvc_locate_shortcode_template( 'templates/vc_' . sanitize_title_with_dashes( $slug ) . '.php' );

			$wvc_filename = wvc_locate_shortcode_template( 'templates/wvc_' . sanitize_title_with_dashes( $slug ) . '.php' );

			$default_filename = wvc_locate_shortcode_template( 'templates/' . sanitize_title_with_dashes( $slug ) . '.php' );

			if ( is_file( $vc_filename ) ) {

				vc_map_update( 'vc_' . $slug, array(
					'html_template' => $vc_filename,
				) );

			} elseif ( is_file( $wvc_filename ) ) {

				vc_map_update( 'wvc_' . $slug, array(
					'html_template' => $wvc_filename,
				) );

			} elseif ( is_file( $default_filename ) ) {

				vc_map_update( $slug, array(
					'html_template' => $default_filename,
				) );
			}
		}
	}
}
add_action( 'vc_after_init', 'wvc_hook_template_dir' );
function wvc_custom_css_classes_for_vc_row_and_vc_column( $class_string, $tag ) {

	if ( $tag === 'vc_row' || $tag === 'vc_row_inner' ) {
	}

	if ( $tag === 'vc_column' || $tag === 'vc_column_inner') {
		$class_string = preg_replace( '/vc_col-sm-(\d{1,2})/', 'wvc-col-$1', $class_string );
	}

	return $class_string;
}
add_filter( 'vc_shortcodes_css_class', 'wvc_custom_css_classes_for_vc_row_and_vc_column', 10, 2 );

/**
 * Disabled duplicated VC element
 */
function wvc_disable_elements() {

	$disabled_elements = apply_filters( 'wvc_disabled_elements', array(
		'vc_section',
		'vc_tour', // deprecated
		'vc_btn', // deprecated
		'vc_tta_accordion',
		'vc_tta_tabs',
		'vc_tta_pageable',
		'vc_round_chart',
		'vc_line_chart',
		'vc_text_separator',
		'vc_facebook',
		'vc_tweetmeme',
		'vc_googleplus',
		'vc_pinterest',
		'vc_images_carousel',
		'vc_tour',
		'vc_teaser_grid',
		'vc_posts_grid',
		'vc_carousel',
		'vc_posts_slider',
		'vc_button2',
		'vc_btn',
		'vc_cta_button',
		'vc_cta_button2',
		'vc_basic_grid',
		'vc_media_grid',
		'vc_masonry_grid',
		'vc_masonry_media_grid',
	) );

	foreach ( $disabled_elements as $element ) {
		vc_remove_element( $element );
	}
}
add_action( 'vc_after_init', 'wvc_disable_elements' );

/*
To re-add elements from theme:
http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key

function readd_el( $disabled_elements ) {

	if ( ( $key = array_search( 'vc_accordion', $disabled_elements ) ) !== false) {
		unset( $disabled_elements[ $key ] );
	}

	return $disabled_elements;
}
add_filter( 'wvc_disabled_elements', 'readd_el' );
*/