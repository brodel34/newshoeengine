<?php
/**
 * Album Disc
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$product_options = array();
$product_options[] = esc_html__( 'WooCommerce not installed', 'wolf-visual-composer' );

if ( class_exists( 'WooCommerce' ) ) {
	$product_posts = get_posts( 'post_type="product"&numberposts=-1' );

	$product_options = array();
	if ( $product_posts ) {
		
		$product_options[] = esc_html__( 'Not linked', 'wolf-visual-composer' );
		
		foreach ( $product_posts as $product ) {
			$product_options[ $product->ID ] = $product->post_title;
		}
	} else {
		$product_options[0] = esc_html__( 'No product yet', '%TMEXTDOAIN%' );
	}
}

vc_map(
	array(
		'name' => esc_html__( 'Product Presentation', 'wolf-visual-composer' ),
		'description' => esc_html__( 'A stylish presentation for your product', 'wolf-visual-composer' ),
		'base' => 'wvc_product_presentation',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'icon-wpb-woocommerce',
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Product', 'wolf-visual-composer' ),
				'param_name' => 'product_id',
				'value' => array_flip( $product_options ),
				'admin_label' => true,
			),
		),
	)
);

class WPBakeryShortCode_Wvc_Product_Presentation extends WPBakeryShortCode {}