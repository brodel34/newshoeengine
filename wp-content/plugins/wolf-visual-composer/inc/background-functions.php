<?php
/**
 * Wolf WPBakery Page Builder Extension background functions
 *
 * Helper PHP functions to output backgrounds
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Frontend
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Display background overlay
 *
 * @param array $args
 * @return string $output
 */
function wvc_background_overlay( $args ) {

	extract( wp_parse_args( $args, array(
		'overlay_color' => 'black',
		'overlay_custom_color' => '#000000',
		'overlay_opacity' => '',
		'overlay_tag' => 'div',
	) ) );

	$overlay_opacity = ( $overlay_opacity ) ? absint( $overlay_opacity ) / 100 : .4;

	$overlay_style = '';
	$class = 'wvc-bg-overlay';

	if ( ( 'custom' === $overlay_color || 'auto' === $overlay_color ) && $overlay_custom_color ) {

		$overlay_style .= 'background-color:' . wvc_sanitize_color( $overlay_custom_color ) . ';';

	} else {
		$class .= " wvc-background-color-$overlay_color"; // color class
	}

	$overlay_style .= "opacity:$overlay_opacity;";

	return '<' . $overlay_tag .' style="' . wvc_esc_style_attr( $overlay_style ) . '" class="' . wvc_sanitize_html_classes( $class ) . '"></' . $overlay_tag .'><!--.wvc-bg-overlay-->';
}

/**
 * Display image background
 *
 * @param array $args
 * @return string $output
 */
