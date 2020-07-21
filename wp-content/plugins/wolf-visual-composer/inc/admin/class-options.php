<?php
/**
 * Wolf WPBakery Page Builder Extension Settings.
 *
 * @class Wvc_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfVisualComposer/Admin
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WVC_Options class.
 */
class WVC_Options {

	/**
	 * @var settings id
	 */
	private $settings_id = 'wvc-settings';

	/**
	 * @var settings slug
	 */
	private $settings_slug = 'settings';

	/**
	 * @var array
	 */
	public $settings = array();

	/**
	 * Constructor
	 */
	public function __construct( $settings = array() ) {

		$this->settings = $settings + $this->settings;
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'settings' ) );
		add_action( 'admin_init', array( $this, 'default_options' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
	}

	/**
  	 * Enqueue scripts
	 */
	public function scripts() {
		wp_enqueue_script( 'wp-color-picker' ); // colorpicker
	}

	/**
	 * Add the Theme menu to the WP admin menu
	 */
	public function admin_menu() {

		foreach ( $this->settings as $section ) {
			$this->settings_id = $section['settings_id'];
			$parent_slug = ( isset( $section['parent_slug'] ) ) ? $section['parent_slug'] : VC_PAGE_MAIN_SLUG;
			add_submenu_page( $parent_slug, $section['title'], $section['title'], 'activate_plugins', $section['settings_id'], array( $this, 'settings_form' ) );
		}
	}

	/**
	 * Init Settings
	 */
	public function settings() {

		foreach ( $this->settings as $setting ) {
			$this->settings_id = $setting['settings_id'];
			$this->settings_slug = $setting['settings_slug'];

			register_setting( $this->settings_id, $this->settings_slug, array( $this, 'settings_validate' ) );
			add_settings_section( $this->settings_id, '', array( $this, 'section_intro' ), $this->settings_id );

			foreach ( $setting['fields'] as $key => $field ) {
				$type = ( isset( $field['type'] ) ) ? $field['type'] : 'text';
				$label = ( isset( $field['label'] ) ) ? $field['label'] : '';
				$description = ( isset( $field['description'] ) ) ? $field['description'] : '';
				$placeholder = ( isset( $field['placeholder'] ) ) ? $field['placeholder'] : '';
				$value = ( isset( $field['value'] ) ) ? $field['value'] : '';
				$choices = ( isset( $field['choices'] ) && 'select' == $type  ) ? $field['choices'] : array();
				add_settings_field(
					$field['field_id'],
					$label,
					array( $this, 'setting_field' ),
					$this->settings_id,
					$this->settings_id,
					array(
						'field_id' => $field['field_id'],
						'type' => $type,
						'settings_slug' => $this->settings_slug,
						'description' => $description,
						'placeholder' => $placeholder,
						'value' => $value,
						'choices' => $choices,
					)
				);
			}

			add_settings_field( 'settings_index', '', array( $this, 'section_slug' ), $this->settings_id, $this->settings_id, array( 'settings_slug' => $this->settings_slug ) );
		}
	}

	/**
	 * Intro section
	 */
	public function section_slug( $args ) {
		$settings_slug = $args['settings_slug'];
		?>
		<input type="hidden" name="<?php echo esc_attr( $settings_slug . '[settings_slug]' ); ?>" value="<?php echo esc_attr( $settings_slug ); ?>">
		<?php
	}

	/**
	 * Validate settings
	 */
	public function settings_validate( $input ) {

		do_action( 'wvc_before_options_save', $input );

		$setting_index = esc_attr( $input['settings_slug'] );
		wvc_update_option_index( $setting_index, $input );

		do_action( 'wvc_after_options_save', $input );

		return $input;
	}

	/**
	 * Intro section
	 */
	public function section_intro() {
	}

	/**
	 * Create field using passed arguments
	 *
	 * @param array $args
	 * @return string
	 */
	public function setting_field( $args ) {
		$type = $args['type'];
		$field_id = $args['field_id'];
		$settings_slug = $args['settings_slug'];
		$placeholder = $args['placeholder'];
		$value = ( wolf_vc_get_option( $settings_slug, $field_id ) ) ? wolf_vc_get_option( $settings_slug, $field_id ) : $args['value'];
		$choices = $args['choices'];
		$description = $args['description'];

		if ( 'text' == $type || 'url' == $type ) {
			?>
			<input placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo esc_attr( wolf_vc_get_option( $settings_slug, $field_id ) ); ?>" name="<?php echo esc_attr( $settings_slug . '[' . $field_id . ']' ); ?>" class="regular-text">
			<?php
		} elseif ( 'textarea' == $type ) {
			?>
			<textarea class="large-text" name="<?php echo esc_attr( $settings_slug . '[' . $field_id . ']' ); ?>" rows="5"><?php echo sanitize_text_field( wolf_vc_get_option( $settings_slug, $field_id ) ); ?></textarea>
			<?php
		} elseif ( 'editor' === $type ) {
			$content = ( wolf_vc_get_option( $settings_slug, $field_id ) ) ? stripslashes( wolf_vc_get_option( $settings_slug, $field_id ) ) : '';
			$editor_id = esc_attr( $settings_slug . '[' . $field_id . ']' );
			wp_editor( $content, $field_id, $settings = array() );
		} elseif ( 'checkbox' == $type ) {
			?>
			<input type="hidden" name="<?php echo esc_attr( $settings_slug . '[' . $field_id . ']' ); ?>" value="0">
			<label>
				<input type="checkbox" name="<?php echo esc_attr( $settings_slug . '[' . $field_id . ']' ); ?>" value="1" <?php checked( wolf_vc_get_option( $settings_slug, $field_id ), 1 ); ?>>
			</label>
			<?php
		} elseif ( 'colorpicker' == $type ) {
			$colorpicker_id = uniqid( 'wvc-settings-colorpicker-' );
			?>
			<script>
				jQuery( document ).ready( function() {
					jQuery( '#<?php echo esc_js( $colorpicker_id ); ?>' ).wpColorPicker();
				} );
			</script>
			<input id="<?php echo esc_attr( $colorpicker_id ); ?>" value="<?php echo wvc_sanitize_color( wolf_vc_get_option( $settings_slug, $field_id ) ); ?>" name="<?php echo esc_attr( $settings_slug . '[' . $field_id . ']' ); ?>" class="wvc-settings-colorpicker">
			<?php

		} elseif ( 'select' == $type ) {
			?>
			<select name="<?php echo esc_attr( $settings_slug . '[' . $field_id . ']' ); ?>">
				<?php if ( array_keys( $choices ) != array_keys( array_keys( $choices ) ) ) : ?>
					<?php foreach ( $choices as $key => $name) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $value, $key ); ?>><?php echo sanitize_text_field( $name ); ?></option>
					<?php endforeach; ?>
				<?php else : ?>
					<?php foreach ( $choices as $choice ) : ?>
						<option value="<?php echo esc_attr( $choice ); ?>" <?php selected( $value, $choice ); ?>><?php echo sanitize_text_field( $choice ); ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
			<?php
		} elseif ( 'image' == $type ) {
			/**
			 * Bg image
			 */
			wp_enqueue_media();
			$image_id = absint( $value );
			$image_url = wvc_get_url_from_attachment_id( $image_id );
			?>
			<input type="hidden" name="<?php echo esc_attr( $settings_slug . '[' . $field_id . ']' ); ?>" value="<?php echo esc_attr( $image_id); ?>">
			<img style="max-width:150px;<?php if ( ! $image_id ) echo 'display:none;'; ?>" class="wvc-img-preview" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $field_id ); ?>">
			<br>
			<a href="#" class="button wvc-reset-img"><?php esc_html_e( 'Clear', 'wolf-visual-composer' ); ?></a>
			<a href="#" class="button wvc-set-img"><?php esc_html_e( 'Choose an image', 'wolf-visual-composer' ); ?></a>
			<?php
		} elseif ( 'background' == $type ) {
			$bg_meta = wvc_get_bg_meta( $settings_slug, $field_id  );
			extract( $bg_meta );
			$image_url = wvc_get_url_from_attachment_id( $image_id );
			/**
			 * Bg color
			 */
			?>
			<p>
				<label for="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][color]' ); ?>">
					<?php esc_html_e( 'Color', 'wolf-visual-composer' ); ?>
				</label><br>
				<input value="<?php echo wvc_sanitize_color( $color ); ?>" name="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][color]' ); ?>" class="wvc-settings-colorpicker">
			</p>
			<?php
			/**
			 * Bg image
			 */
			wp_enqueue_media();
			?>
			<p>
				<label for="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][image_id]' ); ?>">
					<?php esc_html_e( 'Image', 'wolf-visual-composer' ); ?>
				</label><br>
				<input type="hidden" name="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][image_id]' ); ?>" value="<?php echo esc_attr( $image_id); ?>">
				<img style="max-width:150px;<?php if ( ! $image_id ) echo 'display:none;'; ?>" class="wvc-img-preview" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $field_id ); ?>">
				<br>
				<a href="#" class="button wvc-reset-img"><?php esc_html_e( 'Clear', 'wolf-visual-composer' ); ?></a>
				<a href="#" class="button wvc-set-img"><?php esc_html_e( 'Choose an image', 'wolf-visual-composer' ); ?></a>
			</p>
			<?php

			/**
			 * Bg repeat
			 */
			$options = array( 'no-repeat', 'repeat', 'repeat-x', 'repeat-y' );
			?>
			<p>
				<label for="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][repeat]' ); ?>">
					<?php esc_html_e( 'Repeat', 'wolf-visual-composer' ); ?>
				</label><br>
				<select name="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][repeat]' ); ?>">
					<?php foreach ( $options as $option ) : ?>
						<option <?php selected( $repeat, $option ); ?>><?php echo sanitize_text_field( $option ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<?php
			/**
			 * Bg position
			 */
			$options = array(
				'center center',
				'center top',
				'left top' ,
				'right top' ,
				'center bottom',
				'left bottom' ,
				'right bottom' ,
				'left center' ,
				'right center',
			);
			 ?>
			 <p>
				 <label for="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][position]' ); ?>">
					<?php esc_html_e( 'Position', 'wolf-visual-composer' ); ?>
				</label><br>
				 <select name="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][position]' ); ?>">
				 	<?php foreach ( $options as $option ) : ?>
						<option <?php selected( $position, $option ); ?>><?php echo sanitize_text_field( $option ); ?></option>
					<?php endforeach; ?>
				 </select>
			</p>
			 <?php

			/**
			 * Bg size
			 */
			$options = array(
				'cover' => esc_html__( 'cover (resize)', 'wolf-visual-composer' ),
				'normal' => esc_html__( 'normal', 'wolf-visual-composer' ),
				'resize' => esc_html__( 'responsive (hard resize)', 'wolf-visual-composer' ),
			);
			?>
			<p>
				<label for="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][size]' ); ?>">
					<?php esc_html_e( 'Size', 'wolf-visual-composer' ); ?>
				</label><br>
				<select name="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][size]' ); ?>">
					<?php foreach ( $options as $option => $display ) : ?>
						<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $size, $option ); ?>><?php echo sanitize_text_field( $display ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<?php

			/**
			 * Bg attachment
			 */
			$options = array(
				'scroll',
				'fixed',
			);
			?>
			<p>
				<label for="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][attachment]' ); ?>">
					<?php esc_html_e( 'Attachment', 'wolf-visual-composer' ); ?>
				</label><br>
				<select name="<?php echo esc_attr( $settings_slug . '[' . $field_id . '][attachment]' ); ?>">
					<?php foreach ( $options as $option ) : ?>
						<option <?php selected( $attachment, $option ); ?>><?php echo sanitize_text_field( $option ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<?php
		} elseif ( 'message' === $type ) {
			
		}

		if ( $description ) {
			echo '<p class="description">' . wp_kses_post( $description ) . '</p>';
		}
	}

	/**
	 * Plugin Settings
	 */
	public function settings_form() {
		$this->settings_id = ( isset( $_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : '';
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Page Builder Settings' ) ?></h2>
			<?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) { ?>
				<div id="setting-error-settings_updated" class="updated settings-error">
					<p><strong><?php esc_html_e( 'Settings saved.', 'wolf-visual-composer' ); ?></strong></p>
				</div>
			<?php } ?>
			<form action="options.php" method="post">
				<?php settings_fields( $this->settings_id ); ?>
				<?php do_settings_sections( $this->settings_id ); ?>
				<p class="submit"><input name="save" type="submit" class="button-primary" value="<?php esc_html_e( 'Save Changes', 'wolf-visual-composer' ); ?>" /></p>
			</form>
		</div>
		<?php
	}

	/**
	 * Set default options
	 */
	public function default_options() {

		global $options;

		if ( ! get_option( 'wvc_settings' )  ) {

			$default_twitter_url = ( get_user_meta( get_current_user_id(), 'twitter', true ) ) ? 'https://twitter.com/' . esc_attr( get_user_meta( get_current_user_id(), 'twitter', true ) ) : '#';
			$default_facebook_url = ( get_user_meta( get_current_user_id(), 'facebook', true ) ) ? get_user_meta( get_current_user_id(), 'facebook', true ) : '#';

			$default = apply_filters( 'wvc_default_settings',
				array(

					'settings' => array(
						'lightbox' => 'swipebox',
						'lazyload' => true,
						'css_min' => true,
						'js_min' => true,
					),
					'mailchimp' => array(
						'label' => esc_html__( 'Subscribe to our newsletter', 'wolf-visual-composer' ),
						'subscribe_text' => esc_html__( 'Subscribe', 'wolf-visual-composer' ),
						'placeholder_f_name' => esc_html__( 'Your first name', 'wolf-visual-composer' ),
						'placeholder_l_name' => esc_html__( 'Your last name', 'wolf-visual-composer' ),
						'placeholder' => esc_html__( 'Your email', 'wolf-visual-composer' ),
					),
					'fonts' => array(),

					'socials' => array(
						'twitter' => $default_twitter_url,
						'facebook' => $default_facebook_url,
					),
					'privacy_policy_message' => array(
						'page_id' => get_option( 'page_for_privacy_policy' ),
					),
				)
			);

			add_option( 'wvc_settings', $default );
		}
	}
} // end class