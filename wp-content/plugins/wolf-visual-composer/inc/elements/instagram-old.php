<?php
/**
 * Old Instagram element
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wolf_Instagram' ) ) {
	return;
}
vc_map(
	array(
		'name' => esc_html__( 'Old Instagram', 'wolf-visual-composer' ),
		'base' => 'wolf_instagram_gallery',
		'description' => esc_html__( 'Your last instagram photos', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Social' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-instagram',
		'deprecated' => '5.3',
		'params' => array(
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Image Count', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Note that the instagram API may limit the number of image to display.', 'wolf-visual-composer' ),
				'param_name' => 'count',
				'value' => 18,
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Columns', 'wolf-visual-composer' ),
				'param_name' => 'columns',
				'value' => array( 6, 4, 3, 2 ),
				'admin_label' => true,
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Display follow button', 'wolf-visual-composer' ),
				'param_name' => 'button',
			),
		)
	)
);