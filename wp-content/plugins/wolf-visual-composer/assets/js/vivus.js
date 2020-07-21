/*!
 * Vivus
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

/* global Vivus */
var WVCVivus = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			$( '.wvc-vivus' ).each( function() {
				var $svg = $( this ),
					svgId = $svg.attr( 'id' ),
					file = $svg.data( 'file' ),
					duration = $svg.data( 'animation-duration' ) || 100;

				new Vivus( svgId, {
					type: 'delayed',
					duration: duration,
					file: file,
					onReady: function () {
						$svg.css( { 'visibility' : 'visible' } );
					}
				} );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( window ).load( function() {
		WVCVivus.init();
	} );

} )( jQuery );