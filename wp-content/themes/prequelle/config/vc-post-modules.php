<?php
/**
 * WPBakery Page Builder post modules
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'Wolf_Visual_Composer' ) || ! defined( 'WPB_VC_VERSION' ) ) {
	return;
}

$order_by_values = array(
	'',
	esc_html__( 'Date', 'prequelle' ) => 'date',
	esc_html__( 'ID', 'prequelle' ) => 'ID',
	esc_html__( 'Author', 'prequelle' ) => 'author',
	esc_html__( 'Title', 'prequelle' ) => 'title',
	esc_html__( 'Modified', 'prequelle' ) => 'modified',
	esc_html__( 'Random', 'prequelle' ) => 'rand',
	esc_html__( 'Comment count', 'prequelle' ) => 'comment_count',
	esc_html__( 'Menu order', 'prequelle' ) => 'menu_order',
);

$order_way_values = array(
	'',
	esc_html__( 'Descending', 'prequelle' ) => 'DESC',
	esc_html__( 'Ascending', 'prequelle' ) => 'ASC',
);

$shared_gradient_colors = ( function_exists( 'wvc_get_shared_gradient_colors' ) ) ? wvc_get_shared_gradient_colors() : array();
$shared_colors = ( function_exists( 'wvc_get_shared_colors' ) ) ? wvc_get_shared_colors() : array();

/**
 * Post Loop Module
 */
