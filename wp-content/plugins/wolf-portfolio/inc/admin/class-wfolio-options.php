<?php
/**
 * Wolf Portfolio Options.
 *
 * @class Wolf_Portfolio_Options
 * @author WolfThemes
 * @category Admin
 * @package WolfPortfolio/Admin
 * @version 1.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Wolf_Portfolio_Options class.
 */
class Wolf_Portfolio_Options {
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
	 * Add options menu
	 */
	public function add_settings_menu() {

		add_submenu_page( 'edit.php?post_type=work', esc_html__( 'Settings', 'wolf-portfolio' ), esc_html__( 'Settings', 'wolf-portfolio' ), 'edit_plugins', 'wolf-portfolio-settings', array( $this, 'options_form' ) );
		add_submenu_page( 'edit.php?post_type=work', esc_html__( 'Shortcode', 'wolf-portfolio' ), esc_html__( 'Shortcode', 'wolf-portfolio' ), 'edit_plugins', 'wolf-portfolio-shortcode', array( $this, 'help' ) );
	}

	/**
	 * Set default options
	 */
	public function default_options() {

		global $options;

		if ( false === get_option( 'wolf_portfolio_settings' ) ) {

			$default = array(
				'col' => 3,
				'layout' => 'standard',
			);

			add_option( 'wolf_portfolio_settings', $default );
		}
	}

	/**
	 * Init Settings
	 */
	public function register_settings() {

		register_setting( 'wolf-portfolio-settings', 'wolf_portfolio_settings', array( $this, 'settings_validate' ) );
		add_settings_section( 'wolf-portfolio-settings', '', array( $this, 'section_intro' ), 'wolf-portfolio-settings' );
		add_settings_field( 'page_id', esc_html__( 'Portfolio Page', 'wolf-portfolio' ), array( $this, 'setting_page_id' ), 'wolf-portfolio-settings', 'wolf-portfolio-settings' );
		add_settings_field( 'name', esc_html__( 'Portfolio Item Name', 'wolf-portfolio' ), array( $this, 'setting_name' ), 'wolf-portfolio-settings', 'wolf-portfolio-settings' );
		add_settings_field( 'slug', esc_html__( 'Portfolio Item Slug', 'wolf-portfolio' ), array( $this, 'setting_slug' ), 'wolf-portfolio-settings', 'wolf-portfolio-settings' );
		// add_settings_field( 'layout', esc_html__( 'Layout', 'wolf-portfolio' ), array( $this, 'setting_layout' ), 'wolf-portfolio-settings', 'wolf-portfolio-settings' );
		add_settings_field( 'columns', esc_html__( 'Max number of column', 'wolf-portfolio' ), array( $this, 'setting_columns' ), 'wolf-portfolio-settings', 'wolf-portfolio-settings', array( 'class' => 'wolf-portfolio-settings-columns' ) );
	}

	/**
	 * Validate settings
	 */
	public function settings_validate( $input ) {

		$input['col'] = absint( $input['col'] );

		if ( isset( $input['page_id'] ) ) {
			update_option( '_wolf_portfolio_page_id', intval( $input['page_id'] ) );
			unset( $input['page_id'] );
		}

		if ( isset( $input['slug'] ) ) {
			$input['slug'] = sanitize_title_with_dashes( $input['slug'] );
			flush_rewrite_rules();
		}

		return $input;
	}

	/**
	 * Intro section
	 *
	 * @return string
	 */
	public function section_intro() {

		// add instructions
	}

	/**
	 * Page settings
	 *
	 * @return string
	 */
	public function setting_page_id() {
		$page_option = array( '' => esc_html__( '- Disabled -', 'wolf-portfolio' ) );
		$pages = get_pages();

		foreach ( $pages as $page ) {

			if ( get_post_field( 'post_parent', $page->ID ) ) {
				$page_option[ absint( $page->ID ) ] = '&nbsp;&nbsp;&nbsp; ' . sanitize_text_field( $page->post_title );
			} else {
				$page_option[ absint( $page->ID ) ] = sanitize_text_field( $page->post_title );
			}
		}
		?>
		<select name="wolf_portfolio_settings[page_id]">
			<option value="-1"><?php esc_html_e( 'Select a page...', 'wolf-portfolio' ); ?></option>
			<?php foreach ( $page_option as $k => $v ) : ?>
				<option <?php selected( absint( $k ), get_option( '_wolf_portfolio_page_id' ) ); ?> value="<?php echo intval( $k ); ?>"><?php echo sanitize_text_field( $v ); ?></option>
			<?php endforeach; ?>
		</select>
		<?php
	}

