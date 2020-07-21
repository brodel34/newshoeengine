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
		'name' => esc_html__( 'Spotify Follow Button', 'wolf-visual-composer' ),
		'base' => 'wvc_spotify_follow_button',
		'description' => esc_html__( 'Spotify Player', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Music' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-spotify',
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Spotify Artist Link', 'wolf-visual-composer' ),
				'param_name' => 'url',
				'placeholder' => 'https://open.spotify.com/artist/4RuzGKLG99XctuBMBkFFOC',
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Size', 'wolf-visual-composer' ),
				'param_name' => 'size',
				'value' => array(
					esc_html__( 'Detailed', 'wolf-visual-composer' ) => 'detail',
					esc_html__( 'Basic', 'wolf-visual-composer' ) => 'basic',
				),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Theme', 'wolf-visual-composer' ),
				'param_name' => 'theme',
				'value' => array(
					esc_html__( 'For bright backgrounds', 'wolf-visual-composer' ) => 'light',
					esc_html__( 'For dark backgrounds', 'wolf-visual-composer' ) => 'dark',
				),
				'admin_label' => true,
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Show follower count', 'wolf-visual-composer' ),
				'param_name' => 'show_count',
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Alignment', 'wolf-visual-composer' ),
				'param_name' => 'alignment',
				'value' => array(
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
				),
			),
		),
	)
);