<?php
/**
 * Wolf WPBakery Page Builder Extension heading
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns a heading
 *
 * @param array $atts
 */
function wvc_heading( $atts ) {
	
	$atts = wp_parse_args( $atts, array(
		'font_size' => '',
		'min_font_size' => '',
		'responsive' => 'yes',
		'font_family' => '',
		'letter_spacing' => 0,
		'font_weight' => '',
		'line_height' => '',
		'text_transform' => '',
		'font_style' => '',
		'text_align' => '',
		'color' => '',
		'custom_color' => '',
		'text' => '',
		'tag' => 'h2',
		'link' => '',
		'background_img' => '',
		'background_position' => 'center center',
		'background_repeat' => 'no-repeat',
		'background_size' => 'cover',
		'css_animation' => '',
		'css_animation_delay' => '',
		'el_class' => '',
		'el_id' => '',
		'css' => '',
		'inline_style' => '',
		'hide_class' => '',
		'container' => true,
	) );

	$atts = apply_filters( 'wvc_heading_atts', $atts );

	extract( $atts );

	wp_enqueue_script( 'fittext' );
	wp_enqueue_script( 'wvc-fittext' );

	$output = $text_container_class = $text_style = '';

	$class = $el_class;
	$inline_style = wvc_sanitize_css_field( $inline_style );
	$inline_style .= wvc_shortcode_custom_style( $css );

	$has_line_break = ( preg_match( '/(<br>|<br\/>|<br \/>)/', $text ) );

	/*Animate */
	if ( ! wvc_is_new_animation( $css_animation ) && ! $has_line_break ) {
		$class .= wvc_get_css_animation( $css_animation );
		$text_style .= wvc_get_css_animation_delay( $css_animation_delay );
	}

	$link = vc_build_link( $link );
	$link_url = esc_url( $link['url'] );
	$link_target = esc_attr( $link['target'] );
	$link_title = esc_attr( $link['title'] );

	$text_transform = esc_attr( $text_transform );
	$font_weight = ( $font_weight ) ? absint( $font_weight ) : '';

	$url = esc_attr( $link_url );
	$do_link = ( 'http://' != $url && $url );

	if ( $font_size && 'yes' === $responsive ) {
		
		$class .= ' wvc-fittext';

	} elseif ( $font_size && 'yes' !== $responsive ) {
		
		$text_style .= 'font-size:' . absint( $font_size ) . 'px;';
	}

	if ( $font_weight ) {
		$text_style .= 'font-weight:' . absint( $font_weight ) . ';';
	}

	if ( '' !== $letter_spacing ) {
		$text_style .= 'letter-spacing:' . esc_attr( $letter_spacing ) . ';';
	}

	if ( $text_align ) {
		$text_style .= 'text-align:' . esc_attr( $text_align ) . ';';
	}

	if ( $line_height ) {
		$line_height = esc_attr( $line_height );
		$text_style .= "line-height:$line_height;";
	} else {
		$text_style .= 'line-height:1.5;';
	}

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

	if ( 'fadeInUp' === $css_animation || 'fadeInDown' === $css_animation ) {
		$text_container_class .= ' wvc-overflow-hidden';
	}

	$text_container_class .= ' wvc-custom-heading wvc-element wvc-text-align-' . $text_align;
	$text_container_class .= ' ' . $hide_class; // device visibility class

	if ( $background_img ) {
		$bg_img_url = wvc_get_url_from_attachment_id( $background_img, 'large' );
		$inline_style .= "background-image:url($bg_img_url);";
		$inline_style .= "background-repeat:$background_repeat;";
		$inline_style .= "background-position:$background_position;";
		$inline_style .= "background-size:$background_size;";
	}

	if ( $container ) {
		$output .= '<div class="' . wvc_sanitize_html_classes( $text_container_class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

			if ( ! $has_line_break ) {
				$output .= wvc_element_aos_animation_data_attr( $atts );
			}
		
		$output .= '>';
	}

	$output .= '<' . esc_attr( $tag ) .'';

	if ( ! $container && ! $has_line_break ) {
		$output .= wvc_element_aos_animation_data_attr( $atts );
	}

	if ( '' !== $el_id ) {
		$output .= ' id="' . sanitize_title( $el_id ) . '"';
	}

	$output .= ' style="' . wvc_esc_style_attr( $text_style ) . '" class="' . wvc_sanitize_html_classes( $class ) . '" data-heading-text="' . esc_attr( sanitize_title( $text ) ) . '"
		data-max-font-size="' . absint( $font_size ) . '"
		data-min-font-size="' . absint( $min_font_size ) . '">';

	if ( $do_link ) {
		$link_target = ( $link_target ) ? '_blank' : '_parent';
		$output .= '<a style="' . wvc_esc_style_attr( $inline_style ) . '" class="wvc-fittext-link" href="' . esc_url( $url ) . '" target="' . esc_attr( $link_target ) . '">';
	}


	if ( $has_line_break ) {

		$lines = wvc_texarea_lines_to_array( $text );

		$text = '';
	
		foreach( $lines as $line ) {

			$line_container_style = '';
			$line_container_class = 'wvc-custom-heading-line';

			if ( 'fadeInUp' === $css_animation || 'fadeInDown' === $css_animation ) {
				$line_container_class .= ' wvc-overflow-hidden';
			}

			if ( ! wvc_is_new_animation( $css_animation ) ) {
				$line_container_class .= ' ' . wvc_get_css_animation( $css_animation );
				$line_container_style = wvc_get_css_animation_delay( $css_animation_delay );
			}

			$text .= '<span class="' . esc_attr( $line_container_class ) . '" style="' . esc_attr( $line_container_style ) . '"';

			$text .= wvc_element_aos_animation_data_attr( array(
				'css_animation' => $css_animation,
				'css_animation_delay' => $css_animation_delay,

			) );

			$text .= '>';

			$text .= $line;

			$text .= '</span>';

			$css_animation_delay = $css_animation_delay + 100;
		}
	}

	$output .=  do_shortcode( wvc_sanitize_heading( $text ) );

	if ( $do_link ) {
		$output .= '</a>';
	}

	$output .= '</' . esc_attr( $tag ) .'>';

	if ( $container ) {
		$output .= '</div>';
	}

	return $output;
}