<?php
/**
 * Prequelle navigation
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function prequelle_set_navigation_mods( $mods ) {

	$mods['navigation'] = array(
		'id' => 'navigation',
		'icon' => 'menu',
		'title' => esc_html__( 'Navigation', 'prequelle' ),
		'options' => array(

			'menu_layout' => array(
				'id' => 'menu_layout',
				'label' => esc_html__( 'Main Menu Layout', 'prequelle' ),
				'type' => 'select',
				'default' => 'top-justify',
				'choices' => array(
					'top-right' => esc_html__( 'Top Right', 'prequelle' ),
					'top-justify' => esc_html__( 'Top Justify', 'prequelle' ),
					'top-justify-left' => esc_html__( 'Top Justify Left', 'prequelle' ),
					'centered-logo' => esc_html__( 'Centered', 'prequelle' ),
					'top-left' => esc_html__( 'Top Left', 'prequelle' ),
					'offcanvas' => esc_html__( 'Off Canvas', 'prequelle' ),
					'overlay' => esc_html__( 'Overlay', 'prequelle' ),
					'lateral' => esc_html__( 'Lateral', 'prequelle' ),
				),
			),

			'menu_width' => array(
				'id' => 'menu_width',
				'label' => esc_html__( 'Main Menu Width', 'prequelle' ),
				'type' => 'select',
				'choices' => array(
					'wide' => esc_html__( 'Wide', 'prequelle' ),
					'boxed' => esc_html__( 'Boxed', 'prequelle' ),
				),
				'transport' => 'postMessage',
			),

			'menu_style' => array(
				'id' =>'menu_style',
				'label' => esc_html__( 'Main Menu Style', 'prequelle' ),
				'type' => 'select',
				'choices' => array(
					'semi-transparent-white' => esc_html__( 'Semi-transparent White', 'prequelle' ),
					'semi-transparent-black' => esc_html__( 'Semi-transparent Black', 'prequelle' ),
					'solid' => esc_html__( 'Solid', 'prequelle' ),
					'transparent' => esc_html__( 'Transparent', 'prequelle' ),
				),
				'transport' => 'postMessage',
			),

			'menu_hover_style' => array(
				'id' => 'menu_hover_style',
				'label' => esc_html__( 'Main Menu Hover Style', 'prequelle' ),
				'type' => 'select',
				'choices' => apply_filters( 'prequelle_main_menu_hover_style_options', array(
					'none' => esc_html__( 'None', 'prequelle' ),
					'opacity' => esc_html__( 'Opacity', 'prequelle' ),
					'underline' => esc_html__( 'Underline', 'prequelle' ),
					'underline-centered' => esc_html__( 'Underline Centered', 'prequelle' ),
					'border-top' => esc_html__( 'Border Top', 'prequelle' ),
					'plain' => esc_html__( 'Plain', 'prequelle' ),
				) ),
				'transport' => 'postMessage',
			),

			'mega_menu_width' => array(
				'id' => 'mega_menu_width',
				'label' => esc_html__( 'Mega Menu Width', 'prequelle' ),
				'type' => 'select',
				'choices' => array(
					'boxed' => esc_html__( 'Boxed', 'prequelle' ),
					'wide' => esc_html__( 'Wide', 'prequelle' ),
					'fullwidth' => esc_html__( 'Full Width', 'prequelle' ),
				),
				'transport' => 'postMessage',
			),

			'menu_breakpoint' => array(
				'id' =>'menu_breakpoint',
				'label' => esc_html__( 'Main Menu Breakpoint', 'prequelle' ),
				'type' => 'text',
				'description' => esc_html__( 'Below each width would you like to display the mobile menu? 0 will always show the desktop menu and 99999 will always show the mobile menu.', 'prequelle' ),
			),

			'menu_sticky_type' => array(
				'id' =>'menu_sticky_type',
				'label' => esc_html__( 'Sticky Menu', 'prequelle' ),
				'type' => 'select',
				'choices' => array(
					'none' => esc_html__( 'Disabled', 'prequelle' ),
					'soft' => esc_html__( 'Sticky on scroll up', 'prequelle' ),
					'hard' => esc_html__( 'Always sticky', 'prequelle' ),
				),
				'transport' => 'postMessage',
			),

			/*'search_menu_item' => array(
				'label' => esc_html__( 'Search Menu Item', 'prequelle' ),
				'id' => 'search_menu_item',
				'type' => 'checkbox',
			),*/

			'menu_skin' => array(
				'id' => 'menu_skin',
				'label' => esc_html__( 'Sticky Menu Skin', 'prequelle' ),
				'type' => 'select',
				'choices' => array(
					'light' => esc_html__( 'Light', 'prequelle' ),
					'dark' => esc_html__( 'Dark', 'prequelle' ),
				),
				'transport' => 'postMessage',
				'description' => esc_html__( 'Can be overwite on single page.', 'prequelle' ),
			),

			'menu_cta_content_type' => array(
				'id' => 'menu_cta_content_type',
				'label' => esc_html__( 'Additional Content', 'prequelle' ),
				'type' => 'select',
				'default' => 'icons',
				'choices' => apply_filters( 'prequelle_menu_cta_content_type_options', array(
					'search_icon' => esc_html__( 'Search Icon', 'prequelle' ),
					'secondary-menu' => esc_html__( 'Secondary Menu', 'prequelle' ),
					'none' => esc_html__( 'None', 'prequelle' ),
				) ),
			),
		)
	);

	$mods['navigation']['options']['menu_socials'] = array(
		'id' => 'menu_socials',
		'label' => esc_html__( 'Menu Socials', 'prequelle' ),
		'type' => 'text',
		'description' => esc_html__( 'The list of social services to display in the menu. (eg: facebook,twitter,instagram)', 'prequelle' ),
	);

	$mods['navigation']['options']['side_panel_position'] = array(
		'id' => 'side_panel_position',
		'label' => esc_html__( 'Side Panel', 'prequelle' ),
		'type' => 'select',
		'choices' => array(
			'none' => esc_html__( 'None', 'prequelle' ),
			'right' => esc_html__( 'At Right', 'prequelle' ),
			'left' => esc_html__( 'At Left', 'prequelle' ),
		),
		'description' => esc_html__( 'Note that it will be disable with a vertical menu layout (offcanvas and lateral layout).', 'prequelle' ),
	);

	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_navigation_mods' );