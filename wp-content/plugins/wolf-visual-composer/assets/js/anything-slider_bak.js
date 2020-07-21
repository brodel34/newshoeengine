/*!
 * Anything Slider
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

/* global WVC, WVCParams, WVCSliders */
var WVCAnythingSlider = function( $ ) {

	'use strict';

	return {

		isMobile : WVCParams.isMobile,

		/**
		 * Init UI
		 */
		init : function () {

			if ( $.isFunction( $.flexslider ) ) {

				var _this = this;

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
			var defaultTransition = ( this.isMobile ) ? 'slide' : 'fade';

			$( '.wvc-anything-slider' ).each( function() {
				var $slider = $( this ),
					transition,
					dataAutoplay = $slider.data( 'autoplay' ),
					dataSpeed = $slider.data( 'slideshow-speed' ),
					dataPauseonHover = $slider.data( 'pause-on-hover' ),
					dataTransition = $slider.data( 'transition' ),
					dataHeight = $slider.data( 'height' ),
					dataHeightUnit = $slider.data( 'height-unit' ),
					dataNavbullets = $slider.data( 'nav-bullets' ),
					dataArrows = $slider.data( 'nav-arrows' );

				transition = ( 'auto' === dataTransition ) ? defaultTransition : dataTransition;

				$( '#' + $slider.attr( 'id' ) ).wvcSlider( {
					animation : transition,
					slideshow : dataAutoplay,
					pauseOnHover: dataPauseonHover,
					slideshowSpeed : dataSpeed,
					controlNav : dataNavbullets,
					directionNav : dataArrows,
					sliderHeight : dataHeight,
					sliderHeightUnit : dataHeightUnit,
					animationSpeed: 800,
					
					start : function() {
						WVCAnythingSlider.doWow();
					},

					before : function() {
						WVCAnythingSlider.undoWow();
					},

					after : function() {
						window.dispatchEvent( new Event( 'resize' ) );

						setTimeout( function() {
							WVCAnythingSlider.doWow();
						}, 800 );
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
				wowAnimate.init();
			}
		},

		/**
		 * Reset WOW
		 */
		undoWow : function () {
			$( '.wvc-anything-slide' ).find( '.wvc-delayed-wow' ).fadeIn( 'fast', function() {
				$( this ).css( {
					'visibility' : 'hidden',
					'display' : ''
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