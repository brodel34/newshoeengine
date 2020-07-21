<?php
/**
 * Prequelle shop
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function prequelle_set_product_mods( $mods ) {

	if ( class_exists( 'WooCommerce' ) ) {
		$mods['shop'] = array(
			'id' => 'shop',
			'title' => esc_html__( 'Shop', 'prequelle' ),
			'icon' => 'cart',
			'options' => array(

				'product_layout' => array(
					'id' => 'product_layout',
					'label' => esc_html__( 'Products Layout', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'prequelle' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'prequelle' ),
						'sidebar-left' => esc_html__( 'Sidebar at left', 'prequelle' ),
						'fullwidth' => esc_html__( 'Full width', 'prequelle' ),
					),
					'transport' => 'postMessage',
				),

				'product_display' => array(
					'id' =>'product_display',
					'label' => esc_html__( 'Products Archive Display', 'prequelle' ),
					'type' => 'select',
					'choices' => apply_filters( 'prequelle_product_display_options', array(
						'grid_classic' => esc_html__( 'Grid', 'prequelle' ),
					) ),
				),
				'product_single_layout' => array(
					'id' => 'product_single_layout',
					'label' => esc_html__( 'Single Product Layout', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'prequelle' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'prequelle' ),
						'sidebar-left' => esc_html__( 'Sidebar at left', 'prequelle' ),
						'fullwidth' => esc_html__( 'Full Width', 'prequelle' ),
					),
					'transport' => 'postMessage',
				),

				'product_columns' => array(
					'id' => 'product_columns',
					'label' => esc_html__( 'Columns', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'default' => esc_html__( 'Auto', 'prequelle' ),
						3 => 3,
						2 => 2,
						4 => 4,
						6 => 6,
					),
				),

				'product_item_animation' => array(
					'label' => esc_html__( 'Shop Archive Item Animation', 'prequelle' ),
					'id' => 'product_item_animation',
					'type' => 'select',
					'choices' => prequelle_get_animations(),
				),

				'product_zoom' => array(
					'label' => esc_html__( 'Single Product Zoom', 'prequelle' ),
					'id' => 'product_zoom',
					'type' => 'checkbox',
				),

				'related_products_carousel' => array(
					'label' => esc_html__( 'Related Products Carousel', 'prequelle' ),
					'id' => 'related_products_carousel',
					'type' => 'checkbox',
				),

				'cart_menu_item' => array(
					'label' => esc_html__( 'Add a "Cart" Menu Item', 'prequelle' ),
					'id' => 'cart_menu_item',
					'type' => 'checkbox',
				),

				'account_menu_item' => array(
					'label' => esc_html__( 'Add a "Account" Menu Item', 'prequelle' ),
					'id' => 'account_menu_item',
					'type' => 'checkbox',
				),

				'shop_search_menu_item' => array(
					'label' => esc_html__( 'Search Menu Item', 'prequelle' ),
					'id' => 'shop_search_menu_item',
					'type' => 'checkbox',
				),

				'products_per_page' => array(
					'label' => esc_html__( 'Products per Page', 'prequelle' ),
					'id' => 'products_per_page',
					'type' => 'text',
					'placeholder' => 12,
				),
			),
		);
	}

	if ( class_exists( 'Wolf_WooCommerce_Wishlist' ) && class_exists( 'WooCommerce' ) ) {
		$mods['shop']['options']['wishlist_menu_item'] = array(
				'label' => esc_html__( 'Wishlist Menu Item', 'prequelle' ),
				'id' => 'wishlist_menu_item',
				'type' => 'checkbox',
		);
	}

	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_product_mods' );