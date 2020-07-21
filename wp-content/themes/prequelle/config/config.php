<?php
/**
 * Theme configuration file
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

/**
 * Default Google fonts option
 */
function prequelle_set_default_google_font() {
	return 'Cabin:400,700,900|Rubik:400,700|Oswald:400:700|Playfair+Display:400:700|Amatic+SC';
}
add_filter( 'prequelle_default_google_fonts', 'prequelle_set_default_google_font' );

/**
 * Set color scheme
 *
 * Add csutom color scheme
 *
 * @param array $color_scheme
 * @param array $color_scheme
 */
function prequelle_set_color_schemes( $color_scheme ) {

	//unset( $color_scheme['default'] );

	$color_scheme['light'] = array(
		'label'  => esc_html__( 'Light', 'prequelle' ),
		'colors' => array(
			'#f7f7f7', // body_bg
			'#ffffff', // page_bg
			'#ffffff', // submenu_background_color
			'#0c0c0c', // submenu_font_color
			'#000000', // '#c3ac6d', // accent
			'#444444', // main_text_color
			'#4c4c4c', // secondary_text_color
			'#0d0d0d', // strong_text_color
			'#7c7c7c', // secondary accent
		)
	);

	$color_scheme['dark'] = array(
		'label'  => esc_html__( 'Dark', 'prequelle' ),
		'colors' => array(
			'#1B1B1B', // body_bg
			'#232322', // page_bg
			'#1C1829', // submenu_background_color
			'#ffffff', // submenu_font_color
			'#c3ac6d', // accent
			'#f4f4f4', // main_text_color
			'#ffffff', // secondary_text_color
			'#ffffff', // strong_text_color
			'#FF396B', // secondary accent
		)
	);

	return $color_scheme;
}
add_filter( 'prequelle_color_schemes', 'prequelle_set_color_schemes' );

/**
 * Add additional theme support
 */
function prequelle_additional_theme_support() {

	/**
	 * Enable WooCommerce support
	 */
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'prequelle_additional_theme_support' );

/**
 * Set default WordPress option
 */
function prequelle_set_default_wp_options() {

	update_option( 'medium_size_w', 500 );
	update_option( 'medium_size_h', 286 );

	update_option( 'thread_comments_depth', 2 );
}
add_action( 'prequelle_default_wp_options_init', 'prequelle_set_default_wp_options' );

/**
 * Filter WooCommerce image sizes
 *
 * @param array $woocommerce_thumbnails
 * @param array $woocommerce_thumbnails
 */
function prequelle_set_woocommerce_image_sizes( $woocommerce_thumbnails ) {

	$woocommerce_thumbnails = array(
		'catalog' => array(
			'width' 	=> '500',	// px
			'height'	=> '752',	// px
			'crop'	=> 1 		// true
		),

		'single' => array(
			'width' 	=> '709',	// px
			'height'	=> '1067',	// px
			'crop'	=> 1 		// true
		),

		'thumbnail' => array(
			'width' 	=> '200',	// px
			'height'	=> '301',	// px
			'crop'	=> 1 		// true
		),
	);

	return $woocommerce_thumbnails;
}
add_filter( 'prequelle_woocommerce_thumbnail_sizes', 'prequelle_set_woocommerce_image_sizes' );

/**
 * Set mod files to include
 */
function prequelle_customizer_set_mod_files( $mod_files ) {
	$mod_files = array(
		'loading',
		'logo',
		'layout',
		'colors',
		'navigation',
		'socials',
		'fonts',
		'header',
		'header-image',
		'blog',
		'portfolio',
		'shop',
		'background-image',
		'footer',
		'footer-bg',
		'wvc',
		'extra',
	);

	return $mod_files;
}
add_filter( 'prequelle_customizer_mod_files', 'prequelle_customizer_set_mod_files' );