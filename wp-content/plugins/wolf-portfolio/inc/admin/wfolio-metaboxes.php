<?php
/**
 * Wolf Portfolio register metaboxes
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPortfolio/Admin
 * @version 1.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$metaboxes = array(
	'Work Details' => array(
		'title' => esc_html__( 'Work Details', 'wolf-portfolio' ),
		'page' => array( 'work' ),
		'metafields' => array(
			array(
				'label'	=> esc_html__( 'Client', 'wolf-portfolio' ),
				'id'	=> '_work_client',
				'type'	=> 'text',
			),

			array(
				'label'	=> esc_html__( 'Link', 'wolf-portfolio' ),
				'id'	=> '_work_link',
				'type'	=> 'text',
			),
		),
	),
);

new Wolf_Portfolio_Admin_Metabox( $metaboxes );