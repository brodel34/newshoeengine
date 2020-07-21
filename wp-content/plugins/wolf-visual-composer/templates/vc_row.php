<?php
/**
 * Row shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

// If it's a content block, we just stop here and output the content block shortcode
if ( class_exists( 'Wolf_Vc_Content_Block' ) && preg_match( '/\[wvc_content_block [a-zA-Z0-9-_=" ]+\]/', $content, $match ) ) {
	if ( isset( $match[0] ) ) {
		echo wpb_js_remove_wpautop( $match[0] );
	}
} else { // continue normally

/* The wvc_raw_row_atts filter allows to add, edit or remove attributes before they are filtered by the plugin */
$atts = vc_map_get_attributes( $this->getShortcode(), apply_filters( 'wvc_raw_row_atts', $atts ) );

extract( shortcode_atts( array(
	'full_width' => 'stretch_row',
	'full_height' => '',
	'font_color' => 'dark',
	'column_type' => 'column',
	'container_width' => 'wide',
	'content_width' => 'standard',
	'content_placement' => 'default',
	'columns_placement' => '',
	'gap' => '',
	'equal_height' => 'no',
	'min_height' => '',
	'box_shadow' => '',
	'background_type' => '',
	'background_color' => '',
	'background_custom_color' => '',
	'background_img' => '',
	'background_position' => 'center center',
	'background_repeat' => 'no-repeat',
	'background_size' => 'cover',
	'background_effect' => '',
	'background_marquee_position' => 'stretch',
	'background_img_lazyload' => true,
	'background_img_preloader' => false,
	'slideshow_img_ids' => '',
	'slideshow_speed' => '5000',
	'video_bg_url' => '',
	'video_bg_img' => '',
	'video_bg_img_mobile' => '',
	'video_bg_start_time' => '',
	'video_bg_end_time' => '',
	'video_bg_parallax' => '',
	'video_bg_loop' => true,
	'video_bg_mute_button' => '',
	'video_bg_unmute' => '',
	'add_overlay' => '',
	'add_noise' => '', // superflick (deprecated)
	'add_effect' => '', // custom theme effect
	'overlay_color' => 'black',
	'overlay_custom_color' => '#000000',
	'overlay_opacity' => '',

	'rtl_reverse' => '',

	'sd_bottom_type' => '',
	'sd_bottom_shape' => '',
	'sd_bottom_img' => '',
	'sd_bottom_flip' => '',
	'sd_bottom_inverted' => '',
	'sd_bottom_height' => '25%',
	'sd_bottom_color' => '',
	'sd_bottom_custom_color' => '',
	'sd_bottom_opacity' => '',
	'sd_bottom_ratio' => '',
	'sd_bottom_zindex' => '',
	'sd_bottom_responsive' => 'yes',

	'sd_top_type' => '',
	'sd_top_shape' => '',
	'sd_top_img' => '',
	'sd_top_flip' => '',
	'sd_top_inverted' => '',
	'sd_top_height' => '25%',
	'sd_top_color' => '',
	'sd_top_custom_color' => '',
	'sd_top_opacity' => '',
	'sd_top_ratio' => '',
	'sd_top_zindex' => '',
	'sd_top_responsive' => 'yes',

	'border_color' => '',
	'border_custom_color' => '',
	'border_style' => '',
	'add_particles' => '',
	'particles_type' => 'default',
	'mousewheel_down' => '',
	'arrow_down' => '',
	'arrow_down_text' => '',
	'arrow_down_alignement' => '',
	'sticky_player_playlist_id' => '',
	'sticky_player_playlist_skin' => '',
	'add_bigtext' => '',
	'bigtext_marquee' => false,
	'bt_text' => '',
	'bt_font_family' => '',
	'bt_letter_spacing' => 0,
	'bt_font_weight' => 700,
	'bt_text_transform' => 'none',
	'bt_font_style' => '',
	'bt_color' => '',
	'bt_custom_color' => '',
	'bt_vertical_align' => 'middle',
	'bt_max_width' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'hide_class' => '',
	'shift_y' => 0,
	'z_index' => '',
	'css' => '',
	'el_id' => '',
	'disable_element' => '',
	'row_name' => '',
	'el_class' => '',
	'inline_style' => '',
), apply_filters( 'wvc_row_atts', $atts ) ) );

