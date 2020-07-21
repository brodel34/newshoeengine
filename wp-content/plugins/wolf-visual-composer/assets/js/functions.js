/*!
 * Front end plugin methods
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */
/* global DocumentTouch,
WVCParams,
WVCFitText,
WVCFullPage,
WVCBigText,
WVCYTVideoBg,
WVCSliders,
WVCAccordion,
WVCTabs,
WVCToggles,
WVCButtons,
WVCCounter,
WVCMailchimp,
WVCTyped,
WVCCountdown,
WVCCarousels,
WVCTwentyTwenty,
WVCMessage,
WVCVivus,
WVCParticles,
WVCGmaps,
WVCProgressBar,
WVCProcess,
WVCEmbedVideo,
WVCGalleries,
WVCPie,
WVCInteractiveLinks,
WVCInteractiveOverlays,
WVCAlbumTracklist,
WVCAudioButton,
WVCShowaseVerticalCarousel,
WVCLoginForm,
WVCModalWindow,
WVCPrivacyPolicyMessage,
WolfFrameworkJSParams,
WOW,
AOS,
lity,
Vimeo,
objectFitImages,
Event
*/
var WVC = function( $ ) {

	'use strict';

	return {
		body : $( 'body' ),
		isMobile : false,
		isEdge : ( navigator.userAgent.match( /(Edge)/i ) ) ? true : false,
		isApple : ( navigator.userAgent.match( /(Safari)|(iPad)|(iPhone)|(iPod)/i ) && navigator.userAgent.indexOf( 'Chrome' ) === -1 && navigator.userAgent.indexOf( 'Android' ) === -1 ) ? true : false,
		supportSVG : !! document.createElementNS && !! document.createElementNS( 'https://www.w3.org/2000/svg', 'svg').createSVGRect,
		isTouch : 'ontouchstart' in window || window.DocumentTouch && document instanceof DocumentTouch,
		fireAnimation : true,

		/**
		 * Init functions
		 */
		init : function () {

			this.isMobile = WVCParams.isMobile;

			var _this = this;

			this.setClasses();

			this.setAnimationMasks();

			this.videoBackground();
			this.playButton();
			
			this.muteButton(); // mute video backgrounds

			this.fullHeightSection();

			this.rowCosmetic();
			this.rowMargins();

			this.parallax();

			this.fluidVideos();

			this.lightbox();

			this.scrollDownArrow();

			this.smoothScroll();

			this.relGalleryAttr();

			this.maps();

			this.lazyLoad();

			this.onePager();

			this.stickElement();
			this.stickElementResize();

			this.objectFitfallback();

			this.videoOpener();

			this.addResizedEvent();

			this.setVisibleRowClass();
			$( window ).scroll( function() {
				var scrollTop = $( window ).scrollTop();
				_this.setActiveOnePagerBullet( scrollTop );
			} );

			/**
			 * Resize event
			 */
			$( window ).resize( function() {
				_this.winWidthElement();
				_this.fullHeightSection();
				_this.videoBackground();
				_this.scrollDownArrowDisplay();
				_this.rowMargins();
			} ).resize();
		},

		/**
		 * Check if IE
		 */
		isIE : function () {
			var ua = window.navigator.userAgent,
				msie = ua.indexOf( 'MSIE ' ),
				trident = ua.indexOf( 'Trident/' );

			if ( msie > 0 ) {
				return true;
			}

			if ( trident > 0 ) {
				return true;
			}
			return false;
		},

		setClasses : function () {

			if ( this.supportSVG ) {
				$( 'html' ).addClass( 'wvc-svg' );
			}

			if ( this.isTouch ) {
				$( 'html' ).addClass( 'wvc-touch' );
			} else {
				$( 'html' ).addClass( 'wvc-no-touch' );
			}

			if ( this.isMobile ) {
				this.body.addClass( 'wvc-is-mobile' );
			} else {
				this.body.addClass( 'wvc-is-desktop' );
			}

			if ( ( this.isMobile || 800 > $( window ).width() ) && ! WVCParams.forceAnimationMobile ) {
				this.body.addClass( 'wvc-no-animations' );
			}

			if ( this.isApple ) {
				this.body.addClass( 'wvc-is-apple' );
			}

			if ( this.isEdge ) {
			}
		},

		/**
		 * Set mask to animated divs that require one
		 */
		setAnimationMasks : function() {

			var animDelay = 0;

			$( '.uncoverXLeft' ).each( function() {

				$( this ).css( { 'animation-delay' : '' } );
				$( this ).removeClass( 'wvc-wow uncoverXLeft' ).append( '<span class="wvc-animation-mask wvc-wow uncoverXLeft" />' ).show();

				if ( $( this ).css( 'animation-delay' ) ) {
					$( this ).css( { 'animation-delay' : 0 } );
					$( this ).find( '.wvc-animation-mask' ).css( { 'animation-delay' : animDelay + 'ms' } );
					animDelay = animDelay + 200;
				}
			} );

			$( '.uncoverXRight' ).each( function() {
				
				$( this ).css( { 'animation-delay' : '' } );
				$( this ).removeClass( 'wvc-wow uncoverXRight' ).append( '<span class="wvc-animation-mask wvc-wow uncoverXRight" />' ).show();
			
				if ( $( this ).css( 'animation-delay' ) ) {
					$( this ).css( { 'animation-delay' : 0 } );
					$( this ).find( '.wvc-animation-mask' ).css( { 'animation-delay' : animDelay + 200 + 'ms' } );
				}
			} );

			$( '.uncoverYTop' ).each( function() {
				
				$( this ).css( { 'animation-delay' : '' } );
				$( this ).removeClass( 'wvc-wow uncoverYTop' ).append( '<span class="wvc-animation-mask wvc-wow uncoverYTop" />' ).show();
			
				if ( $( this ).css( 'animation-delay' ) ) {
					$( this ).css( { 'animation-delay' : 0 } );
					$( this ).find( '.wvc-animation-mask' ).css( { 'animation-delay' : animDelay + 200 + 'ms' } );
				}
			} );

			$( '.uncoverYBottom' ).each( function() {
				
				$( this ).css( { 'animation-delay' : '' } );
				$( this ).removeClass( 'wvc-wow uncoverYBottom' ).append( '<span class="wvc-animation-mask wvc-wow uncoverYBottom" />' ).show();
			
				if ( $( this ).css( 'animation-delay' ) ) {
					$( this ).css( { 'animation-delay' : 0 } );
					$( this ).find( '.wvc-animation-mask' ).css( { 'animation-delay' : animDelay + 200 + 'ms' } );
				}
			} );
		},

		/**
		 * Detect transition ending
		 */
		transitionEventEnd : function () {
			var t, el = document.createElement( 'transitionDetector' ),
				transEndEventNames = {
					'WebkitTransition' : 'webkitTransitionEnd',// Saf 6, Android Browser
					'MozTransition' : 'transitionend',  // only for FF < 15
					'transition' : 'transitionend'       // IE10, Opera, Chrome, FF 15+, Saf 7+
				};

			for ( t in transEndEventNames ) {
				if ( el.style[t] !== undefined ) {
					return transEndEventNames[t];
				}
			}
		},

		/**
		 * Detect animation ending
		 */
		animationEventEnd : function () {
			var t, el = document.createElement( 'animationDetector' ),

				animations = {
				'animation'      : 'animationend',
				'OAnimation'     : 'oAnimationEnd',
				'MozAnimation'   : 'animationend',
				'WebkitAnimation': 'webkitAnimationEnd'
			};

			for ( t in animations ) {
				if ( el.style[t] !== undefined ) {
					return animations[t];
				}
			}
		},

		/**
		 * Get admin toolbar offset
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

			return parseInt( scrollOffset, 10 );
		},

		/**
		 * Set element height to full screen
		 */
		fullHeightSection : function() {
			var _this = this,
				scrollOffset = _this.getToolBarOffset(),
				bleed = 0;

			if ( $( 'body' ).hasClass( 'is-wpm-bar-player' ) && WVCParams.fullHeightRowDoWPMOffsset ) {
				scrollOffset += $( '.wpm-sticky-playlist-container' ).height();
			}

			$( '.wvc-row-full-height, .fp-section' ).each( function() {
				$( this ).css( { 'min-height' : $( window ).height() - scrollOffset + bleed } );
			} );
		},

		winWidthElement : function () {
			$( '.wvc-winwidth, .wvc-row-bigtext-marquee .wvc-element' ).each( function() {
				$( this ).css( { 'width' : $( window ).width() } );
			} );
		},

		/**
		 * rowMaring
		 */
		rowMargins : function() {

			if ( 800 < $( window ).width() ) {
				$( '.wvc-row' ).each( function() {
					var $row = $( this ),
						gap = $row.data( 'column-gap' ),
						columnBaseWidthInt,
						newWidth,
						gutter;

					if ( '' !== gap && 'undefined' !== typeof( gap ) && $row.hasClass( 'wvc-row-layout-column' ) ) {

						gutter = gap / 2;

						$row.find( '> .wvc-row-wrapper > .wvc-row-content' ).css( {
							'width': 'calc(100% + '+ gap +'px )',
							'margin-left': -gutter
						} );

						$row.find( '> .wvc-row-wrapper > .wvc-row-content > .wvc-columns-container > .wvc-column' ).each( function() {
							columnBaseWidthInt = $( this ).data( 'base-width-int' );

							newWidth = ( columnBaseWidthInt * 100 / 12 );

							$( this ).css( {
								'width': 'calc(' + newWidth + '% - '+ gap +'px)',
								'margin-left' : gutter + 'px',
								'margin-right' : gutter + 'px'
							} );
						} );
					}
				} );
				$( '.wvc-row-inner' ).each( function() {
					var $row = $( this ),
						gap = $row.data( 'column-gap' ),
						columnBaseWidthInt,
						newWidth,
						gutter;

					if ( '' !== gap ) {

						gutter = gap / 2;

						$row.find( '> .wvc-row-inner-wrapper > .wvc-row-inner-content' ).css( {
							'width': 'calc(100% + '+ gutter +'px )',
							'margin-left': -gutter/2
						} );

						$row.find( '> .wvc-row-inner-wrapper > .wvc-row-inner-content > .wvc-column' ).each( function() {
							columnBaseWidthInt = $( this ).data( 'base-width-int' );
							newWidth = ( columnBaseWidthInt * 100 / 12 );

							$( this ).css( {
								'width': 'calc(' + newWidth + '% - '+ gap +'px)',
								'margin-left' : gutter + 'px',
								'margin-right' : gutter + 'px'
							} );
						} );
					}
				} );
			} else {
				$( '.wvc-row-content, .wvc-row-inner-content, .wvc-column' ).css( {
					'width': '',
					'margin-left' : '',
					'margin-right' : ''
				} );
			}
		},

		/**
		 * Row settings adjustment
		 */
		rowCosmetic : function() {
			$( '.wvc-col-12' ).each( function() {
				var $col = $( this );

				if ( $col.closest( '.wvc-row' ).hasClass( 'wvc-parent-row' ) ) {
					$col.closest( '.wvc-row' ).addClass( 'wvc-row-one-column' );
				}
			} );
			$( '.wvc-stick-it.wvc-column-container' ).parents( '.wvc-row-layout-block' ).addClass( 'wvc-no-equal-height' );
			$( '.wvc-columns-container' ).each( function() {

				if ( 4 === $( this ).find( '.wvc-col-3' ).length ) {
					
					$( this ).addClass( 'wvc-columns-container-4-cols' );
				
				} else if ( 6 === $( this ).find( '.wvc-col-2' ).length ) {
					
					$( this ).addClass( 'wvc-columns-container-6-cols' );
				}
			} );
		},

		/**
		 * Fluid Video wrapper
		 */
		fluidVideos : function ( container ) {

			container = container || $( '.wvc-row' );

			var videoSelectors = [
				'iframe[src*="player.vimeo.com"]',
				'iframe[src*="youtube.com"]',
				'iframe[src*="youtube-nocookie.com"]',
				'iframe[src*="youtu.be"]',
				'iframe[src*="kickstarter.com"]',
				'iframe[src*="screenr.com"]',
				'iframe[src*="blip.tv"]',
				'iframe[src*="dailymotion.com"]',
				'iframe[src*="viddler.com"]',
				'iframe[src*="qik.com"]',
				'iframe[src*="revision3.com"]',
				'iframe[src*="hulu.com"]',
				'iframe[src*="funnyordie.com"]',
				'iframe[src*="flickr.com"]',
				'embed[src*="v.wordpress.com"]',
				'iframe[src*="videopress.com"]'
			];

			container.find( $( videoSelectors.join( ',' ) ).not( '.wvc-vimeo-bg, .vimeo-bg' ) ).wrap( '<span class="wvc-fluid-video" />' );
			$( '.rev_slider_wrapper' ).find( videoSelectors.join( ',' ) ).unwrap(); // disabled for revslider videos
			$( '.wvc-fluid-video' ).parent().addClass( 'wvc-fluid-video-container' );
		},

		/**
		 * Video Background
		 */
		videoBackground : function () {

			var _this = this;

			$( '.wvc-video-bg-container').each( function() {
				var videoContainer = $( this ),
					containerWidth = $( this ).width(),
					containerHeight = $( this ).height(),
					ratioWidth = 640,
					ratioHeight = 360,
					$video = $( this ).find( '.wvc-video-bg' ),
					newHeight,
					newWidth,
					newMarginLeft,
					newMarginTop,
					newCss;

				if ( videoContainer.hasClass( 'wvc-youtube-video-bg-container' ) || videoContainer.hasClass( 'wvc-vimeo-video-bg-container' ) ) {

					$video = videoContainer.find( 'iframe' );
					ratioWidth = 560;
					ratioHeight = 315;

				} else {
				}

				/* Landscape */
				if ( ( containerWidth / containerHeight ) >= 1.8 ) {
					
					newWidth = containerWidth;

					newHeight = Math.ceil( ( containerWidth/ratioWidth ) * ratioHeight ) + 2;
					newMarginTop =  - ( Math.ceil( ( newHeight - containerHeight  ) ) / 2 );
					newMarginLeft =  - ( Math.ceil( ( newWidth - containerWidth  ) ) / 2 );

					newCss = {
						width : newWidth,
						height : newHeight,
						marginTop :  newMarginTop,
						marginLeft : newMarginLeft
					};

					$video.css( newCss );

				/* Portrait */
				} else {

					newHeight = containerHeight;
					newWidth = Math.ceil( ( containerHeight/ratioHeight ) * ratioWidth );
					newMarginLeft =  - ( Math.ceil( ( newWidth - containerWidth  ) ) / 2 );

					newCss = {
						width : newWidth,
						height : newHeight,
						marginLeft :  newMarginLeft,
						marginTop : 0
					};

					$video.css( newCss );
				}
			} );
		},

		/**
		 * Video play button
		 */
		playButton : function () {

			$( '.wvc-video-bg-play-button' ).on( 'click', function () {
				var $button = $( this ),
					$section = $button.parents( '.wvc-section' ),
					$video = $section.find( '.wvc-video-bg' ),
					videoId = $video.attr( 'id' ),
					video = document.getElementById( videoId ),
					videoSelector = $video;

				if ( videoSelector.hasClass( 'paused' ) ) {
					video.play();
					videoSelector.removeClass( 'paused' );
					$button.removeClass( 'pause' );
				} else {
					video.pause();
					videoSelector.addClass( 'paused' );
					$button.addClass( 'pause' );
				}
			} );
		},

		/**
		 * Video mute button
		 */
		muteButton : function () {

			$( '.wvc-bg-video-mute-equalizer' ).each( function () {
				$( this ).html( '<div class="wvc-bg-video-mute-equalizer-bar-1 wvc-bg-video-mute-equalizer-bar"></div>\
				<div class="wvc-bg-video-mute-equalizer-bar-2 wvc-bg-video-mute-equalizer-bar"></div>\
				<div class="wvc-bg-video-mute-equalizer-bar-3 wvc-bg-video-mute-equalizer-bar"></div>\
				<div class="wvc-bg-video-mute-equalizer-bar-4 wvc-bg-video-mute-equalizer-bar"></div>' );
			} );

			$( '.wvc-row-video-bg-mute-button' ).on( 'click', function () {
				
				var $button = $( this ),
					$row = $button.parents( '.wvc-parent-row' ),
					$video,
					video,
					YTPlayerId,
					VimeoPlayerId;

				if ( $button.hasClass( 'wvc-row-v-bg-mute-sh' ) ) {

					$video = $row.find( '.wvc-video-bg' );
					video = $video[0];

					if ( video.muted ) {

						video.muted = false;

					} else {
						video.muted = true;
					}

					$row.toggleClass( 'wvc-video-bg-is-unmute wvc-video-bg-is-mute' );

				} else if ( $button.hasClass( 'wvc-row-v-bg-mute-yt' ) ) {

					$video = $row.find( '.wvc-youtube-bg' ),
						YTPlayerId = $video.parent().data( 'yt-bg-element-id' );

					if ( $row.hasClass( 'wvc-video-bg-is-mute' ) ) {
						
						if ( 'undefined' !== typeof WVCYTVideoBg ) {
							WVCYTVideoBg.players[YTPlayerId].unMute();
						}

					} else {
						if ( 'undefined' !== typeof WVCYTVideoBg ) {
							WVCYTVideoBg.players[YTPlayerId].mute();
						}
					}

					$row.toggleClass( 'wvc-video-bg-is-unmute wvc-video-bg-is-mute' );

				} else if ( $button.hasClass( 'wvc-row-v-bg-mute-vimeo' ) ) {

					$video = $row.find( '.wvc-vimeo-bg' );
					video = $video[0],
						VimeoPlayerId = $video.data( 'vimeo-bg-element-id' );

					if ( $row.hasClass( 'wvc-video-bg-is-mute' ) ) {

						if ( 'undefined' !== typeof WVCVimeo ) {
							WVCVimeo.players[VimeoPlayerId].setVolume( 1 );
						}
					
					} else {
						
						if ( 'undefined' !== typeof WVCVimeo ) {
							WVCVimeo.players[VimeoPlayerId].setVolume( 0 );
						}
					}

					$row.toggleClass( 'wvc-video-bg-is-unmute wvc-video-bg-is-mute' );
				}
			} );
		},

		/**
		 * Use AOS plugin to reveal animation on page scroll (new)
		 */
		AOS : function ( selector ) {

			var wowAnimate,
				doWow = ( WVCParams.forceAnimationMobile || ( ! this.isMobile && 800 < $( window ).width() ) ),
				disable = ! doWow;

			selector = selector || '#content';

			if ( 'undefined' !== typeof AOS ) {

				$( selector ).find( '.aos-disabled' ).each( function() {
				} );

				AOS.init( {
					disable: disable
				} );
			}
		},

		/**
		 * reset AOS
		 */
		resetAOS : function ( selector ) {

			selector = selector || '#content';

			$( selector ).find( '.aos-animate' ).each( function() {
				$( this ).removeClass( 'aos-init aos-animate' );
				$( this ).addClass( 'aos-disabled' );
			} );
		},

		/**
		 * reinit AOS
		 */
		doAOS : function( selector ) {

			if ( 'undefined' !== typeof AOS ) {
				$( selector ).find( '.aos-disabled' ).removeClass( 'aos-disabled' );
				AOS.refresh();
			}
		},

		/**
		 * Use Wow plugin to reveal animation on page scroll
		 */
		wowAnimate : function () {

			var wowAnimate,
				doWow = ( WVCParams.forceAnimationMobile || ( ! this.isMobile && 800 < $( window ).width() ) );

			if ( 'undefined' !== typeof WOW && doWow ) {
				wowAnimate = new WOW( {
					boxClass: 'wvc-wow',
					offset : WVCParams.WOWAnimationOffset
				} ); // init wow for CSS animation
				wowAnimate.init();
			}
		},

		/**
		 *  Parallax Background
		 */
		parallax : function () {

			var smallScreen = ( ( 800 > $( window ).width() || this.isMobile ) && WVCParams.parallaxNoSmallScreen );

			/*
			@todo
			https://github.com/nk-o/jarallax/#disable-on-mobile-devices
			*/

			if ( ! smallScreen ) {
				$( '.wvc-parallax' ).jarallax();

				$( '.wvc-video-parallax' ).each( function() {
					var videoStartTime = $( this ).data( 'video-start-time' ) || 0,
						videoEndTime = $( this ).data( 'video-end-time' ) || 0;

					$( this ).jarallax( {
						videoStartTime : videoStartTime,
						videoEndTime : videoEndTime
					} );
				} );
			}
		},

		/**
		 *  Lightbox
		 */
		lightbox : function () {

			$( '.wvc-lightbox:not(.wvc-disabled)' ).swipebox();
			$( '.wvc-gallery .wvc-lightbox' ).each( function() { $( this ).attr( 'rel', 'gallery' ); } );
		},

		/**
		 * Trick to customize the embed tweet
		 */
		loadTwitter : function() {

			var tweet = $( '.twitter-tweet-rendered' ),
				tweetItems = $( '.post.is-tweet' );

			setTimeout( function() {
				if ( tweet.length ) {
					tweet.each( function() {
						$( this ).removeAttr( 'style' )
						.attr( 'height' , 'auto' )
						.animate( { 'opacity' : 1 } );
					} );
				}

				if ( tweetItems.length ) {
					tweetItems.each( function() {
						$( this ).animate( { 'opacity' : 1} );
					} );
				}
			}, 500 );
		},

		/**
		 * Instagrams fade in
		 */
		loadInstagram : function() {
			var instagramItems = $( '.post-item.is-instagram' );

			if ( instagramItems.length ) {
				instagramItems.each( function() {
					$( this ).animate( { 'opacity' : 1} );
				} );
			}
		},

		/**
		 * Hide the scroll down arrow if height is too small
		 */
		scrollDownArrowDisplay : function () {
			var $arrow,
				$section,
				$sectionInner,
				sectionInnerHeight = 0,
				marginOffset = 250;

			$( '.wvc-arrow-down' ).each( function() {
				$arrow = $( this ),
				$section = $arrow.parent(),
				$sectionInner = $section.find( '.wvc-section-inner' ),
				sectionInnerHeight = 0;

				$sectionInner.find( '.wvc-row' ).each( function() {
					sectionInnerHeight += $( this ).height();
				} );

				if ( $( window ).height()  <= sectionInnerHeight + marginOffset ) {

					$arrow.hide();

				} else {
					$arrow.show();
				}
			} );
		},

		/**
		 * Smooth scroll
		 */
		smoothScroll : function () {
			
			var _this = this;

			$( document ).on( 'click', '.wvc-nav-scroll a, .wvc-scroll, .wvc-scroll a', function( event ) {

				event.preventDefault();
				event.stopPropagation();

				var menuOffset = 0,
					toolBarOffset = _this.getToolBarOffset(),
					$this = $( this ),
					href = $this.attr( 'href' ),
					$targetSection,
					hash;

				if ( href && href.indexOf( '#' ) !== -1 ) {

					hash = href.substring( href.indexOf( '#' ) + 1 );

					$targetSection = $( '#' + hash );

					if ( $targetSection.hasClass( 'wvc-row-full-height' ) ) {

						menuOffset = 0;

					} else {
						menuOffset = _this.getMenuOffsetFromTheme();
					}

					if ( $targetSection.length ) {

						$( 'body' ).addClass( 'wvc-scrolling' );

						$( 'html, body' ).stop().animate( {

							scrollTop: $targetSection.offset().top - toolBarOffset - menuOffset

						}, parseInt( WVCParams.smoothScrollSpeed, 10 ), WVCParams.smoothScrollEase, function() {

							if ( '' !== hash ) {
								history.pushState( null, null, '#' + hash );
							}

							setTimeout( function() {
								$( 'body' ).removeClass( 'wvc-scrolling' );
								$( window ).trigger( 'wvc_has_scrolled' )
							}, 500 );
						} );
					}
				}
			} );
		},

		/**
		 * Display an arrow to scroll to the next section
		 */
		scrollDownArrow : function () {
			var _this = this,
				$this,
				$arrow,
				rowClass = '.wvc-parent-row',
				$section = $( rowClass ),
				$nextSection,
				$targetSection,
				menuOffset = 0,
				toolBarOffset = 0,
				sectionOffsetTop,
				hash;

			$section.each( function( i ) {

				$this = $( this ),
				$arrow = $this.find( '.wvc-arrow-down, .wvc-scroll-next-row' ),
				$nextSection = $section.eq( i + 1 ),
				toolBarOffset = _this.getToolBarOffset();

				if ( $arrow && 0 < $nextSection.length ) {

					$this.addClass( 'wvc-has-next-section' );

					$arrow.on( 'click', function( event ) {

						event.preventDefault();
						event.stopPropagation();

						_this.scrollToNextSection( $( this ).closest( rowClass ) );
					} );

				} else {
					$this.addClass( 'wvc-no-next-section' );
				}
			} );
		},

		/**
		 * Scroll to next section
		 */
		scrollToNextSection : function( $currentRow, callback ) {

			var _this = this,
				sectionOffsetTop,
				toolBarOffset = this.getToolBarOffset(),
				callback = callback || function(){},
				menuOffset,
				hash,
				$targetSection;
			$targetSection = $( '.wvc-parent-row' ).eq( $( '.wvc-parent-row' ).index( $currentRow ) + 1 );
			sectionOffsetTop = parseInt( $targetSection.offset().top, 10 );

			if ( $targetSection.hasClass( 'wvc-row-full-height' ) ) {

				menuOffset = 0;

			} else {
				menuOffset = _this.getMenuOffsetFromTheme();
			}

			if ( $targetSection.attr( 'id' ) ) {
				hash = $targetSection.attr( 'id' );
			}

			$( 'body' ).addClass( 'wvc-scrolling' );

			$( 'html, body' ).stop().animate( {

				scrollTop: sectionOffsetTop - toolBarOffset - menuOffset

			}, parseInt( WVCParams.smoothScrollSpeed, 10 ), WVCParams.smoothScrollEase, function() {

				if ( '' !== hash && 'undefined' !== typeof hash ) {
					history.pushState( null, null, '#' + hash );
				}

				setTimeout( function() {
					$( 'body' ).removeClass( 'wvc-scrolling' );
					$( window ).trigger( 'wvc_has_scrolled' )
				}, 500 );
				
				callback();
			} );
		},

		/**
		 * Get menu offset from Theme if available
		 */
		getMenuOffsetFromTheme : function () {

			var menuOffset = 0;

			if ( 'undefined' !== typeof WolfFrameworkJSParams ) {
				if ( WolfFrameworkJSParams.menuOffsetMobile && $( 'body' ).hasClass( 'mobile' ) ) {

					menuOffset = WolfFrameworkJSParams.menuOffsetMobile;
				} else if ( WolfFrameworkJSParams.menuOffsetBreakpoint && ! $( 'body' ).hasClass( 'desktop' ) ) {

					menuOffset = WolfFrameworkJSParams.menuOffsetBreakpoint;
				} else if ( WolfFrameworkJSParams.menuOffsetDesktop ) {

					menuOffset = WolfFrameworkJSParams.menuOffsetDesktop;
				} else if ( WolfFrameworkJSParams.menuOffset ) {

					menuOffset = WolfFrameworkJSParams.menuOffset;
				}
			}

			return parseInt( menuOffset, 10 );
		},

		/**
		 * Set gallery rel attribute for HTML validation
		 */
		relGalleryAttr : function () {
			$( '.wolf-images-gallery .wvc-image-inner, .wvc-item-price-image-container a' ).each( function() {
				if ( $( this ).data( 'wvc-rel' ) ) {
					$( this ).attr( 'rel', $( this ).data( 'wvc-rel' ) );
				}
			} );
		},

		/**
		 * Google map fix to avoid scroll
		 */
		maps : function () {
			$( '.wvc-map-container' ).click( function () {
				$( '.wvc-map-container iframe' ).css( 'pointer-events', 'auto' );
			} );

			$( '.wvc-map-container' ).mouseleave( function() {
				$( '.wvc-map-container iframe' ).css( 'pointer-events', 'none' );
			} );
		},

		/**
		 * Lazy load gallery image
		 */
		lazyLoad : function () {

			$( 'img.wvc-lazy-hidden' ).lazyLoadXT();
		},

		/**
		 * Provide compatibility for browser unsupported features
		 */
		objectFitfallback : function () {

			if ( this.isEdge && 'undefined' !== typeof objectFitImages ) {
				objectFitImages();
			}
		},

		/**
		 * One Pager
		 */
		onePager : function() {

			if ( $( 'body' ).hasClass( 'wvc-one-pager' ) ) {
				
				$( 'body' ).prepend( '<div id="wvc-one-page-nav" />' );

				var bulletClass = 'wvc-scroll wvc-one-page-nav-bullet', i = 0;

				if ( WVCParams.fullPage ) {
					bulletClass = 'wvc-fp-nav wvc-one-page-nav-bullet';
				}

				$( '.wvc-parent-row[data-row-name]' ).each( function( index ) {
					i++

					var $row = $( this ),
						id = $row.attr( 'id' ),
						name = $row.data( 'row-name' );

					if ( id ) {
						$( '#wvc-one-page-nav' ).append( '<a data-index="' + i + '" class="' + bulletClass + '" href="#' + id + '"><span class="wvc-one-page-nav-bullet-tip">' + name + '</span></a>' );
					}
				} );
			} else {
				$( '#wvc-one-page-nav' ).remove();
			}
		},

		/**
		 * Set active menu item
		 */
		setActiveOnePagerBullet : function ( scrollTop ) {

			if ( WVCParams.fullPage ) {
				return;
			}

			var bulletItems = $( '#wvc-one-page-nav a' ),
				bulletItem,
				sectionOffset,
				threshold = 150, i;

			for ( i = 0; i < bulletItems.length; i++ ) {

				bulletItem = $( bulletItems[ i ] );

				if ( $( bulletItem.attr( 'href' ) ).length ) {

					sectionOffset = $( bulletItem.attr( 'href' ) ).offset().top;

					if ( scrollTop > sectionOffset - threshold && scrollTop < sectionOffset + threshold ) {
						bulletItems.removeClass( 'wvc-bullet-active' );
						bulletItem.addClass( 'wvc-bullet-active' );
					}
				}
			}
		},

		/**
		 * Set one page bullets skin
		 */
		setOnePagerBulletSkin : function () {

			if ( ! $( '#wvc-one-page-nav' ).length || $( 'body' ).hasClass( 'wvc-fullpage' ) ) {
				return
			}

			var $body = $( 'body' );

			if ( $( '.wvc-row-visible' ).first().hasClass( 'wvc-font-dark' ) ) {
				$body.addClass( 'page-nav-bullet-dark wvc-page-nav-bullet-dark' );
			} else {
				$body.removeClass( 'page-nav-bullet-dark wvc-page-nav-bullet-dark' );
			}
		},

		/**
		 * Stick element
		 */
		stickElement : function() {

			if ( this.isMobile ) {
				return;
			}

			if ( $.isFunction( $.fn.stick_in_parent ) && ! this.isMobile ) {

				var _this = this, offset;

				$( '.wvc-stick-it' ).each( function() {
					if ( $( this ).closest( '.wvc-row' ).hasClass( 'wvc-row-layout-column' ) ) {

						offset = 35 + _this.getToolBarOffset();
					} else {
						offset = _this.getToolBarOffset();
					}

					$( this ).stick_in_parent( {
						offset_top : offset,
						parent : '.wvc-row-content',
						spacer: '.wvc-column',
						bottoming: true,
						inner_scrolling: false
					} );
				} );
			}
		},

		/**
		 * Reset sticky elements on resize
		 */
		stickElementResize : function() {

			var _this = this;

			if ( this.isMobile ) {
				return;
			}

			setTimeout( function() {

				$( window ).on( 'resize', function() {

					if ( 800 < $( window ).width() ) {
						$( '.wvc-stick-it' ).parent().attr( 'style', '' );
						_this.stickElement();
						$( '.wvc-stick-it' ).trigger( 'sticky_kit:recalc' );

					} else {
						$( '.wvc-stick-it' ).trigger( 'sticky_kit:detach' );
						$( '.wvc-stick-it' ).parent().attr( 'style', '' );
					}
				} );

			}, 1000 );
		},

		/**
		 * Video Opener
		 */
		videoOpener : function () {
			if ( 'undefined' !== typeof lity ) {
				$( document ).on( 'click', '.wvc-video-opener', lity );
			}
		},

		/**
		 * Pause other players when clicking on particular links
		 *
		 * Freeze every players
		 */
		pausePlayers : function( pauseAudio ) {

			pauseAudio = ( typeof pauseAudio !== 'undefined' ) ? pauseAudio : true;

			var iframe,
				player,
				YTPlayerId,
				VimeoPlayerId;

			/* Stop HTML video expect video bg */
			$( 'video:not(.wvc-video-bg):not(.video-bg)' ).trigger( 'pause' );

			/* Stop YT iframe */
			$( '.wvc-yt iframe' ).each( function() {
				this.contentWindow.postMessage( '{"event":"command","func":"' + 'pauseVideo' + '", "args":""}', '*' );
			} );

			/* Stop Vimeo iframe */
			$( '.wvc-vimeo iframe' ).each( function() {
				VimeoPlayerId = $( this ).data( 'vimeo-bg-element-id' );
				if ( 'undefined' !== typeof WVCVimeo && WVCVimeo.players[ VimeoPlayerId ] ) {
					WVCVimeo.players[ VimeoPlayerId ].pause();
				}
			} );

			/* Stop HTML5 BG */
			if ( $( '.wvc-video-bg' ).length ) {
				$( '.wvc-video-bg' ).each( function() {
					$( this ).trigger( 'pause' ).addClass( 'wvc-vbg-paused' );
				} );
			}

			/* Stop YT BG */
			if ( $( '.wvc-youtube-bg' ).length ) {
				$( '.wvc-youtube-bg' ).each( function () {
					YTPlayerId = $( this ).parent().data( 'yt-bg-element-id' );
					if ( 'undefined' !== typeof WVCYTVideoBg && WVCYTVideoBg.players[ YTPlayerId ] ) {
						WVCYTVideoBg.players[ YTPlayerId ].pauseVideo();
					}
				} );
			}
			
			/* Stop Vimeo BG */
			if ( $( '.wvc-vimeo-bg' ).length ) {
				$( '.wvc-vimeo-bg' ).each( function () {
					VimeoPlayerId = $( this ).data( 'vimeo-bg-element-id' );
					if ( 'undefined' !== typeof WVCVimeo && WVCVimeo.players[ VimeoPlayerId ] ) {
						WVCVimeo.players[ VimeoPlayerId ].pause();
					}
				} );
			}

			if ( pauseAudio ) {
				/* Pause all audio */
				$( 'audio:not(.nav-player)' ).trigger( 'pause' );

				/* Album tracklist button class */
				$( '.wvc-ati-play-button' ).removeClass( 'wvc-ati-track-playing' );
			}

			/* Pause audio button anyway */
			$( '.wvc-audio-button' ).each( function() {
				
				var defaultText = $( this ).data( 'text' );
				
				$( this ).removeClass( 'wvc-audio-button-player-playing' );
				$( this ).find( 'span' ).html( defaultText );
			} );
		},

		/**
		 * Restart video BG
		 */
		restartVideoBackgrounds : function() {

			/* HTML5 video */
			if ( $( '.wvc-video-bg' ).length ) {
				$( '.wvc-video-bg' ).each( function() {
					$( this ).trigger( 'play' ).removeClass( 'wvc-vbg-paused' );
				} );
			}

			/* YT */
			if ( $( '.wvc-youtube-bg' ).length ) {
				$( '.wvc-youtube-bg' ).each( function () {
					if ( 'undefined' !== typeof WVCYTVideoBg ) {
						WVCYTVideoBg.players[ $( this ).parent().data( 'yt-bg-element-id' ) ].playVideo();
					}
				} );
			}

			/* Vimeo BG */
			if ( $( '.wvc-vimeo-bg' ).length ) {
				$( '.wvc-vimeo-bg' ).each( function () {
					if ( 'undefined' !== typeof WVCVimeo ) {
						WVCVimeo.players[ $( this ).data( 'vimeo-bg-element-id' ) ].play();
					}
				} );
			}
		},

		/**
		 * Pause other players when clicking on particular links
		 */
		pausePlayersButton : function() {
			var _this = this,
				selectors = '.wvc-embed-video-play-button';

			$( document ).on( 'click', selectors, function() {
				_this.pausePlayers();
			} );
		},

		/**
		 * Scroll down on mousewheel down for full height header
		 */
		scrollDownMousewheel : function() {
			
			if ( this.isMobile ) {
				return;
			}

			var _this = this;

			$( '.wvc-row-mousewheel-scroll-down:first-child' ).on( 'mousewheel DOMMouseScroll', function( e ) {
				if ( typeof e.originalEvent.detail == 'number' && e.originalEvent.detail !== 0 ) {
					if ( e.originalEvent.detail > 0 ) {
						_this.scrollToNextSection( $( this ) );
					} else if ( e.originalEvent.detail < 0 ) {
					}
				} else if ( typeof e.originalEvent.wheelDelta == 'number' ) {
					if ( e.originalEvent.wheelDelta < 0 ) {
						_this.scrollToNextSection( $( this ) );
					} else if ( e.originalEvent.wheelDelta > 0 ) {
					}
				}
			} );
		},

		/**
		 * Unset animations
		 */
		delayWow : function ( selector ) {
			
			var doWow = ( WVCParams.forceAnimationMobile || ( ! this.isMobile && 800 < $( window ).width() ) );

			selector = selector || '#content';

			if ( doWow ) {
				$( selector ).each( function() {
					$( selector ).find( '.wvc-wow, .wow, .wvc-delayed-wow, .items .entry:not([data-aos])' ).each( function() {
						$( this ).removeClass( 'wvc-wow animated' ).addClass( 'wvc-delayed-wow' ).css( {
							'visibility' : 'hidden'
						} );
					} );
				} );
			}
		},

		/**
		 * Reset Animations
		 */
		doWow : function () {
			var wowAnimate,
				doWow = ( WVCParams.forceAnimationMobile || ( ! this.isMobile && 800 < $( window ).width() ) );

			if ( 'undefined' !== typeof WOW && doWow ) {
				wowAnimate = new WOW( {
					boxClass: 'wvc-delayed-wow',
					offset : WVCParams.WOWAnimationOffset
				} ); // init wow for CSS animation
				wowAnimate.init();
			}
		},

		/**
		 * Function to fire on page load
		 */
		pageLoad : function () {

			this.loadInstagram();
			this.loadTwitter();

			window.dispatchEvent( new Event( 'scroll' ) );
			window.dispatchEvent( new Event( 'resize' ) );

			this.fullHeightSection();

			$( 'body' ).addClass( 'wvc-loaded' );

			if ( this.fireAnimation ) {
				this.wowAnimate();
				this.AOS();
			}
		},

		/**
		 * Add resized event
		 */
		addResizedEvent : function () {

			var resizeTimer = 0;

			$( window ).on( 'resize', function() {

				clearTimeout( resizeTimer );
				resizeTimer = setTimeout(function() {

					$( window ).trigger( 'wvc_resized' );

				}, 750 );
			} );
		},

		/**
		 * Set visible row class
		 */
		setVisibleRowClass : function () {

			$( '.wvc-parent-row' ).on( 'inview', function( event, isInView ) {
				
				if ( isInView && ! $( this ).parent().hasClass( 'wvc-modal-window' )  ) {

					$( this ).addClass( 'wvc-row-visible' );
				
				} else {
					$( this ).removeClass( 'wvc-row-visible' );
				}
			} );
		},

		/**
		 * AJAX Callback
		 *
		 * Reinitiate all plugins.
		 * This function can be called after an AJAX request to restore all JS functionality
		 */
		ajaxCallback : function () {

			this.init();
			this.fullHeightSection();
			this.onePager();
			if ( 'undefined' !== typeof WVCResponsive ) {
				WVCResponsive.init();
			}
			if ( 'undefined' !== typeof WVCYTVideoBg ) {
				WVCYTVideoBg.init();
			}
			if ( 'undefined' !== typeof WVCVimeo ) {
				WVCVimeo.init();
			}
			if ( 'undefined' !== typeof WVCFitText ) {
				WVCFitText.init();
			}
			if ( 'undefined' !== typeof WVCFullPage ) {
				WVCFullPage.init();
			}
			if ( 'undefined' !== typeof WVCBigText ) {
				WVCBigText.init();
			}
			if ( 'undefined' !== typeof WVCSliders ) {
				WVCSliders.init();
			}
			if ( 'undefined' !== typeof WVCAccordion ) {
				WVCAccordion.init();
			}
			if ( 'undefined' !== typeof WVCTabs ) {
				WVCTabs.init();
			}
			if ( 'undefined' !== typeof WVCToggles ) {
				WVCToggles.init();
			}
			if ( 'undefined' !== typeof WVCButtons ) {
				WVCButtons.init();
			}
			if ( 'undefined' !== typeof WVCCounter ) {
				WVCCounter.init();
			}
			if ( 'undefined' !== typeof WVCMailchimp ) {
				WVCMailchimp.init();
			}
			if ( 'undefined' !== typeof WVCTyped ) {
				WVCTyped.init();
			}
			if ( 'undefined' !== typeof WVCCountdown ) {

				WVCCountdown.init();
				$( '.wvc-countdown-container' ).addClass( 'wvc-countdown-container-loaded' );
			}
			if ( 'undefined' !== typeof WVCCarousels ) {
				WVCCarousels.init();
			}
			if ( 'undefined' !== typeof WVCTwentyTwenty ) {
				WVCTwentyTwenty.init();
			}
			if ( 'undefined' !== typeof WVCMessage ) {
				WVCMessage.init();
			}
			if ( 'undefined' !== typeof WVCVivus ) {
				WVCVivus.init();
			}
			if ( 'undefined' !== typeof WVCParticles ) {
				WVCParticles.init();
			}
			if ( 'undefined' !== typeof WVCGmaps ) {
				WVCGmaps.init();
			}
			if ( 'undefined' !== typeof WVCPie ) {
				WVCPie.init();
			}
			if ( 'undefined' !== typeof WVCProgressBar ) {
				WVCProgressBar.init();
			}
			if ( 'undefined' !== typeof WVCProcess ) {
				WVCProcess.init();
			}
			if ( 'undefined' !== typeof WVCInteractiveLinks ) {
				WVCInteractiveLinks.init();
			}
			if ( 'undefined' !== typeof WVCInteractiveOverlays ) {
				WVCInteractiveOverlays.init();
			}
			if ( 'undefined' !== typeof WVCEmbedVideo ) {
				WVCEmbedVideo.init();
			}
			if ( 'undefined' !== typeof WVCGalleries ) {
				WVCGalleries.init();
			}
			if ( 'undefined' !== typeof WVCAlbumTracklist ) {
				WVCAlbumTracklist.init();
			}
			if ( 'undefined' !== typeof WVCAudioButton ) {
				WVCAudioButton.init();
			}
			if ( 'undefined' !== typeof WVCShowaseVerticalCarousel ) {
				WVCShowaseVerticalCarousel.init();
			}
			if ( 'undefined' !== typeof WVCBMIC ) {
				WVCBMIC.init();
			}
			if ( 'undefined' !== typeof WVCLoginForm ) {
				WVCLoginForm.init();
			}
			if ( 'undefined' !== typeof WVCModalWindow ) {
				WVCModalWindow.init();
			}
			if ( 'undefined' !== typeof WVCPrivacyPolicyMessage ) {
				WVCPrivacyPolicyMessage.init();
			}
			if ( 'undefined' !== typeof WVCPrint ) {
				WVCPrint.init();
			}
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVC.init();
	} );

	$( window ).load( function() {
		WVC.pageLoad();
	} );

} )( jQuery );