/*!
 * Tabs
 *
 * Wolf WPBakery Page Builder Extension 3.1.1 
 */
/* jshint -W062 */

var WVCTabs = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			$( '.wvc-tabs' ).each( function() {
				$( '#' + $( this ).attr( 'id' ) ).tabs( {
					select: function( event, ui ) {
						$( ui.panel ).animate( { opacity : 0.1 } );
					},
					show: function( event, ui ) {
						$( ui.panel ).animate( { opacity : 1.0 }, 1000 );
					},
					activate: function( event ,ui ) {
						/* LazyLoad callback */
						if ( 'undefined' !== typeof WVC.lazyLoad ) {
							$( '[class*="lazy-hidden"]' ).lazyLoadXT();
						}
						window.dispatchEvent( new Event( 'resize' ) );
						$( window ).trigger( 'wvc_tab_show' );
					}
				} );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCTabs.init();
	} );

} )( jQuery );