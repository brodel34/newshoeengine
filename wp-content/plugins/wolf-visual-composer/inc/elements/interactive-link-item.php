<?php
/**
 * Interactive LInk Item
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/* Get bg params */
$bg_params = wvc_background_params();

/* Remove unwanted params */
$remove_bg_params = array(
	'background_effect',
	'background_marquee_position',
	'video_bg_loop',
	'video_bg_parallax',
	'add_particles',
);

foreach ( $bg_params as $key => $param ) {
	if ( is_array( $param ) && ! empty( $param ) ) {

		if ( 'background_type' === $param['param_name'] ) {
			$bg_params[ $key ]['value'] = array(
				esc_html__( 'Image', 'wolf-visual-composer' ) => 'image',
				esc_html__( 'Video', 'wolf-visual-composer' ) => 'video',
			);

			$bg_params[ $key ]['std'] = 'image';
		}

		if ( 'background_img' === $param['param_name'] ) {
			$bg_params[ $key ]['param_name'] = 'image'; // backward compat
		}

		if ( 'add_overlay' === $param['param_name'] ) {
		}

		$bg_params[ $key ]['group'] = esc_html__( 'Background', 'wolf-visual-composer' );

		if ( in_array( $param['param_name'], $remove_bg_params ) ) {
			unset( $bg_params[ $key ] );
		}
	}
}
vc_map(
	array(
		'name' => esc_html__( 'Interactive LInk Item', 'wolf-visual-composer' ),
		'base' => 'wvc_interactive_link_item',
		'as_child' => array(
			'only' => 'wvc_interactive_links',
			'except' => 'wvc_anything_slider, wvc_posts_index'
		),
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-television',
		'params' => array_merge(
			array(

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Link Type', 'wolf-visual-composer' ),
					'param_name' => 'link_type',
					'value' => array(
						esc_html__( 'Text', 'wolf-visual-composer' ) => 'text',
						esc_html__( 'Image', 'wolf-visual-composer' ) => 'image',
					),
					'admin_label' => true,
					'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
				),

				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Link Image', 'wolf-visual-composer' ),
					'param_name' => 'link_image',
					'admin_label' => true,
					'dependency' => array(
						'element' => 'link_type',
						'value' => 'image',
					),
					'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Text', 'wolf-visual-composer' ),
					'param_name' => 'text',
					'value' => esc_html__( 'About', 'wolf-visual-composer' ),
					'admin_label' => true,
					'dependency' => array(
						'element' => 'link_type',
						'value' => 'text',
					),
					'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
				),

				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Link', 'wolf-visual-composer' ),
					'param_name' => 'link',
					'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
				),
			),
			$bg_params
		)
	)
);

class WPBakeryShortCode_Wvc_Interactive_Link_Item extends WPBakeryShortCode {}
