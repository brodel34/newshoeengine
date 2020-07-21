/*!
 * Galleries
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

var WVCGalleries = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			var _this = this;

			this.masonry();

			$( window ).resize( function() {
				_this.masonry();
			} );

			this.justify();
		},

		masonry : function () {

			if ( ! $( '.wvc-gallery-masonry' ).length && ! $( '.wvc-gallery-metro' ).length ) {
				return;
			}

			var $window = $( window ).width();
			if ( 800 > $window ) {

				if ( $( '.wvc-gallery-isotope' ).length ) {

					$( '.wvc-gallery-isotope' ).isotope( 'destroy' ).removeClass( 'wvc-gallery-isotope' );
				}

			} else {

				$( '.wvc-gallery-masonry' ).imagesLoaded( function() {
					
					if ( ! $( '.wvc-gallery-masonry' ).hasClass( 'wvc-gallery-isotope' ) ) {

						$( '.wvc-gallery-masonry' ).addClass( 'wvc-gallery-isotope' );

						$( '.wvc-gallery-masonry' ).isotope( {
							itemSelector : '.wvc-img-masonry',
							animationEngine : 'best-available',
							layoutMode : 'masonry'
						} );


					} else {

						$( '.wvc-gallery-masonry' ).isotope( 'layout' );

					}
				} );

				$( '.wvc-gallery-metro' ).imagesLoaded( function() {
					if ( ! $( '.wvc-gallery-metro' ).hasClass( 'wvc-gallery-isotope' ) ) {

						$( '.wvc-gallery-metro' ).addClass( 'wvc-gallery-isotope' );

						$( '.wvc-gallery-metro' ).isotope( {
							itemSelector : '.wvc-img-metro',
							animationEngine : 'none',
							layoutMode : 'packery'
						} );

					} else {

						$( '.wvc-gallery-metro' ).isotope( 'layout' );

					}
				} );

			}
		},

		justify : function () {
			if ( $( '.wvc-gallery-justified' ).length ) {

				$( '.wvc-gallery-justified' ).imagesLoaded( function() {
					$( '.wvc-gallery-justified' ).flexImages( {
						rowHeight: 350,
						container: '.wvc-img-justified'
					} );
				} );
			}
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCGalleries.init();
	} );

} )( jQuery );