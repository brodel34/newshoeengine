<?php
/**
 * Wolf Share Options.
 *
 * @class Wolf_Share_Options
 * @author WolfThemes
 * @category Admin
 * @package WolfShare/Admin
 * @version 1.0.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Wolf_Share_Options class.
 */
class Wolf_Share_Options {
	/**
	 * Constructor
	 */
	public function __construct() {

		// Admin init hooks
		$this->admin_init_hooks();
	}

	/**
	 * Admin init
	 */
	public function admin_init_hooks() {

		// Set default options
		add_action( 'admin_init', array( $this, 'default_options' ) );

		// Register settings
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		// Add options menu
		add_action( 'admin_menu', array( $this, 'add_options_menu' ) );
	}

	/**
	 * Add options menu
	 */
	public function add_options_menu() {

		add_theme_page( esc_html__( 'Share Buttons', 'wolf-share' ), esc_html__( 'Share Buttons', 'wolf-share' ), 'edit_plugins', 'wolf-share-settings', array( $this, 'options_form' ) );
	}

	/**
	 * Register options
	 */
	public function register_settings() {
		register_setting( 'wolf-share-settings', 'wolf_share_settings', array( $this, 'settings_validate' ) );
		add_settings_section( 'wolf-share-settings', '', array( $this, 'section_intro' ), 'wolf-share-settings' );
		add_settings_field( 'post_types', esc_html__( 'Post Types', 'wolf-share' ), array( $this, 'setting_post_types' ), 'wolf-share-settings', 'wolf-share-settings' );
		add_settings_field( 'services', esc_html__( 'Services', 'wolf-share' ), array( $this, 'setting_services' ), 'wolf-share-settings', 'wolf-share-settings' );
	}

	/**
	 * Validate options
	 *
	 * @param array $input
	 * @return array $input
	 */
	public function settings_validate( $input ) {

		return $input;
	}

	/**
	 * Debug section
	 */
	public function section_intro() {
		// debug
		//global $options;
		//var_dump( wolf_share_get_option( 'post_types' ) );
	}

	/**
	 * Services
	 *
	 * @return string
	 */
	public function setting_post_types() {

		$selected_post_types = wolf_share_get_option( 'post_types' );

		foreach ( $this->get_post_types() as $post_type ) {
			$checked = isset( $selected_post_types[ $post_type ] );
			?>
			<p>
				<label for="wolf_share_settings[post_types][<?php echo esc_attr( $post_type ); ?>]">
					<input <?php checked( $checked, true ); ?> name="wolf_share_settings[post_types][<?php echo esc_attr( $post_type ); ?>]" type="checkbox">
					<?php echo esc_attr( ucfirst( $post_type ) ); ?>
				</label>
			</p>
			<?php
		}
	}

	/**
	 * Services
	 *
	 * @return string
	 */
	public function setting_services() {

		$selected_services = wolf_share_get_option( 'services' );

		foreach ( $this->get_services() as $service ) {
			$checked = isset( $selected_services[ $service ] );
			?>
			<p>
				<label for="wolf_share_settings[services][<?php echo esc_attr( $service ); ?>]">
					<input <?php checked( $checked, true ); ?> name="wolf_share_settings[services][<?php echo esc_attr( $service ); ?>]" type="checkbox">
					<?php echo esc_attr( ucfirst( $service ) ); ?>
				</label>
			</p>
			<?php
		}
	}

	/**
	 * Options form
	 */
	public function options_form() {
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Share Button Options', 'wolf-share' ); ?></h2>
			<?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) { ?>
			<div id="setting-error-settings_updated" class="updated settings-error">
				<p><strong><?php esc_html_e( 'Settings saved.', 'wolf-share' ); ?></strong></p>
			</div>
			<?php } ?>
			<form action="options.php" method="post">
				<?php settings_fields( 'wolf-share-settings' ); ?>
				<?php do_settings_sections( 'wolf-share-settings' ); ?>
				<p class="submit"><input name="save" type="submit" class="button-primary" value="<?php esc_html_e( 'Save Changes', 'wolf-share' ); ?>" /></p>
			</form>
		</div>
		<?php
	}

	/**
	 * Available services
	 */
	public function get_post_types() {

		$post_types = array( 'post' );

		if ( class_exists( 'WooCommerce' ) ) {
			$post_types[] = 'product';
		}

		if ( class_exists( 'Wolf_Portfolio' ) ) {
			$post_types[] = 'work';
		}

		if ( class_exists( 'Wolf_Events' ) ) {
			$post_types[] = 'event';
		}

		if ( class_exists( 'Wolf_Albums' ) ) {
			$post_types[] = 'gallery';
		}

		if ( class_exists( 'Wolf_Discography' ) ) {
			$post_types[] = 'release';
		}

		if ( class_exists( 'Wolf_Videos' ) ) {
			$post_types[] = 'video';
		}

		if ( class_exists( 'Wolf_Photos' ) ) {
			$post_types[] = 'attachment';
		}

		if ( class_exists( 'Wolf_Playlist_Manager' ) ) {
			$post_types[] = 'wpm_playlist';
		}

		if ( class_exists( 'Wolf_Artists' ) ) {
			$post_types[] = 'artist';
		}

		return apply_filters( 'wolf_share_post_types', $post_types );
	}

	/**
	 * Available services
	 */
	public function get_services() {
		return array(
			'facebook',
			'twitter',
			'reddit',
			'pinterest',
			'tumblr',
			'google',
			'linkedin',
			'stumbleupon',
			'vk',
			'xing',
			'email',
		);
	}

	/**
	 * Set default options
	 */
	public function default_options() {

		//delete_option( 'wolf_share_settings' );

		if ( false === get_option( 'wolf_share_settings' )  ) {

			$default = apply_filters( 'wolf_share_default_settings', array(
				'post_types' => array(
					'post' => 'on',
					'work' => 'on',
					'product' => 'on',
					'event' => 'on',
					'release' => 'on',
					'gallery' => 'on',
					'video' => 'on',
					'wpm_playlist' => 'on',
					'artist' => 'on',
					'attachment' => 'on',
				),
				'services' => array(
					'facebook' => 'on',
					'twitter' => 'on',
					'email' => 'on',
				),
			) );

			add_option( 'wolf_share_settings', $default );
		}
	}
} // end class

return new Wolf_Share_Options();