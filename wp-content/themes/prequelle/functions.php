<?php
/**
 * Prequelle functions and definitions
 *
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Sets up theme defaults and registers support for various WordPress features using the PREQUELLE function
 *
 * @see inc/framework.php
 */
function prequelle_setup_config() {

	/**
	 *  Require the wolf themes framework core file
	 */
	require_once get_template_directory() . '/inc/framework.php';

	/**
	 * Set theme main settings
	 *
	 * We this array to configure the main theme settings
	 */
	$prequelle_settings = array(

		/* Menus */
		'menus' => array(
			'primary' => esc_html__( 'Primary Menu', 'prequelle' ),
			'secondary' => esc_html__( 'Secondary Menu', 'prequelle' ),
			'mobile' => esc_html__( 'Mobile Menu (optional)', 'prequelle' ),
		),

		/**
		 *  We define wordpress thumbnail sizes that we will use in our design
		 */
		'image_sizes' => array(

			/**
			 * Create custom image sizes if the Wolf WPBakery Page Builder extension plugin is not installed
			 * We will use the same image size names to avoid duplicated image sizes in the case the plugin is active
			 */
			'prequelle-slide' => apply_filters( 'prequelle_slide_thumbnail_size', array( 750, 300, true ) ),
			'prequelle-photo' => apply_filters( 'prequelle_photo_thumbnail_size', array( 500, 500, false ) ),
			'prequelle-masonry' => apply_filters( 'prequelle_masonry_thumbnail_size', array( 500, 2000, false ) ),
			'prequelle-masonry-small' => apply_filters( 'prequelle_masonry_small_thumbnail_size', array( 400, 400, false ) ),
			'prequelle-XL' => apply_filters( 'prequelle_xl_thumbnail_size', array( 2000, 3000, false ) ), // XL
		),
	);

	PREQUELLE( $prequelle_settings ); // let's go
}
prequelle_setup_config();
