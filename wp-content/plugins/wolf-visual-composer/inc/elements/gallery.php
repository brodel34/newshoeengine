<?php
/**
 * Image gallery
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Image Gallery', 'wolf-visual-composer' ),
		'description' => esc_html__( 'An image or carousel gallery', 'wolf-visual-composer' ),
		'base' => 'vc_gallery',
		'category' => esc_html__( 'Media' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-images-alt',
		'params' => array(
			array(
				'type' => 'attach_images',
				'heading' => esc_html__( 'Images', 'wolf-visual-composer' ),
				'param_name' => 'images',
				'description' => esc_html__( 'You can set the "large", "medium" and "thumbnail" sizes in the WP media settings.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Gallery Type', 'wolf-visual-composer' ),
				'param_name' => 'type',
				'value' => array(
					esc_html__( 'Grid', 'wolf-visual-composer' ) => 'image_grid',
					esc_html__( 'Carousel', 'wolf-visual-composer' ) => 'carousel',
					esc_html__( 'Mosaic', 'wolf-visual-composer' ) => 'mosaic',
					esc_html__( 'Metro', 'wolf-visual-composer' ) => 'metro',
					esc_html__( 'Masonry', 'wolf-visual-composer' ) => 'masonry',
					esc_html__( 'Justified', 'wolf-visual-composer' ) => 'justified',
				),
				'admin_label' => true,
			),

			array(
				'param_name' => 'metro_pattern',
				'heading' => esc_html__( 'Metro Pattern', 'wolf-visual-composer' ),
				'type' => 'dropdown',
				'value' => wvc_get_metro_patterns(),
				'std' => 'auto',
				'dependency' => array( 'element' => 'type', 'value' => array( 'metro' ) ),
				'admin_label' => true,
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Metro Full Height (beta: for pattern 5 only)', 'wolf-visual-composer' ),
				'param_name' => 'metro_fullheight',
				'dependency' => array( 'element' => 'type', 'value' => array( 'metro' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Metro Background Size (beta: for pattern 5 only)', 'wolf-visual-composer' ),
				'value' => array(
					esc_html__( 'Cover', 'wolf-visual-composer' ) => 'cover',
					esc_html__( 'Contain', 'wolf-visual-composer' ) => 'contain',
				),
				'param_name' => 'metro_bg_size',
				'dependency' => array( 'element' => 'type', 'value' => array( 'metro' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Image Size', 'wolf-visual-composer' ),
				'param_name' => 'img_size',
				'value' => wvc_get_image_sizes(),
				'description' => esc_html__( 'You can set the "large", "medium" and "thumbnail" sizes in the WP media settings.', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'image_grid', 'carousel' ) ),
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
				'heading' => esc_html__( 'Columns', 'wolf-visual-composer' ),
				'param_name' => 'slides_per_view',
				'value' => array(
					4,1,2,3,5,6, 'auto',
				),
				'dependency' => array( 'element' => 'type', 'value' => array( 'image_grid', 'carousel', 'masonry' ) ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Padding', 'wolf-visual-composer' ),
				'param_name' => 'img_padding',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'no',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Hover Effect', 'wolf-visual-composer' ),
				'param_name' => 'hover_effect',
				'value' => wvc_get_hover_effects(),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Add caption below image?', 'wolf-visual-composer' ),
				'param_name' => 'add_caption',
				'description' => esc_html__( 'The image title and caption will be used.', 'wolf-visual-composer' ),
				'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'image_grid', 'carousel', 'masonry' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'On click action', 'wolf-visual-composer' ),
				'param_name' => 'onclick',
				'value' => array(
					sprintf( esc_html__( 'Open in %s', 'wolf-visual-composer' ), 'Lightbox' ) => 'lightbox',
					esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
					esc_html__( 'Link to attachment page', 'wolf-visual-composer' ) => 'attachment_page',
					esc_html__( 'Link to large image', 'wolf-visual-composer' ) => 'img_link_large',
					esc_html__( 'Open custom link', 'wolf-visual-composer' ) => 'custom_link',
				),
				'description' => esc_html__( 'Select action for click action.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'exploded_textarea_safe',
				'heading' => esc_html__( 'Custom links', '%TEXDOMAIN%' ),
				'param_name' => 'custom_links',
				'description' => esc_html__( 'Enter links for each slide (Note: divide links with linebreaks (Enter)).', '%TEXDOMAIN%' ),
				'dependency' => array(
					'element' => 'onclick',
					'value' => array( 'custom_link' ),
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Custom link target', '%TEXDOMAIN%' ),
				'param_name' => 'custom_links_target',
				'description' => esc_html__( 'Select where to open  custom links.', '%TEXDOMAIN%' ),
				'dependency' => array(
					'element' => 'onclick',
					'value' => array(
						'custom_link',
						'img_link_large',
					),
				),
				'value' => ( function_exists( 'wvc_target_param_list' ) ) ? wvc_target_param_list() : '',
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Animate Image One By One', 'wolf-visual-composer' ),
				'param_name' => 'css_animation_each',
				'group' => esc_html__( 'Animation', 'wolf-visual-composer' ),
				'weight' => -5,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Autoplay', 'wolf-visual-composer' ),
				'param_name' => 'autoplay',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'carousel' ) ),
			),
		
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Pause on Hover (if autoplay)', 'wolf-visual-composer' ),
				'param_name' => 'pause_on_hover',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'carousel' ) ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Slideshow Speed in ms', 'wolf-visual-composer' ),
				'param_name' => 'slideshow_speed',
				'value' => 6000,
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'carousel' ) ),
			),
	
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Show Navigation Bullets', 'wolf-visual-composer' ),
				'param_name' => 'nav_bullets',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'carousel' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Show Navigation Arrows', 'wolf-visual-composer' ),
				'param_name' => 'nav_arrows',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'carousel' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Group Cells', 'wolf-visual-composer' ),
				'param_name' => 'group_cells',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'carousel' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Navigation Arrows Tone', 'wolf-visual-composer' ),
				'param_name' => 'nav_arrows_tone',
				'value' => array(
					esc_html__( 'Light', 'wolf-visual-composer' ) => 'light',
					esc_html__( 'Dark', 'wolf-visual-composer' ) => 'dark',
				),
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'carousel' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Navigation Dots Tone', 'wolf-visual-composer' ),
				'param_name' => 'nav_dots_tone',
				'value' => array(
					esc_html__( 'Light', 'wolf-visual-composer' ) => 'light',
					esc_html__( 'Dark', 'wolf-visual-composer' ) => 'dark',
				),
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'carousel' ) ),
			),
		),
	)
);