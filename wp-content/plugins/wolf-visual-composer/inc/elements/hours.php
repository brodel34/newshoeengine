<?php
/**
 * Hours
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Opening Hours', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Display your opening hours', 'wolf-visual-composer' ),
		'base' => 'wvc_hours',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-clock-o',
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Day', 'wolf-visual-composer' ),
				'param_name' => 'day',
				'placeholder' => esc_html__( 'Monday', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Hours', 'wolf-visual-composer' ),
				'param_name' => 'hours',
				'admin_label' => true,
			),
		)
	)
);

class WPBakeryShortCode_Wvc_Hours extends WPBakeryShortCode {}