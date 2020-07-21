<?php
/**
 * Plugin Name: Wolf Video Thumbnail Generator
 * Plugin URI: http://wolfthemes.com/plugin/wolf-video-thumbnail-generator
 * Description: Generate an image from the first video in the post. Supports YouTube and Vimeo.
 * Version: 1.0.5
 * Author: WolfThemes
 * Author URI: http://wolfthemes.com
 * Requires at least: 4.4.1
 * Tested up to: 4.9.1
 *
 * Text Domain: wolf-video-thumbnail-generator
 * Domain Path: /languages/
 *
 * @package WolfVideoThumbnailGenerator
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

if ( ! class_exists( 'Wolf_Video_Thumbnail_Generator' ) ) {
	/**
	 * Main Wolf_Video_Thumbnail_Generator Class
	 *
	 * Contains the main functions for Wolf_Video_Thumbnail_Generator
	 *
	 * @class Wolf_Video_Thumbnail_Generator
	 * @version 1.0.5
	 * @since 1.0.0
	 */
	class Wolf_Video_Thumbnail_Generator {

		/**
		 * @var string
		 */
		public $version = '1.0.5';

		/**
		 * @var Wolf Video Thumbnail Generator The single instance of the class
		 */
		protected static $_instance = null;

		/**
		 * @var string
		 */
		private $update_url = 'http://plugins.wolfthemes.com/update';

		/**
		 * @var the support forum URL
		 */
		private $support_url = 'http://help.wolfthemes.com/';

		/**
		 * Main Wolf Video Thumbnail Generator Instance
		 *
		 * Ensures only one instance of Wolf Video Thumbnail Generator is loaded or can be loaded.
		 *
		 * @static
		 * @see WVTG()
		 * @return Wolf Video Thumbnail Generator - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Wolf Video Thumbnail Generator Constructor.
		 */
		public function __construct() {
			
			$this->define_constants();
			$this->includes();

			do_action( 'wss_loaded' );
		}

		/**
		 * Define WR Constants
		 */
		private function define_constants() {
			
			$constants = array(
				'WVTG_DEV' => false,
				'WVTG_DIR' => $this->plugin_path(),
				'WVTG_URI' => $this->plugin_url(),
				'WVTG_CSS' => $this->plugin_url() . '/assets/css',
				'WVTG_JS' => $this->plugin_url() . '/assets/js',
				'WVTG_SLUG' => plugin_basename( dirname( __FILE__ ) ),
				'WVTG_PATH' => plugin_basename( __FILE__ ),
				'WVTG_VERSION' => $this->version,
				'WVTG_UPDATE_URL' => $this->update_url,
				'WVTG_SUPPORT_URL' => $this->support_url,
				'WVTG_DOC_URI' => 'http://docs.wolfthemes.com/documentation/plugins/' . plugin_basename( dirname( __FILE__ ) ),
				'WVTG_WOLF_DOMAIN' => 'wolfthemes.com',
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

			/**
			 * Functions used in frontend and admin
			 */
			//include_once( 'inc/wvtg-core-functions.php' );

			if ( $this->is_request( 'admin' ) ) {
				include_once( 'inc/admin/class-wvtg-admin.php' );
				include_once( 'inc/admin/class-wvtg-video-thumbnail.php' );
			}

			if ( $this->is_request( 'ajax' ) ) {
				//include_once( 'inc/ajax/wvtg-ajax-functions.php' );
			}

			if ( $this->is_request( 'frontend' ) ) {
				//include_once( 'inc/frontend/wvtg-functions.php' );
				//include_once( 'inc/frontend/class-wvtg-shortcodes.php' );
			}
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
 * Returns the main instance of WVTG to prevent the need to use globals.
 *
 * @return Wolf_Video_Thumbnail_Generator
 */
function WVTG() {
	return Wolf_Video_Thumbnail_Generator::instance();
}

WVTG(); // Go