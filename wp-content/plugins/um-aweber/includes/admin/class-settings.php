<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


class TBZ_UM_Aweber_Settings {

	public function __construct() {

        add_filter( 'um_core_fields_hook', array( $this, 'tbz_um_aweber_add_field' ), 10 );
        add_filter( 'um_fields_without_metakey', array( $this, 'tbz_um_aweber_requires_no_metakey' ) );
        add_action( 'um_admin_field_edit_hook_aweber_list', array( $this, 'tbz_um_admin_field_edit_hook_aweber_list' ) );
        add_action( 'um_admin_field_edit_hook_aweber_label', array( $this, 'tbz_um_admin_field_edit_hook_aweber_label') );
        add_action( 'um_admin_field_edit_hook_aweber_checkbox_state', array( $this, 'tbz_um_admin_field_edit_hook_aweber_checkbox_state') );
        add_action( 'um_admin_field_edit_hook_aweber_autosubscribe', array( $this, 'tbz_um_admin_field_edit_hook_aweber_autosubscribe' ) );

        // UM 1.x settings
        add_filter( 'redux/options/um_options/sections', array( $this, 'aweber_settings' ), 20 );
        add_filter( 'redux/options/um_options/saved', array( $this, 'settings_callback' ) );

        // UM 2.x settings
        add_filter( 'um_settings_structure', array( $this, 'aweber_settings_v2' ) );

        // UM 2.x save settings
		add_action( 'um_settings_save', array( $this, 'aweber_save_settings_v2' ) );

        add_action( 'um_settings_page_before_extensions__content', array( $this, 'admin_notices' ), 1 );

	}

    /**
     * Add aweber to ultimate member core fields
     *
     * @since       1.0.0
     */
    public function tbz_um_aweber_add_field($fields){

        $fields['aweber'] = array(
            'name'      => __( 'AWeber', 'um-aweber' ),
            'col1'      => array( '_title' ),
            'col2'      => array( '_aweber_list' ),
            'col3'      => array( '_aweber_label', '_aweber_checkbox_state', '_aweber_autosubscribe' ),
            'validate'  => array(
                '_title' => array(
                    'mode'  => 'required',
                    'error' => __( 'You must provide a title', 'um-aweber' )
                ),
                '_aweber_list' => array(
                    'mode'  => 'required',
                    'error' => __( 'You must select the list users will be added to', 'um-aweber' )
                ),
            )
        );

        return $fields;
    }

    /**
     * Do not require a metakey on mailchimp field
     *
     * @since       1.0.0
     */
    public function tbz_um_aweber_requires_no_metakey( $array ) {
        $array[] = 'aweber';
        return $array;
    }

    /**
     * Aweber list modal field settings
     *
     * @since       1.0.0
     */
    public function tbz_um_admin_field_edit_hook_aweber_list( $val ) {

        $lists = $this->tbz_um_get_aweber_lists();

        if ( ! $lists ) return;

        if ( class_exists( 'UM' ) ) {

            $metabox = new UM();

        } else {

            $metabox = new UM_Admin_Metabox();

        }

        ?>
            <p>
                <label for="_aweber_list"><?php _e( 'Select a List', 'um-aweber'); ?><?php $metabox->tooltip( __( 'Set up your lists in your AWeber account. This is the list users will be added to when they register.', 'um-aweber' ) ); ?></label>
                <select name="_aweber_list" id="_aweber_list" class="umaf-selectjs" style="width: 100%">
                    <?php foreach( $lists as  $key => $list ) { ?>
                        <option value="<?php echo $key; ?>"
                            <?php selected( $key, $val ); ?>><?php echo $list; ?>
                        </option>
                    <?php } ?>
                </select>
            </p>
        <?php
    }

    /**
     * Aweber label modal field settings
     *
     * @since       1.0.0
     */
    public function tbz_um_admin_field_edit_hook_aweber_label( $val ) {

        if ( class_exists( 'UM' ) ) {

            $metabox = new UM();

        } else {

            $metabox = new UM_Admin_Metabox();

        }

        ?>
            <p>
                <label for="_aweber_label"><?php _e( 'Subscribe Label', 'um-aweber' ); ?><?php $metabox->tooltip( __( 'Enter the form label here. The default label is: Signup for our newsletter', 'um-aweber' ) ); ?></label>
                <input type="text" name="_aweber_label" id="_aweber_label" value="<?php echo $val; ?>" />
            </p>
        <?php
    }

