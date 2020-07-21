<?php
/**
 * Prequelle metaboxes
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Register metaboxes
 *
 * Pass a metabox array to generate metabox with the  Wolf Metaboxes plugin
 */
function prequelle_register_metabox() {

	$body_metaboxes = array(
		'site_settings' => array(
			'title' => esc_html__( 'General', 'prequelle' ),
			'page' => apply_filters( 'prequelle_site_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event', 'artist' ) ),

			'metafields' => array(

				array(
					'label'	=> esc_html__( 'Accent Color', 'prequelle' ),
					'id'	=> '_post_accent_color',
					'type'	=> 'colorpicker',
				),

				array(
					'label'	=> esc_html__( 'Content Background Color', 'prequelle' ),
					'id'	=> '_post_content_inner_bg_color',
					'type'	=> 'colorpicker',
					'desc' => esc_html__( 'If you use the page builder and set your row background setting to "no background", you may want to change the overall content background color.', 'prequelle' ),
				),

				array(
					'label' => esc_html__( 'Loading Animation Type', 'prequelle' ),
					'id' => '_post_loading_animation_type',
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'overlay' => esc_html__( 'Overlay', 'prequelle' ),
		 				'prequelle' => esc_html__( 'Overlay with percent animation', 'prequelle' ),
		 				'none' => esc_html__( 'None', 'prequelle' ),
					),
				),
			),
		),
	);

	$content_blocks = array(
			'' => '&mdash; ' . esc_html__( 'None', 'prequelle' ) . ' &mdash;',
	);

	if ( class_exists( 'Wolf_Visual_Composer' ) && class_exists( 'Wolf_Vc_Content_Block' ) && defined( 'WPB_VC_VERSION' ) ) {
		// Content block option
		$content_block_posts = get_posts( 'post_type="wvc_content_block"&numberposts=-1' );

		$content_blocks = array(
			'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
			'none' => esc_html__( 'None', 'prequelle' ),
		);
		if ( $content_block_posts ) {
			foreach ( $content_block_posts as $content_block_options ) {
				$content_blocks[ $content_block_options->ID ] = $content_block_options->post_title;
			}
		} else {
			$content_blocks[0] = esc_html__( 'No Content Block Yet', 'prequelle' );
		}

		$body_metaboxes['site_settings']['metafields'][] = array(
			'label'	=> esc_html__( 'Post-header Block', 'prequelle' ),
			'id'	=> '_post_after_header_block',
			'type'	=> 'select',
			'choices' => $content_blocks,
		);

		$body_metaboxes['site_settings']['metafields'][] = array(
			'label'	=> esc_html__( 'Pre-footer Block', 'prequelle' ),
			'id'	=> '_post_before_footer_block',
			'type'	=> 'select',
			'choices' => $content_blocks,
		);

	}

	$header_metaboxes = array(
		'header_settings' => array(
			'title' => esc_html__( 'Header', 'prequelle' ),
			'page' => apply_filters( 'prequelle_header_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event', 'artist' ) ),

			'metafields' => array(

				array(
					'label'	=> esc_html__( 'Header Layout', 'prequelle' ),
					'id'	=> '_post_hero_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'standard' => esc_html__( 'Standard', 'prequelle' ),
						'big' => esc_html__( 'Big', 'prequelle' ),
						'small' => esc_html__( 'Small', 'prequelle' ),
						'fullheight' => esc_html__( 'Full Height', 'prequelle' ),
						'none' => esc_html__( 'No Header', 'prequelle' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Title Font Family', 'prequelle' ),
					'id'	=> '_post_hero_title_font_family',
					'type'	=> 'font_family',
				),

				array(
					'label'	=> esc_html__( 'Font Transform', 'prequelle' ),
					'id'	=> '_post_hero_title_font_transform',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'uppercase' => esc_html__( 'Uppercase', 'prequelle' ),
						'none' => esc_html__( 'None', 'prequelle' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Big Text', 'prequelle' ),
					'id'	=> '_post_hero_title_bigtext',
					'type'	=> 'checkbox',
					'desc' => esc_html__( 'Enable "Big Text" for the title?', 'prequelle' ),
				),

				array(
					'label'	=> esc_html__( 'Font Tone', 'prequelle' ),
					'id'	=> '_post_hero_font_tone',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'prequelle' ),
						'dark' => esc_html__( 'Dark', 'prequelle' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Background Type', 'prequelle' ),
					'id'	=> '_post_hero_background_type',
					'type'	=> 'select',
					'choices' => array(
						'featured-image' => esc_html__( 'Featured Image', 'prequelle' ),
						'image' => esc_html__( 'Image', 'prequelle' ),
						'video' => esc_html__( 'Video', 'prequelle' ),
						'slideshow' => esc_html__( 'Slideshow', 'prequelle' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Slideshow Images', 'prequelle' ),
					'id'	=> '_post_hero_slideshow_ids',
					'type'	=> 'multiple_images',
					'dependency' => array( 'element' => '_post_hero_background_type', 'value' => array( 'slideshow' ) ),
				),

				array(
					'label'	=> esc_html__( 'Background', 'prequelle' ),
					'id'	=> '_post_hero_background',
					'type'	=> 'background',
					'dependency' => array( 'element' => '_post_hero_background_type', 'value' => array( 'image' ) ),
				),

				array(
					'label'	=> esc_html__( 'Background Effect', 'prequelle' ),
					'id'	=> '_post_hero_background_effect',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'zoomin' => esc_html__( 'Zoom', 'prequelle' ),
						'parallax' => esc_html__( 'Parallax', 'prequelle' ),
						'none' => esc_html__( 'None', 'prequelle' ),
					),
					'dependency' => array( 'element' => '_post_hero_background_type', 'value' => array( 'image' ) ),
				),

				array(
					'label'	=> esc_html__( 'Video URL', 'prequelle' ),
					'id'	=> '_post_hero_background_video_url',
					'type'	=> 'video',
					'dependency' => array( 'element' => '_post_hero_background_type', 'value' => array( 'video' ) ),
					'desc' => esc_html__( 'A mp4 or YouTube URL. The featured image will be used as image fallback when the video cannot be displayed.', 'prequelle' ),
				),

				array(
					'label'	=> esc_html__( 'Overlay', 'prequelle' ),
					'id'	=> '_post_hero_overlay',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'custom' => esc_html__( 'Custom', 'prequelle' ),
						'none' => esc_html__( 'None', 'prequelle' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Overlay Color', 'prequelle' ),
					'id'	=> '_post_hero_overlay_color',
					'type'	=> 'colorpicker',
					//'value' 	=> '#000000',
					'dependency' => array( 'element' => '_post_hero_overlay', 'value' => array( 'custom' ) ),
				),

				array(
					'label'	=> esc_html__( 'Overlay Opacity (in percent)', 'prequelle' ),
					'id'	=> '_post_hero_overlay_opacity',
					'desc'	=> esc_html__( 'Adapt the header overlay opacity if needed', 'prequelle' ),
					'type'	=> 'int',
					'placeholder'	=> 40,
					'dependency' => array( 'element' => '_post_hero_overlay', 'value' => array( 'custom' ) ),
				),

			),
		),
	);

	$menu_metaboxes = array(
			'menu_settings' => array(
				'title' => esc_html__( 'Menu', 'prequelle' ),
				'page' => apply_filters( 'prequelle_menu_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event', 'artist' ) ),

			'metafields' => array(
				array(
					'label'	=> esc_html__( 'Menu Layout', 'prequelle' ),
					'id'	=> '_post_menu_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'top-right' => esc_html__( 'Top Right', 'prequelle' ),
						'top-justify' => esc_html__( 'Top Justify', 'prequelle' ),
						'top-justify-left' => esc_html__( 'Top Justify Left', 'prequelle' ),
						'centered-logo' => esc_html__( 'Centered', 'prequelle' ),
						'top-left' => esc_html__( 'Top Left', 'prequelle' ),
						//'offcanvas' => esc_html__( 'Off Canvas', 'prequelle' ),
						//'overlay' => esc_html__( 'Overlay', 'prequelle' ),
						//'lateral' => esc_html__( 'Lateral', 'prequelle' ),
						'none' => esc_html__( 'No Menu', 'prequelle' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Menu Width', 'prequelle' ),
					'id'	=> '_post_menu_width',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'wide' => esc_html__( 'Wide', 'prequelle' ),
						'boxed' => esc_html__( 'Boxed', 'prequelle' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Menu Style', 'prequelle' ),
					'id'	=> '_post_menu_style',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'solid' => esc_html__( 'Solid', 'prequelle' ),
						'semi-transparent-white' => esc_html__( 'Semi-transparent White', 'prequelle' ),
						'semi-transparent-black' => esc_html__( 'Semi-transparent Black', 'prequelle' ),
						'transparent' => esc_html__( 'Transparent', 'prequelle' ),
						//'none' => esc_html__( 'No Menu', 'prequelle' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Menu Skin', 'prequelle' ),
					'id'	=> '_post_menu_skin',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'prequelle' ),
						'dark' => esc_html__( 'Dark', 'prequelle' ),
						//'none' => esc_html__( 'No Menu', 'prequelle' ),
					),
				),

				'menu_sticky_type' => array(
					'id' =>'_post_menu_sticky_type',
					'label' => esc_html__( 'Sticky Menu', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'none' => esc_html__( 'Disabled', 'prequelle' ),
						'soft' => esc_html__( 'Sticky on scroll up', 'prequelle' ),
						'hard' => esc_html__( 'Always sticky', 'prequelle' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Sticky Menu Skin', 'prequelle' ),
					'id'	=> '_post_menu_skin',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'prequelle' ),
						'dark' => esc_html__( 'Dark', 'prequelle' ),
						//'none' => esc_html__( 'No Menu', 'prequelle' ),
					),
				),

				array(
					'id' => '_post_menu_cta_content_type',
					'label' => esc_html__( 'Additional Content', 'prequelle' ),
					'type' => 'select',
					'default' => 'icons',
					'choices' => array_merge(
						array(
							'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						),
						apply_filters( 'prequelle_menu_cta_content_type_options', array(
							'search_icon' => esc_html__( 'Search Icon', 'prequelle' ),
							'secondary-menu' => esc_html__( 'Secondary Menu', 'prequelle' ),
						) ),
						array( 'none' => esc_html__( 'None', 'prequelle' ) )
					),
				),

				array(
					'id' => '_post_show_nav_player',
					'label' => esc_html__( 'Show Navigation Player', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'yes' => esc_html__( 'Yes', 'prequelle' ),
						'no' => esc_html__( 'No', 'prequelle' ),
					),
				),

				array(
					'id' => '_post_side_panel_position',
					'label' => esc_html__( 'Side Panel', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'none' => esc_html__( 'None', 'prequelle' ),
						'right' => esc_html__( 'At Right', 'prequelle' ),
						'left' => esc_html__( 'At Left', 'prequelle' ),
					),
					'desc' => esc_html__( 'Note that it will be disable with a vertical menu layout (overlay, offcanvas etc...).', 'prequelle' ),
				),

				array(
					'id' => '_post_logo_visibility',
					'label' => esc_html__( 'Logo Visibility', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'always' => esc_html__( 'Always', 'prequelle' ),
						'sticky_menu' => esc_html__( 'When menu is sticky only', 'prequelle' ),
						'hidden' => esc_html__( 'Hidden', 'prequelle' ),
					),
				),

				array(
					'id' => '_post_menu_items_visibility',
					'label' => esc_html__( 'Menu Items Visibility', 'prequelle' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'show' => esc_html__( 'Visible', 'prequelle' ),
						'hidden' => esc_html__( 'Hidden', 'prequelle' ),
					),
					'desc' => esc_html__( 'If, for some reason, you need to hide the menu items but leave the logo, additional content and side panel.', 'prequelle' ),
				),

				'menu_breakpoint' => array(
					'id' =>'_post_menu_breakpoint',
					'label' => esc_html__( 'Mobile Menu Breakpoint', 'prequelle' ),
					'type' => 'text',
					'desc' => esc_html__( 'Use this field if you want to overwrite the mobile menu breakpoint.', 'prequelle' ),
				),
			),
		)
	);

	$footer_metaboxes = array(
		'footer_settings' => array(
				'title' => esc_html__( 'Footer', 'prequelle' ),
				'page' => apply_filters( 'prequelle_menu_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event' ) ),

			'metafields' => array(
				array(
					'label'	=> esc_html__( 'Page Footer', 'prequelle' ),
					'id'	=> '_post_footer_type',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'hidden' => esc_html__( 'No Footer', 'prequelle' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Hide Bottom Bar', 'prequelle' ),
					'id'	=> '_post_bottom_bar_hidden',
					'type'	=> 'select',
					'choices' => array(
						'' => esc_html__( 'No', 'prequelle' ),
						'yes' => esc_html__( 'Yes', 'prequelle' ),
					),
				),
			),
		)
	);

	/************** Page options ******************/
	$page_metaboxes = array(

		'page_settings' => array(

			'title' => esc_html__( 'Page', 'prequelle' ),
			'page' => array( 'page', 'artist' ),
			'metafields' => array(
				array(
					'label'	=> '',
					'id'	=> '_post_subheading',
					'type'	=> 'text',
				),
			),
		),
	);

	/************** Post options ******************/

	$product_options = array();
	$product_options[] = esc_html__( 'WooCommerce not installed', 'prequelle' );

	if ( class_exists( 'WooCommerce' ) ) {
		$product_posts = get_posts( 'post_type="product"&numberposts=-1' );

		$product_options = array();
		if ( $product_posts ) {
			
			$product_options[] = esc_html__( 'Not linked', 'prequelle' );
			
			foreach ( $product_posts as $product ) {
				$product_options[ $product->ID ] = $product->post_title;
			}
		} else {
			$product_options[ esc_html__( 'No product yet', 'prequelle' ) ] = 0;
		}
	}

	$post_metaboxes = array(
		'post_settings' => array(
			'title' => esc_html__( 'Post', 'prequelle' ),
			'page' => array( 'post' ),
			'metafields' => array(
				array(
					'label'	=> esc_html__( 'Post Layout', 'prequelle' ),
					'id'	=> '_post_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'sidebar-right' => esc_html__( 'Sidebar Right', 'prequelle' ),
						'sidebar-left' => esc_html__( 'Sidebar Left', 'prequelle' ),
						'no-sidebar' => esc_html__( 'No Sidebar', 'prequelle' ),
						'fullwidth' => esc_html__( 'Full width', 'prequelle' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Feature a Product', 'prequelle' ),
					'id'	=> '_post_wc_product_id',
					'type'	=> 'select',
					'choices' => $product_options,
					'desc'	=> esc_html__( 'A "Shop Now" buton will be displayed in the metro layout.', 'prequelle' ),
				),

				array(
					'label'	=> esc_html__( 'Featured', 'prequelle' ),
					'id'	=> '_post_featured',
					'type'	=> 'checkbox',
					'desc'	=> esc_html__( 'Will be displayed bigger in the "metro" layout (auto pattern).', 'prequelle' ),
				),
			),
		),
	);

	/************** Product options ******************/
	$product_metaboxes = array(

		'product_options' => array(
			'title' => esc_html__( 'Product', 'prequelle' ),
			'page' => array( 'product' ),
			'metafields' => array(

				array(
					'label'	=> esc_html__( 'Label', 'prequelle' ),
					'id'	=> '_post_product_label',
					'type'	=> 'text',
					'placeholder' => esc_html__( '-30%', 'prequelle' ),
				),

				array(
					'label'	=> esc_html__( 'Layout', 'prequelle' ),
					'id'	=> '_post_product_single_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'standard' => esc_html__( 'Standard', 'prequelle' ),
						'sidebar-right' => esc_html__( 'Sidebar Right', 'prequelle' ),
						'sidebar-left' => esc_html__( 'Sidebar Left', 'prequelle' ),
						'fullwidth' => esc_html__( 'Full Width', 'prequelle' ),
					),
				),

				// array(
				// 	'label'	=> esc_html__( 'MP3', 'prequelle' ),
				// 	'id'	=> '_post_product_mp3',
				// 	'type'	=> 'file',
				// 	'desc' => esc_html__( 'If you want to display a player for a song you want to sell, paste the mp3 URL here.', 'prequelle' ),
				// ),

				array(
					'label'	=> esc_html__( 'Menu Font Tone', 'prequelle' ),
					'id'	=> '_post_hero_font_tone',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'prequelle' ),
						'dark' => esc_html__( 'Dark', 'prequelle' ),
					),
					'desc' => esc_html__( 'By default the menu style is set to "solid" on single product page. If you change the menu style, you may need to adujst the menu color tone here.', 'prequelle' ),
				),

				array(
					'label'	=> esc_html__( 'Stacked Images with Sticky Product Details', 'prequelle' ),
					'id'	=> '_post_product_sticky',
					'type'	=> 'checkbox',
					'desc' => esc_html__( 'Not compatible with sidebar layouts.', 'prequelle' ),
				),

				array(
					'label'	=> esc_html__( 'Disable Image Zoom', 'prequelle' ),
					'id'	=> '_post_product_disable_easyzoom',
					'type'	=> 'checkbox',
					'desc' => esc_html__( 'Disable image zoom on this product if it\'s enabled in the customizer.', 'prequelle' ),
				),
			),
		),
	);

	/************** Product options ******************/

	$product_options = array();
	$product_options[] = esc_html__( 'WooCommerce not installed', 'prequelle' );

	if ( class_exists( 'WooCommerce' ) ) {
		$product_posts = get_posts( 'post_type="product"&numberposts=-1' );

		$product_options = array();
		if ( $product_posts ) {
			
			$product_options[] = esc_html__( 'Not linked', 'prequelle' );
			
			foreach ( $product_posts as $product ) {
				$product_options[ $product->ID ] = $product->post_title;
			}
		} else {
			$product_options[ esc_html__( 'No product yet', 'prequelle' ) ] = 0;
		}
	}

	/************** Portfolio options ******************/
	$work_metaboxes = array(

		'work_options' => array(
			'title' => esc_html__( 'Work', 'prequelle' ),
			'page' => array( 'work' ),
			'metafields' => array(

				array(
					'label'	=> esc_html__( 'Client', 'prequelle' ),
					'id'	=> '_work_client',
					'type'	=> 'text',
				),

				array(
					'label'	=> esc_html__( 'Link', 'prequelle' ),
					'id'		=> '_work_link',
					'type'	=> 'text',
				),

				array(
					'label'	=> esc_html__( 'Width', 'prequelle' ),
					'id'	=> '_post_width',
					'type'	=> 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'prequelle' ),
						'wide' => esc_html__( 'Wide', 'prequelle' ),
						'fullwidth' => esc_html__( 'Full Width', 'prequelle' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Layout', 'prequelle' ),
					'id'	=> '_post_layout',
					'type'	=> 'select',
					'choices' => array(
						'centered' => esc_html__( 'Centered', 'prequelle' ),
						'sidebar-right' => esc_html__( 'Excerpt & Info at Right', 'prequelle' ),
						'sidebar-left' => esc_html__( 'Excerpt & Info at Left', 'prequelle' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Excerpt & Info Position', 'prequelle' ),
					'id'	=> '_post_work_info_position',
					'type'	=> 'select',
					'choices' => array(
						'after' => esc_html__( 'After Content', 'prequelle' ),
						'before' => esc_html__( 'Before Content', 'prequelle' ),
						'none' => esc_html__( 'Hidden', 'prequelle' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Featured', 'prequelle' ),
					'id'	=> '_post_featured',
					'type'	=> 'checkbox',
					'desc'	=> esc_html__( 'The featured image will be display bigger in the "metro" layout.', 'prequelle' ),
				),
			),
		),
	);

	
	/************** One pager options ******************/
	$one_page_metaboxes = array(
		'one_page_settings' => array(
			'title' => esc_html__( 'One-Page', 'prequelle' ),
			'page' => array( 'post', 'page', 'work', 'product' ),
			'metafields' => array(
				array(
					'label'	=> esc_html__( 'One-Page Navigation', 'prequelle' ),
					'id'	=> '_post_one_page_menu',
					'type'	=> 'select',
					'choices' => array(
						'' => esc_html__( 'No', 'prequelle' ),
						'replace_main_nav' => esc_html__( 'Yes', 'prequelle' ),
					),
					'desc'	=> prequelle_kses( __( 'Activate to replace the main menu by a one-page scroll navigation. <strong>NB: Every row must have a unique name set in the row settings "Advanced" tab.</strong>', 'prequelle' ) ),
				),
				array(
					'label'	=> esc_html__( 'One-Page Bullet Navigation', 'prequelle' ),
					'id'	=> '_post_scroller',
					'type'	=> 'checkbox',
					'desc'	=> prequelle_kses( __( 'Activate to create a section scroller navigation. <strong>NB: Every row must have a unique name set in the row settings "Advanced" tab.</strong>', 'prequelle' ) ),
				),
				array(
					'label'	=> sprintf( esc_html__( 'Enable %s animations', 'prequelle' ), 'fullPage' ),
					'id'	=> '_post_fullpage',
					'type'	=> 'select',
					'choices' => array(
						'' => esc_html__( 'No', 'prequelle' ),
						'yes' => esc_html__( 'Yes', 'prequelle' ),
					),
					'desc' => esc_html__( 'Activate to enable advanced scroll animations between sections. Some of your row setting may be disabled to suit the global page design.', 'prequelle' ),
				),

				array(
					'label'	=> sprintf( esc_html__( '%s animation transition', 'prequelle' ), 'fullPage' ),
					'id'	=> '_post_fullpage_transition',
					'type'	=> 'select',
					'choices' => array(
						'mix' => esc_html__( 'Special', 'prequelle' ),
						'parallax' => esc_html__( 'Parallax', 'prequelle' ),
						'fade' => esc_html__( 'Fade', 'prequelle' ),
						'zoom' => esc_html__( 'Zoom', 'prequelle' ),
						'curtain' => esc_html__( 'Curtain', 'prequelle' ),
						'slide' => esc_html__( 'Slide', 'prequelle' ),
					),
					'dependency' => array( 'element' => '_post_fullpage', 'value' => array( 'yes' ) ),
				),

				array(
					'label'	=> sprintf( esc_html__( '%s animation duration', 'prequelle' ), 'fullPage' ),
					'id'	=> '_post_fullpage_animtime',
					'type'	=> 'text',
					'placeholder' => 1000,
					'dependency' => array( 'element' => '_post_fullpage', 'value' => array( 'yes' ) ),
				),
			),
		),
	);

	/************** Vertical bar options ******************/

	$vertical_bar_content_type_choices = array(
		'' => '&mdash; ' . esc_html__( 'Default', 'prequelle' ) . ' &mdash;',
		'none' => esc_html__( 'None', 'prequelle' ),
		 ) + prequelle_get_vertical_bar_content_choices();
	
	$vertical_bar_metaboxes = array(
		 'vertical_bar_settings' => array(
			'title' => esc_html__( 'Vertical Bar', 'prequelle' ),
			'page' => array( 'post', 'page', 'work', 'product' ),
			'metafields' => array(

			array(
				'label'	=> esc_html__( 'Disable Vertical Bar', 'prequelle' ),
				'id'	=> '_post_disable_vertical_bar',
				'type'	=> 'checkbox',
			),

			'_post_vertical_bar_content_type_top' => array(
				'id' => '_post_vertical_bar_content_type_top',
				'label' => esc_html__( 'Content Type Top', 'prequelle' ),
				'type' => 'select',
				'choices' => $vertical_bar_content_type_choices,
				//'transport' => 'postMessage',
			),

			'_post_vertical_bar_content_type_middle' => array(
				'id' => '_post_vertical_bar_content_type_middle',
				'label' => esc_html__( 'Content Type Middle', 'prequelle' ),
				'type' => 'select',
				'choices' => $vertical_bar_content_type_choices,
				//'transport' => 'postMessage',
			),

			'_post_vertical_bar_content_type_bottom' => array(
				'id' => '_post_vertical_bar_content_type_bottom',
				'label' => esc_html__( 'Content Type Bottom', 'prequelle' ),
				'type' => 'select',
				'choices' => $vertical_bar_content_type_choices,
				//'transport' => 'postMessage',
			),

			'_post_vertical_bar_overlay_content' => array(
				'id' => '_post_vertical_bar_overlay_block_id',
				'label' => esc_html__( 'Overlay Content', 'prequelle' ),
				'type' => 'select',
				'desc' => sprintf ( prequelle_kses( __( 'If you choose the "Toggle Overlay" option above, select the <a href="%s" target="_blank">Content Block</a> to use as overlay content', 'prequelle' ) ), 'http://wlfthm.es/content-blocks' ),
				'choices' => $content_blocks,
				//'transport' => 'postMessage',
			),

			'_post_vertical_bar_bg_color' => array(
				'id' => '_post_vertical_bar_bg_color',
				'label' => esc_html__( 'Background Color', 'prequelle' ),
				'type' => 'colorpicker',
			),

			'_post_vertical_bar_font_color' => array(
				'id' => '_post_vertical_bar_font_color',
				'label' => esc_html__( 'Font Color', 'prequelle' ),
				'type' => 'colorpicker',
			),

			'_post_vertical_bar_transparent_at_top' => array(
				'id' => '_post_vertical_bar_transparent_at_top',
				'label' => esc_html__( 'Transparent at top', 'prequelle' ),
				'type' => 'checkbox',
			),
		),
		)
	);

	$all_metaboxes = array_merge(
		apply_filters( 'prequelle_body_metaboxes', $body_metaboxes ),
		apply_filters( 'prequelle_post_metaboxes', $post_metaboxes ),
		//apply_filters( 'prequelle_page_metaboxes', $page_metaboxes ),
		apply_filters( 'prequelle_product_metaboxes', $product_metaboxes ),
		apply_filters( 'prequelle_work_metaboxes',  $work_metaboxes ),
		apply_filters( 'prequelle_header_metaboxes', $header_metaboxes ),
		apply_filters( 'prequelle_menu_metaboxes', $menu_metaboxes ),
		apply_filters( 'prequelle_footer_metaboxes', $footer_metaboxes ),
		apply_filters( 'prequelle_vertical_bar_metaboxes', $vertical_bar_metaboxes )
	);

	if ( class_exists( 'Wolf_Visual_Composer' ) && defined( 'WPB_VC_VERSION' ) ) {
		$all_metaboxes = $all_metaboxes + apply_filters( 'prequelle_one_page_metaboxes', $one_page_metaboxes );
	}

	if ( class_exists( 'Wolf_Metaboxes' ) ) {
		new Wolf_Metaboxes( apply_filters( 'prequelle_metaboxes', $all_metaboxes ) );
	}
}
prequelle_register_metabox();