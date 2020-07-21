<?php
/**
 * Wolf WPBakery Page Builder Extension frontend functions
 *
 * General core functions available on admin.and frontend
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
 * Check if VC is used on this page
 *
 * @return bool
 */
function wvc_is_vc() {

	global $post;

	$is_page = is_page() && 'default' === get_post_meta( get_the_ID(), '_wp_page_template', true );
	$is_valid_post_type = in_array( get_post_type(), apply_filters( 'wvc_default_post_types', vc_editor_post_types() ) );

	if ( is_page() || ( is_single() && $is_valid_post_type ) ) {
		if ( is_object( $post ) ) {
			$pattern = get_shortcode_regex();
			if ( preg_match( "/$pattern/s", $post->post_content, $match ) ) {
				if ( 'vc_row' === $match[2] || 'vc_section' === $match[2] ) {
					return apply_filters( 'wvc_is_vc', true );
				}
			}
		}
	}
}

/**
 * Check if the browser is edge
 *
 * @return bool
 */
function wvc_is_edge() {
	global $is_edge;

	return $is_edge;
}

/**
 * Check if the browser is firefox
 *
 * @return bool
 */
function wvc_is_firefox() {
	global $is_gecko ;

	return $is_gecko ;
}

/**
 * Check if the browser is iOS
 *
 * @return bool
 */
function wvc_is_iphone() {
	global $is_iphone;

	return $is_iphone;
}

/**
 * Check if Bandwintown plugin is active
 */
function wvc_is_bandsintown() {
	return class_exists( 'Bandsintown_JS_Plugin' );
}

/**
 * Do fullPage
 */
function wvc_do_fullpage() {
	if ( is_page() || is_single() ) {
		if ( get_post_meta( wvc_get_the_ID(), '_post_fullpage', true ) && 'no' !== get_post_meta( wvc_get_the_ID(), '_post_fullpage', true ) ) {
			return apply_filters( 'wvc_do_fullpage', true );
		}
	}
}

/**
 * Check if we are on a woocommerce page
 *
 * @return bool
 */
function wvc_is_woocommerce_page() {

	if ( class_exists( 'WooCommerce' ) ) {

		if ( is_woocommerce() ) {
			return true;
		}

		if ( is_shop() ) {
			return true;
		}

		if ( is_checkout() || is_order_received_page() ) {
			return true;
		}

		if ( is_cart() ) {
			return true;
		}

		if ( is_account_page() ) {
			return true;
		}

		if ( function_exists( 'wolf_wishlist_get_page_id' ) && is_page( wolf_wishlist_get_page_id() ) ) {
			return true;
		}
	}
}

/**
 * Check if the home page is set to posts
 *
 * @return bool
 */
function wvc_is_home_as_blog() {
	return ( 'posts' === get_option( 'show_on_front' ) && is_home() );
}

/**
 * Maintenance
 */
function wvc_is_maintenance_page() {
	
	$wolf_maintenance_settings = get_option( 'wolf_maintenance_settings' );
	$maintenance_page_id = ( isset( $wolf_maintenance_settings[ 'page_id' ] ) ) ? $wolf_maintenance_settings[ 'page_id' ] : null;

	if ( $maintenance_page_id && is_page( $maintenance_page_id ) ) {
		return true;
	}
}

/**
 * Check if use is MC sub
 */
function wvc_is_user_mc_sub() {
	if ( get_user_meta( get_current_user_id(), 'user_mc_subscriber_status', true ) === 'yes' ) {
		return true;
	}
}
function wvc_is_user_admin() {
	return wvc_current_user_has_role( 'administrator' );
}