function wvc_background_img( $args = array() ) {

	extract( wp_parse_args( $args, array(
		'background_img' => get_post_thumbnail_id(),
		'background_color' => '',
		'background_position' => 'center center',
		'background_repeat' => 'no-repeat',
		'background_size' => 'cover',
		'background_effect' => '',
		'background_img_size' => 'wvc-XL',
		'background_img_lazyload' => apply_filters( 'wvc_bg_img_lazyload', true ),
		'background_img_preloader' => apply_filters( 'wvc_bg_img_preloader', false ),
	) ) );

	$output = '';

	if ( 'none' !== $background_effect ) {
		$background_repeat = 'no-repeat';
		$background_size = 'cover';
	}
	$do_object_fit = ( $background_img && 'no-repeat' === $background_repeat && 'default' !== $background_size && 'parallax' !== $background_effect && 'fixed' !== $background_effect && ! wvc_is_edge() && ! wp_is_mobile() && $background_img_lazyload );

	$do_object_fit = apply_filters( 'wvc_bg_objectfit', $do_object_fit, $args );

	$do_parallax = apply_filters( 'wvc_bg_parallax', ( 'parallax' === $background_effect && $background_img ) );

	if ( $do_object_fit || 'marquee' === $background_effect ) {

		$position = array(
			'center center' => '50% 50%',
			'center top' => '50% 0',
			'left top' => '0 0',
			'right top' => '100% 0',
			'center bottom' => '50% 100%',
			'left bottom' => '0 100%',
			'right bottom' => '100% 100%',
			'left center' => '50% 0',
			'right center' => '100% 50%',
		);

		$src = wvc_get_url_from_attachment_id( $background_img, $background_img_size );
		$srcset = wp_get_attachment_image_srcset( $background_img,$background_img_size );
		$alt = get_post_meta( $background_img, '_wp_attachment_image_alt', true);
		$blank = WVC_URI . '/assets/img/blank.gif';
		$img_dominant_color = wvc_get_image_dominant_color( $background_img );

		$original_src = ( $background_img_lazyload ) ? $blank : $src;

		$cover_class = "wvc-img-$background_size wvc-img-cover";

		$container_class = 'wvc-img-bg';
		$container_style = '';

		if ( $background_img_lazyload ) {
			$cover_class .= ' wvc-lazy-hidden wvc-lazyload-bg';
		}

		if ( $background_img_preloader ) {
			$container_class .= ' wvc-preloader-bg';
		}

		$cover_style = 'object-position:' . $position[ $background_position ] . ';';

		if ( 'zoomin' === $background_effect ) {
			$cover_class .= ' wvc-zoomin';
		}

		if ( $background_color ) {
			$background_color = wvc_sanitize_color( $background_color );
			$container_style .= "background-color:$background_color;";

		} elseif ( $img_dominant_color ) {

			$background_color = wvc_sanitize_color( $img_dominant_color );
			$container_style .= "background-color:$img_dominant_color;";
		}

		$output .= '<div class="' . wvc_sanitize_html_classes( $container_class ) . '" style="' . wvc_esc_style_attr( $container_style ) . '">';

		$bg_img_meta = wp_get_attachment_metadata( $background_img );
		$bg_img_width = ( isset( $bg_img_meta['width'] ) ) ? $bg_img_meta['width'] . 'px' : '1500px';

		if ( wp_attachment_is_image( $background_img ) ) {

			if ( 'marquee' === $background_effect ) {
				$cover_class = '';
			}

			$output .= '<img
				src="' . esc_url( $original_src ) . '"
				style="' . wvc_esc_style_attr( $cover_style ) . '"
				data-src="' . esc_url( $src ) .'"';
				
			if ( $srcset ) {
				$output .= ' srcset="' . esc_attr( $srcset ) . '"';
			}

			$output .= ' class="' . wvc_sanitize_html_classes( $cover_class ) . '"
				sizes="(max-width: ' . esc_attr( $bg_img_width ) . ') 100vw, ' . esc_attr( $bg_img_width ) . '"
				alt="' . esc_attr( $alt ) .'">';

			if ( 'marquee' === $background_effect ) {
				$output .= '<img
				src="' . esc_url( $original_src ) . '"
				style="' . wvc_esc_style_attr( $cover_style ) . '"
				data-src="' . esc_url( $src ) .'"
				srcset="' . esc_attr( $srcset ) . '"
				class="' . wvc_sanitize_html_classes( $cover_class ) . ' wvc-img-bg-marquee-aux"
				sizes="(max-width: ' . esc_attr( $bg_img_width ) . ') 100vw, ' . esc_attr( $bg_img_width ) . '"
				alt="' . esc_attr( $alt ) .'">';
			}

		} else {
			$output .= wvc_placeholder_img( 'wvc-XL', $cover_class );
		}

		$output .= '<div class="wvc-img-bg-overlay"></div></div>';

	} elseif ( $background_img || $background_color ) {

		$style = $attrs = '';
		$container_class = 'wvc-img-bg';

		if ( $do_parallax ) {

			wp_enqueue_script( 'jarallax' );

			$container_class .= ' wvc-parallax';

			$background_color = wvc_get_image_dominant_color( $background_img );

			if ( $background_color ) {
				$style .= 'background-color:' . wvc_sanitize_color( $background_color ) . ';';
			}

			$src = wvc_get_url_from_attachment_id( $background_img, $background_img_size );
			$srcset = wp_get_attachment_image_srcset( $background_img, $background_img_size );
			$attrs = ' data-image-src="' . $src . '"';
			$attrs .= ' data-image-srcset="' . $srcset . '"';
			$attrs .= ' data-speed="0.5"';

			$style .= 'background-image:url(' . esc_url( $src ) . ');';
			$bg_meta = wp_get_attachment_metadata( $background_img );

			if ( is_array( $bg_meta ) && isset( $bg_meta['width'] ) ) {
				$attrs .= ' data-image-width="' . $bg_meta['width'] . '"';
			}

			if ( is_array( $bg_meta ) && isset( $bg_meta['height'] ) ) {
				$attrs .= ' data-image-height="' . $bg_meta['height'] . '"';
			}
		}

		if ( ! $do_parallax ) {

			if ( 'zoomin' === $background_effect ) {
			}

			$img_dominant_color = wvc_get_image_dominant_color( $background_img );

			if ( $background_color && 'default' !== $background_color ) {
				
				$style .= 'background-color:' . esc_attr( $background_color ) . ';';

			} elseif ( wp_attachment_is_image( $background_img ) && ( 'cover' === $background_size || 'contain' === $background_size ) ) {

				$img_dominant_color = wvc_get_image_dominant_color( $background_img );

				$style .= 'background-color:' . esc_attr( $img_dominant_color ) . ';';
			}

			if ( $background_position )
				$style .= 'background-position:' . esc_attr( $background_position ) . ';';

			if ( $background_repeat ) {
				$style .= 'background-repeat:' . esc_attr( $background_repeat ) . ';';
			}

			if ( $background_size && 'default' !== $background_size ) {
				$style .= 'background-size:' . esc_attr( $background_size ) . ';';
			}

			if ( 'fixed' === $background_effect ) {
				$style .= 'background-attachment:fixed;';
			}

			if ( $background_img ) {
				$background_img_url = wvc_get_url_from_attachment_id( $background_img, $background_img_size );

				$style .= 'background-image:url(' . esc_url( $background_img_url ) . ');';
			}
		}

		$output .= '<div ' . $attrs . ' class="' . wvc_sanitize_html_classes( $container_class ) . '" style="' . esc_attr( $style ) . '"></div>';
	}

	return $output;
}

