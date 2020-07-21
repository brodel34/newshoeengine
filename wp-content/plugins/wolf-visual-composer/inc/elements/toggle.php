<?php
/**
 * Toggle
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Toggle', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Showcase your albums from the gallery post type', 'wolf-visual-composer' ),
		'base' => 'vc_toggle',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-toggle-on',
		'params' => array(
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
				'param_name' => 'h4',
				'value' => esc_html__( 'My Title', 'wolf-visual-composer' ),
				'admin_heading' => true,
				'holder' => 'div',
			),
			array(
				'type' => 'textarea_html',
				'heading' => esc_html__( 'Content', 'wolf-visual-composer' ),
				'param_name' => 'content',
				'value' => esc_html__( 'Toggle content goes here, click edit button to change this text.' ),
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Open by default', 'wolf-visual-composer' ),
				'param_name' => 'open',
			),
		),
	)
);