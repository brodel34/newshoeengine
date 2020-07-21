<?php
/**
 * Info Table
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Info Table', 'wolf-visual-composer' ),
		'base' => 'wvc_info_table',
		'description' => esc_html__( 'A simple two columns table to present an item', 'wolf-visual-composer' ),
		'icon' => 'fa fa-th',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'params' => array(
			array(
				'type' => 'param_group',
				'value' => '',
				'param_name' => 'values',
				'params' => array(
					array(
						'type' => 'textfield',
						'value' => '',
						'heading' => esc_html__( 'Label', 'wolf-visual-composer' ),
						'param_name' => 'label',
					),
					array(
						'type' => 'textfield',
						'value' => '',
						'heading' => esc_html__( 'Value', 'wolf-visual-composer' ),
						'param_name' => 'value',
					)
				)
			)
		),
	)
);

class WPBakeryShortCode_Wvc_Info_Table extends WPBakeryShortCode {}