/**
 * Display slideshow background
 *
 * @param array $args
 * @return string $output
 */
function wvc_background_slideshow( $args ) {

	extract( wp_parse_args( $args, array(
		'slideshow_image_size' => 'wvc-XL',
		'slideshow_img_ids' => '',
		'slideshow_speed' => 4000,
	) ) );

	wp_enqueue_style( 'flexslider' );
	wp_enqueue_script( 'flexslider' );
	wp_enqueue_script( 'wvc-sliders' );

	$output = '';

	$image_ids = wvc_list_to_array( $slideshow_img_ids );

	$do_object_fit = ( ! wvc_is_edge() && ! wp_is_mobile() );

	if ( array() != $image_ids ) {

		wp_enqueue_script( 'flexslider' );
		wp_enqueue_script( 'wvc-sliders' );

		$output .= '<div data-slideshow-speed="' . absint( $slideshow_speed ) . '" class="wvc-section-slideshow-background"><ul class="slides">';

		foreach ( $image_ids as $image_id ) {
			
			$src = esc_url( wvc_get_url_from_attachment_id( $image_id, $slideshow_image_size ) );

			$output .= '<li>';

			if ( $do_object_fit && wp_attachment_is_image( $image_id ) ) {

				$output .= wp_get_attachment_image( $image_id, $slideshow_image_size, false, array( 'class' => 'wvc-img-cover' ) );

			} else {

				$output .= '<div style="position:absolute;top:0;left:0;right:0;bottom:0;width:100%;height:100%;background:url(' . $src . ') center center;background-size:cover;"></div>';
			}
			

			$output .= '</li>';
		}

		$output .= '</ul></div>';
	}

	return $output;
}

/**
 * Display video background
 *
 * @param array $args
 * @return string $output
 */
function wvc_background_video( $args ) {

	$args = wp_parse_args( $args, array(
		'video_bg_url' => '',
		'video_bg_img' => '',
		'video_bg_controls' => '',
		'video_bg_img_size' => 'wvc-XL',
		'video_bg_start_time' => 0,
		'video_bg_end_time' => 0,
		'video_bg_loop' => true,
		'video_bg_parallax' => '',
		'video_bg_pause_on_start' => false,
		'video_bg_unmute' => false,
	) );

	$output = '';

	$args['video_bg_loop'] = wvc_shortcode_bool( $args['video_bg_loop'] );

	if ( '' !== $args['video_bg_parallax'] ) {

		$output .= wvc_parallax_video_bg( $args );

	} else {

		if ( 'selfhosted' === wvc_get_video_url_type( $args['video_bg_url'] ) ) {

			$output .= wvc_video_bg( $args );

		} elseif ( 'youtube' === wvc_get_video_url_type( $args['video_bg_url'] ) ) {

			$output .= wvc_youtube_video_bg( $args );

		} elseif ( 'vimeo' === wvc_get_video_url_type( $args['video_bg_url'] ) ) {

			$output .= wvc_vimeo_video_bg( $args );
		}
	}

	return $output;
}

