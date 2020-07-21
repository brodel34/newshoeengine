<?php
/**
 * Wolf Custom Post Meta Options.
 *
 * @class Wolf_Custom_Post_Meta_Options
 * @author WolfThemes
 * @category Admin
 * @package WolfCustom Post Meta/Admin
 * @version 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Wolf_Custom_Post_Meta_Options class.
 */
class Wolf_Custom_Post_Meta_Options {
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

		add_theme_page( esc_html__( 'Custom Post Meta', 'wolf-custom-post-meta' ), esc_html__( 'Custom Post Meta', 'wolf-custom-post-meta' ), 'edit_plugins', 'wolf-custom-post-meta-settings', array( $this, 'options_form' ) );
	}

	/**
	 * Register options
	 */
	public function register_settings() {
		register_setting( 'wolf-custom-post-meta-settings', 'wolf_custom_post_meta_settings', array( $this, 'settings_validate' ) );
		add_settings_section( 'wolf-custom-post-meta-settings', '', array( $this, 'section_intro' ), 'wolf-custom-post-meta-settings' );
		add_settings_field( 'post_types', esc_html__( 'Post Types', 'wolf-custom-post-meta' ), array( $this, 'setting_post_types' ), 'wolf-custom-post-meta-settings', 'wolf-custom-post-meta-settings' );
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
		//var_dump(wolf_custom_post_meta_get_option( 'services' ));
	}

	/**
	 * Services
	 *
	 * @return string
	 */
	public function setting_post_types() {

		$selected_post_types = wolf_custom_post_meta_get_option( 'post_types' );

		foreach ( $this->get_post_types() as $post_type ) {
			$checked = isset( $selected_post_types[ $post_type ] );
			?>
			<p>
				<label for="wolf_custom_post_meta_settings[post_types][<?php echo esc_attr( $post_type ); ?>]">
					<input <?php checked( $checked, true ); ?> name="wolf_custom_post_meta_settings[post_types][<?php echo esc_attr( $post_type ); ?>]" type="checkbox">
					<?php echo esc_attr( ucfirst( $post_type ) ); ?>
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
			<h2><?php esc_html_e( 'Custom Post Meta Options', 'wolf-custom-post-meta' ); ?></h2>
			<?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) { ?>
			<div id="setting-error-settings_updated" class="updated settings-error">
				<p><strong><?php esc_html_e( 'Settings saved.', 'wolf-custom-post-meta' ); ?></strong></p>
			</div>
			<?php } ?>
			<form action="options.php" method="post">
				<?php settings_fields( 'wolf-custom-post-meta-settings' ); ?>
				<?php do_settings_sections( 'wolf-custom-post-meta-settings' ); ?>
				<p class="submit"><input name="save" type="submit" class="button-primary" value="<?php esc_html_e( 'Save Changes', 'wolf-custom-post-meta' ); ?>" /></p>
			</form>
		</div>
		<?php
	}

	/**
	 * Available services
	 */
	public function get_post_types() {

		$post_types = array( 'post' );

		if ( class_exists( 'Wolf_Portfolio' ) ) {
			$post_types[] = 'work';
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

		return apply_filters( 'wolf_custom_post_meta_post_types', $post_types );
	}

	/**
	 * Set default options
	 */
	public function default_options() {

		// delete_option( 'wolf_custom_post_meta_settings' );

		if ( false === get_option( 'wolf_custom_post_meta_settings' )  ) {

			$default = array(

			);

			add_option( 'wolf_custom_post_meta_settings', $default );
		}
	}
} // end class

return new Wolf_Custom_Post_Meta_Options();