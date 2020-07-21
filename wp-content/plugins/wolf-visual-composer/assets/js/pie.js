/*!
 * Pie Charts
 *
 * Wolf WPBakery Page Builder Extension 3.1.1
 */
/* jshint -W062 */

/* global CountUp, Waypoint, WVCParams */
var WVCPie = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			$( '.wvc-pie' ).each( function() {

				var options = {},
					counterOptions = {},
					$pie = $( this ),
					containerId = $pie.parent().attr( 'id' ),
					counterId = $pie.find( '.wvc-pie-counter' ).attr( 'id' ),
					size = $( this ).data( 'size' ) || 170,
					lineWidth = $( this ).data( 'line-width' ) || parseInt( WVCParams.pieChartLineWidth, 10 ),
					barColor = $( this ).data( 'bar-color' ) || '#333333',
					trackColor = $( this ).data( 'track-color' ) || '#CCCCCC',
					counter,
					percent = $pie.data( 'percent' ) || 100,
					percentLabel = $pie.data( 'percent-label' ) || percent,
					prefix = $pie.data( 'prefix' ) || '',
					suffix = $pie.data( 'unit' ) || '',
					duration = $pie.data( 'duration' ) || 1.5;

				options = {
					barColor: barColor,
					trackColor: trackColor,
					scaleColor: false,
					lineCap: 'butt',
					lineWidth: lineWidth,
					animate: 1500,
					size: size
				};

				counterOptions = {
					useEasing : false,
					useGrouping : true,
					separator : ',',
					decimal : '.',
					prefix : prefix,
					suffix : suffix
				};

				counter = new CountUp( counterId, 0, percentLabel, 0, duration, counterOptions );

				new Waypoint( {

					element: document.getElementById( containerId ),

					handler: function() {

						$pie.easyPieChart( options );
						counter.start();

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
		WVCPie.init();
	} );

} )( jQuery );