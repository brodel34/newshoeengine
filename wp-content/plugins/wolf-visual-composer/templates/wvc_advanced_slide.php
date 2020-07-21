<?php
/**
 * Advanced slide shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'font_color' => 'light',
	'background_color' => '',
	'background_type' => 'image',
	'background_color' => 'default',
	'background_custom_color' => '',
	'background_img' => '',
	'background_position' => 'center center',
	'background_repeat' => 'no-repeat',
	'background_size' => 'cover',
	'background_effect' => '',
	'video_bg_url' => '',
	'video_bg_img' => '',
	'video_bg_controls' => '',
	'video_bg_mute_button' => '',
	'video_bg_unmute' => '',
	'add_effect' => '', // custom theme effect
	'add_overlay' => '',
	'overlay_color' => 'black',
	'overlay_custom_color' => '#000000',
	'overlay_opacity' => '',
	'title_type' => 'text',
	'title_font_family' => '',
	'title_font_weight' => '',
	'title_font_size' => 60,
	'title_text_transform' => '',
	'title_letter_spacing' => '',
	'title' => '',
	'image' => '',
	'image_size' => 'large',
	'caption_type' => 'text',
	'caption_width' => 'large',
	'caption_position' => 'large',
	'caption_v_align' => 'middle',
	'caption' => '',
	'caption_order' => 'after_title',
	'caption_alignment' => 'center',
	'add_button_1' => '',
	'b1_title' => esc_html__( 'My Button', 'wolf-visual-composer' ),
	'b1_link' => '',
	'b1_color' => '',
	'b1_custom_color' => '',
	'b1_shape' => '',
	'b1_style' => '',
	'b1_size' => '',
	//'b1_align' => '',
	'b1_button_block' => '',
	'b1_hover_effect' => '',
	'b1_add_icon' => '',
	'b1_i_align' => '',
	'b1_i_type' => '',
	'b1_i_hover' => '',
	'b1_font_weight' => '',
	'b1_scroll_to_anchor' => '',
	'add_button_2' => '',
	'b2_title' => esc_html__( 'My Button', 'wolf-visual-composer' ),
	'b2_link' => '',
	'b2_color' => '',
	'b2_custom_color' => '',
	'b2_shape' => '',
	'b2_style' => '',
	'b2_size' => '',
	//'b2_align' => '',
	'b2_button_block' => '',
	'b2_hover_effect' => '',
	'b2_add_icon' => '',
	'b2_i_align' => '',
	'b2_i_type' => '',
	'b2_i_hover' => '',
	'b2_font_weight' => '',
	'b2_scroll_to_anchor' => '',
	'el_class' => '',
	'inline_style' => '',
), apply_filters( 'wvc_advanced_slide_atts', $atts ) ) );

$output = '';

$output = $image_url = $overlay_style = '';
$rand = rand( 0, 9999 );

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );

$class .= " slide wvc-advanced-slide wvc-slide-caption-width-$caption_width wvc-slide-caption-position-$caption_position wvc-slide-caption-text-align-$caption_alignment wvc-slide-caption-valign-$caption_v_align wvc-font-$font_color wvc-$background_type-slide wvc-slide-caption-order-$caption_order";

if ( 'custom' !== $background_color ) {
	$class .= " wvc-background-color-$background_color";
}

//$class .= ( $video_bg_unmute ) ? ' wvc-video-bg-is-unmute' : 'wvc-video-bg-is-mute';

$output .= '<li id="wvc-advanced-slide-' . absint( $rand ) . '" class="' . wvc_sanitize_html_classes( $class ) . '">';

	if ( 'image' === $background_type ) {

		$img_bg_args = array(
			'background_img' => $background_img,
			'background_color' => ( 'custom' === $background_color ) ? $background_custom_color : '',
			'background_position' => $background_position,
			'background_repeat' => $background_repeat,
			'background_size' => $background_size,
			'background_effect' => $background_effect,
		);

		$output .= wvc_background_img( $img_bg_args );

	// video background
	} elseif ( 'video' === $background_type ) {

		$video_bg_args = array(
			'video_bg_url' => $video_bg_url,
			'video_bg_img' => $video_bg_img,
			'video_bg_mute_button' => $video_bg_mute_button,
			'video_bg_unmute' => $video_bg_unmute,
			//'video_bg_pause_on_start' => true,
			//'video_bg_controls' => $video_bg_controls,
		);

		$output .= wvc_background_video( $video_bg_args );
	}

	if ( 'yes' === $add_overlay ) {

		$main_image = ( 'video' === $background_type ) ? $video_bg_img : $background_img;
		$dominant_color = wvc_get_image_dominant_color( $main_image );

		if ('auto' === $overlay_color ) {
			$overlay_custom_color = ( $dominant_color ) ? $dominant_color : '#000000';
		}

		$output .= wvc_background_overlay( array( 'overlay_color' => $overlay_color, 'overlay_custom_color' => $overlay_custom_color, 'overlay_opacity' => $overlay_opacity, ) );
	}

	if ( $add_effect ) {
		$output .= apply_filters( 'wvc_background_effect', '', $atts );
	}

	$output .= '<div class="wvc-slide-caption-container">';

		$output .= '<div class="wvc-slide-caption">';

			$output .= '<div class="wvc-slide-caption-inner">';

			$output .= '<div class="wvc-slide-caption-wrapper">';

	if ( $caption && 'before_title' === $caption_order ) {
		$output .= '<div class="wvc-slide-caption-text wvc-slide-caption-text-type-' . esc_attr( $caption_type ) . '">' . $caption . '</div>';
	}

	if ( 'textfield' === $title_type ) {

		$title_inline_style = '';

		if ( $title_font_family ) {
			$title_inline_style .= 'font-family:' . $title_font_family . ';';
		}

		if ( $title_font_weight ) {
			$title_font_weight = absint( $title_font_weight );
			$title_inline_style .= 'font-weight:' . $title_font_weight . ';';
		}

		if ( '' !== $title_letter_spacing ) {
			$title_inline_style .= 'letter-spacing:' . esc_attr( $title_letter_spacing ) . ';';
		}

		if ( $title_text_transform ) {
			$title_inline_style .= 'text-transform:' . esc_attr( $title_text_transform ) . ';';
		}

		$title_inline_style .= 'font-size:' . $title_font_size . 'px;';

		if ( $title ) {
			$output .= '<h2 style="' . esc_attr( $title_inline_style ) . '" data-max-font-size="' . absint( $title_font_size ) . '" class="wvc-slide-title wvc-fittext">' . sanitize_text_field( $title ) . '</h2>';
		}

	} elseif ( 'image' === $title_type && $image ) {

		if ( $image ) {

			$image_url = esc_url( wvc_get_url_from_attachment_id( absint( $image ), esc_attr( $image_size ) ) );

			$output .= '<div class="wvc-slide-image"><img src="' . $image_url . '" alt="' . esc_attr( strip_tags( $caption ) ) . '"></div><div class="wvc-clear"></div>';
		}
	}

	if ( $caption && 'after_title' === $caption_order ) {
		$output .= '<div class="wvc-slide-caption-text wvc-slide-caption-text-type-' . esc_attr( $caption_type ) . '">' . $caption . '</div>';
	}

	if ( $add_button_1 || $add_button_2 ) {
		$output .= '<div class="wvc-slide-button-container">';
	}

	if ( $add_button_1 ) {

		$button_1_atts = array(
			'title' => $b1_title,
			'link' => $b1_link,
			'color' => $b1_color,
			'custom_color' => $b1_custom_color,
			'shape' => $b1_shape,
			'style' => $b1_style,
			'size' => $b1_size,
			'align' => 'inline',
			'button_block' => $b1_button_block,
			'hover_effect' => $b1_hover_effect,
			'add_icon' => $b1_add_icon,
			'i_align' => $b1_i_align,
			'i_type' => $b1_i_type,
			'i_hover' => $b1_i_hover,
			'font_weight' => $b1_font_weight,
			'scroll_to_anchor' => $b1_scroll_to_anchor,
			'el_class' => '',
		);

		$button_1_icon = ( isset( $atts["b1_i_icon_$b1_i_type"] ) ) ? $atts["b1_i_icon_$b1_i_type"] : '';

		$button_1_atts = apply_filters( 'wvc_advanced_slider_b1_button_atts', $button_1_atts, $atts );

		$output .= wvc_generate_button( array_merge( array( 'icon' => $button_1_icon ), $button_1_atts ) );
	}

	if ( $add_button_2 ) {

		$button_2_atts = array(
			'title' => $b2_title,
			'link' => $b2_link,
			'color' => $b2_color,
			'custom_color' => $b2_custom_color,
			'shape' => $b2_shape,
			'style' => $b2_style,
			'size' => $b2_size,
			'align' => 'inline',
			'button_block' => $b2_button_block,
			'hover_effect' => $b2_hover_effect,
			'add_icon' => $b2_add_icon,
			'i_align' => $b2_i_align,
			'i_type' => $b2_i_type,
			'i_hover' => $b2_i_hover,
			'font_weight' => $b2_font_weight,
			'scroll_to_anchor' => $b2_scroll_to_anchor,
			'el_class' => '',
		);

		$button_2_icon = ( isset( $atts["b2_i_icon_$b2_i_type"] ) ) ? $atts["b2_i_icon_$b2_i_type"] : '';

		$button_2_atts = apply_filters( 'wvc_advanced_slider_b2_button_atts', $button_2_atts, $atts );

		$output .= wvc_generate_button( array_merge( array( 'icon' => $button_2_icon ), $button_2_atts ) );
	}

	if ( $add_button_1 || $add_button_2 ) {
		$output .= '</div><!--.wvc-slide-button-container-->';
	}

$output .= '</div><!-- .wvc-slide-caption-wrapper --></div><!-- .wvc-slide-inner --></div><!-- .wvc-slide-caption --></div><!-- .wvc-slide-caption-container -->';

/**
 * Video mute control
 */
