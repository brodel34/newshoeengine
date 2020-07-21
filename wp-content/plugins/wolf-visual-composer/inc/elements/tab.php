<?php
/**
 * Tab
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Tab', 'wolf-visual-composer' ),
		'base' => 'vc_tab',
		'allowed_container_element' => 'vc_row',
		'is_container' => true,
		'content_element' => false,
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Tab title.', 'wolf-visual-composer' )
			),
		),
		'js_view' => 'VcTabView',
	)
);