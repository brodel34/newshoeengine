/*!
 * Accordion
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

/* global WVC, WVCParams */
var WVCVideoSwitcher = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			var _this = this;
			
			$( '.wvc-video-switcher-container' ).each( function() {
				var $container = $( this ),
					$bigVideo = $( '.wvc-vs-big-video' ),
					$bigVideoInner = $( '.wvc-vs-big-video-inner' ),
					$links = $( this ).find( '.wvc-vs-video-thumbnail-link' ),
					postId,
					href,
					scrollPoint;

				$links.on( 'click', function( event ) {
					event.preventDefault();

					if ( $( this ).parent().hasClass( 'wvc-vs-video-thumbnail-active' ) ) {
						return;
					}

					postId = $( this ).data( 'wvc-vs-video-post-id' );
					href = $( this ).attr( 'href' );

					$links.parent().removeClass( 'wvc-vs-video-thumbnail-active' );
					$( this ).parent().addClass( 'wvc-vs-video-thumbnail-active' );

					$bigVideo.addClass( 'wvc-vs-big-video-loading' );

					$.post( WVCParams.ajaxUrl, {
						action : 'wvc_ajax_get_video_embed_from_url',
						postId : postId,
						videoUrl : href

						}, function( response ) {

						if ( response ) {
							
							$bigVideoInner.removeClass( 'wvc-fluid-video-container' ).html( response );
							
							/* Do WP Mejs for selfhosted videos */
							$bigVideoInner.find( 'video' ).mediaelementplayer();
														
							WVC.fluidVideos( $bigVideoInner );
							
							window.dispatchEvent( new Event( 'resize' ) );

							_this.playVideo( '.wvc-vs-big-video-inner' );
							scrollPoint = $container.offset().top - 80;

							setTimeout( function() {
								if ( $( window ).scrollTop() > scrollPoint ) {
								
									$( 'html, body' ).stop().animate( {

										scrollTop: scrollPoint

									}, parseInt( WVCParams.smoothScrollSpeed, 10 ), WVCParams.smoothScrollEase, function() {
									
									} );
								}

								$bigVideo.removeClass( 'wvc-vs-big-video-loading' );
							}, 800 );
						}
					} );
				} );
			} );
		},

		/**
		 * Play video iframe
		 */
		playVideo : function( container ) {
			
			/* HTML5 video */
			if ( $( 'video', container ).length ) {
				$( 'video', container ).trigger( 'play' );
			}

			if ( $( 'iframe', container ).length ) {
				var $iframe = $( 'iframe', container ),
					src = $iframe.attr( 'src' );

					/* YT */
				if ( src.match( /youtu/ ) ) {

					$iframe[0].src += "&autoplay=1";

					/* Vimeo */
				} else if ( src.match( /vimeo.com/ ) ) {

					$iframe[0].src += "&autoplay=1";
				}
			}			
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCVideoSwitcher.init();
	} );

} )( jQuery );