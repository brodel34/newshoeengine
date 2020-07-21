<?php
/**
 * Albums plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wolf_Albums' ) ) {
	return;
}
vc_map(
	array(
		'name' => esc_html__( 'Albums', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Showcase your albums from the gallery post type', 'wolf-visual-composer' ),
		'base' => 'wolf_last_albums',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-images-alt2',
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Count', 'wolf-visual-composer' ),
				'param_name' => 'count',
				'value' => 4,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Columns', 'wolf-visual-composer' ),
				'param_name' => 'col',
				'value' => array( 4,3,2 ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Category', 'wolf-visual-composer' ),
				'param_name' => 'category',
				'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'wolf-visual-composer' ),
			),
		)
	)
);
vc_map(
	array(
		'name' => esc_html__( 'Photos Widget (last photos)', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Display the last photos uploaded in your albums', 'wolf-visual-composer' ),
		'base' => 'wolf_last_photos_widget',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-images-alt2',
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Count', 'wolf-visual-composer' ),
				'param_name' => 'count',
				'value' => 4,
			),
		)
	)
);