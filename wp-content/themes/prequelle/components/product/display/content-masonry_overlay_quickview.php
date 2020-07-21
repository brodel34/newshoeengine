<?php
/**
 * The product content displayed in the loop for the "grid overlay" display
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
$classes = array();

/* Related product default class */
if ( is_singular( 'product' ) ) {
	$classes = array( 'entry-product-masonry_overlay_quickview', 'entry-columns-default' );
} else {
	$columns = prequelle_get_theme_mod( 'product_columns', 'default' );
	$classes = array( $columns );
}

$thumbnail_size = apply_filters( 'prequelle_product_masonry_thumbnail_size', ( prequelle_is_gif( get_post_thumbnail_id() ) ) ? 'full' : 'prequelle-masonry' );
?>
<article <?php prequelle_post_attr( $classes ); ?>>
	<div class="product-thumbnail-container">
		<div class="product-thumbnail-inner">
			<?php do_action( 'prequelle_product_minimal_player' ); ?>
			<?php woocommerce_show_product_loop_sale_flash(); ?>
			
			<?php echo woocommerce_get_product_thumbnail( $thumbnail_size ); ?>
			<?php prequelle_woocommerce_second_product_thumbnail( $thumbnail_size ); ?>

			<div class="product-overlay">
				<a class="entry-link-mask" href="<?php the_permalink(); ?>"></a>
				<div class="product-overlay-table">
					<div class="product-overlay-table-cell">
						<div class="product-actions">
							<?php
								/**
								 * Quickview button
								 */
								do_action( 'prequelle_product_quickview_button' );
							?>
							
							<?php
								/**
								 * Add to cart button
								 */
								do_action( 'prequelle_product_add_to_cart_button' );
							?>
						</div><!-- .product-actions -->
					</div><!-- .product-overlay-table-cell -->
				</div><!-- .product-overlay-table -->
			</div><!-- .product-overlay -->
		</div><!-- .product-thumbnail-inner -->
	</div><!-- .product-thumbnail-container -->

	<div class="product-summary clearfix">
		<?php woocommerce_template_loop_product_link_open(); ?>
			<?php woocommerce_template_loop_product_title(); ?>
			<?php woocommerce_template_loop_price(); ?>
            <?php
								/**
								 * Wishlist button
								 */
								do_action( 'prequelle_add_to_wishlist_button' );
							?>
		<?php woocommerce_template_loop_product_link_close(); ?>
	</div><!-- .product-summary -->
</article><!-- #post-## -->