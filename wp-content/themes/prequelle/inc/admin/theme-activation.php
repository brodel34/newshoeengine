<?php
/**
 * Prequelle admin activation
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Set default mods from config file
 */
function prequelle_set_default_mods() {

	if ( ! is_user_logged_in() || ! current_user_can( 'switch_themes' ) ) {
		return;
	}

	$mod_filename = 'customizer.dat';

	if ( is_file( get_parent_theme_file_path( 'config/' . prequelle_get_theme_slug() . '.dat' ) ) ) {
		$mod_filename = prequelle_get_theme_slug() . '.dat';
	}

	$file_content = prequelle_file_get_contents( 'config/' . $mod_filename );
	$theme_slug = ( is_child_theme() ) ? prequelle_get_theme_slug() . '_child' : prequelle_get_theme_slug();
	$theme_parent_slug = prequelle_get_theme_slug();

	/* Stop if no file content */
	if ( ! $file_content ) {
		return;
	}

	/* Stop if mods have already been set */
	if ( get_option( $theme_slug . '_customizer_init' ) ) {
		return;
	}

	/* If all good proceed */
	if ( false !== ( $data = @unserialize( $file_content ) ) ) {

		$mods = $data['mods'];

		unset( $mods['nav_menu_locations'] );
		unset( $mods['logo_dark'] );
		unset( $mods['logo_light'] );
		unset( $mods['logo_svg'] );
		unset( $mods['custom_css'] );
		unset( $mods['wp_css'] );

		$mods = apply_filters( 'prequelle_default_mods', $mods ); // filter default mods if needed

		foreach ( $mods as $key => $value ) {

			/* remove external URL to avoid hot linking */
			if ( prequelle_is_external_url( $value ) ) {
				$mods[ $key ] = '';
			}

			set_theme_mod( $key, $value );
		}

		/* Add option to flag that the default mods have been set */
		add_option( $theme_slug . '_customizer_init', true );
	}

}
add_action( 'after_setup_theme', 'prequelle_set_default_mods' );

/**
 * Hook WWPBPBE plugin activation to save theme fonts in plugins settings
 *
 * Import the default fonts from the theme in the page builder settings
 */
function prequelle_set_wvc_default_google_fonts( $settings ) {

	/* Get theme fonts */
	$theme_google_font_option = prequelle_get_option( 'fonts', 'google_fonts' );

	if ( class_exists( 'Wolf_Visual_Composer' ) && $theme_google_font_option ) {

		$settings['fonts']['google_fonts'] = $theme_google_font_option;
	}

	return $settings;
}
add_filter( 'wvc_default_settings', 'prequelle_set_wvc_default_google_fonts' );

/**
 * Get all social networks URL from plugin if plugin is installed before the theme
 *
 * @param array $mods
 * @return array $mods
 */
function prequelle_set_default_social_networks( $mods ) {

	if ( function_exists( 'wvc_get_socials' ) ) {
		$wvc_socials = wvc_get_socials();

		foreach ( $wvc_socials as $service ) {
			$link = wolf_vc_get_option( 'socials', $service );

			if ( $link ) {
				set_theme_mod( $service, $link );
			}
		}
	}

	return $mods;
}
add_filter( 'prequelle_default_mods', 'prequelle_set_default_social_networks' );

/**
 * Define WooCommerce image sizes on theme activation
 *
 * Can be overwritten with the prequelle_woocommerce_thumbnail_sizes filter
 */
function prequelle_woocommerce_image_sizes() {

	global $pagenow;

	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
		return;
	}

	$woocommerce_thumbnails = apply_filters( 'prequelle_woocommerce_thumbnail_sizes', array(
			'catalog' => array(
				'width' 	=> '400',	// px
				'height'	=> '400',	// px
				'crop'	=> 1 		// true
			),

			'single' => array(
				'width' 	=> '600',	// px
				'height'	=> '600',	// px
				'crop'	=> 1 		// true
			),

			'thumbnail' => array(
				'width' 	=> '120',	// px
				'height'	=> '120',	// px
				'crop'	=> 0 		// false
			),
		)
	);

	/* Image sizes */
	update_option( 'shop_catalog_image_size', $woocommerce_thumbnails['catalog'] ); // Product category thumbs
	update_option( 'shop_single_image_size', $woocommerce_thumbnails['single'] ); // Single product image
	update_option( 'shop_thumbnail_image_size', $woocommerce_thumbnails['thumbnail'] ); // Image gallery thumbs

	/* Enable ajax cart */
	update_option( 'woocommerce_enable_ajax_add_to_cart', 'yes' );

	/* Disable WooCommerce lightbox so we can handle it */
	update_option( 'woocommerce_enable_lightbox', 'no' );
}
add_action( 'after_switch_theme', 'prequelle_woocommerce_image_sizes', 1 );

/**
 * Set default WP options on theme activation
 */
function prequelle_default_wp_options_init() {
	if ( ! get_option( prequelle_get_theme_slug() . '_wp_options_init' ) ) {

		/**
		 * A custom hook to set default options on theme activation
		 */
		do_action( 'prequelle_wp_default_options_init' );

		/*
		 * Another custom hook to set default 3rd party plugin options on theme activation
		 */
		do_action( 'prequelle_plugins_default_options_init' );

		/* Default WP options */
		update_option( 'image_default_link_type', 'file' );

		/* Add option to flag that the default mods have been set */
		add_option( prequelle_get_theme_slug() . '_wp_options_init', true );
	}
}
add_action( 'after_setup_theme', 'prequelle_default_wp_options_init' );

/**
 * Set default logo
 *
 * @param $mods
 * @return $mods
 */
function prequelle_set_default_customizer_images( $mods ) {

	$default_images = apply_filters( 'prequelle_default_image_mods', array( 'header', 'background' ) );

	foreach ( $default_images as $default_image ) {

		if ( prequelle_get_theme_uri( 'config/' . $default_image . '.jpg' ) ) {

			$filename = 'config/' . $default_image . '.jpg';

			if ( ! function_exists( 'wp_handle_upload' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
			}

			$movefile = wp_upload_bits( $default_image . '.jpg', null, prequelle_file_get_contents( $filename ) );

			if ( $movefile && isset( $movefile['url'] ) && empty( $movefile['error'] ) ) {

				/*Prepare an array of post data for the attachment.*/
				$movefile_url = $movefile['url'];
				$movefile_file = $movefile['file'];
				$filetype = wp_check_filetype( basename( $movefile_file ), null );
				$attachment = array(
					'guid' => $movefile_url,
					'post_mime_type' => $filetype['type'],
					'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
					'post_content' => '',
					'post_status' => 'inherit'
				);

				$attach_id = wp_insert_attachment( $attachment, $movefile_file );

				if ( $attach_id  ) {
					$mods[ $default_image . '_image'] = prequelle_get_theme_uri( 'config/' . $default_image . '.jpg' );
					$image_data = new stdClass();
					$image_data->attachment_id = $attach_id;
					$image_data->url = $movefile_file;
					$image_data->thumbnail_url = $movefile_url;

					if ( 'header' === $default_image ) {
						$image_data->width = 1900;
						$image_data->height = 1280;
					}

					$mods[ $default_image . '_image_data'] = $image_data;
				}
			}
		}
	}

	return $mods;
}
add_filter( 'prequelle_default_mods', 'prequelle_set_default_customizer_images' );