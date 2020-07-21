/*!
 * BMIC
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

var WVCBMIC = function( $ ) {

	'use strict';

	return {

		processing : false,

		/**
		 * Init UI
		 */
		init : function () {
			this.BMICForm();
		},

		BMICForm : function() {

			var _this = this;

			$( '.wvc-bmic-form' ).each( function() {
				
				$( this ).on( 'submit', function( e ) {

					e.preventDefault();

					if ( true === _this.processing ) {
						return false;
					}

					_this.processing = true;
					
					var $form = $( this ),
						$container = $form.parents( '.wvc-bmic-container' ),
						unit = $form.find( '.wvc-bmi-unit' ).val(),
						height = $form.find( '.wvc-bmi-height' ).val(),
						weight = $form.find( '.wvc-bmi-weight' ).val(),
						age = $form.find( '.wvc-bmi-age' ).val(),
						sex = $form.find( '.wvc-bmi-sex' ).val(),
						activityFactor = $form.find( '.wvc-bmi-activity-factor' ).val(),
						data,
						$resultContainer = $container.find( '.wvc-bmic-result' ),
						$resultInner = $container.find( '.wvc-bmic-result-inner' ),
						$button = $form.find( '.wvc-bmic-submit' ),
						$buttonDefaultText = $button.text(),
						result;

					/* Empty result */
					$resultInner.empty();
					$resultContainer.removeClass( 'wvc-bmic-error wvc-bmic-notification-show' );

					data = {
						action : 'wvc_ajax_bmic_form',
						unit : unit,
						height : height,
						weight : weight,
						age : age,
						sex : sex,
						activityFactor : activityFactor
					};

					if ( '' !== height && '' !== weight && '' !== age && '' !== activityFactor ) {

						$form.addClass( 'wvc-bmic-loading' );
						$button.html( WVCParams.l10n.BMICProcessingMessage ); // loading message

						$.post( WVCParams.ajaxUrl, data, function( response ) {
														
							if ( response ) {

								response = $.parseJSON( response );
								
								if ( 'error' === response.result ) {
									$form.removeClass( 'wvc-bmic-loading' );
									$resultContainer.addClass( 'wvc-bmic-error wvc-bmic-notification-show' );
									$resultInner.append( response.message );
									$button.html( $buttonDefaultText );
									_this.processing = false;
								} else {
									/* Result */
									$form.removeClass( 'wvc-bmic-loading' );
									$resultContainer.addClass( 'wvc-bmic-notification-show' );
									$resultInner.append( response.message );
									$button.html( $buttonDefaultText );
									_this.processing = false;
								}

							} else {
								$resultContainer.addClass( 'wvc-bmic-error wvc-bmic-notification-show' );
								$resultInner.append( WVCParams.l10n.unknownError );
								$form.removeClass( 'wvc-bmic-loading' );
								$button.html( $buttonDefaultText );
								_this.processing = false;
							}

						} );
					
					} else {
						$resultContainer.addClass( 'wvc-bmic-error wvc-bmic-notification-show' );
						$resultInner.append( WVCParams.l10n.emptyFields );
						$button.html( $buttonDefaultText );
						_this.processing = false;
					}
					
					return false;
				} );
			} );

			$( document ).on( 'click', '.wvc-bmic-result-close', function( event ) {
				event.preventDefault();

				$( this ).parent().removeClass( 'wvc-bmic-error wvc-bmic-notification-show' );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCBMIC.init();
	} );

} )( jQuery );