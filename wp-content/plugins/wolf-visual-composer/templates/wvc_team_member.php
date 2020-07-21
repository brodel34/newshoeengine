<?php
/**
 * Team member shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'image_id' => '',
	'layout' => apply_filters( 'wvc_default_team_member_layout', 'standard' ),
	'overlay_color' => 'black',
	'overlay_custom_color' => '',
	'overlay_text_color' => '',
	'overlay_text_custom_color' => '',
	'overlay_opacity' => 40,
	'img_style' => '',
	'img_size' => 'medium',
	'custom_img_size' => '',
	'alignment' => '',
	'v_alignment' => 'middle',
	'name' => '',
	'name_font_size' => '',
	'title_tag' => 'h3',
	'role' => '',
	'tagline' => '',
	'show_socials' => '',
	'link' => '',
	'title_font_family' => '',
	'title_font_weight' => '',
	'title_font_size' => '',
	'title_font_style' => '',
	'title_text_transform' => '',
	'title_letter_spacing' => 0,
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

// add social attribute
$wvc_team_member_socials = wvc_get_team_member_socials();

$social_services = array();
foreach ( $wvc_team_member_socials as $social ) {

	if ( isset( $atts[ $social ] ) ) {
		$social_services[ $social ] = $atts[ $social ];
	}
}

$output = $overlay_style = $text_color = $text_style = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

/* Link */
$link = vc_build_link( $link );
$link_url = ( isset( $link['url'] ) ) ? esc_url( $link['url'] ) : '#';
$link_target = ( isset( $link['target'] ) ) ? esc_attr( trim( $link['target'] ) ) : '_self';
$link_title = ( isset( $link['title'] ) ) ? esc_attr( $link['title'] ) : '';
$nofollow = ( isset( $link['rel'] ) && 'nofollow' === $link['rel'] ) ? 'rel="nofollow"' : '';

/* Title font */
$title_text_transform = esc_attr( $title_text_transform );
$title_font_weight = ( $title_font_weight ) ? absint( $title_font_weight ) : '';
$title_letter_spacing = preg_replace( '/[^0-9-.,]/', '', $title_letter_spacing );

if ( $title_font_family && 'default' !== $title_font_family ) {
	$text_style .= 'font-family:' . esc_attr( $title_font_family ) . ';';
}

if ( $title_text_transform ) {
	$text_style .= 'text-transform:' . esc_attr( $title_text_transform ) . ';';
}

if ( $title_font_size ) {
	$text_style .= 'font-size:' . wvc_sanitize_css_value( $title_font_size ) . ';';
}

if ( $title_font_style ) {
	$text_style .= 'font-style:' . esc_attr( $title_font_style ) . ';';
}

if ( '' !== $title_letter_spacing ) {
	$text_style .= 'letter-spacing:' . floatval( $title_letter_spacing ) . 'px;';
}

/* Custom Size */
if ( 'custom' === $img_size ) {
	$img_size = esc_attr( $custom_img_size );
}

if ( 'round' === $img_style ) {
	$img_size = '500x500';
}

$img_size = sanitize_text_field( $img_size );
$img_style = sanitize_text_field( $img_style );
$name = sanitize_text_field( $name );
$tagline = sanitize_text_field( $tagline );
$role = sanitize_text_field( $role );
$alignment = esc_attr( $alignment );
$v_alignment = esc_attr( $v_alignment );
$title_tag = esc_attr( $title_tag );

$class .= " wvc-team-member-container wvc-team-member-layout-$layout wvc-text-$alignment wvc-tm-valign-$v_alignment wvc-element";

if ( $overlay_text_color && 'standard' !== $layout ) {
	$class .= " wvc-text-color-$overlay_text_color";

	$text_color = wvc_convert_color_class_to_hex_value( $overlay_text_color, $overlay_text_custom_color );
	if ( $text_color ) {
		$text_style .= 'color:' . wvc_sanitize_color( $text_color ) . ';';
	}
}

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= '<div class="wvc-team-member-inner">';

if ( ! in_array( $img_size, array( 'thumbnail', 'medium', 'large', 'wvc-XL', 'full' ) ) ) {
	$img = wpb_getImageBySize( array(
		'attach_id' => $image_id,
		'thumb_size' => $img_size,
	) );
	$image = ( isset( $img['thumbnail'] ) ) ? $img['thumbnail'] : '';

} else {
	$image = wp_get_attachment_image( absint( $image_id ), $img_size );
}

// Image fallback
$image = ( $image ) ? $image : wvc_placeholder_img( $img_size );

if ( $image ) {
	$output .= '<div class="wvc-team-member-image">';

	$output .= $image;

	$output .= '</div><!--.wvc-team-member-image-->';
}

$headings_array = array( 'h2', 'h3', 'h4', 'h5', 'h6' );
$title_tag = ( in_array( $title_tag, $headings_array ) ) ? $title_tag : 'h3';

$output .= '<div class="wvc-team-member-caption-container">';

if ( $link_url ) {
	$output .= "<a $nofollow class='wvc-tm-link-mask' href='$link_url' target='$link_target'></a>";
}

if ( 'overlay' === $layout || 'flip-box' === $layout ) {

	$dominant_color = wvc_get_image_dominant_color( $image_id );

	if ( $dominant_color && 'auto' === $overlay_color ) {
		$overlay_custom_color = $dominant_color;
	}

	$output .= wvc_background_overlay( array( 'overlay_color' => $overlay_color, 'overlay_custom_color' => $overlay_custom_color, 'overlay_opacity' => $overlay_opacity, ) );
}

$output .= '<div class="wvc-team-member-caption">';

//if ( $name_font_size ) {
	//$name_font_size = wvc_sanitize_css_value( $name_font_size );
	//$text_style .= "font-size:$name_font_size;";
//}

if ( $link_url ) {
	$output .= "<a href='$link_url' target='$link_target'>";
}

if ( $name ) {
	$output .= "<$title_tag class='wvc-team-member-name' style='" . wvc_esc_style_attr( $text_style ) . "'>";

	$output .= "<span>$name</span>";

	$output .= "</$title_tag>";
}

if ( $role ) {
	$output .= '<span class="wvc-team-member-role" style="color:' . $text_color . '">' . $role . '</span>';
}

if ( $tagline ) {
	$output .= '<div class="wvc-team-member-tagline" style="color:' . $text_color . '"><p>' . $tagline . '</p></div>';
}

if ( $link_url ) {
	$output .= '</a>';
}

if ( 'true' === $show_socials && array() != $social_services ) {
	$output .= '<div class="wvc-team-member-social-container">';

	$wvc_socials_args = apply_filters( 'wvc_team_member_socials_args', array() );
	$wvc_socials_args['services'] = $social_services;
	$output .= wvc_socials( $wvc_socials_args );

	$output .= '</div><!--.wvc-team-member-social-container-->';
}

$output .= '</div><!--.wvc-team-member-caption-->';

$output .= '</div><!--.wvc-team-member-caption-container-->';

$output .= '</div><!--.wvc-team-member-inner-->';

$output .= '</div><!--.wvc-team-member-container-->';

echo $output;