<?php
/**
 * Banner Gallery
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$button_params = vc_map_integrate_shortcode(
	wvc_button_params(),
	'btn_',
	esc_html( 'Button', 'wolf-visual-composer' ),
	array(
		'exclude' => array(
			'align',
			'link',
			'scroll_to_anchor',
			'button_block',
			'css_animation',
			'css_anmation_delay',
			'css',
		),
	)
);
if ( is_array( $button_params ) && ! empty( $button_params ) ) {
	foreach ( $button_params as $key => $param ) {
		if ( is_array( $param ) && ! empty( $param ) ) {
			if ( ! isset( $button_params[ $key ]['dependency'] ) ) {
				$button_params[ $key ]['dependency'] = array(
					'element' => 'add_button',
					'value' => 'true',
				);
			}

			if ( isset( $param['admin_label'] ) ) {
				unset( $button_params[ $key ]['admin_label'] );
			}
		}
	}
}

vc_map(
	array(
		'name' => esc_html__( 'Gallery Banner', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Open a lightbox gallery from a banner', 'wolf-visual-composer' ),
		'base' => 'wvc_banner_gallery',
		'category' => esc_html__( 'Media' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-bookmark-o',
		'params' => array_merge(
			array(
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Cover Image', 'wolf-visual-composer' ),
					'param_name' => 'image',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'wolf-visual-composer' ),
					'admin_label' => true,
				),

				array(
					'type' => 'attach_images',
					'heading' => esc_html__( 'Images', 'wolf-visual-composer' ),
					'param_name' => 'images',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Banner Size', 'wolf-visual-composer' ),
					'param_name' => 'img_size',
					'value' => wvc_get_image_sizes(),
					'description' => esc_html__( 'You can set the "large", "medium" and "thumbnail" sizes in the WP media settings.', 'wolf-visual-composer' ),
					'admin_label' => true,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Custom Banner Size', 'wolf-visual-composer' ),
					'param_name' => 'custom_img_size',
					'description' => esc_html__( 'Enter size in pixels (Example: 200x100 (Width x Height).', 'wolf-visual-composer' ),
					'dependency' => array( 'element' => 'img_size', 'value' => array( 'custom' ) ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Banner alignment', 'wolf-visual-composer' ),
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
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Maximum width', 'wolf-visual-composer' ),
					'param_name' => 'max_width',
					'description' => sprintf( esc_html__( 'Set a value in %s or %s if you want to constrain the image width.', 'wolf-visual-composer' ), 'px', '%' ),
					'placeholder' => '100%',
				),

				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Banner link', 'wolf-visual-composer' ),
					'param_name' => 'link',
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
					'std' => apply_filters( 'wvc_default_banner_overlay_color', 'black' ),
					'description' => esc_html__( 'Select an overlay color.', 'wolf-visual-composer' ),
					'param_holder_class' => 'wvc_colored-dropdown',
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
					'std' => apply_filters( 'wvc_default_banner_overlay_text_color', 'white' ),
					'description' => esc_html__( 'Select an overlay color.', 'wolf-visual-composer' ),
					'param_holder_class' => 'wvc_colored-dropdown',
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
					'value' => 40,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Text Alignment', 'wolf-visual-composer' ),
					'param_name' => 'txt_align',
					'value' => array(
						esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
						esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
						esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
					),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Text Vertical Alignment', 'wolf-visual-composer' ),
					'param_name' => 'txt_v_align',
					'value' => array(
						esc_html__( 'Middle', 'wolf-visual-composer' ) => 'middle',
						esc_html__( 'Bottom', 'wolf-visual-composer' ) => 'bottom',
						esc_html__( 'Top', 'wolf-visual-composer' ) => 'top',
					),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
					'param_name' => 'title',
					'admin_label' => true,
					'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Title Font Size', 'wolf-visual-composer' ),
					'param_name' => 'title_font_size',
					'admin_label' => true,
					'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
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
					'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
				),

				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Tagline', 'wolf-visual-composer' ),
					'param_name' => 'tagline',
					'admin_label' => true,
					'group' => esc_html__( 'Text', 'wolf-visual-composer' ),
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Add Button', 'wolf-visual-composer' ),
					'param_name' => 'add_button',
				),
			),
			$button_params
		),
	)
);

class WPBakeryShortCode_Wvc_Banner_Gallery extends WPBakeryShortCode {}