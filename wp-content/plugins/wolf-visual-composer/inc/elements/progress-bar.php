<?php
/**
 * Progress bar
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/* Removing parameters */
vc_remove_param( 'vc_progress_bar', 'customtxtcolor' );

vc_map(
	array(
		'name' => esc_html__( 'Progress Bar', 'wolf-visual-composer' ),
		'base' => 'vc_progress_bar',
		'icon' => 'fa fa-tasks',
		'category' => esc_html__( 'Content', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Animated progress bar', 'wolf-visual-composer' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Widget title', 'wolf-visual-composer' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'param_group',
				'heading' => esc_html__( 'Values', 'wolf-visual-composer' ),
				'param_name' => 'values',
				'description' => esc_html__( 'Enter values for graph - value, title and color.', 'wolf-visual-composer' ),
				'value' => urlencode( json_encode( array(
					array(
						'label' => esc_html__( 'Development', 'wolf-visual-composer' ),
						'value' => '90',
					),
					array(
						'label' => esc_html__( 'Design', 'wolf-visual-composer' ),
						'value' => '80',
					),
					array(
						'label' => esc_html__( 'Marketing', 'wolf-visual-composer' ),
						'value' => '70',
					),
				) ) ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Label', 'wolf-visual-composer' ),
						'param_name' => 'label',
						'description' => esc_html__( 'Enter text used as title of bar.', 'wolf-visual-composer' ),
						'admin_label' => true,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Value', 'wolf-visual-composer' ),
						'param_name' => 'value',
						'description' => esc_html__( 'Enter value of bar.', 'wolf-visual-composer' ),
						'admin_label' => true,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Color', 'wolf-visual-composer' ),
						'param_name' => 'color',
						'value' => array_merge(
							array( esc_html__( 'Default', 'wolf-visual-composer' ) => 'default', ),
							wvc_get_shared_colors(),
							wvc_get_shared_gradient_colors(),
							array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
						),
						'description' => esc_html__( 'Select single bar background color.', 'wolf-visual-composer' ),
						'admin_label' => true,
						'param_holder_class' => 'wvc_colored-dropdown',
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Custom color', 'wolf-visual-composer' ),
						'param_name' => 'customcolor',
						'description' => esc_html__( 'Select custom single bar background color.', 'wolf-visual-composer' ),
						'dependency' => array(
							'element' => 'color',
							'value' => array( 'custom' ),
						),
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Custom text color', 'wolf-visual-composer' ),
						'param_name' => 'customtxtcolor',
						'description' => esc_html__( 'Select custom single bar text color.', 'wolf-visual-composer' ),
						'dependency' => array(
							'element' => 'color',
							'value' => array( 'custom' ),
						),
					),
				),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Units', 'wolf-visual-composer' ),
				'param_name' => 'units',
				'description' => esc_html__( 'Enter measurement units (Example: %, px, points, etc. Note: graph value and units will be appended to graph title).', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Color', 'wolf-visual-composer' ),
				'param_name' => 'bgcolor',
				'value' => array_merge(
					wvc_get_shared_colors(),
					wvc_get_shared_gradient_colors(),
					array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
				),
				'description' => esc_html__( 'Select bar background color.', 'wolf-visual-composer' ),
				'admin_label' => true,
				'param_holder_class' => 'wvc_colored-dropdown',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Bar custom background color', 'wolf-visual-composer' ),
				'param_name' => 'custombgcolor',
				'description' => esc_html__( 'Select custom background color for bars.', 'wolf-visual-composer' ),
				'dependency' => array(
					'element' => 'bgcolor',
					'value' => array( 'custom' ),
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Bar custom text color', 'wolf-visual-composer' ),
				'param_name' => 'customtxtcolor',
				'description' => esc_html__( 'Select custom text color for bars.', 'wolf-visual-composer' ),
				'dependency' => array(
					'element' => 'bgcolor',
					'value' => array( 'custom' ),
				),
			),
		),
	)
);