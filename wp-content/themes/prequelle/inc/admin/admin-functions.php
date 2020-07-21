<?php
/**
 * Prequelle admin functions
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Enables the Excerpt meta box in Work & Release edit screen.
 *
 * For old version of Wolf Portfolio & Wolf Discography
 */
function prequelle_add_excerpt_support_for_post_types() {
	add_post_type_support( 'work', 'excerpt' );
	add_post_type_support( 'release', 'excerpt' );
}
add_action( 'init', 'prequelle_add_excerpt_support_for_post_types' );

/**
 * Add helper admin notice on work post
 */
function prequelle_help_admin_notice() {

	global $pagenow;

	$post_type = '';

	if ( isset( $_GET['post_type'] ) ) {
		$post_type = esc_attr( $_GET['post_type'] );

	} elseif ( isset( $_GET['post'] ) ) {
		$post_type = get_post_type( absint( $_GET['post'] ) );
	}

	/* Offer to import demo content */

	$theme_slug = prequelle_get_theme_slug();

	$wvc_activated_flag = get_option( 'wvc_key' );
	$import_demo_flag = get_option( $theme_slug . '_demo_data_imported' );
	$is_ocdi_page = ( isset( $_GET['page'] ) && 'pt-one-click-demo-import' === $_GET['page'] );

	if ( $wvc_activated_flag && ! $import_demo_flag && ! $is_ocdi_page && class_exists( 'OCDI_Plugin' ) && 'index.php' === $pagenow ) {
		
		$cookie_id = $theme_slug . '_wolf_install_demo_data';

		$message = '<h3>';
		$message .= esc_html__( 'Hey there, would you like to import the demo content to help you to get started?', 'prequelle' );
		$message .= '</h3>';

		$message .= '<h4>';
		$message .= esc_html__( 'In this case, please ignore the plugin page setups.', 'prequelle' );
		$message .= '</h4>';

		$message .= sprintf(
			prequelle_kses( __( '<a href="%1$s" class="button button-primary button-hero">Install demo data</a><br>', 'prequelle' ) ),
			esc_url( admin_url( 'themes.php?page=pt-one-click-demo-import' ) )
		);

		prequelle_admin_notice( $message, 'info', $cookie_id, esc_html__( 'No thanks', 'prequelle' ) );
	}

	/*----------------------------*/

	if ( $import_demo_flag && class_exists( 'WooCommerce' ) && 'index.php' === $pagenow ) {

		$cookie_id = $theme_slug . '_wolf_woocommerce_pages_set';

		$message = esc_html__( 'The demo data successfully. ', 'prequelle' );

		$message .= sprintf(
			prequelle_kses( __( '<a href="%1$s" class="button button-primary button-hero">Install demo data</a><br>', 'prequelle' ) ),
			esc_url( admin_url( 'admin.php?page=wc-settings&tab=products&section=display' ) )
		);
	}

	/*----------------------------*/

	/* Info Work */
	if ( 'work' === $post_type && ( 'post.php' === $pagenow || 'post-new.php' === $pagenow  ) ) {
		$message = esc_html__( 'Please use the main text editor to showcase your media content and the "excerpt" box to insert an explanatory text in the page.', 'prequelle' );
		$cookie_id = $theme_slug . '_wolf_work_help';

		prequelle_admin_notice( $message, 'info', $cookie_id, esc_html__( 'Got it', 'prequelle' ) );
	}

	/* Release */
	if ( 'release' === $post_type && ( 'post.php' === $pagenow || 'post-new.php' === $pagenow  ) ) {
		$message = esc_html__( 'You can use the main text editor to showcase your media content usign the page builder, with a playlist for example. In this case it is recommended to set your row "Content Width" to "Full Width" and the background settings to "No Background".', 'prequelle' );
		$cookie_id = $theme_slug . '_wolf_release_help';

		prequelle_admin_notice( $message, 'info', $cookie_id, esc_html__( 'Got it', 'prequelle' ) );
	}

	/* Artist */
	if ( 'artist' === $post_type && ( 'post.php' === $pagenow || 'post-new.php' === $pagenow  ) ) {
		$message = esc_html__( 'You can use the main text editor for the "Biography" tab and the "Excerpt" box for an additional text below the artist\'s name. If you use the page builder for the bio, it is recommended to set your row "Content Width" to "Full Width". If you want to use the page builder to build your page entirely, you must choose the "Custom" layout option in the options below the text editor.', 'prequelle' );
		$cookie_id = $theme_slug . '_wolf_release_help';

		prequelle_admin_notice( $message, 'info', $cookie_id, esc_html__( 'Got it', 'prequelle' ) );
	}

	/* Set exceprt content recommendation */
	if ( 'post' === $post_type && 'post.php' === $pagenow ) {

		if ( prequelle_has_vc_content() ) {
			$message = esc_html__( 'If your post content is designed with the page builder, it is recommended to enter a post text sample in the "excerpt" box.', 'prequelle' );
			$message .= esc_html__( 'In this case it is recommended to set your row "Content Width" to "Full Width" and the background settings to "No Background".', 'prequelle' );
			$cookie_id = $theme_slug . '_wolf_post_help';

			prequelle_admin_notice( $message, 'info', $cookie_id, esc_html__( 'Got it', 'prequelle' ) );
		}
	}
}
add_action( 'admin_init', 'prequelle_help_admin_notice' );

