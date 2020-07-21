<?php
/**
 * Inner Row
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/* Removing parameters */
vc_remove_param( 'vc_row_inner', 'el_id' );
vc_remove_param( 'vc_row_inner', 'gap' );
vc_remove_param( 'vc_row_inner', 'content_position' );
vc_remove_param( 'vc_row_inner', 'full_width' );
vc_remove_param( 'vc_row_inner', 'full_height' );
vc_remove_param( 'vc_row_inner', 'video_bg' );
vc_remove_param( 'vc_row_inner', 'video_bg_url' );
vc_remove_param( 'vc_row_inner', 'video_bg_parallax' );
vc_remove_param( 'vc_row_inner', 'parallax' );
vc_remove_param( 'vc_row_inner', 'parallax_image' );
vc_remove_param( 'vc_row_inner', 'parallax_speed_bg' );
vc_remove_param( 'vc_row_inner', 'parallax_speed_video' );
vc_remove_param( 'vc_row_inner', 'disable_element' );
vc_remove_param( 'vc_row_inner', 'css' );
vc_add_params(
	'vc_row_inner',
	array_merge(
		wvc_row_inner_general_params(),
		array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Font Color', 'wolf-visual-composer' ),
				'param_name' => 'font_color',
				'value' => array(
					esc_html__( 'Inherit', 'wolf-visual-composer' ) => 'inherit',
					esc_html__( 'Dark', 'wolf-visual-composer' ) => 'dark',
					esc_html__( 'Light', 'wolf-visual-composer' ) => 'light',
				),
				'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
				'weight' => 0,
			),
		),
		wvc_background_params(),
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
		array(
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Custom Column Gap', 'wolf-visual-composer' ),
				'param_name' => 'gap',
				'description' => esc_html__( 'The space gap between columns.', 'wolf-visual-composer' ),
				'weight' => -5,
				'std' => '',
				'group' => esc_html__( 'Advanced', 'wolf-visual-composer' ),
			)
		)
	)
);