<?php
/**
 * Album tracklist item
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Track', 'wolf-visual-composer' ),
		'base' => 'wvc_album_tracklist_item',
		'as_child' => array( 'only' => 'wvc_album_tracklist' ),
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-music',
		'params' => array(
			
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
				'param_name' => 'title',
				'placeholder' => esc_html__( 'My Awesome Song', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Duration', 'wolf-visual-composer' ),
				'param_name' => 'duration',
				'placeholder' => '3:25',
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_audio_url',
				'heading' => esc_html__( 'Mp3 URL', 'wolf-visual-composer' ),
				'param_name' => 'mp3',
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Video URL', 'wolf-visual-composer' ),
				'param_name' => 'video_url',
				'placeholder' => 'https://vimeo.com/124894010',
				'description' => sprintf(
					esc_html__( 'Support %1$s and %2$s', 'wolf-visual-composer' ),
					'YouTube',
					'Vimeo'
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Price', 'wolf-visual-composer' ),
				'param_name' => 'price',
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Link', 'wolf-visual-composer' ),
				'param_name' => 'action',
				'value' => array(
					esc_html__( 'None', 'wolf-visual-composer' ) => '',
					esc_html__( 'Buy Link', 'wolf-visual-composer' ) => 'link',
					esc_html__( 'Free Download', 'wolf-visual-composer' ) => 'download',
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => sprintf( esc_html__( '%s URL', 'wolf-visual-composer' ), 'iTunes' ),
				'param_name' => 'itunes_url',
				'placeholder' => 'http://',
				'dependency' => array( 'element' => 'action', 'value' => array( 'link' ) ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => sprintf( esc_html__( '%s URL', 'wolf-visual-composer' ), 'amazon' ),
				'param_name' => 'amazon_url',
				'placeholder' => 'http://',
				'dependency' => array( 'element' => 'action', 'value' => array( 'link' ) ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => sprintf( esc_html__( '%s URL', 'wolf-visual-composer' ), 'Google Play' ),
				'param_name' => 'googleplay_url',
				'placeholder' => 'http://',
				'dependency' => array( 'element' => 'action', 'value' => array( 'link' ) ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Other "Buy" URL', 'wolf-visual-composer' ),
				'param_name' => 'buy_url',
				'placeholder' => 'http://',
				'dependency' => array( 'element' => 'action', 'value' => array( 'link' ) ),
			),
		
		),
	)
);

if ( class_exists( 'WooCommerce' ) ) {
	$product_posts = get_posts( 'post_type="product"&numberposts=-1' );

	$products = array();
	if ( $product_posts ) {
		$products[ esc_html__( 'Not linked', 'wolf-visual-composer' ) ] = '';
		foreach ( $product_posts as $product_options ) {
			$products[ $product_options->post_title ] = $product_options->ID;
		}
	} else {
		$products[ esc_html__( 'No product yet', 'wolf-visual-composer' ) ] = 0;
	}

	vc_add_param(
		'wvc_album_tracklist_item',
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Link to Product', 'wolf-visual-composer' ),
			'param_name' => 'product_id',
			'value' => $products,
			'dependency' => array( 'element' => 'action', 'value' => array( 'link' ) ),
			'description' => esc_html__( 'Select a product to link to add an "Add to Cart" button.', 'wolf-visual-composer' ),
		)
	);
}

class WPBakeryShortCode_Wvc_Album_Tracklist_Item extends WPBakeryShortCode {}
