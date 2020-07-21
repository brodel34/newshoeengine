<?php
/**
 * Wolf Gram Options.
 *
 * @class WD_Options
 * @author WolfThemes
 * @category Admin
 * @package WolfGram/Admin
 * @version 1.5.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WG_Options class.
 */
class WG_Options {
	/**
	 * Constructor
	 */
	public function __construct() {
		// default options
		add_action( 'admin_init', array( $this, 'default_options' ) );

		// register settings
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		// add option sub-menu
		add_action( 'admin_menu', array( $this, 'add_settings_menu' ) );
	}

	/**
	 * Add settings menu
	 *
	 */
	public function add_settings_menu() {
		$icon = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAADB0lEQVQ4T5WUW2gUZxTHf9/Mmt2d7EWz0WitoAbxgpEIpaWhhUJtUYwXrLcoiBeIPnh58UERoQ99aKSK0KfUgvSpbWwjIlKVUmNh0QeViFHwkkR2s667cZNNdnc2MzsXmU2ytG6i5jwd5jvf7/z/nPONOLVtY+2G1EC4YrWn5t7KIPvmL2DDYAvz206g9D3gvcKyLGRxWxiuXaJlZ2O46cVwg93o4U791ICmBZplobik0b6WFRYt29eaTYmMNFVgv2rQ1j2MbkFd1TRWzfM7QEu07FhnN8WHmCrw72iGXtNHsKqaWO9T9i+bjjJN4q3AGYM9fLh0BYFZNUVHw8k40Udd6GqOu8k8t16ZVHgVzOwgzctDyILJgV91nuejT+pJpTN0Pe4GW1C3dCGhgI/Oq5fp6bxLZzLP4IhJ/SwPIY+r2HRChd9mjrHaFeHsz79z8VoHtm0XiyVJ4ps1X3Boz1buXPqD2MP7ZUsgwpcudFSnB2ZLVbIrHXKJBy6loqFy8dyz534T7VdvIMkSHm8lQpLxB4KkEnE2fv0Zh3dvsfsjkV5h6NH/UkXs+bPR9mNhGCZ98Zdsaj6GkAQzZs4B20bxBaie/QEvIt30x6K0t35P0O/F7Xbj9Sql+2VAXS9w/d9bnPzhJxSfH2+ln4FEHCEEcxcsYiCVIDeU5rujB/j84zo0bQSfUzcGnRh48zYnT7fi9flRxoC2gFDNHPLZDGo28z+gI28cWgY0TYO+eIJNzcdBULLs5AJIJRNIwqK99RQBn5tCoVCy60DLgM5ANS3PmXO/cuHKP6WhOLfyqoptmWxrXMWRvVvJqdnSBoxTy4DOgaNSzY/w4/k2/vyrw3lRxXpZFmxe8yUH92zB0HUKhl6+Nm9Oebwin1eLafJVmq7HPcW8bkktM6uCaJo2Iay42JMBnUNVVdF1rbjQoz8TE8Mwymy+dQ/f9KDmsuTUXJm1yT6IaM8TUxqXMEnVVKAi1vssjKDhXRLeByq75CERiTytxeAXgf3pu5Q61h3wROHA3LK0/jXlDpjabqdFywAAAABJRU5ErkJggg==';
		add_menu_page( esc_html__( 'Instagram', 'wolf-gram' ), esc_html__( 'Instagram', 'wolf-gram' ), 'activate_plugins', 'wolf-gram-options', array( $this,  'instagram_login_form' ), $icon );
	}

	/**
	 * Set Default Settings
	 */
	public function default_options() {
		global $options;

		if ( false === get_option( 'wolf_instagram_settings' ) ) {

			$default = array(
				'count' => 20,
				'lightbox' => 'swipebox',
				'widget_link' => 'lightbox',
				'gallery_link' => 'external'
			);

			add_option( 'wolf_instagram_settings', $default );
		}
	}

