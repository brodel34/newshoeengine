/*!
 * Plugin embed video
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

var WVCEmbedVideo = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			
			$( document ).on( 'click', '.wvc-youtube-play-button', function() {
 				var $this = $( this ),
 					$container = $this.parent().parent(),
					$iframe = $container.find( 'iframe' );

				$iframe[0].src += '&autoplay=1';
				$container.find( '.wvc-youtube-cover' ).delay( 500 ).fadeOut();
				$container.addClass( 'wvc-youtube-playing' );
			} );

			$( document ).on( 'click', '.wvc-embed-video-play-button', function() {
 				var $this = $( this ),
 					$container = $this.parent().parent(),
					$iframe = $container.find( 'iframe' );

				$iframe[0].src += '&autoplay=1';
				$container.find( '.wvc-embed-video-cover' ).delay( 500 ).fadeOut();
				$container.addClass( 'wvc-embed-video-playing' );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCEmbedVideo.init();
	} );

} )( jQuery );