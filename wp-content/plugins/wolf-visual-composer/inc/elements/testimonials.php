<?php
/**
 * Testimonials plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wolf_Testimonials' ) ) {
	return;
}
vc_map(
	array(
		'name' => esc_html__( 'Testimonials', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Display quotes from the testimonial post type', 'wolf-visual-composer' ),
		'tags' => 'photo',
		'base' => 'wolf_testimonials',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-format-quote',
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
				'param_name' => 'columns',
				'value' => array( 4,3,2 ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Category', 'wolf-visual-composer' ),
				'param_name' => 'category',
				'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Display', 'wolf-visual-composer' ),
				'param_name' => 'display',
				'value' => array(
					esc_html__( 'Standard', 'wolf-visual-composer' ) => 'standard',
					esc_html__( 'Carousel', 'wolf-visual-composer' ) => 'carousel',
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Post IDs', 'wolf-visual-composer' ),
				'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'wolf-visual-composer' ),
				'param_name' => 'ids',
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Exclude Post IDs', 'wolf-visual-composer' ),
				'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'wolf-visual-composer' ),
				'param_name' => 'exclude_ids',
			),
		)
	)
);
