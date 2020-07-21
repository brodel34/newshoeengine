/*!
 * Anything Slider
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

/* global WOW, WVCParams, WVCSliders */
var WVCAnythingSlider = function( $ ) {

	'use strict';

	return {

		animationSpeed : 1000,
		isMobile : false,

		/**
		 * Init UI
		 */
		init : function () {

			this.isMobile = WVCParams.isMobile;

			if ( $.isFunction( $.flexslider ) ) {

				this.delayWow();
				this.setSliders();

				/**
				 * Resize event
				 */
				$( window ).resize( function() {
					WVCSliders.fullHeightSlider();
					WVCSliders.slideVideoBackground();
				} ).resize();
			}
		},

		/**
		 * Built overlays structure
		 */
		setSliders : function () {
			var isMobile = this.isMobile,
				defaultTransition = ( isMobile ) ? 'slide' : 'fade',
				animationSpeed = this.animationSpeed;


			$( '.wvc-anything-slider' ).each( function() {
				var $slider = $( this ),
					transition,
					dataAutoplay = $slider.data( 'autoplay' ),
					dataSpeed = $slider.data( 'slideshow-speed' ),
					dataAnimationSpeed = $slider.data( 'slideshow-speed' ) || animationSpeed,
					dataPauseonHover = $slider.data( 'pause-on-hover' ),
					dataTransition = $slider.data( 'transition' ),
					dataHeight = $slider.data( 'height' ),
					dataHeightUnit = $slider.data( 'height-unit' ),
					dataNavbullets = $slider.data( 'nav-bullets' ),
					dataArrows = $slider.data( 'nav-arrows' );

				transition = ( 'auto' === dataTransition ) ? defaultTransition : dataTransition;

				$( '#' + $slider.attr( 'id' ) ).wvcSlider( {
					isMobile : isMobile,
					animation : transition,
					slideshow : dataAutoplay,
					pauseOnHover: dataPauseonHover,
					slideshowSpeed : dataSpeed,
					controlNav : dataNavbullets,
					directionNav : dataArrows,
					sliderHeight : dataHeight,
					sliderHeightUnit : dataHeightUnit,
					animationSpeed: dataAnimationSpeed,
					
					start : function() {
						WVCAnythingSlider.doWow();
					},

					before : function() {
						WVCAnythingSlider.undoWow();
					},

					after : function() {
						WVCAnythingSlider.doWow();
					}
				} );
			} );
		},

		/**
		 * Disable WOW
		 */
		delayWow : function () {
			$( '.wvc-anything-slide' ).each( function() {
				$( '.wvc-wow, .items .post' ).each( function() {
					$( this ).removeClass( 'wvc-wow' ).addClass( 'wvc-delayed-wow' ).css( {
						'visibility' : 'hidden'
					} );
				} );
			} );
		},

		/**
		 * Do animations
		 */
		doWow : function () {
			var wowAnimate,
				doWow = ( WVCParams.forceAnimationMobile || ( ! this.isMobile && 800 < $( window ).width() ) );

			if ( doWow ) {
				wowAnimate = new WOW( {
					boxClass: 'wvc-delayed-wow',
					offset : WVCParams.WOWAnimationOffset
				} ); // init wow for CSS animation

				$( '.wvc-anything-slide.flex-active-slide' ).find( '.wvc-as-content' ).fadeIn( 'fast', function() {
					window.dispatchEvent( new Event( 'resize' ) );
					wowAnimate.init();
				} );
			}
		},

		/**
		 * Reset WOW
		 */
		undoWow : function () {
			$( '.wvc-anything-slide' ).find( '.wvc-as-content' ).fadeOut( 'fast', function() {
				$( '.wvc-anything-slide' ).find( '.wvc-delayed-wow' ).css( {
					'visibility' : 'hidden'
				} );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCAnythingSlider.init();
	} );

} )( jQuery );