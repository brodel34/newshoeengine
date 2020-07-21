<?php
/**
 * Prequelle menu functions
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Add a parent CSS class for nav menu items.
 *
 * @see https://developer.wordpress.org/reference/functions/wp_nav_menu/#How_to_add_a_parent_class_for_menu_item
 * @param array  $items The menu items, sorted by each menu item's menu order.
 * @return array (maybe) modified parent CSS class.
 */
function prequelle_add_menu_parent_class( $items ) {

	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}
	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'menu-parent-item';
		}
	}
	return $items;
}
add_filter( 'wp_nav_menu_objects', 'prequelle_add_menu_parent_class' );

/**
 * Display icons in social links menu.
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function prequelle_nav_menu_social_icons( $item_output, $item, $depth, $args ) {

	$social_icons = prequelle_social_links_icons();

	if ( 'primary' === $args->theme_location || 'secondary' === $args->theme_location ) {
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$label = wp_strip_all_tags( $item_output );
				$icon = "<span class='socicon socicon-$value'></span>";
				$item_output = str_replace( $label, $icon, $item_output );
			}
		}
	}

	return $item_output;
}

/**
 * Modify menu item output
 *
 * @param string $item_output The menu item's starting HTML output.
 * @param object $item        Menu item data object.
 * @param int    $depth       Depth of menu item. Used for padding.
 * @param array  $args        An array of wp_nav_menu() arguments.
 */
function prequelle_menu_item_markup( $item_output, $item, $depth, $args ) {

	if ( 'primary' === $args->theme_location || 'secondary' === $args->theme_location ) {

		$item_id = $item->ID;

		$before_text = $after_text = '';

		$label = wp_strip_all_tags( $item_output );

		$icon = get_post_meta( $item->ID, '_menu-item-icon', true );
		$icon_position = ( get_post_meta( $item_id, '_menu-item-icon-position', true ) ) ? get_post_meta( $item->ID, '_menu-item-icon-position', true ) : 'before';
		if ( $icon && 'before' === $icon_position )   {
			$before_text = '<i class="fa ' . $icon . '"></i>';
		}

		if ( $icon && 'after' === $icon_position )   {
			$after_text = '<i class="fa ' . $icon . '"></i>';
		}

		$new_label = $before_text . $label . $after_text;
		if ( $icon && $icon_position ) {
			$item_output = str_replace( $label, $new_label, $item_output );
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'prequelle_menu_item_markup', 10, 4 );

/**
 * Add menu_item attributes
 *
 * @param string $menu_id The ID that is applied to the menu item's <li>.
 * @param object $item The current menu item.
 * @param array  $args An array of wp_nav_menu() arguments.
 * @return array $classes
 */
function prequelle_add_menu_item_link_attributes( $atts, $item, $args ) {

	if ( 'primary' === $args->theme_location || 'secondary' === $args->theme_location ) {

		$item_id = $item->ID;

		if ( get_post_meta( $item_id, '_menu-item-scroll', true ) ) {
			$atts['class'] = 'menu-link scroll';
		} else {
			$atts['class'] = 'menu-link';
		}
		if ( get_post_meta( $item_id, '_mega-menu-tagline', true ) ) {
			$atts['data-mega-menu-tagline'] = get_post_meta( $item_id, '_mega-menu-tagline', true );
		}

		$atts['itemprop'] = 'url';
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'prequelle_add_menu_item_link_attributes', 10, 3 );

/**
 * Add custom classes to menu item
 *
 * @param array $classes The ID that is applied to the menu item's <li>.
 * @param object $item The current menu item.
 * @param array  $args An array of wp_nav_menu() arguments.
 * @return array $classes
 */
function prequelle_add_menu_item_css_classes( $classes, $item, $args ) {

	if ( 'primary' === $args->theme_location || 'secondary' === $args->theme_location ) {

		$item_id = $item->ID;

		$classes[] = 'menu-item-' . $item_id;
		$social_icons = prequelle_social_links_icons();

		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item->url, $attr ) ) {
			}
		}

		if ( get_post_meta( $item_id, '_mega-menu', true ) ) {
			$classes[] = 'mega-menu';
		}

		if ( get_post_meta( $item_id, '_mega-menu-tagline', true ) ) {
			$classes[] = 'mega-menu-has-tagline';
		}

		if ( get_post_meta( $item_id, '_menu-item-not-linked', true ) ) {
			$classes[] = 'not-linked';
		}

		if ( get_post_meta( $item_id, '_menu-item-hidden', true ) ) {
			$classes[] = 'menu-item-hidden';
		}

		if ( get_post_meta( $item_id, '_menu-item-button-style', true ) ) {
			$classes[] = 'menu-button-' . esc_attr( get_post_meta( $item_id, '_menu-item-button-style', true ) );
		}

		if ( get_post_meta( $item_id, '_menu-item-new', true ) ) {
			$classes[] = 'new';
		}

		if ( get_post_meta( $item_id, '_menu-item-hot', true ) ) {
			$classes[] = 'hot';
		}

		if ( get_post_meta( $item_id, '_menu-item-sale', true ) ) {
			$classes[] = 'sale';
		}

		if ( get_post_meta( $item_id, '_menu-item-external', true ) ) {
			$classes[] = 'external';
		}
		$icon_position = ( get_post_meta( $item_id, '_menu-item-icon-position', true ) ) ? get_post_meta( $item_id, '_menu-item-icon-position', true ) : 'before';
		$classes[] = "menu-item-icon-$icon_position";
		$mega_menu_cols = ( get_post_meta( $item_id, '_mega-menu-cols', true ) ) ? get_post_meta( $item_id, '_mega-menu-cols', true ) : 4;
		$classes[] = "mega-menu-$mega_menu_cols-cols";

	} // endif primary menu

	return $classes;
}
add_filter( 'nav_menu_css_class', 'prequelle_add_menu_item_css_classes', 10, 3 );

