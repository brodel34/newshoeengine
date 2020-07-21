<?php
/**
 * Audio Button
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
$button_params = vc_map_integrate_shortcode(
	wvc_button_params(),
	'',
	'',
	array(
		'exclude' => array(
			'add_icon',
			'link',
			'scroll_to_anchor',
		),
		'exclude_regex' => array(
			'/i_/',
		),
	)
);
if ( is_array( $button_params ) && ! empty( $button_params ) ) {
	foreach ( $button_params as $key => $param ) {
		if ( is_array( $param ) && ! empty( $param ) ) {

			if ( 'title' == $param['param_name'] ) {
				$button_params[ $key ]['value'] = esc_html__( 'Play', 'wolf-visual-composer' );
			}
		}
	}
}
vc_map(
	array(
		'name' => esc_html__( 'Audio button', 'wolf-visual-composer' ),
		'base' => 'wvc_audio_button',
		'description' => esc_html__( 'A simple play/pause player button', 'wolf-visual-composer' ),
		'icon' => 'fa fa-music',
		'category' => esc_html__( 'Music' , 'wolf-visual-composer' ),
		'params' => array_merge(
			array(
				array(
					'type' => 'wvc_audio_url',
					'heading' => esc_html__( 'Mp3 URL', 'wolf-visual-composer' ),
					'param_name' => 'mp3',
					'admin_label' => true,
				),
			),
			$button_params
		),
	)
);

class WPBakeryShortCode_Wvc_Audio_Button extends WPBakeryShortCode {}