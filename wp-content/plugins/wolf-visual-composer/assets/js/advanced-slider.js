/*!
Plugin: Wolf Slider
Version 1.9.4
Author: WolfThemes
Twitter: @wolf_themes
Author URL: https://wolfthemes.com

An enhanced version of flexslider that support video background and caption transition effects
*/
;( function ( window, document, $, undefined ) {

	$.wvcSlider = function( elem, options ) {
		/* jshint unused:false */
		var isTouch = $( 'html' ).hasClass( 'wvc-touch' ),
			ui,
			defaults = {
				isMobile : ( navigator.userAgent.match( /(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i ) ) ? true : false,
				animation : 'fade',
				slideshow : false,
				pauseOnHover: true,
				slideshowSpeed : 4000,
				controlNav : true,
				directionNav : true,
				sliderHeight : '100',
				sliderHeightUnit : '%',
				init: function(){},
				start: function(){}, //Callback: function(slider) - Fires when the slider loads the first slide
				before: function(){}, //Callback: function(slider) - Fires asynchronously with each slider animation
				after: function(){}, //Callback: function(slider) - Fires after each slider animation completes
				end: function(){}, //Callback: function(slider) - Fires when the slider reaches the last slide (asynchronous)
				added: function(){}, //{NEW} Callback: function(slider) - Fires after a slide is added
				removed: function(){} //{NEW} Callback: function(slider) - Fires after a slide is removed
			},

			plugin = this,
			selector = elem.selector,
			$selector = $( selector );

		plugin.settings = {};

		plugin.init = function() {

			plugin.settings = $.extend( {}, defaults, options );

			$selector.flexslider( {
				animation : plugin.settings.animation,
				slideshow : plugin.settings.slideshow,
				pauseOnHover : plugin.settings.pauseOnHover,
				slideshowSpeed : plugin.settings.slideshowSpeed,
				controlNav : plugin.settings.controlNav,
				directionNav : plugin.settings.directionNav,

				init : function () {
					ui.init( plugin.settings.sliderHeight, plugin.settings.sliderHeightUnit ); // set dimensions
					ui.pauseAllVideos();
					plugin.settings.init();
				},

				start : function () {
					
					/**
					 * Play first video BG
					 */
					setTimeout( function() {
						ui.playCurrentVideo();
					}, 500 );
					
					plugin.settings.start();
				},

				before : function () {
					ui.pauseAllVideos();
					plugin.settings.before();
				},

				after : function () {
					ui.playCurrentVideo();
					plugin.settings.after();
				},

				end : function () {
					plugin.settings.end();
				},

				added : function () {
					plugin.settings.added();
				},

				removed : function () {
					plugin.settings.removed();
				}
			} );
		};

		ui = {

			/**
			 * Initialize slider
			 */
			init : function ( value, unit ) {
				var _this = this;

				this.setSliderHeight( value, unit );
				
				$( window ).resize( function() {
					_this.setSliderHeight( value, unit );
				} ).resize();
			},

			/**
			 * Set slider height from options
			 */
			setSliderHeight : function( value, unit ) {
				var _this = this,
					winHeight,
					scrollOffset = 0,
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

				$selector.find( '.slide' ).each( function() {
					$( this ).css( { 'height' : winHeight  } );
				} );
			},

			/**
			 * Play current slide video background
			 */
			playCurrentVideo : function () {

				var _this = this;

				/* Play current HTML5 video */
				if ( $selector.find( '.flex-active-slide .wvc-video-bg' ).length ) {

					var $videoContainer = $( '.flex-active-slide' ),
						$video = $videoContainer.find( '.wvc-video-bg' ),
						video = document.getElementById( $video.attr( 'id' ) );

					if ( ! plugin.settings.isMobile ) {

						$video.get(0).play();

						if ( video.readyState >= video.HAVE_FUTURE_DATA ) {
							$videoContainer.find( '.wvc-slide-video-container' ).css( { 'opacity' : 1 } );
						} else {
							video.addEventListener( 'canplay', function () {
								$videoContainer.find( '.wvc-slide-video-container' ).css( { 'opacity' : 1 } );
							}, false );
						}
					} else {
						$videoContainer.find( '.wvc-video-bg-fallback' ).css( { 'z-index' : 1 } );
						$video.remove();
					}
				}

				/* Play current slide YT video */
				else if ( $selector.find( '.flex-active-slide .wvc-yt-video-bg-play' ).length ) {
					$selector.find( '.flex-active-slide .wvc-yt-video-bg-play' ).trigger( 'click' );
				}

				/* Play current slide Vimeo video */
				else if ( $selector.find( '.flex-active-slide .wvc-vimeo-bg' ).length ) {
					$f( $selector.find( '.flex-active-slide .wvc-vimeo-bg' ).get(0) ).api( 'play' );
				}

				window.dispatchEvent( new Event( 'scroll' ) );
			},

			/**
			 * Pause all videos
			 */
			pauseAllVideos : function () {

				var _this = this,
					$video;

				/* Pause all HTML videos */
				if ( $selector.find( '.wvc-video-bg' ).length ) {
					$selector.find( '.wvc-video-bg' ).each( function () {
						$video = $( this );
						$video.get(0).pause();
					} );
				}

				/* Pause all YT videos */
				$selector.find( '.wvc-yt-video-bg-pause' ).trigger( 'click' );

				/* Pause all Vimeo  videos */
				$selector.find( '.wvc-vimeo-video-bg-container > iframe' ).each( function () {
					$f( this ).api( 'pause' ); // froogaloop
					$f( this ).api( 'setVolume', 0 );
				} );
			},

			/**
			 * Toolbar offset
			 */
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
			}
		};

		plugin.init();
	};

	$.fn.wvcSlider = function( options ) {

		if ( ! $.data( this, '_wvcSlider' ) ) {
			var wvcSlider = new $.wvcSlider( this, options );
			this.data( '_wvcSlider', wvcSlider );
		}
		return this.data( '_wvcSlider' );
	};

}( window, document, jQuery ) );