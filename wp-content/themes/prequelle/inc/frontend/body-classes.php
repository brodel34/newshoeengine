<?php
/**
 * Prequelle body classes
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'prequelle_body_classes' ) ) {
	/**
	 * Add specific class to the body depending on theme mods and page template
	 *
	 * @version 1.0.4
	 * @param array $classes
	 * @return array $classes
	 */
	function prequelle_body_classes( $classes ) {

		$classes[] = 'wolf';

		$classes[] = prequelle_get_theme_slug();
		if ( isset( $_COOKIE[ prequelle_get_theme_slug() . '_session_loaded' ] ) ) {
			$classes[] = 'session-loaded';
		}

		if ( prequelle_is_edge() ) {
			$classes[] = 'is-edge';
		} else {
			$classes[] = 'not-edge';
		}

		/* Loading animation type */
		$classes[] = 'loading-animation-type-' . prequelle_get_inherit_mod( 'loading_animation_type' );

		/* Site Layout */
		$classes[] = 'site-layout-' . prequelle_get_inherit_mod( 'site_layout', 'wide' ); // layout
		
		if ( is_single() && post_password_required() ) {
			$classes[] = 'password-protected';
		}

		/* Global skin */
		$classes[] = 'global-skin-' . prequelle_get_color_scheme_option(); // global skin

		if ( ! prequelle_is_vc() ) {
			/*
			* Output skin class on non page builder pages only
			*/
			$classes[] = 'skin-' . prequelle_get_color_scheme_option();
		}

		/* Menu Layout */
		$classes[] = 'menu-layout-' .  prequelle_get_menu_layout();

		if ( 'none' !== prequelle_get_menu_layout() ) {
			/* Menu Style */
			$classes[] = 'menu-style-' . prequelle_get_menu_style();
		}

		/* Menu Skin */
		$classes[] = 'menu-skin-' .  prequelle_get_inherit_mod( 'menu_skin', 'light' );

		/* Menu Width */
		$classes[] = 'menu-width-' . prequelle_get_inherit_mod( 'menu_width', 'boxed' );

		/* Mega Menu Width */
		$classes[] = 'mega-menu-width-' . prequelle_get_inherit_mod( 'mega_menu_width', 'boxed' );

		/* Menu Hover Style */
		$classes[] = 'menu-hover-style-' . prequelle_get_inherit_mod( 'menu_hover_style', 'none' );

		/* Menu Sticky */
		$classes[] = 'menu-sticky-' . prequelle_get_inherit_mod( 'menu_sticky_type', 'soft' );

		/* Sub menu color adjustment */
		if ( 'light' === prequelle_get_color_tone( prequelle_get_theme_mod( 'submenu_background_color' ) ) ) {
			$classes[] = 'submenu-bg-light';
		}

		/* Accent color tune */
		if ( 'light' === prequelle_get_color_tone( prequelle_get_inherit_mod( 'accent_color' ) ) ) {
			$classes[] = 'accent-color-light';
		} else {
			$classes[] = 'accent-color-dark';

			if ( prequelle_color_is_black( prequelle_get_inherit_mod( 'accent_color' ) ) ) {
				$classes[] = 'accent-color-is-black';
			}
		}

		if ( 'none' === prequelle_get_inherit_mod( 'menu_cta_content_type', 'icons' ) || ! prequelle_get_inherit_mod( 'menu_cta_content_type', 'icons' ) ) {
			$classes[] = 'no-menu-cta';
		}

		/* Navbar BG */
		if ( prequelle_get_theme_mod( 'nav_bar_bg_img' ) ) {
			$classes[] = 'nav-bar-has-bg';
		}

		/* Mobile Menu BG */
		if ( prequelle_get_theme_mod( 'mobile_menu_bg_img' ) ) {
			$classes[] = 'mobile-menu-has-bg';
		}

		/* Menu items visiblity */
		$classes[] = 'menu-items-visibility-' . prequelle_get_inherit_mod( 'menu_items_visibility' );

		/* Side Panel */
		if ( prequelle_can_display_sidepanel() ) {
			$classes[] = 'side-panel-position-' . prequelle_get_inherit_mod( 'side_panel_position', 'right' );

			if ( prequelle_get_theme_mod( 'side_panel_bg_img' ) ) {
				$classes[] = 'side-panel-has-bg';
			}
		}

		if ( prequelle_get_theme_mod( 'lateral_menu_bg_img' ) ) {
			$classes[] = 'lateral-menu-has-bg';
		}

		if ( prequelle_get_theme_mod( 'mega_menu_bg_img' ) ) {
			$classes[] = 'mega-menu-has-bg';
		}

		if ( prequelle_get_theme_mod( 'overlay_menu_bg_img' ) ) {
			$classes[] = 'overlay-menu-has-bg';
		}

		/* Button Style */
		$classes[] = 'button-style-' . prequelle_get_theme_mod( 'button_style', 'standard' );

		/* Hero */
		$classes[] = ( prequelle_has_hero() ) ? 'has-hero' : 'no-hero';

		/* Header font tone */
		$classes[] = 'hero-font-' . prequelle_get_header_font_tone();

		/*
		Font class. Allow font size customization depending on font if needed
		*/
		$classes[] = 'body-font-' . sanitize_title( prequelle_get_theme_mod( 'body_font_name' ) );
		$classes[] = 'heading-font-' . sanitize_title( prequelle_get_theme_mod( 'heading_font_name' ) );
		$classes[] = 'menu-font-' . sanitize_title( prequelle_get_theme_mod( 'menu_font_name' ) );

		/* Default Header Image */
		if ( get_header_image() ) {
			$classes[] = 'has-default-header';
		}

		/* Transition animation type */
		$classes[] = 'transition-animation-type-' . prequelle_get_inherit_mod( 'transition_animation_type' );

		/* No logo */
		if ( ! prequelle_get_theme_mod( 'logo_svg' ) && ! prequelle_get_theme_mod( 'logo_light' ) && ! prequelle_get_theme_mod( 'logo_dark' ) ) {
			$classes[] = 'has-text-logo';
		}

		/* Logo visibility */
		$classes[] = 'logo-visibility-' . prequelle_get_inherit_mod( 'logo_visibility' );

		/**
		 * Ajax navigation
		 */
		if ( prequelle_do_ajax_nav() ) {
			$classes[] = 'is-ajax-nav';
		}

		/* Home Blog */
		if ( prequelle_is_home_as_blog() ) {
			$classes[] = 'is-blog-home';
		}

		/* Blog index page */
		if ( prequelle_is_blog_index() ) {
			$classes[] = 'is-blog-index'; // archive blog index (page for posts)
		}

		/* Is WVC activated? */
		if ( prequelle_is_wvc_activated() ) {
			$classes[] = 'has-wvc';
		} else {
			$classes[] = 'no-wvc';
		}

		/* Single post */
		if ( is_singular( 'post' ) ) {
			
			$classes[] = 'single-post-layout-' . prequelle_get_single_post_layout();

			$classes[] = prequelle_get_single_post_wvc_layout();

			if ( prequelle_get_theme_mod( 'newsletter_form_single_blog_post' ) ) {
				$classes[] = 'show-newsletter-form';
			} else {
				$classes[] = 'no-newsletter-form';
			}

			if ( prequelle_get_theme_mod( 'post_author_box' ) ) {
				$classes[] = 'show-author-box';
			} else {
				$classes[] = 'no-author-box';
			}

			if ( prequelle_get_theme_mod( 'post_related_posts' ) ) {
				$classes[] = 'show-related-post';
			} else {
				$classes[] = 'no-related-post';
			}
		}

		/* Blog pages */
		if ( prequelle_is_blog() || is_search() && ! prequelle_is_woocommerce_page() ) {
			$classes[] = 'is-blog';
			$classes[] = 'layout-' . prequelle_get_theme_mod( 'post_layout', 'standard' );
			$classes[] = 'display-' . prequelle_get_theme_mod( 'post_display', 'standard' );
		}

		/* Portfolio */
		if ( prequelle_is_portfolio() ) {
			$classes[] = 'is-portfolio';
			$classes[] = 'layout-' . apply_filters( 'prequelle_portfolio_layout', prequelle_get_theme_mod( 'work_layout', 'standard' ) );
		}

		/* Albums */
		if ( prequelle_is_albums() ) {
			$classes[] = 'is-albums';
			$classes[] = 'layout-' . apply_filters( 'prequelle_albums_layout', prequelle_get_theme_mod( 'gallery_layout', 'standard' ) );
		}

		/* Photos */
		if ( prequelle_is_photos() ) {
			$classes[] = 'is-photos';
			$classes[] = 'layout-' . apply_filters( 'prequelle_photos_layout', prequelle_get_theme_mod( 'attachment_layout', 'standard' ) );
		}

		/* Videos */
		if ( prequelle_is_videos() ) {
			$classes[] = 'is-videos';
			$classes[] = 'layout-' . apply_filters( 'prequelle_videos_layout', prequelle_get_theme_mod( 'video_layout', 'standard' ) );
		}

		/* Artists */
		if ( prequelle_is_artists() ) {
			$classes[] = 'is-artists';
			$classes[] = 'layout-' . apply_filters( 'prequelle_artists_layout', prequelle_get_theme_mod( 'artist_layout', 'standard' ) );
		}

		/* Single video */
		if ( is_singular( 'video' ) ) {
			$classes[] = 'single-post-layout-' . prequelle_get_single_video_layout();
		}

		/* Discography */
		if ( prequelle_is_discography() ) {
			$classes[] = 'is-discography';
			$classes[] = 'layout-' . apply_filters( 'prequelle_discography_layout', prequelle_get_theme_mod( 'release_layout', 'standard' ) );
		}

		/* Event */
		if ( prequelle_is_events() ) {
			$classes[] = 'is-events';
			$classes[] = 'layout-' . apply_filters( 'prequelle_events_layout', prequelle_get_theme_mod( 'event_layout', 'standard' ) );
		}

		/* WooCommerce */
		if ( prequelle_is_woocommerce_page() ) {

			if ( is_singular( 'product' ) ) {
				$classes[] = 'single-product-layout-' . prequelle_get_inherit_mod( 'product_single_layout', 'standard' );
			} else {
				$classes[] = 'is-shop';
				$classes[] = 'layout-' . prequelle_get_theme_mod( 'product_layout', 'standard' );
			}
		}

		/* Single work */
		if ( is_singular( 'work' ) ) {
			$classes[] = 'single-work-layout-' . prequelle_get_single_post_layout();
			$classes[] = 'single-work-width-' . get_post_meta( get_the_ID(), '_post_width', true );
		}

		/* Single Release */
		if ( is_singular( 'release' ) ) {
			$classes[] = 'single-release-layout-' . prequelle_get_single_post_layout( get_the_ID(), 'sidebar-left' );
			$classes[] = 'single-release-width-' . get_post_meta( get_the_ID(), '_post_width', true );
		}

		/* Single Video */
		if ( is_singular( 'video' ) ) {
			$classes[] = 'single-video-layout-' . prequelle_get_single_post_layout( get_the_ID(), 'fullwidth' );
			$classes[] = 'single-video-width-' . get_post_meta( get_the_ID(), '_post_width', true );
		}

		/* Single Artist */
		if ( is_singular( 'artist' ) ) {
			$classes[] = 'single-artist-layout-' . prequelle_get_single_post_layout( get_the_ID(), 'fullwidth' );
			$single_artist_content_width = prequelle_get_theme_mod( 'artist_single_layout' );

			if ( get_post_meta( get_the_ID(), '_post_width', true ) ) {
				$single_artist_content_width = get_post_meta( get_the_ID(), '_post_width', true );
			}

			$classes[] = 'single-artist-width-' . $single_artist_content_width;

			if ( get_post_meta( get_the_ID(), '_artist_hide_pagination', true ) ) {
				$classes[] = 'single-artist-hide-pagination';
			}
		}

		/* Page template clean classes */
		if ( is_page_template( 'page-templates/full-width.php' ) ) {
			$classes[] = 'page-default';
		}

		if ( is_page_template( 'page-templates/full-width.php' ) ) {
			$classes[] = 'page-full-width';
		}

		if ( is_page_template( 'page-templates/page-sidebar-right.php' ) ) {
			$classes[] = 'page-sidebar-right';
		}

		if ( is_page_template( 'page-templates/page-sidebar-left.php' ) ) {
			$classes[] = 'page-sidebar-left';
		}

		if ( is_page_template( 'page-templates/post-archives.php' ) ) {
			$classes[] = 'page-post-archives';
		}

		/* Hero */

		$hero_layout = prequelle_get_inherit_mod( 'hero_layout' );

		$post_hero_layout_meta = get_post_meta( get_the_ID(), '_post_hero_layout', true );
		$show_hero = ( 'none' !== $post_hero_layout_meta );

		if ( is_single() && $show_hero ) {

			if ( $post_hero_layout_meta ) {
				$hero_layout = $post_hero_layout_meta;
			
			} else {
				
				$hero_post_types = array( 'post', 'gallery', 'work', 'release', 'event', 'video', 'artist' );

				foreach ( $hero_post_types as $post_type ) {
					
					$post_type_hero_layout_mod = prequelle_get_theme_mod( $post_type . '_hero_layout' );

					if ( is_singular( $post_type ) && $post_type_hero_layout_mod && $show_hero ) {

						$hero_layout = $post_type_hero_layout_mod;
				
					} else {
						$hero_layout = $hero_layout;
					}
				}
			}

		}

		$classes[] = 'hero-layout-' . $hero_layout;

		if ( get_post_meta( prequelle_get_inherit_post_id(), '_post_hide_title_text', true ) ) {

			$classes[] = 'post-hide-title-text';
		} else {

			$classes[] = 'post-is-title-text';
		}

		/* Post title */
		if ( 'none' === prequelle_get_inherit_mod( 'hero_type' ) ) {

			$classes[] = 'post-hide-hero';

		} else {

			$classes[] = 'post-is-hero';
		}

		/* Footer widget area layout */
		$classes[] = 'footer-type-' . prequelle_get_inherit_mod( 'footer_type' );
		$classes[] = 'footer-skin-' . prequelle_get_inherit_mod( 'footer_skin', 'dark' );
		$classes[] = 'footer-widgets-layout-' . prequelle_get_theme_mod( 'footer_widgets_layout', '4-cols' );
		$classes[] = 'footer-layout-' . prequelle_get_theme_mod( 'footer_layout', 'boxed' );

		/* Bottom bar layout */
		$classes[] = 'bottom-bar-layout-' . prequelle_get_theme_mod( 'bottom_bar_layout', 'centered' );

		if ( get_post_meta( get_the_ID(), '_post_bottom_bar_hidden', true ) ) {
			$classes[] = 'bottom-bar-hidden';
		} else {
			$classes[] = 'bottom-bar-visible';
		}

		if ( class_exists( 'Wolf_404_Error_Page' ) || class_exists( 'PP_404Page' ) ) {
			$classes[] = 'has-404-plugin';
		} else {
			$classes[] = 'no-404-plugin';
		}

		return $classes;
	}
	add_filter( 'body_class', 'prequelle_body_classes' );
}

/**
 * Add data attribute to body
 *
 * @version 1.0.4
 * @param array $classes
 * @return array $classes
 */
function prequelle_body_data( $classes ) {
   
    $classes[] = '" data-hero-font-tone="' . prequelle_get_header_font_tone() . '';

    return $classes;
}
add_filter( 'body_class','prequelle_body_data', 9999 );