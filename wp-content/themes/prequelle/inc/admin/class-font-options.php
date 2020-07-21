<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Prequelle_Font_Options' ) ) {
	/**
	 * Prequelle font loader
	 *
	 * Allow to load Google fonts and Typekit fonts to use in the customizer
	 *
	 * @package WordPress
	 * @subpackage Prequelle
	 * @version 1.0.4
	 */
	class Prequelle_Font_Options {

		/**
		 * @var
		 */
		private $index = 'font';

		/**
		 * Hook into the appropriate actions when the class is constructed.
		 */
		public function __construct() {
			add_action( 'admin_menu',  array( $this, 'add_menu' ) );
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_init', array( $this, 'default_options' ) );
		}

		/**
		 * Add contextual menu
		 */
		public function add_menu() {

			add_theme_page( esc_html__( 'Fonts Loader', 'prequelle' ), esc_html__( 'Font Loader', 'prequelle' ), 'administrator', 'font-loader', array( $this, 'font_loader_settings' ) );
		}

		/**
		 * Get option index name
		 */
		public function options_index_name() {
			return prequelle_get_theme_slug() . '_' . $this->index . '_settings';
		}

		/**
		 * Add Settings
		 */
		public function admin_init() {

			register_setting( $this->options_index_name(), $this->options_index_name(), array( $this, 'settings_validate' ) );

			add_settings_section( $this->options_index_name(), '', array( $this, 'section_intro' ), $this->options_index_name() );

			add_settings_field( 'google_fonts', esc_html__( 'Google Fonts', 'prequelle' ), array( $this, 'setting_google_font' ), $this->options_index_name(), $this->options_index_name() );

			add_settings_field( 'typekit_fonts', esc_html__( 'Typekit fonts', 'prequelle' ), array( $this, 'setting_typekit_font' ), $this->options_index_name(), $this->options_index_name() );
		}

		/**
		 * Intro section used for debug
		 */
		public function section_intro() {
		}

		/**
		 * Intro section used for debug
		 */
		public function settings_validate( $input ) {

			$input['google_fonts'] = esc_attr( $input['google_fonts'] );
			$input['typekit_fonts'] = esc_attr( $input['typekit_fonts'] );

			do_action( 'prequelle_after_' . $this->options_index_name() . '_options_save', $input );

			return $input;
		}

		/**
		 * Google font text field
		 */
		public function setting_google_font() {
			?>
			<input placeholder="Open+Sans:400,700|Karla:400,400" type="text" class="large-text" name="<?php echo esc_attr( $this->options_index_name() ); ?>[google_fonts]" value="<?php echo esc_attr( $this->get_option( 'google_fonts' ) ); ?>">
			<p class="description">
				<?php
					echo sprintf( wp_kses_post(
						__( 'You can get your fonts on the <a href="%s" target="_blank">Google Fonts</a> website.', 'prequelle' )
						),
					esc_url( 'https://www.google.com/fonts' )
				) ?>
			</p>
			<?php
		}

		/**
		 * Typekit font text field
		 */
		public function setting_typekit_font() {
			?>
			<input placeholder="adobe-caslon-pro|other-font" type="text" class="large-text" name="<?php echo esc_attr( $this->options_index_name() ); ?>[typekit_fonts]" value="<?php echo esc_attr( $this->get_option( 'typekit_fonts' ) ); ?>">
			<p class="description">
				<?php
					echo sprintf(
						wp_kses_post(
							__( 'You need <a href="%s" target="_blank">Typekit Fonts for WordPress</a> plugin to import your font kit into your website. <a href="%s" target="_blank">More infos</a>', 'prequelle' )
						),
						esc_url( 'https://wordpress.org/plugins/typekit-fonts-for-wordpress/' ),
						esc_url( 'https://wolfthemes.ticksy.com/article/11666/' )
					);
				?>
			</p>
			<?php
		}

		/**
		 * Get fonts option
		 *
		 * @param string $value
		 * @return string|null
		 */
		public function get_option( $value = null ) {

			$settings = get_option( $this->options_index_name() );

			if ( isset( $settings[ $value ]) ) {
				return $settings[ $value ];
			}
		}

		/**
		 * Default options
		 */
		public function default_options() {

			if ( false === get_option( $this->options_index_name() ) ) {

				$default = array(
					'google_fonts' => apply_filters( 'prequelle_default_google_fonts', '' ),
					'typekit_fonts' => apply_filters( 'prequelle_default_typekit_fonts', '' ),
				);

				add_option( $this->options_index_name(), $default );
			}
		}

		/**
		 * Settings Form
		 */
		public function font_loader_settings() {
			?>
			<div class="wrap">
				<div id="icon-options-general" class="icon32"></div>
				<h2><?php esc_html_e( 'Fonts Loader', 'prequelle' ); ?></h2>
				<form action="options.php" method="post">
					<?php settings_fields( $this->options_index_name() ); ?>
					<?php do_settings_sections( $this->options_index_name() ); ?>
					<p class="submit"><input name="save" type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'prequelle' ); ?>" /></p>
				</form>
			</div>
			<?php
		}
	} // end class

	new Prequelle_Font_Options;
}