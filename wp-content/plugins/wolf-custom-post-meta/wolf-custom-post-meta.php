<?php
/**
 * Plugin Name: Wolf Custom Post Meta
 * Plugin URI: http://wolfthemes.com/plugin/wolf-custom-post-meta
 * Description: A WordPress plugin to add likes, views and reading time meta to your post.
 * Version: 1.0.1
 * Author: WolfThemes
 * Author URI: http://wolfthemes.com
 * Requires at least: 4.4.1
 * Tested up to: 4.9
 *
 * Text Domain: wolf-custom-post-meta
 * Domain Path: /languages/
 *
 * @package WolfCustom Post Meta
 * @category Core
 * @author WolfThemes
 *
 * Being a free product, this plugin is distributed as-is without official support.
 * Verified customers however, who have purchased a premium theme
 * at http://themeforest.net/user/Wolf-Themes/portfolio?ref=Wolf-Themes
 * will have access to support for this plugin in the forums
 * http://help.wolfthemes.com/
 *
 * Copyright (C) 2013 Constantin Saguin
 * This WordPress Plugin is a free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * It is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * See http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Wolf_Custom_Post_Meta' ) ) {
	/**
	 * Main Wolf_Custom_Post_Meta Class
	 *
	 * Contains the main functions for Wolf_Custom_Post_Meta
	 *
	 * @class Wolf_Custom_Post_Meta
	 * @version 1.0.1
	 * @since 1.0.0
	 */
	class Wolf_Custom_Post_Meta {

		/**
		 * @var string
		 */
		public $version = '1.0.1';

		/**
		 * @var Wolf Custom Post Meta The single instance of the class
		 */
		protected static $_instance = null;

		/**
		 * @var string
		 */
		private $update_url = 'https://plugins.wolfthemes.com/update';

		/**
		 * Main Wolf Custom Post Meta Instance
		 *
		 * Ensures only one instance of Wolf Custom Post Meta is loaded or can be loaded.
		 *
		 * @static
		 * @see WCPM()
		 * @return Wolf Custom Post Meta - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Wolf Custom Post Meta Constructor.
		 */
		public function __construct() {

			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			do_action( 'wolf_custom_post_meta_loaded' );
		}

		/**
		 * Hook into actions and filters
		 */
		private function init_hooks() {
			register_activation_hook( __FILE__, array( $this, 'activate' ) );
			add_action( 'init', array( $this, 'init' ), 0 );
		}

		/**
		 * Activation function
		 */
		public function activate() {

			do_action( 'wolf_custom_post_meta_activated' );
		}

		/**
		 * Define WPB Constants
		 */
		private function define_constants() {

			$constants = array(
				'WCPM_DEV' => false,
				'WCPM_DIR' => $this->plugin_path(),
				'WCPM_URI' => $this->plugin_url(),
				'WCPM_CSS' => $this->plugin_url() . '/assets/css',
				'WCPM_JS' => $this->plugin_url() . '/assets/js',
				'WCPM_IMG' => $this->plugin_url() . '/assets/img',
				'WCPM_SLUG' => plugin_basename( dirname( __FILE__ ) ),
				'WCPM_PATH' => plugin_basename( __FILE__ ),
				'WCPM_VERSION' => $this->version,
				'WCPM_UPDATE_URL' => $this->update_url,
				'WCPM_DOC_URI' => 'https://docs.wolfthemes.com/documentation/plugins/' . plugin_basename( dirname( __FILE__ ) ),
				'WCPM_WOLF_DOMAIN' => 'wolfthemes.com',
			);

			foreach ( $constants as $name => $value ) {
				$this->define( $name, $value );
			}
		}

		/**
		 * Define constant if not already set
		 * @param  string $name
		 * @param  string|bool $value
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
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
		 * Include required core files used in admin and on the frontend.
		 */
		public function includes() {

			include_once( 'inc/wcpm-core-functions.php' );

			if ( $this->is_request( 'admin' ) ) {
				include_once( 'inc/admin/class-wcpm-admin.php' );
			}

			if ( $this->is_request( 'ajax' ) ) {
				include_once( 'inc/ajax/wcpm-ajax-functions.php' );
			}

			if ( $this->is_request( 'frontend' ) ) {
				include_once( 'inc/frontend/wcpm-frontend-functions.php' );
				include_once( 'inc/frontend/class-wcpm-shortcodes.php' );
			}
		}

		/**
		 * Init Wolf Custom Post Meta when WordPress Initialises.
		 */
		public function init() {
			// Before init action
			do_action( 'before_wolf_custom_post_meta_init' );

			// Set up localisation
			$this->load_plugin_textdomain();

			// Init action
			do_action( 'wolf_custom_post_meta_init' );
		}

		/**
		 * Loads the plugin text domain for translation
		 */
		public function load_plugin_textdomain() {

			$domain = 'wolf-custom-post-meta';
			$locale = apply_filters( 'wolf-custom-post-meta', get_locale(), $domain );
			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Get the plugin url.
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}

		/**
		 * Get the plugin path.
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}
	}
}
/**
 * Returns the main instance of WCPM to prevent the need to use globals.
 *
 * @return Wolf_Recipes
 */
function WCPM() {
	return Wolf_Custom_Post_Meta::instance();
}

WCPM(); // Go