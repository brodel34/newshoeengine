<?php
/**
 * Prequelle videos
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function prequelle_set_video_mods( $mods ) {

	if ( class_exists( 'Wolf_Videos' ) ) {
		$mods['wolf_videos'] = array(
			'id' => 'wolf_videos',
			'title' => esc_html__( 'Videos', 'prequelle' ),
			'icon' => 'editor-video',
			'options' => array(

				'video_layout' => array(
					'id' => 'video_layout',
					'label' => esc_html__( 'Layout', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'prequelle' ),
						'fullwidth' => esc_html__( 'Full width', 'prequelle' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'prequelle' ),
						'sidebar-left' => esc_html__( 'Sidebar at left', 'prequelle' ),
					),
					'description' => esc_html__( 'For "Sidebar" layouts, the sidebar will be visible if it contains widgets.', 'prequelle' ),
				),

				'video_grid_padding' => array(
					'id' => 'video_grid_padding',
					'label' => esc_html__( 'Padding', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'prequelle' ),
						'no' => esc_html__( 'No', 'prequelle' ),
					),
					'transport' => 'postMessage',
				),

				'video_display' => array(
					'id' => 'video_display',
					'label' => esc_html__( 'Display', 'prequelle' ),
					'type' => 'select',
					'choices' => apply_filters( 'prequelle_video_display_options', array(
						'grid' => esc_html__( 'Grid', 'prequelle' ),
					) ),
				),

				'video_item_animation' => array(
					'label' => esc_html__( 'Video Archive Item Animation', 'prequelle' ),
					'id' => 'video_item_animation',
					'type' => 'select',
					'choices' => prequelle_get_animations(),
				),

				'video_onclick' => array(
					'label' => esc_html__( 'On Click', 'prequelle' ),
					'id' => 'video_onclick',
					'type' => 'select',
					'choices' => apply_filters( 'prequelle_video_onclick', array(
							'lightbox' => esc_html__( 'Open Video in Lightbox', 'prequelle' ),
							'default' => esc_html__( 'Go to the Video Page', 'prequelle' ),
						)
					),
				),

				'video_pagination' => array(
					'id' => 'video_pagination',
					'label' => esc_html__( 'Video Archive Pagination', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'none' => esc_html__( 'None', 'prequelle' ),
						'standard_pagination' => esc_html__( 'Numeric Pagination', 'prequelle' ),
						'load_more' => esc_html__( 'Load More Button', 'prequelle' ),
					),
					'description' => esc_html__( 'You must set a number of posts per page below. The category filter will not be disabled.', 'prequelle' ),
				),

				'videos_per_page' => array(
					'label' => esc_html__( 'Videos per Page', 'prequelle' ),
					'id' => 'videos_per_page',
					'type' => 'text',
					'placeholder' => 6,
				),

				'video_single_layout' => array(
					'id' =>'video_single_layout',
					'label' => esc_html__( 'Single Post Layout', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'sidebar-right' => esc_html__( 'Sidebar Right', 'prequelle' ),
						'sidebar-left' => esc_html__( 'Sidebar Left', 'prequelle' ),
						'no-sidebar' => esc_html__( 'No Sidebar', 'prequelle' ),
						'fullwidth' => esc_html__( 'Full width', 'prequelle' ),
					),
				),

				/*'video_columns' => array(
					'id' => 'video_columns',
					'label' => esc_html__( 'Columns', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						3 => 3,
						2 => 2,
						4 => 4,
						5 => 5,
						6 => 6,
					),
					'transport' => 'postMessage',
				),*/
			),
		);
	}

	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_video_mods' );