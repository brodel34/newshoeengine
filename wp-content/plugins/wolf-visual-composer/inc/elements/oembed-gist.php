<?php
/**
 * Gist
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( class_exists( 'gist' ) ) {
	vc_map(
		array(
			'name' => esc_html__( 'Gist', 'wolf-visual-composer' ),
			'description' => esc_html__( 'Display an Embed Gist', 'wolf-visual-composer' ),
			'base' => 'gist',
			'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
			'icon' => 'fa fa-github',
			'params' => array(

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Gist URL', 'wolf-visual-composer' ),
					'param_name' => 'url',
					'placeholder' => 'https://',
				),
			)
		)
	);
}