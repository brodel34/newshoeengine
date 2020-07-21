/*!
 * Interactive LInks
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

/* global WVC, WVCParams, WVCYTVideoBg, WVCVimeo, Vimeo */
var WVCShowaseVerticalCarousel = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			this.build();
			this.interaction();
		},

		/**
		 * Build markup
		 */
		build : function() {

			var _this = this;

			$( '.wvc-showcase-vertical-carousel' ).each( function() {

				var $container = $( this ),
					$holder = $container.find( '.wvc-showcase-vertical-carousel-bg-holder' );

				$container.closest( '.wvc-column' ).addClass( 'wvc-column-has-svc' );
				$container.find( '.wvc-showcase-vertical-carousel-item:first-child' ).addClass( 'wvc-svc-active' );

				$container.find( '.wvc-showcase-vertical-carousel-item' ).each( function( index ) {
					
					var $this =  $( this ),
						src = $this.data( 'bg-src' ),
						data = $this.data( 'bg-atts' ),
						bgType = data['type'],
						$bgContent;

					data['action'] = 'wvc_ajax_get_bg_markup';

					$holder
						.append( '<div class="wvc-svc-bg" data-bg-index="' + index + '" />' );

					$bgContent = $( '[data-bg-index="' + index + '"]' );

					$.post( WVCParams.ajaxUrl, data, function( response ) {

						if ( response ) {
													
							$bgContent.append( response );

							_this.initVideoBg( $bgContent );
							window.dispatchEvent( new Event( 'resize' ) );

							if ( 0 === index ) {
								
								$bgContent.addClass( 'wvc-svc-bg-active' );
							
							} else if ( $bgContent.length === index ) {

								$holder.removeClass( 'wvc-il-bg-holder-loading' );
							}

						} else {
							console.log( 'AJAX error' );
						}
					} );
				} );
			} );
		},

		/**
		 * Interaction on mouse hover
		 */
		interaction : function () {

			var _this = this;

			$( document ).on( 'hover', '.wvc-svc-item-link', function() {

				var $link = $( this ),
					$item = $link.parent(),
					item = document.getElementById( $item.attr( 'id' ) ),
					$container = $item.closest( '.wvc-showcase-vertical-carousel' ),
					index = $container.find( '.wvc-showcase-vertical-carousel-item' ).index( item );

				$container.addClass( 'wvc-loading' );

				if ( $item.hasClass( '.wvc-svc-active' ) ) {
					return;
				}

				$container.find( '.wvc-showcase-vertical-carousel-item' ).removeClass( 'wvc-svc-active' );
				$item.addClass( 'wvc-svc-active' );

				_this.pauseAllVideos( $( '.wvc-showcase-vertical-carousel' ) );

				$container.find( '.wvc-svc-bg' ).removeClass( 'wvc-svc-bg-active' );
				$container.find( '.wvc-svc-bg' ).eq( index ).addClass( 'wvc-svc-bg-active' );

				_this.startCurrentVideo( $( '.wvc-svc-bg-active' ) );

				setTimeout( function() {
					$container.removeClass( 'wvc-loading' );
				}, 500 );
			} );
		},

		/**
		 * Init & Stop video bg on first load
		 */
		initVideoBg : function( $container ) {

			var $iframe = $container.find( 'iframe' ),
				$video = $container.find( 'video' ),
				YTPlayerId,
				VimeoPlayerId,
				timeOut = 2000;

			/* YT */
			if ( $container.find( '.wvc-youtube-video-bg-container' ).length ) {

				YTPlayerId = $container.find( '.wvc-youtube-video-bg-container' ).data( 'yt-bg-element-id' );

				WVCYTVideoBg.init( $container );

				setTimeout( function() {
					if ( 'undefined' !== typeof WVCYTVideoBg && WVCYTVideoBg.players[ YTPlayerId ] ) {
						WVCYTVideoBg.players[YTPlayerId].pause();
					}
				}, timeOut );

			/* Vimeo */
			} else if ( $iframe.length && $iframe.hasClass( 'wvc-vimeo-bg' ) ) {
				
				VimeoPlayerId = $( this ).data( 'vimeo-bg-element-id' );

				WVCVimeo.init( $container );

				setTimeout( function() {
					if ( 'undefined' !== typeof WVCVimeo && WVCVimeo.players[ VimeoPlayerId ] ) {
						WVCVimeo.players[ VimeoPlayerId ].pause();
					}
				}, timeOut );

			/* Self Hosted */
			} else if ( $video.length ) {

				setTimeout( function() {
					$video.trigger( 'play' );
				}, timeOut );
			}
		},

		/**
		 * Start active video background
		 */
		startCurrentVideo : function( $container ) {
			
			var $iframe = $container.find( 'iframe' ),
				YTPlayerId = $iframe.parent().data( 'yt-bg-element-id' ),
				VimeoPlayerId = $iframe.data( 'vimeo-bg-element-id' ),
				$video = $container.find( 'video' );

			if ( $iframe.length ) {

				if ( $iframe.hasClass( 'wvc-youtube-bg' ) ) {

					if ( 'undefined' !== typeof WVCYTVideoBg && WVCYTVideoBg.players[ YTPlayerId ] ) {
						WVCYTVideoBg.players[YTPlayerId].playVideo();
					}
					
				} else if ( $iframe.hasClass( 'wvc-vimeo-bg' ) ) {

					if ( 'undefined' !== typeof WVCVimeo && WVCVimeo.players[ VimeoPlayerId ] ) {
						WVCVimeo.players[ VimeoPlayerId ].play();
					}
				}

			} else if ( $video.length ) {

				$video.trigger( 'play' );
			}

		},

		/**
		 * Pause all videos
		 */
		pauseAllVideos : function ( $container ) {

			var _this = this,
				VimeoPlayerId,
				$video;

			/* Pause all HTML videos */
			if ( $container.find( '.wvc-video-bg' ).length ) {
				$container.find( '.wvc-video-bg' ).each( function () {
					$video = $( this );
					$video.get(0).pause();
				} );
			}

			/* Pause all YT videos */
			$container.find( '.wvc-yt-video-bg-pause' ).trigger( 'click' );

			/* Pause all Vimeo  videos */
			$container.find( '.wvc-vimeo-video-bg-container > iframe' ).each( function () {
				VimeoPlayerId = $( this ).data( 'vimeo-bg-element-id' );
				if ( 'undefined' !== typeof WVCVimeo && WVCVimeo.players[ VimeoPlayerId ] ) {
					WVCVimeo.players[ VimeoPlayerId ].pause();
				}
			} );
		},
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCShowaseVerticalCarousel.init();
	} );

} )( jQuery );