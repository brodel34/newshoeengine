/**
 *  Theme update notice
 */
 /* global Cookies */
;( function( $ ) {

	'use strict';

	$( document ).on( 'click', '.prequelle-dismiss-admin-notice', function ( event ) {
		event.preventDefault();

		var cookieID = $( this ).attr( 'id' );

		Cookies.set( cookieID, 'hide', { path: '/', expires: 730 } );
		$( this ).parents( '.notice-info' ).slideUp();
	} );

} )( jQuery );