vc_map(
	array(
		'name' => esc_html__( 'Posts', 'prequelle' ),
		'description' => esc_html__( 'Display your posts using the theme layouts', 'prequelle' ),
		'base' => 'wvc_post_index',
		'category' => esc_html__( 'Content' , 'prequelle' ),
		'icon' => 'fa fa-th',
		'weight' => 999,
		'params' =>
		//array_merge(
			array(

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Index ID', 'prequelle' ),
					'value' => 'index-' . rand( 0,99999 ),
					'param_name' => 'el_id',
					'description' => esc_html__( 'A unique identifier for the post module (required).', 'prequelle' ),
				),

				array(
					'param_name' => 'post_display',
					'heading' => esc_html__( 'Post Display', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array_flip( apply_filters( 'prequelle_post_display_options', array(
						'standard' => esc_html__( 'Standard', 'prequelle' ),
					) ) ),
					'std' => 'grid',
					'admin_label' => true,
				),

				array(
					'param_name' => 'post_metro_pattern',
					'heading' => esc_html__( 'Metro Pattern', 'prequelle' ),
					'type' => 'dropdown',
					'value' => prequelle_get_metro_patterns(),
					'std' => 'auto',
					'dependency' => array( 'element' => 'post_display', 'value' => array( 'metro_modern_alt' ) ),
					'admin_label' => true,
				),

				array(
					'param_name' => 'post_alternate_thumbnail_position',
					'heading' => esc_html__( 'Alternate thumbnail position', 'prequelle' ),
					'type' => 'checkbox',
					'dependency' => array(
						'element' => 'post_display',
						'value' => array( 'lateral' )
					),
				),

				array(
					'param_name' => 'post_module',
					'heading' => esc_html__( 'Module', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Grid', 'prequelle' ) => 'grid',
						esc_html__( 'Carousel', 'prequelle' ) => 'carousel',
					),
					'admin_label' => true,
					'dependency' => array(
						'element' => 'post_display',
						'value' => array( 'grid_classic', 'grid_modern' )
					),
				),

				array(
					'param_name' => 'post_excerpt_length',
					'heading' => esc_html__( 'Post Excerpt Lenght', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Shorten', 'prequelle' ) => 'shorten',
						esc_html__( 'Full', 'prequelle' ) => 'full',
					),
					'dependency' => array(
						'element' => 'post_display',
						'value' => array( 'masonry' ),
					),
				),

				array(
					'param_name' => 'post_display_elements',
					'heading' => esc_html__( 'Elements', 'prequelle' ),
					'type' => 'checkbox',
					'value' => array(
						esc_html__( 'Thumbnail', 'prequelle' ) => 'show_thumbnail',
						esc_html__( 'Date', 'prequelle' ) => 'show_date',
						esc_html__( 'Text', 'prequelle' ) => 'show_text',
						esc_html__( 'Category', 'prequelle' ) => 'show_category',
						esc_html__( 'Author', 'prequelle' ) => 'show_author',
						esc_html__( 'Tags', 'prequelle' ) => 'show_tags',
						esc_html__( 'Extra Meta', 'prequelle' ) => 'show_extra_meta',
					),
					'std' => 'show_thumbnail,show_date,show_text,show_author,show_category',
					// 'dependency' => array(
					// 	'element' => 'post_display',
					// 	'value' => array( 'masonry', 'grid_classic', 'grid_modern', 'mosaic', 'metro', 'standard' ),
					// ),
					'description' => esc_html__( 'Note that some options may be ignored depending on the post display.', 'prequelle' ),
					'admin_label' => true,
				),

				array(
					'param_name' => 'post_excerpt_type',
					'heading' => esc_html__( 'Post Excerpt Type', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Auto', 'prequelle' ) => 'auto',
						esc_html__( 'Manual', 'prequelle' ) => 'manual',
					),
					'description' => sprintf(
						wp_kses_post( __( 'When using the manual excerpt, you must split your post using a "<a href="%s">More Tag</a>".', 'prequelle' ) ),
						esc_url( 'https://en.support.wordpress.com/more-tag/' )
					),
					'dependency' => array(
						'element' => 'post_display',
						'value' => array( 'standard', 'standard_modern' ),
					),
				),

				array(
					'param_name' => 'grid_padding',
					'heading' => esc_html__( 'Padding', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Yes', 'prequelle' ) => 'yes',
						esc_html__( 'No', 'prequelle' ) => 'no',
					),
					'admin_label' => true,
					'dependency' => array(
						'element' => 'post_display',
						'value_not_equal_to' => array( 'standard', 'standard_modern', 'masonry_modern', 'offgrid' ),
						// value_not_equal_to
					),
				),

				// array(
				// 	'heading' => esc_html__( 'Category Filter', 'prequelle' ),
				// 	'param_name' => 'post_category_filter',
				// 	'type' => 'checkbox',
				// 	'admin_label' => true,
				// ),

				array(
					'param_name' => 'pagination',
					'heading' => esc_html__( 'Pagination', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'None', 'prequelle' ) => 'none',
						esc_html__( 'Load More', 'prequelle' ) => 'load_more',
						esc_html__( 'Numeric Pagination', 'prequelle' ) => 'standard_pagination',
						esc_html__( 'Link to Blog Archives', 'prequelle' ) => 'link_to_blog',
					),
					'admin_label' => true,
					//'dependency' => array( 'element' => 'post_module', 'value' => array( 'grid' ) ),
				),

				array(
					'heading' => esc_html__( 'Animation', 'prequelle' ),
					'param_name' => 'item_animation',
					'type' => 'dropdown',
					'value' => array_flip( prequelle_get_animations() ),
					'admin_label' => true,
				),

				array(
					'heading' => esc_html__( 'Posts Per Page', 'prequelle' ),
					'param_name' => 'posts_per_page',
					'type' => 'wvc_textfield',
					'value' => get_option( 'posts_per_page' ),
					'admin_label' => true,
				),

				array(
					'heading' => esc_html__( 'Additional CSS inline style', 'prequelle' ),
					'param_name' => 'inline_style',
					'type' => 'wvc_textfield',
					//'admin_label' => true,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Offset', 'prequelle' ),
					'param_name' => 'offset',
					'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query. If an offset is set, sticky posts will be ignored.', 'prequelle' ),
					'group' => esc_html__( 'Query', 'prequelle' ),
					'admin_label' => true,
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Ignore Sticky Posts', 'prequelle' ),
					'param_name' => 'ignore_sticky_posts',
					'description' => esc_html__( 'It will still include the sticky posts but it will not prioritize them in the query.', 'prequelle' ),
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Exclude Sticky Posts', 'prequelle' ),
					'description' => esc_html__( 'It will still exclude the sticky posts.', 'prequelle' ),
					'param_name' => 'exclude_sticky_posts',
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Category', 'prequelle' ),
					'param_name' => 'category',
					'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'prequelle' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'prequelle' ),
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Tags', 'prequelle' ),
					'param_name' => 'tag',
					'description' => esc_html__( 'Include only one or several tags. Paste tag slug(s) separated by a comma', 'prequelle' ),
					'placeholder' => esc_html__( 'my-tag, other-tag', 'prequelle' ),
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'prequelle' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'save_always' => true,
					'description' => sprintf( wp_kses_post( __( 'Select how to sort retrieved posts. More at %s.', 'prequelle' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sort order', 'prequelle' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'save_always' => true,
					'description' => sprintf( wp_kses_post( __( 'Designates the ascending or descending order. More at %s.', 'prequelle' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Post IDs', 'prequelle' ),
					'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'prequelle' ),
					'param_name' => 'include_ids',
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Exclude Post IDs', 'prequelle' ),
					'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'prequelle' ),
					'param_name' => 'exclude_ids',
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'param_name' => 'columns',
					'heading' => esc_html__( 'Columns', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Auto', 'prequelle' ) => 'default',
						esc_html__( 'Two', 'prequelle' ) => 2,
						esc_html__( 'Three', 'prequelle' ) => 3,
						esc_html__( 'Four', 'prequelle' ) => 4,
						esc_html__( 'Six', 'prequelle' ) => 6,
						esc_html__( 'One', 'prequelle' ) => 1,
					),
					'std' => 'default',
					'admin_label' => true,
					'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'prequelle' ),
					'dependency' => array(
						'element' => 'post_display',
						'value_not_equal_to' => array( 'standard', 'standard_modern', 'lateral', 'list' ),
					),
					'group' => esc_html__( 'Extra', 'prequelle' ),
				),
			),
			//),

			// 	array(
			// 		'heading' => esc_html__( 'Additional CSS inline style', 'prequelle' ),
			// 		'param_name' => 'inline_style',
			// 		'type' => 'wvc_textfield',
			// 		//'admin_label' => true,
			// 	),
			// ),
		//)
	)
);
class WPBakeryShortCode_Wvc_Post_Index extends WPBakeryShortCode {}

if ( class_exists( 'Wolf_Portfolio' ) ) {

/**
 * Work Loop Module
 */
vc_map(
	array(
		'name' => esc_html__( 'Works', 'prequelle' ),
		'description' => esc_html__( 'Display your works using the theme layouts', 'prequelle' ),
		'base' => 'wvc_work_index',
		'category' => esc_html__( 'Content' , 'prequelle' ),
		'icon' => 'fa fa-th',
		'weight' => 999,
		'params' =>
		//array_merge(
			array(

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Index ID', 'prequelle' ),
					'value' => 'index-' . rand( 0,99999 ),
					'param_name' => 'el_id',
					'description' => esc_html__( 'A unique identifier for the post module (required).', 'prequelle' ),
				),

				array(
					'param_name' => 'work_display',
					'heading' => esc_html__( 'Work Display', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array_flip( apply_filters( 'prequelle_work_display_options', array(
						'grid' => esc_html__( 'Grid', 'prequelle' ),
					) ) ),
					'admin_label' => true,
				),

				array(
					'param_name' => 'work_module',
					'heading' => esc_html__( 'Module', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Grid', 'prequelle' ) => 'grid',
						esc_html__( 'Carousel', 'prequelle' ) => 'carousel',
					),
					'admin_label' => true,
					'dependency' => array(
						'element' => 'work_display',
						'value' => array( 'grid' )
					),
				),

				array(
					'param_name' => 'work_thumbnail_size',
					'heading' => esc_html__( 'Thumbnail Size', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Default Thumbnail', 'prequelle' ) => 'standard',
						esc_html__( 'Landscape', 'prequelle' ) => 'landscape',
						esc_html__( 'Square', 'prequelle' ) => 'square',
						esc_html__( 'Portrait', 'prequelle' ) => 'portrait',
					),
					'admin_label' => true,
					'dependency' => array(
						'element' => 'work_display',
						'value' => array( 'grid' ),
						// value_not_equal_to
					),
				),

				array(
					'param_name' => 'work_layout',
					'heading' => esc_html__( 'Layout', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Classic', 'prequelle' ) => 'standard',
						esc_html__( 'Overlay', 'prequelle' ) => 'overlay',
						//esc_html__( 'Flip Box', 'prequelle' ) => 'flip-box',
					),
					'admin_label' => true,
					'dependency' => array(
						'element' => 'work_display',
						'value_not_equal_to' => array( 'list_minimal', 'text-background' )
					),
				),

				array(
					'param_name' => 'grid_padding',
					'heading' => esc_html__( 'Padding', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Yes', 'prequelle' ) => 'yes',
						esc_html__( 'No', 'prequelle' ) => 'no',
					),
					'admin_label' => true,
					'dependency' => array( 'element' => 'work_layout', 'value' => array( 'overlay', 'flip-box' ) ),
				),

				array(
					'heading' => esc_html__( 'Caption Text Alignement', 'prequelle' ),
					'param_name' => 'caption_text_alignment',
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Center', 'prequelle' ) => 'center',
						esc_html__( 'Left', 'prequelle' ) => 'left',
						esc_html__( 'Right', 'prequelle' ) => 'right',
					),
					'dependency' => array(
						'element' => 'work_display',
						'value_not_equal_to' => array( 'list_minimal', 'text-background' )
					),
				),

				array(
					'heading' => esc_html__( 'Caption Vertical Alignement', 'prequelle' ),
					'param_name' => 'caption_v_align',
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Middle', 'prequelle' ) => 'middle',
						esc_html__( 'Bottom', 'prequelle' ) => 'bottom',
						esc_html__( 'Top', 'prequelle' ) => 'top',
					),
					'dependency' => array(
						'element' => 'work_display',
						'value_not_equal_to' => array( 'list_minimal', 'text-background' )
					),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Overlay Color', 'prequelle' ),
					'param_name' => 'overlay_color',
					'value' => array_merge(
							array( esc_html__( 'Auto', 'prequelle' ) => 'auto', ),
							$shared_gradient_colors,
							$shared_colors,
							array( esc_html__( 'Custom color', 'prequelle' ) => 'custom', )
					),
					'std' => apply_filters( 'wvc_default_item_overlay_color', 'black' ),
					'description' => esc_html__( 'Select an overlay color.', 'prequelle' ),
					'param_holder_class' => 'wvc_colored-dropdown',
					'dependency' => array( 'element' => 'work_layout', 'value' => array( 'overlay', 'flip-box' ) ),
				),

				// Overlay color
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Overlay Custom Color', 'prequelle' ),
					'param_name' => 'overlay_custom_color',
					//'value' => '#000000',
					'dependency' => array( 'element' => 'overlay_color', 'value' => array( 'custom' ), ),
				),

				// Overlay opacity
				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Overlay Opacity in Percent', 'prequelle' ),
					'param_name' => 'overlay_opacity',
					'description' => '',
					'value' => 40,
					'std' => apply_filters( 'wvc_default_item_overlay_opacity', 40 ),
					'dependency' => array( 'element' => 'work_layout', 'value' => array( 'overlay', 'flip-box' ), ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Overlay Text Color', 'prequelle' ),
					'param_name' => 'overlay_text_color',
					'value' => array_merge(
						$shared_colors,
						$shared_gradient_colors,
						array( esc_html__( 'Custom color', 'prequelle' ) => 'custom', )
					),
					'std' => apply_filters( 'wvc_default_item_overlay_text_color', 'white' ),
					'description' => esc_html__( 'Select an overlay color.', 'prequelle' ),
					'param_holder_class' => 'wvc_colored-dropdown',
					'dependency' => array( 'element' => 'work_layout', 'value' => array( 'overlay', 'flip-box' ) ),
				),

				// Overlay color
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Overlay Custom Text Color', 'prequelle' ),
					'param_name' => 'overlay_text_custom_color',
					//'value' => '#000000',
					'dependency' => array( 'element' => 'overlay_text_color', 'value' => array( 'custom' ), ),
				),

				array(
					'heading' => esc_html__( 'Category Filter', 'prequelle' ),
					'param_name' => 'work_category_filter',
					'type' => 'checkbox',
					'description' => esc_html__( 'The pagination will not be disabled.', 'prequelle' ),
					'admin_label' => true,
					'dependency' => array(
						'element' => 'work_display',
						'value_not_equal_to' => array( 'list_minimal', 'text-background' )
					),
				),

				array(
					'heading' => esc_html__( 'Filter Text Alignement', 'prequelle' ),
					'param_name' => 'work_category_filter_text_alignment',
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Center', 'prequelle' ) => 'center',
						esc_html__( 'Left', 'prequelle' ) => 'left',
						esc_html__( 'Right', 'prequelle' ) => 'right',
					),
					'dependency' => array(
						'element' => 'work_category_filter',
						'value' => array( 'true' ),
					),
				),

				array(
					'heading' => esc_html__( 'Animation', 'prequelle' ),
					'param_name' => 'item_animation',
					'type' => 'dropdown',
					'value' => array_flip( prequelle_get_animations() ),
					'admin_label' => true,
				),

				array(
					'heading' => esc_html__( 'Number of Posts', 'prequelle' ),
					'param_name' => 'posts_per_page',
					'type' => 'wvc_textfield',
					//'placeholder' => get_option( 'posts_per_page' ),
					'description' => esc_html__( 'Leave empty to display all post at once.', 'prequelle' ),
					//'std' => '-1',
					'admin_label' => true,
				),

				array(
					'param_name' => 'pagination',
					'heading' => esc_html__( 'Pagination', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'None', 'prequelle' ) => 'none',
						esc_html__( 'Load More', 'prequelle' ) => 'load_more',
						esc_html__( 'Link to Portfolio', 'prequelle' ) => 'link_to_portfolio',
					),
					'admin_label' => true,
					'dependency' => array( 'element' => 'work_module', 'value' => array( 'grid' ) ),
				),

				array(
					'heading' => esc_html__( 'Additional CSS inline style', 'prequelle' ),
					'param_name' => 'inline_style',
					'type' => 'wvc_textfield',
					//'admin_label' => true,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Include Category', 'prequelle' ),
					'param_name' => 'work_type_include',
					'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'prequelle' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'prequelle' ),
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Exclude Category', 'prequelle' ),
					'param_name' => 'work_type_exclude',
					'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'prequelle' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'prequelle' ),
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Offset', 'prequelle' ),
					'description' => esc_html__( '.', 'prequelle' ),
					'param_name' => 'offset',
					'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query.', 'prequelle' ),
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'prequelle' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'save_always' => true,
					'description' => sprintf( wp_kses_post( __( 'Select how to sort retrieved posts. More at %s.', 'prequelle' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sort order', 'prequelle' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'save_always' => true,
					'description' => sprintf( wp_kses_post( __( 'Designates the ascending or descending order. More at %s.', 'prequelle' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Post IDs', 'prequelle' ),
					'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'prequelle' ),
					'param_name' => 'include_ids',
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Exclude Post IDs', 'prequelle' ),
					'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'prequelle' ),
					'param_name' => 'exclude_ids',
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'param_name' => 'columns',
					'heading' => esc_html__( 'Columns', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Auto', 'prequelle' ) => 'default',
						esc_html__( 'Two', 'prequelle' ) => 2,
						esc_html__( 'Three', 'prequelle' ) => 3,
						esc_html__( 'Four', 'prequelle' ) => 4,
						esc_html__( 'Six', 'prequelle' ) => 6,
						esc_html__( 'One', 'prequelle' ) => 1,
					),
					'std' => 'default',
					'admin_label' => true,
					'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'prequelle' ),
					'dependency' => array(
						'element' => 'post_display',
						'value_not_equal_to' => array( 'standard', 'standard_modern' ),
					),
					'group' => esc_html__( 'Extra', 'prequelle' ),
				),
			),
			//),

			// 	array(
			// 		'heading' => esc_html__( 'Additional CSS inline style', 'prequelle' ),
			// 		'param_name' => 'inline_style',
			// 		'type' => 'wvc_textfield',
			// 		//'admin_label' => true,
			// 	),
			// ),
		//)
	)
);

class WPBakeryShortCode_Wvc_Work_Index extends WPBakeryShortCode {}
} // end Portfolio plugin check

if ( class_exists( 'WooCommerce' ) ) {

/**
 * Product Loop Module
 */
vc_map(
	array(
		'name' => esc_html__( 'Products', 'prequelle' ),
		'description' => esc_html__( 'Display your pages using the theme layouts', 'prequelle' ),
		'base' => 'wvc_product_index',
		'category' => esc_html__( 'Content' , 'prequelle' ),
		'icon' => 'fa fa-th',
		'weight' => 999,
		'params' =>
		//array_merge(
			array(

				array(
					'type' => 'hidden',
					'heading' => esc_html__( 'ID', 'prequelle' ),
					'value' => 'items-' . rand( 0,99999 ),
					'param_name' => 'el_id',
				),

				array(
					'param_name' => 'product_display',
					'heading' => esc_html__( 'Product Display', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array_flip( apply_filters( 'prequelle_product_display_options', array(
						'grid_classic' => esc_html__( 'Classic', 'prequelle' ),
					) ) ),
					'std' => 'grid_classic',
					'admin_label' => true,
				),

				array(
					'param_name' => 'product_metro_pattern',
					'heading' => esc_html__( 'Metro Pattern', 'prequelle' ),
					'type' => 'dropdown',
					'value' => prequelle_get_metro_patterns(),
					'std' => 'pattern-1',
					'dependency' => array( 'element' => 'product_display', 'value' => array( 'metro_overlay_quickview' ) ),
					'admin_label' => true,
				),

				array(
					'param_name' => 'product_text_align',
					'heading' => esc_html__( 'Product Text Alignement', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						'' => '',
						esc_html__( 'Center', 'prequelle' ) => 'center',
						esc_html__( 'Left', 'prequelle' ) => 'left',
						esc_html__( 'Right', 'prequelle' ) => 'right',
					),
					//'std' => '',
					'admin_label' => true,
					'dependency' => array( 'element' => 'product_display', 'value' => array( 'grid_classic' ) ),
				),

				array(
					'param_name' => 'product_meta',
					'heading' => esc_html__( 'Type', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'All', 'prequelle' ) => 'all',
						esc_html__( 'Featured', 'prequelle' ) => 'featured',
						esc_html__( 'On Sale', 'prequelle' ) => 'onsale',
					),
					'admin_label' => true,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Category', 'prequelle' ),
					'param_name' => 'product_cat',
					'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'prequelle' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'prequelle' ),
					'admin_label' => true,
				),

				array(
					'param_name' => 'product_module',
					'heading' => esc_html__( 'Module', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Grid', 'prequelle' ) => 'grid',
						esc_html__( 'Carousel', 'prequelle' ) => 'carousel',
					),
					'admin_label' => true,
					//'dependency' => array( 'element' => 'work_layout', 'value' => array( 'overlay', 'flip-box' ) ),
				),

				array(
					'param_name' => 'grid_padding',
					'heading' => esc_html__( 'Padding', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Yes', 'prequelle' ) => 'yes',
						esc_html__( 'No', 'prequelle' ) => 'no',
					),
					'admin_label' => true,
				),

				array(
					'heading' => esc_html__( 'Animation', 'prequelle' ),
					'param_name' => 'item_animation',
					'type' => 'dropdown',
					'value' => array_flip( prequelle_get_animations() ),
					'admin_label' => true,
				),

				array(
					'heading' => esc_html__( 'Posts Per Page', 'prequelle' ),
					'param_name' => 'posts_per_page',
					'type' => 'wvc_textfield',
					'placeholder' => get_option( 'posts_per_page' ),
					'description' => esc_html__( 'Leave empty to display all post at once.', 'prequelle' ),
					'std' => get_option( 'posts_per_page' ),
					'admin_label' => true,
				),

				array(
					'param_name' => 'pagination',
					'heading' => esc_html__( 'Pagination', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'None', 'prequelle' ) => 'none',
						esc_html__( 'Load More', 'prequelle' ) => 'load_more',
						esc_html__( 'Numeric Pagination', 'prequelle' ) => 'standard_pagination',
						esc_html__( 'Link to Category', 'prequelle' ) => 'link_to_shop_category',
						esc_html__( 'Link to Shop Archive', 'prequelle' ) => 'link_to_shop',
					),
					'admin_label' => true,
					'dependency' => array( 'element' => 'product_module', 'value' => array( 'grid' ) ),
				),

				array(
					'param_name' => 'product_category_link_id',
					'heading' => esc_html__( 'Category', 'prequelle' ),
					'type' => 'dropdown',
					'value' => prequelle_get_product_cat_dropdown_options(),
					'dependency' => array( 'element' => 'pagination', 'value' => array( 'link_to_shop_category' ) ),
					'admin_label' => true,
				),

				array(
					'heading' => esc_html__( 'Additional CSS inline style', 'prequelle' ),
					'param_name' => 'inline_style',
					'type' => 'wvc_textfield',
					//'admin_label' => true,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Offset', 'prequelle' ),
					'param_name' => 'offset',
					'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query. If an offset is set, sticky posts will be ignored.', 'prequelle' ),
					'group' => esc_html__( 'Query', 'prequelle' ),
					'admin_label' => true,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'prequelle' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'save_always' => true,
					'description' => sprintf( wp_kses_post( __( 'Select how to sort retrieved products. More at %s.', 'prequelle' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sort order', 'prequelle' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'save_always' => true,
					'description' => sprintf( wp_kses_post( __( 'Designates the ascending or descending order. More at %s.', 'prequelle' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Post IDs', 'prequelle' ),
					'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'prequelle' ),
					'param_name' => 'include_ids',
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Exclude Post IDs', 'prequelle' ),
					'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'prequelle' ),
					'param_name' => 'exclude_ids',
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'param_name' => 'columns',
					'heading' => esc_html__( 'Columns', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Auto', 'prequelle' ) => 'default',
						esc_html__( 'Two', 'prequelle' ) => 2,
						esc_html__( 'Three', 'prequelle' ) => 3,
						esc_html__( 'Four', 'prequelle' ) => 4,
						esc_html__( 'Six', 'prequelle' ) => 6,
						esc_html__( 'One', 'prequelle' ) => 1,
					),
					'std' => 'default',
					'admin_label' => true,
					'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'prequelle' ),
					'dependency' => array(
						'element' => 'product_display',
						'value_not_equal_to' => array( 'metro_overlay_quickview' ),
					),
					'group' => esc_html__( 'Extra', 'prequelle' ),
				),
			),
			//),

			// 	array(
			// 		'heading' => esc_html__( 'Additional CSS inline style', 'prequelle' ),
			// 		'param_name' => 'inline_style',
			// 		'type' => 'wvc_textfield',
			// 		//'admin_label' => true,
			// 	),
			// ),
		//)
	)
);

class WPBakeryShortCode_Wvc_Product_Index extends WPBakeryShortCode {}

} // end WC check


$parent_pages = array( esc_html__( 'No', 'prequelle' ) => '' );
$all_pages = get_pages();

foreach ( $all_pages as $page ) {

	if ( 0 < count( get_posts( array( 'post_parent' => $page->ID, 'post_type' => 'page' ) ) ) ) {
		$parent_pages[ $page->post_title ] = $page->ID;
	}
}

/**
 * Page Loop Module
 */
vc_map(
	array(
		'name' => esc_html__( 'Pages', 'prequelle' ),
		'description' => esc_html__( 'Display your pages using the theme layouts', 'prequelle' ),
		'base' => 'wvc_page_index',
		'category' => esc_html__( 'Content' , 'prequelle' ),
		'icon' => 'fa fa-th',
		'weight' => 0,
		'params' =>
			array(

				array(
					'type' => 'hidden',
					'heading' => esc_html__( 'ID', 'prequelle' ),
					'value' => 'items-' . rand( 0,99999 ),
					'param_name' => 'el_id',
				),

				array(
					'param_name' => 'page_display',
					'heading' => esc_html__( 'Page Display', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array_flip( apply_filters( 'prequelle_page_display_options', array(
						'grid' => esc_html__( 'Image Grid', 'prequelle' ),
					) ) ),
					'admin_label' => true,
				),

				// array(
				// 	'param_name' => 'grid_padding',
				// 	'heading' => esc_html__( 'Padding', 'prequelle' ),
				// 	'type' => 'dropdown',
				// 	'value' => array(
				// 		esc_html__( 'Yes', 'prequelle' ) => 'yes',
				// 		esc_html__( 'No', 'prequelle' ) => 'no',
				// 	),
				// 	'admin_label' => true,
				// ),

				array(
					'heading' => esc_html__( 'Animation', 'prequelle' ),
					'param_name' => 'item_animation',
					'type' => 'dropdown',
					'value' => array_flip( prequelle_get_animations() ),
					'admin_label' => true,
				),

				array(
					'heading' => esc_html__( 'Number of Page to display', 'prequelle' ),
					'param_name' => 'posts_per_page',
					'type' => 'wvc_textfield',
					'placeholder' => get_option( 'posts_per_page' ),
					'description' => esc_html__( 'Leave empty to display all post at once.', 'prequelle' ),
					'std' => get_option( 'posts_per_page' ),
					'admin_label' => true,
				),

				array(
					'heading' => esc_html__( 'Additional CSS inline style', 'prequelle' ),
					'param_name' => 'inline_style',
					'type' => 'wvc_textfield',
					//'admin_label' => true,
				),

				array(
					'param_name' => 'page_by_parent',
					'heading' => esc_html__( 'Pages By Parent', 'prequelle' ),
					'type' => 'dropdown',
					'value' => $parent_pages,
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Post IDs', 'prequelle' ),
					'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'prequelle' ),
					'param_name' => 'include_ids',
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Exclude Post IDs', 'prequelle' ),
					'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'prequelle' ),
					'param_name' => 'exclude_ids',
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'prequelle' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'save_always' => true,
					'description' => sprintf( wp_kses_post( __( 'Select how to sort retrieved pages. More at %s.', 'prequelle' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sort order', 'prequelle' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'save_always' => true,
					'description' => sprintf( wp_kses_post( __( 'Designates the ascending or descending order. More at %s.', 'prequelle' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group' => esc_html__( 'Query', 'prequelle' ),
				),

				array(
					'param_name' => 'columns',
					'heading' => esc_html__( 'Columns', 'prequelle' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Auto', 'prequelle' ) => 'default',
						esc_html__( 'Two', 'prequelle' ) => 2,
						esc_html__( 'Three', 'prequelle' ) => 3,
						esc_html__( 'Four', 'prequelle' ) => 4,
						esc_html__( 'Six', 'prequelle' ) => 6,
						esc_html__( 'One', 'prequelle' ) => 1,
					),
					'std' => 'default',
					'admin_label' => true,
					'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'prequelle' ),
					'dependency' => array(
						'element' => 'post_display',
						'value_not_equal_to' => array( 'standard', 'standard_modern' ),
					),
					'group' => esc_html__( 'Extra', 'prequelle' ),
				),
			),
	)
);

class WPBakeryShortCode_Wvc_Page_Index extends WPBakeryShortCode {}