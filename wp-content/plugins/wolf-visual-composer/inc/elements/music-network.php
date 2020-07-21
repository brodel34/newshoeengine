<?php
/**
 * Music Network Plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( class_exists( 'Wolf_Music_Network' ) ) {
	vc_map(
		array(
			'name' => esc_html__( 'Music Network', 'wolf-visual-composer' ),
			'base' => 'wolf_music_network',
			'category' => esc_html__( 'Music' , 'wolf-visual-composer' ),
			'tags' => 'music',
			'description' => esc_html__( 'Display your music social network', 'wolf-visual-composer' ),
			'icon' => 'fa fa-headphones',
			'params' => array(

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Height', 'wolf-visual-composer' ),
					'param_name' => 'height',
					'value' => 32,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Alignment', 'wolf-visual-composer' ),
					'param_name' => 'align',
					'value' => array(
						esc_html__( 'Centered', 'wolf-visual-composer' ) => 'center',
						esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
						esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
					),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Services', 'wolf-visual-composer' ),
					'param_name' => 'services',
					'description' => esc_html__( 'separated by a comma (empty for all)', 'wolf-visual-composer' ),
				),
			)
		)
	);
}