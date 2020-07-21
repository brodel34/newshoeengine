<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
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
 * @version     3.3.0
 */
$class = 'products grid items grid-padding-yes clearfix';

if ( is_product() ) { // related products on single product page

	if ( prequelle_get_theme_mod( 'related_products_carousel' ) ) {
		wp_enqueue_script( 'flickity' );
		wp_enqueue_script( 'prequelle-carousel' );
	
		$class .= ' module-carousel product-module-carousel';
	}
}
?>
<div class="clear"></div>
<div id="shop-index" class="<?php echo prequelle_sanitize_html_classes( $class ); ?>">