/**
 * Add a cart menu item in mobile menu
 *
 */
function prequelle_add_cart_menu_item_mobile( $items, $args ) {


	if ( prequelle_display_cart_menu_item() ) {
		if ( $args->theme_location === 'primary' && preg_match( '/mobile/', $args->menu_class ) ) {
			$items .= '<li class="menu-item">';
			$items .= prequelle_cart_menu_item_mobile( false );
			$items .= '</li>';
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_items', 'prequelle_add_cart_menu_item_mobile', 10, 2 );

/**
 * Get menu args
 *
 * @param string $location
 * @param string $location
 * @param string $location
 */
function prequelle_get_menu_args( $location = 'primary', $type = 'desktop', $depth = 3 ) {

	$args = array(
		'theme_location' 	=> $location,
		'menu_class' 		=> "nav-menu nav-menu-$type",
		'menu_id' 		=> "site-navigation-$location-$type",
		'depth'			=> $depth,
		'fallback_cb'		=> 'prequelle_menu_fallback',
		'link_before' => '<span class="menu-item-inner"><span class="menu-item-text-container" itemprop="name">',
		'link_after'=> '</span></span>',
	);

	return $args;
}

/**
 * Dsplay "add menu" link to create menu when no menu is set if user is logged
 *
 * @link http://wordpress.stackexchange.com/questions/64515/fall-back-for-main-menu/
 */
function prequelle_menu_fallback( $args ) {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	extract( $args );

	$link = $link_before
	. '<a class="no-link-style" href="' . admin_url( 'nav-menus.php' ) . '">' . $before . esc_html__( 'Add Menu', 'prequelle' ) . $after . '</a>'
	. $link_after;
	if ( false !== stripos( $items_wrap, '<ul' )
		or false !== stripos( $items_wrap, '<ol' )
		) {
		$link = "<li>$link</li>";
	}

	$output = sprintf( $items_wrap, $menu_id, $menu_class, $link );

	if ( ! empty ( $container ) ) {
		$output  = "<$container class='$container_class' id='$container_id'>$output</$container>";
	}

	echo prequelle_kses( $output );
}

/**
 * Returns an array of supported social links (URL and icon name).
 *
 * Inspired by Twenty Seventeen theme
 *
 * @return array $social_links_icons
 */
function prequelle_social_links_icons() {
	$social_links_icons = array(
		'behance.net'     => 'behance',
		'codepen.io'      => 'codepen',
		'deviantart.com'  => 'deviantart',
		'digg.com'        => 'digg',
		'dribbble.com'    => 'dribbble',
		'dropbox.com'     => 'dropbox',
		'facebook.com'    => 'facebook',
		'flickr.com'      => 'flickr',
		'foursquare.com'  => 'foursquare',
		'plus.google.com' => 'google-plus',
		'github.com'      => 'github',
		'instagram.com'   => 'instagram',
		'linkedin.com'    => 'linkedin',
		'mailto:'         => 'mail',
		'medium.com'      => 'medium',
		'path.com'        => 'path',
		'pinterest.com'   => 'pinterest-p',
		'getpocket.com'   => 'get-pocket',
		'polldaddy.com'   => 'polldaddy',
		'reddit.com'      => 'reddit-alien',
		'skype.com'       => 'skype',
		'skype:'          => 'skype',
		'slideshare.net'  => 'slideshare',
		'snapchat.com'    => 'snapchat-ghost',
		'soundcloud.com'  => 'soundcloud',
		'spotify.com'     => 'spotify',
		'stumbleupon.com' => 'stumbleupon',
		'tumblr.com'      => 'tumblr',
		'twitch.tv'       => 'twitch',
		'twitter.com'     => 'twitter',
		'vimeo.com'       => 'vimeo',
		'vine.co'         => 'vine',
		'vk.com'          => 'vk',
		'yelp.com'        => 'yelp',
		'youtube.com'     => 'youtube',
	);
	return apply_filters( 'prequelle_social_links_icons', $social_links_icons );
}