<?php
/**
 * Row
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

/* Removing parameters */
vc_remove_param( 'vc_row', 'el_id' );
vc_remove_param( 'vc_row', 'gap' );
vc_remove_param( 'vc_row', 'full_width' );
vc_remove_param( 'vc_row', 'full_height' );
vc_remove_param( 'vc_row', 'columns_placement' );
vc_remove_param( 'vc_row', 'content_placement' );
vc_remove_param( 'vc_row', 'video_bg' );
vc_remove_param( 'vc_row', 'video_bg_url' );
vc_remove_param( 'vc_row', 'video_bg_parallax' );
vc_remove_param( 'vc_row', 'parallax' );
vc_remove_param( 'vc_row', 'parallax_image' );
vc_remove_param( 'vc_row', 'parallax_speed_bg' );
vc_remove_param( 'vc_row', 'parallax_speed_video' );
vc_remove_param( 'vc_row', 'disable_element' );
vc_remove_param( 'vc_row', 'css' );
vc_map_update( 'vc_row', array(
	'icon' => 'fa fa-ellipsis-h',
	'weight' => 1000,
) );
$bigtext_params = vc_map_integrate_shortcode(
	wvc_bigtext_params(),
	'bt_', // bt stands for big text
	esc_html( 'Big Text', 'wolf-visual-composer' ),
	array(
		'exclude' => array(
			'title_tag',
			'link',
			'css_animation' => '',
			'css_animation_delay' => '',
			'el_class' => '',
			'css' => '',
			'inline_style' => '',
		),
	),

	array(
		'element' => 'add_bigtext',
		'value' => 'true',
	)
);
if ( is_array( $bigtext_params ) && ! empty( $bigtext_params ) ) {
	foreach ( $bigtext_params as $key => $param ) {
		if ( is_array( $param ) && ! empty( $param ) ) {
				$bigtext_params[ $key ]['admin_label'] = false;
		}
	}
}
vc_add_params(
	'vc_row',
	array_merge(
		wvc_row_general_params(),
		array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Skin Tone', 'wolf-visual-composer' ),
				'param_name' => 'font_color',
				'value' => array(
					esc_html__( 'Light', 'wolf-visual-composer' ) => 'dark',
					esc_html__( 'Dark', 'wolf-visual-composer' ) => 'light',
				),
				'std' => apply_filters( 'wvc_default_row_font_color', 'dark' ),
				'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
				'weight' => 0,
			),
		),
		array_merge(
			wvc_background_params(),
			array(
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Video mute button (beta)', 'wolf-visual-composer' ),
					'param_name' => 'video_bg_mute_button',
					'dependency' => array( 'element' => 'background_type', 'value' => array( 'video' ) ),
					'description' => esc_html__( 'Only if parallax is not enabled.', 'wolf-visual-composer' ),
					'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Unmute video by default', 'wolf-visual-composer' ),
					'param_name' => 'video_bg_unmute',
					'dependency' => array( 'element' => 'background_type', 'value' => array( 'video' ) ),
					'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
				),
			),
			array(
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Add Big Text Background', 'wolf-visual-composer' ),
					'param_name' => 'add_bigtext',
					'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
				),
			),
			$bigtext_params,
			array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Big Text Vertical Position', 'wolf-visual-composer' ),
					'param_name' => 'bt_vertical_align',
					'value' => array(
						esc_html__( 'Middle', 'wolf-visual-composer' ) => 'middle',
						esc_html__( 'Top', 'wolf-visual-composer' ) => 'top',
						esc_html__( 'Bottom', 'wolf-visual-composer' ) => 'bottom',
					),
					'group' => esc_html__( 'Big Text', 'wolf-visual-composer' ),
					'dependency' => array(
						'element' => 'add_bigtext',
						'value' => 'true',
					),
				),
				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Big Text Maximum Width', 'wolf-visual-composer' ),
					'param_name' => 'bt_max_width',
					'placeholder' => 2000,
					'group' => esc_html__( 'Big Text', 'wolf-visual-composer' ),
					'dependency' => array(
						'element' => 'add_bigtext',
						'value' => 'true',
					),
				),
			)
		),
		wvc_style_params(),
		array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Border Color', 'wolf-visual-composer' ),
				'param_name' => 'border_color',
				'value' => array_merge(
					array( esc_html__( 'None', 'wolf-visual-composer' ) => 'none', ),
					wvc_get_shared_gradient_colors(),
					wvc_get_shared_colors(),
					array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
				),
				'param_holder_class' => 'wvc_colored-dropdown',
				'group' => esc_html__( 'Custom', 'wolf-visual-composer' ),
				'weight' => -5,
			),

			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Border Custom Color', 'wolf-visual-composer' ),
				'param_name' => 'border_custom_color',
				'dependency' => array(
					'element' => 'border_color',
					'value' => 'custom',
				),
				'group' => esc_html__( 'Custom', 'wolf-visual-composer' ),
				'weight' => -5,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Border Style', 'wolf-visual-composer' ),
				'param_name' => 'border_style',
				'value' => array(
					esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
					esc_html__( 'Solid', 'wolf-visual-composer' ) => 'solid',
					esc_html__( 'Dotted', 'wolf-visual-composer' ) => 'dotted',
					esc_html__( 'Dashed', 'wolf-visual-composer' ) => 'dashed',
					esc_html__( 'Double', 'wolf-visual-composer' ) => 'double',
					esc_html__( 'Groove', 'wolf-visual-composer' ) => 'groove',
					esc_html__( 'Ridge', 'wolf-visual-composer' ) => 'ridge',
					esc_html__( 'Inset', 'wolf-visual-composer' ) => 'inset',
					esc_html__( 'Outset', 'wolf-visual-composer' ) => 'outset',
				),
				'group' => esc_html__( 'Custom', 'wolf-visual-composer' ),
				'weight' => -5,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Inline Style', 'wolf-visual-composer' ),
				'param_name' => 'inline_style',
				'group' => esc_html__( 'Custom', 'wolf-visual-composer' ),
				'description' => sprintf( esc_html__( 'Additional inline CSS that will be applied to the element. (e.g: %s)', 'wolf-visual-composer' ), 'color:red;' ),
				'weight' => -5,
			),
		),
		wvc_row_extra_params(),
		wvc_row_shape_dividers_params()
	)
);

