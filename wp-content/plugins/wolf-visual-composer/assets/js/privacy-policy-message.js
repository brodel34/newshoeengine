/*!
 * PrivacyPolicyMessage
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

/* global WVC, WVCParams */
var WVCPrivacyPolicyMessage = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			var $container = $( '#wvc-privacy-policy-message-container' ),
				cookieName = WVCParams.themeSlug + '_wvc_privacy_policy_message';

			if ( ! Cookies.get( cookieName ) ) {
				$container.show();
			}

			$( document ).on( 'click', '.wvc-privacy-policy-message-close', function( event ) {
				event.preventDefault();
				$container.fadeOut( 400, function() {
					Cookies.set( cookieName, 'dismissed', { expires: 30, path: '/' } );
				} );
			} );
		}

	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCPrivacyPolicyMessage.init();
	} );

} )( jQuery );