<?php
/**
 * Process container
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
				unset( $icons_params[ $key ]['admin_label'] );
			}
		}
	}
}
vc_map(
	array(
		'name' => esc_html__( 'Process', 'wolf-visual-composer' ),
		'base' => 'wvc_process_container',
		'as_parent' => array( 'only' => 'wvc_process_item' ),
		'content_element' => true,
		'description' => esc_html__( 'Your step-by-step way of working', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-lightbulb-o',
		'show_settings_on_create' => true,
		'params' => array(
			array(
				'type' => 'wvc_help',
				'heading' => '',
				'param_name' => 'help',
				'value' => sprintf(
					esc_html__( 'It is recommended to insert %1$d to %2$d process elements and use the standard width for the parent row.', 'wolf-visual-composer' ),
					3,
					5
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Layout', 'wolf-visual-composer' ),
				'param_name' => 'layout',
				'value' => array(
					esc_html__( 'Horizontal', 'wolf-visual-composer' ) => 'horizontal',
					esc_html__( 'Vertical', 'wolf-visual-composer' ) => 'vertical',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Size', 'wolf-visual-composer' ),
				'param_name' => 'size',
				'value' => array(
					esc_html__( 'Medium', 'wolf-visual-composer' ) => 'medium',
					esc_html__( 'Small', 'wolf-visual-composer' ) => 'small',
					esc_html__( 'Large', 'wolf-visual-composer' ) => 'large',
					esc_html__( 'Extra Large', 'wolf-visual-composer' ) => 'extra-large',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Show Joining Line', 'wolf-visual-composer' ),
				'param_name' => 'show_line',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'no',
				),
			),
		),
		'js_view' => 'VcColumnView',
	)
);

class WPBakeryShortCode_Wvc_Process_Container extends WPBakeryShortCodesContainer {}