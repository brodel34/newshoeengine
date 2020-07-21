/*!
 * AudioButton
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

/* global WVCParams */
var WVCAudioButton = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			$( '.wvc-audio-button' ).each( function() {

				var defaultText = $( this ).find( 'span' ).text(),
						$btn = $( this ),
						$audio = $btn.parent().next( '.wvc-audio-button-player' ),
						audioId = $audio.attr( 'id' ),
						audio = document.getElementById( audioId );

				$( this ).on( 'click', function() {
					event.preventDefault();

					if ( ! $btn.hasClass( 'wvc-audio-button-player-playing' ) ) {
						$( 'video, audio' ).trigger( 'pause' );
						$( '.wvc-audio-button' ).removeClass( 'wvc-audio-button-player-playing' );
						$btn.addClass( 'wvc-audio-button-player-playing' );
						audio.play();
						$btn.find( 'span' ).html( WVCParams.audioButtonPauseText );
					} else {
						$btn.removeClass( 'wvc-audio-button-player-playing' );
						$btn.find( 'span' ).html( defaultText );
						audio.pause();
					}
				} );

				$audio.bind( 'ended', function() {
					$btn.find( 'span' ).html( defaultText );
				} );
			} )
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCAudioButton.init();
	} );

} )( jQuery );