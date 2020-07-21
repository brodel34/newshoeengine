/*!
 * Post Carousel
 *
 * Prequelle 1.1.8
 */
/* jshint -W062 */
/* global Event */
var PrequelleCarousels = function( $ ) {

	'use strict';

	return {

		init : function () {

			var _this = this;

			this.moduleCarousel();
			this.WolfTestimonialsCarousel();

			/**
			 * Resize event
			 */
			$( window ).resize( function() {
				_this.resizeWolfTestimonials();
			} ).resize();
		},

		/**
		 * Page carousel
		 */
		moduleCarousel : function () {

			var $disabledElements = $( '.entry-link-mask, .entry-link, .woocommerce-LoopProduct-link' );

			$( '.module-carousel' ).each( function() {
				$( this ).flickity( {
					groupCells: true,
					prevNextButtons: false,
					cellSelector: '.entry'
				} );
			} ).on( 'select.flickity', function() {

				setTimeout( function() {
					window.dispatchEvent( new Event( 'scroll' ) );
				}, 500 );

			// Disable link on drag
			} ).on( 'dragStart.flickity', function() {

				$disabledElements.addClass( 'disabled' );

			} ).on( 'dragEnd.flickity', function() {

				setTimeout( function() {
					$disabledElements.removeClass( 'disabled' );
				}, 1000 ); // wait before re-enabling lightbox
			} );
		},

		/**
		 * Resize testimonials quote
		 */
		resizePosts : function () {
			var maxHeight = -1;

			$( '.post-display-carousel .entry-summary-content' ).removeAttr( 'style' );

			$( '.post-display-carousel' ).each( function() {

				$( this ).find( '.entry-summary-content' ).each( function() {
					maxHeight = maxHeight > $( this ).height() ? maxHeight : $( this ).height();
				} );

				$( this ).find( '.entry-summary-content' ).each( function() {
					$( this ).height( maxHeight );
				} );
			} );
		},

		WolfTestimonialsCarousel : function () {
			var $disabledElements = $( '.entry-link' );

			$( '.testimonials-display-carousel' ).each( function() {
				$( this ).flickity( {
					groupCells: true,
					prevNextButtons: false,
					cellSelector: '.entry'
				} );
			} ).on( 'select.flickity', function() {

				setTimeout( function() {
					window.dispatchEvent( new Event( 'scroll' ) );
				}, 500 );

			// Disable link on drag
			} ).on( 'dragStart.flickity', function() {

				$disabledElements.addClass( 'disabled' );

			} ).on( 'dragEnd.flickity', function() {

				setTimeout( function() {
					$disabledElements.removeClass( 'disabled' );
				}, 1000 ); // wait before re-enabling lightbox
			} );
		},

		resizeWolfTestimonials : function () {
			var maxHeight = -1;

			$( '.entry-testimonial .testimonial-content' ).removeAttr( 'style' );

			$( '.entry-testimonial' ).each( function() {

				$( this ).find( '.testimonial-content' ).each( function() {
					maxHeight = maxHeight > $( this ).height() ? maxHeight : $( this ).height();
				} );

				$( this ).find( '.testimonial-content' ).each( function() {
					$( this ).height( maxHeight );
				} );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		PrequelleCarousels.init();
	} );

} )( jQuery );
