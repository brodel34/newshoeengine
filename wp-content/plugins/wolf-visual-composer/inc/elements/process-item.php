<?php
/**
 * Process
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

			if ( ! isset( $param['group'] ) ) {
			}

			if ( isset( $param['admin_label'] ) ) {
			}

			if ( 'i_type' == $param['param_name'] ) {
				$icons_params[ $key ]['dependency'] = array(
					'element' => 'type',
					'value' => 'icon',
				);
			}
		}
	}
}
vc_map(
	array(
		'name' => esc_html__( 'Process Item', 'wolf-visual-composer' ),
		'base' => 'wvc_process_item',
		'as_child' => array( 'only' => 'wvc_process_container' ),
		'category' => esc_html__( 'Content', 'wolf-visual-composer' ),
		'icon' => 'fa fa-lightbulb-o',
		'params' => array_merge(
			array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Type', 'wolf-visual-composer' ),
					'param_name' => 'type',
					'value' => array(
						esc_html__( 'Icon', 'wolf-visual-composer' ) => 'icon',
						esc_html__( 'Number', 'wolf-visual-composer' ) => 'number',
						esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
					),
				),
			),
			$icons_params,
			array(
				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
					'param_name' => 'title',
					'value' => esc_html__( 'My title', 'wolf-visual-composer' ),
					'admin_label' => true,
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
					'type' => 'textarea',
					'heading' => esc_html__( 'Text', 'wolf-visual-composer' ),
					'param_name' => 'text',
					'placeholder' => esc_html__( 'Optional description text', 'wolf-visual-composer' ),
					'admin_label' => true,
				),

				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Link', 'wolf-visual-composer' ),
					'param_name' => 'link',
				),

				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Background Image', 'wolf-visual-composer' ),
					'param_name' => 'background_image',
					'admin_label' => true,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Graphic Color', 'wolf-visual-composer' ),
					'param_name' => 'color',
					'value' => array_merge(
						array( esc_html__( 'Default', 'wolf-visual-composer' ) => 'default', ),
						wvc_get_shared_colors(),
						array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
					),
					'param_holder_class' => 'wvc_colored-dropdown',
				),

				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Graphic Custom Color', 'wolf-visual-composer' ),
					'param_name' => 'custom_color',
					'dependency' => array(
						'element' => 'color',
						'value' => 'custom',
					),
				),
			)
		),
	)
);

class WPBakeryShortCode_Wvc_Process_Item extends WPBakeryShortCode {}