<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */
if (!defined('ABSPATH')) {
    exit;
}
global $product;

// compatibility with WC +3
$product_id = method_exists($product, 'get_id') ? $product->get_id() : $product->id;
$Related_Poduct_Category = get_post_meta($product_id, '_Related_Poduct_Category', true);
//print_R($Related_Poduct_Category);
$args = array(
    'post__not_in' => array(get_the_ID()),
    'post_type' => 'product',
    'post_status' => 'publish',
    'ignore_sticky_posts' => 1,
    'posts_per_page' => '24',
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id', //This is optional, as it defaults to 'term_id'
            'terms' => $Related_Poduct_Category,
            'operator' => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
        ),
        array(
            'taxonomy' => 'product_visibility',
            'field' => 'slug',
            'terms' => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
            'operator' => 'NOT IN'
        ),
    )
);
$products = new WP_Query($args);
$new_related_products = $products->posts;
if (count($new_related_products) > 0) {
    if ($new_related_products) :
        ?>

        <section class="related-products">

            <h2><?php esc_html_e('Recommended', 'prequelle'); ?></h2>

            <?php woocommerce_product_loop_start(); ?>

            <?php foreach ($new_related_products as $related_product) : ?>

                <?php
                $post_object = get_post($related_product->ID);

                setup_postdata($GLOBALS['post'] = & $post_object);

                wc_get_template_part('content', 'product');
                ?>

            <?php endforeach; ?>

            <?php woocommerce_product_loop_end(); ?>

        </section>

        <?php
    endif;
}
else {
    echo '<section class="related-products">
</section>';
}
wp_reset_postdata();
