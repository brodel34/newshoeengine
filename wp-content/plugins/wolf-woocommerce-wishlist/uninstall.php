<?php
/**
 * Wolf WooCommerce Wishlist Uninstall
 *
 * Uninstalling Wolf WooCommerce Wishlist
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWooCommerceWishlist/Uninstaller
 * @version 1.0.0
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( '_wolf_woocommerce_wishlist_page_id' );