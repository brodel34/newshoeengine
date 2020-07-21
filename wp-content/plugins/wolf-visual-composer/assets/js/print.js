/*!
 * Accordion
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */
/* global WVCParams */
var WVCPrint = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			this.print();
		},

		print : function() {

			$( document ).on( 'click', '.wvc-do-print', function() {

				if ( 'undefined' !== typeof print ) {
					$( this ).parents( '.wvc-printable-element' ).print( {
						globalStyles: false,
						stylesheet: WVCParams.printStylesheet,
						noPrintSelector: '.wvc-no-print'
					} );
				}
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCPrint.init();
	} );

} )( jQuery );