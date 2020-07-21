<?php
/**
 * Icon with text shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'type' 				=> '',
	'icon' 				=> '',
	'title'                 		=> '',
	'title_font_size'                 	=> '',
	'title_font_family'                 	=> '',
	'title_tag'             		=> 'h5',
	'title_text_transform'             	=> '',
	'title_letter_spacing'             	=> '',
	'text'                  		=> '',
	'size'				=> '',
	'use_custom_size'  		=> '',
	'color'				=> 'default',
	'custom_color'			=> '',
	'background_style'		=> 'none',
	'background_color'		=> '',
	'custom_background_color'	=> '',
	'position'                  		=> '',
	'container_alignement' => '',
	'text_alignement'		=> '',
	'size'                  		=> '',
	'hover_effect'			=> 'none',
	'inner_animation'        	=> '',
	'inner_animation_delay'  	=> '',
	'link'                  		=> '',
	'scroll_to_anchor' 		=> '',
	'media_type' 			=> '',
	'image_id'			=> '',
	'animated_icon_lineaicons'	=> '',
	'animated_icon_color'	=> '',
	'animated_icon_custom_color'	=> '',
	'css_animation'		=> '',
	'css_animation_delay' 	=> '',
	'css'				=> '',
	'el_class'			=> '',
	'inline_style' => '',
), $atts ) );

vc_icon_element_fonts_enqueue( $type );

$icon = ( isset( $atts["icon_$type"] ) ) ? $atts["icon_$type"] : '';

$background_style = ( $background_style ) ? $background_style : 'none';

if ( 'none' !== $background_style ) {
	$icon_color = 'default';
}

if ( 'none' === $background_style ) {
	$hover_effect = 'none';
}

// vars
$output = '';
$icon_html = '';
$title_html = '';
$p_style = '';
$container_class = '';
$container_style = '';
$icon_container_style = '';
$icon_style = '';
$title_style = '';
$icon_filler_style = '';
$svg_style = '';

$class = $el_class;
$container_style = wvc_sanitize_css_field( $inline_style );
$container_style .= wvc_shortcode_custom_style( $css );

// link
$link = vc_build_link( $link );
$link_url = ( isset( $link['url'] ) ) ? esc_url( $link['url'] ) : '#';
$link_target = ( isset( $link['target'] ) ) ? esc_attr( trim( $link['target'] ) ) : '_self';
$link_title = ( isset( $link['title'] ) ) ? esc_attr( $link['title'] ) : '';
$nofollow = ( isset( $link['rel'] ) && 'nofollow' === $link['rel'] ) ? 'rel="nofollow"' : '';

/* Icon color */
if ( 'custom' === $color ) {
	$color = $custom_color;
	$icon_style .= 'color:' . wvc_sanitize_color( $color ) . ';';
	$svg_style .= 'color:' . wvc_sanitize_color( $animated_icon_color ) . ';';
}

/* SVG color (?? not used) */
if ( 'custom' === $animated_icon_color ) {
	$animated_icon_color = $animated_icon_custom_color;
	$svg_style .= 'color:' . wvc_sanitize_color( $animated_icon_color ) . ';';
}

/* Background color */
if ( 'custom' === $background_color ) {
	$background_color = $custom_background_color;
	$bg_color = wvc_sanitize_color( $background_color );
	$icon_container_style .="background-color:$bg_color;border-color:$bg_color;box-shadow-color:$bg_color;";
	$icon_filler_style .="background-color:$bg_color;box-shadow-color:$bg_color;";
}

/*Animate */
$container_class .= 'wvc-element';

//$container_class .= wvc_get_css_animation( $css_animation );
//$container_style .= wvc_get_css_animation_delay( $css_animation_delay );