	/**
	 * Name
	 */
	public function setting_name() {
		?>
		<input type="text" name="wolf_portfolio_settings[name]" value="<?php echo esc_attr( wolf_portfolio_get_option( 'name', 'Work' ) ); ?>">
		<?php //esc_html_e( 'Number of column on desktop screen', 'wolf-portfolio' ); ?>
		<?php
	}

	/**
	 * Slug
	 */
	public function setting_slug() {
		?>
		<input type="text" name="wolf_portfolio_settings[slug]" value="<?php echo esc_attr( wolf_portfolio_get_option( 'slug', 'work' ) ); ?>">
		<?php //esc_html_e( 'Number of column on desktop screen', 'wolf-portfolio' ); ?>
		<?php
	}

	/**
	 * Layout
	 */
	public function setting_layout() {
		$columns = array( 1, 2, 3, 4, 5, 6 );
		?>
		<select name="wolf_portfolio_settings[layout]">
			<?php foreach ( $columns as $column ) : ?>
			<option <?php if ( $column == wolf_portfolio_get_option( 'col', 3 ) ) echo 'selected="selected"'; ?>><?php echo intval( $column ); ?></option>
			<?php endforeach; ?>
		</select>
		<?php esc_html_e( 'Number of column on desktop screen', 'wolf-portfolio' ); ?>
		<?php
	}

	/**
	 * Column
	 */
	public function setting_columns() {
		$columns = array( 1, 2, 3, 4, 5, 6 );
		?>
		<select name="wolf_portfolio_settings[col]">
			<?php foreach ( $columns as $column ) : ?>
			<option <?php if ( $column == wolf_portfolio_get_option( 'col', 3 ) ) echo 'selected="selected"'; ?>><?php echo intval( $column ); ?></option>
			<?php endforeach; ?>
		</select>
		<?php esc_html_e( 'Number of column on desktop screen', 'wolf-portfolio' ); ?>
		<?php
	}

	/**
	 * Display options form
	 *
	 */
	public function options_form() {
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Portfolio Settings' ) ?></h2>
			<?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) { ?>
				<div id="setting-error-settings_updated" class="updated settings-error">
					<p><strong><?php esc_html_e( 'Settings saved.', 'wolf-portfolio' ); ?></strong></p>
				</div>
			<?php } ?>
			<form action="options.php" method="post">
				<?php settings_fields( 'wolf-portfolio-settings' ); ?>
				<?php do_settings_sections( 'wolf-portfolio-settings' ); ?>
				<p class="submit"><input name="save" type="submit" class="button-primary" value="<?php esc_html_e( 'Save Changes', 'wolf-portfolio' ); ?>" /></p>
			</form>
		</div>
		<?php
	}

	/**
	 * Displays Shortcode help
	 */
	public function help() {
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Portfolio Shortcode', 'wolf-portfolio' ) ?></h2>
			<p><?php esc_html_e( 'To display your last works in your post or page you can use the following shortcode.', 'wolf-portfolio' ); ?></p>
			<p><code>[wolf_last_works]</code></p>
			<p><?php esc_html_e( 'Additionally, you can add a count and/or a category attribute.', 'wolf-portfolio' ); ?></p>
			<p><code>[wolf_last_works count="6" category="my-category"]</code></p>

			<p><?php esc_html_e( 'You can also add a column count attribute.', 'wolf-portfolio' ); ?></p>
			<p><code>[wolf_last_works col="2|3|4" category="my-category"]</code></p>
		</div>
		<?php
	}
}

return new Wolf_Portfolio_Options();