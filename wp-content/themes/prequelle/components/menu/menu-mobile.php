<?php
/**
 * The main navigation for mobile
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( prequelle_do_onepage_menu() ) {

	echo prequelle_one_page_menu( 'mobile' );

} else 

{echo do_shortcode('[woocommerce_product_filter_attribute]');
	

	if ( has_nav_menu( 'mobile' ) ) {

		wp_nav_menu( prequelle_get_menu_args( 'mobile', 'mobile' ) );

	} else {
		wp_nav_menu( prequelle_get_menu_args( 'primary', 'mobile' ) );
	}
}