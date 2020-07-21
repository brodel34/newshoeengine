<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WVC_Mailchimp' ) ) {
	/**
	 * WVC_Mailchimp Class
	 *
	 * Contains user and moderator actions, register, login, post ticket and comment, and handles session messages
	 *
	 * @class WVC_Mailchimp
	 * @author WolfThemes
	 */
	class WVC_Mailchimp {

		/**
		 * @var Wolf WPBakery Page Builder Extension The single instance of the class
		 */
		protected static $_instance = null;

		/**
		 * Main Wolf WPBakery Page Builder Extension Instance
		 *
		 * Ensures only one instance of Wolf WPBakery Page Builder Extension is loaded or can be loaded.
		 *
		 * @static
		 * @see WVCM()
		 * @return Wolf WPBakery Page Builder Extension - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Cloning is forbidden.
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'wolf-visual-composer' ), '1.0' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'wolf-visual-composer' ), '1.0' );
		}

		/**
		 * WVC_Mailchimp Constructor.
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {

			if ( $this->api_key() ) {
				require_once( WVC_DIR . '/inc/lib/Mailchimp.class.php' );
				$this->MailChimp = new MailChimp( $this->api_key() );
			}
		}

		/**
		 * Get API key for user theme option
		 *
		 * @access private
		 * @return string
		 */
		private function api_key() {

			if ( wolf_vc_get_option( 'mailchimp', 'mailchimp_api_key' ) ) {
				return wolf_vc_get_option( 'mailchimp', 'mailchimp_api_key' );
			}
		}

		/**
		 * Subscribe from a given email
		 *
		 * @access public
		 * @param string $list_id
		 * @param string $email
		 * @return void
		 */
		public function subscribe( $list_id, $email, $f_name, $l_name ) {

			$result = $this->MailChimp->call(
				'lists/subscribe',
				array(
					'id'                		=> esc_attr( $list_id ),
					'email'             		=> array( 'email' => sanitize_email( $email ) ),
					'merge_vars'        	=> array( 'FNAME' => esc_attr( $f_name ), 'LNAME' => esc_attr( $l_name ) ),
					'double_optin'      	=> false,
					'update_existing'   	=> true,
					'replace_interests' 	=> false,
					'send_welcome'      	=> false,
				)
			);
		}

		/**
		 * Unsubscribe from a given email (not used)
		 *
		 * @access public
		 * @param string $list_id
		 * @param string $email
		 * @return void
		 */
		public function unsubscribe( $list_id, $email ) {

			$result = $this->MailChimp->call(
				'lists/unsubscribe', array(
					'id'	=> $list_id,
					'email'	=> array( 'email' => $email ),
				)
			);
		}
} // end class

} // class_exists check

/**
 * Returns the main instance of WVC_Mailchimp to prevent the need to use globals.
 *
 * @return WVC_Mailchimp
 */
function WVCM() {
	return WVC_Mailchimp::instance();
}

WVCM(); // Go