if ( 'yes' === $disable_element && ! vc_is_page_editable() ) {
	return;
}

wp_enqueue_script( 'inview' );
wp_enqueue_script( 'wpb_composer_front_js' );

/* Add filters depending on row attributes */
do_action( 'wvc_add_row_filters', $atts );

$output = $section_style = $wrapper_style = $columns_container_style =  $background_html = $border_class = $bt_inline_style = '';

$inline_style .= wvc_sanitize_css_field( $inline_style );

if ( 'none' !== $border_style && '' !== $border_style ) {
	$inline_style .= 'border-width:0;';
	$inline_style .= "border-style:$border_style;";
}

$inline_style .= wvc_shortcode_custom_style( $css );

if ( $shift_y ) {
	$shift_y = esc_attr( $shift_y ) . 'px';
	$inline_style .= "transform:translateY($shift_y);margin-bottom:$shift_y;";
}

if ( $z_index ) {
	$inline_style .= "z-index:$z_index;";
}

if ( 'image' === $background_type || 'default_header' === $background_type || 'featured_image' === $background_type ) {

	if ( 'featured_image' === $background_type ) {
		
		$background_img = ( get_post_thumbnail_id() ) ? get_post_thumbnail_id() : wvc_get_hero_image_id();
	} 

	if ( 'default_header' === $background_type ) {
		$background_img = wvc_get_hero_image_id();
	}

	$background_hex_color = null;
	if ( 'custom' === $background_color ) {
		$background_hex_color = $background_custom_color;
	}

	$img_bg_args = array(
		'background_img' => $background_img,
		'background_color' => $background_hex_color,
		'background_position' => $background_position,
		'background_repeat' => $background_repeat,
		'background_size' => $background_size,
		'background_effect' => $background_effect,
		'background_img_lazyload' => $background_img_lazyload,
		'background_img_preloader' => $background_img_preloader,
	);

	$background_html .= wvc_background_img( $img_bg_args );

// video background
} elseif ( 'video' === $background_type ) {

	$video_bg_args = array(
		'video_bg_url' => $video_bg_url,
		'video_bg_img' => $video_bg_img,
		'video_bg_img_mobile' => $video_bg_img_mobile,
		'video_bg_start_time' => $video_bg_start_time,
		'video_bg_end_time' => $video_bg_end_time,
		'video_bg_parallax' => $video_bg_parallax,
		'video_bg_loop' => $video_bg_loop,
		//'video_bg_controls' => $video_bg_controls,
		'video_bg_unmute' => $video_bg_unmute,
	);

	$background_html .= wvc_background_video( $video_bg_args );

} elseif ( 'slideshow' === $background_type ) {

	$slideshow_args = array(
		'slideshow_img_ids' => $slideshow_img_ids,
		'slideshow_speed' => $slideshow_speed,
	);

	$background_html .= wvc_background_slideshow( $slideshow_args );
}

if ( 'yes' === $add_overlay ) {

	$main_image = ( 'video' === $background_type ) ? $video_bg_img : $background_img;
	$dominant_color = wvc_get_image_dominant_color( $main_image );

	if ( 'auto' === $overlay_color ) {
		$overlay_custom_color = ( $dominant_color ) ? $dominant_color : '#000000';
	}

	$background_html .= wvc_background_overlay( array( 'overlay_color' => $overlay_color, 'overlay_custom_color' => $overlay_custom_color, 'overlay_opacity' => $overlay_opacity, ) );
}

