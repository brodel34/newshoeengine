/*!
 * Wolf Share 1.0.7 
 */
/* jshint -W062 */
/* global WolfShareJSParams */

var WolfShare = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			this.shareLinkPopup();
		},

		/**
		 * Share Links Popup
		 */
		shareLinkPopup : function () {

			var _this = this;

			$( '.wolf-share-link' ).on( 'click', function() {

				var $link = $( this ),
					url = $link.attr( 'href' ),
					height = $link.data( 'height' ) || 250,
					width = $link.data( 'width' ) || 500,
					postId = $link.parent().parent().data( 'post-id' ),
					popup;

				if ( postId ) {
					_this.incrementShareCount( postId );
				}

				if ( true === $( this ).data( 'popup' ) && ! _this.isMobile && ! $link.hasClass( 'wolf-share-link-email' ) ){

					popup = window.open( url,'null', 'height=' + height + ',width=' + width + ', top=150, left=150' );

					if ( window.focus ) {
						popup.focus();
					}

					return false;
				}
			} );
		},

		/**
		 * Increment share met count
		 */
		incrementShareCount : function( postId ) {
			var data = {
				action: 'wolf_share_ajax_increment_shares_count',
				postId : postId
			};

			$.post( WolfShareJSParams.ajaxUrl , data, function() {} );
		},
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WolfShare.init();
	} );

} )( jQuery );