if ( $video_bg_mute_button && $video_bg_url && ! wp_is_mobile() ) {

	//if ( 'youtube' === wvc_get_video_url_type( $video_bg_url ) || 'selfhosted' === wvc_get_video_url_type( $video_bg_url ) ) {

		$mute_button_class = 'wvc-row-v-bg-mute-sh';

		if ( 'youtube' === wvc_get_video_url_type( $video_bg_url ) ) {

			$mute_button_class = 'wvc-row-v-bg-mute-yt';

		} elseif ( 'vimeo' === wvc_get_video_url_type( $video_bg_url ) ) {

			$mute_button_class = 'wvc-row-v-bg-mute-vimeo';

		}

		$output .= '<div class="wvc-row-video-bg-mute-button-container">';

		$output .= '<div class="wvc-row-video-bg-mute-button ' . $mute_button_class . '" id="wvc-row-video-bg-mute-button-' . rand( 0, 999 ) . '">';

		$output .= apply_filters( 'wvc_row_video_bg_mute_button_markup', '
			<div class="wvc-bg-video-mute-equalizer"></div>
			' );
		$output .= '</div>';

		$output .= '</div><!--.wvc-row-video-bg-mute-button-container-->';
	
	//}
}

$output .= '</li><!--.slide-->';

echo $output;