/*!
 * Carousels
 *
 * Requires flickity.js
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

/* global WVCParams */
var WVCCarousels = function( $ ) {

	'use strict';

	return {

		isMobile : false,

		/**
		 * Init UI
		 */
		init : function () {

			this.isMobile = WVCParams.isMobile;

			var _this = this;

			this.testimonials();
			this.carouselGallery();
			this.videoCarousel();
			this.wolfTestimonials();
			this.resizeWolfTestimonials();
			this.postCarousel();

			/**
			 * Resize event
			 */
			$( window ).resize( function() {
				_this.resizeWolfTestimonials();
			} ).resize();
		},

		/**
		 * Image gallery carousel
		 */
		carouselGallery : function () {

			$( '.wvc-gallery-carousel' ).each( function() {
				
				var $carousel = $( this ),
					dataAutoplay = $carousel.data( 'autoplay' ),
					dataSpeed = $carousel.data( 'slideshow-speed' ),
					dataPauseonHover = $carousel.data( 'pause-on-hover' ),
					dataGroupCells = $carousel.data( 'group-cells' ),
					dataNavbullets = $carousel.data( 'nav-bullets' ),
					dataArrows = $carousel.data( 'nav-arrows' );

				if ( true === dataAutoplay ) {
					dataAutoplay = dataSpeed;
				}

				$carousel.flickity( {
					autoPlay : dataAutoplay,
					pauseAutoPlayOnHover: dataPauseonHover,
					prevNextButtons: dataArrows,
					pageDots: dataNavbullets,
					groupCells: dataGroupCells,
					wrapAround: true,
					cellSelector: '.wvc-img-carousel'
				} ).on( 'dragStart.flickity', function() {

					$carousel.find( 'a' ).addClass( 'wvc-disabled' );

				} ).on( 'dragEnd.flickity', function() {

					setTimeout( function() {
						$carousel.find( 'a' ).removeClass( 'wvc-disabled' );
					}, 1000 ); // wait before re-enabling lightbox
				} );
			} );
		},

		/**
		 * Video carousel
		 */
		videoCarousel : function () {

		},

		/**
		 * Testomonials slider
		 */
		testimonials : function () {
			var defaultTransition = ( this.isMobile ) ? 'slide' : 'fade';

			$( '.wvc-testimonials-slider' ).each( function () {

				var $slider = $( this ),
					transition,
					dataAutoplay = $slider.data( 'autoplay' ),
					dataSpeed = $slider.data( 'slideshow-speed' ) || dataAutoplay,
					dataPauseonHover = $slider.data( 'pause-on-hover' ),
					dataTransition = $slider.data( 'transition' ),
					dataNavbullets = $slider.data( 'nav-bullets' ),
					dataArrows = $slider.data( 'nav-arrows' );

				transition = ( 'auto' === dataTransition ) ? defaultTransition : dataTransition;

				if ( dataAutoplay ) {
					dataAutoplay = dataSpeed;
				}

				$( this ).flickity( {
					autoPlay : dataAutoplay,
					pauseAutoPlayOnHover: dataPauseonHover,
					prevNextButtons: dataArrows,
					pageDots: dataNavbullets,
					wrapAround: true,
					imagesLoaded: true,
					cellSelector: '.wvc-testimonal-slide'
				} );
			} );
		},

		/**
		 * Post carousel
		 */
		postCarousel : function() {
			$( '.wvc-last-posts-display-carousel' ).each( function() {
				$( this ).flickity( {
					groupCells: true,
					prevNextButtons: false,
					cellSelector: '.wvc-post-column'
				} );
			} );
		},

		/**
		 * Testimonial post type
		 */
		wolfTestimonials : function () {

			$( '.testimonials-display-carousel').each( function() {
				$( this ).flickity( {
					wrapAround: true,
					groupCells: '77%',
					prevNextButtons: false,
					cellSelector: '.testimonial'
				} );
			} );
		},

		/**
		 * Resize testimonials quote
		 */
		resizeWolfTestimonials : function () {
			var maxHeight = -1;

			$( '.testimonials-display-carousel .testimonial-content' ).removeAttr( 'style' );

			$( '.testimonials-display-carousel' ).each( function() {

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
		WVCCarousels.init();
	} );

} )( jQuery );