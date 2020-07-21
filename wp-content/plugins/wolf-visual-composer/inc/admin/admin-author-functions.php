<?php
/**
 * Wolf WPBakery Page Builder Extension admin functions
 *
 * Functions available on admin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Admin
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add author social profiles
 */
function wvc_add_author_socials( $contactmethods ) {

	$services = wvc_get_team_member_socials();

	foreach ( $services as $service ) {

		if ( 'google' !== $service && 'email' !== $service ) { // avoid duplicated google plus
			$contactmethods[ $service ] = ucfirst( $service );
		}
	}

	return $contactmethods;
}
add_filter( 'user_contactmethods', 'wvc_add_author_socials', 10,1 );