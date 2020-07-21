/**
 *  Searchable dropdown
 */
 /* global PrequelleAdminParams */
;( function( $ ) {

	'use strict';

	$( '.prequelle-searchable' ).chosen( {
		no_results_text: PrequelleAdminParams.noResult,
		width: '100%'
	} );

	$( document ).on( 'hover', '#menu-to-edit .pending', function() {
		if ( ! $( this ).find( '.chosen-container' ).length && $( this ).find( '.prequelle-searchable' ).length ) {
			$( this ).find( '.prequelle-searchable' ).chosen( {
				no_results_text: PrequelleAdminParams.noResult,
				width: '100%'
			} );
		}
	} );

} )( jQuery );