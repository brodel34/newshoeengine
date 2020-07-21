<?php
/**
 * Accordion tab
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
$icons_params = vc_map_integrate_shortcode( wvc_icon_params(), 'i_', '', array(
	'include_only_regex' => '/^(type|icon_\w*)/',
) );
if ( is_array( $icons_params ) && ! empty( $icons_params ) ) {
	foreach ( $icons_params as $key => $param ) {
		if ( is_array( $param ) && ! empty( $param ) ) {

			if ( 'i_type' == $param['param_name'] ) {
				$icons_params[ $key ]['dependency'] = array(
					'element' => 'add_icon',
					'value' => 'true',
				);
			}
		}
	}
}

vc_map(
	array(
		'name' => esc_html__( 'Section', 'wolf-visual-composer' ),
		'base' => 'vc_accordion_tab',
		'allowed_container_element' => 'vc_row',
		'is_container' => true,
		'content_element' => false,
		'params' => array_merge(
			array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
					'param_name' => 'title',
					'description' => esc_html__( 'Accordion section title.', 'wolf-visual-composer' ),
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Add Icon', 'wolf-visual-composer' ),
					'param_name' => 'add_icon',
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon Color', 'wolf-visual-composer' ),
					'param_name' => 'icon_color',
					'value' => array_merge( wvc_get_shared_colors(), array(
							esc_html__( 'Default color', 'wolf-visual-composer' ) => 'default',
							esc_html__( 'Gradient Red', 'wolf-visual-composer' ) => 'gradient-red',
							esc_html__( 'Gradient Green', 'wolf-visual-composer' ) => 'gradient-green',
							esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom',
						)
					),
					'std' => 'default',
					'description' => esc_html__( 'Select a text color.', 'wolf-visual-composer' ),
					'param_holder_class' => 'wvc_colored-dropdown',
					'group' => esc_html__( 'Colors', 'wolf-visual-composer' ),
				),

				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Icon Color', 'wolf-visual-composer' ),
					'param_name' => 'icon_custom_color',
					'dependency' => array(
						'element' => 'icon_color',
						'value' => 'custom',
					),
					'group' => esc_html__( 'Colors', 'wolf-visual-composer' ),
				),
			),
			$icons_params
		),
		'js_view' => 'VcAccordionTabView',
	)
);