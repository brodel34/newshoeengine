/*!
 * FullPage
 *
 * Wolf WPBakery Page Builder Extension 3.1.1 
 */
/* jshint -W062 */

/* global WVCParams, WVC, WVCCounter, WVCYTVideoBg, AOS, $f */
var WVCFullPage = function( $ ) {

	'use strict';

	return {

		initFlag : false,
		isScrolling : false,
		$container : $( '.page-entry-content' ),
		rowSelector : '.wvc-parent-row',
		sectionNames : [],
		fpAnimTime : 900,
		fpEasing : 'swing',
		fpTransitionEffect : 'zoom',
		animationEndTimeOut : null,
		revSliderStarted : [],

		init : function() {

			if ( this.initFlag || ! WVCParams.fullPage ) {
				return;
			}

			this.$container = $( WVCParams.fullPageContainer || '.page-entry-content' );
			this.fpAnimTime = WVCParams.fpAnimTime;
			this.fpEasing = WVCParams.fpEasing;
			this.fpTransitionEffect = WVCParams.fpTransitionEffect;

			this.prepare();
			this.fullPage();

			$( window ).trigger( 'wvc_fullpage_loaded' );

			this.initFlag = true;
		},

		/**
		 * Prepare markup
		 */
		prepare : function() {
			
			setTimeout( function() {
				window.scrollTo( 0, 0 );
			}, 10 );

			var _this = this,
				initialSectionIndex;

			$( 'body' ).addClass( 'wvc-fullpage' );

			/* Set row class and data */
			$( this.rowSelector, this.$container ).each( function( index ) {
				
				var sectionName = $( this ).data( 'row-name' ) || 'Section ' + ( index + 1 );
				_this.sectionNames.push( sectionName );

				$( this ).attr( 'data-section', index + 1 );
				$( this ).addClass( 'wvc-scroll-lock fp-auto-height' );

				/* RevSlider is there */
				if ( $( this ).find( '.wvc-revslider-container-fullscreen' ).length ) {
					$( this ).addClass( 'wvc-fp-section-has-fullwidth-revslider' );
				}
			} );

			WVC.delayWow( this.rowSelector );
			WVC.resetAOS();
		},

		/**
		 * fullPage
		 */
		fullPage : function () {
			
			var _this = this,
				$container = this.$container,
				scrollBar = false,
				noHistory = false,
				toIndex,
				hash;

			$container.fullpage( {
				slidesNavigation: true,
				sectionSelector: _this.rowSelector,
				scrollOverflow: true,
				navigation: false,
				scrollBar: scrollBar,
				scrollingSpeed: _this.fpAnimTime,
				easing: _this.fpEasing,
				verticalCentered: true,
				
				afterRender: function() {

					$( '.wvc-scroll-lock.active' ).addClass( 'wvc-scroll-active' );

					WVC.pausePlayers( false );

					WVC.doAOS( '.wvc-scroll-active' );

					/**
					 * Play first video bg if any
					 */
					_this.playActiveVideoBg();
					_this.handleRevSlider();

					$( '#wvc-one-page-nav a.wvc-fp-nav:first-child' ).addClass( 'wvc-bullet-active' );

					_this.navigation();
					_this.nextNavigation();

					/* Move to section if a hash is found in the URL */
					setTimeout( function() {
						
						hash = window.location.hash;

						if ( '' !== hash ) {
							toIndex = $( '.fp-section' ).index( $( hash ) );
							$.fn.fullpage.moveTo( toIndex + 1 );
						}

						/**
						 * Animate first slide
						 */
						WVC.doWow();
						Waypoint.refreshAll();
						$( '.wvc-scroll-active' ).find( '.lazy-hidden' ).removeClass( 'lazy-hidden' ); // force lazyload

					}, 1000 );
				},
				
				onLeave: function( index, nextIndex, direction ) {

					if ( WVCFullPage.isScrolling ) {
						return false;
					}
					
					WVCFullPage.isScrolling = true;
					WVCFullPage.slideLeaveAnimation( index, nextIndex, direction );

					if ( $( '.wvc-scroll-lock', this.$container ).eq( nextIndex + 1 ).hasClass( 'hidden-scroll' ) ) {
						
						if ( 'up' === direction ) {
							$.fn.fullpage.moveTo( nextIndex - 1 );
						} else {
							$.fn.fullpage.moveTo( nextIndex + 1 );
						}
						return false;
					}
				}
			} );
		},

		/**
		 * Go to next section if any
		 */
		nextNavigation : function() {

			var _this = this,
				index;

			$( document ).on( 'click', '.wvc-fp-nav-next', function( event ) {
				
				event.preventDefault();

				if ( _this.isScrolling ) {
					return;
				}

				index = $( this ).closest( '.wvc-scroll-lock' ).data( 'section' );

				$.fn.fullpage.moveTo( index + 1 );
			} );
		},

		/**
		 * Navigation
		 */
		navigation : function () {

			var _this = this,
				href,
				toIndex;

			$( document ).on( 'click', '.wvc-fp-nav', function( event ) {
				
				event.preventDefault();

				if ( _this.isScrolling ) {
					return;
				}
				
				href = $( this ).attr( 'href' ),
					toIndex = $( '.fp-section' ).index( $( href ) );

				$.fn.fullpage.moveTo( toIndex + 1 );
			} );
		},

		/**
		 * Play active video bg (fullpage script stoped it)
		 */
		playActiveVideoBg : function( $container ) {

			$container = $container || $( '.wvc-scroll-active' );
			
			var video, YTPlayerId, VimeoPlayerId, vimeoPlayer;

			/* HTML video */
			if ( $container.find( '.wvc-video-bg' ).length ) {
				video = $container.find( '.wvc-video-bg' ).get(0);

				if ( video.paused ) {
					video.play();
				}
			
			/* YT video */
			} else if ( $container.find( '.wvc-youtube-player' ).length ) {
				
				setTimeout( function() {
					$container.find( '.wvc-youtube-player' )[0].contentWindow.postMessage( '{"event":"command","func":"' + 'playVideo' + '", "args":""}', '*' );
				}, 200 );

			/* Vimeo video */
			} else if ( $container.find( '.wvc-vimeo-bg' ).length ) {

				setTimeout( function() {
					vimeoPlayer = new Vimeo.Player( $container.find( '.wvc-vimeo-bg' )[0] );
					vimeoPlayer.play();
				}, 200 );
			}
		},

		slideLeaveAnimation : function ( index, nextIndex, direction ) {

			var _this = this,
				$currentSlide = $( '.wvc-scroll-lock[data-section="' + index + '"]', this.$container ),
				$nextSlide = $( '.wvc-scroll-lock[data-section="' + nextIndex + '"]', this.$container ),
				animationEnd = 'webkitAnimationEnd MozAnimation animationend',
				transitionEnd = 'webkitTransitionEnd MozTransition transitionend',
				effect,
				animTime = this.fpAnimTime,
				animOut,
				animIn,
				animInDelay,
				containerOff = this.$container.offset().top,
				timeout,
				dataHash = $nextSlide.attr( 'data-anchor' ),
				player, iframe;

			if ( 'zoom' === this.fpTransitionEffect || 'mix' === this.fpTransitionEffect ) {
			
				effect = 'scaleDown';
			
			} else if ( 'parallax' === this.fpTransitionEffect ) {
				
				effect = 'moveparallax';

			} else if ( 'fade' === this.fpTransitionEffect ) {
				
				effect = 'opacity';
			
			} else if ( 'slide' === this.fpTransitionEffect ) {
				
				effect = 'moveslide';

			} else if ( 'curtain' === this.fpTransitionEffect ) {

				effect = 'movecurtain';

			} else {
				effect = '';
			}

			animOut = effect !== 'scaleDown' ? effect + direction : effect;
			animInDelay = effect === 'scaleDown' ? 0 : 0;

			switch( direction ) {
				case 'up':
					animIn = 'moveFromTop';
					break;
				default:
					animIn = 'moveFromBottom';
			}

			if ( 'zoom' === this.fpTransitionEffect ) {
				
				animOut = animIn + 'trid';
				animIn = animOut + 'In';
				animTime = animTime * 2;
			
			} else if ( 'fade' === this.fpTransitionEffect ) {
				
				animIn = effect + 'In';
				animOut = effect + 'Out';
			}

			_this.playActiveVideoBg( $nextSlide );

			var $outBg = $( '.background-wrapper', $currentSlide );

			this.activateParallax( nextIndex, direction );

			WVC.pausePlayers( false );

			$nextSlide.find( '.wvc-revslider-container' ).show();
			_this.handleRevSlider( $nextSlide );
		
			$nextSlide
				.addClass( 'wvc-scroll-front' )
				.addClass( 'wvc-scroll-active' )
				.addClass( 'wvc-scroll-visible' )
				.addClass( 'wvc-scroll-animating-in' )
				.css( {
					'z-index': 4,
					'animation-name': animIn,
					'animation-duration': animTime + 'ms',
					'animation-delay': '',
					'animation-timing-function': _this.fpEasing,
					'animation-fill-mode': 'both',
					'transition': 'initial',
				} ).off( animationEnd )
				.on( animationEnd, function( event ) {

					if ( event.originalEvent.animationName === animIn ) {
						$( this )
							.addClass( 'wvc-scroll-already' )
							.removeClass( 'wvc-scroll-front' )
							.removeClass( 'wvc-scroll-animating-in' )
							.css( {
								'animation-name': '',
								'animation-duration': '',
								'animation-delay': '',
								'animation-timing-function': '',
								'animation-fill-mode': '',
								'transition': 'initial',
							} );

						$currentSlide
							.removeClass( 'wvc-scroll-active' )
							.add( $outBg )
							.css( {
								'animation-name': '',
								'animation-duration': '',
								'animation-delay': '',
								'animation-timing-function': '',
								'animation-fill-mode': '',
								'transition': 'initial',
							} );

						_this.animationEndAction( index, nextIndex );
					}

					if ( nextIndex > 1 ) {
						$( 'body' ).addClass( 'window-scrolled' );
					} else {
						$( 'body' ).removeClass( 'window-scrolled' );
					}
				} );

			$currentSlide
				.addClass( 'wvc-scroll-animating-out' )
				.removeClass( 'wvc-scroll-front' )
				.css( {
					'z-index': 1,
					'animation-name': animOut,
					'animation-duration': animTime + 'ms',
					'animation-delay': '',
					'animation-timing-function': _this.fpEasing,
					'animation-fill-mode': 'both',
					'transition': 'initial',
					'will-change': 'auto'
				} ).off( animationEnd )
				.on( animationEnd, function( event ) {
					
					/* Hide Revslider */
					$currentSlide.find( '.wvc-revslider-container' ).hide();
					
					if ( event.originalEvent.animationName === animOut ) {
						$currentSlide.removeClass( 'wvc-scroll-animating-out' );
					}
				} );

			$( window ).trigger( 'wvc_fullpage_change', [ $nextSlide ] );

			$( '#wvc-one-page-nav a.wvc-fp-nav' ).removeClass( 'wvc-bullet-active' );
			$( '#wvc-one-page-nav a.wvc-fp-nav[data-index="' + nextIndex + '"]' ).addClass( 'wvc-bullet-active' );
		},

		/**
		 * Start revolution slider or redraw it if already started
		 */
		handleRevSlider : function ( $container ) {
			
			$container = $container || $( '.wvc-scroll-active' );

			if ( $container.find( '.wvc-slider-revolution' ).length ) {
				var _this = this,
					revSliderId =  $container.find( '.wvc-slider-revolution' ).data( 'revslider-id' );

				if ( $.inArray( revSliderId, _this.revSliderStarted ) == -1 ) {

					console.log( 'start' );

					window['revapi' + revSliderId].revstart();

					_this.revSliderStarted.push( revSliderId );

				} else {

					console.log( 'redraw' );
					
					window['revapi' + revSliderId].revredraw();
				}
			}
		},

		activateParallax : function( nextIndex, direction ) {

			var $el = $( '.wvc-scroll-lock[data-section="' + nextIndex + '"]', this.$container ),
				$cell = $( '.fp-tableCell', $el ),
				animationEnd = 'webkitAnimationEnd MozAnimation animationend',
				cellAnim;

			switch( direction ) {
				case 'up':
					cellAnim = 'moveFromTopInner';
					break;
				default:
					cellAnim = 'moveFromBottomInner';
			}

			if ( 'fade' === this.fpTransitionEffect || 'slide' === this.fpTransitionEffect || 'curtain' === this.fpTransitionEffect ) {
				cellAnim = '';
			}

			$cell.css( {
				'animation-name': cellAnim,
				'animation-duration': this.fpAnimTime + 'ms',
				'animation-delay': '',
				'animation-timing-function': this.fpEasing,
				'animation-fill-mode': 'both',
			} ).off( animationEnd )
			.on( animationEnd, function( event ) {
				if ( event.originalEvent.animationName === cellAnim ) {
					$cell
						.css( {
							'animation-name': '',
							'animation-duration': '',
							'animation-delay': '',
							'animation-timing-function': '',
							'animation-fill-mode': '',
						} );
				}
			} );
		},

		animationEndAction : function ( index, nextIndex ) {
			var _this = this,
				$currentSlide = $( '.wvc-scroll-lock[data-section="' + index + '"]', this.$container ),
				$nextSlide = $( '.wvc-scroll-lock[data-section="' + nextIndex + '"]', this.$container ),
				player, iframe,
				event;

			$( '.no-scrolloverflow' ).removeClass( 'no-scrolloverflow' );

			WVC.doWow();
			Waypoint.refreshAll();
			WVC.doAOS();
			
			event = new CustomEvent( 'fp-animation-end' );
			window.dispatchEvent(event);
			
			clearTimeout( _this.animationEndTimeOut );

			if ( $currentSlide.find( '.wvc-ad-disc-container' ).length ) {
				$currentSlide.find( '.wvc-ad-disc-container' ).removeClass( 'animated' );
			}
			
			_this.animationEndTimeOut = setTimeout( function() {
				
				_this.isScrolling = false;
				$( window ).trigger( 'wvc_fullpage_changed' );

			}, 500 );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCFullPage.init();
	} );

} )( jQuery );