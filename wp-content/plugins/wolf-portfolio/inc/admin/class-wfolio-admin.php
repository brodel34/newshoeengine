<?php
/**
 * Wolf Portfolio Admin.
 *
 * @class Wolf_Portfolio_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfPortfolio/Admin
 * @version 1.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Wolf_Portfolio_Admin class.
 */
class Wolf_Portfolio_Admin {
	/**
	 * Constructor
	 */
	public function __construct() {

		// Includes files
		$this->includes();

		// Set metaboxes
		$this->metaboxes();

		// Admin init hooks
		$this->admin_init_hooks();
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		include_once( 'class-wfolio-options.php' );
		include_once( 'class-wfolio-metabox.php' );
		include_once( 'wfolio-admin-functions.php' );
	}

	/**
	 * Admin init
	 */
	public function admin_init_hooks() {

		// Plugin settings link
		add_filter( 'plugin_action_links_' . plugin_basename( WFOLIO_PATH ), array( $this, 'settings_action_links' ) );

		// Plugin update notifications
		add_action( 'admin_init', array( $this, 'plugin_update' ) );

		// Create page notice
		add_action( 'admin_notices', array( $this, 'check_page' ) );
		add_action( 'admin_notices', array( $this, 'create_page' ) );
		
		// Hide editors from index page
		add_action( 'edit_form_after_title', array( $this, 'is_index_page' ) );
		add_action( 'admin_init', array( $this, 'hide_editor' ) );
		add_action( 'admin_head', array( $this, 'hide_wpb_editor' ) );

		// Add columns to post list
		add_filter( 'manage_work_posts_columns', array( $this, 'admin_columns_head_work_thumb' ), 10 );
		add_action( 'manage_work_posts_custom_column', array( $this, 'admin_columns_content_work_thumb' ), 10, 2 );
	}

	/**
	 * Add metaboxes
	 */
	public function metaboxes() {
		include_once( 'wfolio-metaboxes.php' );
	}

	/**
	 * Check portfolio page
	 *
	 * Display a notification if we can't get the portfolio page id
	 *
	 */
	public function check_page() {

		$output    = '';
		$theme_dir = get_template_directory();

		// update_option( '_wolf_portfolio_needs_page', true );
		// delete_option( '_wolf_portfolio_no_needs_page', true );
		// delete_option( '_wolf_portfolio_page_id' );

		if ( get_option( '_wolf_portfolio_no_needs_page' ) )
			return;

		if ( ! get_option( '_wolf_portfolio_needs_page' ) )
			return;

		if ( -1 == wolf_portfolio_get_page_id() && ! isset( $_GET['wolf_portfolio_create_page'] ) ) {

			if ( isset( $_GET['skip_wolf_portfolio_setup'] ) ) {
				delete_option( '_wolf_portfolio_needs_page' );
				return;
			}

			update_option( '_wolf_portfolio_needs_page', true );

			$message = '<strong>Wolf Portfolio</strong> ' . sprintf(
					wp_kses(
						__( 'says : <em>Almost done! you need to <a href="%1$s">create a page</a> for your portfolio or <a href="%2$s">select an existing page</a> in the plugin settings</em>.', 'wolf-portfolio' ),
						array(
							'a' => array(
								'href' => array(),
								'class' => array(),
								'title' => array(),
							),
							'br' => array(),
							'em' => array(),
							'strong' => array(),
						)
					),
					esc_url( admin_url( '?wolf_portfolio_create_page=true' ) ),
					esc_url( admin_url( 'edit.php?post_type=work&page=wolf-portfolio-settings' ) )
			);

			$message .= sprintf(
				wp_kses(
					__( '<br><br>
					<a href="%1$s" class="button button-primary">Create a page</a>
					&nbsp;
					<a href="%2$s" class="button button-primary">Select an existing page</a>
					&nbsp;
					<a href="%3$s" class="button">Skip setup</a>', 'wolf-portfolio' ),

					array(
							'a' => array(
								'href' => array(),
								'class' => array(),
								'title' => array(),
							),
							'br' => array(),
							'em' => array(),
							'strong' => array(),
						)
				),
					esc_url( admin_url( '?wolf_portfolio_create_page=true' ) ),
					esc_url( admin_url( 'edit.php?post_type=work&page=wolf-portfolio-settings' ) ),
					esc_url( admin_url( '?skip_wolf_portfolio_setup=true' ) )
			);

			$output = '<div class="updated wolf-admin-notice wolf-plugin-admin-notice"><p>';

				$output .= $message;

			$output .= '</p></div>';

			echo $output;
		} else {

			delete_option( '_wolf_portfolio_need_page' );
		}

		return false;
	}

	/**
	 * Create portfolio page
	 */
	public function create_page() {

		if ( isset( $_GET['wolf_portfolio_create_page'] ) && $_GET['wolf_portfolio_create_page'] == 'true' ) {

			$output = '';

			// Create post object
			$post = array(
				'post_title'  => esc_html__( 'Portfolio', 'wolf-portfolio' ),
				'post_type'   => 'page',
				'post_status' => 'publish',
			);

			// Insert the post into the database
			$post_id = wp_insert_post( $post );

			if ( $post_id ) {

				update_option( '_wolf_portfolio_page_id', $post_id );
				update_post_meta( $post_id, '_wpb_status', 'off' ); // disable page builder mode for this page

				$message = esc_html__( 'Your portfolio page has been created succesfully', 'wolf-portfolio' );

				$output = '<div class="updated"><p>';

				$output .= $message;

				$output .= '</p></div>';

				echo $output;
			}

		}

		return false;
	}

	/**
	 * Display notice on portfolio page
	 */
	public function is_index_page() {

		if ( isset( $_GET['post'] ) && absint( $_GET['post'] ) == wolf_portfolio_get_page_id() ) {
			$message = esc_html__( 'You are currently editing the page that shows the portfolio.', 'wolf-portfolio' );

			$output = '<div class="notice notice-warning inline"><p>';

			$output .= $message;

			$output .= '</p></div>';

			echo $output;
		}
	}

	/**
	 * Hide the editor if we're on the admin portfolio page
	 */
	public function hide_editor() {
		if ( isset( $_GET['post'] ) && absint( $_GET['post'] ) == wolf_portfolio_get_page_id() ) {
			remove_post_type_support( 'page', 'editor' );
		}
	}

	/**
	 * Hide the editor if we're on the admin portfolio page
	 */
	public function hide_wpb_editor() {
		if ( isset( $_GET['post'] ) && absint( $_GET['post'] ) == wolf_portfolio_get_page_id() ) {
			?>
			<style type="text/css">
			.wpb-toggle-editor,
			#wpb-import-export-buttons,
			#wpb_content{
				display:none!important;
			}
			</style>
			<?php
		}
	}

