
<?php
/**
 * Pricing table shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'title' => '',
	'title_tag' => 'h3',
	'tagline' => '',
	'price' => '',
	'currency' => '',
	'display_currency' => 'before',
	'offer' => '',
	'offer_price' => '',
	'price_period' => '',
	'show_button' => '',
	'button_text' => esc_html__( 'Buy Now', 'wolf-visual-composer' ),
	'link' => '',
	'target' => '',
	'featured' => '',
	'featured_text' => esc_html__( 'Best Choice', 'wolf-visual-composer' ),
	'services' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

// link
$link = vc_build_link( $link );
$link_url = ( isset( $link['url'] ) ) ? esc_url( $link['url'] ) : '#';
$link_target = ( isset( $link['target'] ) ) ? esc_attr( trim( $link['target'] ) ) : '_self';
$link_title = ( isset( $link['title'] ) ) ? esc_attr( $link['title'] ) : '';
$nofollow = ( isset( $link['rel'] ) && 'nofollow' === $link['rel'] ) ? 'rel="nofollow"' : '';

$class .= ' wvc-pricing-table-inner wvc-element';

$headings_array = array( 'h2', 'h3', 'h4', 'h5', 'h6' );
$title_tag = ( in_array( $title_tag, $headings_array ) ) ? esc_attr( $title_tag ) : 'h3';

if ( 'yes' === $featured ) {
	$class .= ' wvc-pricing-table-featured';
}

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= '<ul>';

if ( $title ) {

	$output .= '<li class="wvc-pricing-table-title-cell">';

	if ( 'yes' == $featured ) {
		$output .= '<span class="wvc-pricing-table-featured-text"><span>' . sanitize_text_field( $featured_text ) . '</span></span>';
	}

	$output .= '<' . esc_attr( $title_tag ) . ' class="wvc-pricing-table-title">' . sanitize_text_field( $title ) . '</' . esc_attr( $title_tag ) . '>';

	if ( $tagline ) {
		$output .= '<span class="wvc-pricing-table-tagline">' . sanitize_text_field( $tagline ) . '</span>';
	}

	$output .= '</li>';
}

if ( $price ) {

	$output .= '<li class="wvc-pricing-table-main-content">';

	// Offer
	if ( 'yes' === $offer && $offer_price ) {

		$output .= '<span class="wvc-pricing-table-price-strike">';

		if ( $currency && 'before' == $display_currency ) {
			$output .= '<span class="wvc-pricing-table-currency-strike">' . sanitize_text_field( $currency ) . '</span>';
		}

		$output .= absint( $price );

		if ( $currency && 'after' == $display_currency ) {
			$output .= '<span class="wvc-pricing-table-currency-strike">' . sanitize_text_field( $currency ) . '</span>';
		}

		$output .= '</span>';

		if ( $currency && 'before' == $display_currency ) {
			$output .= '<span class="wvc-pricing-table-currency">' . sanitize_text_field( $currency ) . '</span>';
		}

		$output .= '<span class="wvc-pricing-table-price">' . sanitize_text_field( $offer_price ) . '</span>';

		if ( $currency && 'after' == $display_currency ) {
			$output .= '<span class="wvc-pricing-table-currency">' . sanitize_text_field( $currency ) . '</span>';
		}
	} else {

		if ( $currency && 'before' == $display_currency ) {
			$output .= '<span class="wvc-pricing-table-currency">' . sanitize_text_field( $currency ) . '</span>';
		}

		$output .= '<span class="wvc-pricing-table-price">' . sanitize_text_field( $price ) . '</span>';

		if ( $currency && 'after' == $display_currency ) {
			$output .= '<span class="wvc-pricing-table-currency">' . sanitize_text_field( $currency ) . '</span>';
		}
	}

	if ( $price_period ) {
		$output .= '<span class="wvc-pricing-table-price-period">' . sanitize_text_field( $price_period ) . '</span>';
	}

	$output .= '</li>';
}

if ( $services ) {
	$services = wvc_texarea_lines_to_array( $services );
	foreach ( $services as $service ) {
		$output .= '<li class="wvc-pt-cell"><span class="wvc-pt-cell-text">';
		$output .= ( $service ) ? $service : '-';
		$output .= '</span></li>';
	}
}

if ( $show_button && 'no' !== $show_button ) {
	$output .= '<li class="wvc-pricing-table-button">';
	$output .= '<a ' . $nofollow . ' href="' . esc_url( $link_url ) . '"';
	$output .= 'target="' . esc_attr( $link_target ) . '"';
	$output .= '>' . esc_attr( $button_text ) . '</a>';
	$output .= '</li>';
}

$output .= '</ul>';

$output .= '</div><!--.wvc-pricing-table-inner-->';

echo $output;