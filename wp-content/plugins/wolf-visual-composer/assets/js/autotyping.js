/*!
 * Autotyping
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

var WVCTyped = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			$( '.wvc-typed' ).each( function() {
				var $typed = $( this ),
					strings = $typed.data( 'string' ) || [],
					loop = $typed.data( 'loop' ) || false,
					speed = $typed.data( 'speed' ) || false,
					cursor = $typed.data( 'cursor' ) || '|';

				if ( [] !== strings ) {
					$typed.typed( {
						strings : strings,
						loop : loop,
						typeSpeed : speed,
						cursorChar: cursor,
						contentType: 'html'
					} );
				}
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCTyped.init();
	} );

} )( jQuery );