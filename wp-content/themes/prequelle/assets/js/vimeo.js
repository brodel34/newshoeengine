/*!
 * Vimeo
 *
 * Prequelle 1.0.4
 */
/* jshint -W062 */

/* global Vimeo */
var PrequelleVimeo = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			$( '.vimeo-bg' ).each( function() {
				var iframe = $( this )[0],
					player = new Vimeo.Player( iframe );
				
				player.setVolume( 0 );
			
				//player.api( 'play' );
				//setTimeout( function() {
				//	$cover.fadeOut();
				//}, 500 );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		PrequelleVimeo.init();
	} );

} )( jQuery );