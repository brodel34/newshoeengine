<?php
/**
 * Zig Zag
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map_update( 'vc_zigzag', array(
	'icon' => 'fa fa-arrows-h',
) );

vc_add_params(
	'vc_zigzag',
	array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Color', 'wolf-visual-composer' ),
			'param_name' => 'color',
			'value' => array_merge(
				array( esc_html__( 'Default', 'wolf-visual-composer' ) => 'default', ),
				wvc_get_shared_colors(),
				wvc_get_shared_gradient_colors(),
				array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
			),
			'description' => esc_html__( 'Select icon color.', 'wolf-visual-composer' ),
			'param_holder_class' => 'wvc_colored-dropdown',
		),

		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Custom color', 'wolf-visual-composer' ),
			'param_name' => 'custom_color',
			'description' => esc_html__( 'Select custom icon color.', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'color',
				'value' => 'custom',
			),
		),
	)
);