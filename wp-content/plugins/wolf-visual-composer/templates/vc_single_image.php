<?php
/**
 * Single image shortcode template
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
	'image' => '',
	'img_size' => '',
	'custom_img_size' => '',
	'shape' => '',
	'border' => '',
	'shadow' => '',
	'hover_effect' => '',
	'add_caption' => '',
	'alignment' => '',
	'full_width' => '',
	'max_width' => '',
	'onclick' => '',
	'opacity' => 100,
	'link' => '',
	'animated_svg' => true,
	'add_overlay' => false,
	'overlay_color' => 'black',
	'overlay_custom_color' => '',
	'overlay_text_color' => '',
	'overlay_text_custom_color' => '',
	'overlay_opacity' => 40,
	'overlay_content' => '',
	'overlay_content_type' => '',
	'title_tag' => 'h5',
	'title_font_family' => '',
	'title_font_weight' => '',
	'title_font_size' => '',
	'title_font_style' => '',
	'title_text_transform' => '',
	'title_letter_spacing' => 0,
	'css_animation' => '',
	'css_animation_delay' => '',
	'hide_class' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$output = $container_class = $container_style = $img_class = $link_start = $link_end = $overlay_style = $text_style = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$container_style .= wvc_shortcode_custom_style( $css );

$class .= " $hide_class"; // device visibility class

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

/* Custom Size */
if ( 'custom' === $img_size ) {
	$img_size = esc_attr( $custom_img_size );
}

$img_id = $image;

$large_img_src = wvc_get_url_from_attachment_id( $img_id, 'wvc-XL' );

$pretty_rel_random = ' data-rel="prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']"';
$swipebox_rel_random = ' data-rel="swipebox[rel-' . get_the_ID() . '-' . rand() . ']"';
$lightbox_rel_random = ' data-rel="lightbox[rel-' . get_the_ID() . '-' . rand() . ']"';

if ( 'link_image' === $onclick ) {

	wp_enqueue_script( 'prettyphoto' );
	wp_enqueue_style( 'prettyphoto' );

} elseif ( 'swipebox' === $onclick) {

	wp_enqueue_script( 'swipebox' );
	wp_enqueue_style( 'swipebox' );

} elseif ( 'lightbox' === $onclick) {

	wp_enqueue_script( 'swipebox' );
	wp_enqueue_style( 'swipebox' );
}


$attachment = get_post( $img_id );
$attachment_page_url = ( $attachment ) ? get_attachment_link( $img_id ) : '#';
$title_attr = ( is_object( $attachment ) ) ? wptexturize( $attachment->post_title ) : '';
$caption = ( is_object( $attachment ) ) ? wptexturize( $attachment->post_excerpt ) : '';

if ( $max_width ) {
	$max_width = wvc_sanitize_css_value( $max_width );
	$inline_style .= "max-width:$max_width;";
}

if ( $full_width ) {
	$class .= ' wvc-single-image-full-width';
}

if ( $opacity ) {
	$opacity = absint( $opacity ) / 100;
	$inline_style .= "opacity:$opacity;";
}

// Link
$link = vc_build_link( $link );
$link_url = ( isset( $link['url'] ) ) ? esc_url( $link['url'] ) : '#';
$link_target = ( isset( $link['target'] ) && $link['target'] ) ? esc_attr( trim( $link['target'] ) ) : '_self';
$link_title = ( isset( $link['title'] ) ) ? esc_attr( $link['title'] ) : '';
$nofollow = ( isset( $link['rel'] ) && 'nofollow' === $link['rel'] ) ? 'rel="nofollow"' : '';

switch ( $onclick ) {

	case 'none':
		//$link_start = '<span class="wvc-img wvc-si-link" data-title="' . esc_attr( $title_attr ) . '">';
		//$link_end = '</span>';
		break;

	case 'attachment_page':
		$link_start = '<a class="wvc-si-link" href="' . esc_url( $attachment_page_url ) . '" data-title="' . esc_attr( $title_attr ) . '">';
		$link_end = '</a>';
		break;

	case 'img_link_large':
		$link_start = '<a class="wvc-si-link" href="' . esc_url( $large_img_src ) . '" data-title="' . esc_attr( $title_attr ) . '">';
		$link_end = '</a>';
		break;

	case 'link_image':
		$link_start = '<a class="wvc-si-link" class="prettyphoto" href="' . esc_url( $large_img_src ) . '"' . $pretty_rel_random . ' data-title="' . esc_attr( $title_attr ) . '">';
		$link_end = '</a>';
		break;

	case 'custom_link':
		$link_start = '<a ' . $nofollow . ' target="' . esc_attr( $link_target ) . '" class="wvc-si-link" href="' . esc_url( $link_url ) . '" data-title="' . esc_attr( $link_title ) . '">';
		$link_end = '</a>';
		break;

	case 'swipebox':
		$link_start = '<a class="wvc-si-link wvc-swipebox" href="' . esc_url( $large_img_src ) . '"' . $swipebox_rel_random . ' data-title="' . esc_attr( $title_attr ) . '">';
		$link_end = '</a>';
		break;

	case 'lightbox':
		$link_start = '<a class="wvc-si-link wvc-lightbox" href="' . esc_url( $large_img_src ) . '"' . $lightbox_rel_random . ' data-title="' . esc_attr( $title_attr ) . '" data-caption="' . esc_attr( $caption ) . '">';
		$link_end = '</a>';
		break;
}