    /**
     * Aweber checkbox state modal field settings
     *
     * @since       1.0.0
     */
    public function tbz_um_admin_field_edit_hook_aweber_checkbox_state( $val ) {

        if ( class_exists( 'UM' ) ) {

            $metabox = new UM();

        } else {

            $metabox = new UM_Admin_Metabox();

        }

        ?>
            <p>
                <label for="_aweber_checkbox_state"><?php _e( 'Sign-up Checkbox Default State', 'um-aweber' ) ;?><?php $metabox->tooltip( __( 'The default state of the sign-up checkbox. This is only used when the Auto Subscribe option below is set to No.', 'um-aweber' ) ); ?></label>

                <select name="_aweber_checkbox_state" id="_aweber_checkbox_state" class="umaf-selectjs" style="width: 100%">
                    <option value="checked" <?php selected( 'checked', $val ); ?>>
                        <?php _e( 'Checked', 'um-aweber' ); ?>
                    </option>
                    <option value="unchecked" <?php selected( 'unchecked', $val ); ?>>
                        <?php _e( 'Unchecked', 'um-aweber' ); ?>
                    </option>
                </select>
            </p>
        <?php
    }

    /**
     * Aweber autosubscribe modal field settings
     *
     * @since       1.0.0
     */
    public function tbz_um_admin_field_edit_hook_aweber_autosubscribe( $val ) {

        if ( class_exists( 'UM' ) ) {

            $metabox = new UM();

        } else {

            $metabox = new UM_Admin_Metabox();

        }

        ?>
            <p>
                <label for="_aweber_autosubscribe"><?php _e( 'Auto Subscribe', 'um-aweber' ); ?><?php $metabox->tooltip( __( 'Allow users to be added to this list automatically. This will hide the subscribe checkbox on the registration page', 'um-aweber' ) ); ?></label>

                <span class="um-admin-yesno">
                    <span class="btn pos-<?php echo $val; ?>"></span>
                    <span class="yes" data-value="1"><?php _e( 'Yes', 'um-aweber' ); ?></span>
                    <span class="no" data-value="0"><?php _e( 'No', 'um-aweber' ); ?></span>
                    <input type="hidden" name="_aweber_autosubscribe" id="_aweber_autosubscribe" value="<?php echo $val; ?>" />
                </span>
            </p>
        <?php
    }

    /**
     * Aweber settings
     *
     * @since       1.0.0
     */
    public function aweber_settings( $sections ){

        $sections[] = array(

            'subsection' => true,
            'title'      => __( 'AWeber', 'um-aweber' ),
            'fields'     => array(
                array(
                    'id'            => 'tbz_um_aweber_authorization_code',
                    'type'          => 'textarea',
                    'rows'          => 2,
                    'title'         => __( 'Authorization Code', 'um-aweber' ),
                    'compiler'      => true,
                    'desc'          => __( 'Enter your Aweber Authorization Code here.<br />Click <a href="https://auth.aweber.com/1.0/oauth/authorize_app/2502752d" target="_blank">here</a> to retrieve your authorization code.', 'um-aweber' ),
                ),
            )

        );
        return $sections;
    }

    /**
     * Aweber settings callback
     *
     * @since       1.0.0
     */
    public function settings_callback( $options ){

        $authorization_code = $options['tbz_um_aweber_authorization_code'];

        if( empty( $authorization_code ) ){
            return;
        }

        $auth_code = get_option( 'um_aweber_authorization_code' );

        if( $authorization_code == $auth_code ){
            return;
        }
        else{
            delete_option( 'um_aweber_credentials' );
        }

        $aweber_credentials = get_option( 'um_aweber_credentials' );

        if( $aweber_credentials ){
           return;
        }

        require_once TBZ_UM_AWEBER_PLUGIN_DIR . 'aweber_api/aweber_api.php';

        try{
            $auth = AWeberAPI::getDataFromAweberID( $authorization_code );

            if( empty( $auth ) ) {
                echo '<div class="saved_notice admin-notice notice-yellow"><strong>Invalid AWeber authorization code. Generate another AWeber authorization code and try again.</strong></div>';
            }
            else {
                list( $consumerKey, $consumerSecret, $accessKey, $accessSecret) = $auth;

                $aweber_credentials = array(
                    'consumer_key'      => $consumerKey,
                    'consumer_secret'   => $consumerSecret,
                    'access_key'        => $accessKey,
                    'access_secret'     => $accessSecret
                );

                update_option( 'um_aweber_credentials', $aweber_credentials );
                update_option( 'um_aweber_authorization_code', $authorization_code );
                echo '<div class="saved_notice admin-notice notice-green"><strong>Valid AWeber authorization code!</strong></div>';
            }
        }
        catch( AWeberAPIException $exc ) {
            echo '<div class="saved_notice admin-notice notice-yellow"><strong>Invalid AWeber authorization code. Generate another AWeber authorization code and try again.</strong></div>';
        }
    }


