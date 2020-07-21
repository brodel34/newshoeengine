<?php
/**
 * Plugin Name: Wolf WPBakery Page Builder Extension
 * Plugin URI: http://wolfthemes.com/plugin/wolf-visual-composer
 * Description: A WordPress plugin that extends WPBakery Page Builder for Wolf Themes.
 * Version: 3.1.1
 * Author: WolfThemes
 * Author URI: http://wolfthemes.com
 * Requires at least: 4.5
 * Tested up to: 5.3
 *
 * Text Domain: wolf-visual-composer
 * Domain Path: /languages/
 *
 * @package WolfVisualComposer
 * @category Core
 * @author WolfThemes
 *
 * Help:
 * https://wolfthemes.ticksy.com/
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wolf_Visual_Composer' ) ) {
	/**
	 * Main Wolf_Visual_Composer Class
	 *
	 * Contains the main functions for Wolf_Visual_Composer
	 *
	 * @class Wolf_Visual_Composer
	 * @version 3.1.1
	 * @since 1.0.0
	 */
	class Wolf_Visual_Composer {

		/**
		 * @var string
		 */
		public $version = '3.1.1';

		/**
		 * @var Wolf WPBakery Page Builder Extension The single instance of the class
		 */
		protected static $_instance = null;

		/**
		 * @var string
		 */
		private $update_url = 'https://plugins.wolfthemes.com/update';

		/**
		 * @var the support forum URL
		 */
		private $support_url = 'https://wlfthm.es/help/';

		/**
		 * @var string
		 */
		public $template_url;

		/**
		 * Main Wolf WPBakery Page Builder Extension Instance
		 *
		 * Ensures only one instance of Wolf WPBakery Page Builder Extension is loaded or can be loaded.
		 *
		 * @static
		 * @see WVC()
		 * @return Wolf WPBakery Page Builder Extension - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Wolf WPBakery Page Builder Extension Constructor.
		 */
		public function __construct() {

			/**
			 * WPBakery Page Builder not installed
			 */
			if ( ! defined( 'WPB_VC_VERSION' ) ) {
				add_action( 'admin_notices', array( $this, 'show_vc_missing_notice' ) );
				return;
			}

			include_once( 'inc/admin/auth.php' );

			//var_dump( wvc_is_activated() );

			if ( ! wvc_is_activated() ) {
				add_action( 'admin_notices', 'wvc_activation_notice' );
				if ( $this->is_request( 'admin' ) ) {
					include_once( 'inc/admin/admin-theme-activation.php' );
				}
				return;
			}

			if ( wvc_wrong_theme() ) {
				add_action( 'admin_notices', 'wvc_show_wrong_theme_notice' );
				return;
			}

			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			if ( get_transient( 'wvc_activation_notice' ) ) {
				add_action( 'admin_notices', 'wvc_show_activation_notice' );
			}

			do_action( 'wolf_vc_loaded' );
		}

		/**
		 * Hook into actions and filters
		 */
		private function init_hooks() {
			register_activation_hook( __FILE__, array( $this, 'activate' ) );

			add_action( 'after_setup_theme', array( $this, 'include_template_functions' ), 11 );
			add_action( 'init', array( $this, 'init' ), 0 );

			// Includes element after init hook to allow filtering by theme
			add_action( 'init', array( $this, 'include_elements' ) );
		}

		/**
		 * Activation function
		 */
		public function activate() {

			//do_action( 'vc_restore_default_settings_preset', null, 'vc_section' );

			if ( ! get_transient( 'wvc_activation_notice' ) && ! get_option( 'wvc_activation_notice_set' ) ) {
				set_transient( 'wvc_activation_notice', true, 30 * DAY_IN_SECONDS );
				update_option( 'wvc_activation_notice_set', true );
			}

			update_option( 'wpb_js_gutenberg_disable', true );
		}

		/**
		 * Define WR Constants
		 */
		private function define_constants() {

			$constants = array(
				'WVC_DEV' => false,
				'WVC_OK' => true,
				'WVC_DIR' => $this->plugin_path(),
				'WVC_URI' => $this->plugin_url(),
				'WVC_CSS' => $this->plugin_url() . '/assets/css',
				'WVC_JS' => $this->plugin_url() . '/assets/js',
				'WVC_SLUG' => plugin_basename( dirname( __FILE__ ) ),
				'WVC_PATH' => plugin_basename( __FILE__ ),
				'WVC_VERSION' => $this->version,
				'WVC_UPDATE_URL' => $this->update_url,
				'WVC_SUPPORT_URL' => $this->support_url,
				'WVC_DOC_URI' => 'https://docs.wolfthemes.com/documentation/plugins/' . plugin_basename( dirname( __FILE__ ) ),
				'WVC_WOLF_DOMAIN' => 'wolfthemes.com',
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

			// Functions used in frontend and admin
			include_once( 'inc/core-functions.php' );
			include_once( 'inc/utility-functions.php' );
			include_once( 'inc/google-fonts.php' );
			include_once( 'inc/vc-editor-scripts.php' );
			include_once( 'inc/vc-presets.php' );
			include_once( 'inc/vc-extend.php' );
			include_once( 'inc/vc-custom-fields.php' );
			include_once( 'inc/vc-additional-params.php' );
			include_once( 'inc/theme-functions.php' );
			include_once( 'inc/user-functions.php' );
			include_once( 'inc/conditional-functions.php' );

			// Containers background
			include_once( 'inc/params/background-params.php' );
			include_once( 'inc/params/style-params.php' );

			// Section
			include_once( 'inc/params/section-params.php' );

			// Custom heading
			include_once( 'inc/params/heading-params.php' );

			// Big Text
			include_once( 'inc/params/bigtext-params.php' );
			include_once( 'inc/bigtext.php' );

			// Row
			include_once( 'inc/params/row-params.php' );
			include_once( 'inc/params/row-inner-params.php' );

			// Column
			include_once( 'inc/params/column-params.php' );
			include_once( 'inc/params/column-inner-params.php' );

			// Icon functions
			include_once( 'inc/icon-styles.php' );
			include_once( 'inc/icon-libraries.php' );
			include_once( 'inc/params/icon-params.php' );

			// Button functions
			include_once( 'inc/params/button-params.php' );
			include_once( 'inc/button.php' );

			// Social icons
			include_once( 'inc/social-icons.php' );
			include_once( 'inc/class-widget-socials.php' );

			// Heading
			include_once( 'inc/heading.php' );

			// MailChimp
			include_once( 'inc/class-mailchimp.php' );
			include_once( 'inc/class-widget-mailchimp.php' );
			include_once( 'inc/mailchimp.php' );

			// Background functions
			include_once( 'inc/background-functions.php' );

			// Login Form
			include_once( 'inc/login-form.php' );

			// Modal Window
			include_once( 'inc/modal-window.php' );

			// Privacy Policy Message
			include_once( 'inc/privacy-policy-message.php' );

			if ( $this->is_request( 'admin' ) ) {

				if ( ! get_transient( 'wvc_activation_notice' ) && ! get_option( 'wvc_activation_notice_set' ) ) {
					set_transient( 'wvc_activation_notice', true, 30 * DAY_IN_SECONDS );
					update_option( 'wvc_activation_notice_set', true );
				}

				include_once( 'inc/admin/admin-theme-activation.php' );
				include_once( 'inc/admin/class-admin.php' );
			}

			if ( $this->is_request( 'ajax' ) ) {
				$this->ajax_includes();
			}

			if ( $this->is_request( 'frontend' ) ) {
				$this->frontend_includes();
			}
		}

		/**
		 * Include required ajax files.
		 */
		public function ajax_includes() {
			include_once( 'inc/ajax/ajax-functions.php' );
		}

		/**
		 * Include required frontend files.
		 */
		public function frontend_includes() {

			include_once( 'inc/frontend/frontend-functions.php' );
			include_once( 'inc/frontend/template-hooks.php' );
			include_once( 'inc/frontend/theme-frontend-functions.php' );
			include_once( 'inc/frontend/styles.php' );
			include_once( 'inc/frontend/colors.php' );
			include_once( 'inc/frontend/scripts.php' );
		}

		/**
		 * Include element files
		 */
		public function include_elements() {
			// Includes all shortcode files

			// Get elements list
			$elements_slugs = wvc_get_element_list();

			foreach ( $elements_slugs as $slug ) {

				include_once( 'inc/elements/' . sanitize_title_with_dashes( $slug ) . '.php' );

				if ( is_file( WVC_DIR . '/inc/shortcodes/' . sanitize_title_with_dashes( $slug ) . '.php' ) ) {
					include_once( 'inc/shortcodes/' . sanitize_title_with_dashes( $slug ) . '.php' );
				}
			}
		}

		/**
		 * Function used to Init Wolf WPBakery Page Builder Extension Template Functions - This makes them pluggable by plugins and themes.
		 */
		public function include_template_functions() {
			include_once( 'inc/frontend/template-functions.php' );
		}

		/**
		 * Init Wolf WPBakery Page Builder Extension when WordPress Initialises.
		 */
		public function init() {

			// Set up localisation
			$this->load_plugin_textdomain();

			// Variables
			$this->template_url = apply_filters( 'wolf_vc_url', 'views/' );

			// Init action
			do_action( 'wolf_vc_init' );
		}

		/**
		 * Loads the plugin text domain for translation
		 */
		public function load_plugin_textdomain() {

			$domain = 'wolf-visual-composer';
			$locale = apply_filters( 'wolf-visual-composer', get_locale(), $domain );
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
			return apply_filters( 'wvc_template_path', 'views/' );
		}

		/**
		 * Get the template path.
		 * @return string
		 */
		public function shortcode_template_path() {
			return apply_filters( 'wvc_shortcode_template_path', 'templates/' );
		}

		/**
		 * Get Ajax URL.
		 * @return string
		 */
		public function ajax_url() {
			return admin_url( 'admin-ajax.php', 'relative' );
		}

		public function show_vc_missing_notice() {
			$plugin_data = get_plugin_data( __FILE__ );
				echo '<div class="notice notice-warning">
					<p>' . sprintf(
						wp_kses_post( __( '<strong>%s</strong> requires <strong><a href="%s" target="_blank">%s</a></strong> plugin to be installed.', 'wolf-visual-composer' ) ),
							$plugin_data['Name'],
							'https://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431?ref=wolf-themes',
							'WPBakery Page Builder'
						) . '</p>
				</div>';
		}
	} // end class
} // end class check

/**
 * Returns the main instance of Wolf_Visual_Composer to prevent the need to use globals.
 *
 * @return Wolf_Visual_Composer
 */
function WVC() {
	return Wolf_Visual_Composer::instance();
}

WVC(); // Go