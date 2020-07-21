<?php
/**
 * Admin Helper Text
 *
 * Helper text to display in the admin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Admin Comment', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Helper text to display in the admin.', 'wolf-visual-composer' ),
		'base' => 'wvc_admin_helper_text',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-question',
		'params' => array(

			array(
				'type' => 'textarea',
				'holder' => 'div',
				'heading' => esc_html__( 'Comment', 'wolf-visual-composer' ),
				'param_name' => 'comment',
			),
		),
	)
);