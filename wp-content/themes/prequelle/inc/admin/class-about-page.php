<?php
/**
 * Prequelle about page
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Prequelle_Admin_About_Page' ) ) {
	/**
	 * About Page Class
	 */
	class Prequelle_Admin_About_Page {

		var $theme_name;
		var $theme_version;
		var $theme_slug;
		var $user_capability;

		/**
		 * __construct function.
		 */
		public function __construct() {

			$this->theme_name = prequelle_get_theme_name();
			$this->theme_version = prequelle_get_theme_version();
			$this->theme_slug = prequelle_get_theme_slug();
			$this->user_capability = 'activate_plugins';

			$this->dismiss_cookie();

			add_action( 'admin_menu', array( $this, 'admin_menus') );
			add_action( 'admin_init', array( $this, 'welcome' ) );
		}

		/**
		 * Add admin menus/screens
		 */
		public function admin_menus() {

			add_theme_page( esc_html__( 'About the Theme', 'prequelle' ), esc_html__( 'About the Theme', 'prequelle' ), 'switch_themes', $this->theme_slug . '-about', array( $this, 'about_screen' ) );
		}

		/**
		 * Admin notice dismiss
		 *
		 * Set cookie from "hide permanently" admin notice links if JS was not available
		 *
		 * @access private
		 */
		private function dismiss_cookie() {
			if ( isset( $_GET['page'] ) && prequelle_get_theme_slug() . '-about' === esc_attr( $_GET['page'] ) && isset( $_GET['dismiss'] ) ) {
				$cookie_id = esc_attr( $_GET['dismiss'] );

				setcookie( $cookie_id, 'hide', time() + 2 * YEAR_IN_SECONDS, '/' );
			}
		}

		/**
		 * Into text/links shown on all about pages.
		 *
		 * @access private
		 */
		private function intro() {
			if ( isset( $_GET['prequelle-activated'] ) ) {
				update_user_meta( get_current_user_id(), 'show_welcome_panel', true );
			}

			?>
			<h1><?php printf( esc_html__( 'Welcome to %s %s', 'prequelle' ), $this->theme_name, $this->theme_version ); ?></h1>

			<div class="wp-badge prequelle-about-page-logo">
				<?php printf( esc_html__( 'Version %s', 'prequelle'  ), sanitize_text_field( $this->theme_version ) ); ?>
			</div>
			<?php
		}

		/**
		 * Output the about screen.
		 */
		public function about_screen() {
			?>
			<div class="wrap prequelle-about-page-wrap">
				<?php $this->intro(); ?>
				<?php $this->actions(); ?>
				<?php $this->tabs(); ?>
			</div>
			<?php
		}

		/**
		 * Check if TGM plugin activation is completed
		 *
		 * As there isn't any filter or hook to know if TGMPA plugin installation has been completed
		 * We check if its menu exists as it is disabled when plugin is completed
		 */
		private function is_tgmpa_in_da_place() { // don't ask me, lack of inspiration for the function name
			global $submenu;

			$tgmpa_menu_slug = 'tgmpa-install-plugins'; // must be the same as in the plugin config/plugins.php file

			if ( ! get_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice_tgmpa' ) ) { // if user didn't dismissed the notice
				if ( isset( $submenu['themes.php'] ) ) {
					$theme_menu_items = $submenu['themes.php'];

					foreach ( $theme_menu_items as $item ) {

						if ( isset( $item[2] ) && $tgmpa_menu_slug == $item[2] ) {
							return true;
							break;
						}
					}
				}
			}
		}

		/**
		 * Output action buttons
		 */
		public function actions() {
			?>
			<p class="prequelle-about-actions">
				<?php if ( $this->is_tgmpa_in_da_place() ) : ?>
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="button button-primary">
						<span class="dashicons dashicons-admin-plugins"></span>
						<?php esc_html_e( 'Install Recommended Plugins', 'prequelle' ); ?>
					</a>
				<?php endif; ?>
				<?php if ( prequelle_get_theme_changelog() ) : ?>
					<a target="_blank" href="<?php echo esc_url( 'https://docs.wolfthemes.com/documentation/theme/' . prequelle_get_theme_slug() ); ?>" class="button">
						<span class="dashicons dashicons-sos"></span>
						<?php esc_html_e( 'Documentation', 'prequelle' ); ?>
					</a>
				<?php endif; ?>
			</p>
			<?php
		}

		/**
		 * Tabs
		 */
		private function tabs() {
			?>
			<div id="prequelle-welcome-tabs">
				<h2 class="nav-tab-wrapper">
					<?php if ( prequelle_get_theme_changelog() || current_user_can( $this->user_capability ) ) : ?>
						<div class="tabs" id="tabs1">
							<a href="#welcome" class="nav-tab nav-tab-active"><?php esc_html_e( 'Welcome', 'prequelle' ); ?></a>
							<?php if ( current_user_can( $this->user_capability ) )  : ?>
								<a href="#system-status" class="nav-tab"><?php esc_html_e( 'System Status', 'prequelle' ); ?></a>
							
							<?php if ( prequelle_get_theme_changelog() ) : ?>
								<a href="#changelog" class="nav-tab"><?php esc_html_e( 'Changelog', 'prequelle' ); ?></a>
								<?php endif; ?>
							<?php endif; ?>

							<?php
								/**
								 * WVC License tab
								 */
								do_action( 'wvc_license_tab' );
							?>
						</div>
					<?php endif; ?>
				</h2>
				
				<div class="content">
					
					<div id="welcome" class="prequelle-options-panel">
						<?php $this->welcome_message(); ?>
					</div><!-- #system-status -->
					
					<?php if ( current_user_can( $this->user_capability ) )  : ?>
						<div id="system-status" class="prequelle-options-panel">
							<?php $this->system_status(); ?>
						</div><!-- #system-status -->
					<?php endif; ?>
					
					<?php if ( prequelle_get_theme_changelog() ) : ?>
						<div id="changelog" class="prequelle-options-panel">
							<?php $this->changelog(); ?>
						</div><!-- #changelog -->
					<?php endif; ?>

					<?php
						/**
						 * WVC License tab content
						 */
						do_action( 'wvc_license_tab_content' );
					?>
				</div>
			</div><!-- #prequelle-welcome-tabs -->
			<?php
		}

		/**
		 * Welcome message
		 */
		function welcome_message() {
			?>
			<div class="about-text prequelle-about-text">
				<h4>
				<?php
					if ( isset( $_GET['prequelle-updated'] ) ) {
						$message = esc_html__( 'Thank you for updating to the latest version!', 'prequelle' );
					} else {
						$message = sprintf( esc_html__( 'Thanks for using %s theme!', 'prequelle' ), $this->theme_name );
					}

					if ( isset( $_GET['prequelle-activated'] ) ) {

						printf( esc_html__( '%s We hope you will enjoy using it.', 'prequelle' ), $message );

					} elseif ( isset( $_GET['prequelle-updated'] ) ) {

						printf( wp_kses( __( '%s <br> %s is now more stable and secure than ever.<br>We hope you enjoy using it.', 'prequelle' ), array( 'br' => array() ) ), $message, $this->theme_name );

					} else {
						printf( esc_html__( '%s We hope you enjoy using it.', 'prequelle' ), $message );
					}
				?>
				</h4>
				<div class="row prequelle-about-columns">
					<div class="col col-4">
						<h4><?php esc_html_e( 'Getting Started', 'prequelle' ); ?></h4>
						<ul>
							<li><a href="https://wolfthemes.ticksy.com/article/11652/" target="_blank"><?php esc_html_e( 'Before Getting Started', 'prequelle' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11655/" target="_blank"><?php esc_html_e( 'Install Recommended Plugins', 'prequelle' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11656/" target="_blank"><?php esc_html_e( 'Import Demo Data', 'prequelle' ); ?></a></li>
						</ul>
					</div>
					<div class="col col-4">
						<h4><?php esc_html_e( 'Troubleshooting', 'prequelle' ); ?></h4>
						<ul>
							<li><a href="https://wolfthemes.ticksy.com/article/11680/" target="_blank"><?php esc_html_e( 'Issue Importing the Demo', 'prequelle' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11681/" target="_blank"><?php esc_html_e( '404 error page', 'prequelle' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11678/" target="_blank"><?php esc_html_e( 'FAQ', 'prequelle' ); ?></a></li>
						</ul>
					</div>
					<div class="col col-4">
						<h4><?php esc_html_e( 'Help', 'prequelle' ); ?></h4>
						<ul>
							<li><a href="https://docs.wolfthemes.com/documentation/theme/<?php echo esc_attr( $this->theme_slug ); ?>" target="_blank"><?php esc_html_e( 'Theme Documentation', 'prequelle' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11658/" target="_blank"><?php esc_html_e( 'Update the Theme', 'prequelle' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/12629/" target="_blank"><?php esc_html_e( 'Bundled Plugin Activation', 'prequelle' ); ?></a></li>
						</ul>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * System status
		 *
		 * Display system status
		 */
		private function system_status() {

			$vars = prequelle_get_minimum_required_server_vars();
			?>
			<div id="prequelle-system-status">
				<?php if ( ! prequelle_get_theme_changelog() ) : ?>
					<h3><?php esc_html_e( 'System Status', 'prequelle' ); ?></h3>
				<?php endif; ?>
				<p>
					<?php esc_html_e( 'Check that all the requirements below are fulfiled and labeled in green.', 'prequelle' ); ?>
				</p>

				<h4><?php esc_html_e( 'WordPress Environment', 'prequelle' ); ?></h4>

				<table>
			<?php
			$xml_latest = '0';
			$xml_requires = $vars['REQUIRED_WP_VERSION'];

			if ( $xml = prequelle_get_theme_changelog() ) {
				$xml_latest = (string)$xml->latest;
				$xml_requires = (string)$xml->requires;
			}
			$theme_version = prequelle_get_parent_theme_version();
			$required_theme_version = $xml_latest;
			$theme_version_condition = ( version_compare( $theme_version, $required_theme_version, '>=' ) );
			$theme_update_url = ( class_exists( 'Envato_Market' ) ) ? admin_url( 'admin.php?page=envato-market' ) : 'https://wolfthemes.ticksy.com/article/11658/';
			$target = ( class_exists( 'Envato_Market' ) ) ? '_parent' : '_blank';
			$theme_version_error_message = ( ! $theme_version_condition ) ? ' - ' . esc_html__( 'It is recommended to update the theme to the latest version', 'prequelle' ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'Theme Version', 'prequelle' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( sprintf( __( 'The version of %s installed on your site.', 'prequelle' ), prequelle_get_theme_name() ) ); ?>" target="<?php echo esc_attr( $target ); ?>" href="<?php echo esc_url( $theme_update_url ); ?>"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( $theme_version_condition ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $theme_version . $theme_version_error_message ); ?></td>
						<td class="status <?php echo ( $theme_version_condition ) ? 'green' : 'red'; ?>"><?php echo ( $theme_version_condition ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			$wp_version = get_bloginfo( 'version' );
			$required_wp_version = $xml_requires;
			$wp_version_condition = ( version_compare( $wp_version, $required_wp_version, '>=' ) );
			$wp_version_error_message = ( ! $wp_version_condition ) ? ' - ' . esc_html__( 'It is recommended to update WordPress to the latest version', 'prequelle' ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'WP Version', 'prequelle' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The version of WordPress installed on your site.', 'prequelle' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11677/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( $wp_version_condition ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $wp_version . $wp_version_error_message ); ?></td>
						<td class="status <?php echo ( $wp_version_condition ) ? 'green' : 'red'; ?>"><?php echo ( $wp_version_condition ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			$wp_memory_limit = WP_MEMORY_LIMIT;
			$required_wp_memory_limit = $vars['REQUIRED_WP_MEMORY_LIMIT'];
			$wp_memory_limit_condition = ( wp_convert_hr_to_bytes( $wp_memory_limit ) >= wp_convert_hr_to_bytes( $required_wp_memory_limit ) );
			$wp_memory_limit_error_message = ( ! $wp_memory_limit_condition ) ? ' - ' . sprintf( __( 'It is recommended to increase your WP memory limit to %s at least', 'prequelle' ), $vars['REQUIRED_WP_MEMORY_LIMIT'] ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'WP  Limit', 'prequelle' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The maximum amount of memory (RAM) that your site can use at one time.', 'prequelle' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11676/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( $wp_memory_limit_condition ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $wp_memory_limit . $wp_memory_limit_error_message ); ?></td>
						<td class="status <?php echo ( $wp_memory_limit_condition ) ? 'green' : 'red'; ?>"><?php echo ( $wp_memory_limit_condition ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>

				</table>

				<h4><?php esc_html_e( 'Server Environment', 'prequelle' ); ?></h4>

				<table>
			<?php
			$php_version = phpversion();
			$required_php_version = $vars['REQUIRED_PHP_VERSION'];
			$php_version_condition = ( version_compare( $php_version, $required_php_version, '>=' ) );
			$php_version_error_message = ( ! $php_version_condition ) ? ' - ' . sprintf( __( 'The theme needs at least PHP %s installed on your server', 'prequelle' ), $vars['REQUIRED_PHP_VERSION'] ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'PHP Version', 'prequelle' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The version of PHP installed on your hosting server.', 'prequelle' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11673/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( $php_version_condition ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $php_version . $php_version_error_message ); ?></td>
						<td class="status <?php echo ( $php_version_condition ) ? 'green' : 'red'; ?>"><?php echo ( $php_version_condition ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			$max_input_vars = @ini_get( 'max_input_vars' );
			$required_max_input_vars = $vars['REQUIRED_MAX_INPUT_VARS'];
			$max_input_vars_condition = ( wp_convert_hr_to_bytes( $max_input_vars ) >= wp_convert_hr_to_bytes( $required_max_input_vars ) );
			$max_input_vars_condition_error_message = ( ! $max_input_vars_condition ) ? ' - ' . sprintf( __( 'It is recommended to increase your server max_input_var value to %s at least', 'prequelle' ), $vars['REQUIRED_MAX_INPUT_VARS'] ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'PHP Max Input Vars', 'prequelle' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The maximum amount of variable your server can use for a single function.', 'prequelle' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11675/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( $max_input_vars_condition ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $max_input_vars . $max_input_vars_condition_error_message ); ?></td>
						<td class="status <?php echo ( $max_input_vars_condition ) ? 'green' : 'red'; ?>"><?php echo ( $max_input_vars_condition ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			$php_post_max_size = size_format( wp_convert_hr_to_bytes( @ini_get( 'post_max_size' ) ) );
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'PHP Post Max Size', 'prequelle' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The largest filesize that can be contained in one post.', 'prequelle' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11672/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data"><?php echo esc_attr( $php_post_max_size ); ?></td>
						<td class="status">&nbsp;</td>
					</tr>
			<?php
			$php_memory_limit = @ini_get( 'memory_limit' );
			$required_php_memory_limit = $vars['REQUIRED_SERVER_MEMORY_LIMIT'];
			$php_memory_limit_condition = ( wp_convert_hr_to_bytes( $php_memory_limit ) >= wp_convert_hr_to_bytes( $required_php_memory_limit ) );
			$php_memory_limit_error_message = ( ! $php_memory_limit_condition ) ? ' - ' . sprintf( __( 'It is recommended to increase your server memory limit to %s at least', 'prequelle' ), $vars['REQUIRED_SERVER_MEMORY_LIMIT'] ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'Server Memory Limit', 'prequelle' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The maximum amount of memory (RAM) that your server can use at one time.', 'prequelle' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11674/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( $php_memory_limit_condition ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $php_memory_limit . $php_memory_limit_error_message ); ?></td>
						<td class="status <?php echo ( $php_memory_limit_condition ) ? 'green' : 'red'; ?>"><?php echo ( $php_memory_limit_condition ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			$max_upload_size = size_format( wp_max_upload_size() );
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'Max Upload Size', 'prequelle' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The largest filesize that can be uploaded to your WordPress installation.', 'prequelle' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11672/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data"><?php echo esc_attr( $max_upload_size ); ?></td>
						<td class="status">&nbsp;</td>
					</tr>
				</table>

				<p><?php
					printf( __( 'Please check the <a target="_blank" href="%s">server requirements</a> recommended by WordPress. You can find more informations <a href="%s" target="_blank">here</a>.', 'prequelle' ),
					'https://wordpress.org/about/requirements/',
					'https://wolfthemes.ticksy.com/article/11651/'

				) ?></p>
			</div><!-- .prequelle-system-status -->

			<?php
		}

		/**
		 * Output the last new feature if set in the changelog XML
		 *
		 */
		private function changelog() {
			if ( $xml = prequelle_get_theme_changelog() ) {
				?>
				<div id="prequelle-notifications">
					<?php if ( '' !== (string)$xml->warning ) {
						$warning = (string)$xml->warning;
					?>
						<div class="prequelle-changelog-notification" id="prequelle-changelog-warning"><?php echo wp_kses_post( $warning ); ?></div>
					<?php } ?>
					<?php if ( '' !== (string)$xml->info ) {
						$info = (string)$xml->info;
					?>
						<div class="prequelle-changelog-notification" id="prequelle-changelog-info"><?php echo wp_kses_post( $info ); ?></div>
					<?php } ?>
					<?php if ( '' !== (string)$xml->new ) {
						$new = (string)$xml->new;
					?>
						<div class="prequelle-changelog-notification" id="prequelle-changelog-news"><?php echo wp_kses_post( $new ); ?></div>
					<?php } ?>
				</div><!-- #prequelle-notifications -->

				<div id="prequelle-changelog">
					<?php echo wp_kses_post( $xml->changelog ); ?>
				</div><!-- #prequelle-changelog -->
				<hr>
				<?php
			}
		}

		/**
		 * Sends user to the welcome page on first activation
		 */
		public function welcome() {
			if ( isset( $_GET['activated'] ) && 'true' == $_GET['activated'] ) {
				flush_rewrite_rules();
				wp_redirect( admin_url( 'admin.php?page=' . $this->theme_slug . '-about&prequelle-activated' ) );
				exit;
			}
		}
	}

	new Prequelle_Admin_About_Page();
} // end class exists check