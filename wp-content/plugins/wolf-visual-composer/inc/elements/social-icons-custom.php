<?php
/**
 * Social icons custom
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$social_icons_params = vc_map_integrate_shortcode(
	'wvc_social_icons',
	'',
	'',
	array(
		'exclude' => array(
			'services',
		),
	)
);

$social_icons_params = array();
vc_map(
	array(
		'name' => esc_html__( 'Social Icons Custom', 'wolf-visual-composer' ),
		'base' => 'wvc_social_icons_custom',
		'icon' => 'fa fa-share-alt',
		'description' => esc_html__( 'A set of icons with custom URLs', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Social', 'wolf-visual-composer' ),
		'params' => array_merge( $social_icons_params, array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Alignment', 'wolf-visual-composer' ),
				'param_name' => 'alignment',
				'value' => array(
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
				),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Target', 'wolf-visual-composer' ),
				'param_name' => 'target',
				'value' => array(
					esc_html__( 'Same window', 'wolf-visual-composer' ) => '_self',
					esc_html__( 'New window', 'wolf-visual-composer' ) => '_blank',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Background shape', 'wolf-visual-composer' ),
				'param_name' => 'background_style',
				'value' => array(
					esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
					esc_html__( 'Circle', 'wolf-visual-composer' ) => 'rounded',
					esc_html__( 'Square', 'wolf-visual-composer' ) => 'boxed',
					esc_html__( 'Rounded', 'wolf-visual-composer' ) => 'rounded-less',
					esc_html__( 'Outline Circle', 'wolf-visual-composer' ) => 'rounded-outline',
					esc_html__( 'Outline Square', 'wolf-visual-composer' ) => 'boxed-outline',
					esc_html__( 'Outline Rounded', 'wolf-visual-composer' ) => 'rounded-less-outline',
				),
				'description' => esc_html__( 'Select background shape and style for icon.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon color', 'wolf-visual-composer' ),
				'param_name' => 'color',
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
				'dependency' => array(
					'element' => 'background_style',
					'value' => 'none',
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Custom color', 'wolf-visual-composer' ),
				'param_name' => 'custom_color',
				'description' => esc_html__( 'Select custom icon color.', 'wolf-visual-composer' ),
				'dependency' => array(
					'element' => 'color',
					'value' => 'custom',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Background color', 'wolf-visual-composer' ),
				'param_name' => 'background_color',
				'value' => array_merge(
					array( esc_html__( 'Default color', 'wolf-visual-composer' ) => 'default', ),
					wvc_get_shared_colors(),
					array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
				),
				'description' => esc_html__( 'Select background color for icon.', 'wolf-visual-composer' ),
				'param_holder_class' => 'wvc_colored-dropdown',
				'dependency' => array(
					'element' => 'background_style',
					'value_not_equal_to' => array( 'none' ),
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Custom background color', 'wolf-visual-composer' ),
				'param_name' => 'custom_background_color',
				'description' => esc_html__( 'Select custom icon background color.', 'wolf-visual-composer' ),
				'dependency' => array(
					'element' => 'background_color',
					'value' => 'custom',
				),
			),
			
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Size', 'wolf-visual-composer' ),
				'param_name' => 'size',
				'value' => array(
					esc_html__( 'Tiny', 'wolf-visual-composer' ) => 'fa-1x',
					esc_html__( 'Small', 'wolf-visual-composer' ) => 'fa-2x',
					esc_html__( 'Medium', 'wolf-visual-composer' ) => 'fa-3x',
					esc_html__( 'Large', 'wolf-visual-composer' ) => 'fa-4x',
					esc_html__( 'Very Large', 'wolf-visual-composer' ) => 'fa-5x',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Hover Transition', 'wolf-visual-composer' ),
				'param_name' => 'hover_effect',
				'value' => array(
					esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
					esc_html__( 'Opacity', 'wolf-visual-composer' ) => 'opacity',
					esc_html__( 'Inset border', 'wolf-visual-composer' ) => 'border-inset',
					esc_html__( 'Sonar', 'wolf-visual-composer' ) => 'sonar',
					esc_html__( 'Fill', 'wolf-visual-composer' ) => 'fill',
					esc_html__( 'Pop', 'wolf-visual-composer' ) => 'pop',
					esc_html__( 'Rotate', 'wolf-visual-composer' ) => 'rotate',
				),
				'dependency' => array(
					'element' => 'background_style',
					'not_empty' => true,
				),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Direction', 'wolf-visual-composer' ),
				'param_name' => 'direction',
				'std' => 'horizontal',
				'value' => array(
					esc_html__( 'Horizontal', 'wolf-visual-composer' ) => 'horizontal',
					esc_html__( 'Vertical', 'wolf-visual-composer' ) => 'vertical',
				),
				'admin_label' => true,
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Animate Icons One By One', 'wolf-visual-composer' ),
				'param_name' => 'css_animation_each',
				'group' => esc_html__( 'Animation', 'wolf-visual-composer' ),
				'weight' => -5,
			),
		) )
	)
);

$add_params = array();
$socials = wvc_get_socials();

foreach ( $socials as $social ) {
	
	$add_params[] = array(
		'type' => 'textfield',
		'heading' => ucfirst( $social ),
		'param_name' => $social,
		'group' => esc_html__( 'Socials', 'wolf-visual-composer' ),
		'weight' => 1000,
	);


}
vc_add_params( 'wvc_social_icons_custom', $add_params );

class WPBakeryShortCode_Wvc_Social_Icons_Custom extends WPBakeryShortCode {}