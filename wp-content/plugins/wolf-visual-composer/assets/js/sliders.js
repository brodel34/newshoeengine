/*!
 * Sliders
 *
 * Requires flexslider.js
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

/* global WVCParams */
var WVCSliders = function( $ ) {

	'use strict';

	return {

		isMobile : false,

		/**
		 * Init UI
		 */
		init : function () {

			this.isMobile = WVCParams.isMobile;

			if ( $.isFunction( $.flexslider ) ) {

				var _this = this;

				this.advancedSlider();
				this.tabletSlider();
				this.laptopSlider();
				this.desktopSlider();
				this.mobileSlider();

				/**
				 * Resize event
				 */
				$( window ).resize( function() {
					_this.fullHeightSlider();
					_this.tabletSlider();
					_this.laptopSlider();
					_this.desktopSlider();
					_this.mobileSlider();
					_this.slideVideoBackground();
				} ).resize();
			}

			this.flexSlider();
		},

		/**
		 * Advanced Slider
		 */
		advancedSlider : function() {

			var isMobile = this.isMobile,
				defaultTransition = ( this.isMobile ) ? 'slide' : 'fade';

			$( '.wvc-advanced-slider, .wvc-last-posts-big-slider .flexslider' ).each( function() {
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
					isMobile : isMobile,
					animation : transition,
					slideshow : dataAutoplay,
					pauseOnHover: dataPauseonHover,
					slideshowSpeed : dataSpeed,
					controlNav : dataNavbullets,
					directionNav : dataArrows,
					sliderHeight : dataHeight,
					sliderHeightUnit : dataHeightUnit
				} );
			} );
		},

		/**
		 * FlexSlider
		 */
		flexSlider : function() {

			var defaultTransition = ( this.isMobile ) ? 'slide' : 'fade';

			/* Image Slider & Last Posts Slider */
			$( '.wvc-images-slider, .wvc-last-posts-slider .flexslider' ).each( function () {
				var $slider = $( this ),
					transition,
					dataAutoplay = $slider.data( 'autoplay' ),
					dataSpeed = $slider.data( 'slideshow-speed' ),
					dataPauseonHover = $slider.data( 'pause-on-hover' ),
					dataTransition = $slider.data( 'transition' ),
					dataNavbullets = $slider.data( 'nav-bullets' ),
					dataArrows = $slider.data( 'nav-arrows' );

				transition = ( 'auto' === dataTransition ) ? defaultTransition : dataTransition;

				$slider.flexslider( {
					animation: transition,
					slideshow : dataAutoplay,
					pauseOnHover: dataPauseonHover,
					slideshowSpeed : dataSpeed,
					smoothHeight: true,
					directionNav : dataArrows,
					controlNav : dataNavbullets
				} );
			} );

			$( '.wvc-post-gallery-slider' ).each( function () {
				var $slider = $( this );

				$slider.flexslider( {
					animation: defaultTransition,
					slideshow : true,
					pauseOnHover: true,
					slideshowSpeed : 4000,
					smoothHeight: true,
					directionNav : true,
					controlNav : true
				} );
			} );

			$( '.wvc-product-presentation .product-images' ).each( function () {
				var $slider = $( this );

				$slider.flexslider( {
					animation: defaultTransition,
					slideshow : true,
					pauseOnHover: true,
					slideshowSpeed : 4000,
					smoothHeight: true,
					directionNav : true,
					controlNav : false
				} );
			} );

			$( '.wvc-section-slideshow-background' ).each( function () {
				var $slider = $( this ),
					dataSpeed = $slider.data( 'slideshow-speed' );

				$slider.flexslider( {
					animation: 'fade',
					slideshow : true,
					pauseOnHover: false,
					slideshowSpeed : dataSpeed,
					animationSpeed : 1000,
					smoothHeight: false,
					directionNav : false,
					controlNav : false,
					useCSS : false
				} );
			} );
		},

		/**
		 * Last posts big slider
		 *
		 * deprecated. Advanced slider used instead
		 */
		lastPostsBigSlider : function () {

			var _this = this,
				defaultTransition = ( this.isMobile ) ? 'slide' : 'fade';


			$( '.wvc-last-posts-big-slider .flexslider' ).each( function () {

				var $slider = $( this ),
					transition,
					dataAutoplay = $slider.data( 'autoplay' ),
					dataSpeed = $slider.data( 'slideshow-speed' ),
					dataPauseonHover = $slider.data( 'pause-on-hover' ),
					dataTransition = $slider.data( 'transition' ),
					dataNavbullets = $slider.data( 'nav-bullets' ),
					dataArrows = $slider.data( 'nav-arrows' ),
					dataHeight = $slider.data( 'height' ),
					dataUnit = $slider.data( 'height-unit' );

				_this.setSliderHeight( $slider, dataHeight, dataUnit );

				transition = ( 'auto' === dataTransition ) ? defaultTransition : dataTransition;

				$slider.flexslider( {
					animation: transition,
					slideshow : dataAutoplay,
					pauseOnHover: dataPauseonHover,
					slideshowSpeed : dataSpeed,
					smoothHeight: true,
					directionNav : dataArrows,
					controlNav : dataNavbullets
				} );
			} );
		},

		/**
		 * Set element height to full screen
		 */
		setSliderHeight : function( $slider, value, unit ) {
			var _this = this,
				winHeight,
				scrollOffset = _this.getToolBarOffset(),
				bleed = 2;

			winHeight = parseInt( value, 10 );

			if ( 100 === winHeight && '%' === unit ) {
				scrollOffset = _this.getToolBarOffset();
			}

			if ( '%' === unit ) {
				winHeight = Math.floor( $( window ).height() * value / 100 );
			}

			if ( $( '.wpm-sticky-playlist-container' ).length ) {
				scrollOffset += $( '.wpm-sticky-playlist-container' ).height();
			}

			winHeight = winHeight - scrollOffset + bleed;

			$slider.find( '.slide' ).each( function() {
				$( this ).css( { 'height' : winHeight  } );
			} );
		},

		/**
		 * Slider with Tablet Background
		 */
		tabletSlider : function () {

			$( '.wvc-slider-background-tablet' ).each( function() {

				var tabletSliderContainer = $( this ),
					tabletSliderContainerWidth = tabletSliderContainer.width(),
					maxWidth = 625,
					defaultPaddingTop = 101,
					defaultPaddingLeft = 102,
					defaultPaddingRight = 95,
					defaultPaddingBottom = 0,
					newPaddingTop,
					newPaddingLeft,
					newPaddingRight,
					newPaddingBottom,
					newCss,

					colContainer = tabletSliderContainer.parent( '[class*="wolf_col_"]' );

				colContainer.css( { marginBottom : 0 } );

				if ( 822 > tabletSliderContainerWidth ) {

					newPaddingTop = Math.floor( ( tabletSliderContainerWidth / maxWidth ) * defaultPaddingTop );
					newPaddingLeft = Math.floor( ( tabletSliderContainerWidth / maxWidth ) * defaultPaddingLeft );
					newPaddingRight = Math.floor( ( tabletSliderContainerWidth / maxWidth ) * defaultPaddingRight );
					newPaddingBottom = Math.floor( ( tabletSliderContainerWidth / maxWidth ) * defaultPaddingBottom );

					newCss = {

						paddingTop : newPaddingTop,
						paddingLeft : newPaddingLeft,
						paddingRight : newPaddingRight,
						paddingBottom : newPaddingBottom

					};

					$( this ).css( newCss );
				}
			} );
		},

		/**
		 * Slider with Laptop Background
		 */
		laptopSlider : function () {

			$( '.wvc-slider-background-laptop' ).each( function() {

				var laptopSliderContainer = $( this ),
					laptopSliderContainerWidth = laptopSliderContainer.width(),
					maxWidth = 676,
					defaultPaddingTop = 40,
					defaultPaddingLeft = 116,
					defaultPaddingRight = 120,
					defaultPaddingBottom = 73,
					newPaddingTop,
					newPaddingLeft,
					newPaddingRight,
					newPaddingBottom,
					newCss;

				if ( 912 > laptopSliderContainerWidth ) {

					newPaddingTop = Math.floor( ( laptopSliderContainerWidth / maxWidth ) * defaultPaddingTop );
					newPaddingBottom = Math.floor( ( laptopSliderContainerWidth / maxWidth ) * defaultPaddingBottom );
					newPaddingLeft = Math.floor( ( laptopSliderContainerWidth / maxWidth ) * defaultPaddingLeft );
					newPaddingRight = Math.floor( ( laptopSliderContainerWidth / maxWidth ) * defaultPaddingRight );

					newCss = {

						paddingTop : newPaddingTop,
						paddingLeft : newPaddingLeft,
						paddingRight : newPaddingRight,
						paddingBottom : newPaddingBottom

					};

					$( this ).css( newCss );
				}
			} );
		},

		/**
		 * Slider with desktop Background
		 */
		desktopSlider : function () {

			$( '.wvc-slider-background-desktop' ).each( function() {

				var desktopSliderContainer = $( this ),
					desktopSliderContainerWidth = desktopSliderContainer.width(),
					maxWidth = 922,
					defaultPaddingTop = 41,
					defaultPaddingLeft = 42,
					defaultPaddingRight = 44,
					defaultPaddingBottom = 330,
					newPaddingTop,
					newPaddingLeft,
					newPaddingRight,
					newPaddingBottom,
					newCss;

				if ( 1007 > desktopSliderContainerWidth ) {

					newPaddingTop = Math.floor( ( desktopSliderContainerWidth / maxWidth ) * defaultPaddingTop );
					newPaddingBottom = Math.floor( ( desktopSliderContainerWidth / maxWidth ) * defaultPaddingBottom );
					newPaddingLeft = Math.floor( ( desktopSliderContainerWidth / maxWidth ) * defaultPaddingLeft );
					newPaddingRight = Math.floor( ( desktopSliderContainerWidth / maxWidth ) * defaultPaddingRight );

					newCss = {

						paddingTop : newPaddingTop,
						paddingLeft : newPaddingLeft,
						paddingRight : newPaddingRight,
						paddingBottom : newPaddingBottom

					};

					$( this ).css( newCss );
				}
			} );
		},

		/**
		 * Slider with mobile Background
		 */
		mobileSlider : function () {

			$( '.wvc-slider-background-mobile' ).each( function() {

				var mobileSliderContainer = $( this ),
					mobileSliderContainerWidth = mobileSliderContainer.width(),
					maxWidth = 277,
					defaultPaddingTop = 95,
					defaultPaddingLeft = 38,
					defaultPaddingRight = 37,
					defaultPaddingBottom = 103,
					newPaddingTop,
					newPaddingLeft,
					newPaddingRight,
					newPaddingBottom,
					newCss;

				if ( 350 > mobileSliderContainerWidth ) {

					newPaddingTop = Math.floor( ( mobileSliderContainerWidth / maxWidth ) * defaultPaddingTop );
					newPaddingBottom = Math.floor( ( mobileSliderContainerWidth / maxWidth ) * defaultPaddingBottom );
					newPaddingLeft = Math.floor( ( mobileSliderContainerWidth / maxWidth ) * defaultPaddingLeft );
					newPaddingRight = Math.floor( ( mobileSliderContainerWidth / maxWidth ) * defaultPaddingRight );

					newCss = {

						paddingTop : newPaddingTop,
						paddingLeft : newPaddingLeft,
						paddingRight : newPaddingRight,
						paddingBottom : newPaddingBottom

					};

					$( this ).css( newCss );
				}
			} );
		},

		/**
		 * Set element height to full screen
		 */
		fullHeightSlider : function() {
			var _this = this;

			$( '.wvc-fullscreen-slider' ).find( '.slide' ).each( function() {
				$( this ).css( { 'height' : $( window ).height() - _this.getToolBarOffset() } );
			} );
		},

		getToolBarOffset : function () {

			var scrollOffset = 0;

			if ( $( 'body' ).is( '.admin-bar' ) ) {

				if ( 782 < $( window ).width() ) {
					scrollOffset = 32;
				} else {
					scrollOffset = 46;
				}
			}

			return scrollOffset;
		},

		/**
		 * Video background
		 */
		slideVideoBackground : function () {

			var _this = this;

			$( '.wvc-slide-video-container').each( function() {
				var videoContainer = $( this ),
					containerWidth = $( this ).width(),
					containerHeight = $( this ).height(),
					ratioWidth = 640,
					ratioHeight = 360,
					video = $( this ).find( '.wvc-slide-video' ),
					newHeight,
					newWidth,
					newMarginLeft,
					newMarginTop,
					newCss;

				if ( videoContainer.hasClass( 'wvc-youtube-video-bg-container' ) ) {
					video = videoContainer.find( 'iframe' );
					ratioWidth = 560;
					ratioHeight = 315;

				} else {
					if ( _this.isMobile ) {
						videoContainer.find( '.wvc-video-bg-fallback' ).css( { 'z-index' : 1 } );
						video.remove();
						return;
					}
				}

				if ( ( containerWidth / containerHeight ) >= 1.8 ) {
					newWidth = containerWidth;

					newHeight = Math.floor( ( containerWidth/ratioWidth ) * ratioHeight ) + 2;
					newMarginTop =  - ( Math.floor( ( newHeight - containerHeight  ) ) / 2 );
					newMarginLeft =  - ( Math.floor( ( newWidth - containerWidth  ) ) / 2 );

					newCss = {
						width : newWidth,
						height : newHeight,
						marginTop :  newMarginTop,
						marginLeft : newMarginLeft
					};

					video.css( newCss );

				} else {
					newHeight = containerHeight;
					newWidth = Math.floor( ( containerHeight/ratioHeight ) * ratioWidth );
					newMarginLeft =  - ( Math.floor( ( newWidth - containerWidth  ) ) / 2 );

					newCss = {
						width : newWidth,
						height : newHeight,
						marginLeft :  newMarginLeft,
						marginTop : 0
					};

					video.css( newCss );
				}
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCSliders.init();
	} );

} )( jQuery );