if ( 'true' === $add_bigtext || 'yes' === $add_bigtext ) {
	$bigtext_params = array(
		'text' => $bt_text,
		'font_family' => $bt_font_family,
		'letter_spacing' => $bt_letter_spacing,
		'font_weight' => $bt_font_weight,
		'text_transform' => $bt_text_transform,
		'font_style' => $bt_font_style,
		'color' => $bt_color,
		'custom_color' => $bt_custom_color,
		'title_tag' => 'p',
	);

	if ( $bt_max_width ) {
		$bt_max_width = wvc_sanitize_css_value( $bt_max_width );
		$bt_inline_style .= "min-width:0;max-width:$bt_max_width";
	}

	$bigtext_class = 'wvc-row-bigtext-container';

	if ( $bigtext_marquee ) {
		$bigtext_class .= ' wvc-row-bigtext-marquee';
	}

	$background_html .= "<div class='$bigtext_class wvc-row-big-text-vertical-align-$bt_vertical_align'>";
	//$background_html .= "<div class='wvc-row-bigtext-inner'>";
	$background_html .= '<div class="wvc-row-bigtext-content" style="' . wvc_esc_style_attr( $bt_inline_style ) . '">';
	$background_html .= wvc_generate_bigtext( $bigtext_params );
	if ( $bigtext_marquee ) {
		$bigtext_params['el_class'] = 'wvc-row-bigtext-aux';
		$background_html .= wvc_generate_bigtext( $bigtext_params );
	}
	$background_html .= '</div>';
	
	//$background_html .= '</div>';
	$background_html .= '</div>';
}

if ( $add_noise ) {
	$background_html .= '<div class="noise"></div>';
}

if ( $add_effect ) {
	$background_html .= apply_filters( 'wvc_background_effect', '', $atts );
}

if ( 'yes' === $add_particles ) {

	wp_enqueue_script( 'particles' );
	wp_enqueue_script( 'wvc-particles' );

	$particles_rand = 'wvc-particles-' . rand( 0, 9999 );

	$background_html .= '<div class="wvc-bg-overlay wvc-particles" id="' . esc_attr( $particles_rand ) . '"></div>';
}

if ( $sd_bottom_type && 'disabled' !== $sd_bottom_type ) {

	$background_html .= wvc_shape_divider( array(
		'sd_position' => 'bottom',
		'sd_type' => $sd_bottom_type,
		'sd_shape' => $sd_bottom_shape,
		'sd_img' => $sd_bottom_img,
		'sd_flip' => $sd_bottom_flip,
		'sd_inverted' => $sd_bottom_inverted,
		'sd_height' => $sd_bottom_height,
		'sd_color' => $sd_bottom_color,
		'sd_custom_color' => $sd_bottom_custom_color,
		'sd_opacity' => $sd_bottom_opacity,
		'sd_ratio' => $sd_bottom_ratio,
		'sd_zindex' => $sd_bottom_zindex,
		'sd_responsive' => $sd_bottom_responsive,
	) );
}

if ( $sd_top_type && 'disabled' !== $sd_top_type ) {

	$background_html .= wvc_shape_divider( array(
		'sd_position' => 'top',
		'sd_type' => $sd_top_type,
		'sd_shape' => $sd_top_shape,
		'sd_img' => $sd_top_img,
		'sd_flip' => $sd_top_flip,
		'sd_inverted' => $sd_top_inverted,
		'sd_height' => $sd_top_height,
		'sd_color' => $sd_top_color,
		'sd_custom_color' => $sd_top_custom_color,
		'sd_opacity' => $sd_top_opacity,
		'sd_ratio' => $sd_top_ratio,
		'sd_zindex' => $sd_top_zindex,
		'sd_responsive' => $sd_top_responsive,
	) );
}

if ( 'block' === $column_type ) {
	$content_width = 'full';
}

$video_bg_mute_button_class = ( $video_bg_unmute ) ? '.wvc-video-bg-is-unmute' : 'wvc-video-bg-is-mute';

$css_classes = array(
	//'vc_row',
	//'wpb_row',
	//$custom_style_class,
	'wvc-clearfix',
	$el_class,
	//vc_shortcode_custom_css_class( $css ),
	'wvc-row',
	'wvc-parent-row',
	"wvc-row-width-$container_width",
	"wvc-row-layout-$column_type",
	$video_bg_mute_button_class,
	$hide_class,
);

