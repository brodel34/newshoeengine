<?php
/**
 * Wolf Playlist Manager plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wolf_Playlist_Manager' ) ) {
	return;
}

$choices = array();

$playlists = get_posts( array( 'post_type' => 'wpm_playlist', 'posts_per_page' => -1, ) ); // get all playlist

foreach ( $playlists as $playlist ) {
	$choices[ $playlist->ID ] = $playlist->post_title;
}
if ( array() == $choices ) {
	$choices[0] = esc_html__( 'No playlist created yet', 'wolf-visual-composer' );
}

vc_map(
	array(
		'name' => esc_html__( 'Playlist', 'wolf-visual-composer' ),
		'base' => 'wvc_playlist',
		'description' => esc_html__( 'Display one of your playlist', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Music' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-playlist-audio',
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Playlist', 'wolf-visual-composer' ),
				'param_name' => 'id',
				'value' => array_flip( $choices ),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Tracklist Visibility', 'wolf-visual-composer' ),
				'param_name' => 'show_tracklist',
				'value' => array(
					esc_html__( 'Show', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'Hide', 'wolf-visual-composer' ) => 'false',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Skin', 'wolf-visual-composer' ),
				'param_name' => 'theme',
				'value' => array(
					esc_html__( 'Dark', 'wolf-visual-composer' ) => 'dark',
					esc_html__( 'Light', 'wolf-visual-composer' ) => 'light',
				),
				'std' => apply_filters( 'wvc_default_playlist_skin', 'dark' ),
			),
		)
	)
);

class WPBakeryShortCode_Wvc_Playlist extends WPBakeryShortCode {}