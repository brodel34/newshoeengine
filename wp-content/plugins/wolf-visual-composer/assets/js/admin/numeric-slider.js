/**
 *  Jquery UI slider fields
 */
;( function( $ ) {

 	$( document ).ready( function() {

  		$( '.wvc_numeric_slider .wvc-numeric-slider' ).each( function() {
 			var $slider = $( this ),
 				$helper = $slider.parent().find( '.numeric-slider-helper-input' ),
 				$input = $slider.parent().find( '.wpb_vc_param_value' ),
 				//value = ( $slider.attr( 'data-value' ) !== '' ) ? parseInt( $slider.attr( 'data-value' ), 10 ) : 0,
 				min = parseInt( $slider.attr( 'data-min' ), 10 ),
 				max = parseInt( $slider.attr( 'data-max' ), 10 ),
 				step = parseInt( $slider.attr( 'data-step' ), 10 );

 			$( this ).slider( {
 				min: min,
 				max: max,
 				step: step,
 				slide: function( event, ui ) {
 					// ui.value
 					$helper.text( ui.value );
 					$input.val( ui.value );
				},
				stop: function( event, ui ) {
					$helper.text( ui.value );
					$input.val( ui.value );
				},
				change: function( event, ui ) {
					$helper.text( ui.value );
					$input.val( ui.value );
				},
				create: function() {

					$( this ).slider( 'value', $input.val() );
				}
 			} );
 		} );
 	} );

} )( jQuery );