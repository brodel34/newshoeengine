/**
 *  Reset theme mods button
 */
 /* global PrequelleAdminParams,
 confirm, console */
;( function( $ ) {

	'use strict';

	var $container = $( '#customize-header-actions' ),
		$button = $( '<button id="prequelle-mods-reset" class="button-secondary button">' )
		.text( PrequelleAdminParams.resetModsText )
		.css( {
		'float': 'right',
		'margin-right': '10px',
		'margin-left': '10px'
	} );

	$button.on( 'click', function ( event ) {

		event.preventDefault();

		var r = confirm( PrequelleAdminParams.confirm ),
			data = {
				wp_customize: 'on',
				action: 'prequelle_ajax_customizer_reset',
				nonce: PrequelleAdminParams.nonce.reset
			};

		if ( ! r ) {
			return;
		}

		$button.attr( 'disabled', 'disabled' );

		$.post( PrequelleAdminParams.ajaxUrl, data, function ( response ) {

			if ( 'OK' === response ) {
				wp.customize.state( 'saved' ).set( true );
				location.reload();
			} else {
				$button.removeAttr( 'disabled' );
				console.log( response );
			}
		} );
	} );

	$button.insertAfter( $container.find( '.button-primary.save' ) );
} )( jQuery );