/**
 * Custom admin notice
 *
 * @param string $message
 * @param string $type error|warning|info|success
 * @param string $cookie_id if set a cookie will be use to hide the notice permanently
 */
function prequelle_admin_notice( $message = null, $type = null, $cookie_id = null, $dismiss_text = null ) {

	if ( ! $message ) {
		return;
	}

	$is_dismissible = ( 'error' == $message ) ? '' : 'is-dismissible';

	if ( $cookie_id ) {

		if ( ! $dismiss_text ) {
			$dismiss_text = esc_html__( 'Hide permanently', 'prequelle' );
		}

		if ( $cookie_id ) {
			if ( ! isset( $_COOKIE[ $cookie_id ] ) ) {
				$href = esc_url( admin_url( 'themes.php?page=' . prequelle_get_theme_slug() . '-about&amp;dismiss=' . $cookie_id ) );
				echo "<div class='notice notice-$type $is_dismissible'><p>$message<br><a href='$href' id='$cookie_id' class='prequelle-dismiss-admin-notice'>$dismiss_text</a></p></div>";
			}
		}
	} else {
		echo "<div class='notice notice-$type $is_dismissible'><p>$message</p></div>";
	}
	return false;
}
add_action( 'admin_notices', 'prequelle_admin_notice' );

/**
 * Remove post formats on work posts
 */
function prequelle_remove_work_post_formats() {

	$post_type = '';

	if ( isset( $_GET['post_type'] ) ) {
		$post_type = esc_attr( $_GET['post_type'] );

	} elseif ( isset( $_GET['post'] ) ) {
		$post_type = get_post_type( absint( $_GET['post'] ) );
	}

	if ( 'work' === $post_type ) {
		remove_theme_support( 'post-formats' );
	}

}
add_action( 'load-post.php', 'prequelle_remove_work_post_formats' );
add_action( 'load-post-new.php', 'prequelle_remove_work_post_formats' );

/**
 * Remove unwanted plugin submenu
 */
function prequelle_remove_wolf_plugin_submenu() {
	remove_submenu_page( 'edit.php?post_type=work', 'wolf-portfolio-shortcode' );
	remove_submenu_page( 'edit.php?post_type=gallery', 'wolf-albums-shortcode' );
	remove_submenu_page( 'edit.php?post_type=video', 'wolf-videos-shortcode' );
	remove_submenu_page( 'edit.php?post_type=release', 'wolf-discography-shortcode' );
	remove_submenu_page( 'themes.php', 'wolf-custom-post-meta-settings' );

	if ( defined( 'VC_PAGE_MAIN_SLUG' ) ) {
		remove_submenu_page( VC_PAGE_MAIN_SLUG, 'wvc-socials' );
		remove_submenu_page( VC_PAGE_MAIN_SLUG, 'wvc-fonts' );
		remove_menu_page( 'edit.php?post_type=vc_grid_item' );
	}
}
add_action( 'admin_menu', 'prequelle_remove_wolf_plugin_submenu', 999 );

/**
 * Get the content of a file using wp_remote_get
 *
 * @param string $file path from theme folder
 */
function prequelle_file_get_contents( $file ) {

	$file = prequelle_get_theme_uri( $file );

	if ( $file ) {
		$response = wp_remote_get( $file );
		if ( is_array( $response ) ) {
			return wp_remote_retrieve_body( $response );
		}
	}
}

/**
 * Check if a string is an external URL to prevent hot linking when importing default mods on theme activation
 *
 * @param string $string
 * @return bool
 */
function prequelle_is_external_url( $string ) {

	if ( filter_var( $string, FILTER_VALIDATE_URL ) && parse_url( site_url(), PHP_URL_HOST) != parse_url( $string, PHP_URL_HOST ) ) {
		return parse_url( $string, PHP_URL_HOST );
	}
}

/**
 * Sync theme font option with WWPBPBE plugin
 *
 * @param array $options
 * @return array $options
 */
function prequelle_sync_theme_font_options_with_wvc( $options ) {
	if ( isset( $options['google_fonts'] ) && prequelle_is_wvc_activated() && function_exists( 'wvc_update_option' ) ) {
		wvc_update_option( 'fonts', 'google_fonts', $options['google_fonts'] );
	}

	return $options;
}
add_action( 'prequelle_after_' . prequelle_get_theme_slug() . '_font_settings_options_save', 'prequelle_sync_theme_font_options_with_wvc', 10, 1 );

/**
 * Sync WWPBPBE plugin fonts option with theme fonts
 *
 * @param array $options
 * @return array $options
 */
