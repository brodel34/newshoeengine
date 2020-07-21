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

function prequelle_set_event_mods( $mods ) {

	if ( class_exists( 'Wolf_Events' ) ) {
		$mods['wolf_events'] = array(
			'priority' => 45,
			'id' => 'wolf_events',
			'title' => esc_html__( 'Events', 'prequelle' ),
			'icon' => 'calendar-alt',
			'options' => array(

				'event_layout' => array(
					'id' => 'event_layout',
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

				'event_display' => array(
					'id' => 'event_display',
					'label' => esc_html__( 'Display', 'prequelle' ),
					'type' => 'select',
					'choices' => apply_filters( 'prequelle_list_display_options', array(
						'list' => esc_html__( 'List', 'prequelle' ),
					) ),
				),

				'event_grid_padding' => array(
					'id' => 'event_grid_padding',
					'label' => esc_html__( 'Padding', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'prequelle' ),
						'no' => esc_html__( 'No', 'prequelle' ),
					),
					'transport' => 'postMessage',
				),
			),
		);
	}

	return $mods;

}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_event_mods' );