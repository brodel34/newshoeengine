/*!
 * Main Theme Methods
 *
 * Prequelle 1.0.4
 */
/* jshint -W062 */
/* global PrequelleParams, WOW, AOS, WVC, Cookies, Event, objectFitImages, WVCBigText, WVCParams, Vimeo */

var PrequelleUi = function( $ ) {

	'use strict';

	return {
		isWVC : 'undefined' !== typeof WVC,
		lastScrollTop : 0,
		timer : null,
		clock : 0,
		initFlag : false,
		debugLoader : false,
		defaultHeroFont : 'light',
		isEdge : ( navigator.userAgent.match( /(Edge)/i ) ) ? true : false,
		isMobile : ( navigator.userAgent.match( /(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i ) ) ? true : false,
		isApple : ( navigator.userAgent.match( /(Safari)|(iPad)|(iPhone)|(iPod)/i ) && navigator.userAgent.indexOf( 'Chrome' ) === -1 && navigator.userAgent.indexOf( 'Android' ) === -1 ) ? true : false,

		/**
		 * Init all functions
		 */
		init : function () {

			this.isMobile = PrequelleParams.isMobile;

			if ( this.initFlag ) {
				return;
			}

			var _this = this;

			this.loadingAnimation();

			this.centeredLogo();
			this.svgLogo();
			this.centeredLogoOffset();

			this.setClasses();

			this.fluidVideos();
			this.resizeVideoBackground();

			this.muteVimeoBackgrounds();

			this.parallax();

			this.flexSlider();

			this.lightbox();

			this.animateAnchorLinks();
			this.heroScrollDownArrow();

			this.lazyLoad();

			this.addItemAnimationDelay();

			/* Portfolio */
			this.stickyElements();
			this.adjustSidebarPadding();

			/* Menu functions */
			this.megaMenuWrapper();
			this.megaMenuTagline();
			this.menuDropDown();
			this.subMenuDropDown();
			this.subMenuDirection();
			this.toggleMenu();

			this.toggleSearchForm();
			this.liveSearch();

			//this.WolfPluginShortcodeAnimation();

			this.WooCommerceLiveSearch();

			this.footerPageMarginBottom();

			this.isolateScroll();

			this.tooltipsy();

			this.commentReplyLinkSmoothScroll();

			this.setInternalLinkClass();
			this.transitionCosmetic();

			this.objectFitfallback();

			this.pausePlayersButton();

			this.adjustmentClasses();

			this.photoSizesOptionToggle();

			// @todo merge all 3
			this.minimalPlayer();
			this.navPlayer();
			this.loopPostPlayer();

			this.setEventSizeClass();

			this.wvcfullPageEvents();

			//this.addResizedEvent();

			//this.headerScrollDownMousewheel();

			this.artistTabs();

			

			this.wvcEventCallback();


			// Resize event
			$( window ).resize( function() {
				//_this.centeredLogoOffset();
				_this.subMenuDirection();
				_this.resizeVideoBackground();
				_this.mobileMenuBreakPoint();
				_this.footerPageMarginBottom();
				_this.setEventSizeClass();
			} ).resize();

			// Scroll event
			$( window ).scroll( function() {
				var scrollTop = $( window ).scrollTop();
				_this.topLinkAnimation( scrollTop );
				_this.stickyMenu( scrollTop );
				_this.setActiveOnePageMenuItem( scrollTop );
			} );

			//$( window ).unload( function() {
				//Cookies.remove( PrequelleParams.themeSlug + '_session_loaded' );
			//} );

			_this.initFlag = true;

			$( window ).bind( 'pageshow', function( event ) {
				if ( event.originalEvent.persisted ) {
					window.location.reload();
				}
			} );
		},

		/**
		 * Set body classes
		 */
		setClasses : function () {

			if ( this.isMobile ) {
				$( 'body' ).addClass( 'is-mobile' );
			} else {
				$( 'body' ).addClass( 'not-mobile' );
			}

			if ( ( this.isMobile || 800 > $( window ).width() ) && ! PrequelleParams.forceAnimationMobile ) {
				$( 'body' ).addClass( 'no-animations' );
			}

			if ( this.isApple ) {
				$( 'body' ).addClass( 'is-apple' );
			}

			if ( $( '#secondary' ).length ) {
				$( 'body' ).addClass( 'has-secondary' );
			} else {
				$( 'body' ).addClass( 'no-secondary' );
			}
		},

		/**
		 * Detect transition ending
		 */
		transitionEventEnd : function () {
			var t, el = document.createElement( 'transitionDetector' ),
				transEndEventNames = {
					'WebkitTransition' : 'webkitTransitionEnd',// Saf 6, Android Browser
					'MozTransition'    : 'transitionend',      // only for FF < 15
					'transition'       : 'transitionend'       // IE10, Opera, Chrome, FF 15+, Saf 7+
				};

			for ( t in transEndEventNames ) {
				if ( el.style[t] !== undefined ) {
					return transEndEventNames[t];
				}
			}
		},

		/**
		 * Detect animation ending
		 */
		animationEventEnd : function () {
			var t, el = document.createElement( 'animationDetector' ),

				animations = {
				'animation'      : 'animationend',
				'OAnimation'     : 'oAnimationEnd',
				'MozAnimation'   : 'animationend',
				'WebkitAnimation': 'webkitAnimationEnd'
			};

			for ( t in animations ) {
				if ( el.style[t] !== undefined ) {
					return animations[t];
				}
			}
		},

		/**
		 * Loading overlay animation
		 */
		loadingAnimation : function () {

			if ( ! PrequelleParams.defaultPageLoadingAnimation ) {
				return false;
			}

			var _this = this;

			// timer to display the loader if loading last more than 1 sec
			_this.timer = setInterval( function() {

				_this.clock++;

				/**
				 * If the loading time last more than n sec, we hide the overlay anyway
				 * An iframe such as a video or a google map probably takes too much time to load
				 * So let's show the page
				 */
				if ( 5 === _this.clock ) {
					_this.hideLoader();
				}

			}, 1000 );
		},

		/**
		 * Convert SVG logo image to inline SVG
		 */
		svgLogo : function () {

			$( 'img.svg' ).each( function() {
				var $img = $( this ),
					imgID = $img.attr( 'id' ),
					imgClass = $img.attr( 'class' ),
					imgURL = $img.attr( 'src' ),
					$svg;

				$.get( imgURL, function( data ) {

					$svg = $( data ).find( 'svg' );

					if ( typeof imgID !== 'undefined' ) {
						$svg = $svg.attr( 'id', imgID );
					}

					if ( typeof imgClass !== 'undefined' ) {
						$svg = $svg.attr( 'class', imgClass + ' replaced-svg' );
					}

					$svg = $svg.removeAttr( 'xmlns:a' );

					// Replace image with new SVG
					$img.replaceWith( $svg );

				}, 'xml');
			} );
		},

		/**
		 * Add resized event
		 */
		addResizedEvent : function () {

			var resizeTimer = 0;

			$( window ).on( 'resize', function() {

				clearTimeout( resizeTimer );
				resizeTimer = setTimeout(function() {

					$( window ).trigger( 'resized' );

				}, 500 );
			} );
		},

		/**
		 * Sticky Portfolio Sidebar
		 */
		stickyElements : function () {
			if ( $.isFunction( $.fn.stick_in_parent ) ) {
				if ( $( 'body' ).hasClass( 'single-work-layout-sidebar-left' ) || $( 'body' ).hasClass( 'single-work-layout-sidebar-right' ) ) {
					$( '.work-info-container' ).stick_in_parent( {
						offset_top : parseInt( PrequelleParams.portfolioSidebarOffsetTop, 10 )
					} );
				}
			}
		},

		/**
		 * Adjust sidebar padding depending on WVC row padding
		 */
		adjustSidebarPadding : function () {
			if ( $( 'body' ).hasClass( 'wolf-visual-composer' ) ) {
				if ( $( 'body' ).hasClass( 'single-work-layout-sidebar-left' ) || $( 'body' ).hasClass( 'single-work-layout-sidebar-right' ) ) {
					if ( $( '.wvc-row' ).length ) {
						var paddingTop = $( '.wvc-row' ).first().css( 'padding-top' ),
							paddingBottom = $( '.wvc-row' ).last().css( 'padding-top' );

						if ( 50 <= parseInt( paddingTop, 10 ) ) {
							$( '.work-info-container' ).css( { 'padding-top' : paddingTop } );
						}

						if ( 50 <= parseInt( paddingBottom, 10 ) ) {
							$( '.work-info-container' ).css( { 'padding-bottom' : paddingBottom } );
						}
					}
				}
			}
		},

		/**
		 *  Add a mobileMenuBreakpoint class for mobile
		 */
		mobileMenuBreakPoint : function () {

			var $body = $( 'body' ),
				winWidth = $( window ).width(),
				breakpoint = PrequelleParams.breakPoint;

			if ( breakpoint > winWidth ) {

				$body.addClass( 'breakpoint' );
				$body.removeClass( 'desktop' );

				// Remove all panel toggle class
				$body.removeClass( 'offcanvas-menu-toggle' );
				$body.removeClass( 'overlay-menu-toggle' );
				$body.removeClass( 'side-panel-toggle' );

				$( window ).trigger( 'prequelle_breakpoint' );

			} else {

				$body.removeClass( 'breakpoint' );
				$body.removeClass( 'mobile-menu-toggle' ); // close mobile menu if open
				$body.addClass( 'desktop' );
			}

			if ( 800 > winWidth ) {

				$body.addClass( 'mobile' );

			} else {
				$body.removeClass( 'mobile' );
			}
		},

		/**
		 * Change 2nd level sub menu direction if it's off screen
		 */
		subMenuDirection : function() {

			var $this,
				subMenuWidth = parseInt( PrequelleParams.subMenuWidth, 10 ),
				bleed = 8;

			$( '#site-navigation-primary-desktop > li.menu-parent-item:not(.mega-menu)' ).each( function() {

				$this = $( this );

				if ( $this.offset().left + bleed + subMenuWidth > $( window ).width() ) {
					$this.find( '> ul.sub-menu' ).addClass( 'reversed-first-level-sub-menu' );
				}
			} );

			$( '#site-navigation-primary-desktop > li.menu-parent-item:not(.mega-menu)' ).each( function() {

				$this = $( this );

				if ( $this.offset().left + bleed + ( subMenuWidth * 2 ) > $( window ).width() ) {
					$this.find( '> ul.sub-menu li > ul.sub-menu' ).addClass( 'reversed-sub-menu' );
				}
			} );
		},

		/**
		 * Resize Video Background
		 */
		resizeVideoBackground : function () {

			var videoContainer = $( '.video-bg-container' );

			videoContainer.each( function() {
				var videoContainer = $( this ),
					containerWidth = videoContainer.width(),
					containerHeight = videoContainer.height(),
					ratioWidth = 640,
					ratioHeight = 360,
					$video = $( this ).find( '.video-bg' ),
					//video = document.getElementById( $video.attr( 'id' ) ),
					newHeight,
					newWidth,
					newMarginLeft,
					newMarginTop,
					newCss;

				if ( videoContainer.hasClass( 'youtube-video-bg-container' ) ) {
					$video = videoContainer.find( 'iframe' );
					ratioWidth = 560;
					ratioHeight = 315;

				} else {
					// fallback
					if ( this.isTouch && 800 > $( window ).width() ) {
						// console.log( this.isTouch );
						videoContainer.find( '.video-bg-fallback' ).css( { 'z-index' : 1 } );
						$video.remove();
						return;
					}
				}

				if ( ( containerWidth / containerHeight ) >= 1.8 ) {
					newWidth = containerWidth;

					newHeight = Math.ceil( ( containerWidth/ratioWidth ) * ratioHeight ) + 2;
					newMarginTop =  - ( Math.ceil( ( newHeight - containerHeight  ) ) / 2 );
					newMarginLeft =  - ( Math.ceil( ( newWidth - containerWidth  ) ) / 2 );

					newCss = {
						width : newWidth,
						height : newHeight,
						marginTop :  newMarginTop,
						marginLeft : newMarginLeft
					};

					$video.css( newCss );

				} else {
					newHeight = containerHeight;
					newWidth = Math.ceil( ( containerHeight/ratioHeight ) * ratioWidth );
					newMarginLeft =  - ( Math.ceil( ( newWidth - containerWidth  ) ) / 2 );

					newCss = {
						width : newWidth,
						height : newHeight,
						marginLeft :  newMarginLeft,
						marginTop : 0
					};

					$video.css( newCss );
				}
			} );
		},

		/**
		 * Centered logo
		 */
		centeredLogo : function () {

			if ( ! $( 'body' ).hasClass( 'menu-layout-centered-logo' ) ) {
				return;
			}

			var
				//logoWidth = $( '.logo-container' ).width(),
				$socialMenuItems = $( '#site-navigation-primary-desktop > li.social-menu-item' ),
				$firstLevelItems = $( '#site-navigation-primary-desktop > li:not(.social-menu-item)' ),
				itemLenght = $firstLevelItems.length,
				middleItemCount;

			itemLenght = $firstLevelItems.length;

			if ( $socialMenuItems.length  ) {
				itemLenght++;
			}

			middleItemCount = Math.round( parseFloat( itemLenght / 2, 10 ) );

			$firstLevelItems.each( function( index ) {
				if ( middleItemCount > index ) {
					$( this ).addClass( 'before-logo' );
				} else {
					$( this ).addClass( 'after-logo' );
				}
			} );

			// Insert logo
			$( '<li class="logo-menu-item">' + PrequelleParams.logoMarkup + '</li>' ).insertAfter( '#site-navigation-primary-desktop > li:nth-child(' + middleItemCount + ')' );
		},

		/**
		 * Adjust logo offset
		 */
		centeredLogoOffset : function () {

			if ( ! $( 'body' ).hasClass( 'menu-layout-centered-logo' ) ) {
				return;
			}

			$( '.nav-menu-desktop .logo' ).removeAttr( 'style' );
			$( '#site-navigation-primary-desktop' ).removeAttr( 'style' );

			var $desktopMenu = $( '#site-navigation-primary-desktop' ),
				windowCenter = $( window ).width() / 2,
				logoPositionLeft = windowCenter - $( '.nav-menu-desktop .logo' ).offset().left,
				targetLeft = windowCenter - ( windowCenter - $( '.nav-menu-desktop .logo' ).outerWidth() / 2 ),
				offset = logoPositionLeft - targetLeft;

			if ( $( 'body' ).hasClass( 'menu-width-boxed' ) ) {

				$desktopMenu.css( { 'left' : offset } );

			} else if ( $( 'body' ).hasClass( 'menu-width-wide' ) ) {

				$( '.nav-menu-desktop .logo' ).css( { 'left' : offset } );
			}
		},

		/**
		 * stickyMenu
		 */
		stickyMenu : function ( scrollTop ) {

			var scrollPoint,
				menuOffset = parseInt( PrequelleParams.menuOffset, 10 );

			scrollTop = scrollTop || 0;

			scrollPoint = parseInt( PrequelleParams.stickyMenuScrollPoint, 10 );

			if ( ! menuOffset && ( 'soft' === PrequelleParams.stickyMenuType || 'none' === PrequelleParams.stickyMenuType ) ) {
				if ( 10 < scrollTop ) {
					$( 'body' ).addClass( 'untop' );
					$( 'body' ).removeClass( 'attop' );

				} else {
					$( 'body' ).addClass( 'attop' );
					$( 'body' ).removeClass( 'untop' );
				}
			}

			if ( menuOffset ) {
				scrollPoint = menuOffset - parseInt( PrequelleParams.desktopMenuHeight, 10 );
			}

			if ( 'soft' === PrequelleParams.stickyMenuType ) {

				if ( scrollTop < this.lastScrollTop && scrollPoint < scrollTop ) {

					$( 'body' ).addClass( 'sticking' );
					this.centeredLogoOffset();

				} else {
					$( 'body' ).removeClass( 'sticking' );
				}

				this.lastScrollTop = scrollTop;

			} else if ( 'hard' === PrequelleParams.stickyMenuType ) {

				if ( scrollPoint < scrollTop ) {

					$( 'body' ).addClass( 'sticking' );
					this.centeredLogoOffset();

				} else {
					$( 'body' ).removeClass( 'sticking' );
				}
			}
		},

		/**
		 * Wrap mega menu
		 */
		megaMenuWrapper : function () {
			$( '#site-navigation-primary-desktop .mega-menu' ).find( '> ul.sub-menu' ).each( function() {
				$( this ).wrap( '<div class="mega-menu-panel" />' ).wrap( '<div class="mega-menu-panel-inner" />' );
			} );
		},

		/**
		 * Reveal sub menu on hover
		 */
		menuDropDown : function () {

			var _this = this, $li;

			$( '.nav-menu-desktop .menu-parent-item' ).on( {

				mouseenter: function() {
					$li = $( this );

					_this.subMenuDirection();

					if ( ! $( this ).parents( '.sub-menu' ).length ) {
						$( this ).find( '> ul.sub-menu' ).show( 0, function() {

							// Fixes transition not firing on chrome
							setTimeout( function() {
								$li.addClass( 'hover' );
							}, 100 );
						} );

						$( this ).find( '> .mega-menu-panel' ).show( 0, function() {
							setTimeout( function() {
								$li.addClass( 'hover' );
							}, 100 );
						} );

						$( this ).find( '> .mega-menu-tagline' ).show( 0, function() {
							setTimeout( function() {
								$li.addClass( 'hover' );
							}, 100 );
						} );
					}
				},

				mouseleave: function() {
					$( this ).removeClass( 'hover' );
					$( this ).find( '> ul.sub-menu, > .mega-menu-panel, > .mega-menu-tagline' ).removeAttr( 'style' );
				}
			});
		},

		/**
		 * Set mega menu tagline
		 */
		megaMenuTagline : function () {

			$( '#site-navigation-primary-desktop .mega-menu' ).each( function() {
				var $this = $( this ),
					$submenu = $this.find( '.mega-menu-panel' ).first(),
					tagline = $this.find( 'a' ).data( 'mega-menu-tagline' ),
					$tagline;

				if ( tagline ) {
					$tagline = $( '<div class="mega-menu-tagline"><span class="mega-menu-tagline-text">' + tagline + '</span></div>' );
					$tagline.insertBefore( $submenu );
				}
			} );
		},

		/**
		 * Scroll down on mousewheel down for full height header
		 */
		headerScrollDownMousewheel : function() {
			
			var _this = this;

			if ( $( 'body' ).hasClass( 'hero-layout-fullheight' ) ) {
				$( '#hero' ).bind( 'mousewheel', function( e ) {
					if ( e.originalEvent.wheelDelta / 120 <  0) {
						_this.scrollToMainContent();
					}
				} );
			}
		},

		/**
		 * Parallax header
		 */
		parallax : function () {

			var smallScreen = ( ( 800 > $( window ).width() || this.isMobile ) && PrequelleParams.parallaxNoSmallScreen );

			if ( ! smallScreen ) {
				$( '.parallax' ).jarallax( {
					noAndroid : PrequelleParams.parallaxNoAndroid,
					noIos : PrequelleParams.parallaxNoIos
				} );
			}
		},

		/**
		 * Toggle mobile menu
		 */
		toggleMenu : function () {
			$( '.toggle-mobile-menu' ).on( 'click', function( event ) {
				event.preventDefault();
				$( 'body' ).toggleClass( 'mobile-menu-toggle' );
			} );

			$( '.toggle-side-panel' ).on( 'click', function( event ) {
				event.preventDefault();
				$( 'body' ).toggleClass( 'side-panel-toggle' );
			} );

			$( '.toggle-offcanvas-menu' ).on( 'click', function( event ) {
				event.preventDefault();
				$( 'body' ).toggleClass( 'offcanvas-menu-toggle' );
			} );

			$( '.toggle-overlay-menu' ).on( 'click', function( event ) {
				event.preventDefault();
				$( window ).trigger( 'prequelle_overlay_menu_toggle_button_click', [ $( this ) ] );
				$( 'body' ).toggleClass( 'overlay-menu-toggle' );
			} );
		},

		/**
		 * Mobile sub menus toggles
		 */
		subMenuDropDown : function () {
			var dropDown = '.nav-menu-mobile .menu-parent-item > a, .nav-menu-vertical .menu-parent-item > a';

			$( document ).on( 'click', dropDown, function( event ) {
				var $link = $( this ),
					$linkSubmenu = $( this ).parent().find( 'ul:first' );

				event.preventDefault();
				// event.stopPropagation();

				if ( $linkSubmenu.length ) {

					// close if open
					if ( $linkSubmenu.hasClass( 'menu-item-open' ) ) {
						$linkSubmenu.slideUp();
						$linkSubmenu.removeClass( 'menu-item-open' );

					// proceed
					} else {
						// close other submenu
						$link.parent().parent().find( 'ul.sub-menu.menu-item-open' ).slideUp().removeClass( 'menu-item-open' );

						$linkSubmenu.slideDown();
						$linkSubmenu.addClass( 'menu-item-open' );
					}
				}

				return false;
			} );
		},

		/**
		 * Toggle navigation search form
		 */
		toggleSearchForm : function () {
			$( document ).on( 'click', '.toggle-search', function() {
				$( window ).trigger( 'prequelle_searchform_toggle' );
				$( 'body' ).toggleClass( 'search-form-toggle' );
			} );
		},

		/**
		 * Fluid iframe videos
		 */
		fluidVideos : function ( container, force ) {

			force = force || false;

			if ( $( 'body' ).hasClass( 'wolf-visual-composer' ) && false === force ) {
				return;
			}

			container = container || $( '#page' );

			var videoSelectors = [
				'iframe[src*="player.vimeo.com"]',
				'iframe[src*="youtube.com"]',
				'iframe[src*="youtube-nocookie.com"]',
				'iframe[src*="youtu.be"]',
				'iframe[src*="kickstarter.com"][src*="video.html"]',
				'iframe[src*="screenr.com"]',
				'iframe[src*="blip.tv"]',
				'iframe[src*="dailymotion.com"]',
				'iframe[src*="viddler.com"]',
				'iframe[src*="qik.com"]',
				'iframe[src*="revision3.com"]',
				'iframe[src*="hulu.com"]',
				'iframe[src*="funnyordie.com"]',
				'iframe[src*="flickr.com"]',
				'embed[src*="v.wordpress.com"]',
				'iframe[src*="videopress.com"]'
			];

			container.find( $( videoSelectors.join( ',' ) ).not( '.vimeo-bg, .youtube-bg' ) ).wrap( '<span class="fluid-video" />' );
			$( '.rev_slider_wrapper' ).find( videoSelectors.join( ',' ) ).unwrap(); // disabled for revslider videos
			$( '.fluid-video' ).parent().addClass( 'fluid-video-container' );
		},

		/**
		 * Flexslider galleries
		 */
		flexSlider : function () {

			if ( $.isFunction( $.flexslider ) ) {

				/* header slideshow */
				$( '.slideshow-background' ).flexslider( {
					animation: 'fade',
					controlNav: false,
					directionNav: false,
					slideshow : true,
					pauseOnHover : false,
					pauseOnAction : false,
					slideshowSpeed : 4000,
					animationSpeed : 800
				} );

				/* Slideshow custom direction nav */
				$( document ).on( 'click', '.slideshow-gallery-direction-nav-prev', function( event ) {
					event.preventDefault();
					$( this ).parents( 'article.post' ).find( '.slideshow-background' ).flexslider( 'prev' );
				} );

				$( document ).on( 'click', '.slideshow-gallery-direction-nav-next', function( event ) {
					event.preventDefault();
					$( this ).parents( 'article.post' ).find( '.slideshow-background' ).flexslider( 'next' );
				} );

				/* Entry gallery slider */
				$( '.entry-slider' ).flexslider( {
					//animation: 'fade',
					//controlNav: false,
					//directionNav: false,
					slideshow : true,
					//pauseOnHover : false,
					//pauseOnAction : false,
					slideshowSpeed : 4000
				} );
			}
		},

		/**
		 * Lightbox images
		 */
		lightbox : function () {

			var _this = this,
				rand,
				quickviewData,
				selectors = '.wvc-lightbox, .lightbox, .gallery-item a[href$=".jpg"], .gallery-item a[href$=".png"], .gallery-item a[href$=".gif"], .gallery-item a[href$=".svg"]';

			// get rel attr and set it as data-fancybox attribute to create a gallery
			$( '.wvc-gallery .wvc-lightbox' ).each( function() {
				$( this ).attr( 'data-fancybox', $( this ).data( 'rel' ) );
			} );

			rand = Math.floor( ( Math.random() * 9999 ) + 1 );

			// set a random number to set a gallery
			$( '.gallery' ).each( function() {
				rand = Math.floor( ( Math.random() * 9999 ) + 1 );

				$( this ).find( '.gallery-item a:not(.select-action)' ).each( function() {
					$( this ).attr( 'data-fancybox', 'gallery-' + rand );
				} );
			} );

			if ( 'fancybox' === PrequelleParams.lightbox ) {

				$( selectors ).fancybox();

				/* Gallery quickview */
				$( '.gallery-quickview, .wvc-gallery-quickview' ).unbind().on( 'click', function() {
					event.preventDefault();
					event.stopPropagation();

					quickviewData = $( this ).data( 'gallery-params' );

					$.fancybox.open( quickviewData );
					return false;
				} );

				/* WC product images quickview */
				$( '.woocommerce-product-gallery__trigger' ).unbind().on( 'click', function() {
					event.preventDefault();
					event.stopPropagation();

					quickviewData = _this.getProductGalleryItems( $( this ).parent().find( '.woocommerce-product-gallery__image' ) );

					$.fancybox.open( quickviewData );
					return false;
				} );

				/* Disable lighbox when zoom is off and slider is on */
				$( '.woocommerce-product-gallery__image a' ).unbind().on( 'click', function() {
					event.preventDefault();
					event.stopPropagation();

					//if ( ! $( this ).parent().hasClass( '.flex-active-slide' ) ) {
					//	$( this ).fancybox();
					//}

					return false;
				} );

				/* iFrame */
				$( '.wvc-lightbox-iframe' ).fancybox( {
					iframe : {
						css : {
							width : '600px',
							height : '450px'
						}
					},

					beforeLoad : function() {
						
						// Adjust iframe height according to the contents
						parent.jQuery.fancybox.getInstance().update();
					}
				} );

				/* Video lightbox */
				$( '.lightbox-video' ).fancybox( {

					beforeLoad : function() {
						
						PrequelleUi.pausePlayers();
					},

					afterLoad : function() {

						PrequelleUi.lightboxVideoAfterLoad();
					},

					afterClose : function() {

						PrequelleUi.restartVideoBackgrounds();
					}
				} );

			} else if ( 'swipebox' === PrequelleParams.lightbox ) {

				$( selectors ).swipebox();

				/* Video lightbox */
				$( '.lightbox-video' ).swipebox( {
					beforeLoad : function() {

						PrequelleUi.pausePlayers();
					},

					afterClose : function() {

						PrequelleUi.restartVideoBackgrounds();
					}
				} );
			}

		},

		/**
		 * Lightbox video after load callback
		 *
		 * Fire mediaelement for self hosted video
		 */
		lightboxVideoAfterLoad : function () {
			
			var $iframe = $( '.fancybox-iframe' ).contents(),
				$head = $iframe.find( 'head' ),
				$video = $iframe.find( 'video' ),
				accentColor = PrequelleParams.accentColor;
			
			if ( $video.length ) {

				// Wrap content
				$( '.fancybox-content' ).hide();

				$head.append( $( '<link/>',
					{
						rel: 'stylesheet',
						href: PrequelleParams.mediaelementLegacyCssUri,
						type: 'text/css'
					} )
				);
				$head.append( $( '<link/>',
					{
						rel: 'stylesheet',
						href: PrequelleParams.mediaelementCssUri,
						type: 'text/css'
					} )
				);

				$head.append( $( '<link/>',
					{
						rel: 'stylesheet',
						href: PrequelleParams.fancyboxMediaelementCssUri,
						type: 'text/css'
					} )
				);

				$video.mediaelementplayer();

				$iframe.find( '.mejs-container' ).find( '.mejs-time-current' ).css( {
					'background-color' : accentColor
				} );
				
				$iframe.find( '.mejs-container' )
					.wrap( '<div class="fancybox-mediaelement-container" />' )
					.wrap( '<div class="fancybox-mediaelement-inner" />' );
				
				$iframe.find( '.mejs-container' ).find( '.mejs-time-current' ).css( {
					'background-color' : accentColor
				} );

				$iframe.find( '.mejs-container' ).find( '.mejs-play' ).trigger( 'click' );

				/* Resizing */
				setTimeout( function() {
					
					$( window ).trigger( 'resize' );
					$( '.fancybox-content' ).removeAttr( 'style' ).fadeIn( 'slow' );

				}, 200 );
			}
		},

		/**
		 * Get product slides params
		 */
		getProductGalleryItems : function( $slides ) {

			var items = [];

			if ( $slides.length > 0 ) {
				$slides.each( function( i, el ) {
					var img = $( el ).find( 'img' ),
						large_image_src = img.attr( 'data-large_image' ),
						item = {
							src  : large_image_src,
							opts : {
								caption: img.attr( 'data-caption' ) ? img.attr( 'data-caption' ) : img.attr( 'title' )
							}
						};
					items.push( item );
				} );
			}

			return items;
		},

		/**
		 * Overwrite WVC video opener
		 */
		videoOpener : function() {

			if ( 'fancybox' === PrequelleParams.lightbox ) {

				$( '.wvc-video-opener' ).fancybox( {
					
					beforeLoad : function() {

						PrequelleUi.pausePlayers();
					},

					afterLoad : function() {

						PrequelleUi.lightboxVideoAfterLoad();
					},

					afterClose : function() {

						PrequelleUi.restartVideoBackgrounds();
					}
				} );

			} else if ( 'swipebox' === PrequelleParams.lightbox ) {

				$( '.wvc-video-opener' ).fancybox( {
					beforeLoad : function() {

						PrequelleUi.pausePlayers();
					},

					afterClose : function() {

						PrequelleUi.restartVideoBackgrounds();
					}
				} );
			}
		},

		/**
		 * Lazyload images
		 */
		lazyLoad : function () {
			$( '.lazy-hidden' ).lazyLoadXT();
		},

		/**
		 * Smooth scroll
		 */
		animateAnchorLinks : function () {

			var _this = this;

			$( document ).on( 'click', '.scroll, .nav-scroll a', function( event ) {

				event.preventDefault();
				event.stopPropagation();

				_this.smoothScroll( $( this ).attr( 'href' ) );
			} );

			$( document ).on( 'click', '.woocommerce-review-link', function( event ) {

				event.preventDefault();
				event.stopPropagation();

				_this.smoothScroll( '#wc-tabs-container' );
			} );
		},

		/**
		 * Smooth scroll to comment form when clicking on comment reply link
		 */
		commentReplyLinkSmoothScroll : function () {

			var _this = this;

			$( '.comment-reply-link' ).on( 'click', function( event ) {
				event.preventDefault();
				setTimeout( function() {
					_this.smoothScroll( '#respond' );
				}, 500 );
				return false;
			} );
		},

		/**
		 * Scroll to first main content from hero
		 */
		heroScrollDownArrow : function() {

			var _this = this;

			$( document ).on( 'click', '#hero-scroll-down-arrow', function( event ) {
				event.preventDefault();
				event.stopPropagation();

				_this.scrollToMainContent();
			} );
		},

		/**
		 * Scroll to main content
		 */
		scrollToMainContent : function () {

			var $target = $( '#hero' ).next( '.section' ),
				scrollOffset = this.getToolBarOffset() - 5,
				hash = '';

			if ( $target.attr( 'id' ) ) {
				hash = $target.attr( 'id' );
			}

			$( 'html, body' ).stop().animate( {

				scrollTop: $target.offset().top - scrollOffset

			}, parseInt( PrequelleParams.smoothScrollSpeed, 10 ), PrequelleParams.smoothScrollEase, function() {

				if ( '' !== hash ) {
					// push hash
					history.pushState( null, null, '#' + hash );
					//window.location.hash = hash;
				}
			} );
		},

		/**
		 * Smooth scroll to an anchor
		 */
		smoothScroll : function( href ) {
			var scrollOffset = this.getToolBarOffset() - 5,
				hash;

			if ( -1 !== href.indexOf( '#' ) ) {

				hash = href.substring( href.indexOf( '#' ) + 1 );

				if ( $( '#' + hash ).length ) {

					if ( 'hard' === PrequelleParams.stickyMenuType && ! $( '#' + hash ).hasClass( 'wvc-row-full-height' ) ) {
						scrollOffset += parseFloat( PrequelleParams.stickyMenuHeight, 10 );
					}

					$( 'html, body' ).stop().animate( {

						scrollTop: $( '#' + hash ).offset().top - scrollOffset

					}, parseInt( PrequelleParams.smoothScrollSpeed, 10 ), PrequelleParams.smoothScrollEase, function() {

						if ( '' !== hash ) {
							// push hash
							history.pushState( null, null, '#' + hash );
						}

						$( 'body' ).removeClass( 'mobile-menu-toggle' ); // close mobile menu if open
					} );

				} else {
					window.location.replace( href ); // redirect to link if anchor doesn't exist on the page
				}
			}
		},

		/**
		 * Get the height of the top admin bar and/or menu
		 */
		getToolBarOffset : function () {

			var offset = 0;

			if ( $( 'body' ).is( '.admin-bar' ) ) {

				if ( 782 < $( window ).width() ) {
					offset = 32;
				} else {
					offset = 46;
				}
			}

			if ( 'hard' === PrequelleParams.stickyMenuType ) {
				//offset = PrequelleParams.stickyMenuHeight + 60;
			}

			if ( $( '#wolf-message-bar' ).length && $( '#wolf-message-bar' ).is( ':visible' ) ) {
				offset = offset + $( '#wolf-message-bar-container' ).outerHeight();
			}

			return parseInt( offset, 10 );
		},

		/**
		 * Back to the top link animation
		 */
		topLinkAnimation : function( scrollTop ) {

			if ( scrollTop >= 550 ) {
				$( 'a#back-to-top' ).addClass( 'back-to-top-visible' );
			} else {
				$( 'a#back-to-top' ).removeClass( 'back-to-top-visible' );
			}

			$( document ).on( 'click', 'a#back-to-top', function( event ) {
				event.preventDefault();

				$( 'html, body' ).stop().animate( {

					scrollTop: 0

				}, parseInt( PrequelleParams.smoothScrollSpeed, 10 ), PrequelleParams.smoothScrollEase );
			} );
		},

		/**
		 * Add animation to Wolf Plugin shortcodes
		 */
		/*WolfPluginShortcodeAnimation : function() {

			$( '.shortcode-video-grid, .shortcode-gallery-grid, .shortcode-release-grid, .shortcode-testimonial-grid' ).each( function() {

				var $container = $( this ),
					anim = $container.data( 'animation-parent' ),
					animDelay = 0;

				if ( anim ) {
					$container.find( 'article' ).each( function() {
						animDelay = animDelay + 200;
						$( this ).addClass( 'wow ' + anim ).css( {
							'animation-delay' : animDelay / 1000 + 's',
							'-webkit-animation-delay' : animDelay / 1000 + 's'
						} );
					} );
				}

			} );
		},*/

		/**
		 * Use Wow plugin to reveal animation on page scroll
		 */
		wowAnimate : function () {

			var wowAnimate,
				doWow = ( PrequelleParams.forceAnimationMobile || ( ! this.isMobile && 800 < $( window ).width() ) );

			if ( doWow && 'undefined' !==  typeof WOW ) {
				wowAnimate = new WOW( { offset : PrequelleParams.WOWAnimationOffset } ); // init wow for CSS animation
				wowAnimate.init();
			}
		},

		/**
		 * Use AOS plugin to reveal animation on page scroll (new)
		 */
		AOS : function ( selector ) {

			var forceAnimationMobile = false,
				doWow,
				disable;

			if ( 'undefined' !== typeof WVCParams ) {
				forceAnimationMobile = WVCParams.forceAnimationMobile;
			}

			doWow = ( forceAnimationMobile || ( ! this.isMobile && 800 < $( window ).width() ) );
			disable = ! doWow;

			selector = selector || '#content';

			if ( 'undefined' !== typeof AOS ) {

				AOS.init( {
					disable: disable
				} );
			}
		},

		/**
		 * Item animation delay (now uses AOS)
		 */
		addItemAnimationDelay : function () {

			var animDelay = 0;

			$( '.entry[data-aos]' ).each( function() {
				animDelay = animDelay + 150;

				$( this ).attr( 'data-aos-delay', animDelay );
			} );
		},

		/**
		 * Live Search
		 */
		liveSearch : function () {

			if ( ! PrequelleParams.doLiveSearch ) {
				return;
			}

			var searchInput = $( '.nav-search-form' ).find( 'input[type="search"]' ),
				$loader = $( '#nav-search-loader' ),
				timer = null,
				$resultContainer,
				action = 'prequelle_ajax_live_search',
				result;

			if ( $( '.nav-search-form' ).hasClass( 'search-type-shop' ) ) {
				action = 'prequelle_ajax_woocommerce_live_search';
			}

			$( '<div class="live-search-results"><ul></u></div>' ).insertAfter( searchInput );

			$resultContainer = $( '.live-search-results' ),
			result = $resultContainer.find( 'ul' );

			searchInput.on( 'keyup', function( event ) {

				// clear the previous timer
				clearTimeout( timer );

				var $this = $( this ),
					term = $this.val();

				if ( 8 === event.keyCode || 46 === event.keyCode ) {
					//console.log( 'back' );
					$resultContainer.fadeOut();
					$loader.fadeOut();

				} else if ( '' !== term ) {

					// 200ms delay so we dont exectute excessively
					timer = setTimeout( function() {

						$loader.fadeIn();

						var data = {

							action : action,
							s : term
						};

						//console.log( data );

						$.post( PrequelleParams.ajaxUrl, data, function( response ) {

							if ( '' !== response ) {

								result.empty().html( response );
								$resultContainer.fadeIn();
								$loader.fadeOut();

								//result.find( 'li' ).on( 'click', function() {
								//	var text = $( this ).find( '.term-text' ).text();
								//	//console.log( text );
								//	searchInput.val( text );
								// } );

							} else {
								$resultContainer.fadeOut();
								$loader.fadeOut();
							}
						} );
					}, 200 ); // timer

				} else {
					$resultContainer.fadeOut();
					$loader.fadeOut();
				}
			} );
		},

		/**
		 * Live Search
		 */
		WooCommerceLiveSearch : function() {

			if ( ! PrequelleParams.doLiveSearch ) {
				return;
			}

			var searchInput = $( '#menu-product-search-form-container' ).find( 'input[type="search"]' ),
				$loader = $( '#product-search-form-loader' ),
				timer = null,
				$resultContainer,
				result;

			$( '<div id="woocommerce-live-search-results"><ul></u></div>' ).insertAfter( searchInput );

			$resultContainer = $( '#woocommerce-live-search-results' ),
			result = $resultContainer.find( 'ul' );

			searchInput.on( 'keyup', function( event ) {

				// clear the previous timer
				clearTimeout( timer );

				var $this = $( this ),
					term = $this.val();

				if ( 8 === event.keyCode || 46 === event.keyCode ) {
					//console.log( 'back' );
					$resultContainer.fadeOut();
					$loader.fadeOut();

				} else if ( '' !== term ) {

					// 600ms delay so we dont exectute excessively
					timer = setTimeout( function() {

						$loader.fadeIn();

						var data = {

							action : 'prequelle_ajax_woocommerce_live_search',
							s : term
						};

						$.post( PrequelleParams.ajaxUrl , data, function( response ) {

							//console.log( response );

							if ( '' !== response ) {

								result.empty().html( response );
								$resultContainer.fadeIn();
								$loader.fadeOut();

								//result.find( 'li' ).on( 'click', function() {
								//	var text = $( this ).find( '.term-text' ).text();
								//	//console.log( text );
								//	searchInput.val( text );
								// } );

							} else {
								$resultContainer.fadeOut();
								$loader.fadeOut();
							}
						} );
					}, 600 ); // timer

				} else {
					$resultContainer.fadeOut();
					$loader.fadeOut();
				}
			} );
		},

		/**
		 * Hide loading overlay
		 */
		hideLoader : function () {

			if ( this.debugLoader ) {
				return false;
			}

			var $body = $( 'body' );

			clearInterval( this.timer );
			$body.removeClass( 'loading' );
			$body.addClass( 'loaded' );
			$( window ).trigger( 'hide_loader' );
		},

		/**
		 * Add page bottom padding for "uncover" footer type
		 */
		footerPageMarginBottom : function () {
			if ( $( 'body' ).hasClass( 'footer-type-uncover' ) && ! $( 'body' ).hasClass( 'error404' ) ) {
				var footerHeight = $( '.site-footer' ).height() - 2;
				$( '#page-content' ).css( { 'margin-bottom' : footerHeight } );
			} else {
				$( '#page-content' ).css( { 'margin-bottom' : 0 } );
			}
		},

		/**
		 * Provide compatibility for browser unsupported features
		 */
		objectFitfallback : function () {

			if ( this.isEdge ) {
				objectFitImages();
			}
		},

		/**
		 * Isolate side panel scroll
		 */
		isolateScroll : function () {
			$( '.side-panel-inner, #vertical-bar-panel-inner, #vertical-bar-overlay-inner' ).on( 'mousewheel DOMMouseScroll', function( e ) {

				var d = e.originalEvent.wheelDelta || -e.originalEvent.detail,
					dir = d > 0 ? 'up' : 'down',
					stop = ( dir === 'up' && this.scrollTop === 0 ) ||
					( dir === 'down' && this.scrollTop === this.scrollHeight - this.offsetHeight );
					stop && e.preventDefault();
			} );
		},

		/**
		 * Tooltip
		 */
		tooltipsy : function () {
			if ( ! this.isMobile ) {

				var $tipspan,
					selectors = '.hastip, .wvc-ati-link:not(.wvc-ati-add-to-cart-button), .wvc-ati-add-to-cart-button-title, .wpm-track-icon:not(.wpm-add-to-cart-button), .wpm-add-to-cart-button-title, .wolf-release-button a:not(.wolf-release-add-to-cart), .wolf-release-add-to-cart-button-title, .wolf-share-link, .loop-release-button-link, .wolf-share-button-count, .single-add-to-wishlist .wolf_add_to_wishlist';

				$( selectors ).tooltipsy();

				$( document ).on( 'added_to_cart', function( event, fragments, cart_hash, $button ) {

					if ( $button.hasClass( 'wvc-ati-add-to-cart-button' ) || $button.hasClass( 'wpm-add-to-cart-button' ) || $button.hasClass( 'wolf-release-add-to-cart' ) ) {

						$tipspan = $button.find( 'span' );

						$tipspan.data( 'tooltipsy' ).hide();
						$tipspan.data( 'tooltipsy' ).destroy();

						$tipspan.attr( 'title', PrequelleParams.l10n.addedToCart );

						$tipspan.tooltipsy();
						$tipspan.data( 'tooltipsy' ).show();

						setTimeout( function() {
							$tipspan.data( 'tooltipsy' ).hide();
							$tipspan.data( 'tooltipsy' ).destroy();
							$tipspan.attr( 'title', PrequelleParams.l10n.addToCart );
							$tipspan.tooltipsy();
						}, 3000 );

					}
				} );
			}
		},

		/**
		 * Add class to link that will be ajaxify
		 *
		 * Then remove it for the ones we don't want
		 */
		setInternalLinkClass : function () {

			var siteURL = PrequelleParams.siteUrl,
				$internalLinks,
				regEx = '';

			$.each( PrequelleParams.allowedMimeTypes, function( index, value ) {
				regEx += '|' + value;
			} );

			regEx = $.trim( regEx ).substring(1);

			siteURL = PrequelleParams.siteUrl;

			$internalLinks = $( 'a[href^="' + siteURL + '"], a[href^="/"], a[href^="./"], a[href^="../"]' );

			// exclude downloadable files
			$internalLinks = $internalLinks.not( function() {
				return $( this ).attr( 'href' ).match( '.(' + regEx + ')$' );
			} );

			$internalLinks.addClass( 'internal-link' );

			if ( PrequelleParams.isWooCommerce ) {

				/*
				When WC pages aren't set the WC pages variables will return the siteURL
				Be sure it is not the same !!
				 */
				if ( this.untrailingSlashit( siteURL ) !== this.untrailingSlashit( PrequelleParams.WooCommerceCartUrl ) ) {
					$( 'a[href^="' + PrequelleParams.WooCommerceCartUrl + '"]' ).removeClass( 'internal-link' );
				}

				if ( this.untrailingSlashit( siteURL ) !== this.untrailingSlashit( PrequelleParams.WooCommerceAccountUrl ) ) {
					$( 'a[href^="' + PrequelleParams.WooCommerceAccountUrl + '"]' ).removeClass( 'internal-link' );
				}

				if ( this.untrailingSlashit( siteURL ) !== this.untrailingSlashit( PrequelleParams.WooCommerceCheckoutUrl ) ) {
					$( 'a[href^="' + PrequelleParams.WooCommerceCheckoutUrl + '"]' ).removeClass( 'internal-link' );
				}

				$( '.woocommerce-MyAccount-navigation a, .add_to_cart_button, .woocommerce-main-image, .product .images a, .product-remove a, .wc-proceed-to-checkout a, .wc-forward' ).removeClass( 'internal-link' );
			}

			$( '.wpml-ls-item, .wpml-ls-item a' ).removeClass( 'internal-link' );
			$( '[class*="wp-image-"]' ).parent().removeClass('internal-link');
			$( '.no-ajax, .loadmore-button' ).removeClass( 'internal-link' );
			$( '#wpadminbar a' ).removeClass( 'internal-link' );
			$( '.release-thumbnail a' ).removeClass( 'internal-link' );
			$( '.lightbox, .wvc-lightbox, .video-item .entry-link, .last-photos-thumbnails, .scroll, .wvc-nav-scroll' ).removeClass( 'internal-link' );
			$( '.widget_meta a, a.comment-reply-link, a#cancel-comment-reply-link, a.post-edit-link, a.comment-edit-link, a.share-link, .single .comments-link a' ).removeClass( 'internal-link' );
			$( '#blog-filter a, #albums-filter a, #work-filter a, #videos-filter a, #plugin-filter a, .logged-in-as a, #trigger a' ).removeClass( 'internal-link' );
			$( '.category-filter a, .infinitescroll-trigger-container .nav-links a, .envato-item-presentation a' ).removeClass( 'internal-link' );
			$( '.dropdown li.menu-item-has-children > a, .dropdown li.page_item_has_children > a' ).removeClass( 'internal-link' );
			$( 'a[target="_blank"], a[target="_parent"], a[target="_top"]' ).removeClass( 'internal-link' );
			$( '.nav-menu-mobile li.menu-parent-item > a' ).removeClass( 'internal-link' );
			$( '.wc-item-downloads a' ).removeClass( 'internal-link' );
			$( '.timely a' ).removeClass( 'internal-link' );
			$( '.wwcq-product-quickview-button' ).removeClass( 'internal-link' );
		},

		/**
		 * Remove slash in string
		 *
		 * Used to clean URLs
		 */
		untrailingSlashit : function ( str ) {

			str = str || '';

			if ( '/' === str.charAt( str.length - 1 ) ) {
				str = str.substr( 0, str.length - 1 );
			}

			return str;
		},

		/**
		 * Overlay transition
		 */
		transitionCosmetic : function() {

			if ( ! PrequelleParams.defaultPageTransitionAnimation ) {
				return false;
			}

			var _this = this;

			if ( PrequelleParams.isAjaxNav ) {
				return;
			}

			$( document ).on( 'click', '.internal-link:not(.disabled)', function( event ) {
				
				if ( ! event.ctrlKey ) {

					event.preventDefault();

					var $link = $( this );

					$( '.spinner' ).attr( 'id', 'spinner' );

					$( 'body' ).removeClass( 'mobile-menu-toggle overlay-menu-toggle offcanvas-menu-toggle vertical-bar-panel-toggle vertical-bar-overlay-toggle' );
					$( 'body' ).addClass( 'loading transitioning' );

					Cookies.set( PrequelleParams.themeSlug + '_session_loaded', true, { expires: null } );

					if ( PrequelleParams.hasLoadingOverlay ) {
						$( '.loading-overlay' ).one( _this.transitionEventEnd(), function() {
							Cookies.remove( PrequelleParams.themeSlug + '_session_loaded' );
							window.location = $link.attr( 'href' );
						} );
					} else {
						window.location = $link.attr( 'href' );
					}
				}
			} );
		},

		/**
		 * Set active menu item
		 */
		setActiveOnePageMenuItem : function ( scrollTop ) {
			var menuItems = $( '.menu-one-page-menu-container #site-navigation-primary-desktop li.menu-item a' ),
				menuItem,
				sectionOffset,
				threshold = 150, i;

			if ( ! menuItems.length ) {
				return;
			}

			if ( $( 'body' ).hasClass( 'wvc-fullpage' ) ) {

				$( window ).on( 'wvc_fullpage_change', function( event, targetRow ) {

					var sectionSlug = targetRow.attr( 'id' );

					if ( sectionSlug ) {
						menuItems.parent().removeClass( 'menu-link-active' );
						$( 'a.wvc-fp-nav[href="#' + sectionSlug + '"]' ).parent().addClass( 'menu-link-active' );
					}
				} );

			} else {

				for ( i = 0; i < menuItems.length; i++ ) {

					menuItem = $( menuItems[ i ] );

					if ( $( menuItem.attr( 'href' ) ).length ) {

						sectionOffset = $( menuItem.attr( 'href' ) ).offset().top;

						if ( scrollTop > sectionOffset - threshold && scrollTop < sectionOffset + threshold ) {
							menuItems.parent().removeClass( 'menu-link-active' );
							menuItem.parent().addClass( 'menu-link-active' );
						}
					}
				}
			}
		},

		/**
		 * Play pause button
		 */
		minimalPlayer : function() {

			$( document ).on( 'click', '.minimal-player-play-button', function( event ) {
				event.preventDefault();

				var $btn = $( this ),
					$audio = $btn.next( '.minimal-player-audio' ),
					audioId = $audio.attr( 'id' ),
					audio = document.getElementById( audioId );

				if ( ! $btn.hasClass( 'minimal-player-track-playing' ) ) {
					$( 'video, audio' ).trigger( 'pause' );
					$( '.minimal-player-play-button' ).removeClass( 'minimal-player-track-playing' );
					$btn.addClass( 'minimal-player-track-playing' );
					audio.play();
				} else {
					$btn.removeClass( 'minimal-player-track-playing' );
					audio.pause();
				}
			} );

			$( '.minimal-player-audio' ).bind( 'ended', function() {
				$( this ).prev( '.minimal-player-play-button' ).removeClass( 'minimal-player-track-playing' );
			} );
		},

		/**
		 * Pause other players when clicking on particular links
		 */
		pausePlayers : function() {

			if ( this.isWVC ) {
				
				WVC.pausePlayers();

				$( '.minimal-player-track-playing' ).removeClass( 'minimal-player-track-playing' );
				$( '.loop-post-player-playing' ).removeClass( 'loop-post-player-playing' );

			} else {
				$( 'audio:not(.nav-player)' ).trigger( 'pause' ); // pause audio players when opening a video
				$( 'video:not(.wvc-video-bg):not(.video-bg)' ).trigger( 'pause' );
			}
		},

		/**
		 * Play video in thumbnail on hover
		 */
		videoThumbnailPlayOnHover : function() {

			if ( this.isMobile ) {
				return;
			}

			var itemsContainer = '.items.videos';

			if ( ! $( itemsContainer ).length ) {
				return;
			}

			/* Stop YT */
			$( 'iframe.youtube-bg', itemsContainer ).each( function() {
				this.contentWindow.postMessage( '{"event":"command","func":"' + 'pauseVideo' + '", "args":""}', '*' );
			} );

			/* Stop Vimeo */
			$( 'iframe.vimeo-bg', itemsContainer ).each( function() {
				var player = new Vimeo.Player( $( this ) );
				player.pause();
			} );

			/* Stop HTML5 video */
			$( 'video.video-bg', itemsContainer ).each( function() {
				$( this ).trigger( 'pause' );
			} );

			$( '.entry-video', itemsContainer ).each( function() {

				var $iframe = $( this ).find( 'iframe' ),
					$video = $( this ).find( 'video' ),
					vimeoPlayer;

				if ( $iframe.length ) {

					if ( $iframe.hasClass( 'youtube-bg' ) ) {

						$( this ).mouseenter( function() {
							$iframe[0].contentWindow.postMessage( '{"event":"command","func":"' + 'playVideo' + '", "args":""}', '*' );
						} );

						$( this ).mouseleave( function() {
							setTimeout( function() {
								$iframe[0].contentWindow.postMessage( '{"event":"command","func":"' + 'pauseVideo' + '", "args":""}', '*' );
							}, 200 );
						} );

					} else if ( $iframe.hasClass( 'vimeo-bg' ) ) {

						vimeoPlayer = new Vimeo.Player( $iframe[0] );

						$( this ).mouseenter( function() {
							vimeoPlayer.play();
						} );

						$( this ).mouseleave( function() {

							setTimeout( function() {
								vimeoPlayer.pause();
							}, 200 );
						} );

					}

				} else if ( $video.length ) {

					$( this ).mouseenter( function() {
						$video.trigger( 'play' );
					} );

					$( this ).mouseleave( function() {

						setTimeout( function() {
							$video.trigger( 'pause' );
						}, 200 );
					} );
				}
			} );
		},

		/**
		 * Restart video BG
		 */
		restartVideoBackgrounds : function() {

			if ( this.isWVC ) {
				WVC.restartVideoBackgrounds();
			}
		},

		/**
		 * Pause other players when clicking on particular links
		 */
		pausePlayersButton : function() {
			var _this = this,
				selectors = '.wvc-embed-video-play-button, .pause-players, .audio-play-button';

			$( document ).on( 'click', selectors, function() {
				_this.pausePlayers();
			} );
		},

		/**
		 * Toggle sizes options for attahcment download page
		 * (only for Wolf Photos supported theme)
		 */
		photoSizesOptionToggle : function() {
			$( document ).on( 'click', '.button-size-options-toggle', function() {
				$( '.size-options-panel' ).toggle();
			} );

			var src, filename;

			$( document ).on( 'change', '.size-option-radio', function() {
				src = this.value;
				filename = $( this ).data( 'filename' );

				$( '.button-size-options-download' ).attr( 'href', src );
				$( '.button-size-options-download' ).attr( 'download', filename );
			} );

			$( document ).on( 'click', '.size-options-panel table tr', function() {
				$( this ).find( '.size-option-radio' ).prop( 'checked', true ).trigger( 'change' );
			} );
		},

		/**
		 * Set event list size class
		 */
		setEventSizeClass : function() {
			$( '.event-display-list' ).each( function() {
				var width = $( this ).width();

				if ( 800 > width ) {
					$( this ).removeClass( 'event-list-large' );
				} else {
					$( this ).addClass( 'event-list-large' );
				}
			} );
		},

		/**
		 * Add custom classes for styling adjustment
		 */
		adjustmentClasses : function() {
			$( '.wvc-row-is-fullwidth' ).each( function() {
				if ( $( this ).find( '.wvc-col-12 .grid-padding-no' ).length ) {
					$( this ).addClass( 'has-no-padding-grid' );
				}
			} );

			$( 'img, code' ).parent( 'a' ).addClass( 'no-link-style' );

			$( '.more-link' ).parent( 'p' ).addClass( 'no-margin' );
		},

		/**
		 * Mute Vimeo Bg
		 */
		muteVimeoBackgrounds : function () {

			$( '.vimeo-bg' ).each( function() {
				var player = new Vimeo.Player( this );

				player.on('play', function() {
					player.setVolume(0);
				} );
			} );
		},

		wvcfullPageEvents : function () {

			var _this = this,
				rowClass,
				newSkin,
				fpAnimTime = 900;

			if ( 'undefined' !== typeof WVCParams ) {
				fpAnimTime = WVCParams.fpAnimTime;
			}

			$( window ).on( 'wvc_fullpage_loaded', function() {

				// Get default hero font
				_this.defaultHeroFont = $( 'body' ).data( 'hero-font-tone' );
			} );

			$( window ).on( 'wvc_fullpage_change', function( event, targetRow ) {

				if ( $( 'body' ).hasClass( 'mobile-menu-toggle' ) ) {
					 $( 'body' ).removeClass( 'mobile-menu-toggle' );
				}

				if ( targetRow.attr( 'class' ).match( /wvc-font-(light|dark)/ ) ) {

					rowClass = targetRow.attr( 'class' );
					newSkin = rowClass.match( /wvc-font-(light|dark)/ )[1];

					//alert( newSkin );

					setTimeout( function() {
						$( 'body' ).removeClass( 'hero-font-light hero-font-dark' ).addClass( 'hero-font-' + newSkin );
						$( 'body' ).removeClass( 'page-nav-bullet-light page-nav-bullet-dark' ).addClass( 'page-nav-bullet-' + newSkin );
					}, fpAnimTime );
					
				} else {
					setTimeout( function() {
						$( 'body' ).removeClass( 'hero-font-light hero-font-dark' ).addClass( 'hero-font-' + _this.defaultHeroFont );
						$( 'body' ).removeClass( 'page-nav-bullet-light page-nav-bullet-dark' ).addClass( 'page-nav-bullet-' + _this.defaultHeroFont );
					}, fpAnimTime );
				}
			} );
		},

		/**
		 * Artist tabs
		 */
		artistTabs : function() {

			if ( $( 'body' ).hasClass( 'single-artist' ) ) {
				$( '#artist-tabs' ).tabs( {
					
					select: function( event, ui ) {
						$( ui.panel ).animate( {opacity : 0.1} );
					},
					
					show: function( event, ui ) {
						$( ui.panel ).animate( { opacity : 1.0 },1000 );
					},

					activate: function( event, ui ) {
						$( '.lazyload-bg' ).removeClass( 'lazy-hidden' );
					
						/* Tour dates */
						if ( 'undefined' !== typeof WVCBigText ) {
							WVCBigText.init();
						}
					}
				} );
			}
		},

		/**
		 * Mini nav player
		 */
		navPlayer : function () {
			$( document ).on( 'click', '.nav-play-button', function() {
				event.preventDefault();

				var $btn = $( this ),
					$container = $btn.parent(),
					$audio = $btn.next( '.nav-player' ),
					audioId = $audio.attr( 'id' ),
					audio = document.getElementById( audioId ),
					playText = PrequelleParams.l10n.playText,
					pauseText = PrequelleParams.l10n.pauseText;

				if ( ! $container.hasClass( 'nav-player-playing' ) ) {
					$( 'video, audio' ).trigger( 'pause' );
					$btn.attr( 'title', pauseText );
					$container.removeClass( 'nav-player-playing' );
					$container.addClass( 'nav-player-playing' );
					audio.play();
				} else {
					$container.removeClass( 'nav-player-playing' );
					audio.pause();
					$btn.attr( 'title', playText );
				}
			} );
		},

		/**
		 * Mini nav player
		 */
		loopPostPlayer : function () {
			$( document ).on( 'click', '.loop-post-play-button', function() {
				event.preventDefault();

				var $btn = $( this ),
					$container = $btn.parent(),
					$audio = $btn.next( 'audio' ),
					audioId = $audio.attr( 'id' ),
					audio = document.getElementById( audioId ),
					playText = PrequelleParams.l10n.playText,
					pauseText = PrequelleParams.l10n.pauseText;

				if ( ! $container.hasClass( 'loop-post-player-playing' ) ) {
					$( 'video, audio' ).trigger( 'pause' );
					$btn.attr( 'title', pauseText );
					$container.removeClass( 'loop-post-player-playing' );
					$container.addClass( 'loop-post-player-playing' );
					audio.play();
				} else {
					$container.removeClass( 'loop-post-player-playing' );
					audio.pause();
					$btn.attr( 'title', playText );
				}
			} );
		},

		/**
		 *
		 */
		wvcEventCallback : function () {
			if ( ! this.isWVC ) {
				return;
			}

			/**
			 * On fullPage anim end
			 */
			$( window ).on( 'fp-animation-end', function() {
				$( '.lazyload-bg' ).removeClass( 'lazy-hidden' );
			} );
		},

		/**
		 * Page Load
		 */
		pageLoad : function () {

			if ( ! PrequelleParams.defaultPageLoadingAnimation ) {
				return false;
			}

			var _this = this, delay;

			if ( this.debugLoader ) {
				$( 'body' ).addClass( 'loading' );
				return false;
			}

			delay = PrequelleParams.pageTransitionDelayAfter;

			setTimeout( function() {
				_this.hideLoader();
				_this.wowAnimate();
				_this.AOS();
				$( 'body' ).addClass( 'loaded' );
			}, delay );

			if ( PrequelleParams.hasLoadingOverlay ) {
				$( '.loading-overlay' ).one( _this.transitionEventEnd(), function() {
					$( window ).trigger( 'page_loaded' );
				} );
			} else {
				$( window ).trigger( 'page_loaded' );
			}

			setTimeout( function() {
				window.dispatchEvent( new Event( 'resize' ) );
				window.dispatchEvent( new Event( 'scroll' ) ); // Force WOW effect
				$( window ).trigger( 'just_loaded' );
			}, delay + 500 );

			/* Add another class 1+ sec after the page is loaded to hide loading overlay and such */
			setTimeout( function() {
				$( 'body' ).addClass( 'one-sec-loaded' );
				$( window ).trigger( 'one_sec_loaded' );
				Cookies.set( PrequelleParams.themeSlug + '_session_loaded', true, { expires: null } );


				_this.videoThumbnailPlayOnHover();

			}, parseInt( PrequelleParams.pageLoadedDelay, 10 ) );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	if ( 'undefined' !== typeof WVC ) {

		/**
		 * Overwrite WVC lightbox function with the theme function
		 */
		WVC.lightbox = PrequelleUi.lightbox;

		/**
		 * Overwrite WVC video opener
		 */
		WVC.videoOpener = PrequelleUi.videoOpener;

		/**
		 * Overwrite toolbar offset calculation
		 */
		WVC.getToolBarOffset = PrequelleUi.getToolBarOffset;
	}

	$( document ).ready( function() {
		PrequelleUi.init();
	} );

	$( window ).load( function() {
		PrequelleUi.pageLoad();
$('[data-countdown]').each(function() {
  var $this = $(this), finalDate = $(this).data('countdown');
  $this.countdown(finalDate, function(event) {
    $this.html(event.strftime('%D days %H:%M:%S'));
  });
});
	} );

} )( jQuery );