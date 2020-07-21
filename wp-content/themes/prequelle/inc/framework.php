<?php
/**
 * Framework
 *
 * A simple class to handle theme functionalities and include files
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Main Framework Class
 */
final class Prequelle_Framework {

	/**
	 * @var The single instance of the class
	 */
	protected static $_instance = null;

	/**
	 * Default theme settings
	 *
	 * @var array
	 */
	public $options = array(
		'menus' => array( 'primary' => 'Primary Menu' ),
		'image_sizes' => array(),
	);

	/**
	 * Main Theme Instance
	 *
	 * Ensures only one instance of the theme is loaded or can be loaded.
	 *
	 * @static
	 * @see PREQUELLE()
	 * @return Theme - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
	}

	/**
	 * Prequelle_Framework Constructor.
	 */
	public function __construct( $options = array() ) {

		$this->options = $options + $this->options;

		$this->includes();

		$this->init_hooks();

		do_action( 'prequelle_framework_loaded' );
	}

	/**
	 * Hook into actions and filters
	 */
	private function init_hooks() {
		add_action( 'after_setup_theme', array( $this, 'setup' ) );
		add_action( 'init', array( $this, 'include_vc_modules' ) );
	}


	/**
	 * Include VC element files
	 */
	public function include_vc_modules() {
		/* Includes VC modules */
		prequelle_include( 'config/vc-post-modules.php' );
	}

	/**
	 * What type of request is this?
	 * string $type ajax, frontend or admin
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
			case 'ajax' :
				return defined( 'DOING_AJAX' );
			case 'cron' :
				return defined( 'DOING_CRON' );
			case 'frontend' :
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	/**
	 * Include required  depending on context
	 */
	public function includes() {

		/* Includes files from theme inc dir in both frontend and backend */
		require get_parent_theme_file_path( '/inc/core-functions.php' );
		require get_parent_theme_file_path( '/inc/vc-extend.php' );
		require get_parent_theme_file_path( '/inc/fonts.php' );
		require get_parent_theme_file_path( '/inc/sidebars.php' );

		/* Includes main config file (colors, add support, WooCommerce thumbnail size etc...) */
		prequelle_include( 'config/config.php' );

		/* Theme custom functions */
		prequelle_include( 'inc/theme-functions.php' );

		if ( $this->is_request( 'admin' ) ) {
			$this->admin_includes();
		}

		/**
		 * For some reason, VC fire all frontend when saving a post
		 * No other choice than to enqueue all frontend in admin as well.
		 */
			$this->frontend_includes();

		if ( $this->is_request( 'ajax' ) ) {
			$this->ajax_includes();
		}

		/* Customizer related function needs to be included in both admin and frontend */
		$this->customizer_includes();
	}

	/**
	 * Includes framework filters, functions, specific front end options & template-tags
	 */
	public function frontend_includes() {

		require get_parent_theme_file_path( '/inc/frontend/utility-functions.php' );
		require get_parent_theme_file_path( '/inc/frontend/frontend-functions.php' );
		require get_parent_theme_file_path( '/inc/frontend/background-functions.php' );
		require get_parent_theme_file_path( '/inc/frontend/plugin-extend-functions.php' );
		require get_parent_theme_file_path( '/inc/frontend/conditional-functions.php' );
		require get_parent_theme_file_path( '/inc/frontend/template-tags.php' );
		require get_parent_theme_file_path( '/inc/frontend/featured-media.php' );
		require get_parent_theme_file_path( '/inc/frontend/menu-functions.php' );
		require get_parent_theme_file_path( '/inc/frontend/query-functions.php' );
		require get_parent_theme_file_path( '/inc/frontend/body-classes.php' );
		require get_parent_theme_file_path( '/inc/frontend/post-attributes.php' );
		require get_parent_theme_file_path( '/inc/frontend/hooks.php' );
		require get_parent_theme_file_path( '/inc/frontend/post.php' );
		require get_parent_theme_file_path( '/inc/frontend/class-walker-comment.php' );
		require get_parent_theme_file_path( '/inc/frontend/styles.php' );
		require get_parent_theme_file_path( '/inc/frontend/woocommerce.php' );
		require get_parent_theme_file_path( '/inc/frontend/scripts.php' );
	}

