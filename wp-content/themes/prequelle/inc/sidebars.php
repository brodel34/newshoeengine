<?php
/**
 * Prequelle sidebars
 *
 * Register default sidebar for the theme with the prequelle_sidebars_init function
 * This function can be overwritten in a child theme
 *
 * @package WordPress
 * @subpackage Prequelle
 * @since 1.0.0
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Register blog and page sidebar and footer widget area.
 */
function prequelle_sidebars_init() {

	/* Blog Sidebar */
	register_sidebar(
		array(
			'name'          		=> esc_html__( 'Blog Sidebar', 'prequelle' ),
			'id'            		=> 'sidebar-main',
			'description'		=> esc_html__( 'Add widgets here to appear in your blog sidebar.', 'prequelle' ),
			'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  		=> '</div></aside>',
			'before_title' 	 	=> '<h3 class="widget-title">',
			'after_title'  	 	=> '</h3>',
		)
	);

	/* Page Sidebar */
	register_sidebar(
		array(
			'name'          		=> esc_html__( 'Page Sidebar', 'prequelle' ),
			'id'            		=> 'sidebar-page',
			'description'		=> esc_html__( 'Add widgets here to appear in your page sidebar.', 'prequelle' ),
			'before_widget' 	=> '<aside id="%1$s" class="clearfix widget %2$s"><div class="widget-content">',
			'after_widget'		=> '</div></aside>',
			'before_title'  		=> '<h3 class="widget-title">',
			'after_title'   		=> '</h3>',
		)
	);

	/* Side Panel Sidebar */
	register_sidebar(
		array(
			'name'          		=> esc_html__( 'Side Panel Sidebar', 'prequelle' ),
			'id'            		=> 'sidebar-side-panel',
			'description'		=> esc_html__( 'Add widgets here to appear in your side panel if enabled.', 'prequelle' ),
			'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  		=> '</div></aside>',
			'before_title' 	 	=> '<h3 class="widget-title">',
			'after_title'  	 	=> '</h3>',
		)
	);

	/* Footer Sidebar */
	register_sidebar(
		array(
			'name'          		=> esc_html__( 'Footer Widget Area', 'prequelle' ),
			'id'            		=> 'sidebar-footer',
			'description'		=> esc_html__( 'Add widgets here to appear in your footer.', 'prequelle' ),
			'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'		=> '</div></aside>',
			'before_title'  		=> '<h3 class="widget-title">',
			'after_title'   		=> '</h3>',
		)
	);

	/* Discography Siderbar */
	if ( class_exists( 'Wolf_Discography' ) ) {
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Discography Sidebar', 'prequelle' ),
				'id'            		=> 'sidebar-discography',
				'description'   		=> esc_html__( 'Appears on the discography pages if a layout with sidebar is set', 'prequelle' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}

	/* Videos Siderbar */
	if ( class_exists( 'Wolf_Videos' ) ) {
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Videos Sidebar', 'prequelle' ),
				'id'            		=> 'sidebar-videos',
				'description'   		=> esc_html__( 'Appears on the videos pages if a layout with sidebar is set', 'prequelle' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}

	/* Albums Siderbar */
	if ( class_exists( 'Wolf_Albums' ) ) {
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Albums Sidebar', 'prequelle' ),
				'id'            		=> 'sidebar-albums',
				'description'   		=> esc_html__( 'Appears on the albums pages if a layout with sidebar is set', 'prequelle' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}

	/* Photos Siderbar */
	if ( class_exists( 'Wolf_Photos' ) ) {
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Photo Sidebar', 'prequelle' ),
				'id'            		=> 'sidebar-attachment',
				'description'   		=> esc_html__( 'Appears before the image details on single photo pages', 'prequelle' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Photo Sidebar Secondary', 'prequelle' ),
				'id'            		=> 'sidebar-attachment-secondary',
				'description'   		=> esc_html__( 'Appears after the image details on single photo pages', 'prequelle' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}

	/* Events Siderbar */
	if ( class_exists( 'Wolf_Events' ) ) {
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Events Sidebar', 'prequelle' ),
				'id'            		=> 'sidebar-events',
				'description'   		=> esc_html__( 'Appears on the events pages if a layout with sidebar is set', 'prequelle' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}

	/* Artists Siderbar */
	if ( class_exists( 'Wolf_Artists' ) ) {
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Artists Sidebar', 'prequelle' ),
				'id'            		=> 'sidebar-artists',
				'description'   		=> esc_html__( 'Appears on the artists pages if a layout with sidebar is set', 'prequelle' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}

	/* Woocommerce Siderbar */
	if ( class_exists( 'Woocommerce' ) ) {
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Shop Sidebar', 'prequelle' ),
				'id'            		=> 'sidebar-shop',
				'description'   		=> esc_html__( 'Add widgets here to appear in your shop page if a sidebar is visible.', 'prequelle' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}
}
add_action( 'widgets_init', 'prequelle_sidebars_init' );