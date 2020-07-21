<?php
/**
 * WooCommerce categories
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'WooCommerce Category Images', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Shop categories image links', 'wolf-visual-composer' ),
		'base' => 'wvc_wc_categories',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'icon-wpb-woocommerce',
		'params' => array(
			
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Layout', 'wolf-visual-composer' ),
				'param_name' => 'type',
				'value' => array(
					esc_html__( 'Grid', 'wolf-visual-composer' ) => 'image_grid',
					esc_html__( 'Carousel', 'wolf-visual-composer' ) => 'carousel',
					esc_html__( 'Metro', 'wolf-visual-composer' ) => 'metro',
					esc_html__( 'Masonry', 'wolf-visual-composer' ) => 'masonry',
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
				'heading' => esc_html__( 'Font Tone', 'wolf-visual-composer' ),
				'param_name' => 'font_tone',
				'value' => array(
					esc_html__( 'Auto', 'wolf-visual-composer' ) => '',
					esc_html__( 'Dark', 'wolf-visual-composer' ) => 'light',
					esc_html__( 'Light', 'wolf-visual-composer' ) => 'dark',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Horizontal Alignment', 'wolf-visual-composer' ),
				'param_name' => 't_align',
				'value' => array(
					esc_html__( 'Default', 'wolf-visual-composer' ) => '',
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Vertical Alignment', 'wolf-visual-composer' ),
				'param_name' => 'v_align',
				'value' => array(
					esc_html__( 'Default', 'wolf-visual-composer' ) => '',
					esc_html__( 'Bottom', 'wolf-visual-composer' ) => 'bottom',
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'Top', 'wolf-visual-composer' ) => 'top',
				),
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Hide Product Count', 'wolf-visual-composer' ),
				'param_name' => 'hide_count',
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Hide Category Description', 'wolf-visual-composer' ),
				'param_name' => 'hide_desc',
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Hover Effect', 'wolf-visual-composer' ),
				'param_name' => 'hover_effect',
				'value' => wvc_get_hover_effects(),
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
			array(
				'heading' => esc_html__( 'Count', 'wolf-visual-composer' ),
				'param_name' => 'count',
				'type' => 'wvc_textfield',
				'value' => '',
				'admin_label' => true,
				'group' => esc_html__( 'Query', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Parent Category', 'wolf-visual-composer' ),
				'param_name' => 'parent',
				'value' => array_merge(
					array( esc_html__( 'All', 'wolf-visual-composer' ) => 0, ),
					wvc_get_product_cat_dropdown_options()
				),
				'group' => esc_html__( 'Query', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Include Category', 'wolf-visual-composer' ),
				'param_name' => 'include',
				'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'wolf-visual-composer' ),
				'placeholder' => esc_html__( 'my-category, other-category', 'wolf-visual-composer' ),
				'group' => esc_html__( 'Query', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Exclude Category', 'wolf-visual-composer' ),
				'param_name' => 'exclude',
				'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'wolf-visual-composer' ),
				'placeholder' => esc_html__( 'my-category, other-category', 'wolf-visual-composer' ),
				'group' => esc_html__( 'Query', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Order by', 'wolf-visual-composer' ),
				'param_name' => 'orderby',
				'value' => wvc_get_order_by_category_values(),
				'std' => 'count',
				'description' => sprintf( wp_kses_post( __( 'Select how to sort retrieved posts. More at %s.', 'wolf-visual-composer' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				'group' => esc_html__( 'Query', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Sort order', 'wolf-visual-composer' ),
				'param_name' => 'order',
				'value' => wvc_get_order_way_category_values(),
				'std' => 'DESC',
				'description' => sprintf( wp_kses_post( __( 'Designates the ascending or descending order. More at %s.', 'wolf-visual-composer' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				'group' => esc_html__( 'Query', 'wolf-visual-composer' ),
			),
		)
	)
);

class WPBakeryShortCode_Wvc_Wc_Categories extends WPBakeryShortCode {}