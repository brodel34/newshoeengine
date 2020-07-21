<?php
/**
 * Empty space
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_remove_param( 'vc_empty_space', 'css' );

vc_add_param(
	'vc_empty_space',
	array(
		'type' => 'wvc_textfield',
		'heading' => esc_html__( 'Height', 'wolf-visual-composer' ),
		'param_name' => 'height',
		'value' => '14px',
		'admin_label' => true,
		'description' => esc_html__( 'Enter empty space height (Note: CSS measurement units allowed).', 'wolf-visual-composer' ),
	)
);