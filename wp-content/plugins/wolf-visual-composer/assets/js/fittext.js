/*!
 * FitText
 *
 * Wolf WPBakery Page Builder Extension 3.1.1 
 */
/* jshint -W062 */

var WVCFitText = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			$( '.wvc-fittext' ).each( function() {
				var maxFontSize = $( this ).data( 'max-font-size' ) || 60,
					minFontSize = $( this ).data( 'min-font-size' ) || 18,
					compression = $( this ).data( 'font-compression' ) || 1.2;


				$( this ).fitText( compression, { minFontSize: minFontSize + 'px', maxFontSize: maxFontSize + 'px' } );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCFitText.init();
	} );

} )( jQuery );