$container_class .= " wvc-single-image-alignement-$alignment wvc-single-image-shape-$shape wvc-element";

$container_class .= " $hide_class"; // device visibility class

$class .= " wvc-single-image wvc-single-image-overlay-$add_overlay wvc-single-image-hover-effect-$hover_effect wvc-single-image-border-$border wvc-single-image-shadow-$shadow wvc-single-image-add-caption-$add_caption";

$output .= '<div class="' . wvc_sanitize_html_classes( $container_class ) . '" style="' . wvc_esc_style_attr( $container_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );

$output .= '>';

if ( $title ) {
	// Title
	$output .= '<h3 class="wvc-single-image-title">' . esc_attr( $title ) . '</h3>';
}

$output .= '<figure class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '">';

if ( ! $add_overlay ) {
	$output .= $link_start;
} else {
	$output .= '<span class="wvc-si-img-inner">';
}

$image = wvc_get_url_from_attachment_id( $img_id );
$filetype = wp_check_filetype( $image );

if ( isset( $filetype['ext'] ) && 'svg' === $filetype['ext'] ) { //  is SVG

	wp_enqueue_script( 'vivus' );
	wp_enqueue_script( 'wvc-vivus' );

	$rand = 'wvc-svg-' . rand( 0, 999 ); //unique ID

	if ( $animated_svg ) {
		
		$output .= wvc_animated_svg( $image, array( 'class' => 'wow', 'animation_duration' => 200, ) );
	
	} else {
		
		$output .= wvc_file_get_contents( esc_url( $image ) );
	}

	//$output .= '<div style="visibility:hidden;" id="' . esc_attr( $rand ) . '" data-animation-duration="200" class="wvc-vivus" data-file="' . esc_url( $image ) . '"></div>';

} else {
	
	if ( ! $add_overlay ) {
		$output .= '<span class="wvc-img wvc-img-hover-effect-' . $hover_effect . '">';
	}

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

	if ( ! $add_overlay ) {
		$output .= '</span>';
	}
}

if ( ! $add_overlay ) {
	$output .= $link_end;
} else {
	$output .= '</span>';
}

if ( $add_overlay ) {

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

	$output .= '<span class="wvc-single-image-overlay">';

	$output .= $link_start;
	$output .= $link_end;

	$add_caption = false;

	$dominant_color = wvc_get_image_dominant_color( $img_id );

	if ( $dominant_color && 'auto' === $overlay_color ) {
		$overlay_custom_color = $dominant_color;
	}

	$output .= wvc_background_overlay(
		array(
			'overlay_color' => $overlay_color,
			'overlay_custom_color' => $overlay_custom_color,
			'overlay_opacity' => $overlay_opacity,
			'overlay_tag' => 'span',
		) );

	
	// Caption

	if ( $overlay_content_type ) {

		$text_color_style_attr = '';
		$text_color_class = '';

		if ( $overlay_text_color ) {
			$text_color_class = "wvc-text-color-$overlay_text_color";

			$text_color = wvc_convert_color_class_to_hex_value( $overlay_text_color, $overlay_text_custom_color );
			if ( $text_color ) {
				$text_style .= 'color:' . wvc_sanitize_color( $text_color ) . ';';
				$text_color_style_attr = 'color:' . wvc_sanitize_color( $text_color ) . ';';
			}
		}

		$output .= '<span class="wvc-single-image-overlay-content">';
		
			$output .= str_replace( 'wvc-si-link', '', $link_start ); // remove link class

		if ( $title_attr ) {

			$output .= "<$title_tag class='wvc-single-image-overlay-title $text_color_class ' style='" . wvc_esc_style_attr( $text_style ) . "'>";

			$output .= "<span>$title_attr</span>";

			$output .= "</$title_tag>";
		}

		if ( $caption ) {
			$output .= "<span class='wvc-single-image-overlay-caption-text $text_color_class' style='$text_color_style_attr'>";

			$output .= "<span>$caption</span>";

			$output .= "</span>";
		}

			$output .= $link_end;

		$output .= '</span>';
	}

	$output .= '</span>'; // img overlay
}

if ( $add_caption ) {
	
	if ( $caption ) {
		$output .= '<figcaption class="wvc-single-image-caption">';
		
		$output .= esc_attr( $title_attr );
		$output .= '<br>';
		$output .= esc_attr( $caption );
		
		$output .= '</figcaption>';
	}
}

$output .= '</figure>';

$output .= '</div>';

echo $output;