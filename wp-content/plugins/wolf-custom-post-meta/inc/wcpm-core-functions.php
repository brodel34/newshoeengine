<?php
/**
 * Wolf Custom Post Meta core functions
 *
 * General core functions available on admin and frontend
 *
 * @author WolfThemes
 * @category Core
 * @package WolfCustom Post Meta/Core
 * @version 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get options
 *
 * @param string $key
 * @param string $default
 * @return string
 */
function wolf_custom_post_meta_get_option( $key, $default = null ) {

	$settings = get_option( 'wolf_custom_post_meta_settings' );

	if ( isset( $settings[ $key ] ) && '' != $settings[ $key ] ) {

		return $settings[ $key ];

	} elseif ( $default ) {

		return $default;
	}
}