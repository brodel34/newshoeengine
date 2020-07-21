/**
 *  About page tabs
 */
 /* global Cookies */
;( function( $ ) {

	'use strict';

	var anchor = window.location.hash;
	if ( anchor ) {
		window.scrollTo( 0, 0 );
		setTimeout( function() {
			window.scrollTo( 0, 0 );
		}, 1 );
	}

	/**
	 * Tabs
	 */
	$( '.tabs a' ).on( 'click', function( event ) {
		event.preventDefault();
		var href = $( this ).attr( 'href' );
		history.pushState( null, null, href );
		return false;
	} );

	$( '.tabs' ).each( function() {

		var current = null,
			id = $( this ).attr( 'id' );

		if ( anchor !== '' && $( this ).find( 'a[href="'+anchor+'"]' ).length > 0 ) {
			current = anchor;

		} else if ( Cookies.get( 'tab' + id ) && $( this ).find( 'a[href="'+Cookies.get( 'tab'+id)+'"]' ).length > 0 ) {
			current = Cookies.get( 'tab' + id);

		} else {
			current = $( this ).find( 'a:first' ).attr( 'href' );
		}

		$( this ).find( 'a[href="'+current+'"]' ).addClass( 'nav-tab-active' );

		$( current ).siblings().hide();

		$( this ).find( 'a' ).on( 'click', function( ) {
			var link = $( this ).attr( 'href' );

			if ( link === current ) {
				return false;
			} else {

				$( this ).addClass( 'nav-tab-active' ).siblings().removeClass( 'nav-tab-active' );
				$( link ).show().siblings().hide();
				current = link;
				Cookies.set( 'tab' + id,current);
			}
		} );

	} );

} )( jQuery );