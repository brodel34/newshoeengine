/* jshint -W062 */
var WolfPortfolio = function ( $ ) {

	'use strict';

	return {

		/**
		 * Init isotope masonry
		 */
		init : function () {

			if ( $( '.works' ).length && $( '.work-item' ).length  ) {

				var mainContainer = $( '.works' ),
					OptionFilter = $( '#work-filter' ),
					OptionFilterLinks = OptionFilter.find( 'a' ),
					selector;

				mainContainer.imagesLoaded( function() {
					mainContainer.isotope( {
						itemSelector : '.work-item'
					} );
				} );

				OptionFilterLinks.click( function() {
					selector = $( this ).attr( 'data-filter' );
					OptionFilterLinks.attr( 'href', '#' );
					mainContainer.isotope( {
						filter : '.' + selector,
						itemSelector : '.work-item',
						layoutMode : 'fitRows',
						animationEngine : 'best-available'
					} );

					OptionFilterLinks.removeClass( 'active' );
					$( this ).addClass( 'active' );
					return false;
				} );
			}
		}
	};

}( jQuery );

;( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WolfPortfolio.init();
	} );

} )( jQuery );