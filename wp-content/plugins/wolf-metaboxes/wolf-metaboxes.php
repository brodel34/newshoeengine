<?php
/**
 * Plugin Name: Wolf Metaboxes
 * Plugin URI: https://wolfthemes.com/plugin/wolf-metaboxes
 * Description: Add metaboxes to your theme
 * Version: 1.0.3
 * Author: WolfThemes
 * Author URI: http://wolfthemes.com
 * Requires at least: 4.4.1
 * Tested up to: 4.9.7
 *
 * Text Domain: wolf-metaboxes
 * Domain Path: /languages/
 *
 * @package WolfMetaboxes
 * @category Core
 * @author WolfThemes
 *
 * Being a free product, this plugin is distributed as-is without official support.
 * Verified customers however, who have purchased a premium theme
 * at https://themeforest.net/user/Wolf-Themes/portfolio?ref=Wolf-Themes
 * will have access to support for this plugin in the forums
 * https://wolfthemes.ticksy.com/
 *
 * Copyright (C) 2017 Constantin Saguin
 * This WordPress Plugin is a free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * It is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * See https://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Wolf_Metaboxes_Plugin' ) ) {
	/**
	 * Main Wolf_Metaboxes_Plugin Class
	 *
	 * Contains the main functions for Wolf_Metaboxes_Plugin
	 *
	 * @class Wolf_Metaboxes_Plugin
	 * @version 1.0.3
	 * @since 1.0.0
	 */
	class Wolf_Metaboxes_Plugin {

		/**
		 * @var string
		 */
		public $version = '1.0.3';

		/**
		 * @var Wolf Metaboxes The single instance of the class
		 */
		protected static $_instance = null;

		/**
		 * @var string
		 */
		private $update_url = 'https://plugins.wolfthemes.com/update';

		/**
		 * @var the support forum URL
		 */
		private $support_url = 'https://help.wolfthemes.com/';

		/**
		 * @var string
		 */
		public $template_url;

		/**
		 * Main Wolf Metaboxes Instance
		 *
		 * Ensures only one instance of Wolf Metaboxes is loaded or can be loaded.
		 *
		 * @static
		 * @see WVCCB()
		 * @return Wolf Metaboxes - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Wolf Metaboxes Constructor.
		 */
		public function __construct() {
			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			// Plugin update notifications
			add_action( 'admin_init', array( $this, 'plugin_update' ) );
		}

		/**
		 * Hook into actions and filters
		 */
		private function init_hooks() {
			add_action( 'init', array( $this, 'init' ), 0 );
		}

		/**
		 * Define WR Constants
		 */
		private function define_constants() {

			$constants = array(
				'WMBOX_DEV' => false,
				'WMBOX_DIR' => $this->plugin_path(),
				'WMBOX_URI' => $this->plugin_url(),
				'WMBOX_CSS' => $this->plugin_url() . '/assets/css',
				'WMBOX_JS' => $this->plugin_url() . '/assets/js',
				'WMBOX_SLUG' => plugin_basename( dirname( __FILE__ ) ),
				'WMBOX_PATH' => plugin_basename( __FILE__ ),
				'WMBOX_VERSION' => $this->version,
				'WMBOX_UPDATE_URL' => $this->update_url,
				'WMBOX_SUPPORT_URL' => $this->support_url,
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
		 * Include required core files used in admin and on the frontend.
		 */
		public function includes() {

			if ( is_admin() ) {
				include_once( 'inc/admin/lib/class-metabox-tabs.php' );
				include_once( 'inc/admin/admin-functions.php' );
			}
		}

		/**
		 * Init Wolf Metaboxes when WordPress Initialises.
		 */
		public function init() {

			// Set up localisation
			$this->load_plugin_textdomain();
		}

		/**
		 * Loads the plugin text domain for translation
		 */
		public function load_plugin_textdomain() {

			$domain = 'wolf-metaboxes';
			$locale = apply_filters( 'wolf-metaboxes', get_locale(), $domain );
			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Plugin update
		 */
		public function plugin_update() {
			$plugin_slug = WMBOX_SLUG;
			$plugin_path = WMBOX_PATH;
			$remote_path = WMBOX_UPDATE_URL . '/' . $plugin_slug;
			$plugin_data = get_plugin_data( WMBOX_DIR . '/' . WMBOX_SLUG . '.php' );
			$current_version = $plugin_data['Version'];
			include_once( WMBOX_DIR . '/inc/admin/lib/class-update.php');
			new Wolf_Metaboxes_Update( $current_version, $remote_path, $plugin_path );
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
	} // end class
} // end class check

/**
 * Returns the main instance of Wolf_Metaboxes to prevent the need to use globals.
 *
 * @return Wolf_Metaboxes
 */
function WOLFMETABOXES() {
	return Wolf_Metaboxes_Plugin::instance();
}

WOLFMETABOXES(); // Go