    /**
     * Get all aweber lists
     *
     * @since       1.0.0
     * @return      array $lists The aweber lists array
     */
    public function tbz_um_get_aweber_lists() {

        $lists = array();

        require_once TBZ_UM_AWEBER_PLUGIN_DIR . 'aweber_api/aweber_api.php';

        $aweber_credentials = get_option( 'um_aweber_credentials' );

        if( ! $aweber_credentials ){
            $lists[''] = __( 'Invalid AWeber authorization code. Go to the Ultimate Member AWeber settings page to enter another authorization code.', 'um_aweber' );
            return $lists;
        }

        $aweber = new AWeberAPI( $aweber_credentials['consumer_key'], $aweber_credentials['consumer_secret'] );

        $account = $aweber->getAccount( $aweber_credentials['access_key'], $aweber_credentials['access_secret'] );

        $aweber_lists = $account->lists;

        foreach( $aweber_lists as $list ){
            $lists[ $list->id ] = $list->name;
        }

        return $lists;
    }


    /**
     * AWeber settings for UM 2.x
     *
     * @since       2.0.0
     */
	public function aweber_settings_v2( $settings ) {

	    $aweber =  array(
	        'title'     => 'AWeber',
	        'fields'     => array(
	            array(
	                'id'            => 'tbz_um_aweber_authorization_code',
	                'type'          => 'textarea',
	                'label'         => __( 'AWeber Authorization Code', 'um-aweber' ),
	                'tooltip'       => __( 'Enter your Aweber Authorization Code here.', 'um-aweber' ),
                    'args'          => array(
                        'textarea_rows' => 3
                    )
	            ),
                array(
                    'id'            => 'tbz_um_aweber_info',
                    'type'          => 'info_text',
                    'value'         => __( 'Retrieve your authorization code via this link - https://auth.aweber.com/1.0/oauth/authorize_app/2502752d', 'um-aweber' )
                ),
	        )
	    );

	    if ( empty( $settings['extensions']['sections'] ) ) {
	        $settings['extensions']['sections'][''] = $aweber;
	    } else {
	        $settings['extensions']['sections']['aweber'] = $aweber;
	    }

	    return $settings;

	}

    /**
     * AWeber settings callback for UM 2.x
     *
     * @since       2.0.0
     */
	public function aweber_save_settings_v2() {

	    if ( ! isset( $_POST['um_options']['tbz_um_aweber_authorization_code'] ) )
	        return;

        $authorization_code = UM()->options()->get( 'tbz_um_aweber_authorization_code' );

        if ( empty( $authorization_code ) ){
            return;
        }

        $auth_code = get_option( 'um_aweber_authorization_code' );

        if ( $authorization_code == $auth_code ){
            return;
        } else {
            delete_option( 'um_aweber_credentials' );
            delete_option( 'um_aweber_authorization_code' );
        }

        $aweber_credentials = get_option( 'um_aweber_credentials' );

        if ( $aweber_credentials ){
            return;
        }

        require_once TBZ_UM_AWEBER_PLUGIN_DIR . 'aweber_api/aweber_api.php';

        try {
            $auth = AWeberAPI::getDataFromAweberID( $authorization_code );

            if ( empty( $auth ) ) {

                $url = add_query_arg( 'um_aweber_notice', 'invalid_auth' );

                wp_redirect( $url );
                exit;

            } else {

                list( $consumerKey, $consumerSecret, $accessKey, $accessSecret) = $auth;

                $aweber_credentials = array(
                    'consumer_key'      => $consumerKey,
                    'consumer_secret'   => $consumerSecret,
                    'access_key'        => $accessKey,
                    'access_secret'     => $accessSecret
                );

                update_option( 'um_aweber_credentials', $aweber_credentials );
                update_option( 'um_aweber_authorization_code', $authorization_code );

                $url = add_query_arg( 'um_aweber_notice', 'valid_auth' );

                wp_redirect( $url );
                exit;
            }
        }
        catch( AWeberAPIException $exc ) {

            UM()->options()->remove( 'tbz_um_aweber_authorization_code' );

            $url = add_query_arg( 'um_aweber_notice', 'invalid_auth' );

            wp_redirect( $url );
            exit;
        }

	}

    public function admin_notices() {

        $message = '';
        $class   = 'updated';

        if ( isset( $_GET['um_aweber_notice'] ) && $_GET['um_aweber_notice'] ) {

            switch( $_GET['um_aweber_notice'] ) {

                case 'invalid_auth' :
                    $message = __( 'Invalid AWeber authorization code. Generate another AWeber authorization code and try again.', 'um-aweber' );
                    $class   = 'error';

                    break;

                case 'valid_auth' :
                    $message = __( 'Valid AWeber authorization code!', 'um-aweber' );
                    $class   = 'updated';

                    break;

            }

            echo sprintf( '<div class="%1$s"><p>%2$s</p></div>',
                esc_attr( $class ),
                $message
            );

        }
    }

}
$um_aweber_settings = new TBZ_UM_Aweber_Settings;