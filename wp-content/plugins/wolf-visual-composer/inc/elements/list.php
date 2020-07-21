<?php
/**
 * List
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
				$icons_params[ $key ]['dependency'] = array();
			}

			if ( 'i_icon_fontawesome' == $param['param_name'] ) {
				$icons_params[ $key ]['value'] = 'fa fa-angle-right';
			}

			if ( isset( $param['admin_label'] ) ) {
				unset( $icons_params[ $key ]['admin_label'] );
			}
		}
	}
}

vc_map(
	array(
		'name' => esc_html__( 'List', 'wolf-visual-composer' ),
		'base' => 'wvc_list',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'description' => esc_html__( 'List with icon', 'wolf-visual-composer' ),
		'icon' => 'fa fa-list',
		'params' => array_merge(
			array(
				array(
					'type' => 'textarea_html',
					'heading' => esc_html__( 'List text', 'wolf-visual-composer' ) ,
					'param_name' => 'content',
					'value' => '<ul><li>Item #1</li><li>Item #2</li></ul>',
					'admin_label' => true,
				),
			),
			$icons_params,
			array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon color', 'wolf-visual-composer' ),
					'param_name' => 'icon_color',
					'value' => array_merge(
						array(
							esc_html__( 'Default color', 'wolf-visual-composer' ) => 'default',
						),
						wvc_get_shared_colors(),
						array(
							esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom',
						)
					),
					'description' => esc_html__( 'Select icon color.', 'wolf-visual-composer' ),
					'param_holder_class' => 'wvc_colored-dropdown',
				),

				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Custom color', 'wolf-visual-composer' ),
					'param_name' => 'icon_custom_color',
					'description' => esc_html__( 'Select custom icon color.', 'wolf-visual-composer' ),
					'dependency' => array(
						'element' => 'icon_color',
						'value' => 'custom',
					),
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show icon on hover', 'wolf-visual-composer' ),
					'param_name' => 'icon_animate',
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide Icon', 'wolf-visual-composer' ),
					'param_name' => 'hide_icon',
				),
			)
		)
	)
);

class WPBakeryShortCode_Wvc_List extends WPBakeryShortCode {}