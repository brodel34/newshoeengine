/*!
 * Process
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */
var WVCProcess = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			var _this = this;

			_this.setLineDimensions();

			$( window ).resize( function() {
				_this.setLineDimensions();
			} ).resize();
		},

		setLineDimensions : function () {
			$( '.wvc-process-item' ).each( function() {
				
				var $item = $( this ),
					itemWidth = $item.width(),
					itemHeight = $item.height(),
					itemPrevHeight,
					overflow = 5,
					$icon = $item.find( '.wvc-process-icon-container' ),
					iconWidth = $icon.width(),
					iconHeight = $icon.height(),
					$container = $item.parent().parent();

				if ( $container.hasClass( 'wvc-process-container-show-line-no' ) ) {
					return;
				}

				if ( $container.hasClass( 'wvc-process-container-layout-vertical' ) ) {

					if ( $item.prev().length ) {
						itemPrevHeight = $item.prev().height();

						$item.find( '.wvc-process-item-line-before' ).css( {
							'height' : itemPrevHeight - iconHeight + overflow
						} );
					}

					$item.find( '.wvc-process-item-line-after' ).css( {
						'height' : itemHeight - iconHeight
					} );
				
				} else if ( $container.hasClass( 'wvc-process-container-layout-horizontal' ) ) {
					$item.find( '.wvc-process-item-line-before, .wvc-process-item-line-after' ).css( {
						'width' : itemWidth - iconWidth
					} );
				}
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCProcess.init();
	} );

} )( jQuery );