<?php
/**
 * Column
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Column', 'wolf-visual-composer' ) ,
		'base' => 'vc_column',
		'is_container' => true,
		'content_element' => false,
		'params' => array_merge(
			wvc_column_general_params(),
			array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Skin Tone', 'wolf-visual-composer' ),
					'param_name' => 'font_color',
					'value' => array(
						esc_html__( 'Inherit', 'wolf-visual-composer' ) => 'inherit',
						esc_html__( 'Light', 'wolf-visual-composer' ) => 'dark',
						esc_html__( 'Dark', 'wolf-visual-composer' ) => 'light',
					),
					'group' => esc_html__( 'Style', 'wolf-visual-composer' ),
					'weight' => 0,
				)
			),
			wvc_background_params(),
			array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Border Color', 'wolf-visual-composer' ),
					'param_name' => 'border_color',
					'value' => array_merge(
						array( esc_html__( 'None', 'wolf-visual-composer' ) => 'none', ),
						wvc_get_shared_gradient_colors(),
						wvc_get_shared_colors(),
						array( esc_html__( 'Transparent', 'wolf-visual-composer' ) => 'transparent', ),
						array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
					),
					'param_holder_class' => 'wvc_colored-dropdown',
					'group' => esc_html__( 'Custom', 'wolf-visual-composer' ),
					'weight' => -100,
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
					'weight' => -100,
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
					'weight' => -100,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Inline Style', 'wolf-visual-composer' ),
					'param_name' => 'inline_style',
					'group' => esc_html__( 'Custom', 'wolf-visual-composer' ),
					'description' => sprintf( esc_html__( 'Additional inline CSS that will be applied to the element. (e.g: %s)', 'wolf-visual-composer' ), 'color:red;' ),
					'weight' => -100,
				),
			),
			array(
				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Custom Link', 'wolf-visual-composer' ),
					'param_name' => 'link',
					'group' => esc_html__( 'Extra', 'wolf-visual-composer' ),
					'weight' => -100,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Link Extra Class', 'wolf-visual-composer' ),
					'param_name' => 'link_extra_class',
					'group' => esc_html__( 'Extra', 'wolf-visual-composer' ),
					'weight' => -100,
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Sticky', 'wolf-visual-composer' ),
					'param_name' => 'sticky',
					'description' => esc_html__( 'Check this option to stick the element at the top when scrolling. Note that this feature doesn\'t work if your row is set to "equal height" columns.', 'wolf-visual-composer' ),
					'group' => esc_html__( 'Extra', 'wolf-visual-composer' ),
					'weight' => -100,
				)
			)
		),
		'js_view' => 'VcColumnView',
	)
);