/**
 * Display a parallax video background
 *
 * Use jarallax script to output the parallax video background
 *
 * @param array $args
 * @return string $output
 */
function wvc_parallax_video_bg( $args ) {
	
	extract( wp_parse_args( $args, array(
		'video_bg_url' => '',
		'video_bg_img' => '',
		'video_bg_img_mobile' => '',
		'video_bg_img_size' => 'wvc-XL',
		'video_bg_start_time' => 0,
		'video_bg_end_time' => 0,
		'video_bg_loop' => true,
		'video_bg_unmute' => false,
	) ) );

	wp_enqueue_script( 'jarallax' );
	wp_enqueue_script( 'jarallax-video' );

	$output = $data_start_time = $data_end_time = '';

	/**
	 *	@todo debug start and endtime
	 */
	$video_bg_start_time = esc_attr( $video_bg_start_time );
	$video_bg_end_time = esc_attr( $video_bg_end_time );

	if ( $video_bg_start_time ) {
		$data_start_time .= 'data-video-start-time="' .  absint( $video_bg_start_time ) . '"';
	}

	if ( $video_bg_end_time ) {
		$data_end_time .= 'data-video-end-time="' .  absint( $video_bg_end_time ) . '"';
	}

	if ( strpos( $video_bg_url, 'mp4' ) ) {
		$video_bg_url = 'mp4:' . $video_bg_url;
	} else {
		$video_bg_url = esc_url( $video_bg_url );
	}

	$output .= '<div class="wvc-video-parallax" data-jarallax-video="' . esc_attr( $video_bg_url ) . '" ' . $data_start_time . ' ' . $data_end_time . '>';
	$output .= wvc_video_bg_img_fallback( $args );

	$output .= '</div><!-- .wvc-video-parallax -->';


	return $output;
}

/**
 * Display a self hosted video background
 *
 * Output a basic HTML5 video markup to use as video background
 *
 * @param array $args
 * @return string $output
 */
function wvc_video_bg( $args ) {

	extract( wp_parse_args( $args, array(
		'video_bg_url' => '',
		'video_bg_webm' => '',
		'video_bg_ogv' => '',
		'video_bg_img' => '',
		'video_bg_img_mobile' => '',
		'video_bg_controls' => '',
		'video_bg_img_size' => 'wvc-XL',
		'video_bg_pause_on_start' => false,
		'video_bg_unmute' => false,
	) ) );

	$rand = rand( 0, 9999 );
	$output = $inline_style = '';
	$class = 'wvc-video-bg-container';

	/* Set default background color for image dominant color */
	if ( wp_attachment_is_image( $video_bg_img ) ) {
		$image_dominant_color = wvc_get_image_dominant_color( $video_bg_img );

		if ( $image_dominant_color ) {
			$inline_style .= 'background-color:' . wvc_sanitize_color( $image_dominant_color )  . '';
		}
	}
	$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '">';

	$output .= wvc_video_bg_img_fallback( $args );

	$autoplay_attr = ( $video_bg_pause_on_start ) ? '' : 'autoplay';

	$muted = ( $video_bg_unmute ) ? '' : 'muted';

	$output .= '<video class="wvc-video-bg" id="wvc-video-bg-' . absint( $rand ) . '"
	preload="auto" ' . $autoplay_attr  .' loop="loop" ' . $muted . '>';

	if ( $video_bg_webm ) {
		$output .= '<source src="' . esc_url( $video_bg_webm ) . '" type="video/webm">';
	}

	if ( $video_bg_url ) {
		$output .= '<source src="' . esc_url( $video_bg_url ) . '" type="video/mp4">';
	}

	if ( $video_bg_ogv ) {
		$output .= '<source src="' . esc_url( $video_bg_ogv ) . '" type="video/ogg">';
	}

	$output .= '</video>';
	$output .= '<div class="wvc-video-bg-overlay"></div>';
	/*
		Video controls will go here
	*/
	$output .= '</div>';

	return $output;
}

