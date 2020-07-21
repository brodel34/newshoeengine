<?php
/**
 * Plugin Name: Wolf Gram
 * Plugin URI: http://wolfthemes.com/plugin/wolf-gram/
 * Description: A WordPress Plugin to Display your Instagram Feed.
 * Version: 1.5.8
 * Author: WolfThemes
 * Author URI: http://wolfthemes.com
 * Requires at least: 4.4.1
 * Tested up to: 5.3
 *
 * Text Domain: wolf-gram
 * Domain Path: /languages/
 *
 * @package WolfGram
 * @category Core
 * @author WolfThemes
 * 
 * Being a free product, this plugin is distributed as-is without official support.
 * Verified customers however, who have purchased a premium theme
 * at https://themeforest.net/user/Wolf-Themes/portfolio?ref=Wolf-Themes
 * will have access to support for this plugin in the forums
 * https://help.wolfthemes.com/
 *
 * Copyright (C) 2014 Constantin Saguin
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

if ( ! class_exists( 'Wolf_Instagram' ) ) {
	/**
	 * Main Wolf_Instagram Class
	 *
	 * Contains the main functions for Wolf_Instagram
	 *
	 * @class Wolf_Instagram
	 * @version 1.5.8
	 * @since 1.0.0
	 * @package WolfGram
	 * @author WolfThemes
	 */
	class Wolf_Instagram{

		/**
		 * @var string
		 */
		private $required_php_version = '5.4.0';

		/**
		 * @var string
		 */
		public $version = '1.5.8';

		/**
		 * @var Wolf Gram The single instance of the class
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
		 * Main Wolf Gram Instance
		 *
		 * Ensures only one instance of Wolf Gram is loaded or can be loaded.
		 *
		 * @static
		 * @see WGRM()
		 * @return Wolf Gram - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Wolf Gram Constructor.
		 */
		public function __construct() {

			if ( phpversion() < $this->required_php_version ) {
				add_action( 'admin_notices', array( $this, 'warning_php_version' ) );
				return;
			}

			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			do_action( 'wolf_gram_loaded' );
		}

		/**
		 * Display error notice if PHP version is too low
		 */
		public function warning_php_version() {
			?>
			<div class="notice notice-error">
				<p><?php
					printf(
						esc_html__( '%1$s needs at least PHP %2$s installed on your server. You have version %3$s currently installed. Please contact your hosting service provider if you\'re not able to update PHP by yourself.', 'wolf-gram' ),
						'Wolf Gram',
						$this->required_php_version,
						phpversion()
					);
				?></p>
			</div>
			<?php
		}

		/**
		 * Hook into actions and filters
		 */
		private function init_hooks() {
			add_action( 'init', array( $this, 'init' ), 0 );
			register_activation_hook( __FILE__, array( $this, 'activate' ) );
		}

		/**
		 * Activation function
		 */
		public function activate() {
			// you mey be need this later
		}

		/**
		 * Define WG Constants
		 */
		private function define_constants() {

			$constants = array(
				'WG_DEV' => false,
				'WG_DIR' => $this->plugin_path(),
				'WG_URI' => $this->plugin_url(),
				'WG_CSS' => $this->plugin_url() . '/assets/css',
				'WG_JS' => $this->plugin_url() . '/assets/js',
				'WG_SLUG' => plugin_basename( dirname( __FILE__ ) ),
				'WG_PATH' => plugin_basename( __FILE__ ),
				'WG_VERSION' => $this->version,
				'WG_UPDATE_URL' => $this->update_url,
				'WG_SUPPORT_URL' => $this->support_url,
				'WG_DOC_URI' => 'https://docs.wolfthemes.com/documentation/plugins/' . plugin_basename( dirname( __FILE__ ) ),
				'WG_WOLF_DOMAIN' => 'wolfthemes.com',
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
			include_once( 'inc/wg-core-functions.php' );


			if ( $this->is_request( 'admin' ) ) {
				include_once( 'inc/admin/class-wg-admin.php' );
			}

			if ( $this->is_request( 'frontend' ) ) {
				include_once( 'inc/frontend/class-wg-shortcodes.php' );
			}

			include_once( 'inc/wg-functions.php' );
		}

		/**
		 * register_widget function.
		 *
		 * @access public
		 * @return void
		 */
		public function register_widget() {

			// Include
			include_once( 'inc/widgets/class-wg-widget-gallery.php' );

			// Register widgets
			register_widget( 'WG_Widget_Instagram_Gallery' );
		}

		/**
		 * Init Wolf Gram when WordPress Initialises.
		 */
		public function init() {
			
			// Before init action
			do_action( 'before_wolf_gram_init' );

			// Set up localisation
			$this->load_plugin_textdomain();

			// Hooks
			add_action( 'widgets_init', array( $this, 'register_widget' ) );

			// Init action
			do_action( 'wolf_gram_init' );
		}

		/**
		 * Loads the plugin text domain for translation
		 */
		public function load_plugin_textdomain() {

			$domain = 'wolf-gram';
			$locale = apply_filters( 'wolf-gram', get_locale(), $domain );
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

		/**
		 * Get the template path.
		 * @return string
		 */
		public function template_path() {
			return apply_filters( 'wa_template_path', 'wolf-albums/' );
		}

	} // end class
} // end class check

/**
 * Returns the main instance of WGRM to prevent the need to use globals.
 *
 * @return Wolf_Instagram
 */
function WGRM() {
	return Wolf_Instagram::instance();
}

WGRM(); // Go
