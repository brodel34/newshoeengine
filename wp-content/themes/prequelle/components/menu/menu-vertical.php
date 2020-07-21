<?php
/**
 * The main navigation for vertical menus
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( prequelle_do_onepage_menu() ) {

	echo prequelle_one_page_menu();

} else {
	wp_nav_menu( prequelle_get_menu_args( 'primary', 'vertical' ) );
}