	/**
	 * Settings Init
	 */
	public function register_settings() {
		register_setting( 'wolf-instagram-settings', 'wolf_instagram_settings', array($this, 'settings_validate' ) );
		add_settings_section( 'wolf-instagram-settings', '', array($this, 'section_intro' ), 'wolf-instagram-settings' );
		add_settings_field( 'username', esc_html__( 'Username', 'wolf-gram' ), array($this, 'setting_username' ), 'wolf-instagram-settings', 'wolf-instagram-settings' );
		add_settings_field( 'api_key', esc_html__( 'API key', 'wolf-gram' ), array($this, 'setting_api_key' ), 'wolf-instagram-settings', 'wolf-instagram-settings' );
		add_settings_field( 'count', esc_html__( 'Number of photos to display in the Instagram gallery (max 30)', 'wolf-gram' ), array($this, 'setting_count' ), 'wolf-instagram-settings', 'wolf-instagram-settings' );
		add_settings_field( 'lightbox', esc_html__( 'Lightbox (thumbnails widgets)', 'wolf-gram' ) , array($this, 'setting_lightbox' ), 'wolf-instagram-settings', 'wolf-instagram-settings', array( 'class' => 'wolf-gram-widget-lightbox' ) );
		add_settings_field( 'widget_link', esc_html__( 'Widget Images Link', 'wolf-gram' ) , array($this, 'setting_widget_link' ), 'wolf-instagram-settings', 'wolf-instagram-settings' );
		add_settings_field( 'gallery_link', esc_html__( 'Gallery Images Link', 'wolf-gram' ) , array($this, 'setting_gallery_link' ), 'wolf-instagram-settings', 'wolf-instagram-settings' );
		add_settings_field( 'instructions', esc_html__( 'Instructions' , 'wolf-gram' ), array($this, 'setting_instructions' ), 'wolf-instagram-settings', 'wolf-instagram-settings' );
	}

	/**
	 * Validate data
	 *
	 */
	public function settings_validate( $input) {

		$input['count'] = absint( $input['count'] );
		$input['username'] = esc_attr( $input['username'] );
		$input['api_key'] = esc_attr( $input['api_key'] );

		if ( $input['count'] > 30 ) {
			$input['count']= 30;
		}

		$input['lightbox'] = esc_attr( $input['lightbox'] );

		if ( isset( $input['api_key'] ) ) {
			update_option( 'wolf_instagram_access_token', $input['api_key'] );
		}

		// Flush cache
		delete_transient( 'wolf_instagram_user_data_' . esc_attr( $input['username'] ) );

		return $input;
	}

	/**
	 * Intro section used for debug
	 *
	 */
	public function section_intro() {
		// global $options;
		// $this->debug(get_option( 'wolf_instagram_settings' ) );
		?>
		<p><?php esc_html_e( 'You can set the default settings below. Some settings can be overwritten via shortcode attributes.', 'wolf-gram' )  ?></p>
		<?php
	}

	/**
	 * Username
	 */
	public function setting_username() {
		echo '<input type="text" name="wolf_instagram_settings[username]" class="regular-text" value="'.wolf_gram_get_option( 'username' ) .'" />';
	}

	/**
	 * API key
	 *
	 */
	public function setting_api_key() {

		echo '<input type="text" name="wolf_instagram_settings[api_key]" class="regular-text" value="'. get_option( 'wolf_instagram_access_token' ) .'" />';
	}

	/**
	 * Gallery Count
	 *
	 */
	public function setting_count() {
		echo '<input type="text" name="wolf_instagram_settings[count]" class="regular-text" value="'.wolf_gram_get_option( 'count' ) .'" />';
	}

	/**
	 * Lightbox Option
	 *
	 */
	public function setting_lightbox() {
		?>
		<select name="wolf_instagram_settings[lightbox]">
			<option <?php if ( wolf_gram_get_option( 'lightbox' ) == 'swipebox' ) echo 'selected="selected"'; ?>>swipebox</option>
			<option <?php if ( wolf_gram_get_option( 'lightbox' ) == 'fancybox' ) echo 'selected="selected"'; ?>>fancybox</option>
			<option <?php if ( wolf_gram_get_option( 'lightbox' ) == 'none' ) echo 'selected="selected"'; ?>>none</option>
		</select>
		<?php
	}

