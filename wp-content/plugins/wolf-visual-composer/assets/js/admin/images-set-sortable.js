/**
 *  Images Set Sortabls
 */
;( function( $ ) {

	/**
 	 * make sure the previews are sortable
 	 */
 	$( '.wvc-images-set' ).sortable( {
		update : function() {
			$( this ).parent().find( 'input' ).val( $( this ).sortable( 'toArray', { attribute: 'data-attachment-id' } ) );
		},
		helper: 'clone',
		items: '.wvc-image'
	} );

} )( jQuery );