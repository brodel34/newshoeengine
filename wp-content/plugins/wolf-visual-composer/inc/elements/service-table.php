<?php
/**
 * Service table
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
$icons_params = vc_map_integrate_shortcode( wvc_icon_params(), 'i_', '', array(
	'include_only_regex' => '/^(type|icon_\w*)/',
), array(
	'element' => 'add_icon',
	'value' => 'true',
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

			if ( isset( $param['admin_label'] ) ) {
				unset( $icons_params[ $key ]['admin_label'] );
			}
		}
	}
}
vc_map(
	array(
		'name' => esc_html__( 'Service Table', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Show what your business is about', 'wolf-visual-composer' ),
		'base' => 'wvc_service_table',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-pressthis',
		'params' => array_merge(
			array(
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Services', 'wolf-visual-composer' ),
					'param_name' => 'services',
					'description' => esc_html__( 'Enter one service per line.' ),
					'admin_label' => true,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
					'param_name' => 'title',
					'admin_label' => true
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title Tag', 'wolf-visual-composer' ),
					'param_name' => 'title_tag',
					'value' => array(
						'h3',
						'span',
						'h1',
						'h2',
						'h4',
						'h5',
						'h6',
					),
				),

				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Link', 'wolf-visual-composer' ),
					'param_name' => 'link',
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Add icon?', 'wolf-visual-composer' ),
					'param_name' => 'add_icon',
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Background Color', 'wolf-visual-composer' ),
					'param_name' => 'background_color',
					'value' => array_merge(
						array( esc_html__( 'Default', 'wolf-visual-composer' ) => 'default', ),
						wvc_get_shared_colors(),
						array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
					),
					'param_holder_class' => 'wvc_colored-dropdown',
					'group' => esc_html( 'Style', 'wolf-visual-composer' ),
				),

				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Background Color', 'wolf-visual-composer' ),
					'param_name' => 'background_custom_color',
					'group' => esc_html__( 'Color', 'wolf-visual-composer' ),
					'dependency' => array(
						'element' => 'background_color',
						'value' => 'custom',
					),
				),

				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Background Image', 'wolf-visual-composer' ),
					'param_name' => 'background_image',
					'admin_label' => true,
					'group' => esc_html( 'Style', 'wolf-visual-composer' ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Text Color', 'wolf-visual-composer' ),
					'param_name' => 'font_color',
					'value' => array_merge(
						array( esc_html__( 'Default', 'wolf-visual-composer' ) => 'default', ),
						wvc_get_shared_colors(),
						array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
					),
					'param_holder_class' => 'wvc_colored-dropdown',
					'group' => esc_html( 'Style', 'wolf-visual-composer' ),
				),

				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Text Color', 'wolf-visual-composer' ),
					'param_name' => 'font_custom_color',
					'group' => esc_html__( 'Color', 'wolf-visual-composer' ),
					'dependency' => array(
						'element' => 'font_color',
						'value' => 'custom',
					),
				),
			),
			$icons_params
		),
	)
);

class WPBakeryShortCode_Wvc_Service_Table extends WPBakeryShortCode {}