<?php
/**
 * Interactive Overlays
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Interactive Overlays', 'wolf-visual-composer' ),
		'base' => 'wvc_interactive_overlays',
		'as_parent' => array( 'only' => 'wvc_interactive_overlay_item' ),
		'show_settings_on_create' => false,
		'content_element' => true,
		'description' => esc_html__( 'Show image on hover', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-television',
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Alignment', 'wolf-visual-composer' ),
				'param_name' => 'align',
				'value' => array(
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Vertical Alignment', 'wolf-visual-composer' ),
				'param_name' => 'v_align',
				'value' => array(
					esc_html__( 'Middle', 'wolf-visual-composer' ) => 'middle',
					esc_html__( 'Bottom', 'wolf-visual-composer' ) => 'bottom',
					esc_html__( 'Top', 'wolf-visual-composer' ) => 'top',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Display', 'wolf-visual-composer' ),
				'param_name' => 'display',
				'value' => array(
					esc_html__( 'Block', 'wolf-visual-composer' ) => 'block',
					esc_html__( 'Inline', 'wolf-visual-composer' ) => 'inline-block',
				),
			),

			array(
				'type' => 'wvc_font_family',
				'heading' => esc_html__( 'Font', 'wolf-visual-composer' ),
				'param_name' => 'font_family',
				'admin_label' => true,
				'group' => esc_html__( 'Font', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Font Size', 'wolf-visual-composer' ),
				'param_name' => 'font_size',
				'group' => esc_html__( 'Font', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Font Weight', 'wolf-visual-composer' ),
				'param_name' => 'font_weight',
				'placeholder' => 700,
				'group' => esc_html__( 'Font', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Transform', 'wolf-visual-composer' ),
				'param_name' => 'text_transform',
				'value' => array(
					esc_html__( 'Default', 'wolf-visual-composer' ) => '',
					esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
					esc_html__( 'Uppercase', 'wolf-visual-composer' ) => 'uppercase',
				),
				'group' => esc_html__( 'Font', 'wolf-visual-composer' ),
			),

		),
		'js_view' => 'VcColumnView',
	)
);

class WPBakeryShortCode_Wvc_Interactive_Overlays extends WPBakeryShortCodesContainer {}