/**
 * Display a YouTube video background
 *
 * @param array $args
 * @return string $output
 */
function wvc_youtube_video_bg( $args ) {

	extract( wp_parse_args( $args, array(
		'video_bg_url' => '',
		'video_bg_start_time' => '',
		'video_bg_end_time' => '',
		'video_bg_img' => '',
		'video_bg_img_mobile' => '',
		'video_bg_img_size' => 'wvc-XL',
		'video_bg_loop' => true,
		'video_bg_pause_on_start' => false,
		'video_bg_unmute' => false,
	) ) );

	wp_enqueue_script( 'wvc-youtube-video-bg' );

	$output = $style = '';
	$class = 'wvc-video-bg-container wvc-youtube-video-bg-container';
	$video_bg_url = esc_url( $video_bg_url );
	$video_bg_start_time = absint( $video_bg_start_time );
	$random_id = rand( 1, 9999 );

	if (
		preg_match( '#youtube(?:\-nocookie)?\.com/watch\?v=([A-Za-z0-9\-_]+)#', $video_bg_url, $match )
		|| preg_match( '#youtube(?:\-nocookie)?\.com/v/([A-Za-z0-9\-_]+)#', $video_bg_url, $match )
		|| preg_match( '#youtube(?:\-nocookie)?\.com/embed/([A-Za-z0-9\-_]+)#', $video_bg_url, $match )
		|| preg_match( '#youtu.be/([A-Za-z0-9\-_]+)#', $video_bg_url, $match )
	) {

		if ( $match && isset( $match[1] ) ) {

			$youtube_id = $match[1];
			$embed_url = 'https://youtube.com/embed/' . $youtube_id;

			$output .= "<div data-yt-bg-element-id='$random_id' class='$class' data-youtube-start-time='$video_bg_start_time' data-youtube-end-time='$video_bg_end_time' data-youtube-pause-on-start='$video_bg_pause_on_start' data-youtube-loop='$video_bg_loop' data-youtube-unmute='$video_bg_unmute' id='wvc-youtube-video-bg-$random_id-container' data-youtube-id='$youtube_id'>" . "\n";
			$output .= wvc_video_bg_img_fallback( $args );

			$output .= "<div class='wvc-youtube-player wvc-youtube-bg' id='wvc-youtube-player-$random_id'></div>" . "\n";

			$output .= '<div class="wvc-video-bg-overlay"></div>';

			$output .= "<span class='wvc-yt-video-bg-play' id='wvc-yt-video-bg-play-$random_id'></span>"; // play
			$output .= "<span class='wvc-yt-video-bg-pause' id='wvc-yt-video-bg-pause-$random_id'></span>"; // pause

			$output .= '</div><!-- .wvc-youtube-video-bg -->' . "\n";
		}
	}
	return $output;
}

/**
 * Display a vimeo video background
 *
 * Output vimeo video background markup
 *
 * @param array $args
 * @return string $output
 */
