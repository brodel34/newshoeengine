/*!
 * WolfGram
 *
 * Wolf Gram 1.5.8
 */
/* jshint -W062 */
/* global DocumentTouch */
var WolfGram = WolfGram || {},
	console = console || {};

WolfGram = function( $ ) {

	'use strict';

	return {

		init : function() {

			var _this = this;

			this.setRelAttr();

			$( window ).resize( function() {
				_this.widthClass();
			} ).resize();
		},

		setRelAttr : function () {

			var rand = Math.floor( (Math.random() * 9999 ) + 1 );

			$( '#wolf-instagram .wolf-instagram-item a' ).each( function() {
				$( this ).attr( 'rel', 'wolfgram-gallery' );
			} );

			$( '.wolf-instagram-list li a' ).each( function() {
				$( this ).attr( 'rel', 'wolfgram-widget-gallery' );
				$( this ).attr( 'data-fancybox', 'wolfgram-widget-gallery-' + rand ); // new fancybox
			} );
		},

		widthClass : function() {
			$( '.wolf-instagram-gallery' ).each( function() {

				var $gallery = $( this ),
					itemWidth = $gallery.find( '.wolf-instagram-item:first-child' ).width();

				if ( 100 > itemWidth && 380 > itemWidth ) {
					$( this ).addClass( 'wolf-instagram-gallery-small' );
					$( this ).removeClass( 'wolf-instagram-gallery-big' );

				} else if ( 380 < itemWidth ) {
					$( this ).removeClass( 'wolf-instagram-gallery-small' );
					$( this ).addClass( 'wolf-instagram-gallery-big' );

				} else {
					$( this ).removeClass( 'wolf-instagram-gallery-small' );
					$( this ).removeClass( 'wolf-instagram-gallery-big' );
				}
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WolfGram.init();
	} );

} )( jQuery );


