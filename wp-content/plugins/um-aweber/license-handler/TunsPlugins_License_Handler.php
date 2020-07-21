<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'TunsPLugins_License' ) ) :

/**
 * TunsPLugins_License Class
 */
class TunsPLugins_License {

	private $file;
	private $license;
	private $item_name;
	private $item_slug;
	private $version;
	private $author;
	private $api_url = 'https://tunsplugins.com';

	private $key_statuses;
	private $activate_errors;
	private $last_activation_error;

	/**
	 * Class constructor
	 *
	 * @param string  $_file
	 * @param string  $_item_name
	 * @param string  $_item_slug
	 * @param string  $_version
	 * @param string  $_author
	 */
	function __construct( $_file, $_item_name, $_item_slug, $_version, $_author ) {

		$this->file           	= $_file;
		$this->item_name      	= $_item_name;
		$this->item_slug 		= strtolower( $_item_slug );
		$this->version        	= $_version;
		$this->license 		 	= null !== get_option( 'tunsplugins_'.$this->item_slug.'_license_key' ) ? trim( get_option( 'tunsplugins_'.$this->item_slug.'_license_key' ) ) : '';
		$this->author         	= $_author;

		$this->key_statuses = array(
			'invalid' 		=> 'The entered license key is not valid.',
			'expired' 		=> 'Your license key has expired and needs to be renewed. <a href="https://tunsplugins.com" target="_new">Renew Now</a>',
			'inactive' 		=> 'Your license key is valid, but is not active.',
			'disabled' 		=> 'Your license key is currently disabled. Please contact <a href="https://tunsplugins.com/support" target="_new">support</a>',
			'site_inactive' => 'Your license key is valid, but not active for this site.',
			'valid' 		=> 'Your license key is valid and active for this site.'
		);

		$this->activate_errors = array(
			'missing' 		=> 'The provided license key does not seem to exist.',
			'revoked' 		=> 'The provided license key has been revoked. Please contact <a href="https://tunsplugins.com/support" target="_new">support</a>',
			'no_activations_left' => 'This license key has been activated the maximum number of times.',
			'expired' 		=> 'This license key has expired. <a href="https://tunsplugins.com" target="_new">Renew Now</a>',
			'key_mismatch' 	=> 'An unknown error has occurred: key_mismatch'
		);

		// Setup hooks
		$this->includes();
		$this->hooks();
		$this->auto_updater();
	}

	/**
	 * Include the updater class
	 *
	 * @access  private
	 * @return  void
	 */
	private function includes() {
		if ( ! class_exists( 'EDD_SL_Plugin_Updater' ) ) require_once 'EDD_SL_Plugin_Updater.php';
	}

	/**
	 * Setup hooks
	 *
	 * @access  private
	 * @return  void
	 */
	private function hooks() {

		// Activate license key on settings save
		add_action( 'admin_init', array( $this, 'activate_license' ) );

		// Deactivate license key
		add_action( 'admin_init', array( $this, 'deactivate_license' ) );

		// Check license key status
		add_action( 'current_screen', array( $this, 'check_license' ) );

		add_action( 'tunsplugins_licenses', array( $this, 'settings' ) );

	}

	/**
	 * Auto updater
	 *
	 * @access  private
	 * @return  void
	 */
	private function auto_updater() {
		// Setup the updater
		$edd_updater = new EDD_SL_Plugin_Updater(
			$this->api_url,
			$this->file,
			array(
				'version'   	=> $this->version,
				'license'   	=> $this->license,
				'item_name' 	=> $this->item_name,
				'author'    	=> $this->author,
				'wp_override'	=> true
			)
		);
	}


	/**
	 * Add license field to setting
	 *
	 * @access  public
	 */
	public function settings(){
		include 'settings.php';
	}


	/**
	 * Activate the license key
	 *
	 * @access  public
	 * @return  void
	 */
	public function activate_license() {

		if ( ! isset( $_POST['tunsplugins_action'] ) )
			return;

		if ( ! isset( $_POST[ 'tunsplugins_'.$this->item_slug.'_license_key' ] ) )
			return;

		if ( 'valid' == get_option( 'tunsplugins_'.$this->item_slug.'_license_status' ) )
			return;

		$license = sanitize_text_field( $_POST[ 'tunsplugins_'.$this->item_slug.'_license_key' ] );

		// Data to send to the API
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_name'  => urlencode( $this->item_name )
		);

		// Call the API
		$response = wp_remote_get(
			esc_url_raw( add_query_arg( $api_params, $this->api_url ) ),
			array(
				'timeout'   => 15,
				'body'      => $api_params,
				'sslverify' => false
			)
		);

		// Make sure there are no errors
		if ( is_wp_error( $response ) )
			return;