function wvc_vimeo_video_bg( $args ) {

	extract( wp_parse_args( $args, array(
		'video_bg_url' => '',
		'video_bg_start_time' => '',
		'video_bg_end_time' => '',
		'video_bg_img' => '',
		'video_bg_img_mobile' => '',
		'video_bg_img_size' => 'wvc-XL',
		'video_bg_loop' => true,
		'video_bg_unmute' => false,
	) ) );

	wp_enqueue_script( 'froogaloop' ); // soon deprecated
	wp_enqueue_script( 'vimeo-player' );
	wp_enqueue_script( 'wvc-vimeo' );

	$output = $style = '';
	$class = 'wvc-video-bg-container wvc-vimeo-video-bg-container';
	$video_bg_url = esc_url( $video_bg_url );
	$start_time = ( $video_bg_start_time ) ? '#tp=' . $video_bg_start_time : '';

	if (
		preg_match( '#vimeo\.com/([0-9a-z\#=]+)#', $video_bg_url, $match )
	) {

		if ( $match && isset( $match[1] ) ) {

			$vimeo_id = $match[1];
			$embed_url = 'https://player.vimeo.com/' . $vimeo_id;

			$output .= '<div class="wvc-vimeo-video-bg-container wvc-video-bg-container">';
			$output .= wvc_video_bg_img_fallback( $args );

			$rand = rand( 0, 9999 );
			$player_id = 'wvc-vimeo-iframe-' . $rand;
			$output .= '<iframe data-vimeo-bg-element-id="' . esc_attr( $rand ) . '" id="' . esc_attr( $player_id ) . '" class="wvc-vimeo-bg" src="https://player.vimeo.com/video/' . esc_attr( $vimeo_id ) . '?autoplay=1&loop=1&byline=0&title=0&api=1&background=1' . esc_attr( $start_time ) . '&player_id=' . $player_id . '"></iframe>';
			
			$output .= '<div class="wvc-video-bg-overlay"></div>';
			$output .= '</div><!--.wvc-video-bg-container-->';
		}
	}
	return $output;
}

/**
 * Video background image fallback
 *
 * @param array $args
 * @return string $image
 */
function wvc_video_bg_img_fallback( $args ) {
	
	extract( wp_parse_args( $args, array(
		'video_bg_img_size' => 'wvc-XL',
		'video_bg_img' => '',
		'video_bg_img_mobile' => '',
	) ) );

	$image = '';
	$is_mobile = wp_is_mobile();

	if ( $is_mobile && wp_get_attachment_image( $video_bg_img_mobile ) ) {

		$image = wp_get_attachment_image( $video_bg_img_mobile, $video_bg_img_size, false, array( 'class' => 'wvc-img-cover wvc-video-bg-fallback wvc-video-bg-fallback-mobile' ) );

	} else if ( $video_bg_img ) {
		$image = wp_get_attachment_image( $video_bg_img, $video_bg_img_size, false, array( 'class' => 'wvc-img-cover wvc-video-bg-fallback' ) );
	}

	return $image;
}

/**
 * Display shape divider
 *
 * @param array $args
 * @return string $output
 */
