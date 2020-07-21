/*!
 * Toggles
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

var WVCToggles = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			$( '.wvc-toggle-title span' ).on( 'click', function() {

				var $this = $( this ),
					container = $this.parents( '.wvc-toggle' ),
					content = container.find( '.wvc-toggle-content' );

				if ( container.hasClass( 'wvc-toggle-open' ) ) {

					content.slideUp( 'fast' );

					setTimeout( function() {
						container.removeClass( 'wvc-toggle-open' );
					}, 500 );

				} else {
					setTimeout( function() {
						container.removeClass( 'wvc-toggle-close' );
						container.addClass( 'wvc-toggle-open' );
					}, 500 );

					content.slideDown( 'fast' );
				}
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCToggles.init();
	} );

} )( jQuery );