		// Decode license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		update_option( 'tunsplugins_'.$this->item_slug.'_license_key', $license );
		update_option( 'tunsplugins_'.$this->item_slug.'_license_status', $license_data->license );

		if ( isset($license_data->error) ) {
			$this->last_activation_error = $license_data->error;
			add_action( 'admin_notices', array($this, 'notice_license_activate_error') );
		} else if ( $license_data->license == "invalid" ) {
			add_action( 'admin_notices', array($this, 'notice_license_invalid') );
		} else {
			add_action( 'admin_notices', array($this, 'notice_license_valid') );
		}
	}


	/**
	 * Deactivate the license key
	 *
	 * @access  public
	 * @return  void
	 */
	public function deactivate_license() {

		if ( ! isset( $_POST['tunsplugins_action'] ) )
			return;

		if ( ! isset( $_POST[ 'tunsplugins_'.$this->item_slug.'_license_key' ] ) )
			return;

		// Run on deactivate button press
		if ( isset( $_POST[ 'tunsplugins_license_deactivate' ] ) ) {

			// Data to send to the API
			$api_params = array(
				'edd_action' => 'deactivate_license',
				'license'    => $this->license,
				'item_name'  => urlencode( $this->item_name )
			);

			// Call the API
			$response = wp_remote_get(
				esc_url_raw( add_query_arg( $api_params, $this->api_url ) ),
				array(
					'timeout'   => 15,
					'sslverify' => false
				)
			);

			// Make sure there are no errors
			if ( is_wp_error( $response ) )
				return;

			// Decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// $license_data->license will be either "deactivated" or "failed"
			if ( $license_data->license == "failed" ) {
				// warn user
				add_action( 'admin_notices', array($this, 'notice_license_deactivate_failed') );
			} else {
				delete_option( 'tunsplugins_'.$this->item_slug.'_license_status' );
				add_action( 'admin_notices', array( $this, 'notice_license_deactivate_success' ) );
			}
		}
	}


	/**
	 * check_license
	 * Retrieve license status for current site and store in status setting.
	 *
	 * @access public
	 * @return void
	 */
	public function check_license( $current_screen ) {

		if ( 'plugins_page_tunsplugins-licenses' == $current_screen->id ) {

			if ( isset( $_REQUEST['tunsplugins_license_activate'] ) || isset( $_REQUEST['tunsplugins_license_deactivate'] ) ) {
				return;
			}

			$license = $this->license;

			if ( empty( $license ) ) return;

			update_option( 'tunsplugins_'.$this->item_slug.'_license_status', $this->get_license_status() );
		}
	}


	/**
	 * get_license_status
	 * Retrieve status of license key for current site.
	 *
	 * @access public
	 * @return void
	 */
	public function get_license_status() {

		$license = $this->license;

		if ( empty($license) ) return;

		$api_params = array(
			'edd_action'	=> 'check_license',
			'license' 		=> $license,
			'item_name' 	=> urlencode( $this->item_name )
		);

		// Call the API
		$response = wp_remote_get(
			esc_url_raw( add_query_arg( $api_params, $this->api_url ) ),
			array(
				'timeout'   => 15,
				'sslverify' => false
			)
		);

		if ( is_wp_error( $response ) )
			return false;

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		return $license_data->license;
	}


	/**
	 * notice_license_invalid function.
	 *
	 * @access public
	 * @return void
	 */
	function notice_license_invalid() {
		?>
		<div class="error">
			<p><?php echo $this->item_name; ?> license activation was not successful. Please check your key status below for more information.</p>
		</div>
		<?php
	}


	/**
	 * notice_license_valid function.
	 *
	 * @access public
	 * @return void
	 */
	function notice_license_valid() {
		?>
		<div class="updated">
			<p><?php echo $this->item_name; ?> license successfully activated.</p>
		</div>
		<?php
	}


	/**
	 * notice_license_deactivate_failed function.
	 *
	 * @access public
	 * @return void
	 */
	function notice_license_deactivate_failed() {
		?>
		<div class="error">
			<p><?php echo $this->item_name; ?> license deactivation failed. Please try again, or contact support.</p>
		</div>
		<?php
	}


	/**
	 * notice_license_deactivate_success function.
	 *
	 * @access public
	 * @return void
	 */
	function notice_license_deactivate_success() {
		?>
		<div class="updated">
			<p><?php echo $this->item_name; ?> license deactivated successfully.</p>
		</div>
		<?php
	}


	/**
	 * notice_license_activate_error function.
	 *
	 * @access public
	 * @param mixed $error
	 * @return void
	 */
	function notice_license_activate_error($error) {
		?>
		<div class="error">
			<p><?php echo $this->item_name; ?> license activation failed: <?php echo $this->activate_errors[$this->last_activation_error]; ?></p>
		</div>
		<?php
	}

}

endif; // end class_exists check