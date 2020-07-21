<?php
/**
 * Prequelle Frontend Scripts
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Remove plugin scripts
 * Allow an easier customization
 */
function prequelle_dequeue_plugin_scripts() {
	wp_dequeue_script( 'wolf-portfolio' );
	wp_dequeue_script( 'wolf-videos' );
	wp_dequeue_script( 'wolf-albums' );
	wp_dequeue_script( 'wolf-discography' );
}
add_action( 'wp_enqueue_scripts', 'prequelle_dequeue_plugin_scripts' );

if ( ! function_exists( 'prequelle_enqueue_scripts' ) ) {
	/**
	 * Register theme scripts for the theme
	 */
	function prequelle_enqueue_scripts() {

		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : prequelle_get_theme_version();
		if ( defined( 'AUTOPTIMIZE_PLUGIN_DIR' ) ) {
			$suffix = '';
		}

		$lightbox = apply_filters( 'prequelle_lightbox', prequelle_get_theme_mod( 'lightbox', 'fancybox' ) );
		wp_enqueue_script( 'wp-mediaelement' );

		/**
		 * Enqueuing main scripts
		 */
		wp_register_script( 'jarallax', get_template_directory_uri() . '/assets/js/lib/jarallax.min.js', array( 'jquery' ), '1.8.0', false );
		wp_enqueue_script( 'fastclick', get_template_directory_uri() . '/assets/js/lib/fastclick.js', array( 'jquery' ), '1.0.6', true );
		wp_enqueue_script( 'js-cookie', get_template_directory_uri() . '/assets/js/lib/js.cookie.min.js', array( 'jquery' ), '2.1.4', true );
		wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/assets/js/lib/jquery.flexslider.min.js', array( 'jquery' ), '2.6.3', true );
		wp_enqueue_script( 'flickity', get_template_directory_uri() . '/assets/js/lib/flickity.pkgd.min.js', array( 'jquery' ), '2.0.5', true );

		if ( 'fancybox' === $lightbox ) {
			wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/assets/js/lib/jquery.fancybox.min.js', array( 'jquery' ), '3.0', true );

		} elseif ( 'swipebox' === $lightbox ) {
			wp_enqueue_script( 'swipebox', get_template_directory_uri() . '/assets/js/lib/jquery.swipebox.min.js', array( 'jquery' ), '1.4.4', true );
		}
		wp_enqueue_script( 'lazyloadxt', get_template_directory_uri() . '/assets/js/lib/jquery.lazyloadxt.min.js', array( 'jquery' ), '1.1.0', true );
		wp_enqueue_script( 'sticky-kit', get_template_directory_uri() . '/assets/js/lib/sticky-kit.min.js', array( 'jquery' ), '1.1.3', true );
		wp_register_script( 'vimeo-player', get_template_directory_uri() . '/assets/js/lib/player.min.js', array(), '2.6.1', true );

		if ( prequelle_is_edge() ) {
			wp_enqueue_script( 'object-fit-images', get_template_directory_uri() . '/assets/lib/ofi.min.js', array(), '3.2.3', true );
		}
		wp_register_script( 'aos', get_template_directory_uri() . '/assets/js/lib/aos.js', array( 'jquery' ), '2.3.0', true );
		wp_register_script( 'prequelle-carousels', get_template_directory_uri() . '/assets/js/carousels' . $suffix . '.js', array( 'jquery' ), $version, true );
		wp_register_script( 'prequelle-youtube-video-background', get_template_directory_uri() . '/assets/js/YT-background' . $suffix . '.js', array( 'jquery' ), $version, true );

		wp_register_script( 'prequelle-vimeo', get_template_directory_uri() . '/assets/js/vimeo' . $suffix . '.js', array( 'jquery' ), $version, true );
		wp_enqueue_script( 'wolftheme', get_template_directory_uri() . '/assets/js/functions' . $suffix . '.js', array( 'jquery' ), $version, true );
		wp_enqueue_script( 'tooltipsy', get_template_directory_uri() . '/assets/js/lib/tooltipsy.min.js', array( 'jquery' ), '1.0.0', true );

		/*
		* Register conditional scripts
		*/
		wp_register_script( 'infinitescroll', get_template_directory_uri() . '/assets/js/lib/jquery.infinitescroll.min.js', array( 'jquery' ), '2.0.0', true );

		wp_register_script( 'prequelle-loadposts', get_template_directory_uri() . '/assets/js/loadposts' . $suffix . '.js', array( 'jquery' ), $version, true );
		wp_register_script( 'imagesloaded', get_template_directory_uri() . '/assets/js/lib/imagesloaded.pkgd.min.js', array( 'jquery' ), '4.1.4', true );
		
		wp_register_script( 'isotope', get_template_directory_uri() . '/assets/js/lib/isotope.pkgd.min.js', array( 'jquery' ), '3.0.5', true );
		
		wp_register_script( 'packery-mode', get_template_directory_uri() . '/assets/js/lib/packery-mode.pkgd.min.js', array( 'jquery', 'isotope' ), '2.0.1', true );
		wp_register_script( 'flex-images', get_template_directory_uri() . '/assets/lib/jquery.flex-images.min.js', array( 'jquery' ), '1.0.4', true );
		
		wp_register_script( 'prequelle-masonry', get_template_directory_uri() . '/assets/js/masonry' . $suffix . '.js', array( 'jquery' ), $version, true );
		wp_register_script( 'prequelle-category-filter', get_template_directory_uri() . '/assets/js/category-filter' . $suffix . '.js', array( 'jquery' ), $version, true );

		wp_register_script( 'prequelle-ajax-nav', get_template_directory_uri() . '/assets/js/ajax' . $suffix . '.js', array( 'jquery' ), $version, true );

		/**
		 * Enqueuing scripts
		 */
		wp_enqueue_script( 'flexslider' );
		wp_enqueue_script( 'jarallax' );
		if ( prequelle_is_wvc_activated() ) {
			wp_enqueue_script( 'bigtext' );
			wp_enqueue_script( 'wvc-bigtext' );
		}

		if ( is_search() || is_singular( 'proof_gallery' ) ) {
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'isotope' );
			wp_enqueue_script( 'prequelle-masonry' );
		}

		if ( is_singular( 'work' ) ) {
		}

		if ( is_singular( 'artist' ) ) {
			wp_enqueue_script( 'jquery-ui-tabs', true );
		}
			wp_enqueue_script( 'flickity' );
			wp_enqueue_script( 'prequelle-carousels' );

		/**
		 * If AJAX navigation is enabled, we enqueued everything we may need from start
		 */
		if ( prequelle_do_ajax_nav() ) {
			wp_enqueue_script( 'wp-mediaelement' );
			wp_enqueue_script( 'jarallax' );
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'isotope' );
			wp_enqueue_script( 'packery-mode' );
			wp_enqueue_script( 'infinitescroll' );
			wp_enqueue_script( 'sticky-kit' );
			wp_enqueue_script( 'prequelle-masonry' );
			wp_enqueue_script( 'prequelle-infinitescroll' );
			wp_enqueue_script( 'prequelle-loadposts' );
			wp_enqueue_script( 'prequelle-category-filter' );
			wp_enqueue_script( 'prequelle-carousels' );
			if ( class_exists( 'WooCommerce' ) ) {

				wp_enqueue_script( 'wc-single-product' );
				wp_enqueue_script( 'wc-jquery-ui-touchpunch', WC()->plugin_url() . '/assets/js/jquery-ui-touch-punch/jquery-ui-touch-punch' . $suffix . '.js', array( 'jquery-ui-slider' ), WC_VERSION, true );
				wp_enqueue_script( 'wc-price-slider', WC()->plugin_url() . '/assets/js/frontend/price-slider' . $suffix . '.js', array( 'jquery-ui-slider', 'wc-jquery-ui-touchpunch' ), WC_VERSION, true );
			}

			wp_enqueue_script( 'prequelle-ajax-nav' );
		}
		wp_localize_script(
			'wolftheme', 'PrequelleParams', array(
				'defaultPageLoadingAnimation' => apply_filters( 'prequelle_default_page_loading_animation', true ),
				'defaultPageTransitionAnimation' => apply_filters( 'prequelle_default_page_transition_animation', true ),
				'siteUrl' => esc_url( site_url( '/' ) ),
				'homeUrl' => esc_url( home_url( '/' ) ),
				'ajaxUrl' => esc_url( admin_url( 'admin-ajax.php' ) ),
				'isMobile' => wp_is_mobile(),
				'isPostTypeArchive' => prequelle_is_post_type_archive(),
				'themeSlug' => prequelle_get_theme_slug(),
				'accentColor' => prequelle_get_inherit_mod( 'accent_color', '#007acc' ),
				'breakPoint' => apply_filters( 'prequelle_menu_breakpoint', prequelle_get_inherit_mod( 'menu_breakpoint', 1100 ) ),
				'menuLayout' => prequelle_get_inherit_mod( 'menu_layout' ),
				'menuOffset' => prequelle_get_inherit_mod( 'menu_offset', 0 ),
				'menuHoverStyle' => prequelle_get_inherit_mod( 'menu_hover_style', 'opacity' ),
				'subMenuWidth' => apply_filters( 'prequelle_submenu_width', 230 ),
				'stickyMenuType' => prequelle_get_inherit_mod( 'menu_sticky_type', 'soft' ),
				'stickyMenuScrollPoint' => apply_filters( 'prequelle_sticky_menu_scrollpoint', 500 ),
				'stickyMenuHeight' => apply_filters( 'prequelle_sticky_menu_height', 60 ),
				'desktopMenuHeight' => apply_filters( 'prequelle_desktop_menu_height', 80 ),
				'lightbox' => apply_filters( 'prequelle_lightbox', prequelle_get_inherit_mod( 'lightbox', 'fancybox' ) ),
				'WOWAnimationOffset' => apply_filters( 'prequelle_wow_animation_offset', 0 ),
				'forceAnimationMobile' => apply_filters( 'prequelle_force_animation_mobile', false ),
				'parallaxNoIos' => apply_filters( 'prequelle_parallax_no_ios', true ),
				'parallaxNoAndroid' => apply_filters( 'prequelle_parallax_no_android', true ),
				'parallaxNoSmallScreen' => apply_filters( 'prequelle_parallax_no_small_screen', true ),
				'portfolioSidebarOffsetTop' => ( 'soft' === prequelle_get_inherit_mod( 'menu_sticky_type', 'soft' ) || 'hard' === prequelle_get_inherit_mod( 'menu_sticky_type', 'soft' ) ) ? apply_filters( 'prequelle_sticky_menu_height', 60 ) : 0,
				'isWooCommerce' => function_exists( 'WC' ),
				'WooCommerceCartUrl' => ( function_exists( 'wc_get_cart_url' ) ) ? wc_get_cart_url() : '',
				'WooCommerceCheckoutUrl' => ( function_exists( 'wc_get_checkout_url' ) ) ? wc_get_checkout_url() : '',
				'WooCommerceAccountUrl' => ( function_exists( 'WC' ) ) ? get_permalink( get_option('woocommerce_myaccount_page_id') ) : '',
				'doWoocommerceLightbox' => ( 'no' == get_option( 'woocommerce_enable_lightbox' ) ),
				'doVideoLightbox' => ( 'yes' == prequelle_get_inherit_mod( 'videos_lightbox' ) ),
				'doLiveSearch' => apply_filters( 'prequelle_live_search', true ),
				'doHashChange' => apply_filters( 'prequelle_hashchange', true ),
				'smoothScrollSpeed' => apply_filters( 'prequelle_smooth_scroll_speed', 1000 ),
				'smoothScrollEase' => apply_filters( 'prequelle_smooth_scroll_ease', 'swing' ),
				'infiniteScrollEmptyLoad' => get_template_directory_uri() . '/assets/img/blank.gif',
				'infiniteScrollGif' => apply_filters( 'prequelle_infinite_scroll_loading_gif_url', get_template_directory_uri() . '/assets/img/loading.gif' ),
				'isCustomizer' => prequelle_is_customizer(),
				'isAjaxNav' => prequelle_do_ajax_nav(),
				'hasLoadingOverlay' => apply_filters( 'prequelle_display_overlay', 'none' != prequelle_get_inherit_mod( 'loading_animation_type', 'none' ) ),
				'pageLoadedDelay' => apply_filters( 'prequelle_page_loaded_delay', 1000 ),
				'pageTransitionDelayBefore' => apply_filters( 'prequelle_page_transition_delay_before', 0 ),
				'pageTransitionDelayAfter' => apply_filters( 'prequelle_page_transition_delay_after', 0 ),
				'mediaelementLegacyCssUri' => includes_url( 'js/mediaelement/mediaelementplayer-legacy.min.css' ),
				'fancyboxMediaelementCssUri' => get_template_directory_uri(). '/assets/css/fancybox-mediaelement' . esc_attr( $suffix ) . '.css',
				'is404' => is_404(),
				'isUserLoggedIn' => is_user_logged_in(),
				'allowedMimeTypes' => array_keys( get_allowed_mime_types() ),
				'logoMarkup' => prequelle_logo( false ),
				'language' => get_locale(),
				'l10n' => array(
					'replyTitle' => esc_html__( 'Post a comment', 'prequelle' ),
					'editPost' => esc_html__( 'Edit Post', 'prequelle' ),
					'infiniteScrollMsg' => esc_html__( 'Loading', 'prequelle' ) . '<span class="load-more-hellip">.</span><span class="load-more-hellip">.</span><span class="load-more-hellip">.</span>',
					'infiniteScrollEndMsg' => esc_html__( 'No more post to load', 'prequelle' ),
					'loadMoreMsg' => apply_filters( 'prequelle_load_more_posts_text', esc_html__( 'Load More', 'prequelle' ) ),
					'infiniteScrollDisabledMsg' => esc_html__( 'The infinitescroll is disabled in live preview mode', 'prequelle' ),
					'addToCart' => esc_html__( 'Add to cart', 'prequelle' ),
					'viewCart' => esc_html__( 'View cart', 'prequelle' ),
					'addedToCart' => esc_html__( 'Added to cart', 'prequelle' ),
					'playText' => esc_html__( 'Play', 'prequelle' ),
					'pauseText' => esc_html__( 'Pause', 'prequelle' ),
				),
			)
		);
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'prequelle_enqueue_scripts' );
} // end function check

/**
 * Force WWPBPBE to enqueue all scripts for AJAX
 *
 * Wolf WPBakery Page Builder Extension enqueue scripts conditionally. We need all scripts from start for AJAX navigation.
 * We set the wvc_force_enqueue_scripts filter to true right here if AJAX nav is enabled
 */
function prequelle_wvc_force_enqueue_scripts() {

	if ( prequelle_do_ajax_nav() ) {
		return true;
	}
}
add_filter( 'wvc_force_enqueue_scripts', 'prequelle_wvc_force_enqueue_scripts' );

/* 
Remove CSS and/or JS for Select2 used by WooCommerce, see https://gist.github.com/Willem-Siebe/c6d798ccba249d5bf080.
*/
 add_action( 'wp_enqueue_scripts', 'prequelle_dequeue_stylesandscripts_select2', 100 );
 function prequelle_dequeue_stylesandscripts_select2() {
    if ( class_exists( 'woocommerce' ) && wp_is_mobile() ) {
        wp_dequeue_style( 'selectWoo' );
        wp_deregister_style( 'selectWoo' );
 
        wp_dequeue_script( 'selectWoo');
        wp_deregister_script('selectWoo');
    } 
}