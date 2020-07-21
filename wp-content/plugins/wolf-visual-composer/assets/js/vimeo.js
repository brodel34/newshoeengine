/*!
 * Vimeo
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

/* global Vimeo */
var WVCVimeo = function( $ ) {

	'use strict';

	return {

		players : [],

		/**
		 * Init UI
		 */
		init : function ( $container ) {

			var _this = this;

			$container = $container || $( 'body' );

			$container.find( '.wvc-vimeo-bg' ).each( function() {
				var $row = $( this ).closest( '.wvc-parent-row' ),
					elementDataId = $( this ).data( 'vimeo-bg-element-id' ),
					player = new Vimeo.Player( this ),
					$cover = $( this ).closest( '.wvc-video-bg-fallback' );

				if ( $row.hasClass( 'wvc-video-bg-is-mute' ) ) {
					player.setVolume( 0 );
				} else {
					player.setVolume( 1 );
				}

				_this.players[elementDataId] = player; // awesome, we can access the player (almost) from anywhere!
				
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCVimeo.init();
	} );

} )( jQuery );