	/**
	 * Includes ajax functions
	 */
	public function ajax_includes() {

		require get_parent_theme_file_path( '/inc/ajax/ajax-functions.php' );
	}

	/**
	 * Includes framework filters, functions, specific front end options & template-tags
	 */
	public function admin_includes() {

		/* Require admin files */
		require get_parent_theme_file_path( '/inc/admin/theme-activation.php' );
		require get_parent_theme_file_path( '/inc/admin/admin-functions.php' );
		require get_parent_theme_file_path( '/inc/admin/import-functions.php' );
		require get_parent_theme_file_path( '/inc/admin/admin-update-functions.php' );
		require get_parent_theme_file_path( '/inc/admin/admin-scripts.php' );
		require get_parent_theme_file_path( '/inc/admin/class-font-options.php' );
		require get_parent_theme_file_path( '/inc/admin/class-menu-item-custom-fields.php' );

		/* About page */
		prequelle_include( '/inc/admin/class-about-page.php' );

		/* Includes recommend plugins file if available */
		prequelle_include( 'config/plugins.php' );

		/* Includes demo importer file if available */
		prequelle_include( 'config/importer.php' );

		/* Update actions file if available */
		prequelle_include( 'config/update.php' );

		/* Metaboxes file if available */
		prequelle_include( 'config/metaboxes.php' );
	}

	/**
	 * Includes customizer files.
	 *
	 * They must be enqueued in front end and backend
	 */
	public function customizer_includes() {

		require get_parent_theme_file_path( '/inc/customizer/class-customizer-library.php' );
		require get_parent_theme_file_path( '/inc/customizer/extensions/functions.php' );
		require get_parent_theme_file_path( '/inc/customizer/extensions/preview-colors.php' );
		require get_parent_theme_file_path( '/inc/customizer/extensions/preview-fonts.php' );
		require get_parent_theme_file_path( '/inc/customizer/extensions/preview-layout.php' );
		require get_parent_theme_file_path( '/inc/customizer/extensions/frontend.php' );
		require get_parent_theme_file_path( '/inc/mods.php' );
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 */
	public function setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on the theme, use a find and replace
		 * to change 'prequelle' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'prequelle', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
		) );

		/**
		 * Add custom background support
		 */
		add_theme_support( 'custom-background', array(
				'default-color' => '',
				'default-repeat' => 'no-repeat',
				'default-attachment' => 'fixed',
			)
		);

		/**
		 * Add custom header support
		 *
		 * Diable the header text because we will handle it automatically to display the page title
		 */
		add_theme_support( 'custom-header', apply_filters( 'prequelle_custom_header_args', array(
				'header-text' => false,
				'width' => 1900, // recommended width
				'height' => 1280, // recommended height
				'flex-height' => true,
				'flex-width' => true,
			) )
		);

		/**
		 * Indicate widget sidebars can use selective refresh in the Customizer.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically typography
		 */
		add_editor_style( 'assets/css/admin/editor-style.css' );

		$this->set_post_thumbnail_sizes();
		$this->register_nav_menus();
	}

	/**
	 * Set the different thumbnail sizes needed in the design
	 * (can be set in functions.php)
	 */
	public function set_post_thumbnail_sizes() {
		global $content_width;

		set_post_thumbnail_size( $content_width, $content_width / 2 ); // default Post Thumbnail dimensions

		$image_sizes = apply_filters( 'prequelle_image_sizes', $this->options['image_sizes'] );

		if ( $image_sizes != array() ) {
			if ( function_exists( 'add_image_size' ) ) {
				foreach ( $image_sizes as $k => $v ) {
					add_image_size( $k, $v[0], $v[1], $v[2] );
				}
			}
		}
	}

	/**
	 * Register menus
	 */
	public function register_nav_menus() {
		if ( function_exists( 'register_nav_menus' ) ) {
			register_nav_menus( apply_filters( 'prequelle_menus', $this->options['menus'] ) );
		}
	}
} // end class

/**
 * Returns the main instance of PREQUELLE to prevent the need to use globals.
 *
 * @return Prequelle_Framework
 */
function PREQUELLE( $options = array() ) {
	return new Prequelle_Framework( $options );
}