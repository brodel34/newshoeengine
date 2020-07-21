<?php
/**
 * Plugin Name: Wolf Share
 * Plugin URI: http://wolfthemes.com/plugin/wolf-share
 * Description: A WordPress plugin to add share buttons to your post.
 * Version: 1.0.7
 * Author: WolfThemes
 * Author URI: http://wolfthemes.com
 * Requires at least: 4.4.1
 * Tested up to: 4.9.5
 *
 * Text Domain: wolf-share
 * Domain Path: /languages/
 *
 * @package WolfShare
 * @category Core
 * @author WolfThemes
 *
 * Being a free product, this plugin is distributed as-is without official support.
 * Verified customers however, who have purchased a premium theme
 * at http://themeforest.net/user/Wolf-Themes/portfolio?ref=Wolf-Themes
 * will have access to support for this plugin in the forums
 * https://wolfthemes.ticksy.com/
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

if ( ! class_exists( 'Wolf_Share' ) ) {
	/**
	 * Main Wolf_Share Class
	 *
	 * Contains the main functions for Wolf_Share
	 *
	 * @class Wolf_Share
	 * @version 1.0.7
	 * @since 1.0.0
	 */
	class Wolf_Share {

		/**
		 * @var string
		 */
		public $version = '1.0.7';

		/**
		 * @var Wolf Share The single instance of the class
		 */
		protected static $_instance = null;

		/**
		 * @var string
		 */
		private $update_url = 'https://plugins.wolfthemes.com/update';

		/**
		 * Main Wolf Share Instance
		 *
		 * Ensures only one instance of Wolf Share is loaded or can be loaded.
		 *
		 * @static
		 * @see WSHARE()
		 * @return Wolf Share - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Wolf Share Constructor.
		 */
		public function __construct() {

			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			do_action( 'wolf_share_loaded' );
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

			do_action( 'wolf_share_activated' );
		}

		/**
		 * Define WPB Constants
		 */
		private function define_constants() {

			$constants = array(
				'WS_DEV' => false,
				'WS_DIR' => $this->plugin_path(),
				'WS_URI' => $this->plugin_url(),
				'WS_CSS' => $this->plugin_url() . '/assets/css',
				'WS_JS' => $this->plugin_url() . '/assets/js',
				'WS_IMG' => $this->plugin_url() . '/assets/img',
				'WS_SLUG' => plugin_basename( dirname( __FILE__ ) ),
				'WS_PATH' => plugin_basename( __FILE__ ),
				'WS_VERSION' => $this->version,
				'WS_UPDATE_URL' => $this->update_url,
				'WS_DOC_URI' => 'https://docs.wolfthemes.com/documentation/plugins/' . plugin_basename( dirname( __FILE__ ) ),
				'WS_WOLF_DOMAIN' => 'wolfthemes.com',
			);

			foreach ( $constants as $name => $value ) {
				$this->define( $name, $value );
			}

			// var_dump( WPB_UPLOAD_URI );
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

			include_once( 'inc/ws-core-functions.php' );

			if ( $this->is_request( 'admin' ) ) {
				include_once( 'inc/admin/class-ws-admin.php' );
			}

			if ( $this->is_request( 'ajax' ) ) {
				include_once( 'inc/ajax/ws-ajax-functions.php' );
			}

			if ( $this->is_request( 'frontend' ) ) {
				include_once( 'inc/frontend/ws-frontend-functions.php' );
				include_once( 'inc/frontend/class-ws-shortcodes.php' );
			}
		}

		/**
		 * Init Wolf Share when WordPress Initialises.
		 */
		public function init() {
			// Before init action
			do_action( 'before_wolf_share_init' );

			// Set up localisation
			$this->load_plugin_textdomain();

			// Init action
			do_action( 'wolf_share_init' );
		}

		/**
		 * Loads the plugin text domain for translation
		 */
		public function load_plugin_textdomain() {

			$domain = 'wolf-share';
			$locale = apply_filters( 'wolf-share', get_locale(), $domain );
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
 * Returns the main instance of WSHARE to prevent the need to use globals.
 *
 * @return Wolf_Recipes
 */
function WSHARE() {
	return Wolf_Share::instance();
}

WSHARE(); // Go