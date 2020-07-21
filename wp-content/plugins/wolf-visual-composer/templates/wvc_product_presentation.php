<?php
/**
 * Product Presentation shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'product_id' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$output = '';

wp_enqueue_style( 'flexslider' );
wp_enqueue_script( 'flexslider' );
wp_enqueue_script( 'wvc-sliders' );

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );
	
if ( 'publish' !== get_post_status( $product_id ) || ! class_exists( 'WooCommerce' ) ) {
	return;
}

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$class .= " wvc-product-presentation woocommerce wvc-clearfix";

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';
$output .= wvc_element_aos_animation_data_attr( $atts );
$output .= '>';

add_filter( 'woocommerce_gallery_thumbnail_size', 'wvc_filter_image_size' );
add_filter( 'woocommerce_short_description', 'wvc_filter_product_description' );

/* Get post query */
$query = new WP_Query( array(
	'post__in' => array( $product_id ),
	'post_type' => 'product',
	'posts_per_page' => 1,
) );

while ( $query->have_posts() ) : $query->the_post();
	ob_start();
	wc_get_template( 'product-presentation.php', array(), '', WVC_DIR . '/views/' );
	$output .= ob_get_clean();
endwhile;
wp_reset_postdata();

remove_filter( 'woocommerce_gallery_thumbnail_size', 'wwcqv_filter_image_size' );
remove_filter( 'woocommerce_short_description', 'wwcqv_filter_product_description' );

$output .= '</div><!--.wvc-product-presentation-->';

echo $output;