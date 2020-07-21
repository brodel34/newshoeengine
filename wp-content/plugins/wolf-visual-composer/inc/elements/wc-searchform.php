<?php
/**
 * WooCommerce search form
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'WooCommerce Search Form', 'wolf-visual-composer' ),
		'description' => esc_html__( 'A Big Products Search Bar', 'wolf-visual-composer' ),
		'base' => 'wvc_wc_searchform',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'icon-wpb-woocommerce',
		'params' => array(
			
		)
	)
);

class WPBakeryShortCode_Wvc_WC_Searchform extends WPBakeryShortCode {}