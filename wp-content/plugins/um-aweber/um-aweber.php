<?php
/*
Plugin Name:        Ultimate Member - AWeber
Plugin URI:         https://tunsplugins.com/products/ultimate-member-aweber
Description:        AWeber Extension for Ultimate Member
Version:            2.0.0
Author:             Tunbosun Ayinla
Author URI:         http://bosun.me
Contributors:       tubiz
Requires at least:  4.5
Tested up to:       4.9

Text Domain:        um-aweber
Domain Path:        /languages
*/

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


if( ! class_exists( 'TunsPLugins_License' ) ) {
    include( dirname( __FILE__ ) . '/license-handler/TunsPlugins_License_Handler.php' );
}

$license = new TunsPLugins_License( __FILE__, 'Ultimate Member - AWeber', 'um_aweber','2.0.0', 'Tunbosun Ayinla' );

if( ! function_exists( 'tunsplugins_license_menu' ) ) {

    function tunsplugins_license_menu(){
        add_plugins_page( 'TunsPlugins Licenses', 'TunsPlugins Licenses', 'manage_options', 'tunsplugins-licenses', 'tunsplugins_license_page' );
    }
    add_action( 'admin_menu', 'tunsplugins_license_menu' );

    function tunsplugins_license_page(){
        require_once plugin_dir_path( __FILE__ ) . '/license-handler/settings-page.php';
    }
}



