<?php
/**
 * Wolf WPBakery Page Builder Extension scripts functions
 *
 * Scripts related functions for frontend
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Frontend
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * JS params
 */
function wvc_get_js_params() {

	/* Clean up modal window delay */
	$modal_window_delay = apply_filters( 'wvc_modal_window_delay', wolf_vc_get_option( 'modal_window', 'delay', 3 ) );
	$modal_window_delay = wvc_clean_spaces( str_replace( ',', '.', $modal_window_delay ), true );
	$modal_window_delay = $modal_window_delay * 1000;

	$js_params = array(
		'themeSlug' => wvc_get_theme_slug(),
		'ajaxUrl' => esc_url( WVC()->ajax_url() ),
		'WvcUrl' => esc_url( WVC_URI ),
		'lightbox' => apply_filters( 'wvc_lightbox', 'swipebox' ),
		'isMobile' => wp_is_mobile(),
		'WOWAnimationOffset' => apply_filters( 'wvc_wow_animation_offset', 0 ),
		'forceAnimationMobile' => apply_filters( 'wvc_force_animation_mobile', false ),
		'smoothScrollSpeed' => apply_filters( 'wvc_smooth_scroll_speed', 900 ),
		'smoothScrollEase' => apply_filters( 'wvc_smooth_scroll_ease', 'swing' ),
		'pieChartLineWidth' => apply_filters( 'wvc_default_pie_chart_line_width', 5 ),
		'parallaxNoIos' => apply_filters( 'wvc_parallax_no_ios', true ),
		'parallaxNoAndroid' => apply_filters( 'wvc_parallax_no_android', true ),
		'parallaxNoSmallScreen' => apply_filters( 'wvc_parallax_no_small_screen', true ),
		'googleMapApiKey' => wolf_vc_get_option( 'google-map', 'google_maps_api_key' ),
		'fullPage' => apply_filters( 'wvc_do_fullpage', wvc_do_fullpage() ),
		'fullPageContainer' => '.page-entry-content',
		'fpTransitionEffect' => apply_filters( 'wvc_fp_transition_effect', 'mix' ),
		'fpAnimTime' => apply_filters( 'wvc_fp_animtime', 900 ),
		'fpEasing' => apply_filters( 'wvc_fp_easing', 'swing' ),
		'fullPageContainer' => '.page-entry-content',
		'audioButtonPlayText' => esc_html__( 'Play', 'wolf-visual-composer' ),
		'audioButtonPauseText' => esc_html__( 'Pause', 'wolf-visual-composer' ),
		'modalWindowDelay' => $modal_window_delay,
		'modalWindowShowOnce' => apply_filters( 'wvc_modal_show_once', wolf_vc_get_option( 'modal_window', 'show_once' ) ),
		'modalWindowCookieTime' => apply_filters( 'wvc_modal_cookie_time', wolf_vc_get_option( 'modal_window', 'cookie_time', 1 ) ),
		'modalWindowNavigateAway' => apply_filters( 'wvc_modal_show_navigate_away', wolf_vc_get_option( 'modal_window', 'show_navigate_away' ) ),
		'language' => get_locale(),
		'accentColor' => apply_filters( 'wvc_theme_accent_color', '#0073AA' ),
		'fullHeightRowDoWPMOffsset' => apply_filters( 'wvc_fullheight_row_do_wpm_offset', true ),
		'isRTL' => apply_filters( 'wvc_is_rtl', true ),
		'printStylesheet' => WVC_CSS . '/print.min.css',
		'l10n' => array(
			'emptyFields' => esc_html__( 'Please fill all fields.', 'wolf-visual-composer' ),
			'unknownError' => esc_html__( 'Something went wrong while submuitting the form, please try again later.', 'wolf-visual-composer' ),
			'processingMessage' => esc_html__( 'Loading', 'wolf-visual-composer' ) . '<span class="wvc-hellip">.</span><span class="wvc-hellip">.</span><span class="wvc-hellip">.</span>',
			'BMICProcessingMessage' => esc_html__( 'Calculating', 'wolf-visual-composer' ) . '<span class="wvc-hellip">.</span><span class="wvc-hellip">.</span><span class="wvc-hellip">.</span>',
		),
	);

	$js_params = apply_filters( 'wvc_js_params', $js_params );

	return $js_params;
}

/**
 * Register scripts
 *
 * @since Wolf WPBakery Page Builder Extension 3.1.1
 */
