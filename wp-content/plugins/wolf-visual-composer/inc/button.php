<?php
/**
 * Wolf WPBakery Page Builder Extension button function
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns a button
 *
 * @param array $atts
 */
function wvc_generate_button( $atts ) {

	$atts = wp_parse_args( $atts, array(
		'title' => esc_html__( 'My Button', 'wolf-visual-composer' ),
		'link' => '',
		'href' => '#',
		'color' => '',
		'custom_color' => '',
		'shape' => '',
		'style' => '',
		'size' => 'md',
		'align' => '',
		'button_block' => '',
		'hover_effect' => 'opacity',
		'font_weight' => '',
		'scroll_to_anchor' => '',
		'add_icon' => '',
		'i_align' => '',
		'i_hover' => '',
		'icon' => '',
		'css_animation' => '',
		'css_animation_delay' => '',
		'css' => '',
		'el_class' => '',
		'inline_style' => '',
	) );

	$atts = apply_filters( 'wvc_button_atts', $atts );

	extract( $atts );

	$output = $container_class = $button_filler_style = $before_text = $after_text = '';

	$class = $el_class;
	$inline_style = wvc_sanitize_css_field( $inline_style );
	$inline_style .= wvc_shortcode_custom_style( $css );

	/*Animate */
	if ( ! wvc_is_new_animation( $css_animation ) ) {
		$class .= wvc_get_css_animation( $css_animation );
		$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
	}
	$link = vc_build_link( $link );
	$link_url = ( isset( $link['url'] ) && $link['url'] ) ? esc_url( $link['url'] ) : $href;
	$link_target = esc_attr( $link['target'] );
	if ( $button_block && 'inline' !== $align ) {
		$class .= ' wvc-button-fullwidth';
	}

	$class .= " wvc-button";

	if ( $color ) {
		$class .= " wvc-button-background-color-$color";
	}

	if ( $shape ) {
		$class .= " wvc-button-shape-$shape";
	}

	if ( $style ) {
		$class .= " wvc-button-style-$style";
	}

	if ( $size ) {
		$class .= " wvc-button-size-$size";
	}

	if ( $style ) {
		$class .= " wvc-button-style-$style";
	}

	if ( $hover_effect ) {
		$class .= " wvc-button-hover-$hover_effect";
	}

	if ( $scroll_to_anchor ) {
		$class .= ' wvc-scroll';
	}

	if ( $i_hover ) {
		$class .= ' wvc-button-icon-reveal';
	}

	$container_class .= "wvc-button-container wvc-button-container-align-$align";

	if ( 'inline' !== $align ) {
		$container_class .= ' wvc-element';
	}
	if ( $add_icon ) {
		$class .= " wvc-button-icon-$i_align";

		if ( 'left' === $i_align ) {

			$before_text = "<i class='wvc-button-icon fa $icon'></i>";

		} elseif ( 'right' === $i_align ) {

			$after_text = "<i class='fa $icon'></i>";
		}

	}

	/* Background color */
	if ( 'custom' === $color ) {
		$color = $custom_color;
		$bg_color = wvc_sanitize_color( $color );
		$inline_style .="background-color:$bg_color;border-color:$bg_color;box-shadow-color:$bg_color;";
		$icon_filler_style .= "background-color:$bg_color;box-shadow-color:$bg_color;";
	}

	if ( $font_weight ) {
		$font_weight = absint( $font_weight );
		$inline_style .="font-weight:$font_weight;";
	}

	$output .= '<div class="' . wvc_sanitize_html_classes( $container_class ) . '"';

	$output .= wvc_element_aos_animation_data_attr( $atts );
	
	$output .= '>';

			$output .= '<a href="' . esc_url( $link_url ) . '" data-text="' . esc_attr( $title ) . '"';

			if ( $link_target ) {
				$output .= ' target="' . esc_attr( $link_target ) . '"';
			}

			$output .= ' class="' . wvc_sanitize_html_classes( $class ) . '"  style="' . wvc_esc_style_attr( $inline_style ) . '">';

			$output .= '<small data-text="' . esc_attr( $title ) . '" class="wvc-button-background-fill" style="' . wvc_esc_style_attr( $button_filler_style ) . '"></small>';

				$output .= $before_text;

				$output .= '<span>';
				$output .= esc_attr( $title );
				$output .= '</span>';

				$output .= $after_text;

			$output .= '</a>';
	$output .= '</div>';

	return $output;
}