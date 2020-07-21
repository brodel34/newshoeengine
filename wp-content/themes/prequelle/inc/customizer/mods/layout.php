<?php
/**
 * Prequelle layout
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function prequelle_set_layout_mods( $mods ) {

	$mods['layout'] = array(

		'id' => 'layout',
		'title' => esc_html__( 'Layout', 'prequelle' ),
		'icon' => 'layout',
		'options' => array(

			'site_layout' => array(
				'id' => 'site_layout',
				'label' => esc_html__( 'General', 'prequelle' ),
				'type' => 'radio_images',
				'default' => 'wide',
				'choices' => array(
					array(
						'key' => 'wide',
						'image' => get_parent_theme_file_uri( 'assets/img/customizer/site-layout/wide.png' ),
						'text' => esc_html__( 'Wide', 'prequelle' ),
					),

					array(
						'key' => 'boxed',
						'image' => get_parent_theme_file_uri( 'assets/img/customizer/site-layout/boxed.png' ),
						'text' => esc_html__( 'Boxed', 'prequelle' ),
					),

					array(
						'key' => 'frame',
						'image' => get_parent_theme_file_uri( 'assets/img/customizer/site-layout/frame.png' ),
						'text' => esc_html__( 'Frame', 'prequelle' ),
					),
				),
				'transport' => 'postMessage',
			),

			'button_style' => array(
				'id' => 'button_style',
				'label' => esc_html__( 'Button Shape', 'prequelle' ),
				'type' => 'select',
				'choices' => array(
					'standard' => esc_html__( 'Standard', 'prequelle' ),
					'square' => esc_html__( 'Square', 'prequelle' ),
					'round' => esc_html__( 'Round', 'prequelle' ),
				),
				'transport' => 'postMessage',
			),
		),
	);

	if ( class_exists( 'Wolf_Vc_Content_Block' ) && class_exists( 'Wolf_Visual_Composer' ) && defined( 'WPB_VC_VERSION' ) ) {

		$content_block_posts = get_posts( 'post_type="wvc_content_block"&numberposts=-1' );

		$content_blocks = array( '' => esc_html__( 'None', 'prequelle' ) );
		if ( $content_block_posts ) {
			foreach ( $content_block_posts as $content_block_options ) {
				$content_blocks[ $content_block_options->ID ] = $content_block_options->post_title;
			}
		} else {
			$content_blocks[0] = esc_html__( 'No Content Block Yet', 'prequelle' );
		}

		$mods['layout']['options']['after_header_block'] = array(
			'label'	=> esc_html__( 'Post-header Block', 'prequelle' ),
			'id'	=> 'after_header_block',
			'type'	=> 'select',
			'choices' => $content_blocks,
			'description' => esc_html__( 'A block to display below to header or in replacement of the header.', 'prequelle' ),
		);

		$mods['layout']['options']['before_footer_block'] = array(
			'label'	=> esc_html__( 'Pre-footer Block', 'prequelle' ),
			'id'	=> 'before_footer_block',
			'type'	=> 'select',
			'choices' => $content_blocks,
			'description' => esc_html__( 'A block to display above to footer or in replacement of the footer.', 'prequelle' ),
		);
	}

	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_layout_mods' );