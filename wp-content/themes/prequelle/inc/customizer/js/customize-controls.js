;( function( $ ) {

	'use strict';

	$( document ).on( 'load ready', function() {

		/* === Checkbox Multiple Control === */

		$( '.customize-control-group_checkbox input[type="checkbox"]' ).on(
			'change',
			function() {

				var checkbox_values = $( this ).parents( '.customize-control' ).find( 'input[type="checkbox"]:checked' ).map(
					function() {
						return this.value;
					}
				).get().join( ',' );

				//console.log( checkbox_values );

				$( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
			}
		);
	} );

} )( jQuery );