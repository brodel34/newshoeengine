<?php
/**
 * Prequelle customizer fonts preview functions
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Returns CSS for the fonts.
 *
 * @param array $fonts Fonts family.
 * @return string Fonts CSS.
 */
function prequelle_get_fonts_css( $fonts_args ) {

	$fonts_args = wp_parse_args( $fonts_args, array(
		'body_font_name',
		'body_font_size',
		'menu_font_name',
		'menu_font_weight',
		'menu_font_transform',
		'menu_font_letter_spacing',
		'menu_font_size',
		'submenu_font_transform',
		'submenu_font_weight',
		'submenu_font_letter_spacing',
		'heading_font_name',
		'heading_font_weight',
		'heading_font_transform',
		'heading_font_letter_spacing',
	) );

	extract( $fonts_args );

	$font_css = '';

	/* Body */
	$body_selectors = 'body, blockquote.wvc-testimonial-content, .tp-caption';

	if ( $body_font_name ) {
		$font_css .= "$body_selectors{font-family: $body_font_name }";
		$font_css .= ".wvc-countdown-container .countdown-period, .bit-widget{font-family: $body_font_name!important }";
	}

	if ( $body_font_size ) {
		$font_css .= "body{font-size: $body_font_size }";
	}

	/* Menu */
	$menu_selectors = '.nav-menu li, .cta-container';

	if ( $menu_font_name && 'default' != $menu_font_name ) {
		$font_css .= "$menu_selectors{font-family:'$menu_font_name'}";
	}

	if ( $menu_font_weight ) {
		$font_css .= "$menu_selectors{font-weight: $menu_font_weight }";
	}

	if ( $menu_font_transform ) {
		$font_css .= "$menu_selectors{text-transform: $menu_font_transform }";
	}

	if ( $menu_font_letter_spacing ) {
		$font_css .= "$menu_selectors{letter-spacing: " . $menu_font_letter_spacing . "px }";
	}

	$submenu_selector = '.nav-menu ul ul li';

	if ( $submenu_font_transform ) {
		$font_css .= "$submenu_selector{text-transform: $submenu_font_transform }";
	}

	if ( $submenu_font_weight ) {
		$font_css .= "$submenu_selector{font-weight: $submenu_font_weight }";
	}

	if ( '' !== $submenu_font_letter_spacing ) {
		$font_css .= "$submenu_selector{letter-spacing: " . $submenu_font_letter_spacing . "px!important; }";
	}

	if ( $menu_font_size ) {
		$font_css .= ".nav-menu-desktop li{font-size:'$menu_font_size'}";
	}

	/* Heading */
	$heading_family_selectors = apply_filters( 'prequelle_heading_family_selectors', prequelle_list_to_array( 'h1, h2, h3, h4, h5, h6, .post-title, .entry-title, h2.entry-title > .entry-link, h2.entry-title, .widget-title, .wvc-counter-text, .wvc-countdown-period, .event-date, .logo-text, .wvc-interactive-links, .wvc-interactive-overlays, .heading-font' ) );
	
	$heading_selectors = apply_filters( 'prequelle_heading_selectors', prequelle_list_to_array( 'h1:not(.wvc-bigtext), h2:not(.wvc-bigtext), h3:not(.wvc-bigtext), h4:not(.wvc-bigtext), h5:not(.wvc-bigtext), .post-title, .entry-title, h2.entry-title > .entry-link, h2.entry-title, .widget-title, .wvc-counter-text, .wvc-countdown-period, .location-title, .logo-text, .wvc-interactive-links, .wvc-interactive-overlays, .heading-font' ) );

	$heading_family_selectors = prequelle_array_to_list( $heading_family_selectors );
	$heading_selectors = prequelle_array_to_list( $heading_selectors );

	if ( $heading_font_name && 'default' != $heading_font_name ) {
		$font_css .= "$heading_family_selectors{font-family:'$heading_font_name'}";
	}

	if ( $heading_font_weight ) {
		$font_css .= "$heading_selectors{font-weight: $heading_font_weight }";
	}

	if ( $heading_font_transform ) {
		$font_css .= "$heading_selectors{text-transform: $heading_font_transform }";
	}

	if ( $heading_font_letter_spacing ) {
		$font_css .= "$heading_selectors{letter-spacing: " . $heading_font_letter_spacing . "px }";
	}

	return apply_filters( 'prequelle_fonts_css_output', $font_css, $fonts_args );
}

/**
 * Get array of fonts of the Underscore template
 *
 * @return array $fonts
 */
function prequelle_get_template_fonts() {

	$fonts = array(
		'body_font_name',
		'menu_font_name',
		'menu_font_weight',
		'menu_font_transform',
		'submenu_font_transform',
		'submenu_font_weight',
		'submenu_font_letter_spacing',
		'menu_font_style',
		'menu_font_letter_spacing',
		'heading_font_name',
		'heading_font_weight',
		'heading_font_transform',
		'heading_font_style',
		'heading_font_letter_spacing',
	);

	foreach ( $fonts as $id ) {
		$fonts[ $id ] =  '{{ data.' . $id . ' }}';
	}

	return $fonts;
}

/**
 * Outputs an Underscore template for generating CSS for the fonts.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 */
function prequelle_fonts_css_template() {

	$fonts = prequelle_get_template_fonts();
	?>
	<script type="text/html" id="tmpl-prequelle-fonts">
		<?php echo prequelle_get_fonts_css( $fonts ); ?>
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'prequelle_fonts_css_template' );