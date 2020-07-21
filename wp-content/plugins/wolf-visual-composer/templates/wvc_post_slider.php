<?php
/**
 * Last posts big slider shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'ids' => '',
	'exclude_ids' => '',
	'count' => 3,
	'category' => '',
	'tag' => '',
	'autoplay' => 'yes',
	'transition' => 'auto',
	'slideshow_speed' => 4000,
	'pause_on_hover' => 'yes',
	'nav_bullets' => 'yes',
	'nav_arrows' => 'yes',
	'nav_tone' => 'light',
	'animation' => '',
	'animation_delay' => '',
	'inline_style' => '',
	'extra_class' => '',
	'anchor' => '',
	'hide_category' => '',
	'hide_tag' => '',
	'hide_date' => '',
	'hide_author' => '',
	'slider_height' => '100%',
	'responsive' => '',
	'font_family' => '',
	'font_weight' => '',
	'font_size' => '',
	'text_transform' => '',
	'letter_spacing' => '',
	'ignore_sticky_posts' => '',
	'offset' => '',
	'post_type' => 'post',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_style( 'linea-icons' );

wp_enqueue_style( 'flexslider' );
wp_enqueue_script( 'flexslider' );
wp_enqueue_script( 'fittext' );
wp_enqueue_script( 'wvc-advanced-slider' );
wp_enqueue_script( 'wvc-fittext' );
wp_enqueue_script( 'wvc-sliders' );

$post_type = ( post_type_exists( $post_type ) ) ? esc_attr( $post_type ) : 'post';

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$slider_height_unit = '%';

// percent
if ( '%' === substr( $slider_height, -1 ) ) {
	$slider_height_unit = '%';

	if ( 100 < absint( $slider_height ) ) {
		$slider_height = 100;
	}
// em
} elseif ( 'em' === substr( $slider_height, -2 ) ) {
	$slider_height_unit = 'em';

//px
} elseif ( 'px' === substr( $slider_height, -2 ) ) {
	$slider_height_unit = 'px';
}

$slider_height = absint( $slider_height );

$class .= " wvc-last-posts wvc-last-posts-big-slider wvc-slider-nav-font-tone-$nav_tone wvc-element";

if ( $hide_category ) {
	$class .= ' wvc-hide-category';
}

if ( $hide_tag ) {
	$class .= ' wvc-hide-tag';
}

if ( $hide_date ) {
	$class .= ' wvc-hide-date';
}

if ( $hide_author ) {
	$class .= ' wvc-hide-author';
}

$output .= '<section';

if ( $anchor ) {
	$output .= ' id="' . esc_attr( $anchor ) . '"';
}

$output .= ' class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

$rand = rand( 0, 9999 );

$slider_id = "wvc-last-posts-big-slider-$rand";

$slider_data = "data-pause-on-hover='$autoplay'
	data-autoplay='$autoplay'
	data-transition='$transition'
	data-slideshow-speed='$slideshow_speed'
	data-nav-arrows='$nav_arrows'
	data-nav-bullets='$nav_bullets'
	data-height='$slider_height'
	data-height-unit='$slider_height_unit'";
	$output .= "<div $slider_data class='flexslider' id='$slider_id'><ul class='slides'>";

	$args = array(
		'post_type' => array( $post_type ),
		'posts_per_page' => absint( $count ),
		'meta_query' => array(
			array(
				'key' => '_thumbnail_id',
				'compare' => '!=',
				'value' => 'NULL'
			),
		),
	);

	if ( $ignore_sticky_posts ) {
		$args['ignore_sticky_posts'] = 1;
	}

	if ( $ids ) {
		$args['post__in'] = wvc_list_to_array( $ids );
	}

	if ( $exclude_ids ) {
		$args['post__not_in'] = wvc_list_to_array( $exclude_ids );
	}

	if ( $category ) {
		$args['category_name'] = strtolower( str_replace( ' ', '', $category ) );
	}

	if ( $tag ) {
		$args['tag'] = strtolower( str_replace( ' ', '', $tag ) );
	}

	// Offset
	if ( $offset ) {
		$sticky_posts_count = count( get_option( 'sticky_posts' ) );
		$sticky_posts_count = ( $sticky_posts_count ) ? absint( $sticky_posts_count ) : 0;

		$offset = $offset + $sticky_posts_count;

		$args['offset'] = $offset;
		$args['ignore_sticky_posts'] = 1; // force ignoring sticky posts
	}

ob_start();

	$last_post_loop = new WP_Query( $args );

	if ( $last_post_loop->have_posts() ) :
		while ( $last_post_loop->have_posts() ) : $last_post_loop->the_post();

			/*
			 * Pass args to filter template. Cool stuff.
			 */
			set_query_var( 'wvc_post_slider_args', array(
				'responsive' => $responsive,
				'font_family' => $font_family,
				'font_weight' => $font_weight,
				'font_size' => $font_size,
				'text_transform' => $text_transform,
				'letter_spacing' => $letter_spacing,
			) );
			wvc_get_template_part( 'post/content', 'post-slider' );

		endwhile;
	else :
		echo '<p class="wvc-text-center">';

			esc_html_e( 'No post found.', 'wolf-visual-composer' );

			if ( is_user_logged_in() ) {
				echo '<br>';
				esc_html_e( 'Only posts with a featured image will be displayed.', 'wolf-visual-composer' );
			}
		echo '</p>';

	endif;
	wp_reset_postdata();
	$output .= ob_get_clean();


	$output .= '</ul></div><!-- .flexslider -->';

$output .= '</section><!-- .wvc-last-posts-big-slider -->';

echo $output;