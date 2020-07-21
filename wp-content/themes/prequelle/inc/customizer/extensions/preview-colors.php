<?php
/**
 * Prequelle customizer colors preview functions
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Registers color schemes for Prequelle.
 *
 * Can be filtered with {@see 'prequelle_color_schemes'}.
 *
 * The order of colors in a colors array:
 * 0. Main Background Color.
 * 1. Page Background Color.
 * 2. Sub Menu Background Color.
 * 3. Box Background Color.
 * 4. Accent Color.
 * 5. Main Text Color.
 * 6. Secondary Text Color.
 * 7. Strong Text Color.

 * 7. Entry Content Frame Background Color.
 *
 * @return array An associative array of color scheme options.
 */
function prequelle_get_color_schemes() {
	/**
	 * Filter the color schemes registered for use with Prequelle.
	 *
	 * The default schemes include 'default', 'dark', 'light'
	 *
	 *
	 * @param array $schemes {
	 *     Associative array of color schemes data.
	 *
	 *     @type array $slug {
	 *         Associative array of information for setting up the color scheme.
	 *
	 *         @type string $label  Color scheme label.
	 *         @type array  $colors HEX codes for default colors prepended with a hash symbol ('#').
	 *                              Colors are defined in the following order: Main background, page
	 *                              background, link, main text, secondary text.
	 *     }
	 * }
	 */
	return apply_filters( 'prequelle_color_schemes', array(

		'default' => array(
			'label'  => esc_html__( 'Default', 'prequelle' ),
			'colors' => array(
				'#ffffff', // body_bg
				'#ffffff', // page_bg
				'#333333', // submenu_background_color
				'#ffffff', // submenu_font_color
				'#007acc', // accent
				'#444444', // main_text_color
				'#4c4c4c', // secondary_text_color
				'#0d0d0d', // strong_text_color
				'#007acc', // secondary accent
			),
		),

		'light' => array(
			'label'  => esc_html__( 'Light', 'prequelle' ),
			'colors' => array(
				'#ffffff', // body_bg
				'#ffffff', // page_bg
				'#333333', // submenu_background_color
				'#ffffff', // submenu_font_color
				'#007acc', // accent
				'#444444', // main_text_color
				'#4c4c4c', // secondary_text_color
				'#0d0d0d', // strong_text_color
				'#007acc', // secondary accent
			),
		),
		'dark' => array(
			'label'  => esc_html__( 'Dark', 'prequelle' ),
			'colors' => array(
				'#1B1B1B', // body_bg
				'#1B1B1B', // page_bg
				'#333333', // submenu_background_color
				'#000000', // submenu_font_color
				'#007acc', // accent
				'#ffffff', // main_text_color
				'#ffffff', // secondary_text_color
				'#ffffff', // strong_text_color
				'#007acc', // secondary accent
			),
		),
	) );
}