function wvc_shape_divider( $args ) {

	extract( wp_parse_args( $args, array(
		'sd_position' => '',
		'sd_type' => '',
		'sd_shape' => '',
		'sd_img' => '',
		'sd_custom_svg' => '',
		'sd_flip' => '',
		'sd_inverted' => '',
		'sd_height' => '25%',
		'sd_color' => '',
		'sd_custom_color' => '',
		'sd_opacity' => '',
		'sd_ratio' => '',
		'sd_zindex' => '',
		'sd_responsive' => 'yes',
	) ) );

	if ( $sd_type === 'disabled' ) {
		return;
	}

	$output = $inline_style = '';
	$classes = "wvc-shape-divider wvc-sd-position-$sd_position wvc-sd-type-$sd_type";

	if ( 'yes' === $sd_flip ) {
		$classes .= ' wvc-sd-flip';
	}

	if ( 'yes' === $sd_inverted ) {
		$classes .= ' wvc-sd-invert';
	}

	if ( 'yes' === $sd_ratio ) {
		$classes .= ' wvc-sd-preserve-ratio';
	}

	if ( $sd_type === 'image' ) {
		$src = wvc_get_url_from_attachment_id( $sd_img, 'wvc-XL' );
		$inline_style .= 'background-image:url(' . esc_url( $src ) . ');';
	}

	if ( $sd_height ) {
		$inline_style .= 'height:' . wvc_sanitize_css_value( $sd_height, '%' ) . ';';
	}

	if ( $sd_opacity ) {
		$sd_opacity = ( $sd_opacity ) ? absint( $sd_opacity ) / 100 : 1;
		$inline_style .= 'opacity:' . $sd_opacity . ';';
	}

	if ( $sd_zindex ) {
		$inline_style .= 'z-index:' .absint( $sd_zindex ) . ';';
	}

	$colors = wvc_get_shared_colors_hex();
	$color = '';
	
	if ( 'custom' === $sd_color ) {
		
		$color = $sd_custom_color;
	
	} else {
		$color = isset( $colors[ $sd_color ] ) ? $colors[ $sd_color ] : '';
	}

	if ( ! $color ) {
		$color = $colors['grey'];
	}

	$color = wvc_sanitize_color( $color );

	$output .= '<div class="' . wvc_sanitize_html_classes( $classes ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '">';

	/*
	curve, curve opacity
	curve asymetric, curve asym opacity
	book,
	spear
	arrow,
	triangle
	pyramids
	tilt,
	tilt opacity
	waves
	waves opacity
	hills hill op
	paper
	paint
	*/

	if ( $sd_type === 'default' && $sd_shape ) {
		ob_start();

		if ( 'tilt' === $sd_shape ) : ?>
<svg version="1.1" class="wvc-row-divider wvc-row-divider-tilt" viewBox="0 0 240 24" enable-background="new 0 0 240 24" xml:space="preserve" preserveAspectRatio="none"> <path fill="<?php echo esc_attr( $color ); ?>" d="M240,24V0L0,24H240z"></path> </svg>
		
		<?php elseif ( 'tilt_opacity' === $sd_shape ) : ?>
			<svg version="1.1" class="wvc-row-divider wvc-row-divider-tilt-opacity" x="0px" y="0px" width="240px" height="24px" viewBox="0 0 240 24" enable-background="new 0 0 240 24" xml:space="preserve" preserveAspectRatio="none">
				<path fill="<?php echo esc_attr( $color ); ?>" fill-opacity="0.33" d="M240,24V0L0,24H240z"></path>
				<path fill="<?php echo esc_attr( $color ); ?>" d="M240,24V3.72L0,24H240z"></path>
				<path fill="<?php echo esc_attr( $color ); ?>" fill-opacity="0.33" d="M240,24V1.99L0,24H240z"></path></svg>
		<?php elseif ( 'waves' === $sd_shape ) : ?>
		
		
		<?php elseif ( 'triangle' === $sd_shape ) : ?>
		

		<?php elseif( 'curve' === $sd_shape ) : ?>
		<svg version="1.1" class="wvc-row-divider wvc-row-divider-curve" x="0px" y="0px" width="240px" height="24px" viewBox="0 0 240 24" enable-background="new 0 0 240 24" xml:space="preserve" preserveAspectRatio="none"> <path fill="<?php echo esc_attr( $color ); ?>" d="M119.849,0C47.861,0,0,24,0,24h240C240,24,191.855,0.021,119.849,0z"></path> </svg>

<?php elseif( 'curve_opacity' === $sd_shape ) : ?>
		<svg version="1.2" baseProfile="tiny" id="Calque_1"
	 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="338px" height="57.665px"
	 viewBox="0 0 338 57.665" xml:space="preserve" preserveAspectRatio="none">
<ellipse fill="<?php echo esc_attr( $color ); ?>" cx="168.833" cy="90" rx="185.833" ry="82.666"/>
	<ellipse fill="<?php echo esc_attr( $color ); ?>"  fill-opacity="0.33" cx="168.833" cy="86" rx="185.833" ry="82.666"/>
		<ellipse fill="<?php echo esc_attr( $color ); ?>"  fill-opacity="0.33" cx="168.833" cy="82" rx="185.833" ry="82.666"/>
</svg>
		<?php elseif( 'paint' === $sd_shape ) : ?>

		<?php elseif( 'grunge_border1' === $sd_shape ) : ?>
			<?php include( 'dividers/grunge_border1.php' ); ?>
		<?php endif;
		$shape= ob_get_clean();

		$output .= apply_filters( 'wvc_shape_divider', $shape, $args );
	}

	$output .= '</div>';

	return $output;
}