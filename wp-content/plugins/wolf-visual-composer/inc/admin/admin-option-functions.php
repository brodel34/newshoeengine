<?php
/**
 * Wolf WPBakery Page Builder Extension admin option functions
 *
 * Functions available on admin for options
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Admin
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Update option index
 *
 * @param string $value
 * @param string $default
 * @return string
 */
function wvc_update_option_index( $index = 'settings', $options_array ) {

	$wvc_settings = ( get_option( 'wvc_settings' ) && is_array( get_option( 'wvc_settings' ) ) ) ? get_option( 'wvc_settings' ) : array();

	$wvc_settings[ $index ] = $options_array;

	update_option( 'wvc_settings', $wvc_settings );
}