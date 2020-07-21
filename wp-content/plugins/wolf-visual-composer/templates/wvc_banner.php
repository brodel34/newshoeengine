<?php
/**
 * Banner shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'image' => '',
	'img_size' => '',
	'custom_img_size' => '',
	'alignment' => '',
	'max_width' => '',
	'link' => '',
	'overlay_color' => '',
	'overlay_custom_color' => '',
	'overlay_text_color' => '',
	'overlay_text_custom_color' => '',
	'overlay_opacity' => '',
	'txt_align' => '',
	'txt_v_align' => '',
	'title' => '',
	'title_font_size' => '',
	'title_tag' => 'h3',
	'tagline' => '',
	'add_button' => '',
	'btn_title' => esc_html__( 'My Button', 'wolf-visual-composer' ),
	'btn_link' => '',
	'btn_color' => '',
	'btn_custom_color' => '',
	'btn_shape' => '',
	'btn_style' => '',
	'btn_size' => '',
	'btn_button_block' => '',
	'btn_hover_effect' => '',
	'btn_font_weight' => '',
	'btn_add_icon' => '',
	'btn_i_align' => '',
	'btn_i_type' => '',
	'btn_i_icon' => '',
	'btn_i_hover' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$output = $img_class = $text_color = $text_style = $title_style = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

/* Custom Size */
if ( 'custom' === $img_size ) {
	$img_size = esc_attr( $custom_img_size );
}

$img_id = $image; // for better understanding

if ( $max_width ) {
	$max_width = wvc_sanitize_css_value( $max_width );
	$inline_style .= "max-width:$max_width;";
}

if ( $overlay_text_color ) {
	$text_color = wvc_convert_color_class_to_hex_value( $overlay_text_color, $overlay_text_custom_color );
	if ( $text_color ) {
		$title_style .= 'color:' . wvc_sanitize_color( $text_color ) . ';';
		$text_style .= 'color:' . wvc_sanitize_color( $text_color ) . ';';
	}
}

if ( $title_font_size ) {
	$title_style .= 'font-size:' . wvc_sanitize_css_value( $title_font_size ) . ';';
}

/* Link */
$link = vc_build_link( $link );
$link_url = esc_url( $link['url'] );
$link_target = ( isset( $link['target'] ) && $link['target'] ) ? esc_attr( $link['target'] )  : '_self';
$link_title = esc_attr( $link['title'] );

$class .= ' wvc-banner wvc-element';
$class .= " wvc-banner-alignment-$alignment wvc-banner-text-align-$txt_align wvc-banner-text-vertical-align-$txt_v_align";

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

if ( $link_url ) {

	$output .= '<a class="wvc-banner-link-mask" href="' . esc_url( $link_url ) . '"';
	$output .= ' target="' . esc_attr( $link_target ) . '"';

	if ( $link_title ) {
		$output .= ' title="' . esc_attr( $link_title ) . '"';
	}

	$output .= '></a>';

}

$output .= '<div class="wvc-banner-image">';

// Image
if ( ! in_array( $img_size, array( 'thumbnail', 'medium', 'large', 'wvc-XL', 'full' ) ) ) {

	if ( wp_attachment_is_image( $img_id ) ) {
			
		$img = wpb_getImageBySize( array(
			'attach_id' => $img_id,
			'thumb_size' => $img_size,
			'class' => $img_class,
		) );

		$output .= $img['thumbnail'];
	} else {
		$output .= wvc_placeholder_img( $img_size, $img_class );
	}

} else {
	if ( wp_attachment_is_image( $img_id ) ) {
		$output .= wp_get_attachment_image( $img_id, $img_size, false, array( 'class' => $img_class ) );
	} else {
		$output .= wvc_placeholder_img( $img_size, $img_class );
	}
}

$output .= '</div><!--.wvc-banner-image-->';

// Overlay
$dominant_color = wvc_get_image_dominant_color( get_post_thumbnail_id() );

if ( $dominant_color && 'auto' === $overlay_color ) {
	$overlay_custom_color = $dominant_color;
}

$output .= wvc_background_overlay( array(
	'overlay_color' => $overlay_color,
	'overlay_custom_color' => $overlay_custom_color,
	'overlay_opacity' => $overlay_opacity, )
);

$output .= '<div class="wvc-banner-caption">';

$output .= '<div class="wvc-banner-caption-table">';

$output .= '<div class="wvc-banner-caption-table-cell">';

if ( $title ) {
	$output .= '<' . esc_attr( $title_tag ) . ' class="wvc-banner-title" style="' . wvc_esc_style_attr( $title_style ) . '">';

	$output .= sanitize_text_field( $title );

	$output .= '</' . esc_attr( $title_tag ) . '>';
}

if ( $tagline ) {
	$output .= '<span class="wvc-banner-tagline" style="' . wvc_esc_style_attr( $text_style ) . '">';

	$output .= sanitize_text_field( $tagline );

	$output .= '</span>';
}

if ( $add_button ) {

	$button_params = array(
		'href' => $link_url,
		'title' => $btn_title,
		'color' => $btn_color,
		'custom_color' => $btn_custom_color,
		'shape' => $btn_shape,
		'style' => $btn_style,
		'size' => $btn_size,
		'button_block' => $btn_button_block,
		'hover_effect' => $btn_hover_effect,
		'font_weight' => $btn_font_weight,
		'add_icon' => $btn_add_icon,
		'i_align' => $btn_i_align,
		'i_hover' => $btn_i_hover,
		'el_class' => '',
	);

	$icon = ( isset( $atts["btn_i_icon_$btn_i_type"] ) ) ? $atts["btn_i_icon_$btn_i_type"] : '';
	
	$button_params = apply_filters( 'wvc_banner_button_atts', $button_params, $atts );

	$banner_button = wvc_generate_button( array_merge( array( 'icon' => $icon ), $button_params ) );

	$output .= $banner_button;
}

$output .= '</div><!--.wvc-banner-caption-table-cell-->';

$output .= '</div><!--.wvc-banner-caption-table-->';

$output .= '</div><!--.wvc-banner-caption-->';

$output .= '</div><!--.wvc-banner-->';

echo $output;