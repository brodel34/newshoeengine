<?php
/**
 * Wolf WPBakery Page Builder Extension bigtext function
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns a bigtext
 *
 * @param array $atts
 */
function wvc_generate_bigtext( $atts ) {
	$atts = wp_parse_args( $atts, array(
		'font_family' => '',
		'letter_spacing' => 0,
		'font_weight' => 700,
		'text_transform' => 'none',
		'font_style' => '',
		'color' => '',
		'custom_color' => '',
		'css_animation' => '',
		'css_animation_delay' => '',
		'text' => '',
		'link' => '',
		'title_tag' => 'h4',
		'el_class' => '',
		'css' => '',
		'inline_style' => '',
	) );

	extract( $atts );

	wp_enqueue_script( 'bigtext' );
	wp_enqueue_script( 'wvc-bigtext' );

	$output = $text_container_class = $text_style = '';

	$class = $el_class;
	$inline_style = wvc_sanitize_css_field( $inline_style );
	$inline_style .= wvc_shortcode_custom_style( $css );

	/*Animate */
	if ( ! wvc_is_new_animation( $css_animation ) ) {
		$class .= wvc_get_css_animation( $css_animation );
		$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
	}

	$link = vc_build_link( $link );
	$link_url = esc_url( $link['url'] );
	$link_target = esc_attr( $link['target'] );
	$link_title = esc_attr( $link['title'] );
	$text_transform = esc_attr( $text_transform );
	$font_weight = absint( $font_weight );
	$letter_spacing = preg_replace( "/[^0-9-]/", '', $letter_spacing );

	$url = esc_attr( $link_url );
	$do_link = ( 'http://' != $url && $url );

	$class .= ' wvc-bigtext';

	$text_container_class .= ' wvc-element';

	$text_style .= 'font-weight:' . absint( $font_weight ) . ';';
	$text_style .= 'letter-spacing:' . absint( $letter_spacing ) . 'px;';

	if ( $font_family && 'default' !== $font_family ) {
		$text_style .= 'font-family:' . esc_attr( $font_family ) . ';';
	}

	if ( $text_transform ) {
		$text_style .= 'text-transform:' . esc_attr( $text_transform ) . ';';
	}

	if ( $font_style ) {
		$text_style .= 'font-style:' . esc_attr( $font_style ) . ';';
	}

	if ( 'custom' === $color && $custom_color ) {
		$text_style .= 'color:' . wvc_sanitize_color( $custom_color ) . ';';
	} else {
		$class .= " wvc-text-color-$color"; // color class
	}

	$lines = wvc_texarea_lines_to_array( $text );

	if ( 'fadeInUp' === $css_animation || 'fadeInDown' === $css_animation ) {
		$text_container_class .= ' wvc-overflow-hidden';
	}

	if ( array() !== $lines ) {

		$output .= '<div class="' . wvc_sanitize_html_classes( $text_container_class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

		$output .= wvc_element_aos_animation_data_attr( $atts );

		$output .= '>';

		$output .= '<' . esc_attr( $title_tag ) .'';
		$output .= ' style="' . wvc_esc_style_attr( $text_style ) . '" class="' . wvc_sanitize_html_classes( $class ) . '">';

		if ( $do_link ) {
			$target = ( $link_target ) ? '_blank' : '_parent';
		}

		foreach( $lines as $line ) {
			if ( $do_link ) {
				$output .= '<a class="wvc-bigtext-link" href="' . esc_attr( $url ) . '" target="' . esc_attr( $target ) . '">';

			} else {
				$output .= '<span>';
			}

			$output .= wvc_sanitize_heading( $line );

			if ( $do_link ) {
				$output .= '</a>';
			} else {
				$output .= '</span>';
			}
		}

		$output .= '</' . esc_attr( $title_tag ) .'>';

		$output .= '</div>';

		return $output;
	}

} // end function