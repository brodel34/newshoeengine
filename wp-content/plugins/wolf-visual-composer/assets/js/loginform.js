/*!
 * Tabs
 *
 * Wolf WPBakery Page Builder Extension 3.1.1 
 */
/* jshint -W062 */

var WVCLoginForm = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			$( '.wvc-loginform-tabs' ).each( function() {
				$( '#' + $( this ).attr( 'id' ) ).tabs( {
					select: function(event, ui) {
						$( ui.panel ).animate( {opacity : 0.1} );
					},
					show: function(event, ui) {
						$( ui.panel ).animate( { opacity : 1.0 },1000 );
					}
				} );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCLoginForm.init();
	} );

} )( jQuery );