if ( class_exists( 'Wolf_Playlist_Manager' ) ) {
	$playlist_posts = get_posts( 'post_type="wpm_playlist"&numberposts=-1' );

	$playlist = array( '' => esc_html__( 'None', 'wolf-visual-composer' ) );
	if ( $playlist_posts ) {
		foreach ( $playlist_posts as $playlist_options ) {
			$playlist[ $playlist_options->ID ] = $playlist_options->post_title;
		}
	} else {
		$playlist[0] = esc_html__( 'No Playlist Yet', 'wolf-visual-composer' );
	}

	vc_add_params( 'vc_row', array(

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Playlist', 'wolf-visual-composer' ),
			'param_name' => 'sticky_player_playlist_id',
			'value' => array_flip( $playlist ),
			'group' => esc_html__( 'Player Bar', 'wolf-visual-composer' ),
			'weight' => -1000
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Playlist Skin', 'wolf-visual-composer' ),
			'param_name' => 'sticky_player_playlist_skin',
			'value' => array(
				esc_html__( 'Dark', 'wolf-visual-composer' ) => 'dark',
				esc_html__( 'Light', 'wolf-visual-composer' ) => 'dark',
				esc_html__( 'Transparent Light', 'wolf-visual-composer' ) => 'transparent-light',
				esc_html__( 'Transparent Dark', 'wolf-visual-composer' ) => 'transparent-dark',
			),
			'group' => esc_html__( 'Player Bar', 'wolf-visual-composer' ),
			'weight' => -1000
		),
	) );
}