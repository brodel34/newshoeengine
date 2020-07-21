<?php
/**
 * Last posts shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'include_ids' => '',
	'exclude_ids' => '',
	'count' => 4,
	'columns' => 4,
	'padding' => 'yes',
	'display' => 'standard',
	'category' => '',
	'tag' => '',
	'autoplay' => 'yes',
	'transition' => 'auto',
	'slideshow_speed' => 4000,
	'pause_on_hover' => 'yes',
	'nav_bullets' => 'yes',
	'nav_arrows' => 'yes',
	'hide_category' => '',
	'hide_tag' => '',
	'hide_date' => '',
	'hide_author' => '',
	'hide_cover' => '',
	'hide_summary' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'el_id' => '',
	'inline_style' => '',
), $atts ) );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

$type = 'grid';

$class .= "wvc-last-posts wvc-last-posts-$type wvc-last-posts-padding-$padding wvc-last-posts-display-$display wvc-element";

$no_column_types = apply_filters( 'wvc_posts_display_types_without_columns', array(
	'preview',
	'slider',
	'carousel',
) );

if ( ! in_array( $type, $no_column_types ) ) {
	$class .= ' wvc-last-posts-columns-' . absint( $columns );
}

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

if ( $hide_cover ) {
	$class .= ' wvc-hide-cover';
}

if ( $hide_summary ) {
	$class .= ' wvc-hide-summary';
}

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$output .= '<section';

if ( $el_id ) {
	$output .= ' id="' . esc_attr( $el_id ) . '"';
}

$output .= ' class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

if ( 'slider' === $type ) {
	$slider_data = "data-pause-on-hover='$autoplay'
	data-autoplay='$autoplay'
	data-transition='$transition'
	data-slideshow-speed='$slideshow_speed'
	data-nav-arrows='$nav_arrows'
	data-nav-bullets='$nav_bullets'";
	$output .= "<div $slider_data class='flexslider'><ul class='slides'>";
}

ob_start();

$args = array(
	'post_type' => array( 'post' ),
	'posts_per_page' => absint( $count ),
	'ignore_sticky_posts' => 1,
);

if ( $include_ids ) {
	$args['post__in'] = wvc_list_to_array( $include_ids );
}

if ( $exclude_ids ) {
	$args['post__not_in'] = wvc_list_to_array( $exclude_ids );
}

if ( $category ) {
		$args['category_name'] = wvc_clean_list( $category );
	}

	if ( $tag ) {
		$args['tag'] = wvc_clean_list( $tag );
	}

$css_animation_class = '';
if ( $css_animation ) {
	$css_animation_class .= "wow $css_animation";
}

$last_post_loop = new WP_Query( $args );

if ( $last_post_loop->have_posts() ) :
	while ( $last_post_loop->have_posts() ) : $last_post_loop->the_post();
		if ( 'preview' === $type ) {
			echo "<div class='$css_animation_class'>";
		}

		wvc_get_template_part( 'post/content', $type );

		if ( 'preview' === $type ) {
			echo '</div>';
		}
	endwhile;
else :
	echo '<p class="wvc-text-center">';
	esc_html_e( 'No post found.', 'wolf-visual-composer' );
	echo '</p>';

endif;
wp_reset_postdata();
$output .= ob_get_clean();

if ( 'slider' === $type ) {
	$output .= '</ul></div><!--.flexslider-->';
}

$output .= '</section><!--.wvc-last-posts-' . $type . '-->';

echo $output;