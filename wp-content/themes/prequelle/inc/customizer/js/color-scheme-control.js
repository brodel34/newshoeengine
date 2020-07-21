/* global colorScheme, Color */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

;( function( api, $ ) {

	var colorSchemeTemplate = wp.template( 'prequelle-color-scheme' ),
		fontsTemplate = wp.template( 'prequelle-fonts' ),
		layoutTemplate = wp.template( 'prequelle-layout' ),

		colorSettings = [
			'body_background_color',
			'page_background_color',
			'submenu_background_color',
			'submenu_font_color',
			'accent_color',
			'main_text_color',
			'secondary_text_color',
			'strong_text_color',
			'secondary_accent_color',
		],

		fontSettings = [
			'body_font_name',
			'body_font_size',
			'menu_font_name',
			'menu_font_weight',
			'menu_font_transform',
			'menu_font_size',
			'menu_font_letter_spacing',
			'submenu_font_transform',
			'submenu_font_weight',
			'heading_font_name',
			'heading_font_weight',
			'heading_font_transform',
			'heading_font_letter_spacing'
		],

		layoutSettings = [
			'site_width',
			'menu_item_horizontal_padding'
		];

	api.controlConstructor.select = api.Control.extend( {

		ready: function() {

			if ( 'color_scheme' === this.id ) {

				this.setting.bind( 'change', function( value ) {

					var colors = colorScheme[value].colors;

					$.each( colorSettings, function( index, setting ) {
						//console.log( index + ": " + value );
						//console.log( colors[index] );

						if ( 'undefined' !== typeof api( setting ) ) {

							var color = colors[index];
							api( setting ).set( color );
							api.control( setting ).container.find( '.color-picker-hex' )
								.data( 'data-default-color', color )
								.wpColorPicker( 'defaultColor', color );
						} else {
							//console.log( 'nope' );
						}
					} );
				} );
			}
		}
	} );

	/*-------------------------------------------------------------------------------------------

		Generate the color CSS for the current Color Scheme.

	*--------------------------------------------------------------------------------------------*/

	function updateColorSchemeCSS() {

		var scheme = api( 'color_scheme' )(),
			colorCss,
			colors = _.object( colorSettings, colorScheme[ scheme ].colors );

		// Merge in color scheme overrides.
		_.each( colorSettings, function( setting ) {
			if ( 'undefined' !== typeof api( setting ) ) {
				colors[ setting ] = api( setting )();
			}
		} );

		// Add additional color.
		// jscs:disable
		colors.border_color = Color( colors.strong_text_color ).toCSS( 'rgba', 0.15 );
		// jscs:enable

		colorCss = colorSchemeTemplate( colors );

		api.previewer.send( 'update-color-scheme-css', colorCss );
	}

	// Update the CSS whenever a color setting is changed.
	_.each( colorSettings, function( setting ) {
		api( setting, function( setting ) {
			setting.bind( updateColorSchemeCSS );
		} );
	} );

	/*-------------------------------------------------------------------------------------------

		Generate the color CSS for the current Fonts

	*--------------------------------------------------------------------------------------------*/

	function updateFontsCSS() {
		var fonts = _.object(),
			fontsCss;

		_.each( fontSettings, function( setting ) {

			if ( 'undefined' !== typeof api( setting ) ) {
				fonts[ setting ] = api( setting )();
			}
		} );

		fontsCss = fontsTemplate( fonts );

		//console.log( fontsCss );

		api.previewer.send( 'update-fonts-css', fontsCss );
	}

	// Update the CSS whenever a fonts setting is changed.
	_.each( fontSettings, function( setting ) {
		api( setting, function( setting ) {
			setting.bind( updateFontsCSS );
		} );
	} );

	/*-------------------------------------------------------------------------------------------

		Generate the CSS for the layout

	*--------------------------------------------------------------------------------------------*/

	function updateLayoutCSS() {
		var layout = _.object(),
			layoutCss;

		_.each( fontSettings, function( setting ) {

			if ( 'undefined' !== typeof api( setting ) ) {
				layout[ setting ] = api( setting )();
			}
		} );

		layoutCss = layoutTemplate( layout );

		//console.log( layoutCss );

		api.previewer.send( 'update-layout-css', layoutCss );
	}

	// Update the CSS whenever a fonts setting is changed.
	_.each( layoutSettings, function( setting ) {
		api( setting, function( setting ) {
			setting.bind( updateLayoutCSS );
		} );
	} );
} )( wp.customize, jQuery );