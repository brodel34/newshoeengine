<?php
/**
 * Count down
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Count Down', 'wolf-visual-composer' ),
		'description' => esc_html__( 'See the seconds tick down', 'wolf-visual-composer' ),
		'base' => 'wvc_countdown',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-bell-o',
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Date', 'wolf-visual-composer' ),
				'param_name' => 'date',
				'description' => sprintf( __( 'formatted like %s', 'wolf-visual-composer' ), '12/24/2020 12:00:00' ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'UTC Timezone offset', 'wolf-visual-composer' ),
				'param_name' => 'offset',
				'placeholder' => '-5',
				'description' => sprintf( __( 'e.g : -5 for NY. <a href="%s" target="_blank">More info</a>.', 'wolf-visual-composer' ), esc_url( 'https://en.wikipedia.org/wiki/List_of_UTC_time_offsets' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Format', 'wolf-visual-composer' ),
				'param_name' => 'format',
				'admin_label' => true,
				'std' => 'dHMS',
				'value' => array(
					esc_html__( 'Auto (show all values as needed)', 'wolf-visual-composer' ) => 'yowdHMS',
					esc_html__( 'By Days', 'wolf-visual-composer' ) => 'dHMS',
					esc_html__( 'By Weeks', 'wolf-visual-composer' ) => 'wdHM',
					esc_html__( 'By Month', 'wolf-visual-composer' ) => 'odHM',
					esc_html__( 'Custom', 'wolf-visual-composer' ) => 'custom',
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Custom Format', 'wolf-visual-composer' ),
				'param_name' => 'custom_format',
				'value' => 'dHMS',
				'description' => sprintf( wvc_kses( __( 'You can check all avalable format codes <a href="%s" target="_blank">here</a>.', 'wolf-visual-composer' ) ), 'http://keith-wood.name/countdown.html' ),
				'dependency' => array(
					'element' => 'format',
					'value' => 'custom',
				),
			),

			array(
				'type' => 'wvc_font_family',
				'heading' => esc_html__( 'Font', 'wolf-visual-composer' ),
				'param_name' => 'font_family',
				'admin_label' => true,
				'group' => esc_html__( 'Number Font', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Font Size', 'wolf-visual-composer' ),
				'param_name' => 'font_size',
				'group' => esc_html__( 'Number Font', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Font Weight', 'wolf-visual-composer' ),
				'param_name' => 'font_weight',
				'placeholder' => 700,
				'group' => esc_html__( 'Number Font', 'wolf-visual-composer' ),
				'std' => apply_filters( 'wvc_default_countdown_font_weight', 700 ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Number Font Color', 'wolf-visual-composer' ),
				'param_name' => 'number_font_color',
				'value' => array_merge(
					array( esc_html__( 'Default color', 'wolf-visual-composer' ) => 'default', ),
					wvc_get_shared_colors(),
					array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
				),
				'group' => esc_html__( 'Colors', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Number Font Custom Color', 'wolf-visual-composer' ),
				'param_name' => 'number_font_custom_color',
				'description' => esc_html__( 'Select custom single pie chart track color.', 'wolf-visual-composer' ),
				'dependency' => array(
					'element' => 'number_font_color',
					'value' => array( 'custom' ),
				),
				'group' => esc_html__( 'Colors', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Font Color', 'wolf-visual-composer' ),
				'param_name' => 'text_font_color',
				'value' => array_merge(
					array( esc_html__( 'Default color', 'wolf-visual-composer' ) => 'default', ),
					wvc_get_shared_colors(),
					array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
				),
				'group' => esc_html__( 'Colors', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Text Font Custom Color', 'wolf-visual-composer' ),
				'param_name' => 'text_font_custom_color',
				'description' => esc_html__( 'Select custom single pie chart track color.', 'wolf-visual-composer' ),
				'dependency' => array(
					'element' => 'text_font_color',
					'value' => array( 'custom' ),
				),
				'group' => esc_html__( 'Colors', 'wolf-visual-composer' ),
			),
		)
	)
);

class WPBakeryShortCode_Wvc_Countdown extends WPBakeryShortCode {}