if ( 'yes' === $disable_element && vc_is_page_editable() ) {
	$css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
}

if ( $mousewheel_down ) {
	//wp_enqueue_script( 'inview' );
	//wp_enqueue_script( 'mousewheel' );
	$css_classes[] = 'wvc-row-mousewheel-scroll-down';
}

if ( $rtl_reverse ) {
	$css_classes[] = 'wvc_rtl-columns-reverse';
}

if ( $sticky_player_playlist_id ) {
	$css_classes[] = 'wvc-row-has-sticky-player';
}

$wrapper_css_classes = array(
	'wvc-row-wrapper',
);

if ( 'custom' === $border_color && $border_custom_color ) {

	$inline_style .= 'border-color:' . wvc_sanitize_color( $border_custom_color ) . ';';

} else {
	$border_class = "wvc-border-color-$border_color"; // border color class
}

if ( 'wide' === $container_width ) {
	$css_classes[] = "wvc-row-bg-effect-$background_effect";

	if ( 'marquee' === $background_effect ) {
		$css_classes[] = "wvc-row-bg-marquee-$background_marquee_position";
	}

	$css_classes[] = "wvc-row-bg-$background_type";
	$css_classes[] = "wvc-font-$font_color";
	$css_classes[] = $this->getExtraClass( $el_class );

	if ( ! wvc_is_new_animation( $css_animation ) ) {
		$css_classes[] = wvc_get_css_animation( $css_animation );
	}

	$css_classes[] = $border_class;

	if ( $video_bg_parallax ) {
		$css_classes[] = "wvc-row-bg-video-parallax";
	}

	if ( 'custom' !== $background_color ) {
		$css_classes[] = "wvc-background-color-$background_color";
		$background_color = '';
	}

	if ( 'full' === $content_width ) {
		$css_classes[] = 'wvc-row-is-fullwidth';
	}

	if ( 'large' === $content_width ) {
		$css_classes[] = 'wvc-row-is-large';
	}

	$wrapper_css_classes[] = "wvc-row-wrapper-width-$content_width";

} else {
	$wrapper_css_classes[] = "wvc-row-bg-effect-$background_effect";

	if ( 'marquee' === $background_effect ) {
		$css_classes[] = "wvc-row-bg-marquee-$background_marquee_position";
	}
	
	$wrapper_css_classes[] = "wvc-row-bg-$background_type";
	$wrapper_css_classes[] = "wvc-font-$font_color";
	$wrapper_css_classes[] = $this->getExtraClass( $el_class );

	if ( ! wvc_is_new_animation( $css_animation ) ) {
		$wrapper_css_classes[] = wvc_get_css_animation( $css_animation );
	}
	
	$wrapper_css_classes[] = $border_class;

	if ( 'transparent' === $background_color  ) {
		$wrapper_css_classes[] = "wvc-row-bg-transparent";
		$background_color = '';
	}

	if ( $video_bg_parallax ) {
		$css_classes[] = "wvc-row-bg-video-parallax";
	}

	if ( 'custom' !== $background_color ) {
		$wrapper_css_classes[] = "wvc-background-color-$background_color";
		$background_color = '';
	}

	$css_classes[] = apply_filters( 'wvc_default_row_skin_class', 'wvc-font-default' );

	//$inline_style .= "min-height:$min_height;";
}

if ( $box_shadow && 'wide' !== $container_width ) {
	$css_classes[] = 'wvc-row-box-shadow';
}

$wrapper_attributes = array();

// build attributes for wrapper
if ( $row_name ) {
	$el_id = sanitize_title( $row_name );
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '" data-anchor="' . esc_attr( $el_id ) . '" data-row-name="' . esc_attr( $row_name ) . '"';
}

