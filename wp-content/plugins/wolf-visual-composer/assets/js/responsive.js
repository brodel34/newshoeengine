/*!
 * Accordion
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

var WVCResponsive = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			var _this = this;

			this.reponsiveClasses();

			/**
			 * Resize event
			 */
			$( window ).bind( 'wvc_resized', function() {
				_this.reponsiveClasses();
				
			} ).resize();
		},

		reponsiveClasses : function() {

			var $selectors = $( '.wvc-meal, .wvc-recipe, .wvc-workout-program' ),
				$el, width;

			$selectors.each( function() {
				$el = $( this ),
				width = $el.width();

				console.log( 'resized to ' + width );

				if ( 800 > width && 500 < width  ) {

					$( this ).addClass( 'wvc-el-800' );

				} else if ( 500 > width && 380 < width  ) {
					
					$( this ).addClass( 'wvc-el-500' );
					$( this ).removeClass( 'wvc-el-800' );
					$( this ).removeClass( 'wvc-el-380' );

				} else if ( 380 > width ) {
					$( this ).removeClass( 'wvc-el-800' );
					$( this ).removeClass( 'wvc-el-500' );
					$( this ).addClass( 'wvc-el-380' );
				
				} else {
					$( this ).removeClass( 'wvc-el-800' );
					$( this ).removeClass( 'wvc-el-500' );
					$( this ).removeClass( 'wvc-el-380' );
				}
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCResponsive.init();
	} );

} )( jQuery );