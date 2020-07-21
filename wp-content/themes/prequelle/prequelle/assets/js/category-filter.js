/*!
 * Category filter
 *
 * Prequelle 1.1.8
 */
/* jshint -W062 */
/* global PrequelleParams,
PrequelleMasonry,
PrequelleInfiniteScroll,
PrequelleLoadPosts,
PrequelleYTVideoBg,
PrequelleUi,
PrequelleAjaxNav,
WPM,
alert,
console */
var PrequelleCategoryFilter = function( $ ) {

	'use strict';

	return {

		init : function() {

			this.ajaxCategoryFilter();
			this.isotopeCategoryFilter();
		},

		/**
		 * AJAX filter
		 */
		ajaxCategoryFilter_bak : function () {
			var _this = this,
				selector = '#category-filter-post a',
				$content = $( 'main' ),
				//$loader = $( '#category-filter-loader' ),
				$container,
				//$response,
				$trigger,
				$pagination,
				newPaginationMarkup,
				params,
				cat,
				href,
				data,
				$dom;

			$( document ).on( 'click', selector, function( event ) {

				if ( PrequelleParams.isCustomizer ) {
					alert( PrequelleParams.l10n.categoryFilterDisabledMsg );
					return false;
				}

				event.preventDefault();
				event.stopPropagation();

				$container = $( this ).parent().parent().parent().next( '.items' );
				$trigger = $container.next( '.trigger-container' );
				$pagination = $trigger.next( '.navigation' );
				params = $container.data( 'params' );
				cat = $( this ).data( 'cat-term' );
				href = $( this ).attr( 'href' );

				$container.animate( { 'opacity' : 0.44 } );

				// cosmetic
				$( selector ).removeClass( 'active' );
				$( this ).addClass( 'active' );
				//$trigger.animate( { 'opacity' : 0 } );
				//$loader.animate( { 'opacity' : 1 } );

				data = {
					action : 'prequelle_ajax_get_post_index_content',
					cat : $( this ).data( 'cat-term' ),
					params : params
				};

				// AJAX request
				$.post( PrequelleParams.ajaxUrl, data, function( response ) {

					if ( response ) {

						//console.log(response);

						$content.infinitescroll( 'binding', 'unbind' ); // destroy previous infinitescroll instance
						$content.data( 'infinitescroll', null );
						$( window ).unbind( '.infscr' );

						$dom = $( document.createElement( 'html' ) ); // Create HTML content
						$dom[0].innerHTML = response; // Set AJAX response as HTML dom

						// update pagination
						if ( undefined !== $dom.find( '.paging-navigation').html() ) {
							newPaginationMarkup = $dom.find( '.paging-navigation').html();
						}

						$pagination.html( newPaginationMarkup );

						// update trigger
						$trigger.html( $dom.find( '.trigger-container').html() );

						// Update content
						$container.html( $dom.find( '.items' ).html() ).animate( { 'opacity' : 1 } );

						// Callback to reinit everything
						_this.callBack();

						if ( ! PrequelleParams.isCustomizer ) {
							//window.history.pushState( null, null, href ); // update URL
						}
					} else {
						$container.fadeIn();
					}
				} );

				return false;
			} );
		},

		/**
		 * Callback
		 */
		callBack : function() {

			var $content = $( '.items' );

			PrequelleUi.resizeVideoBackground();
			PrequelleUi.lazyLoad();
			PrequelleUi.fluidVideos();
			//PrequelleUi.youtubeWmode();
			//PrequelleUi.setVimeoStyles();
			PrequelleUi.flexSlider();
			PrequelleUi.lightbox();
			PrequelleUi.addItemAnimationDelay();
			PrequelleUi.parallax();
			PrequelleLoadPosts.init();

			/* YT background */
			if ( 'undefined' !== typeof PrequelleYTVideoBg ) {
				PrequelleYTVideoBg.init();
			}

			if ( $( '.masonry-container' ).length ) {
				PrequelleMasonry.init();

				if ( $content.data( 'isotope' ) ) {
					$content.isotope( 'reloadItems' ).isotope();
				}
			}

			//if ( $( '.infinitescroll-container-trigger' ).length ) {
				PrequelleInfiniteScroll.infiniteScrollTrigger();
			//}

			if ( $( '.infinitescroll-container' ).length ) {
				PrequelleInfiniteScroll.infiniteScroll();
			}

			/* AJAX nav */
			if ( 'undefined' !== typeof PrequelleAjaxNav ) {
				PrequelleAjaxNav.setAjaxLinkClass();
			}

			/* Wolf Playilst */
			if ( 'undefined' !== typeof WPM ) {
				WPM.init();
			}

			if ( $content.find( '.twitter-tweet' ).length ) {
				$.getScript( 'http://platform.twitter.com/widgets.js' );
			}

			if ( $content.find( '.instagram-media' ).length ) {

				$.getScript( '//platform.instagram.com/en_US/embeds.js' );

				if ( 'undefined' !== typeof window.instgrm  ) {
					window.instgrm.Embeds.process();
				}
			}

			if ( $content.find( 'audio,video' ).length ) {
				$content.find( 'audio,video' ).mediaelementplayer();
			}
		},

		ajaxCategoryFilter : function () {
			
			// Return if no filter markup or taxonomy page
			if ( ! $( '.category-filter' ).length || $( 'body' ).hasClass( 'category' ) ) {
				return;
			}

			var _this = this,
				$container;

			$( '.ajax-filtered-content' ).each( function() {
				$container = $( this );
			} );

			$( '.category-filter-post a' ).on( 'click', function( event ) {
					event.preventDefault();

					if ( PrequelleParams.isCustomizer ) {
						alert( PrequelleParams.l10n.categoryFilterDisabledMsg );
						return;
					}

					var $link = $( this ),
						//catSlug = $link.data( 'cat-slug' ),
						$container = $( this ).parent().parent().parent().next( '.items' ),
						params = $container.data( 'params' ),
						data,
						$dom,
						$newItems;

					data = {
						action : 'prequelle_ajax_get_post_index_content',
						cat : $( this ).data( 'cat-term' ),
						params : params
					};

					// AJAX request
					$.post( PrequelleParams.ajaxUrl, data, function( response ) {

						console.log( response );

						if ( response ) {
							$dom = $( document.createElement( 'html' ) ); // Create HTML content
							$dom[0].innerHTML = response; // Set AJAX response as HTML dom

							$newItems = $dom.find( '.items' ).html();

							$container.html( $newItems );

							// Callback to reinit everything
							_this.callBack();
							$( window ).trigger( 'resize' );
						}

					} );
			} );
		},

		/**
		 * Isotope filter
		 */
		isotopeCategoryFilter : function () {

			// Return if no filter markup or taxonomy page
			if ( ! $( '.category-filter' ).length || $( 'body' ).hasClass( 'tax-work_type' ) || $( 'body' ).hasClass( 'tax-video_type' ) || $( 'body' ).hasClass( 'tax-band' ) ) {
				return;
			}

			var $container,
				$filterContainer,
				layoutMode = 'masonry';

			$( '.filtered-content' ).each( function() {

				$container = $( this );

				if ( ! $container.hasClass( 'isotope-initialized' ) ) {
					$container.imagesLoaded( function() {
						$container.isotope( {
							itemSelector : '.entry',
							animationEngine: 'best-available'
						} );
					} ).addClass( 'isotope-initialized' );
				} else {
					console.log( 'Already loaded' );
				}
			} );

			$( '.category-filter a' ).on( 'click', function( event ) {

				event.preventDefault();

				if ( $( this ).hasClass( 'category-filter-post' ) ) {
					return;
				}

				var selector = $( this ).attr( 'data-filter' );
				$( this ).attr( 'href', '#' );

				$filterContainer = $( this ).parent().parent().parent();
				$container = $filterContainer.next( '.filtered-content' );

				if ( $container.hasClass( 'metro-container' ) ) {
					layoutMode = 'packery';
				}

				if ( $container.hasClass( 'isotope-initialized' ) ) {
					$container.imagesLoaded( function() {
						$container.isotope( {
							filter : '.' + selector,
							itemSelector : '.entry',
							layoutMode : layoutMode,
							animationEngine : 'best-available'
						} );
					} );

					//$container.isotope( 'once', 'arrangeComplete', function() {
					//	$container.find( '.entry' ).removeClass( 'animated' );
					//} );
				}

				$filterContainer.find( 'a' ).removeClass( 'active' );
				$( this ).addClass( 'active' );
				
				setTimeout( function() {
					$( window ).trigger( 'resize' );
				}, 500 );
				
				return false;
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		PrequelleCategoryFilter.init();
	} );

} )( jQuery );