if ( '' !== $gap && '35' !== $gap ) {
	$wrapper_attributes[] = 'data-column-gap="' . esc_attr( $gap ) . '"';
	$gap = absint( $gap ) . 'px';
	$gap_margin = absint( $gap ) * 2 . 'px';
	/*$columns_container_style .= "
		width: calc(100% + $gap_margin);
		margin-left: -$gap;
		";*/

	//$columns_container_style .= "border-spacing: $gap 0;";
}

if ( $full_height ) {
	$css_classes[] = 'wvc-row-full-height';
}

if ( $min_height ) {
	$css_classes[] = 'wvc-row-min-height';
	$min_height = wvc_sanitize_css_value( $min_height );
	$inline_style .= "min-height:$min_height;";

	if ( 'yes' !== $equal_height && 'column' === $column_type ) {
		//$columns_container_style .= "min-height:$min_height;";
	}
}

if ( 'column' === $column_type ) {

	$wrapper_css_classes[] = "wvc-row-column-equal-height-$equal_height";
	$css_classes[] = 'wvc-row-content-placement-' . $content_placement;
	$css_classes[] = 'wvc-row-columns-placement-' . $columns_placement;
}

$css_classes = apply_filters( 'wvc_row_css_class', $css_classes );
$row_css_class = wvc_array_to_list( $css_classes, ' ' );

$wrapper_css_classes = wvc_array_to_list( $wrapper_css_classes, ' ' );

$wrapper_attributes[] = 'class="' . wvc_sanitize_html_classes( $row_css_class ) . '"';

if ( 'wide' === $container_width ) {
	$section_style = $inline_style;
} else {
	$wrapper_style = $inline_style;
}

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . ' style="' . wvc_esc_style_attr( $section_style) . '"';

if ( 'wide' === $container_width ) {
	$output .= wvc_element_aos_animation_data_attr( $atts );
}

$output .= '>';

if ( 'wide' === $container_width ) {
	$output .= $background_html;
}

$output .= '<div class="' . wvc_sanitize_html_classes( $wrapper_css_classes ) . '" style="' . wvc_esc_style_attr( $wrapper_style ) . '"'; // wrapper

if ( 'wide' !== $container_width ) {
	$output .= wvc_element_aos_animation_data_attr( $atts );
}

$output .= '>';

if ( 'wide' !== $container_width ) {
	$output .= $background_html;
}

$output .= '<div class="wvc-row-content">';

$output .= '<div class="wvc-columns-container" style="' . wvc_esc_style_attr( $columns_container_style ) . '">';

$output .= wpb_js_remove_wpautop( $content );

$output .= '</div><!--.wvc-columns-container-->';

$output .= '</div><!--.wvc-row-content-->';
$output .= '</div><!--.wvc-row-wrapper-->';

	/* scroll to next section arrow */
	if ( $arrow_down ) {

		$output .= '<span class="wvc-arrow-down wvc-arrow-down-alignement-' . esc_attr( $arrow_down_alignement ) . '">';

		if ( $arrow_down_text ) {
			$output .= '<span class="wvc-arrow-down-text">';
			$output .= $arrow_down_text;
			$output .= '</span>';
		}

		$output .= '</span>';
	}

/**
 * Video mute control
 */
if ( $video_bg_mute_button && $video_bg_url && ! $video_bg_parallax && ! wp_is_mobile() ) {

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

/**
 * Sticky player
 */
if ( $sticky_player_playlist_id && function_exists( 'wpm_playlist' ) ) {
	$attrs = array(
		'show_tracklist' => false,
		'is_sticky_player' => true,
		'theme' => esc_attr( $sticky_player_playlist_skin ),
	);

	$output .= '<div class="wvc-row-sticky-player-container">';

	ob_start();
	wpm_playlist( $sticky_player_playlist_id, $attrs );
	$output .= ob_get_clean();

	$output .= '</div><!--.wvc-row-sticky-player-container-->';
}

$output .= '</div><!--.wvc-row-->';

echo $output;

/* Remove filters depending on row attributes */
do_action( 'wvc_remove_row_filters', $atts );

} // else if content block