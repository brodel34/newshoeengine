/*!
 * Album tracklist
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

var WVCAlbumTracklist = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			var _this = this;

			_this.playButton();

			$( window ).resize( function() {
				_this.widthClass();
			} ).resize();
		},

		playButton : function() {
			
			var _this = this;

			$( document ).on( 'click', '.wvc-ati-play-button', function( event ) {
				event.preventDefault();

				var $btn = $( this ),
					$container = $btn.parents( '.wvc-album-tracklist' ),
					$audio = $btn.next( '.wvc-ati-audio' ),
					audioId = $audio.attr( 'id' ),
					audio = document.getElementById( audioId );
				
				if ( ! $btn.hasClass( 'wvc-ati-track-playing' ) ) {
					
					_this.pauseAllPlayers();
					$container.find( '.wvc-album-tracklist-item' ).removeClass( 'wvc-album-tracklist-item-active' );
					$btn.closest( '.wvc-album-tracklist-item' ).addClass( 'wvc-album-tracklist-item-active' );
					$btn.addClass( 'wvc-ati-track-playing' );
					audio.play();
			
				} else {
					
					$btn.removeClass( 'wvc-ati-track-playing' );
					audio.pause();
				}
			} );

			$( '.wvc-ati-audio' ).bind( 'ended', function() {
				$( this ).prev( '.wvc-ati-play-button' ).removeClass( 'wvc-ati-track-playing' );
			} );
		},

		pauseAllPlayers : function() {
			$( '.wvc-ati-audio-cell' ).each( function() {
				var $btn = $( this ).find( '.wvc-ati-play-button' ),
					$audio = $btn.next( '.wvc-ati-audio' ),
					audioId = $audio.attr( 'id' ),
					audio = document.getElementById( audioId );
				
				$btn.removeClass( 'wvc-ati-track-playing' );
				audio.pause();
			} );
		},

		widthClass : function() {
			$( '.wvc-album-tracklist' ).each( function() {
				var width = $( this ).width();

				if ( 500 > width && 380 < width  ) {
					$( this ).addClass( 'wvc-album-tracklist-500' );
					$( this ).removeClass( 'wvc-album-tracklist-380' );

				} else if ( 380 > width ) {
					$( this ).removeClass( 'wvc-album-tracklist-500' );
					$( this ).addClass( 'wvc-album-tracklist-380' );
				} else {
					$( this ).removeClass( 'wvc-album-tracklist-500' );
					$( this ).removeClass( 'wvc-album-tracklist-380' );
				}
			} );
		}
	};
}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCAlbumTracklist.init();
	} );

} )( jQuery );