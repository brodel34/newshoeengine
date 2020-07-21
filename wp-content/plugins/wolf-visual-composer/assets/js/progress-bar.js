/*!
 * ProgressBar
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

/* global Waypoint,
CountUp */
var WVCProgressBar = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			$( '.wvc-progress-bar' ).each( function() {

				var containerId = $( this ).attr( 'id' ),
					index = 1;

				new Waypoint( {

					element: document.getElementById( containerId ),

					handler: function() {

						/* Bar animation */
						$( '#' + containerId ).find( '.wvc_single_bar' ).each( function() {
							var $this = $( this ),
								$bar = $this.find( '.wvc_bar' ),
								val = $bar.data( 'percentage-value' );

							index++;

							setTimeout( function() {
								$bar.css( {
									width: val + '%'
								} );
							}, 200 * index );
						} );

						/* Counter animation */
						$( '#' + containerId ).find( '.vc_label_units' ).each( function() {
							
							var $this = $( this ),
								counterOptions = {},
								counterId = $this.attr( 'id' ),
								percent = $this.data( 'percent' ) || 100,
								prefix = $this.data( 'prefix' ) || '',
								suffix = $this.data( 'unit' ) || '',
								duration = $this.data( 'duration' ) || 1;

							index++;

							counterOptions = {
								useEasing : false,
								useGrouping : false,
								separator : ',',
								decimal : '.',
								prefix : prefix,
								suffix : suffix
							};

							setTimeout( function() {
								
								new CountUp( counterId, 0, percent, 0, duration, counterOptions ).start();

							}, 200 * index );
						} );

					},
					offset: '88%'
				} );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCProgressBar.init();
	} );

} )( jQuery );