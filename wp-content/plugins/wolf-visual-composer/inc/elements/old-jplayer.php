<?php
/**
 * Old jPlayer plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wolf_Jplayer' ) ) {
	return;
}

vc_map(
	array(
		'name' => esc_html__( 'jPlayer', 'wolf-visual-composer' ),
		'base' => 'wolf_jplayer_playlist',
		'description' => esc_html__( 'Display the old jPlayer plugin', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Music' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-indent',
		'deprecated' => '5.2',
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Playlist ID', 'wolf-visual-composer' ),
				'param_name' => 'id',
				'admin_label' => true,
			),
		),
	),
);