/**
 * Returns CSS for the color schemes.
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function prequelle_get_color_scheme_css( $colors ) {

	$colors = wp_parse_args( $colors, array(
		'body_background_color' => '',
		'page_background_color' => '',
		'submenu_background_color' => '',
		'submenu_font_color' => '',
		'accent_color' => '',
		'main_text_color' => '',
		'secondary_text_color' => '',
		'strong_text_color' => '',
		'secondary_accent_color' => '',
		'border_color' => '',
	) );

	extract( $colors );

	$output = '';

	$border_color = vsprintf( 'rgba( %s, 0.08)', prequelle_hex_to_rgb( $strong_text_color ) );
	$overlay_panel_bg_color = vsprintf( 'rgba( %s, 0.95)', prequelle_hex_to_rgb( $submenu_background_color ) );

	$link_selector = '.link, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):not(.gallery-quickview)';
	$link_selector_after = '.link:after, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):not(.gallery-quickview):after';

	$output .= "/* Color Scheme */

	/* Body Background Color */
	body,
	.frame-border{
		background-color: $body_background_color;
	}

	/* Page Background Color */
	.site-header,
	.post-header-container,
	.content-inner,
	#logo-bar,
	.nav-bar,
	.loading-overlay,
	.no-hero #hero,
	.wvc-font-default,
	#topbar{
		background-color: $page_background_color;
	}

	.spinner:before,
	.spinner:after{
		background-color: $page_background_color;
	}

	/* Submenu color */
	#site-navigation-primary-desktop .mega-menu-panel,
	#site-navigation-primary-desktop ul.sub-menu,
	#mobile-menu-panel,
	.mobile-menu-toggle .nav-bar,
	.offcanvas-menu-panel,
	.lateral-menu-panel,
	.side-panel{
		background:$submenu_background_color;
	}

	.menu-hover-style-border-top .nav-menu li:hover,
	.menu-hover-style-border-top .nav-menu li.current_page_item,
	.menu-hover-style-border-top .nav-menu li.current-menu-parent,
	.menu-hover-style-border-top .nav-menu li.current-menu-ancestor,
	.menu-hover-style-border-top .nav-menu li.current-menu-item,
	.menu-hover-style-border-top .nav-menu li.menu-link-active{
		box-shadow: inset 0px 5px 0px 0px $submenu_background_color;
	}

	.menu-hover-style-plain .nav-menu li:hover,
	.menu-hover-style-plain .nav-menu li.current_page_item,
	.menu-hover-style-plain .nav-menu li.current-menu-parent,
	.menu-hover-style-plain .nav-menu li.current-menu-ancestor,
	.menu-hover-style-plain .nav-menu li.current-menu-item,
	.menu-hover-style-plain .nav-menu li.menu-link-active{
		background:$submenu_background_color;
	}

	.panel-closer-overlay{
		background:$submenu_background_color;
	}

	.overlay-menu-panel{
		background:$overlay_panel_bg_color;
	}

	/* Sub menu Font Color */
	.nav-menu-desktop li ul li:not(.menu-button-primary):not(.menu-button-secondary) .menu-item-text-container,
	.nav-menu-desktop li ul.sub-menu li:not(.menu-button-primary):not(.menu-button-secondary).menu-item-has-children > a:before,
	.nav-menu-desktop li ul li.not-linked > a:first-child .menu-item-text-container,
	.mobile-menu-toggle .nav-bar .hamburger-icon .line{
		color: $submenu_font_color;
	}

	.nav-menu-vertical li a,
	.nav-menu-mobile li a,
	.nav-menu-vertical li.menu-item-has-children:before,
	.nav-menu-vertical li.page_item_has_children:before,
	.nav-menu-vertical li.active:before,
	.nav-menu-mobile li.menu-item-has-children:before,
	.nav-menu-mobile li.page_item_has_children:before,
	.nav-menu-mobile li.active:before{
		color: $submenu_font_color!important;
	}

	.nav-menu-desktop li ul.sub-menu li.menu-item-has-children > a:before{
		color: $submenu_font_color;
	}

	body.wolf.mobile-menu-toggle .hamburger-icon .line,
	body.wolf.overlay-menu-toggle.menu-style-transparent .hamburger-icon .line,
	body.wolf.overlay-menu-toggle.menu-style-semi-transparent-white .hamburger-icon .line,
	body.wolf.overlay-menu-toggle.menu-style-semi-transparent-black .hamburger-icon .line,
	body.wolf.offcanvas-menu-toggle.menu-style-transparent .hamburger-icon .line,
	body.wolf.offcanvas-menu-toggle.menu-style-semi-transparent-white .hamburger-icon .line,
	body.wolf.offcanvas-menu-toggle.menu-style-semi-transparent-black .hamburger-icon .line,
	body.wolf.side-panel-toggle.menu-style-transparent .hamburger-icon .line,
	body.wolf.side-panel-toggle.menu-style-semi-transparent-white .hamburger-icon .line,
	body.wolf.side-panel-toggle.menu-style-semi-transparent-black .hamburger-icon .line {
		background-color: $submenu_font_color !important;
	}

	.overlay-menu-toggle .nav-bar,
	.overlay-menu-toggle .nav-bar a,
	.overlay-menu-toggle .nav-bar strong {
		color: $submenu_font_color !important;
	}

	.overlay-menu-toggle.menu-style-transparent.hero-font-light a,
	.overlay-menu-toggle.menu-style-semi-transparent-black.hero-font-light a,
	.overlay-menu-toggle.menu-style-semi-transparent-white.hero-font-light a,
	.menu-layout-overlay.desktop .overlay-menu-panel a,
	.menu-layout-lateral.desktop .lateral-menu-panel a,
	.lateral-menu-panel-inner,
	.lateral-menu-panel-inner a{
		color: $submenu_font_color;
	}

	.mobile-menu-toggle.menu-style-transparent.hero-font-light .logo-svg *,
	.overlay-menu-toggle.menu-style-transparent.hero-font-light .logo-svg *,
	.overlay-menu-toggle.menu-style-semi-transparent-black.hero-font-light .logo-svg *,
	.overlay-menu-toggle.menu-style-semi-transparent-white.hero-font-light .logo-svg *,
	.menu-layout-overlay.desktop .overlay-menu-panel .logo-svg *,
	.menu-layout-lateral.desktop .lateral-menu-panel .logo-svg *,
	.lateral-menu-panel-inner .logo-svg *{
		fill:$submenu_font_color!important;
	}

	/* Accent Color */
	.accent{
		color:$accent_color;
	}

	$link_selector:hover{
		color:$accent_color;
		border-color:$accent_color;
	}

	$link_selector_after{
		background-color:$accent_color!important;
	}

	.wolf-bigtweet-content a{
		color:$accent_color!important;
	}

	.nav-menu li.sale .menu-item-text-container:before,
	.nav-menu-mobile li.sale .menu-item-text-container:before{
		background:$accent_color!important;
	}

	.entry-post-grid_classic:hover .entry-title,
	.entry-post-masonry:hover .entry-title,
	.entry-post-list:hover .entry-title,
	.entry-post-masonry_modern.format-standard:hover .entry-title,
	.entry-post-masonry_modern.format-chat:hover .entry-title,
	.wolf-tweet-link:hover{
		color:$accent_color;
	}

	.work-meta-value a:hover,
	.single-post-pagination a:hover,
	.single-post-categories a:hover,
	.single-post-tagcloud.tagcloud a:hover{
		color:$accent_color;
	}

	entry-post-standard .entry-thumbnail,
	.entry-post-standard_modern .entry-thumbnail,
	.proof-photo.selected .proof-photo__bg,
	.widget_price_filter .ui-slider .ui-slider-range,
	mark,
	p.demo_store,
	.woocommerce-store-notice{
		background-color:$accent_color;
	}

	.button-secondary{
		background-color:$accent_color;
		border-color:$accent_color;
	}

	.nav-menu li.menu-button-primary > a:first-child > .menu-item-inner{
		border-color:$accent_color;
		background-color:$accent_color;
	}

	.nav-menu li.menu-button-secondary > a:first-child > .menu-item-inner{
		border-color:$accent_color;
	}

	.nav-menu li.menu-button-secondary > a:first-child > .menu-item-inner:hover{
		background-color:$accent_color;
	}

	.fancybox-thumbs>ul>li:before,
	input[type=text]:focus, input[type=search]:focus, input[type=tel]:focus, input[type=time]:focus, input[type=url]:focus, input[type=week]:focus, input[type=password]:focus, input[type=color]:focus, input[type=date]:focus, input[type=datetime]:focus, input[type=datetime-local]:focus, input[type=email]:focus, input[type=month]:focus, input[type=number]:focus, textarea:focus{
		border-color:$accent_color;
	}

	.button,
	.button-download,
	.added_to_cart,
	input[type='submit'],
	.more-link{
		background-color:$accent_color;
		border-color:$accent_color;
	}

	span.onsale,
	.wvc-background-color-accent,
	.entry-post-grid_classic .category-label:hover,
	.entry-post-grid_modern .category-label:hover,
	.entry-post-masonry .category-label:hover,
	.entry-post-masonry_modern .category-label:hover,
	.entry-post-metro .category-label:hover,
	.entry-post-metro_modern .category-label:hover,
	.entry-post-mosaic .category-label:hover,
	.entry-post-list .category-label:hover,
	.entry-post-lateral .category-label:hover,
	.entry-post-standard .entry-thumbnail{
		background-color:$accent_color;
	}

	.wvc-highlight-accent{
		background-color:$accent_color;
		color:#fff;
	}

	.wvc-icon-background-color-accent{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-icon-background-color-accent .wvc-icon-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	.wvc-button-background-color-accent{
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-button-background-color-accent .wvc-button-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	.wvc-svg-icon-color-accent svg * {
		stroke:$accent_color!important;
	}

	.wvc-one-page-nav-bullet-tip{
		background-color: $accent_color;
	}

	.wvc-one-page-nav-bullet-tip:before{
		border-color: transparent transparent transparent $accent_color;
	}

	.accent,
	.comment-reply-link,
	.bypostauthor .avatar,
	.wolf-bigtweet-content:before{
		color:$accent_color;
	}

	.wvc-button-color-button-accent,
	.more-link,
	.buton-accent{
		background-color: $accent_color;
		border-color: $accent_color;
	}
	
	/* WVC icons */
	.wvc-icon-color-accent{
		color:$accent_color;
	}

	.wvc-icon-background-color-accent{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-icon-background-color-accent .wvc-icon-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	#ajax-progress-bar,
	.side-panel,
	.cart-icon-product-count{
		background:$accent_color;
	}

	.background-accent,
	.mejs-container .mejs-controls .mejs-time-rail .mejs-time-current,
	.mejs-container .mejs-controls .mejs-time-rail .mejs-time-current, .mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current{
		background: $accent_color!important;
	}

	.trigger{
		background-color: $accent_color!important;
		border : solid 1px $accent_color;
	}

	.bypostauthor .avatar {
		border: 3px solid $accent_color;
	}

	::selection {
		background: $accent_color;
	}
	::-moz-selection {
		background: $accent_color;
	}

	.spinner{
		color:$accent_color;
	}

	/*********************
		WVC
	***********************/

	.wvc-icon-box.wvc-icon-type-circle .wvc-icon-no-custom-style.wvc-hover-fill-in:hover, .wvc-icon-box.wvc-icon-type-square .wvc-icon-no-custom-style.wvc-hover-fill-in:hover {
		-webkit-box-shadow: inset 0 0 0 1em $accent_color;
		box-shadow: inset 0 0 0 1em $accent_color;
		border-color: $accent_color;
	}

	.wvc-pricing-table-featured-text,
	.wvc-pricing-table-price-strike:before,
	.wvc-pricing-table-button a{
		background: $accent_color;
	}

	.wvc-pricing-table-price,
	.wvc-pricing-table-currency{
		color: $accent_color;
	}

	.wvc-team-member-social-container a:hover{
		color: $accent_color;
	}

	/* Main Text Color */
	body,
	.nav-label{
		color:$main_text_color;
	}

	.spinner-color, .sk-child:before, .sk-circle:before, .sk-cube:before{
		background-color: $main_text_color!important;
	}

	.ball-pulse > div,
	.ball-grid-pulse > div,

	.ball-clip-rotate-pulse-multiple > div,
	.ball-pulse-rise > div,
	.ball-rotate > div,
	.ball-zig-zag > div,
	.ball-zig-zag-deflect > div,
	.ball-scale > div,
	.line-scale > div,
	.line-scale-party > div,
	.ball-scale-multiple > div,
	.ball-pulse-sync > div,
	.ball-beat > div,
	.ball-spin-fade-loader > div,
	.line-spin-fade-loader > div,
	.pacman > div,
	.ball-grid-beat > div{
		background-color: $main_text_color!important;
	}

	.ball-clip-rotate-pulse > div:first-child{
		background-color: $main_text_color;
	}

	.ball-clip-rotate-pulse > div:last-child {
		border: 2px solid $main_text_color;
		border-color: $main_text_color transparent $main_text_color transparent;
	}

	.ball-scale-ripple-multiple > div,
	.ball-triangle-path > div{
		border-color: $main_text_color;
	}

	.pacman > div:first-of-type,
	.pacman > div:nth-child(2){
		background: none!important;
		border-right-color: transparent;
		border-top-color: $main_text_color;
		border-left-color: $main_text_color;
		border-bottom-color: $main_text_color;
	}

	/* Secondary Text Color */
	/*.categories-links a,
	.comment-meta,
	.comment-meta a,
	.comment-awaiting-moderation,
	.ping-meta,
	.entry-meta,
	.entry-meta a,
	.edit-link{
		color: $secondary_text_color!important;
	}*/

	/* Strong Text Color */
	a,strong,
	.products li .price,
	.products li .star-rating,
	.wr-print-button,
	table.cart thead, #content table.cart thead{
		color: $strong_text_color;
	}

	.menu-hover-style-underline .nav-menu-desktop li a span.menu-item-text-container:after,
	.menu-hover-style-underline-centered .nav-menu-desktop li a span.menu-item-text-container:after{
		background: $strong_text_color;
	}

	.menu-hover-style-line .nav-menu li a span.menu-item-text-container:after{
		background-color: $strong_text_color;
	}

	.bit-widget-container,
	.entry-link{
		color: $strong_text_color;
	}

	/*.widget:not(.wpm_playlist_widget):not(.widget_tag_cloud):not(.widget_product_tag_cloud) a,
	.woocommerce-tabs ul.tabs li:not(.active) a:hover{
		color: $strong_text_color!important;
	}*/

	.wr-stars>span.wr-star-voted:before, .wr-stars>span.wr-star-voted~span:before{
		color: $strong_text_color!important;
	}

	/* Border Color */
	.author-box,
	input[type=text],
	input[type=search],
	input[type=tel],
	input[type=time],
	input[type=url],
	input[type=week],
	input[type=password],
	input[type=checkbox],
	input[type=color],
	input[type=date],
	input[type=datetime],
	input[type=datetime-local],
	input[type=email],
	input[type=month],
	input[type=number],
	select,
	textarea{
		border-color:$border_color;
	}

	.widget-title,
	.woocommerce-tabs ul.tabs{
		border-bottom-color:$border_color;
	}

	.widget_layered_nav_filters ul li a{
		border-color:$border_color;
	}

	hr{
		background:$border_color;
	}
	";
	if ( preg_match( '/dark/', prequelle_get_theme_mod( 'color_scheme' ) ) ) {
		$output .= ".wvc-background-color-default.wvc-font-light{
			background-color:$page_background_color;
		}";
	}
	if ( preg_match( '/light/', prequelle_get_theme_mod( 'color_scheme' ) ) ) {
		$output .= ".wvc-background-color-default.wvc-font-dark{
			background-color:$page_background_color;
		}";
	}

	return apply_filters( 'prequelle_color_scheme_output', $output, $colors );
}

/**
 * Get array of colors of the Underscore template
 *
 * @return array $colors
 */
function prequelle_get_template_colors() {

	$colors = array(
		'body_background_color',
		'page_background_color',
		'submenu_background_color',
		'submenu_font_color',
		'accent_color',
		'main_text_color',
		'secondary_text_color',
		'strong_text_color',
		'secondary_accent_color'
	);

	foreach ( $colors as $id ) {
		$colors[ $id ] =  '{{ data.' . $id . ' }}';
	}

	return $colors;
}

/**
 * Outputs an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 */
function prequelle_color_scheme_css_template() {

	$colors = prequelle_get_template_colors();
	?>
	<script type="text/html" id="tmpl-prequelle-color-scheme">
		<?php echo prequelle_get_color_scheme_css( $colors ); ?>
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'prequelle_color_scheme_css_template' );