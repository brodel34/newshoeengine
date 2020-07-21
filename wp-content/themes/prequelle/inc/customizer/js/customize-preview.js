/*!
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 * Things like site title, description, and background color changes.
 *
 * Prequelle 1.0.4
 */

/* global PrequelleUi */

;( function( $ ) {

	'use strict';

	/**
	 * Background
	 */
	var colorSchemeStyle = $( '#prequelle-color-scheme-css' ),
		fontsStyle = $( '#prequelle-fonts-css' ),
		layoutStyle = $( '#prequelle-layout-css' ),
		api = wp.customize,
		backgrounds = {
			'light_background' : '.wvc-font-dark',
			'dark_background' : ' .wvc-font-light',
			'footer_bg' : '.sidebar-footer',
			'bottom_bar_bg' : '.site-infos',
			'music_network_bg' : '.music-social-icons-container'
		},
		options = [ 'repeat', 'position', 'attachment' ];

	// Color scheme style tag
	if ( ! colorSchemeStyle.length ) {
		colorSchemeStyle = $( 'head' ).append( '<style type="text/css" id="prequelle-color-scheme-css" />' )
			.find( '#prequelle-color-scheme-css' );
	}

	// Fonts style tag
	if ( ! fontsStyle.length ) {
		fontsStyle = $( 'head' ).append( '<style type="text/css" id="prequelle-fonts-css" />' )
			.find( '#prequelle-fonts-css' );
	}

	// Layout style tag
	if ( ! layoutStyle.length ) {
		layoutStyle = $( 'head' ).append( '<style type="text/css" id="prequelle-layout-css" />' )
			.find( '#prequelle-layout-css' );
	}

	$.each( backgrounds, function( key, bg ) {

		$.each( options, function( k, o ) {

			wp.customize( key + '_' + o, function( value ) {

				value.bind( function( to ) {

					var prop = 'background-' + o;
					$( bg ).css( prop , to );
				} );
			} );
		} );

		/* Size
		---------------*/
		wp.customize( key + '_size', function( value ) {

			value.bind( function( to ) {

				if ( to === 'resize' ) {

					$( bg ).css( {
						'background-size' : '100% auto',
						'-webkit-background-size' : '100% auto',
						'-moz-background-size' : '100% auto',
						'-o-background-size' : '100% auto'
					} );

				} else {

					$( bg ).css( {
						'background-size' : to,
						'-webkit-background-size' : to,
						'-moz-background-size' : to,
						'-o-background-size' : to
					} );
				}
			} );
		} );
	} ); // end for each background

	// CSS template.
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'update-color-scheme-css', function( css ) {
			colorSchemeStyle.html( css );
		} );

		api.preview.bind( 'update-fonts-css', function( css ) {
			fontsStyle.html( css );
		} );

		api.preview.bind( 'update-layout-css', function( css ) {
			layoutStyle.html( css );
		} );
	} );

	// Add has-header-image body class when background image is added.
	api( 'header_image', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).toggleClass( 'has-default-header', '' !== to );
		} );
	} );

	// Main skin
	api( 'color_scheme', function( value ) {
		value.bind( function( to ) {

			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)global-skin-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'global-skin-' + to );

			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)skin-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'skin-' + to );
			$( window ).trigger( 'resize' );
		} );
	} );

	// Site layout
	api( 'site_layout', function( value ) {
		value.bind( function( to ) {

			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)site-layout-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'site-layout-' + to );
			$( window ).trigger( 'resize' );
		} );
	} );

	// Logo visibility
	api( 'logo_visibility', function( value ) {
		value.bind( function( to ) {

			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)logo-visibility-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'logo-visibility-' + to );
			$( window ).trigger( 'resize' );
		} );
	} );

	// Logo header alignement
	api( 'logo_header_align', function( value ) {
		value.bind( function( to ) {

			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)logo-header-align-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'logo-header-align-' + to );
			$( window ).trigger( 'resize' );
		} );
	} );

	/* Button
	-------------------------------------------*/
	api( 'button_style', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)button-style-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'button-style-' + to );
		} );
	} );

	/* Menu
	-------------------------------------------*/
	api( 'menu_skin', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)menu-skin-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'menu-skin-' + to );
		} );
	} );

	api( 'menu_width', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)menu-width-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'menu-width-' + to );
			PrequelleUi.centeredLogoOffset();
			PrequelleUi.subMenuDirection();
		} );
	} );

	api( 'menu_style', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)menu-style-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'menu-style-' + to );
		} );
	} );

	api( 'menu_hover_style', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)menu-hover-style-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'menu-hover-style-' + to );
		} );
	} );

	api( 'menu_centered_alignment', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)menu-centered-alignment-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'menu-centered-alignment-' + to );
		} );
	} );

	api( 'mega_menu_width', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)mega-menu-width-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'mega-menu-width-' + to );
		} );
	} );

	api( 'menu_sticky_type', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)menu-sticky-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'menu-sticky-' + to );
		} );
	} );

	/* Header
	-------------------------------------------*/
	api( 'hero_layout', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)hero-layout-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'hero-layout-' + to );
			$( window ).trigger( 'resize' );
		} );
	} );


	/* Layouts
	-------------------------------------------*/
	var postTypes = {
		'post' : 'is-blog',
		'product' : 'is-shop',
		'work' : 'is-portfolio',
		'gallery' : 'is-albums',
		'attachment' : 'is-photos',
		'release' : 'is-discography',
		'video' : 'is-videos',
		'event' : 'is-events',
		'artist' : 'is-artists'
	};

	$.each( postTypes, function( postType, bodyClass ) {

		//console.log( postType + ": " + bodyClass );

		api( postType + '_layout', function( value ) {

			if ( ! $( 'body' ).hasClass( bodyClass ) ) {
				return;
			}

			value.bind( function( to ) {
				$( 'body' ).removeClass( function ( index, css ) {
					return ( css.match ( /(^|\s)layout-\S+/g) || [] ).join(' ');
				} );

				$( 'body' ).addClass( 'layout-' + to );
				if ( $( '.grid' ).hasClass( 'isotope-initialized' ) ) {
					$( '.grid' ).isotope( 'reloadItems' ).isotope();
				}
				$( window ).trigger( 'resize' );
			} );
		} );

		api( postType + '_grid_padding', function( value ) {

			if ( ! $( 'body' ).hasClass( bodyClass ) ) {
				return;
			}

			value.bind( function( to ) {
				$( '.grid' ).removeClass( function ( index, css ) {
					return ( css.match ( /(^|\s)grid-padding-\S+/g) || [] ).join(' ');
				} );
				$( '.grid' ).addClass( 'grid-padding-' + to );
				if ( $( '.grid' ).hasClass( 'isotope-initialized' ) ) {
					$( '.grid' ).isotope( 'reloadItems' ).isotope();
				}
				$( window ).trigger( 'resize' );
			} );
		} );
	} );

	/* Product Single
	-------------------------------------------*/
	api( 'product_single_layout', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)single-product-layout-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'single-product-layout-' + to );
		} );
	} );


	/* Bottom bar
	-------------------------------------------*/
	api( 'bottom_bar_layout', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)bottom-bar-layout-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'bottom-bar-layout-' + to );
		} );
	} );


	/* Footer
	-------------------------------------------*/

	api( 'footer_type', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)footer-type-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'footer-type-' + to );
			PrequelleUi.footerPageMarginBottom();
		} );
	} );

	api( 'footer_layout', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)footer-layout-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'footer-layout-' + to );
		} );
	} );

	api( 'footer_widgets_layout', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)footer-widgets-layout-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'footer-widgets-layout-' + to );
		} );
	} );

	api( 'bottom_bar_layout', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)bottom-bar-layout-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'bottom-bar-layout-' + to );
		} );
	} );

} )( jQuery );