/*!
 * BigText
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

var WVCBigText = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			var _this = this;

			_this.bigText();

			$( window ).on( 'wvc_resized', function () {
				_this.bigText();
			} );
		},

		bigText : function() {
			$( '.wvc-bigtext' ).each( function() {
				$( this ).bigtext();
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCBigText.init();
		window.dispatchEvent( new Event( 'resize' ) );
	} );

} )( jQuery );