if ( ! wvc_is_new_animation( $css_animation ) ) {
	$container_class .= wvc_get_css_animation( $css_animation );
	$container_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$icon_container_style .= ( $inner_animation_delay ) ? 'animation-delay:' . absint( $inner_animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $inner_animation_delay ) / 1000 . 's;' : '' ;

$headings_array = array( 'h2', 'h3', 'h4', 'h5', 'h6', 'span' );
$title_tag = ( in_array( $title_tag, $headings_array ) ) ? esc_attr( $title_tag ) : 'h3';

switch ( $size ) {

	case 'fa-2x':
		$box_size = 'small';
		break;
	case 'fa-3x':
		$box_size = 'medium';
		break;
	case 'fa-4x':
		$box_size = 'large';
		break;
	case 'fa-5x':
		$box_size = 'very-large';
		break;
	default:
		$box_size = 'tiny';
}

$box_class = "$class wvc-icon-box wvc-clearfix wvc-icon-position-$position wvc-icon-box-$box_size wvc-icon-background-style-$background_style wvc-icon-hover-$hover_effect wvc-icon-container-alignment-$container_alignement";

/*Animate */
$box_class .= wvc_get_css_animation( $css_animation );

$icon_container_class = 'wvc-icon-container';

if ( 'image' !== $media_type ) {
	$icon_container_class .= ' ' . $size;
}

if ( 'normal' !== $background_style && 'image' !== $media_type ) {
	$icon_container_class .= ' fa-stack';
}

if ( $inner_animation ) {
	//$icon_container_class .= ' wow bounceIn';
}

if ( 'none' !== $background_style ) {
	$icon_container_class .= " wvc-icon-background-color-$background_color";
}

if ( 'top' === $position ) {
	$box_class .= " wvc-text-$text_alignement";
}

$open_icon_html_tag = 'div';

if ( $link_url ) {
	$icon_html_link_target = ( $link_target ) ? ' target="_blank"' : '';
	$open_icon_html_tag = 'a href="' . esc_attr( $link_url ) . '"' . $icon_html_link_target;

	if ( $scroll_to_anchor ) {
		$box_class .= ' wvc-scroll';
	}
}

$output .= '<div class="' . wvc_sanitize_html_classes( $container_class ) .'" style="' . wvc_esc_style_attr( $container_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );

$output .= '>';

$output .= '<' . $open_icon_html_tag .  ' class="' . wvc_sanitize_html_classes( $box_class ) .'">';

// Sorry no animated icon for edge. Just doesn't work correctly
if (
	wvc_is_edge() &&
	'animated_icon' === $media_type ) {
	$media_type = 'icon';
	$icon = $animated_icon_lineaicons;
	$color = $animated_icon_color;
}

if ( 'icon' === $media_type || ! $media_type ) {

	$icon_html .= '<div class="' . wvc_sanitize_html_classes( $icon_container_class ) . '" style="' . wvc_esc_style_attr( $icon_container_style ) . '"><div class="wvc-icon-background-fill" style="' . wvc_esc_style_attr( $icon_filler_style ) . '"></div>';

	if ( 'none' === $background_style ) {

		$icon_html .= '<i style="' . wvc_esc_style_attr( $icon_style ) . '" class="wvc-icon-color-' . $color . ' wvc-icon fa '. esc_attr( $icon ) . '"></i>';

	} elseif ( 'ban' === $background_style ) {

		$icon_html .= '<i style="' . wvc_esc_style_attr( $icon_style ) . '" class="wvc-icon-color-' . $color . ' wvc-icon fa '. esc_attr( $icon ) . ' fa-stack-1x"></i>';

		$icon_html .= '<i style="' . wvc_esc_style_attr( $icon_style ) . '" class="wvc-icon-color-' . $color . ' wvc-icon fa fa-ban fa-stack-2x wvc-text-danger"></i>';

	} else {

		$icon_html .= '<i style="' . wvc_esc_style_attr( $icon_style ) . '" class="wvc-icon-color-' . $color . ' wvc-icon fa '. esc_attr( $icon ) . ' fa-stack-1x"></i>';
	}


	$icon_html .= '</div>'; // end icon container

// Animated SVG icon
} elseif ( 'animated_icon' === $media_type ) {

	$icon_container_class .= ' wvc-image-icon';

	$icon_html .= '<div class="' . wvc_sanitize_html_classes( $icon_container_class ) . '" style="' . wvc_esc_style_attr( $icon_container_style ) . '">';

	$search = array(
		'linea-arrows',
		'linea-basic-elaboration',
		'linea-basic',
		'linea-ecommerce',
		'linea-music',
		'linea-software',
		'linea-weather',
		'-',
	);
	$replace = array(
		'_arrows/_SVG/arrows',
		'_basic-elaboration/_SVG/basic_elaboration',
		'_basic/_SVG/basic',
		'_ecommerce/_SVG/ecommerce',
		'_music/_SVG/music',
		'_software/_SVG/software',
		'_weather/_SVG/weather',
		'_',
	);
	$svg_file = str_replace( $search, $replace, $animated_icon_lineaicons ) . '.svg';

	$svg_filename = WVC_URI . '/assets/css/lib/linea-icons/svg/' . $svg_file;

	$icon_html .= wvc_animated_svg( $svg_filename, array( 'class' => 'wvc-svg-icon-color-' . $animated_icon_color ) );

	$icon_html .= '</div>'; // end icon container

} elseif ( 'image' === $media_type ) {

	$image = wvc_get_url_from_attachment_id( $image_id );

	$filetype = wp_check_filetype( $image );

	$icon_container_class .= ' wvc-image-icon';

	$icon_html .= '<div class="' . wvc_sanitize_html_classes( $icon_container_class ) . '" style="' . wvc_esc_style_attr( $icon_container_style ) . '">';

	if ( isset( $filetype['ext'] ) && 'svg' === $filetype['ext'] ) { //  is SVG

		$icon_html .= wvc_animated_svg( $image );

	} else {

		$image_icon_size = array(
			'tiny' => '32x32',
			'small' => '64x64',
			'medium' => '96x96',
			'large' => '128x128',
			'very-large' => '160x160',
		);

		$img = wpb_getImageBySize( array(
			'attach_id' => $image_id,
			'thumb_size' => $image_icon_size[ $box_size ],
			'class' => 'wvc-image-icon',
		) );
		$image = ( isset( $img['thumbnail'] ) ) ? $img['thumbnail'] : '';
		$icon_html .= $image;
	}

	$icon_html .= '</div>'; // end icon container
}

/**
 *  Title tag
 */
if ( $title_font_size ) {
	$title_font_size = ( is_numeric( $title_font_size ) ) ? absint( $title_font_size ) . 'px' : $title_font_size;
	$title_style .= 'font-size:' . esc_attr( $title_font_size ) . ';';
}

if ( $title_font_family && 'default' !== $title_font_family ) {
	$title_style .= 'font-family:' . esc_attr( $title_font_family ) . ';';
}

if ( $title_text_transform ) {
	$title_style .= 'text-transform:' . esc_attr( $title_text_transform ) . ';';
}

//$title_letter_spacing = preg_replace( '/[^0-9-.,]/', '', $title_letter_spacing );
if ( $title_letter_spacing ) {
	$title_style .= 'letter-spacing:' . esc_attr( $title_letter_spacing ) . ';';
}

$title_html .= '<' . esc_attr( $title_tag  ). ' style="' . wvc_esc_style_attr( $title_style ) . '" class="wvc-icon-title">';

$title_html .= do_shortcode( $title );

$title_html .= '</' . esc_attr( $title_tag ) . '>';

/**
 * Display the layout differently depending on the position option
 */
if ( 'left_from_title' == $position ) {

	$output .= "<div class='wvc-icon-text-holder'>";
	$output .= "<div class='wvc-icon-text-inner'>";
	$output .= "<div class='wvc-icon-title-holder'>";
	$output .= "<div class='wvc-icon-holder'>";

	// icon
	$output .= $icon_html;
	$output .= '</div><!-- .wvc-icon-holder -->';

	if ( $title ) {
		$output .= wp_kses(
			$title_html,
			array(
				'i' => array( 'class' => array(), 'style' => array(), 'data-icon-hover-color' => array(), ),
				'div' => array( 'class' => array(), 'style' => array(), 'data-bg-hover-color' => array(), 'data-border-hover-color' => array(), ),
				'h1' => array( 'class' => array(), 'style' => array(), ),
				'h2' => array( 'class' => array(), 'style' => array(), ),
				'h3' => array( 'class' => array(), 'style' => array(), ),
				'h4' => array( 'class' => array(), 'style' => array(), ),
				'h5' => array( 'class' => array(), 'style' => array(), ),
				'h6' => array( 'class' => array(), 'style' => array(), ),
				'a' => array( 'href' => array(), 'target' => array(), 'style' => array(), 'class' => array(), ),
			)
		);
	}
	$output .= '</div><!-- .wvc-icon-title-holder -->';

	if ( $text ) $output .= '<p style="' . wvc_esc_style_attr( $p_style ) . '">' . $text . '</p>';

	$output .= '</div><!-- .wvc-icon-text-inner -->';
	$output .= '</div><!-- .wvc-icon-text-holder -->';

} elseif ( 'right_from_title' == $position ) {

	$output .= "<div class='wvc-icon-text-holder'>";
		$output .= "<div class='wvc-icon-text-inner'>";
		$output .= "<div class='wvc-icon-title-holder'>";

		if ( $title ) {
			$output .= wp_kses(
				$title_html,
				array(
					'i' => array( 'class' => array(), 'style' => array(), 'data-icon-hover-color' => array(), ),
					'div' => array( 'class' => array(), 'style' => array(), 'data-bg-hover-color' => array(), 'data-border-hover-color' => array(), ),
					'h1' => array( 'class' => array(), 'style' => array(), ),
					'h2' => array( 'class' => array(), 'style' => array(), ),
					'h3' => array( 'class' => array(), 'style' => array(), ),
					'h4' => array( 'class' => array(), 'style' => array(), ),
					'h5' => array( 'class' => array(), 'style' => array(), ),
					'h6' => array( 'class' => array(), 'style' => array(), ),
					'a' => array( 'href' => array(), 'target' => array(), 'style' => array(), 'class' => array(), ),
				)
			);
		}
		$output .= "<div class='wvc-icon-holder'>";

		// icon
		$output .= $icon_html;
		$output .= '</div><!-- .wvc-icon-holder -->';

		$output .= '</div><!-- .wvc-icon-title-holder -->';

		if ( $text ) $output .= '<p style="' . wvc_esc_style_attr( $p_style ) . '">' .  $text . '</p>';

		$output .= '</div><!-- .wvc-icon-text-inner -->';
	$output .= '</div><!-- .wvc-icon-text-holder -->';

} else {
	$output .= "<div class='wvc-icon-holder'>";

	// icon
	$output .= $icon_html;
	$output .= '</div>';

	$output .= "<div class='wvc-icon-text-holder'>";
	$output .= "<div class='wvc-icon-text-inner'>";

	if ( $title ) {
		$output .= wp_kses(
			$title_html,
			array(
				'i' => array( 'class' => array(), 'style' => array(), 'data-icon-hover-color' => array(), ),
				'div' => array( 'class' => array(), 'style' => array(), 'data-bg-hover-color' => array(), 'data-border-hover-color' => array(), ),
				'h1' => array( 'class' => array(), 'style' => array(), ),
				'h2' => array( 'class' => array(), 'style' => array(), ),
				'h3' => array( 'class' => array(), 'style' => array(), ),
				'h4' => array( 'class' => array(), 'style' => array(), ),
				'h5' => array( 'class' => array(), 'style' => array(), ),
				'h6' => array( 'class' => array(), 'style' => array(), ),
				'a' => array( 'href' => array(), 'target' => array(), 'style' => array(), 'class' => array(), ),
			)
		);
	}

	if ( $text ) $output .= '<p style="' . wvc_esc_style_attr( $p_style ) . '">' . $text . '</p>';

	$output .= '</div><!-- .wvc-icon-text-inner -->';
	$output .= '</div><!-- .wvc-icon-text-holder -->';
}

$end_icon_html_tag = 'div';

if ( $link_url ) {
	$end_icon_html_tag = 'a';
}

$output .= '</' . $end_icon_html_tag . '><!-- .wvc-icon-box  -->';
$output .= '</div><!-- .wvc-element  -->';

echo $output;