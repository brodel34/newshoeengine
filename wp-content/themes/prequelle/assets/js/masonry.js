/*!
 * Masonry
 *
 * Prequelle 1.0.4
 */
/* jshint -W062 */
/* global PrequelleParams */
var PrequelleMasonry = function( $ ) {

	'use strict';

	return {

		resizeClock : 0,
		resizeClockDone : false,
		bufferPx : 2000,

		init : function() {

			var _this = this;

			this.masonry();
			this.proofGallery();
			this.flexImages();
			this.infiniteScroll();
			this.resizeTimer();

			$( window ).resize( function() {
				_this.masonry();
			} );
		},

		/**
		 * Masonry
		 */
		masonry : function () {

			var _this = this,
				$window = $( window ).width(),
				animationEngine = 'best-available',
				layoutMode = 'masonry';

			// Disable isotope on mobile
			if ( 480 > $window ) {

				if ( $( '.isotope' ).length ) {
					$( '.isotope' ).isotope( 'destroy' ).removeClass( 'isotope' );
				}

				//console.log( 'disable' );
				this.clearResizeTime(); // disable clock

			} else {

				if ( $( '.masonry-container' ).length ) {

					$( '.masonry-container' ).imagesLoaded( function() {
						
						if ( ! $( '.masonry-container' ).hasClass( 'isotope' ) ) {

							$( '.masonry-container' ).addClass( 'isotope' );

							//console.log( 'enable' );

							if ( $( '.masonry-container' ).hasClass( 'metro' ) ) {
								animationEngine = 'none',
								layoutMode = 'packery';
							}

							$( '.masonry-container' ).isotope( {
								itemSelector : '.entry',
								animationEngine : animationEngine,
								layoutMode : layoutMode
							} );

							// Init clock
							_this.clearResizeTime();
							_this.resizeTimer();
						} else {
							//console.log( 'relayout' );
							$( '.masonry-container' ).isotope( 'layout' );
						}
					} );
				}
			}
		},

		/**
		 * Pixproof plugin gallery
		 */
		proofGallery : function () {
			if ( $( '#pixproof_gallery' ).length ) {
				$( '#pixproof_gallery' ).imagesLoaded( function() {
					$( '#pixproof_gallery' ).isotope( {
						itemSelector : '.proof-photo',
						animationEngine : 'none',
						layoutMode : 'masonry'
					} );
				} );
			}
		},

		/**
		 * Flex Images
		 */
		flexImages : function() {

			if ( $( '.fleximages-container' ).length ) {

				$( '.fleximages-container' ).each( function() {

					var $container = $( this );

					$container.imagesLoaded( function() {
						//console.log( 'set do mosaic' );
						$container.flexImages( {
							rowHeight: 350,
							container: '.attachment'
						} );
					} );
				} );
			}
		},

		/**
		 * Trigger window resize every 2 sec 3 times to relayout isotope for other cosmetic features
		 */
		resizeTimer : function () {

			var _this = this;

			_this.resizeTime = setInterval( function() {
				
				_this.resizeClock++;

				$( window ).trigger( 'resize' );

				//console.log( 'clock ' + _this.resizeClock );

				if ( 1 === _this.resizeClock ) {
					//console.log( 'clock init' );
				}

				if ( 3 === _this.resizeClock ) {
					_this.clearResizeTime();
					//console.log( 'clock stop' );
				}

			}, 2000 );
		},

		/**
		 * Clear resize time
		 */
		clearResizeTime : function () {
			clearInterval( this.resizeTime );
			this.resizeClock = 0;
		},

		/**
		 * Inifnite scroll
		 */
		infiniteScroll : function () {

			var  _this = this,
				$container = $( '.items.attachments' ); // pagination

			if ( ! $container.length ) {
				return;
			}

			$container.infinitescroll( {
				state: {
					isDestroyed: false,
					isDone: false,
					isDuringAjax : false
				},
				navSelector  : '.nav-previous',
				nextSelector : '.nav-previous a',
				itemSelector : '.entry-attachment',
				loading: {
					finishedMsg: PrequelleParams.l10n.infiniteScrollEndMsg,
					msgText : PrequelleParams.l10n.infiniteScrollMsg,
					img: PrequelleParams.infiniteScrollGif,
					extraScrollPx: _this.extraScrollPx
				},
				bufferPx : _this.bufferPx
			// callback
			}, function( newElements ) {

				var $newElems = $( newElements ).css( { opacity: 0 } );

				$newElems.imagesLoaded( function() {

					if ( $container.hasClass( 'masonry-container' ) ) {
						$container.isotope( 'appended', $newElems );
					}

					if ( $container.hasClass( 'fleximages-container' ) ) {
						_this.flexImages(); // reset flexImages
					}

					$newElems.animate( { opacity: 1 } );

					$( newElements ).find( 'img' ).lazyLoadXT();

					_this.resizeTimer();
				} );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		PrequelleMasonry.init();
	} );

} )( jQuery );