/*!
 * Mailchimp
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */
/* global WVCMailchimpParams */

var WVCMailchimp = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			$( '.wvc-mailchimp-submit' ).on( 'click', function( event ) {
				event.preventDefault();

				var message = '',
					$submit = $( this ),
					$form = $submit.parents( '.wvc-mailchimp-form' ),
					$result = $form.find( '.wvc-mailchimp-result' ),
					list_id = $form.find( '.wvc-mailchimp-list' ).val(),
					firstName = $form.find( '.wvc-mailchimp-f-name' ).val(),
					lastName = $form.find( '.wvc-mailchimp-l-name' ).val(),
					hasName = $form.find( '.wvc-mailchimp-has-name' ).val(),
					email = $form.find( '.wvc-mailchimp-email' ).val(),
					data = {

						action : 'wvc_mailchimp_ajax',
						list_id : list_id,
						firstName : firstName,
						lastName : lastName,
						email : email,
						hasName : hasName
					};

				$result.animate( { 'opacity' : 0 } );

				$.post( WVCMailchimpParams.ajaxUrl, data, function( response ) {
					
					if ( response ) {

						message = response;

						if ( 'OK' === response ) {
							
							message = WVCMailchimpParams.subscriptionSuccessfulMessage;

							/* Use to track subs */
							$( window ).trigger( 'wvc_mc_subscribe' );
						}

					} else {
						
						message = WVCMailchimpParams.unknownError;
					}

					$result.html( message ).animate( { 'opacity' : 1 } );
					
					setTimeout( function() {
						$result.animate( { 'opacity' : 0 } );
					}, 3000 );
				} );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCMailchimp.init();
	} );

} )( jQuery );