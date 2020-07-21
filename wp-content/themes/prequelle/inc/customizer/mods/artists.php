<?php
/**
 * Prequelle events
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function prequelle_set_artist_mods( $mods ) {

	if ( class_exists( 'Wolf_Artists' ) ) {
		$mods['wolf_artists'] = array(
			'priority' => 45,
			'id' => 'wolf_artists',
			'title' => esc_html__( 'Artists', 'prequelle' ),
			'icon' => 'admin-users',
			'options' => array(

				'artist_layout' => array(
					'id' => 'artist_layout',
					'label' => esc_html__( 'Layout', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'prequelle' ),
						'fullwidth' => esc_html__( 'Full width', 'prequelle' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'prequelle' ),
						'sidebar-left' => esc_html__( 'Sidebar at left', 'prequelle' ),
					),
					'transport' => 'postMessage',
					'description' => esc_html__( 'For "Sidebar" layouts, the sidebar will be visible if it contains widgets.', 'prequelle' ),
				),

				'artist_display' => array(
					'id' => 'artist_display',
					'label' => esc_html__( 'Display', 'prequelle' ),
					'type' => 'select',
					'choices' => apply_filters( 'prequelle_artist_display_options', array(
						'list' => esc_html__( 'List', 'prequelle' ),
					) ),
				),

				'artist_grid_padding' => array(
					'id' => 'artist_grid_padding',
					'label' => esc_html__( 'Padding', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'prequelle' ),
						'no' => esc_html__( 'No', 'prequelle' ),
					),
					'transport' => 'postMessage',
				),

				'artist_pagination' => array(
					'id' => 'artist_pagination',
					'label' => esc_html__( 'Artists Archive Pagination', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'none' => esc_html__( 'None', 'prequelle' ),
						'standard_pagination' => esc_html__( 'Numeric Pagination', 'prequelle' ),
						'load_more' => esc_html__( 'Load More Button', 'prequelle' ),
					),
					'description' => esc_html__( 'You must set a number of posts per page below. The category filter will not be disabled.', 'prequelle' ),
				),

				'artists_per_page' => array(
					'label' => esc_html__( 'Artists per Page', 'prequelle' ),
					'id' => 'artists_per_page',
					'type' => 'text',
					'placeholder' => 6,
				),
			),
		);
	}

	return $mods;

}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_artist_mods' );