if ( ! class_exists( 'TBZ_UM_Aweber' ) ) {

    final class TBZ_UM_Aweber{

        /**
         * Holds the instance.
         *
         * Ensures that only one instance of TBZ_UM_Aweber exists in memory at any one
         * time and it also prevents needing to define globals all over the place.
         *
         * TL;DR This is a static property property that holds the singleton instance.
         *
         * @access private
         * @since  1.0
         * @var    \TBZ_UM_Aweber
         * @static
         */
        private static $instance;

        /**
         * The version number.
         *
         * @access private
         * @since  1.0
         * @var    string
         */
        private $version = '2.0.0';

        /**
         * Generates the main TBZ_UM_Aweber instance.
         *
         * Insures that only one instance of TBZ_UM_Aweber exists in memory at any one
         * time. Also prevents needing to define globals all over the place.
         *
         * @access  public
         * @since   1.0
         * @static
         *
         * @return \TBZ_UM_Aweber The one true TBZ_UM_Aweber instance.
         */
        public static function instance() {
            if ( ! isset( self::$instance ) && ! ( self::$instance instanceof TBZ_UM_Aweber ) ) {

                self::$instance = new TBZ_UM_Aweber;
                self::$instance->setup_constants();
                self::$instance->load_textdomain();
                self::$instance->includes();
                self::$instance->hooks();

            }

            return self::$instance;
        }

        /**
         * Throw error on object clone
         *
         * The whole idea of the singleton design pattern is that there is a single
         * object therefore, we don't want the object to be cloned.
         *
         * @since 1.0.0
         * @access protected
         * @return void
         */
        public function __clone() {
            // Cloning instances of the class is forbidden
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'um-aweber' ), '1.0.0' );
        }

        /**
         * Disable unserializing of the class
         *
         * @since 1.0.0
         * @access protected
         * @return void
         */
        public function __wakeup() {
            // Unserializing instances of the class is forbidden
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'um-aweber' ), '1.0.0' );
        }

        /**
         * Sets up the class.
         *
         * @access private
         * @since  1.0
         */
        private function __construct() {
            self::$instance = $this;
        }

        /**
         * Resets the instance of the class.
         *
         * @access public
         * @since  1.0
         * @static
         */
        public static function reset() {
            self::$instance = null;
        }

        /**
         * Sets up plugin constants.
         *
         * @access private
         * @since  2.0.0
         *
         * @return void
         */
        private function setup_constants() {
            // Plugin version
            if ( ! defined( 'TBZ_UM_AWEBER_VERSION' ) ) {
                define( 'TBZ_UM_AWEBER_VERSION', $this->version );
            }

            // Plugin Folder Path
            if ( ! defined( 'TBZ_UM_AWEBER_PLUGIN_DIR' ) ) {
                define( 'TBZ_UM_AWEBER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
            }

            // Plugin Folder URL
            if ( ! defined( 'TBZ_UM_AWEBER_PLUGIN_URL' ) ) {
                define( 'TBZ_UM_AWEBER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
            }

            // Plugin Root File
            if ( ! defined( 'TBZ_UM_AWEBER_PLUGIN_FILE' ) ) {
                define( 'TBZ_UM_AWEBER_PLUGIN_FILE', __FILE__ );
            }
        }

        /**
         * Loads the plugin language files.
         *
         * @access public
         * @since  1.0
         *
         * @return void
         */
        public function load_textdomain() {

            // Set filter for plugin's languages directory.
            $lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';

            /**
             * Filters the languages directory for Ultimate Member - AWeber plugin.
             *
             * @since 1.0
             *
             * @param string $lang_dir Language directory.
             */
            $lang_dir = apply_filters( 'um_aweber_languages_directory', $lang_dir );

            // Traditional WordPress plugin locale filter.
            $locale = apply_filters( 'plugin_locale',  get_locale(), 'um-aweber' );
            $mofile = sprintf( '%1$s-%2$s.mo', 'um-aweber', $locale );

            // Setup paths to current locale file.
            $mofile_local  = $lang_dir . $mofile;
            $mofile_global = WP_LANG_DIR . '/um-aweber/' . $mofile;

            if ( file_exists( $mofile_global ) ) {

                // Look in global /wp-content/languages/um-aweber/ folder.
                load_textdomain( 'um-aweber', $mofile_global );

            } elseif ( file_exists( $mofile_local ) ) {

                // Look in local /wp-content/plugins/um-aweber/languages/ folder.
                load_textdomain( 'um-aweber', $mofile_local );

            } else {

                // Load the default language files.
                load_plugin_textdomain( 'um-aweber', false, $lang_dir );

            }
        }

        /**
         * Includes necessary files.
         *
         * @access private
         * @since  1.0
         *
         * @return void
         */
        private function includes() {

            if ( is_admin() ) {

                require_once TBZ_UM_AWEBER_PLUGIN_DIR . 'includes/admin/class-settings.php';

            }

        }

        /**
         * Sets up the default hooks and actions.
         *
         * @access private
         * @since  1.0.0
         *
         * @return void
         */
        private function hooks() {

            add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );

            add_action( 'admin_init', array( $this, 'tbz_um_aweber_check_requirements' ) );

            if ( class_exists( 'UM_Functions' ) ) {

                add_action( 'um_registration_complete', array( $this, 'tbz_um_aweber_add_user_to_list' ), 10, 2 );

            } else {

                add_action( 'um_post_registration_global_hook', array( $this, 'tbz_um_aweber_add_user_to_list' ), 10, 2 );

            }


            add_filter( 'um_edit_field_register_aweber', array( $this, 'tbz_um_edit_field_register_aweber' ), 10, 2 );

        }


        /**
         * Check if required plugins are installed and activated
         *
         * @since       1.0.0
         */
        public function tbz_um_aweber_check_requirements() {

            if ( ! ( class_exists( 'UM_Functions' ) || class_exists('UM_API' ) ) ) {

                // display notice
                add_action( 'admin_notices', array( $this, 'admin_notices' ) );

            }

        }

        /**
         * Show notice if required plugins are not installed
         *
         * @since       1.0.0
         */
        public function admin_notices() {

            echo '<div class="error"><p>You must install and activate <strong><a href="'. admin_url('plugin-install.php?tab=search&type=term&s=Ultimate+Member') .'" title="Ultimate Member" target="_blank">Ultimate Member</a></strong> plugin to use the <strong>Ultimate Member - Aweber</strong> extension</p></div>';

        }

        /**
         * Show aweber checkbox on registration page
         *
         * @since       1.0.0
         */
        public function tbz_um_edit_field_register_aweber( $output, $data ) {

            extract( $data );

            if ( empty( $aweber_list ) )
                return false;

            if ( isset( $aweber_autosubscribe ) && $aweber_autosubscribe ) {
                return '<input type="hidden" name="um-aweber['.$aweber_list.']" value="1" />';
            }

            $checkbox_active = $aweber_checkbox_state == 'checked' ? 'um-field-checkbox active' : 'um-field-checkbox';
            $checkbox_class = $aweber_checkbox_state == 'checked' ? 'um-icon-android-checkbox-outline' : 'um-icon-android-checkbox-outline-blank';
            $checkbox_state = $aweber_checkbox_state == 'checked' ? 'checked' : '';

            ob_start();

            ?>

            <div class="um-field um-field-b um-field-aweber" data-key="<?php echo $metakey; ?>">

                <div class="um-field-area">

                    <label class="<?php echo $checkbox_active; ?>">
                        <input type="checkbox" name="um-aweber[<?php echo $aweber_list; ?>]" <?php echo $checkbox_state; ?> value="1" />
                        <span class="um-field-checkbox-state">
                            <i class="<?php echo $checkbox_class; ?>"></i>
                        </span>
                        <span class="um-field-checkbox-option"><?php echo ( $aweber_label ) ? $aweber_label : __( 'Signup for our newsletter', 'um-aweber' ); ?></span>
                    </label>

                    <?php wp_reset_postdata(); ?>

                    <div class="um-clear"></div>

                </div>

            </div>

            <?php

            $output .= ob_get_contents();
            ob_end_clean();

            return $output;
        }

        /**
         * Add user to aweber list after registering
         *
         * @since       1.0.0
         */
        public function tbz_um_aweber_add_user_to_list( $user_id, $args ) {

            if ( ! isset( $_POST['um-aweber'] ) ) {
                return;
            }

            foreach ( $_POST['um-aweber'] as $list_id => $value ) {

                if( ! empty ( $list_id ) ){

                    $user = get_user_by( 'id', $user_id );

                    $first_name     = $user->first_name;
                    $last_name      = $user->last_name;
                    $email          = $user->user_email;

                    $details = array(
                        'first_name'    => $first_name,
                        'last_name'     => $last_name,
                        'email'         => $email,
                        'user_id'       => $user_id,
                        'list_id'       => $list_id
                    );

                    $user = $this->tbz_um_add_to_aweber_list( $details );
                }
            }

            return;
        }

        /**
         * Add to aweber list helper
         *
         * @since       1.0.0
         * @param       array $args Aweber subscribe args
         */
        public function tbz_um_add_to_aweber_list( $args ) {

            require_once TBZ_UM_AWEBER_PLUGIN_DIR . 'aweber_api/aweber_api.php';

            try {

                $aweber_credentials = get_option( 'um_aweber_credentials' );

                $aweber = new AWeberAPI( $aweber_credentials['consumer_key'], $aweber_credentials['consumer_secret'] );

                $account = $aweber->getAccount( $aweber_credentials['access_key'], $aweber_credentials['access_secret'] );

                $ip = ( array_key_exists( 'X_FORWARDED_FOR', $_SERVER ) ) ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

                $params =  array(
                    'email'         => $args['email'],
                    'ip_address'    => $ip,
                    'name'          => $args['first_name'] .' '.$args['last_name'],
                    'ad_tracking'   => 'UltimateMember',
                );

                $list_url       = "/accounts/{$account->id}/lists/{$args['list_id']}";
                $list           = $account->loadFromUrl( $list_url );
                $subscribers    = $list->subscribers;
                $new_subscriber = $subscribers->create( $params );

                return $new_subscriber;
            }
            catch ( Exception $e ) {
                return;
            }
        }

        /**
        * Add Settings link to the plugin entry in the plugins menu
        **/
        public function plugin_action_links( $links ) {

            if ( class_exists( 'UM_Functions' ) || class_exists( 'UM_API' ) ) {

                $settings_link = array(
                    'settings' => '<a href="' . admin_url( 'admin.php?page=um_options&tab=extensions&section=aweber' ) . '" title="View Ultimate Member - Aweber Settings">Settings</a>'
                );

                return array_merge( $settings_link, $links );
            }

            return $links;
        }

    }

    /**
     * The main function responsible for returning the one true TBZ_UM_Aweber
     * instance to functions everywhere.
     *
     * Use this function like you would a global variable, except without needing
     * to declare the global.
     *
     * Example: <?php $tbz_um_aweber = tbz_um_aweber(); ?>
     *
     * @since  1.0.0
     *
     * @return \TBZ_UM_Aweber The one true TBZ_UM_Aweber instance.
     */
    function tbz_um_aweber() {
        return TBZ_UM_Aweber::instance();
    }
    add_action( 'plugins_loaded', 'tbz_um_aweber', 100 );

}