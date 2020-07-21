<?php
/**
 * Spotify Player
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Spotify Player', 'wolf-visual-composer' ),
		'base' => 'wvc_spotify_player',
		'description' => esc_html__( 'Spotify Player', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Music' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-spotify',
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Spotify Link', 'wolf-visual-composer' ),
				'param_name' => 'url',
				'placeholder' => 'https://open.spotify.com/album|track|artist|playlist/4RuzGKLG99XctuBMBkFFOC',
				'description' => esc_html__( 'A Spotify link URL containing the word "album", "track, "artist", or "playlist".', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Type', 'wolf-visual-composer' ),
				'param_name' => 'type',
				'value' => array(
					esc_html__( 'Large', 'wolf-visual-composer' ) => 'large',
					esc_html__( 'Compact', 'wolf-visual-composer' ) => 'compact',
				),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Width', 'wolf-visual-composer' ),
				'param_name' => 'width',
				'value' => 300,
				'placeholder' => '300',
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Height', 'wolf-visual-composer' ),
				'param_name' => 'height',
				'value' => 380,
				'placeholder' => '380',
				'admin_label' => true,
				'dependency' => array(
					'element' => 'type',
					'value' => 'large',
				),
			),
		),
	)
);