function wvc_register_scripts() {

	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : WVC_VERSION;
	$folder = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '/min';
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	if ( defined( 'AUTOPTIMIZE_PLUGIN_DIR' ) ) {
		$suffix = '';
		$folder = '';
	}
	wp_register_script( 'swipebox', WVC_JS . '/lib/jquery.swipebox.min.js', array( 'jquery' ), '1.2.9', true );
	wp_register_script( 'jarallax', WVC_JS . '/lib/jarallax/jarallax.min.js', array(), '1.10.6', false );
	wp_register_script( 'jarallax-video', WVC_JS . '/lib/jarallax/jarallax-video.min.js', array(), '1.0.1', false );
	wp_register_script( 'parallax-scroll', WVC_JS . '/lib/jquery.parallax-scroll.min.js', array( 'jquery' ), '1.0.0b', true );
	wp_register_script( 'lazyloadxt', WVC_JS . '/lib/jquery.lazyloadxt.min.js', array( 'jquery' ), '1.1.0', true );
	wp_register_script( 'bigtext', WVC_JS . '/lib/jquery.bigtext.min.js', array( 'jquery' ), '1.0.0', true );
	wp_deregister_script( 'waypoints' ); // deregister waypoints from VC
	wp_register_script( 'waypoints', WVC_JS . '/lib/jquery.waypoints.min.js', array( 'jquery' ), '1.6.2', true );
	wp_register_script( 'froogaloop', WVC_JS . '/lib/froogaloop.js', array( 'jquery' ), '1.6.2', true ); // deprecated
	wp_register_script( 'vimeo-player', WVC_JS . '/lib/player.min.js', array(), '2.6.1', true );
	wp_deregister_script( 'vc_pie' ); // deregister vc_pie from VC
	wp_register_script( 'easypiechart', WVC_JS . '/lib/jquery.easypiechart.min.js', array( 'jquery' ), '2.1.7', true );
	wp_register_script( 'flex-images', WVC_JS . '/lib/jquery.flex-images.min.js', array( 'jquery' ), '1.0.4', true );
	wp_register_script( 'imagesloaded', WVC_JS . '/assets/js/lib/imagesloaded.pkgd.min.js', array( 'jquery' ), '4.1.4', true );
	wp_register_script( 'sticky-kit', WVC_JS . '/lib/sticky-kit.min.js', array( 'jquery' ), '1.1.2', true );
	wp_register_script( 'mousewheel', WVC_JS . '/lib/jquery.mousewheel.min.js', array( 'jquery' ), '3.1.13', true );
	wp_register_script( 'inview', WVC_JS . '/lib/jquery.inview.min.js', array( 'jquery' ), '1.1.2', true );

	/* Full Page */
	wp_register_script( 'scrolloverflow', WVC_JS . '/lib/scrolloverflow.min.js', array(), '0.0.5', true );
	wp_register_script( 'fullpage', WVC_JS . '/lib/jquery.fullpage.min.js', array(), '2.9.6', true );

	/* Particles */
	wp_register_script( 'particles', WVC_JS . '/lib/particles.min.js', array(), '0.4.0', false );

	/* Print */
	wp_register_script( 'print', WVC_JS . '/lib/jQuery.print.min.js', array(), '1.6.0', true );
	wp_register_script( 'wvc-lib-min', WVC_JS . '/min/lib.min.js', array( 'jquery' ), WVC_VERSION, true );
	wp_register_script( 'wvc-scripts', WVC_JS . '/min/scripts.min.js', array( 'jquery' ), WVC_VERSION, true );
	wp_register_script( 'object-fit-images', WVC_JS . '/lib/ofi.min.js', array(), '3.2.3', true );

	/*
	Don't register script below if we use the wvc_force_enqueue_scripts filter
	When using the wvc_force_enqueue_scripts, we will enqueue all these scripts concatenated and minified
	*/
	if ( apply_filters( 'wvc_force_enqueue_scripts', false ) ) {
		return;
	}

	/* Libraries */
	wp_register_script( 'event-move', WVC_JS . '/lib/jquery.event.move.min.js', array( 'jquery' ), '1.0.0', true );
	wp_register_script( 'twentytwenty', WVC_JS . '/lib/jquery.twentytwenty.min.js', array( 'jquery' ), '1.0.0', true );
	wp_register_script( 'countdown', WVC_JS . '/lib/jquery.countdown.min.js', array( 'jquery' ), '2.0.1', true );
	wp_register_script( 'countup', WVC_JS . '/lib/countUp.min.js', array(), '1.9.3', true );
	wp_register_script( 'fittext', WVC_JS . '/lib/jquery.fittext.min.js', array( 'jquery' ), '1.2.0', true );
	wp_register_script( 'flickity', WVC_JS . '/lib/flickity.pkgd.min.js', array( 'jquery' ), '2.2.0', true );
	wp_register_script( 'typed', WVC_JS . '/lib/typed.min.js', array( 'jquery' ), '2.0.1', true );
	wp_register_script( 'wow', WVC_JS . '/lib/wow.min.js', array( 'jquery' ), '1.3.0', true );
	wp_register_script( 'aos', WVC_JS . '/lib/aos.js', array( 'jquery' ), '2.3.0', true );
	wp_register_script( 'lity', WVC_JS . '/lib/lity.min.js', array( 'jquery' ), '2.2.2', true );
	wp_register_script( 'vivus', WVC_JS . '/lib/vivus.min.js', array(), '0.4.0', false );
	wp_register_script( 'owlcarousel', WVC_JS . '/lib/owl.carousel.min.js', array( 'jquery' ), '2.2.1', true );

	wp_register_script( 'packery-mode', WVC_JS . '/lib/packery-mode.pkgd.min.js', array( 'jquery', 'isotope' ), '2.0.1', true );
	wp_register_script( 'js-cookie', WVC_JS . '/lib/js.cookie.min.js', array( 'jquery' ), '2.1.4', true );
	wp_register_script( 'wvc-responsive', WVC_JS . $folder . '/responsive' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-accordion', WVC_JS . $folder . '/accordion' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-advanced-slider', WVC_JS . $folder . '/advanced-slider' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-anything-slider', WVC_JS . $folder . '/anything-slider' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-audio-button', WVC_JS . $folder . '/audio-button' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-carousels', WVC_JS . $folder . '/carousels' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-bigtext', WVC_JS . $folder . '/bigtext' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-fittext', WVC_JS . $folder . '/fittext' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-twentytwenty', WVC_JS . $folder . '/twentytwenty' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-countdown', WVC_JS . $folder . '/countdown' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-counter', WVC_JS . $folder . '/counter' . $suffix . '.js', array( 'jquery' ), $version, true );
	
	wp_register_script( 'wvc-fullpage', WVC_JS . $folder . '/fullpage' . $suffix . '.js', array( 'jquery' ), $version, true );

	wp_register_script( 'wvc-mailchimp', WVC_JS . $folder . '/mailchimp' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-sliders', WVC_JS . $folder . '/sliders' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-tabs', WVC_JS . $folder . '/tabs' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-toggles', WVC_JS . $folder . '/toggles' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-typed', WVC_JS . $folder . '/autotyping' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-embed-video', WVC_JS . $folder . '/embed-video' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-message', WVC_JS . $folder . '/message' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-vivus', WVC_JS . $folder . '/vivus' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-particles', WVC_JS . $folder . '/particles' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-gmaps', WVC_JS . $folder . '/gmaps' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-google-maps', WVC_JS . $folder . '/google-maps' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-progress-bar', WVC_JS . $folder . '/progress-bar' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-process', WVC_JS . $folder . '/process' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-galleries', WVC_JS . $folder . '/galleries' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-album-tracklist', WVC_JS . $folder . '/album-tracklist' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-loginform', WVC_JS . $folder . '/loginform' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-bmic', WVC_JS . $folder . '/bmic' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-modal-window', WVC_JS . $folder . '/modal-window' . $suffix . '.js', array( 'jquery', 'js-cookie' ), $version, true );
	wp_register_script( 'wvc-privacy-policy-message', WVC_JS . $folder . '/privacy-policy-message' . $suffix . '.js', array( 'jquery', 'js-cookie' ), $version, true );
	wp_register_script( 'wvc-pie', WVC_JS . $folder . '/pie' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-interactive-links', WVC_JS . $folder . '/interactive-links' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-interactive-overlays', WVC_JS . $folder . '/interactive-overlays' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-video-switcher', WVC_JS . $folder . '/video-switcher' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-showcase-vertical-carousel', WVC_JS . $folder . '/showcase-vertical-carousel' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-print', WVC_JS . $folder . '/print' . $suffix . '.js', array( 'jquery', 'print' ), $version, true );
	wp_register_script( 'wvc-youtube-video-bg', WVC_JS . $folder . '/YT-video-bg' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-vimeo', WVC_JS . $folder . '/vimeo' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_register_script( 'wvc-functions', WVC_JS . $folder . '/functions' . $suffix . '.js', array( 'jquery' ), $version, true );
}
add_action( 'wp_enqueue_scripts', 'wvc_register_scripts' );

/**
 * Enqueue conditional scripts
 *
 * @since Wolf WPBakery Page Builder Extension 3.1.1
 */
function wvc_enqueue_common_scripts() {

	if ( apply_filters( 'wvc_force_enqueue_scripts', false ) ) {
		return;
	}

	if ( 'swipebox' === apply_filters( 'wvc_lightbox', 'swipebox' ) ) {
		wp_enqueue_script( 'swipebox' );
	}

	wp_enqueue_script( 'lazyloadxt' );

	if ( wvc_is_edge() ) {
		wp_enqueue_script( 'object-fit-images' );
	}
	wp_enqueue_script( 'wvc-functions' ); // common functions
	wp_localize_script( 'wvc-functions', 'WVCParams', wvc_get_js_params() );
}
add_action( 'wp_enqueue_scripts', 'wvc_enqueue_common_scripts' );

/**
 * Force Enqueue all JS for theme usign AJAX
 *
 * @since Wolf WPBakery Page Builder Extension 3.1.1
 */
function wvc_force_enqueue_scripts() {

	/* If the theme need scripts on every page for AJAX, we enqueue everything */
	if ( apply_filters( 'wvc_force_enqueue_scripts', false ) ) {

		/*
		In case these libraries are used by 3rd party plugins
		We dequeue all library that are in the compressed file
		*/
		wp_dequeue_script( 'bigtext' );
		wp_dequeue_script( 'event-move' );
		wp_dequeue_script( 'twentytwenty' );
		wp_dequeue_script( 'countdown' );
		wp_dequeue_script( 'countup' );
		wp_dequeue_script( 'fittext' );
		wp_dequeue_script( 'flickity' );
		wp_dequeue_script( 'typed' );
		wp_dequeue_script( 'wow' );
		wp_dequeue_script( 'aos' );
		wp_dequeue_script( 'lity' );
		wp_dequeue_script( 'vivus' );
		wp_enqueue_script( 'lazyloadxt' );
		if ( 'swipebox' === apply_filters( 'wvc_lightbox', 'swipebox' ) ) {
			wp_enqueue_script( 'swipebox' );
		}

		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'waypoints' );
		wp_enqueue_script( 'jarallax' );
		wp_enqueue_script( 'jarallax-video' );
		wp_enqueue_script( 'parallax-scroll' );
		wp_enqueue_script( 'particles' );
		wp_enqueue_script( 'sticky-kit' );
		wp_enqueue_script( 'wvc-lib-min' ); // all lib files
		wp_enqueue_script( 'bandsintown', 'https://widget.bandsintown.com/main.min.js', array(), false, true );

		$google_api_key = wolf_vc_get_option( 'google-map', 'google_maps_api_key' );

		if ( $google_api_key ) {
			wp_enqueue_script( 'google-maps-api', '//maps.googleapis.com/maps/api/js?key=' . $google_api_key, array(), false, true );
		}

		wp_enqueue_script( 'wolf-facebook-page-box' );
		wp_enqueue_script( 'wvc-scripts' );
		wp_localize_script( 'wvc-scripts', 'WVCParams', wvc_get_js_params() );
		wp_enqueue_script( 'wvc-mailchimp', WVC_JS . '/min/mailchimp.min.js', array( 'jquery' ), WVC_VERSION, true );
		wp_localize_script(
			'wvc-mailchimp', 'WVCMailchimpParams', array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'unknownError' => esc_html__( 'An unknown error occured.', 'wolf-visual-composer' ),
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'wvc_force_enqueue_scripts' );

/**
 * Enqueue full page if enabled
 */
function wvc_enqueue_fullpage_scripts() {

	if ( wvc_do_fullpage() ) {

		wp_enqueue_script( 'waypoints' );
		wp_enqueue_script( 'scrolloverflow' );
		wp_enqueue_script( 'fullpage-extensions' );
		wp_enqueue_script( 'fullpage' );
		wp_enqueue_script( 'wvc-fullpage' );
	}
}
add_action( 'wp_enqueue_scripts', 'wvc_enqueue_fullpage_scripts', 44 );

/**
 * Overwrite isotope
 */
function wvc_overwrite_vc_scripts() {
	
	wp_deregister_script( 'isotope' );
	wp_register_script( 'isotope', WVC_JS . '/lib/isotope.pkgd.min.js', array( 'jquery' ), '3.0.6', true );
}
add_action( 'wp_enqueue_scripts', 'wvc_overwrite_vc_scripts', 999 );