function prequelle_sync_wvc_font_options_with_theme( $options ) {
	if ( isset( $options['google_fonts'] ) ) {
		$fonts = $options['google_fonts'];
		prequelle_update_option( 'font', 'google_fonts', $fonts );
	}

	return $options;
}
add_action( 'wvc_after_options_save', 'prequelle_sync_wvc_font_options_with_theme', 10, 1 );

/**
 * Sync theme social mods with WWPBPBE plugin options
 *
 * Save social profiles URL from customizer to plugin settings
 */
function prequelle_sync_theme_social_mods_with_wvc() {
	
	if ( function_exists( 'wvc_get_socials' ) ) {
		$wvc_socials = wvc_get_socials();

		foreach ( $wvc_socials as $service ) {
			$mod = get_theme_mod( $service );

			if ( $mod ) {
				wvc_update_option( 'socials', $service, $mod );
			}
		}
	}
}
add_action( 'customize_save_after', 'prequelle_sync_theme_social_mods_with_wvc' );

/**
 * Sync WWPBPBE social options with theme mods
 *
 * Hook plugin option save to sync social networks theme mods
 *
 * @param array $options
 * @return array $options
 */
function prequelle_sync_wvc_social_options_with_theme( $options ) {
	if ( function_exists( 'wvc_get_socials' ) ) {
		$wvc_socials = wvc_get_socials();

		foreach ( $wvc_socials as $service ) {
			if ( isset( $options[ $service ] ) ) {
				set_theme_mod( $service, esc_attr( $options[ $service ] ) );
			}
		}
	}

	return $options;
}
add_action( 'wvc_after_options_save', 'prequelle_sync_wvc_social_options_with_theme' );


/**
 * Add CTA menu content type options
 *
 * @param array $options
 * @return array $options
 */
function prequelle_add_cta_menu_content_types( $options ) {

	if ( prequelle_is_wvc_activated() ) {
		$options['socials'] = esc_html__( 'Socials', 'prequelle' );
	}

	if ( prequelle_is_wc_activated() ) {
		$options['shop_icons'] = esc_html__( 'Shop Icons', 'prequelle' );
	}

	if ( function_exists( 'icl_object_id' ) ) {
		$options['wpml'] = esc_html__( 'Language Switcher', 'prequelle' );
	}

	return $options;
}
add_filter( 'prequelle_menu_cta_content_type_options', 'prequelle_add_cta_menu_content_types' );

/**
 * Filter theme menu layout mod
 *
 * If WPM is not installed and the menu with language switcher is set, return another menu layout instead
 *
 * @param array $mod
 * @return array $mod
 */
function prequelle_filter_menu_cta_content_type( $mod ) {

	if ( 'socials' === $mod && ! prequelle_is_wvc_activated() ) {
		$mod = 'icons';
	}

	if ( 'wpml' === $mod && ! prequelle_is_wvc_activated() ) {
		$mod = 'icons';
	}

	return $mod;
}
add_filter( 'theme_mod_cta_content', 'prequelle_filter_menu_layout_theme_mods' );

/**
 * Check if current post content has VC content in it
 *
 * @return bool
 */
function prequelle_has_vc_content() {

	if ( isset( $_GET['post'] ) ) {
		$post = get_post( absint( $_GET['post'] ) );

		if ( is_object( $post ) && preg_match( '/vc_row/', $post->post_content, $match ) ) {
			return true;
		}
	}
}

/**
 * Get the rev slider list
 *
 * @see http://themeforest.net/forums/thread/add-rev-slider-to-theme-please-authors-reply/97711
 * @return array $result
 */
function prequelle_get_revsliders() {

	if ( class_exists( 'RevSlider' ) ) {
		$theslider     = new RevSlider();
		$arrSliders = $theslider->getArrSliders();
		$arrA     = array();
		$arrT     = array();
		foreach( $arrSliders as $slider ) {
			$arrA[]     = $slider->getAlias();
			$arrT[]     = $slider->getTitle();
		}

		if ( $arrA && $arrT ) {
			$result = array_combine( $arrA, $arrT );
		} else {
			$result = array( '' => esc_html__( 'No slider yet', 'prequelle' ) );
		}
		
		return $result;
	}
}

/*---------------------------------------------------------------

	Tiny MCE custom class

-----------------------------------------------------------------*/

/**
 * Callback function to insert 'styleselect' into the $buttons array
 */
function prequelle_mce_styleselect_button( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter( 'mce_buttons_2', 'prequelle_mce_styleselect_button' );

/**
 * Callback function to filter the MCE settings
 */
function prequelle_mce_before_init_insert_formats( $init_array ) {  

	$style_formats = array(  
		array(  
			'title' => esc_html__( 'Accent Color', 'prequelle' ),
			'inline' => 'span',
			'classes' => 'accent',
			'wrapper' => false,
		),
	);

	$style_formats =apply_filters( 'prequelle_tiny_mce_style_formats', $style_formats );
	$init_array['style_formats'] = json_encode( $style_formats );
	
	return $init_array;  
}
add_filter( 'tiny_mce_before_init', 'prequelle_mce_before_init_insert_formats' );