/*!
 * Infinite scroll blog
 *
 * Prequelle 1.0.4
 */
/* jshint -W062 */
/* global PrequelleParams,
PrequelleUi,
PrequelleMasonry,
PrequelleYTVideoBg,
PrequelleUi,
WPM,
WVCBigText,
WolfCustomPostMeta,
PrequelleAjaxNav,
_gaq, ga,
alert, console,
Event */

var PrequelleLoadPosts = function ( $ ) {
	'use strict';

	return {

		/**
		 * Init blog
		 */
		init : function () {
			this.loadMorePosts();
		},

		loadMorePosts : function () {

			var _this = this;

			$( document ).on( 'click', '.loadmore-button', function( event ) {

				event.preventDefault();

				if ( PrequelleParams.isCustomizer ) {
					event.stopPropagation();
					alert( PrequelleParams.l10n.infiniteScrollDisabledMsg );
					return;
				}

				var $button = $( this ),
					href = $button.attr( 'href' );

				if ( $button.hasClass( 'trigger-loading' ) ) {
					return;
				}

				$button.addClass( 'trigger-loading' );

				$button.html( PrequelleParams.l10n.infiniteScrollMsg ); // loading message

				$.get( href, function( response ) {
					if ( response ) {
						_this.processContent( response, $button );
					} else {
						console.log( 'empty response' );
					}
				} );
			} );
		},

		/**
		 * Process response data
		 */
		processContent : function ( response, $button ) {

			if ( response ) {

				var _this = this,
					//currentRootUrl = $button.data( 'current-url' ),
					href = $button.attr( 'href' ),
					containerId = $button.parent().prev().attr( 'id' ),
					$container = $( '#' + containerId ),
					max = parseInt( $button.attr( 'data-max-pages' ), 10 ),
					newItems,
					$lastItem = $container.find( '.entry:last-child' ),
					lastItemOffsetBottom = $lastItem.offset().top + $lastItem.height(),
					$dom,
					nextPage;

				$dom = $( document.createElement( 'html' ) ); // Create HTML content
				$dom[0].innerHTML = response; // Set AJAX response as HTML dom
				newItems = $dom.find( '#' + containerId ).html(),
				nextPage = parseInt( $dom.find( '.loadmore-button' ).attr( 'data-next-page' ), 10 );

				$container.append( newItems );

				_this.trackPageView( href );

				if ( PrequelleParams.doHashChange ) {
					// Update URL in browser bar
					history.pushState( null, null, href );
				}

				//console.log( max );
				//console.log( nextPage );

				// Update button
				if ( max < nextPage || undefined === nextPage || isNaN( nextPage ) ) {

					$button.html( PrequelleParams.l10n.infiniteScrollEndMsg );

					setTimeout( function() {
						$button.fadeOut( 500, function() {
							$( this ).remove();
						} );
					}, 3000 );

				} else {

					/* Get next page link and update button attrs */
					$.post( PrequelleParams.ajaxUrl, {

						action: 'prequelle_ajax_get_next_page_link',
						href : $button.attr( 'href' )

					}, function( response ) {

						if ( response ) {

							if ( $.parseJSON( response ) ) {

								response = $.parseJSON( response );
								$button.attr( 'data-current-page', response.currentPage );
								$button.attr( 'data-next-page', response.nextPage );
								$button.attr( 'href', response.href );
							}
						}

						$button.removeClass( 'trigger-loading' );
						$button.html( PrequelleParams.l10n.loadMoreMsg );
					} );
				}

				_this.callBack( $container );

				if ( $container.hasClass( 'grid-padding-yes' ) ) {
					lastItemOffsetBottom += 14;
				}

				if ( $container.hasClass( 'display-metro' ) || $container.hasClass( 'display-masonry' ) || $container.hasClass( 'display-masonry_modern' ) ) {

					// Scroll just a bit
					setTimeout( function() {
						_this.scrollToPoint( $( window ).scrollTop() + 200 ); // scroll 200px
					}, 1000 );

				} else {

					// Scroll to new items
					setTimeout( function() {
						_this.scrollToPoint( lastItemOffsetBottom );
					}, 1000 );
				}

				// Resize to recalculate parallax
				setTimeout( function() {
					window.dispatchEvent( new Event( 'resize' ) );
					//console.log( 'OK' );
				}, 1500 );
			}
		},

		/**
		 * Decode URI
		 */
		urldecode : function( url ) {
			var txt = document.createElement( 'textarea' );
				txt.innerHTML = url;
			
			return txt.value;
		},

		/**
		 * Scroll to point smoothly after posts are loaded
		 */
		scrollToPoint : function ( scrollPoint ) {

			$( 'html, body' ).stop().animate( {

				scrollTop: scrollPoint - PrequelleUi.getToolBarOffset()

			}, 1E3, 'swing' );
		},

		/**
		 * Track page view if Google analytics is found
		 */
		trackPageView : function ( url ) {

			if ( 'undefined' !== typeof _gaq ) {
				_gaq.push( [ '_trackPageview', url ] );
			}
			else if ( 'undefined' !== typeof ga ) {
				ga( 'send', 'pageview', { 'page' : url } );
			}
		},

		/**
		 * Callback
		 */
		callBack : function ( $container ) {

			$container = $container || $( '.items' );

			if ( 'undefined' !== typeof PrequelleUi ) {
				PrequelleUi.adjustmentClasses();
				PrequelleUi.resizeVideoBackground();
				PrequelleUi.lazyLoad();
				PrequelleUi.fluidVideos( $container, true );
				PrequelleUi.flexSlider();
				PrequelleUi.lightbox();
				PrequelleUi.addItemAnimationDelay();
				PrequelleUi.parallax();
				PrequelleUi.setInternalLinkClass();

				PrequelleUi.muteVimeoBackgrounds();

				setTimeout( function() {
					PrequelleUi.videoThumbnailPlayOnHover();
				}, 200 );
			}

			/* YT background */
			if ( 'undefined' !== typeof PrequelleYTVideoBg ) {
				PrequelleYTVideoBg.init( $container );
				PrequelleYTVideoBg.playVideo( $container );
			}

			if ( $( '.masonry-container' ).length || $( '.metro-container' ).length ) {
				PrequelleMasonry.masonry();
				PrequelleMasonry.resizeTimer();

				if ( $container.data( 'isotope' ) ) {
					$container.isotope( 'reloadItems' ).isotope();
				}
			}

			if ( $( '.fleximages-container' ).length ) {
				PrequelleMasonry.flexImages();
			}

			/* AJAX nav */
			if ( 'undefined' !== typeof PrequelleAjaxNav ) {
				PrequelleAjaxNav.setAjaxLinkClass();
			}

			/* Wolf Playilst */
			if ( 'undefined' !== typeof WPM ) {
				WPM.init();
			}

			/* Big Text */
			if ( 'undefined' !== typeof WVCBigText ) {
				WVCBigText.init();
			}

			/* Likes post meta */
			if ( 'undefined' !== typeof WolfCustomPostMeta ) {
				WolfCustomPostMeta.checkLikedPosts();
			}

			/* WVC */
			//if ( 'undefined' !== typeof WVC ) {
				//WVC.ajaxCallback();
			//}

			if ( $container.find( '.twitter-tweet' ).length ) {
				$.getScript( 'http://platform.twitter.com/widgets.js' );
			}

			if ( $container.find( '.instagram-media' ).length ) {

				$.getScript( '//platform.instagram.com/en_US/embeds.js' );

				if ( 'undefined' !== typeof window.instgrm  ) {
					window.instgrm.Embeds.process();
				}
			}

			if ( $container.find( 'audio:not(.minimal-player-audio):not(.loop-post-player-audio),video' ).length ) {
				$container.find( 'audio,video' ).mediaelementplayer();
			}
		}
	};

}( jQuery );

;( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		PrequelleLoadPosts.init();
	} );

} )( jQuery );