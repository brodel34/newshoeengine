<?php
/**
 * Showcase Vertical Carousel
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Showcase Vertical', 'wolf-visual-composer' ),
		'base' => 'wvc_showcase_vertical_carousel',
		'as_parent' => array( 'only' => 'wvc_showcase_vertical_carousel_item' ),
		'show_settings_on_create' => false,
		'content_element' => true,
		'description' => esc_html__( 'Showcase anything the smart way', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-television',
		'params' => array(
			


		),
		'js_view' => 'VcColumnView',
	)
);

class WPBakeryShortCode_Wvc_Showcase_Vertical_Carousel extends WPBakeryShortCodesContainer {}