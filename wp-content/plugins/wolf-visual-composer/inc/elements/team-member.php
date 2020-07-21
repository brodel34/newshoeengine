<?php
/**
 * Team member
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => apply_filters( 'wvc_team_member_title', esc_html__( 'Team Member', 'wolf-visual-composer' ) ),
		'base' => 'wvc_team_member',
		'icon' => 'fa fa-user',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'description' => apply_filters( 'wvc_team_member_description', esc_html__( 'Present your staff members', 'wolf-visual-composer' ) ),
		'params' => array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Photo', 'wolf-visual-composer' ),
				'param_name' => 'image_id',
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Image Size', 'wolf-visual-composer' ),
				'param_name' => 'img_size',
				'value' => wvc_get_image_sizes(),
				'description' => esc_html__( 'You can set the "large", "medium" and "thumbnail" sizes in the WP media settings.', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Custom Image Size', 'wolf-visual-composer' ),
				'param_name' => 'custom_img_size',
				'description' => esc_html__( 'Enter size in pixels (Example: 200x100 (Width x Height).', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'img_size', 'value' => array( 'custom' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Layout', 'wolf-visual-composer' ),
				'param_name' => 'layout',
				'value' => array(
					esc_html__( 'Standard', 'wolf-visual-composer' ) => 'standard',
					esc_html__( 'Overlay', 'wolf-visual-composer' ) => 'overlay',
					esc_html__( 'Flip Box', 'wolf-visual-composer' ) => 'flip-box',
				),
				'std' => apply_filters( 'wvc_default_team_member_layout', 'standard' ),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Overlay Color', 'wolf-visual-composer' ),
				'param_name' => 'overlay_color',
				'value' => array_merge(
						array( esc_html__( 'Auto', 'wolf-visual-composer' ) => 'auto', ),
						wvc_get_shared_colors(),
						wvc_get_shared_gradient_colors(),
						array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
				),
				'std' => apply_filters( 'wvc_default_item_overlay_color', 'black' ),
				'description' => esc_html__( 'Select an overlay color.', 'wolf-visual-composer' ),
				'param_holder_class' => 'wvc_colored-dropdown',
				'dependency' => array( 'element' => 'layout', 'value' => array( 'overlay', 'flip-box' ) ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Overlay Custom Color', 'wolf-visual-composer' ),
				'param_name' => 'overlay_custom_color',
				'dependency' => array( 'element' => 'overlay_color', 'value' => array( 'custom' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Overlay Text Color', 'wolf-visual-composer' ),
				'param_name' => 'overlay_text_color',
				'value' => array_merge(
						array( esc_html__( 'Auto', 'wolf-visual-composer' ) => 'auto', ),
						wvc_get_shared_colors()
				),
				'std' => apply_filters( 'wvc_default_item_overlay_text_color', 'white' ),
				'description' => esc_html__( 'Select an overlay color.', 'wolf-visual-composer' ),
				'param_holder_class' => 'wvc_colored-dropdown',
				'dependency' => array( 'element' => 'layout', 'value' => array( 'overlay', 'flip-box' ) ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Overlay Text Custom Color', 'wolf-visual-composer' ),
				'param_name' => 'overlay_text_custom_color',
				'dependency' => array( 'element' => 'overlay_text_color', 'value' => array( 'custom' ) ),
			),
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Overlay Opacity in Percent', 'wolf-visual-composer' ),
				'param_name' => 'overlay_opacity',
				'description' => '',
				'std' => apply_filters( 'wvc_default_item_overlay_opacity', 40 ),
				'dependency' => array( 'element' => 'layout', 'value' => array( 'overlay', 'flip-box' ) ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Name', 'wolf-visual-composer' ),
				'param_name' => 'name',
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Role', 'wolf-visual-composer' ),
				'param_name' => 'role',
				'admin_label' => true,
			),

			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Description', 'wolf-visual-composer' ),
				'param_name' => 'tagline',
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Alignment', 'wolf-visual-composer' ),
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
				'heading' => esc_html__( 'Text Vertical Alignment', 'wolf-visual-composer' ),
				'param_name' => 'v_alignment',
				'value' => array(
					esc_html__( 'Middle', 'wolf-visual-composer' ) => 'middle',
					esc_html__( 'Bottom', 'wolf-visual-composer' ) => 'bottom',
					esc_html__( 'Top', 'wolf-visual-composer' ) => 'top',
				),
				'admin_label' => true,
				'dependency' => array( 'element' => 'layout', 'value' => array( 'overlay', 'flip-box' ) ),
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
				'admin_label' => true,
			),

			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Link', 'wolf-visual-composer' ),
				'param_name' => 'link',
				'placeholder' => 'http://',
			),

			array(
				'type' => 'wvc_font_family',
				'heading' => esc_html__( 'Font', 'wolf-visual-composer' ),
				'param_name' => 'title_font_family',
				'admin_label' => true,
				'std' => apply_filters( 'wvc_default_team_member_title_font_family', '' ),
				'group' => esc_html__( 'Title Font', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Font Size', 'wolf-visual-composer' ),
				'param_name' => 'title_font_size',
				'value' => apply_filters( 'wvc_default_team_member_title_font_size', '' ),
				'placeholder' => apply_filters( 'wvc_default_team_member_title_font_size', '' ),
				'group' => esc_html__( 'Title Font', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Font Weight', 'wolf-visual-composer' ),
				'param_name' => 'title_font_weight',
				'value' => apply_filters( 'wvc_default_team_member_title_font_weight', '' ),
				'placeholder' => 700,
				'group' => esc_html__( 'Title Font', 'wolf-visual-composer' ),
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
				'std' => apply_filters( 'wvc_default_team_member_title_text_transform', '' ),
				'group' => esc_html__( 'Title Font', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Font Style', 'wolf-visual-composer' ),
				'param_name' => 'title_font_style',
				'value' => array(
					esc_html__( 'Default', 'wolf-visual-composer' ) => '',
					esc_html__( 'Italic', 'wolf-visual-composer' ) => 'italic',
				),
				'group' => esc_html__( 'Title Font', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Letter Spacing', 'wolf-visual-composer' ),
				'param_name' => 'title_letter_spacing',
				'value' => apply_filters( 'wvc_default_team_member_title_letter_spacing', '' ),
				'group' => esc_html__( 'Title Font', 'wolf-visual-composer' ),
			),
		)
	)
);

vc_add_param( 'wvc_team_member', array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Add Social Profiles', 'wolf-visual-composer' ),
		'param_name' => 'show_socials',
	)
);

$add_params = array();
foreach ( wvc_get_team_member_socials() as $social ) {
	$add_params[] = array(
		'type' => 'wvc_textfield',
		'heading' => $social,
		'param_name' => $social,
		'placeholder' => 'http://',
		'dependency' => array(
			'element' => 'show_socials',
			'value' => 'true',
		),
		'group' => esc_html__( 'Socials', 'wolf-visual-composer' ),
	);
}
vc_add_params( 'wvc_team_member', $add_params );

class WPBakeryShortCode_Wvc_Team_Member extends WPBakeryShortCode {}