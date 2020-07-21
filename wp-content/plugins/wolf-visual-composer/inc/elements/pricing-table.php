<?php
/**
 * Pricing table
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Pricing Table', 'wolf-visual-composer' ),
		'base' => 'wvc_pricing_table',
		'category' => esc_html__( 'Content', 'wolf-visual-composer' ),
		'icon' => 'fa fa-list-alt',
		'params' => array(
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
				'param_name' => 'title',
				'value' => esc_html__( 'Basic Plan', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Title Tag', 'wolf-visual-composer' ),
				'param_name' => 'title_tag',
				'value' => array(
					'h3',
					'h1',
					'h2',
					'h4',
					'h5',
					'h6',
				),
				'std' => 'h3',
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Tagline', 'wolf-visual-composer' ),
				'param_name' => 'tagline',
				'placeholder' => esc_html__( 'An optional tagline', 'wolf-visual-composer' ),
				'admin_label' => true,
			),
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Price', 'wolf-visual-composer' ),
				'param_name' => 'price',
				'placeholder' => 15,
				'admin_label' => true,
			),
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Currency', 'wolf-visual-composer' ),
				'param_name' => 'currency',
				'description' => esc_html__( 'e.g: $ or €', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Display Currency', 'wolf-visual-composer' ),
				'param_name' => 'display_currency',
				'value' => array(
					'before' => esc_html__( 'before', 'wolf-visual-composer' ),
					'after' => esc_html__( 'after', 'wolf-visual-composer' )
				),
				'admin_label' => true,
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Offer', 'wolf-visual-composer' ),
				'param_name' => 'offer',
				'value' => array(
					'no' => esc_html__( 'no', 'wolf-visual-composer' ),
					'yes' => esc_html__( 'yes', 'wolf-visual-composer' ),
				),
				'admin_label' => true,
			),
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Offer Price', 'wolf-visual-composer' ),
				'param_name' => 'offer_price',
				'dependency' => array( 'element' => 'offer', 'value' => array( 'yes' ) ),
				'admin_label' => true,
			),
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Price Period', 'wolf-visual-composer' ),
				'param_name' => 'price_period',
				'description' => esc_html__( 'e.g "monthly" or "per month"', 'wolf-visual-composer' ),
				'admin_label' => true,
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Show Button', 'wolf-visual-composer' ),
				'param_name' => 'show_button',
				'value' => array(
					esc_html__( 'yes', 'wolf-visual-composer' ) => 'yes',
					esc_html__( 'no', 'wolf-visual-composer' ) => 'no',
				),
				'admin_label' => true,
			),
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Button Text', 'wolf-visual-composer' ),
				'param_name' => 'button_text',
				'value' => esc_html__( 'Buy now', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'show_button', 'value' => array( 'yes' ) ),
			),
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Button Link', 'wolf-visual-composer' ),
				'param_name' => 'link',
				'dependency' => array( 'element' => 'show_button', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Featured', 'wolf-visual-composer' ),
				'param_name' => 'featured',
				'value' => array(
					'no' => esc_html__( 'no', 'wolf-visual-composer' ),
					'yes' => esc_html__( 'yes', 'wolf-visual-composer' ),
				),
			),
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Featured Text', 'wolf-visual-composer' ),
				'param_name' => 'featured_text',
				'placeholder' => esc_html__( 'Best Choice', 'wolf-visual-composer' ),
				'std' => esc_html__( 'Best Choice', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'featured', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Services', 'wolf-visual-composer' ),
				'param_name' => 'services',
				'description' => esc_html__( 'Enter one service per line.' ),
			),
		),
	)
);

class WPBakeryShortCode_Wvc_Pricing_Table extends WPBakeryShortCode {}
