<?php
/**
 * Hover box
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map_update( 'vc_hoverbox', array(
	'icon' => 'fa fa-hand-pointer-o',
) );

vc_remove_param( 'vc_hoverbox', 'primary_title_use_theme_fonts' );
vc_remove_param( 'vc_hoverbox', 'primary_title_google_fonts' );
vc_remove_param( 'vc_hoverbox', 'primary_title_font_container' );
vc_remove_param( 'vc_hoverbox', 'hover_title_use_theme_fonts' );
vc_remove_param( 'vc_hoverbox', 'hover_title_google_fonts' );
vc_remove_param( 'vc_hoverbox', 'hover_title_font_container' );
vc_remove_param( 'vc_hoverbox', 'hover_title_css_animation' );
$button_params = vc_map_integrate_shortcode(
	wvc_button_params(),
	'hover_btn_',
	esc_html( 'Hover Button', 'wolf-visual-composer' ),
	array(
		'exclude' => array(
			'align',
			'button_block',
			'css_animation',
			'css_anmation_delay',
			'css',
		),
	),
	array(
		'element' => 'hover_add_button',
		'value' => 'true',
	)
);

vc_add_params(
	'vc_hoverbox',
	array_merge(
		array(
			array(
				'type' => 'wvc_font_family',
				'heading' => esc_html__( 'Font Family', 'wolf-visual-composer' ),
				'param_name' => 'primary_title_font_family',
				'group' => esc_html__( 'Primary Title', 'wolf-visual-composer' ),
				'dependency' => array(
					'element' => 'use_custom_fonts_primary_title',
					'value' => 'true',
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Font Size', 'wolf-visual-composer' ),
				'param_name' => 'primary_title_font_size',
				'value' => 48,
				'group' => esc_html__( 'Primary Title', 'wolf-visual-composer' ),
				'dependency' => array(
					'element' => 'use_custom_fonts_primary_title',
					'value' => 'true',
				),
			),

			array(
				'type' => 'wvc_font_family',
				'heading' => esc_html__( 'Font Family', 'wolf-visual-composer' ),
				'param_name' => 'hover_title_font_family',
				'group' => esc_html__( 'Hover Title', 'wolf-visual-composer' ),
				'dependency' => array(
					'element' => 'use_custom_fonts_hover_title',
					'value' => 'true',
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Font Size', 'wolf-visual-composer' ),
				'param_name' => 'hover_title_font_size',
				'value' => 48,
				'group' => esc_html__( 'Hover Title', 'wolf-visual-composer' ),
				'dependency' => array(
					'element' => 'use_custom_fonts_hover_title',
					'value' => 'true',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Background Color', 'wolf-visual-composer' ),
				'param_name' => 'hover_background_color',
				'value' => array_merge(
					wvc_get_shared_colors(),
					wvc_get_shared_gradient_colors(),
					array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
				),
				'std' => 'default',
				'description' => esc_html__( 'Select a background color.', 'wolf-visual-composer' ),
				'param_holder_class' => 'wvc_colored-dropdown',
				'group' => esc_html__( 'Hover Block', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Background Color', 'wolf-visual-composer' ),
				'param_name' => 'hover_background_custom_color',
				'dependency' => array(
					'element' => 'hover_background_color',
					'value' => 'custom',
				),
				'group' => esc_html__( 'Hover Block', 'wolf-visual-composer' ),
			),
		),
		$button_params
	) // array_mergae
);