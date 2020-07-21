<?php
/**
 * Video switcher shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'wvc-video-switcher' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/* Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$class .= " wvc-video-switcher-container";

$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$output .= '<div class="wvc-vs-big-video">';
$output .= '<div class="wvc-vs-big-video-inner">';

/* Last video */
$args = array(
	'numberposts' => 1,
	'post_type' => 'video',
	'meta_key' => '_thumbnail_id',
);

$recent_posts = wp_get_recent_posts( $args, ARRAY_A );
$last_post_id = ( isset( $recent_posts[0]['ID'] ) && isset( $recent_posts[0] ) ) ? $recent_posts[0]['ID'] : null;
$last_video_url = get_post_meta( $last_post_id, '_wv_video_url', true );

if ( preg_match( '/(http:|https:)?\/\/[a-zA-Z0-9\/.?&=_-]+.mp4/', $last_video_url, $match ) ) {

	$video_attrs = array(
		'src' => esc_url( $last_video_url ),
		'poster' => get_the_post_thumbnail_url( $last_post_id ),
		'autoplay' => false,
		'preload'  => true,
	);

	$output .= wp_video_shortcode( $video_attrs );

} else {
	$output .= wp_oembed_get( $last_video_url );
}

$output .= '</div><!-- .wvc-vs-big-video-inner -->';
$output .= '</div><!-- .wvc-vs-big-video -->';

$output .= '<div class="wvc-vs-video-thumbnails wvc-clearfix">';

/* Last videos */
$args = array(
	'numberposts' => 4,
	'post_type' => 'video',
	'meta_key' => '_thumbnail_id',
);

$recent_posts = wp_get_recent_posts( $args, ARRAY_A );

if ( is_array( $recent_posts ) && isset( $recent_posts[0] ) ) {
	
	$i = 0;
	
	foreach ( $recent_posts as $post ) {
		
		$post_id = absint( $post['ID'] );

		$t_video_class = ( 0 === $i ) ? 'wvc-vs-video-thumbnail wvc-vs-video-thumbnail-active' : 'wvc-vs-video-thumbnail';
		
		$v_url = esc_url( get_post_meta( $post_id, '_wv_video_url', true ) );

		$output .= "<div class='$t_video_class'>";
			
			$output .= "<a data-wvc-vs-video-post-id='$post_id' target='_blank' class='wvc-vs-video-thumbnail-link' href='$v_url'>";
			
			$img = wpb_getImageBySize( array(
				'attach_id' => get_post_thumbnail_id( $post_id ),
				'thumb_size' => apply_filters( 'wvc_video_switcher_thumbnail_size', '300x170' ),
			) );

			$output .= $img['thumbnail'];
			$output .= '</a>';
		$output .= '</div>';

		$i++;
	}
}

$output .= '</div><!-- .wvc-vs-video-thumbnails -->';

$output .= '</div><!-- .wvc-video-switcher-container -->';

echo $output;