<?php
/**
 * Wolf Gram core functions
 *
 * General core functions available on admin and frontend
 *
 * @author WolfThemes
 * @category Core
 * @package WolfGram/Core
 * @version 1.5.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get instagram access token from database option
 */
function wolf_gram_get_auth() {
	return get_option( 'wolf_instagram_access_token' );
}

/**
 * Get option
 */
function wolf_gram_get_option( $value = null, $default = null ) {

	global $options;

	$wolf_instagram_settings = get_option( 'wolf_instagram_settings' );

	if ( isset( $wolf_instagram_settings[ $value ] ) && '' != $wolf_instagram_settings[ $value ] ) {

		return $wolf_instagram_settings[ $value ];

	} elseif ( $default ) {

		return $default;
	}
}