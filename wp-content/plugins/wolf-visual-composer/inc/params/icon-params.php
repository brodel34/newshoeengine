<?php
/**
 * Wolf WPBakery Page Builder Extension icon params
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get icon params
 *
 * @return array
 */
function wvc_icon_params() {

	return array(
		'name' => esc_html__( 'Icon Box', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Icon box from icon library', 'wolf-visual-composer' ),
		'base' => 'vc_icon',
		'icon' => 'fa fa-rocket',
		'category' => esc_html__( 'Content', 'wolf-visual-composer' ),
		'params' => array(

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon Type', 'wolf-visual-composer' ),
				'value' => array(
					esc_html__( 'Icon', 'wolf-visual-composer' ) => 'icon',
					esc_html__( 'Animated Icon', 'wolf-visual-composer' ) => 'animated_icon',
					esc_html__( 'Image', 'wolf-visual-composer' ) => 'image',
				),
				'admin_label' => true,
				'param_name' => 'media_type',
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon library', 'wolf-visual-composer' ),
				'value' => array(
					esc_html__( 'Font Awesome', 'wolf-visual-composer' ) => 'fontawesome',
					esc_html__( 'Linearcons', 'wolf-visual-composer' ) => 'linearicons',
					esc_html__( 'Linea Icons', 'wolf-visual-composer' ) => 'linea-icons',
					esc_html__( 'Elegant Icons', 'wolf-visual-composer' ) => 'elegant-icons',
					esc_html__( 'Ionicons', 'wolf-visual-composer' ) => 'ionicons',
					esc_html__( 'Dripicons', 'wolf-visual-composer' ) => 'dripicons',
					esc_html__( 'Open Iconic', 'wolf-visual-composer' ) => 'openiconic',
					esc_html__( 'Typicons', 'wolf-visual-composer' ) => 'typicons',
					esc_html__( 'Entypo', 'wolf-visual-composer' ) => 'entypo',
					esc_html__( 'Linecons', 'wolf-visual-composer' ) => 'linecons',
					esc_html__( 'Socicon', 'wolf-visual-composer' ) => 'socicon',
					esc_html__( 'Material', 'wolf-visual-composer' ) => 'material',
					esc_html__( 'Wolf Rare Icons', 'wolf-visual-composer' ) => 'wolficons',
				),
				'admin_label' => true,
				'param_name' => 'type',
				'description' => esc_html__( 'Select icon library.', 'wolf-visual-composer' ),
				'dependency' => array(
					'element' => 'media_type',
					'value' => 'icon',
				),
				'std' => apply_filters( 'wvc_default_icon_font', 'fontawesome' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wolf-visual-composer' ),
				'param_name' => 'icon_fontawesome',
				'value' => 'fa fa-cog',
				'settings' => array(
					'emptyIcon' => false,
					'iconsPerPage' => 4000,
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'fontawesome',
				),
				'description' => esc_html__( 'Select icon from library.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wolf-visual-composer' ),
				'param_name' => 'icon_linearicons',
				'value' => 'lnr-sun',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'linearicons',
					'iconsPerPage' => 4000,
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'linearicons',
				),
				'description' => esc_html__( 'Select icon from library.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wolf-visual-composer' ),
				'param_name' => 'icon_linea-icons',
				'value' => 'linea-basic-gear',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'linea-icons',
					'iconsPerPage' => 4000,
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'linea-icons',
				),
				'description' => esc_html__( 'Select icon from library.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wolf-visual-composer' ),
				'param_name' => 'icon_elegant-icons',
				'value' => 'ei-genius',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'elegant-icons',
					'iconsPerPage' => 4000,
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'elegant-icons',
				),
				'description' => esc_html__( 'Select icon from library.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wolf-visual-composer' ),
				'param_name' => 'icon_ionicons',
				'value' => 'ion-android-car',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'ionicons',
					'iconsPerPage' => 4000,
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'ionicons',
				),
				'description' => esc_html__( 'Select icon from library.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Dripicons', 'wolf-visual-composer' ),
				'param_name' => 'icon_dripicons',
				'value' => 'dripicons-browser',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'dripicons',
					'iconsPerPage' => 4000,
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'dripicons',
				),
				'description' => esc_html__( 'Select icon from library.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wolf-visual-composer' ),
				'param_name' => 'icon_openiconic',
				'value' => 'vc-oi vc-oi-dial',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'openiconic',
					'iconsPerPage' => 4000,
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'openiconic',
				),
				'description' => esc_html__( 'Select icon from library.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wolf-visual-composer' ),
				'param_name' => 'icon_typicons',
				'value' => 'typcn typcn-adjust-brightness',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'typicons',
					'iconsPerPage' => 4000,
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'typicons',
				),
				'description' => esc_html__( 'Select icon from library.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wolf-visual-composer' ),
				'param_name' => 'icon_entypo',
				'value' => 'entypo-icon entypo-icon-note',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'entypo',
					'iconsPerPage' => 4000,
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'entypo',
				),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wolf-visual-composer' ),
				'param_name' => 'icon_linecons',
				'value' => 'vc_li vc_li-heart',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'linecons',
					'iconsPerPage' => 4000,
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'linecons',
				),
				'description' => esc_html__( 'Select icon from library.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wolf-visual-composer' ),
				'param_name' => 'icon_monosocial',
				'value' => 'vc-mono vc-mono-fivehundredpx',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'monosocial',
					'iconsPerPage' => 4000,
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'monosocial',
				),
				'description' => esc_html__( 'Select icon from library.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wolf-visual-composer' ),
				'param_name' => 'icon_socicon',
				'value' => 'vc-mono vc-mono-fivehundredpx',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'socicon',
					'iconsPerPage' => 4000,
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'socicon',
				),
				'description' => esc_html__( 'Select icon from library.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wolf-visual-composer' ),
				'param_name' => 'icon_material',
				'value' => 'vc-material vc-material-cake',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'material',
					'iconsPerPage' => 4000,
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'material',
				),
				'description' => esc_html__( 'Select icon from library.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wolf-visual-composer' ),
				'param_name' => 'icon_wolficons',
				'value' => 'wolf-icon-wolfthemes',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'wolficons',
					'iconsPerPage' => 4000,
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'wolficons',
				),
				'description' => esc_html__( 'Select icon from library.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Icon Image', 'wolf-visual-composer' ),
				'param_name' => 'image_id',
				'dependency' => array(
					'element' => 'media_type',
					'value' => 'image',
				),
			),

			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'wolf-visual-composer' ),
				'param_name' => 'animated_icon_lineaicons',
				'value' => 'linea-basic-gear',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'linea-icons',
					'iconsPerPage' => 4000,
				),
				'dependency' => array(
					'element' => 'media_type',
					'value' => 'animated_icon',
				),
				'description' => esc_html__( 'Select icon from library.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon color', 'wolf-visual-composer' ),
				'param_name' => 'animated_icon_color',
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
					'element' => 'media_type',
					'value' => 'animated_icon',
				),
			),

			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Custom color', 'wolf-visual-composer' ),
				'param_name' => 'animated_icon_custom_color',
				'description' => esc_html__( 'Select custom icon color.', 'wolf-visual-composer' ),
				'dependency' => array(
					'element' => 'animated_icon_color',
					'value' => 'custom',
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
					esc_html__( 'Ban', 'wolf-visual-composer' ) => 'ban',
				),
				'description' => esc_html__( 'Select background shape and style for icon.', 'wolf-visual-composer' ),
				'dependency' => array(
					'element' => 'media_type',
					'value' => 'icon',
				),
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
				'value' => array_merge( wvc_get_shared_colors(), array(
						esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom',
					)
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
					'value_not_equal_to' => array( 'none' ),
				),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Position', 'wolf-visual-composer' ),
				'param_name' => 'position',
				'value' => array(
					esc_html__( 'Top', 'wolf-visual-composer' ) => 'top',
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Left from Title', 'wolf-visual-composer' ) => 'left_from_title',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
					esc_html__( 'Right from Title', 'wolf-visual-composer' ) => 'right_from_title',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Container Alignement', 'wolf-visual-composer' ),
				'param_name' => 'container_alignement',
				'value' => array(
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
				),
				'dependency' => array( 'element' => 'position', 'value' => array( 'left_from_title' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Alignement', 'wolf-visual-composer' ),
				'param_name' => 'text_alignement',
				'value' => array(
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
				),
				'dependency' => array( 'element' => 'position', 'value' => array( 'top' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Size', 'wolf-visual-composer' ),
				'param_name' => 'size',
				'value' => array(
					esc_html__( 'Small', 'wolf-visual-composer' ) => 'fa-2x',
					esc_html__( 'Medium', 'wolf-visual-composer' ) => 'fa-3x',
					esc_html__( 'Large', 'wolf-visual-composer' ) => 'fa-4x',
					esc_html__( 'Very Large', 'wolf-visual-composer' ) => 'fa-5x',
					esc_html__( 'Tiny', 'wolf-visual-composer' ) => 'fa-1x',
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
				'param_name' => 'title',
				'placeholder' => esc_html__( 'My title', 'wolf-visual-composer' ),
				'admin_label' => true,
				'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Title Font Size', 'wolf-visual-composer' ),
				'param_name' => 'title_font_size',
				'placeholder' => '18px',
				'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_font_family',
				'heading' => esc_html__( 'Title Font Family', 'wolf-visual-composer' ),
				'param_name' => 'title_font_family',
				'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Transform', 'wolf-visual-composer' ),
				'param_name' => 'title_text_transform',
				'value' => array(
					esc_html__( 'Default', 'wolf-visual-composer' ) => '',
					esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
					esc_html__( 'Uppercase', 'wolf-visual-composer' ) => 'uppercase',
				),
				'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Title Tag', 'wolf-visual-composer' ),
				'param_name' => 'title_tag',
				'value' => array(
					'h3',
					'h1',
					'h2',
					'h4',
					'h5',
					'h6',
					'span',
				),
				'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Title Letter Spacing', 'wolf-visual-composer' ),
				'param_name' => 'title_letter_spacing',
				'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Text', 'wolf-visual-composer' ),
				'param_name' => 'text',
				'admin_label' => true,
				'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Link', 'wolf-visual-composer' ),
				'param_name' => 'link',
				'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Scroll to anchor?', 'wolf-visual-composer' ),
				'param_name' => 'scroll_to_anchor',
				'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
			),
		),
		'js_view' => 'VcIconElementView_Backend',
	);
}