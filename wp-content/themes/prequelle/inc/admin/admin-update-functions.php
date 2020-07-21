<?php
/**
 * Prequelle admin theme update functions
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Update theme version
 *
 * Compare and update theme version and fire update hook to do stuff if needed
 */
function prequelle_update() {

	$theme_version = prequelle_get_theme_version();
	$theme_slug = prequelle_get_theme_slug();

	if ( ! defined( 'IFRAME_REQUEST' ) && ! defined( 'DOING_AJAX' ) && ( get_option( $theme_slug . '_version' ) != $theme_version ) ) {
		do_action( 'prequelle_do_update' );
		delete_option( $theme_slug . '_version' );
		add_option( $theme_slug . '_version', $theme_version );
		do_action( 'prequelle_updated' );
	}
}
add_action( 'admin_init', 'prequelle_update', 0 );

/**
 * Fetch XML changelog file from remote server
 *
 * Get the theme changelog and cache it in a transient key
 *
 * @return string
 */
function prequelle_get_theme_changelog() {

	$xml = null;
	$update_url = 'https://updates.wolfthemes.com';
	$changelog_url = $update_url . '/' . prequelle_get_theme_slug() .'/changelog.xml';

	$trans_key = '_latest_theme_version_' . prequelle_get_theme_slug();

	if ( false === ( $cached_xml = get_transient( $trans_key ) ) ) {

		$response = wp_remote_get( $changelog_url , array( 'timeout' => 10 ) );

		if ( ! is_wp_error( $response ) && is_array( $response ) ) {
			$xml = wp_remote_retrieve_body( $response ); // use the content
		}

		if ( $xml ) {
			set_transient( $trans_key, $xml, 60 * 60 * 6 ); // 6 hours cache
		}
	} else {
		$xml = $cached_xml;
	}

	if ( $xml ) {
		return @simplexml_load_string( $xml );
	}
}

/**
 * Display the theme update notification notice fro important update
 *
 * @param bool $link
 * @return string
 */
function prequelle_update_notification_message() {

	$changelog = prequelle_get_theme_changelog();
	$warning = ( $changelog && isset( $changelog->warning ) ) ? (string)$changelog->warning : false;
	$cookie_name = prequelle_get_theme_slug() . '_update_notice';
	$message = '';
	$is_envato_plugin_page = ( isset( $_GET['page'] ) && 'envato-market' === $_GET['page'] );

	/* Stop if update is not critical and the update notification is disabled */
	if ( $changelog && isset( $changelog->updatenotification ) && 'no' === (string)$changelog->updatenotification ) {
		return;
	}
	if ( $changelog && isset( $changelog->latest ) && -1 == version_compare( prequelle_get_parent_theme_version(), $changelog->latest ) && ! $is_envato_plugin_page ) {

		$class = 'prequelle-admin-notice notice notice-info is-dismissible';

		$message .= '<p>';
		$message .= sprintf(
			wp_kses_post(
				__( 'There is a new version of <strong>%s</strong> available. You have version %s installed. It is recommended to update.', 'prequelle' )
			),
			prequelle_get_parent_theme_name(),
			prequelle_get_parent_theme_version()
		);
		$message .= '</p>';
		$href = ( class_exists( 'Envato_Market' ) ) ? admin_url( 'update-core.php' ) : 'https://wolfthemes.ticksy.com/article/11658/';
		$target = ( class_exists( 'Envato_Market' ) ) ? '_parent' : '_blank';

		$message .= '<p>';
		$message .= '<a class="button button-primary prequelle-admin-notice-button" href="' . esc_url( $href ) . '" target="' . esc_attr( $target ) .'">';
		$message .= sprintf( esc_html__( 'Update to version %s', 'prequelle' ), $changelog->latest );
		$message .= '</a>';

		$message .= ' <a id="' . esc_attr( $cookie_name ) . '" class="button prequelle-dismiss-admin-notice" href="#">';
		$message .= esc_html__( 'Hide update notices permanently', 'prequelle' );
		$message .= '</a>';
		$message .= '</p>';

		if ( $warning ) {
			$class = 'prequelle-admin-notice notice notice-error is-dismissible';
			$message .= '<br>';
			$message .= $warning;
		}

		if ( ! isset( $_COOKIE[ $cookie_name ] ) ) {
			printf( '<div class="%1$s">%2$s</div>', $class, $message );
		}
	}
}
add_action( 'admin_notices', 'prequelle_update_notification_message' );