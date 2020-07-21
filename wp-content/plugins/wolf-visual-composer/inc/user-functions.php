<?php
/**
 * Wolf WPBakery Page Builder Extension user functions
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Check if loggedin user is a MailChimp Subscriber
 *
 * Stores the result in user meta
 *
 * @param string
 * @param object
 */
function wvc_get_subscriber_mailchimp_status( $user_login, $user ) {

	$api_key = wolf_vc_get_option( 'mailchimp', 'mailchimp_api_key' );
	$list_id = wolf_vc_get_option( 'mailchimp', 'default_mailchimp_list_id' );
	$us = null;

	if ( ! $api_key ) {
		return;
	}

	$us_match = preg_match( '/-us[0-9]/', $api_key, $us_m ); // eg, 'us5' or 'us7'

	if ( isset( $us_m[0] ) ) {

		$us = trim( $us_m[0], '-' );

	} else {
		return;
	}

	if ( ! $us ) {
		return;
	}

	$args = array(
		'headers'     => array(
			'Authorization' => 'Basic ' . base64_encode( 'user:' . $api_key ),
			'Access-Control-Allow-Origin' => '*',
		),
	);
	$email_address = $user->user_email;
	
	$email_formatted = md5( strtolower( $email_address ) );
	
	$response = wp_remote_get( 'https://'. $us  .'.api.mailchimp.com/3.0/lists/'. $list_id .'/members/' . $email_formatted, $args );
	
	if ( is_array( $response ) ) {

		$body = json_decode( wp_remote_retrieve_body( $response ) );
		
		if ( $body && isset( $body->status ) ) {

			$mailchimp_status = $body->status;

			if ( $mailchimp_status == 'subscribed' ) {
				
				update_user_meta( $user->ID, 'user_mc_subscriber_status', 'yes' );
			
			} else {
				
				update_user_meta( $user->ID, 'user_mc_subscriber_status', 'no' );
			}		
		}
	}
}
add_action( 'wp_login', 'wvc_get_subscriber_mailchimp_status', 10, 2 );


function wvc_current_user_has_role( $role ){
	return wvc_user_has_role_by_user_id( get_current_user_id(), $role );
}

function wvc_get_user_roles_by_user_id( $user_id ) {
	$user = get_userdata( $user_id );
	return empty( $user ) ? array() : $user->roles;
}

function wvc_user_has_role_by_user_id( $user_id, $role ) {

	$user_roles = wvc_get_user_roles_by_user_id( $user_id );

	if ( is_array( $role ) ) {
		return array_intersect( $role, $user_roles ) ? true : false;
	}

	return in_array( $role, $user_roles );
}