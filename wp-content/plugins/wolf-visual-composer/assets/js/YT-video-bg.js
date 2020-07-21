/*!
 * YouTube Video Background
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */
/* global YT, WVCParams */
var WVCYTVideoBg = function( $ ) {

	'use strict';

	return {

		players : [],
		isMobile : false,

		/**
		 * @link http://gambit.ph/how-to-use-the-javascript-youtube-api-across-multiple-plugins/
		 */
		init : function ( $container ) {

			this.isMobile = WVCParams.isMobile;

			var _this = this;

			$container = $container || $( 'body' );

			if ( ! $container.find( '.wvc-youtube-video-bg-container' ).length || this.isMobile ) {
				return;
			}

			if ( 'undefined' === typeof( YT ) || 'undefined' === typeof( YT.Player ) ) {
				$.getScript( '//www.youtube.com/player_api' );
			}

			setTimeout( function() {

				if ( typeof window.onYouTubePlayerAPIReady !== 'undefined' ) {
					if ( typeof window.WVCOtherYTAPIReady === 'undefined' ) {
						window.WVCOtherYTAPIReady = [];
					}
					window.WVCOtherYTAPIReady.push( window.onYouTubePlayerAPIReady );
				}

				window.onYouTubePlayerAPIReady = function() {
					_this.playVideo( $container );

					if ( typeof window.WVCOtherYTAPIReady !== 'undefined' ) {
						if ( window.WVCOtherYTAPIReady.length ) {
							window.WVCOtherYTAPIReady.pop()();
						}
					}
				};
			}, 2 );
		},

		/**
		 * Loop through video container and load player
		 */
		playVideo: function( $container ) {

			var _this = this;

			$container.find( '.wvc-youtube-video-bg-container' ).each( function( index ) {
				var $this = $( this ), containerId, videoId, startTime = 0, endTime = 0, loop = true, pauseOnStart = false, unMute = false;

				containerId = $this.find( '.wvc-youtube-player' ).attr( 'id' );
				videoId = $this.data( 'youtube-id' ),
				loop = $this.data( 'youtube-loop' ),
				startTime = $this.data( 'youtube-start-time' ),
				endTime = $this.data( 'youtube-end-time' ),
				pauseOnStart = $this.data( 'youtube-pause-on-start' );
				unMute = $this.data( 'youtube-unmute' );

				_this.loadPlayer( containerId, videoId, startTime, endTime, loop, pauseOnStart, unMute );
			} );
		},

		/**
		 * Load YT player
		 */
		loadPlayer: function( containerId, videoId, startTime, endTime, loop, pauseOnStart, unMute ) {

			var _this = this, 	
				done = false,
				elementDataId = $( '#' + containerId ).parent().data( 'yt-bg-element-id' ),

			player = new YT.Player( containerId, {
				width: '100%',
				height: '100%',
				videoId: videoId,
				playerVars: {
					playlist: videoId,
					iv_load_policy: 3, // hide annotations
					enablejsapi: 1,
					disablekb: 1,
					autoplay: 1,
					controls: 0,
					showinfo: 0,
					rel: 0,
					loop: 1,
					wmode: 'transparent',
					start: startTime
				},
				events: {
					onReady: function ( event ) {
						event.target.setLoop( true );
						if ( ! unMute ) {
							event.target.mute();
						}

						var el = document.getElementById( containerId );
						el.className = el.className + ' wvc-youtube-player-is-loaded';

						if ( pauseOnStart ) {
							setTimeout( function() {
								player.pauseVideo();
							}, 100 );
    						}
					},

					/**
					 * End video at the end if loop option not set
					 */
					onStateChange : function( event ) {

    						var videoDuration = player.getDuration();

    						if ( event.data === YT.PlayerState.PLAYING && ! done && ! loop ) {
							setTimeout( function() {

								player.pauseVideo();

							}, ( videoDuration - 0.1 ) * 1000 );
							done = true;
    						}
					}
				}
			} );

			_this.players[elementDataId] = player; // awesome, we can access the player (almost) from anywhere!
			
			/* Play and pause button */
			var playButton = document.getElementById( 'wvc-yt-video-bg-play-' + elementDataId );
			playButton.addEventListener( 'click', function() {
				if ( typeof player.playVideo === 'function' ) {
					player.playVideo();
				}
			} );

			var pauseButton = document.getElementById( 'wvc-yt-video-bg-pause-' + elementDataId );
			pauseButton.addEventListener( 'click', function() {
				player.pauseVideo();
			} );

			/* Mute/Unmute Button */

			$( window ).trigger( 'resize' ); // trigger window calculation for video background
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( window ).load( function() {
		WVCYTVideoBg.init();
	} );

} )( jQuery );