	/**
	 * Add thumbnail column head in admin posts list
	 *
	 * @param array $columns
	 * @return array $columns
	 */
	public function admin_columns_head_work_thumb( $columns ) {

		$columns['work_thumbnail']   = esc_html__( 'Thumbnail', 'wolf-portfolio' );
		return $columns;
	}

	/**
	 * Add thumbnail column in admin posts list
	 *
	 * @param string $column_name
	 * @param int $post_id
	 */
	public function admin_columns_content_work_thumb( $column_name, $post_id ) {

		$thumbnail = get_the_post_thumbnail();

		if ( 'work_thumbnail' == $column_name ) {

			if ( $thumbnail ) {
				echo '<a href="' . get_edit_post_link() . '" title="' . esc_attr( sprintf( esc_html__( 'Edit "%s"', 'wolf-portfolio' ), get_the_title() ) ) . '">' . get_the_post_thumbnail( '', array( 60, 60 ), array( 'style' => 'max-width:60px;height:auto;' ) ) . '</a>';
			}
		}
	}

	/**
	 * Add settings link in plugin page
	 */
	public function settings_action_links( $links ) {
		$setting_link = array(
			'<a href="' . admin_url( 'edit.php?post_type=work&page=wolf-portfolio-settings' ) . '">' . esc_html__( 'Settings', 'wolf-portfolio' ) . '</a>',
		);
		return array_merge( $links, $setting_link );
	}

	/**
	 * Plugin update
	 */
	public function plugin_update() {
		
		$plugin_name = WFOLIO_SLUG;
		$plugin_slug = WFOLIO_SLUG;
		$plugin_path = WFOLIO_PATH;
		$remote_path = WFOLIO_UPDATE_URL . '/' . $plugin_slug;
		$plugin_data = get_plugin_data( WFOLIO_DIR . '/' . WFOLIO_SLUG . '.php' );
		$current_version = $plugin_data['Version'];
		include_once( 'class-wfolio-update.php');
		new Wolf_Portfolio_Update( $current_version, $remote_path, $plugin_path );
	}
}

return new Wolf_Portfolio_Admin();