	/**
	 * Widget Link
	 *
	 */
	public function setting_widget_link() {
		?>
		<select name="wolf_instagram_settings[widget_link]">
			<option value="lightbox" <?php if (wolf_gram_get_option( 'widget_link' ) == 'lightbox' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Open in lightbox', 'wolf-gram' ); ?></option>
			<option value="external" <?php if (wolf_gram_get_option( 'widget_link' ) == 'external' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Open Instagram Page', 'wolf-gram' ); ?></option>
		</select>
		<?php
	}

	/**
	 * Gallery Link
	 *
	 */
	public function setting_gallery_link() {
		?>
		<select name="wolf_instagram_settings[gallery_link]">
			<option value="lightbox" <?php if (wolf_gram_get_option( 'gallery_link' ) == 'lightbox' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Open in lightbox', 'wolf-gram' ); ?></option>
			<option value="external" <?php if (wolf_gram_get_option( 'gallery_link' ) == 'external' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Open Instagram Page', 'wolf-gram' ); ?></option>
		</select>
		<?php
	}

	/**
	 * Instructions
	 *
	 */
	public function setting_instructions() {
		?>
		<p><?php esc_html_e( 'You can display the gallery in your post or page with the following shortcode:', 'wolf-gram' )  ?></p>
		<p><code>[wolf_instagram_gallery username="username" api_key="api_key" count="18" button="true|false" button_text="Follow us"]</code></p>
		<?php
	}

	/**
	 * Admin login form
	 *
	 */
	public function instagram_login_form() {

		if ( isset( $_POST['wolf_instagram_logout'] ) && wp_verify_nonce( $_POST['wolf_instagram_logout_nonce'],'wolf_instagram_logout' ) ) {
			$this->instagram_logout();
		}
		?>
		<div class="wrap">
			<div id="icon-themes" class="icon32"></div>
			<h2>Instagram</h2>
		<?php //if ( ! $this->instagram_login() ): // if not logged ?>
			<p><?php esc_html_e( 'WolfGram is a Wordpress plugin that uses the Instagram API to display your Instagram feed.', 'wolf-gram' ); ?></p>
			<p><?php //esc_html_e( 'You need to link the WolfGram app to your Instagram account and get your access key to be able to use the WolfGram features.', 'wolf-gram' ); ?></p>
			<p><?php //esc_html_e( 'To do so, simply follow the link below and follow the instructions.', 'wolf-gram' ); ?></p>
			<p><?php esc_html_e( 'You can use the button below to generate an access key.', 'wolf-gram' ); ?></p>
			<p><a class="button-primary" target="_blank" href="http://wolfgram.wolfthemes.com/"><?php esc_html_e( 'Generate API key', 'wolf-gram' ); ?></a></p>

			<hr>
			<h3><?php esc_html_e( 'Settings', 'wolf-gram' ); ?></h3>
			<form action="options.php" method="post">
				<?php settings_fields( 'wolf-instagram-settings' ); ?>
				<?php do_settings_sections( 'wolf-instagram-settings' ); ?>
				<p class="submit"><input name="save" type="submit" class="button-primary" value="<?php esc_html_e( 'Save Changes', 'wolf-gram' ); ?>" /></p>
			</form>
			<div class="clear"></div>
		</div><!-- .wrap -->

		<?php //endif;
	}

	/**
	 * Login function
	 * @return boolean
	 */
	public function instagram_login( $access_token = null) {

		if ( wolf_gram_get_auth() ) {
			return true;
		}

		if ( isset( $_POST['wolf_instagram_login'] ) && wp_verify_nonce( $_POST['wolf_instagram_login_nonce'],'wolf_instagram_login' ) ) {
			if ( isset( $_POST['wolf_instagram_code'] ) ) {
				$access_token = $_POST['wolf_instagram_code'];
			}
		}

		if ( ! wolf_gram_get_auth() && $access_token ) {
			if ( $this->verify_access_token( $access_token ) ) {
				add_option( 'wolf_instagram_access_token', $access_token  );
				return true;
			} else {
				return false;
			}


		} elseif ( ! wolf_gram_get_auth() && ! $access_token ) {
		 	return false;
		}
	}

	/**
	 * Authentification
	 */
	public function verify_access_token( $access_token) {

		$apiurl = "https://api.instagram.com/v1/users/self/media/recent?count=1&access_token=".$access_token;

		$response = wp_remote_get( $apiurl,
			array(
				'sslverify' => apply_filters( 'https_local_ssl_verify', false)
			)
		);

		if ( ! is_wp_error( $response) && $response['response']['code'] < 400 && $response['response']['code'] >= 200) {

			return true;
		}
	}

	/**
	 * Log Out
	 */
	public function instagram_logout() {
		$trans_key = 'wolf_instagram_data';
		delete_transient( $trans_key );
		delete_option( 'wolf_instagram_access_token' );
	}
}

return new WG_Options();