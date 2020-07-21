<?php
/**
 * Prequelle customizer blog mods
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function prequelle_set_work_mods( $mods ) {

	if ( class_exists( 'Wolf_Portfolio' ) ) {

		$mods['portfolio'] = array(
			'id' => 'portfolio',
			'icon' => 'portfolio',
			'title' => esc_html__( 'Portfolio', 'prequelle' ),
			'options' => array(

				'work_layout' => array(
					'id' =>'work_layout',
					'label' => esc_html__( 'Portfolio Layout', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'prequelle' ),
						'fullwidth' => esc_html__( 'Full width', 'prequelle' ),
					),
				),

				'work_display' => array(
					'id' =>'work_display',
					'label' => esc_html__( 'Portfolio Display', 'prequelle' ),
					'type' => 'select',
					'choices' => apply_filters( 'prequelle_work_display_options', array(
						'grid' => esc_html__( 'Grid', 'prequelle' ),
					) ),
				),

				'work_grid_padding' => array(
					'id' => 'work_grid_padding',
					'label' => esc_html__( 'Padding (for grid style display only)', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'prequelle' ),
						'no' => esc_html__( 'No', 'prequelle' ),
					),
					'transport' => 'postMessage',
				),

				'work_item_animation' => array(
					'label' => esc_html__( 'Portfolio Post Animation', 'prequelle' ),
					'id' => 'work_item_animation',
					'type' => 'select',
					'choices' => prequelle_get_animations(),
				),

				'work_pagination' => array(
					'id' => 'work_pagination',
					'label' => esc_html__( 'Portfolio Archive Pagination', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'none' => esc_html__( 'None', 'prequelle' ),
						'standard_pagination' => esc_html__( 'Numeric Pagination', 'prequelle' ),
						'load_more' => esc_html__( 'Load More Button', 'prequelle' ),
					),
					'description' => esc_html__( 'You must set a number of posts per page below. The category filter will not be disabled.', 'prequelle' ),
				),

				'works_per_page' => array(
					'label' => esc_html__( 'Works per Page', 'prequelle' ),
					'id' => 'works_per_page',
					'type' => 'text',
					'placeholder' => 6,
				),
			),
		);
	}

	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_work_mods' );