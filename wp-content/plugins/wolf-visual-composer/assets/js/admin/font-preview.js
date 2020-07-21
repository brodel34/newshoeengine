/**
 *  font family preview
 */
;( function( $ ) {

	/**
 	 * make sure the previews are sortable
 	 */
 	$( document ).on( 'change', '.wvc-font-family-select', function() {
 		var val = $( this ).val(),
 			$container = $( this ).next( '.wvc-font-family-preview' );

 		if ( 'default' === val ) {
 			$container.removeAttr( 'style' );
 		} else {
 			$container.css( { 'font-family' : val } );
 		}
 	} );

} )( jQuery );