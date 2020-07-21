<?php
/**
 * Prequelle photos
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function prequelle_set_attachment_mods( $mods ) {

	if ( class_exists( 'Wolf_Photos' ) ) {
		$mods['photos'] = array(
			'priority' => 45,
			'id' => 'photos',
			'title' => esc_html__( 'Stock Photos', 'prequelle' ),
			'icon' => 'camera',
			'options' => array(

				'attachment_layout' => array(
					'id' => 'attachment_layout',
					'label' => esc_html__( 'Layout', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'prequelle' ),
						'fullwidth' => esc_html__( 'Full width', 'prequelle' ),
					),
					'transport' => 'postMessage',
				),

				'attachment_display' => array(
					'id' =>'attachment_display',
					'label' => esc_html__( 'Photos Display', 'prequelle' ),
					'type' => 'select',
					'choices' => apply_filters( 'prequelle_attachment_display_options', array(
						'grid' => esc_html__( 'Grid', 'prequelle' ),
					) ),
				),

				'attachment_grid_padding' => array(
					'id' => 'attachment_grid_padding',
					'label' => esc_html__( 'Padding', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'prequelle' ),
						'no' => esc_html__( 'No', 'prequelle' ),
					),
					'transport' => 'postMessage',
				),

				'attachment_author' => array(
					'id' => 'attachment_author',
					'label' => esc_html__( 'Display Author on Single Page', 'prequelle' ),
					'type' => 'checkbox',
				),

				'attachment_likes' => array(
					'id' => 'attachment_likes',
					'label' => esc_html__( 'Display Likes', 'prequelle' ),
					'type' => 'checkbox',
				),

				'attachment_multiple_sizes_download' => array(
					'id' => 'attachment_multiple_sizes_download',
					'label' => esc_html__( 'Allow multiple sizes options for downloadable photos.', 'prequelle' ),
					'type' => 'checkbox',
				),

				'attachments_per_page' => array(
					'label' => esc_html__( 'Photos per Page', 'prequelle' ),
					'id' => 'attachments_per_page',
					'type' => 'text',
				),

				'attachments_pagination' => array(
					'id' => 'attachments_pagination',
					'label' => esc_html__( 'Pagination Type', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'infinitescroll' => esc_html__( 'Infinite Scroll', 'prequelle' ),
						'numbers' => esc_html__( 'Numbers', 'prequelle' ),
					),
					'transport' => 'postMessage',
				),
			),
		);
	}

	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_attachment_mods' );