/*!
 * Additional Theme Methods
 *
 * Prequelle 1.0.4
 */
/* jshint -W062 */

/* global PrequelleParams, PrequelleUi, WVC, Cookies, Event, WVCParams, CountUp */
var Prequelle = function( $ ) {

	'use strict';

	return {
		initFlag : false,
		isEdge : ( navigator.userAgent.match( /(Edge)/i ) ) ? true : false,
		isWVC : 'undefined' !== typeof WVC,
		isMobile : ( navigator.userAgent.match( /(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i ) ) ? true : false,
		loaded : false,

		/**
		 * Init all functions
		 */
		init : function () {

			if ( this.initFlag ) {
				return;
			}

			var _this = this;

			this.isMobile = PrequelleParams.isMobile;

			this.specialButton();
			this.transitionCosmetic();
			this.quickView();
			this.toggleVerticalBarOverlay();
			this.hamburgerIcon();
			this.loginPopup();
			this.startPercent();
			this.stickyProductDetails();

			if ( this.isWVC ) {
				WVC.delayWow( '#vertical-bar-overlay-content' );
				WVC.resetAOS( '#vertical-bar-overlay-content' );
			
				$( window ).on( 'wvc_fullpage_changed', function( event ) {
					WVC.resetAOS( '#vertical-bar-overlay-content' );
				} );
			}

			$( window ).on( 'wwcq_product_quickview_loaded', function( event ) {
			} );

			$( window ).scroll( function() {
				var scrollTop = $( window ).scrollTop();
				_this.backToTopSkin( scrollTop );
			} );

			this.initFlag = true;
		},

		/**
		 * Hamburger icon hook
		 */
		hamburgerIcon : function () {
			$( window ).on( 'prequelle_overlay_menu_toggle_button_click', function( event, $button ) {

				//console.log( $button );

				if ( $button.hasClass( 'hamburger-icon-vertical-bar' ) ) {
					if ( $( 'body' ).hasClass( 'overlay-menu-toggle' ) ) {
						$( '.vertical-bar-hamburger' ).removeClass( 'h-open' );
					} else {
						$button.parent().addClass( 'h-open' );
					}
				}
			} );
		},

		specialButton : function () {

			$( document ).on( 'mouseenter', '.prequelle-button-special', function() {
				$( this ).removeClass( 'out' ).addClass( 'over' );
			} ).on( 'mouseleave', '.prequelle-button-special', function() {
				$( this ).removeClass( 'over' ).addClass( 'out' );
			} );
		},

		/**
		 * Toggle vertical bar overlay
		 */
		toggleVerticalBarOverlay : function () {

			var _this = this,
				$body = $( 'body' );

			$( '.toggle-vertical-bar-overlay' ).on( 'click', function( event ) {
				event.preventDefault();

				if ( $body.hasClass( 'vertical-bar-overlay-toggle' ) ) {

					$body.removeClass( 'vertical-bar-overlay-toggle' );
					$( '.vertical-bar-hamburger' ).removeClass( 'h-open' );

					if ( _this.isWVC ) {

						$( '#vertical-bar-overlay' ).one( PrequelleUi.transitionEventEnd(), function() {
							
							//console.log( 'delay wow' );
							setTimeout( function() {
								WVC.delayWow( '#vertical-bar-overlay-content' );
								WVC.resetAOS( '#vertical-bar-overlay-content' );
							}, 200 );
						} );
					}
				
				} else {

					$body.removeClass( 'vertical-bar-panel-toggle' );
					$body.removeClass( 'vertical-bar-newsletter-toggle' );
					$body.removeClass( 'loginform-popup-toggle' );
					$body.removeClass( 'overlay-menu-toggle' );

					$body.addClass( 'vertical-bar-overlay-toggle' );
					$( this ).parent().addClass( 'h-open' );

					if ( _this.isWVC ) {

						WVC.delayWow( '#vertical-bar-overlay-content' );
						WVC.resetAOS( '#vertical-bar-overlay-content' );

						$( '#vertical-bar-overlay' ).one( PrequelleUi.transitionEventEnd(), function() {
							//console.log( 'do wow' );
							WVC.doWow();
							WVC.doAOS( '#vertical-bar-overlay-content' );
						} );
					}
				}
			} );

			$( '.toggle-vertical-bar-panel' ).on( 'click', function( event ) {
				event.preventDefault();

				if ( $body.hasClass( 'vertical-bar-panel-toggle' ) ) {
				
					$body.removeClass( 'vertical-bar-panel-toggle' );
					$( '.vertical-bar-hamburger' ).removeClass( 'h-open' );
			
				} else {

					$body.removeClass( 'vertical-bar-overlay-toggle' );
					$body.removeClass( 'vertical-bar-newsletter-toggle' );
					$body.removeClass( 'loginform-popup-toggle' );
					$body.removeClass( 'overlay-menu-toggle' );

					$body.addClass( 'vertical-bar-panel-toggle' );
					$( this ).parent().addClass( 'h-open' );
				}
			} );

			$( '.toggle-vertical-bar-newsletter' ).on( 'click', function( event ) {
				event.preventDefault();
				
				if ( $body.hasClass( 'vertical-bar-newsletter-toggle' ) ) {

					$body.removeClass( 'vertical-bar-newsletter-toggle' );

				} else {
					$body.removeClass( 'vertical-bar-panel-toggle' );
					$body.removeClass( 'vertical-bar-overlay-toggle' );
					$body.removeClass( 'loginform-popup-toggle' );
					$body.removeClass( 'overlay-menu-toggle' );

					$body.addClass( 'vertical-bar-newsletter-toggle' );
				}
			} );

			$( window ).on( 'prequelle_breakpoint prequelle_searchform_toggle', function() {
				$body.removeClass( 'vertical-bar-panel-toggle' );
				$body.removeClass( 'vertical-bar-overlay-toggle' );
				$body.removeClass( 'vertical-bar-newsletter-toggle' );
				$body.removeClass( 'loginform-popup-toggle' );
				$body.removeClass( 'overlay-menu-toggle' );
				$( '.vertical-bar-hamburger' ).removeClass( 'h-open' );
			} );
		},

		loginPopup : function() {

			var $body = $( 'body' );

			$( document ).on( 'click', '.account-item-icon-user-not-logged-in, .close-loginform-button', function( event ) {
				event.preventDefault();

				if ( $body.hasClass( 'loginform-popup-toggle' ) ) {

						$body.removeClass( 'loginform-popup-toggle' );

				} else {
					$body.removeClass( 'vertical-bar-panel-toggle' );
					$body.removeClass( 'vertical-bar-overlay-toggle' );
					$body.removeClass( 'vertical-bar-newsletter-toggle' );
					$body.removeClass( 'overlay-menu-toggle' );

					$body.addClass( 'loginform-popup-toggle' );
				}
			} );

			$( document ).mouseup( function( event ) {

				if ( 1 !== event.which ) {
					return;
				}

				var $container = $( '#loginform-overlay-content' );

				if ( ! $container.is( event.target ) && $container.has( event.target ).length === 0 ) {
					$body.removeClass( 'loginform-popup-toggle' );
				}
			} );
		},

		/**
		 * Check back to top color
		 */
		backToTopSkin : function( scrollTop ) {
			
			if ( scrollTop < 550 ) {
				return;
			}

			$( '.wvc-row' ).each( function() {

				if ( $( this ).hasClass( 'wvc-font-light' ) && ! $( this ).hasClass( 'wvc-row-bg-transparent' ) ) {

						var $button = $( '#back-to-top' ),
						buttonOffset = $button.position().top + $button.width() / 2 ,
						sectionTop = $( this ).offset().top - scrollTop,
						sectionBottom = sectionTop + $( this ).outerHeight();

					if ( sectionTop < buttonOffset && sectionBottom > buttonOffset ) {
						$button.addClass( 'back-to-top-light' );
					} else {
						$button.removeClass( 'back-to-top-light' );
					}
				}
			} );
		},

		/**
		 * Product quickview
		 */
		quickView : function () {

			$( document ).on( 'added_to_cart', function( event, fragments, cart_hash, $button ) {
				if ( $button.hasClass( 'quickview-product-add-to-cart' ) ) {
					//console.log( 'good?' );
					$button.attr( 'href', PrequelleParams.WooCommerceCartUrl );
					$button.find( 'span' ).attr( 'title', PrequelleParams.l10n.viewCart );
					$button.removeClass( 'ajax_add_to_cart' );
				}
			} );
		},

		stickyProductDetails : function() {
			if ( $.isFunction( $.fn.stick_in_parent ) ) {
				if ( $( 'body' ).hasClass( 'sticky-product-details' ) ) {
					$( '.entry-single-product .summary' ).stick_in_parent( {
						offset_top : parseInt( PrequelleParams.portfolioSidebarOffsetTop, 10 ) + 40
					} );
				}
			}
		},

		/**
		 * Overlay transition
		 */
		transitionCosmetic : function() {

			$( document ).on( 'click', '.internal-link:not(.disabled)', function( event ) {

				if ( ! event.ctrlKey ) {

					event.preventDefault();

					var $link = $( this );

					$( 'body' ).removeClass( 'mobile-menu-toggle overlay-menu-toggle offcanvas-menu-toggle vertical-bar-panel-toggle vertical-bar-overlay-toggle vertical-bar-newsletter-toggle loginform-popup-toggle' );
					$( 'body' ).addClass( 'loading transitioning' );

					Cookies.set( PrequelleParams.themeSlug + '_session_loaded', true, { expires: null } );

					if ( $( '.prequelle-loader-overlay' ).length ) {
						$( '.prequelle-loader-overlay' ).one( PrequelleUi.transitionEventEnd(), function() {
							Cookies.remove( PrequelleParams.themeSlug + '_session_loaded' );
							window.location = $link.attr( 'href' );
						} );
					} else {
						window.location = $link.attr( 'href' );
					}
				}
			} );
		},

		/**
		 * Star counter loader
		 */
		startPercent : function() {

			if ( $( '#prequelle-percent' ).length ) {

				var _this = this,
					$line = $( '#prequelle-loading-line' ),
					progressNumber = 'prequelle-percent',
					$progressNumber = $( '#' + progressNumber ),
					duration = 3,
					numAnimText,
					options = {
						useEasing: true,
						useGrouping: true,
						separator: ',',
						decimal: '.',
						suffix: '%'
					};
				
				$progressNumber.addClass( 'prequelle-percent-show' ).one( PrequelleUi.transitionEventEnd(), function() {
					
					$line.addClass( 'move-line' );
					numAnimText = new CountUp( progressNumber, 0, 100, 0, duration, options );
					
					numAnimText.start( function() {
						$progressNumber
							.removeClass( 'prequelle-percent-show' )
							.addClass( 'prequelle-percent-hide' )
							.one( PrequelleUi.transitionEventEnd(), function() {

							$( '.prequelle-loading-block' ).css( {
								'height' : '100%'
							} );

							$( '#prequelle-loading-before' ).one( PrequelleUi.transitionEventEnd(), function() {
								_this.reveal();
							} );
						} );
					} );
				} );
			}
		},

		reveal : function() {

			var _this = this;

			$( 'body' ).addClass( 'loaded reveal' );
			_this.fireContent();

			setTimeout( function() {
				$( '#prequelle-loading-line' ).removeAttr( 'style' ).removeClass( 'move-line' );
				$( '#prequelle-loading-before' ).removeAttr( 'style' );
				$( '#prequelle-loading-after' ).removeAttr( 'style' );
				PrequelleUi.videoThumbnailPlayOnHover();
			}, 1000 );
		},

		/**
		* Page Load
		*/
		loadingAnimation : function () {

			var _this = this,
				delay = 50;

		    	if ( $( '#prequelle-loading-line' ).length ) {
		    		return;
		    	}

			setTimeout( function() {

				$( 'body' ).addClass( 'loaded' );

				if ( $( '.prequelle-loader-overlay' ).length ) {

					$( 'body' ).addClass( 'reveal' );

					$( '.prequelle-loader-overlay' ).one( PrequelleUi.transitionEventEnd(), function() {

						_this.fireContent();

						setTimeout( function() {

							$( 'body' ).addClass( 'one-sec-loaded' );

							PrequelleUi.videoThumbnailPlayOnHover();
						}, 100 );
					} );
				} else {

					$( 'body' ).addClass( 'reveal' );

					_this.fireContent();

					setTimeout( function() {

						$( 'body' ).addClass( 'one-sec-loaded' );

						PrequelleUi.videoThumbnailPlayOnHover();
					}, 100 );
				}
			}, delay );
 		},

		fireContent : function () {
			
			var _this = this;

			// Animate
			$( window ).trigger( 'page_loaded' );
			PrequelleUi.wowAnimate();
			window.dispatchEvent( new Event( 'resize' ) );
			window.dispatchEvent( new Event( 'scroll' ) ); // Force WOW effect
			$( window ).trigger( 'just_loaded' );
			$( 'body' ).addClass( 'one-sec-loaded' );

			setTimeout( function() {
				if ( _this.isWVC ) {
					WVC.resetAOS( '#vertical-bar-overlay-content' );
				}
			}, 1000 );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		Prequelle.init();
	} );

	$( window ).load( function() {
		Prequelle.loadingAnimation();
	} );

} )( jQuery );