<?php
/**
 * Single image
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Single Image', 'wolf-visual-composer' ),
		'description' => esc_html__( 'A single image item', 'wolf-visual-composer' ),
		'base' => 'vc_single_image',
		'category' => esc_html__( 'Media' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-image',
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Widget title', 'wolf-visual-composer' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'wolf-visual-composer' ),
				'param_name' => 'image',
				'value' => '',
				'description' => esc_html__( 'Select image from media library.', 'wolf-visual-composer' ),
				'admin_label' => true,
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
				'type' => 'checkbox',
				'heading' => esc_html__( 'Full width', 'wolf-visual-composer' ),
				'param_name' => 'full_width',
				'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => true ),
				'std' => true,
				'description' => esc_html__( 'The image will take the full width of the container.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Maximum width', 'wolf-visual-composer' ),
				'param_name' => 'max_width',
				'description' => sprintf( esc_html__( 'Set a value in %s or %s if you want to constrain the image width.', 'wolf-visual-composer' ), 'px', '%' ),
				'placeholder' => '100%',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Shape', 'wolf-visual-composer' ),
				'param_name' => 'shape',
				'value' => array(
					esc_html__( 'Default', 'wolf-visual-composer' ) => 'default',
					esc_html__( 'Circle', 'wolf-visual-composer' ) => 'circle',
					esc_html__( 'Rounded', 'wolf-visual-composer' ) => 'rounded',
				),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Shadow', 'wolf-visual-composer' ),
				'param_name' => 'shadow',
				'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Hover effect', 'wolf-visual-composer' ),
				'param_name' => 'hover_effect',
				'value' => wvc_get_hover_effects(),
				'admin_label' => true,
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Add caption below image?', 'wolf-visual-composer' ),
				'param_name' => 'add_caption',
				'description' => esc_html__( 'The image title and caption will be used.', 'wolf-visual-composer' ),
				'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes' ),
				'dependency' => array(
					'element' => 'add_overlay',
					'not_equal_to' => array( 'yes' )
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Image alignment', 'wolf-visual-composer' ),
				'param_name' => 'alignment',
				'value' => array(
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
				),
				'description' => esc_html__( 'Select image alignment.', 'wolf-visual-composer' ),
				'admin_label' => true,
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'On click action', 'wolf-visual-composer' ),
				'param_name' => 'onclick',
				'value' => array(
					esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
					sprintf( esc_html__( 'Open in %s', 'wolf-visual-composer' ), 'Lightbox' ) => 'lightbox',
					esc_html__( 'Open custom link', 'wolf-visual-composer' ) => 'custom_link',
					esc_html__( 'Link to attachment page', 'wolf-visual-composer' ) => 'attachment_page',
					esc_html__( 'Link to large image', 'wolf-visual-composer' ) => 'img_link_large',
				),
				'description' => esc_html__( 'Select action for click action.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Image link', 'wolf-visual-composer' ),
				'param_name' => 'link',
				'dependency' => array(
					'element' => 'onclick',
					'value' => 'custom_link',
				),
			),

			array(
				'type' => 'wvc_numeric_slider',
				'heading' => esc_html__( 'Opacity', 'wolf-visual-composer' ),
				'param_name' => 'opacity',
				'min' => 5,
				'max' => 100,
				'step' => 5,
				'std' => 100,
				'group' => esc_html( 'Extra', 'wolf-visual-composer' ),
				'weight' => -100,
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Animated SVG', 'wolf-visual-composer' ),
				'param_name' => 'animated_svg',
				'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => true ),
				'std' => true,
				'description' => esc_html__( 'If the image file is an SVG image, it will animated on page scroll if possible.', 'wolf-visual-composer' ),
				'group' => esc_html( 'Extra', 'wolf-visual-composer' ),
				'weight' => -100,
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Add Overlay', 'wolf-visual-composer' ),
				'param_name' => 'add_overlay',
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
				'dependency' => array( 'element' => 'add_overlay', 'value' => array( 'true' ) ),
				'group' => esc_html( 'Overlay', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Overlay Custom Color', 'wolf-visual-composer' ),
				'param_name' => 'overlay_custom_color',
				'dependency' => array( 'element' => 'overlay_color', 'value' => array( 'custom' ), ),
				'group' => esc_html( 'Overlay', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Overlay Opacity in Percent', 'wolf-visual-composer' ),
				'param_name' => 'overlay_opacity',
				'description' => '',
				'value' => 40,
				'std' => apply_filters( 'wvc_default_item_overlay_opacity', 40 ),
				'dependency' => array( 'element' => 'add_overlay', 'value' => array( 'true' ) ),
				'group' => esc_html( 'Overlay', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Overlay Text Color', 'wolf-visual-composer' ),
				'param_name' => 'overlay_text_color',
				'value' => array_merge(
					wvc_get_shared_colors(),
					wvc_get_shared_gradient_colors(),
					array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
				),
				'std' => apply_filters( 'wvc_default_item_overlay_text_color', 'white' ),
				'description' => esc_html__( 'Select an overlay color.', 'wolf-visual-composer' ),
				'param_holder_class' => 'wvc_colored-dropdown',
				'dependency' => array( 'element' => 'add_overlay', 'value' => array( 'true' ) ),
				'group' => esc_html( 'Overlay', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Overlay Custom Text Color', 'wolf-visual-composer' ),
				'param_name' => 'overlay_text_custom_color',
				'dependency' => array( 'element' => 'overlay_text_color', 'value' => array( 'custom' ), ),
				'group' => esc_html( 'Overlay', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Overlay Content Type', 'wolf-visual-composer' ),
				'param_name' => 'overlay_content_type',
				'value' => array(
					esc_html__( 'Image Title and Caption', 'wolf-visual-composer' ) => 'caption',
				),
				'dependency' => array( 'element' => 'add_overlay', 'value' => array( 'true' ) ),
				'group' => esc_html( 'Overlay', 'wolf-visual-composer' ),
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
				'dependency' => array( 'element' => 'overlay_content_type', 'value' => array( 'caption' ) ),
				'group' => esc_html( 'Overlay', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_font_family',
				'heading' => esc_html__( 'Font', 'wolf-visual-composer' ),
				'param_name' => 'title_font_family',
				'admin_label' => true,
				'std' => apply_filters( 'wvc_default_single_image_title_font_family', '' ),
				'dependency' => array( 'element' => 'overlay_content_type', 'value' => array( 'caption' ) ),
				'group' => esc_html( 'Overlay', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Font Size', 'wolf-visual-composer' ),
				'param_name' => 'title_font_size',
				'value' => apply_filters( 'wvc_default_single_image_title_font_size', '' ),
				'dependency' => array( 'element' => 'overlay_content_type', 'value' => array( 'caption' ) ),
				'group' => esc_html( 'Overlay', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Font Weight', 'wolf-visual-composer' ),
				'param_name' => 'title_font_weight',
				'value' => apply_filters( 'wvc_default_single_image_title_font_weight', '' ),
				'dependency' => array( 'element' => 'overlay_content_type', 'value' => array( 'caption' ) ),
				'placeholder' => 700,
				'group' => esc_html( 'Overlay', 'wolf-visual-composer' ),
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
				'std' => apply_filters( 'wvc_default_single_image_title_text_transform', '' ),
				'dependency' => array( 'element' => 'overlay_content_type', 'value' => array( 'caption' ) ),
				'group' => esc_html( 'Overlay', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Font Style', 'wolf-visual-composer' ),
				'param_name' => 'title_font_style',
				'value' => array(
					esc_html__( 'Default', 'wolf-visual-composer' ) => '',
					esc_html__( 'Italic', 'wolf-visual-composer' ) => 'italic',
				),
				'dependency' => array( 'element' => 'overlay_content_type', 'value' => array( 'caption' ) ),
				'group' => esc_html( 'Overlay', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Letter Spacing', 'wolf-visual-composer' ),
				'param_name' => 'title_letter_spacing',
				'value' => apply_filters( 'wvc_default_single_image_title_letter_spacing', '' ),
				'dependency' => array( 'element' => 'overlay_content_type', 'value' => array( 'caption' ) ),
				'group' => esc_html( 'Overlay', 'wolf-visual-composer' ),
			),
		),
	)
);