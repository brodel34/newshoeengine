<?php
/**
 * WooCommerce Product Retailers
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Product Retailers to newer
 * versions in the future. If you wish to customize WooCommerce Product Retailers for your
 * needs please refer to http://docs.woocommerce.com/document/woocommerce-product-retailers/ for more information.
 *
 * @package     WC-Product-Retailers/Admin
 * @author      SkyVerge
 * @copyright   Copyright (c) 2013-2018, SkyVerge, Inc.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

defined( 'ABSPATH' ) or exit;

/**
 * Retailers Admin Class - handles admin UX
 *
 * @since 1.0.0
 */
class WC_Product_Retailers_Admin {


    /**
     * Setup admin class
     *
     * @since 1.0.0
     */
    public function __construct() {

        // load styles/scripts
        add_action( 'admin_enqueue_scripts', array( $this, 'load_styles_scripts' ) );

        // load WC scripts on the edit retailers page
        add_filter( 'woocommerce_screen_ids', array( $this, 'load_wc_admin_scripts' ) );

        add_filter( 'woocommerce_product_settings', array( $this, 'add_global_settings' ) );

        // add product tab
        add_action( 'woocommerce_product_write_panel_tabs', array( $this, 'add_product_tab' ), 11 );

        // add product tab data
        add_action( 'woocommerce_product_data_panels', array( $this, 'add_product_tab_options' ), 11 );
                add_action( 'woocommerce_product_data_panels', array( $this, 'add_product_tab_options_aftermarket' ), 11 );
                add_action( 'woocommerce_product_data_panels', array( $this, 'add_product_tab_options_raffles' ), 11 );
                add_action( 'woocommerce_product_data_panels', array( $this, 'add_product_tab_options_wheretobuy' ), 11 );
                add_action( 'woocommerce_product_data_panels', array( $this, 'add_product_tab_options_all' ), 11 );

        // save product tab data
        add_action( 'woocommerce_process_product_meta_simple',                array( $this, 'save_product_tab_options' ) );
        add_action( 'woocommerce_process_product_meta_variable',              array( $this, 'save_product_tab_options' ) );
        add_action( 'woocommerce_process_product_meta_booking',               array( $this, 'save_product_tab_options' ) );
        add_action( 'woocommerce_process_product_meta_subscription',          array( $this, 'save_product_tab_options' ) );
        add_action( 'woocommerce_process_product_meta_variable-subscription', array( $this, 'save_product_tab_options' ) );

        // add AJAX retailer search
        add_action( 'wp_ajax_wc_product_retailers_search_retailers', array( $this, 'ajax_search_retailers' ) );
    }


    /**
     * Load admin js/css
     *
     * @since 1.0.0
     * @param string $hook_suffix
     */
    public function load_styles_scripts( $hook_suffix ) {
        global $post_type;

        if ( 'wc_product_retailer' === $post_type && 'edit.php' === $hook_suffix ) {
            ob_start();
            ?>
            // get rid of the date filter and also the filter button itself, unless there are other filters added
            $( 'select[name="m"]' ).remove();
            if ( ! $('#post-query-submit').siblings('select').size() ) $('#post-query-submit').remove();
            <?php
            $js = ob_get_clean();
            wc_enqueue_js( $js );
        }

        // load admin css/js only on edit product/new product pages
        if ( 'product' === $post_type && ( 'post.php' === $hook_suffix || 'post-new.php' === $hook_suffix ) ) {

            // admin CSS
            wp_enqueue_style( 'wc-product-retailers-admin', wc_product_retailers()->get_plugin_url() . '/assets/css/admin/wc-product-retailers-admin.min.css', array( 'woocommerce_admin_styles' ), WC_Product_Retailers::VERSION );

            // admin JS
            wp_enqueue_script( 'wc-product-retailers-admin', wc_product_retailers()->get_plugin_url() . '/assets/js/admin/wc-product-retailers-admin.min.js', WC_Product_Retailers::VERSION );

            wp_enqueue_script( 'jquery-ui-sortable' );

            // add script data
            $wc_product_retailers_admin_params = array(
                'search_retailers_nonce' => wp_create_nonce( 'search_retailers' ),
                'is_wc_gte_3_0' => SV_WC_Plugin_Compatibility::is_wc_version_gte_3_0(),
            );
            wp_localize_script( 'wc-product-retailers-admin', 'wc_product_retailers_admin_params', $wc_product_retailers_admin_params );
        }

        // load WC CSS on add/edit retailer page
        if ( 'wc_product_retailer' === $post_type ) {
            wp_enqueue_style( 'woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css' );
        }
    }


    /**
     * Add settings/export screen ID to the list of pages for WC to load its scripts on.
     *
     * @since 1.0.0
     * @param array $screen_ids
     * @return array
     */
    public function load_wc_admin_scripts( $screen_ids ) {

        $screen_ids[] = 'wc_product_retailer';

        return $screen_ids;
    }


    /**
     * Returns the global settings array for the plugin.
     *
     * @since 1.0.0
     * @return array the global settings
     */
    public static function get_global_settings() {

        return apply_filters( 'wc_product_retailers_settings', array(
            // section start
            array(
                'name' => __( 'Product Retailers', 'woocommerce-product-retailers' ),
                'type' => 'title',
                'desc' => '',
                'id' => 'wc_product_retailer_options',
            ),

            // product button text
            array(
                'title'    => __( 'Product Button Text', 'woocommerce-product-retailers' ),
                'desc_tip' => __( 'This text will be shown on the dropdown linking to the external product, unless overridden at the product level.', 'woocommerce-product-retailers' ),
                'id'       => 'wc_product_retailers_product_button_text',
                'css'      => 'width:200px;',
                'default'  => __( 'Purchase from Retailer', 'woocommerce-product-retailers' ),
                'type'     => 'text',
            ),

            // catalog button text
            array(
                'title'    => __( 'Catalog Button Text', 'woocommerce-product-retailers' ),
                'desc_tip' => __( 'This text will be shown on the catalog page "Add to Cart" button for simple products that are sold through retailers only, unless overridden at the product level.', 'woocommerce-product-retailers' ),
                'id'       => 'wc_product_retailers_catalog_button_text',
                'css'      => 'width:200px;',
                'default'  => __( 'View Retailers', 'woocommerce-product-retailers' ),
                'type'     => 'text',
            ),

            // open in new tab
            array(
                'title'    => __( 'Open retailer links in a new tab', 'woocommerce-product-retailers' ),
                'desc'     => __( 'Enable this option to open links to other retailers in a new tab instead of the current one.', 'woocommerce-product-retailers' ),
                'id'       => 'wc_product_retailers_enable_new_tab',
                'default'  => '',
                'type'     => 'checkbox',
            ),
                    

            // section end
            array( 'type' => 'sectionend', 'id' => 'wc_product_retailer_options' ),
        ) );
    }


    /**
     * Inject global settings into the Settings > Catalog/Products page(s),
     * immediately after the 'Product Data' section.
     *
     * @since 1.0.0
     * @param array $settings associative array of WooCommerce settings
     * @return array associative array of WooCommerce settings
     */
    public function add_global_settings( $settings ) {

        $setting_id = 'catalog_options';

        $updated_settings = array();

        foreach ( $settings as $setting ) {

            $updated_settings[] = $setting;

            if ( isset( $setting['id'] ) && $setting_id === $setting['id']
                 && isset( $setting['type'] ) && 'sectionend' === $setting['type'] ) {
                $updated_settings = array_merge( $updated_settings, self::get_global_settings() );
            }
        }

        return $updated_settings;
    }


    /**
     * Add 'Retailers' tab to product data writepanel.
     *
     * @since 1.0.0
     */
    public function add_product_tab() {

        ?>
                <li class="wc-product-retailers-tab wc-product-retailers-options hide_if_external hide_if_grouped">
            <a href="#wc-product-retailers-data-all"><span><?php esc_html_e( 'All', 'woocommerce-product-retailers' ); ?></span></a>
        </li>        
        <li class="wc-product-retailers-tab wc-product-retailers-options hide_if_external hide_if_grouped">
            <a href="#wc-product-retailers-data"><span><?php esc_html_e( 'Retailers', 'woocommerce-product-retailers' ); ?></span></a>
        </li>
                <li class="wc-product-retailers-tab wc-product-retailers-options hide_if_external hide_if_grouped">
            <a href="#wc-product-retailers-data_aftermarket"><span><?php esc_html_e( 'After-Market', 'woocommerce-product-retailers' ); ?></span></a>
        </li>
        <li class="wc-product-retailers-tab wc-product-retailers-options hide_if_external hide_if_grouped">
            <a href="#wc-product-retailers-data_raffles"><span><?php esc_html_e( 'Raffles', 'woocommerce-product-retailers' ); ?></span></a>
        </li>
                <li class="wc-product-retailers-tab wc-product-retailers-options hide_if_external hide_if_grouped">
            <a href="#wc-product-retailers-data_wheretobuy"><span><?php esc_html_e( 'Where to Buy', 'woocommerce-product-retailers' ); ?></span></a>
        </li>
                <?php
    }

public function add_product_tab_options_all() {
    ?>
    <div id="wc-product-retailers-data-all" class="panel woocommerce_options_panel">
        <div class="options_group">
        <?php $this->add_retailers_table_all(); ?>
    </div>
    </div>
                <?php
}
private function add_retailers_table_all() {
    global $post;
    ?>
    <p>Show tab on front-end</p>
    <?php $raffles_switch = get_post_meta( $post->ID, '_wc_product_retailers_raffles_switch', true ); ?>
    <input type="checkbox" name="raffles_switch" value='1' <?=($raffles_switch==1) ? 'checked="checked"' : ''?> /> On
    <?php $tablist = get_post_meta( $post->ID, '_wc_product_retailers_tablist', true ); ?>
    <p>Make a tab sticky on front-end</p>
    <select name="tablist">
    <option value="All" <?=($tablist=='All') ? 'selected="selected"' : ''?>>All</option>
    <option value="Retailers" <?=($tablist=='Retailers') ? 'selected="selected"' : ''?>>Retailers</option>
        <option value="After-Market" <?=($tablist=='After-Market') ?  'selected="selected"' : ''?>>After-Market</option>
        <option value="Raffles" <?=($tablist=='Raffles') ?  'selected="selected"': ''?>>Raffles</option>
        <option value="Where_to_Buy" <?=($tablist=='Where_to_Buy') ?  'selected="selected"' : ''?>>Where to buy</option>
    </select>
    <br />
    <?php $first_list = get_post_meta( $post->ID, '_wc_product_retailers_firstlist', true ); ?>
    <p>Show Retailers first in ALL Tab of</p>
    <select name="firstlist">
    <option value="Select" <?=($first_list=='Select') ? 'selected="selected"' : ''?>>Select</option>
    <option value="retailers" <?=($first_list=='retailers') ? 'selected="selected"' : ''?>>Retailers</option>
        <option value="aftermarket" <?=($first_list=='aftermarket') ?  'selected="selected"' : ''?>>After-Market</option>
        <option value="raffles" <?=($first_list=='raffles') ?  'selected="selected"': ''?>>Raffles</option>
        <option value="Where_to_Buy" <?=($first_list=='Where_to_Buy') ?  'selected="selected"' : ''?>>Where to buy</option>
    </select>
        <?php
                }
    /**
     * Add product retailers options to product writepanel.
     *
     * @since 1.0.0
     */
        public function add_product_tab_options() {
        global $post_id;

        ?>
            <div id="wc-product-retailers-data" class="panel woocommerce_options_panel">
                <div class="options_group">
                    <?php

                    do_action( 'wc_product_retailers_product_options_start' );

                    // retailer availability
                    woocommerce_wp_select(
                        array(
                            'id'          => '_wc_product_retailers_retailer_availability',
                            'label'       => __( 'Retailer Availability', 'woocommerce-product-retailers' ),
                            'description' => __( 'Choose when retailers are shown for the product.', 'woocommerce-product-retailers' ),
                            'class'       => 'wc-enhanced-select',
                            'options'     => array(
                                'with_store'    => __( 'Always; Use both retailers and the store add-to-cart button.', 'woocommerce-product-retailers' ),
                                'replace_store' => __( 'Always; Use retailers instead of the store add-to-cart button.', 'woocommerce-product-retailers' ),
                                'out_of_stock'  => __( 'Only when the product is out of stock.', 'woocommerce-product-retailers' ),
                            ),
                            'value'     => get_post_meta( $post_id, '_wc_product_retailers_retailer_availability', true ),
                        )
                    );

                    // show buttons
                    woocommerce_wp_checkbox(
                        array(
                            'id'          => '_wc_product_retailers_use_buttons',
                            'label'       => __( 'Use Buttons', 'woocommerce-product-retailers' ),
                            'description' => __( 'Enable this to use buttons rather than a dropdown for multiple retailers.', 'woocommerce-product-retailers' ),
                        )
                    );
                                        // show Tabs
                    woocommerce_wp_checkbox(
                        array(
                            'id'          => '_wc_product_retailers_on_switch',
                            'label'       => __( 'On', 'woocommerce-product-retailers' ),
                            'description' => __( 'check to show tabs on front-end.', 'woocommerce-product-retailers' ),
                        )
                    );

                    // product button text
                    woocommerce_wp_text_input(
                        array(
                            'id'          => '_wc_product_retailers_product_button_text',
                            'label'       => __( 'Product Button Text', 'woocommerce-product-retailers' ),
                            'description' => __( 'This text will be shown on the dropdown linking to the external product, or before the buttons if "Use Buttons" is enabled.', 'woocommerce-product-retailers' ),
                            'desc_tip'    => true,
                            'placeholder' => wc_product_retailers()->get_product_button_text(),
                        )
                    );

                    // product button text
                    woocommerce_wp_text_input(
                        array(
                            'id'          => '_wc_product_retailers_catalog_button_text',
                            'label'       => __( 'Catalog Button Text', 'woocommerce-product-retailers' ),
                            'description' => __( 'This text will be shown on the catalog page "Add to Cart" button for simple products that are sold through retailers only.', 'woocommerce-product-retailers' ),
                            'desc_tip'    => true,
                            'placeholder' => wc_product_retailers()->get_catalog_button_text(),
                        )
                    );

                    // show retailers element on product page
                    woocommerce_wp_checkbox(
                        array(
                            'id'          => '_wc_product_retailers_hide',
                            'label'       => __( 'Hide Product Retailers', 'woocommerce-product-retailers' ),
                            'description' => __( 'Enable this to hide the default product retailers buttons/dropdown on the product page.  Useful if you want to display them elsewhere using the shortcode or widget.', 'woocommerce-product-retailers' ),
                            'default'     => 'no',
                        )
                    );

                    do_action( 'wc_product_retailers_product_options_end' );
                    ?>
                </div>
                <div class="options_group">
                    <?php $this->add_retailers_table(); ?>
                </div>
            </div>
        <?php

        // hide "Catalog Button Text" if "Retailers Only Purchase" is enabled
        wc_enqueue_js( '

            var $retailer_availability_input  = $( "#_wc_product_retailers_retailer_availability" );
                $catalog_button_field         = $( "._wc_product_retailers_catalog_button_text_field" );

            $retailer_availability_input.change( function() {
                if ( "with_store" == $( this ).find( "option:selected" ).val() ) {
                    $catalog_button_field.hide();
                } else {
                    $catalog_button_field.show();
                }
            } ).change();

        ' );
    }
    


    /**
     * Add product retailers add/remove table.
     *
     * @since 1.0.0
     */
    private function add_retailers_table() {
        global $post;
        
        ?>
                <p>Show tab on front-end</p>
                
                <?php $retailer_switch = get_post_meta( $post->ID, '_wc_product_retailers_retailer_switch', true ); ?>
                <input type="checkbox" name="retailer_switch" value='1' <?=($retailer_switch==1) ? 'checked="checked"' : ''?> /> On
        <table class="widefat wc-product-retailers">
            <thead>
                <tr>
                    <td class="check-column"><input type="checkbox"></td>
                    <th class="wc-product-retailer-name"><?php esc_html_e( 'Retailer', 'woocommerce-product-retailers' ); ?></th>
                    <th class="wc-product-retailer-price"><?php esc_html_e( 'Product Price', 'woocommerce-product-retailers' ); ?></th>
                    <th class="wc-product-retailer-price"><?php esc_html_e( 'Date', 'woocommerce-product-retailers' ); ?></th>
                                        <th class="wc-product-retailer-price"><?php esc_html_e( 'Coupon', 'woocommerce-product-retailers' ); ?></th>
                                        <th class="wc-product-retailer-price"><?php esc_html_e( 'Sale Price', 'woocommerce-product-retailers' ); ?></th>
                                        <th class="wc-product-retailer-price"><?php esc_html_e( 'Color', 'woocommerce-product-retailers' ); ?></th>
                    <th class="wc-product-retailer-product-url"><?php esc_html_e( 'Product URL', 'woocommerce-product-retailers' ); ?></th>
                                       
                </tr>
            </thead>
            <tbody>
                <?php
                $retailers = get_post_meta( $post->ID, '_wc_product_retailers_ret', true ); 
                $index     = 0;

                if ( ! empty( $retailers) ) :

                    foreach ( $retailers as $retailer ) :

                        try {
                            // build the retailer object and override the URL as needed
                            $_retailer = new WC_Product_Retailers_Retailer( $retailer['id'] );

                            // product URL for retailer
                            if ( ! empty( $retailer['product_url'] ) ) {
                                $_retailer->set_url( $retailer['product_url'] );
                            }

                            if ( ! empty( $retailer['product_img'] ) ) {
                                $_retailer->set_img( $retailer['product_img'] );
                            }

                            // product price for retailer
                            if ( isset( $retailer['product_price'] ) ) {
                                $_retailer->set_price( $retailer['product_price'] );
                            }
                            
                            if ( isset( $retailer['retailer_date'] ) ) {
                                $_retailer->set_retailer_date( $retailer['retailer_date'] );
                            }
                                                        
                                                        if ( isset( $retailer['retailer_coupon'] ) ) {
                                $_retailer->set_retailer_coupon( $retailer['retailer_coupon'] );
                            }
                                                        
                                                        if ( isset( $retailer['retailer_saleprice'] ) ) {
                                $_retailer->set_retailer_saleprice( $retailer['retailer_saleprice'] );
                            }
                                                        
                                                        if ( isset( $retailer['retailer_color'] ) ) {
                                $_retailer->set_retailer_color( $retailer['retailer_color'] );
                            }

                            // if the retailer is not available (trashed) exclude it
                            if ( ! $_retailer->is_available( true ) ) {
                                continue;
                            }

                            ?>
                            <tr class="wc-product-retailer">
                                <td class="check-column">
                                    <input type="checkbox" name="select" />
                                    <input type="hidden" name="_wc_product_retailer_id_ret[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_id() ); ?>" />
                                </td>
                                <td class="wc-product-retailer_name"><?php echo esc_html( $_retailer->get_name() ); ?></td>
                                <td class="wc-product-retailer-product-price">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-price-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_price_ret[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_price() ); ?>" />
                                </td>
                                <td class="wc-product-retailer-product-date">
                                    <input type="datetime-local" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-date-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_date_ret[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_retailer_date() ); ?>" />
                                </td>
                                                                <td class="wc-product-retailer-product-coupon">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-coupon-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_coupon_ret[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_retailer_coupon() ); ?>" />
                                </td>
                                                                <td class="wc-product-retailer-product-saleprice">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-saleprice-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_saleprice_ret[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_retailer_saleprice() ); ?>" />
                                </td>
                                                                <td class="wc-product-retailer-product-color">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-color-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_color_ret[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_retailer_color() ); ?>" />
                                </td>
                                <td class="wc-product-retailer-product-url">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-product-url-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_url_ret[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_url() ); ?>" />
                                </td>                     
                                                        </tr>
                            <?php
                            $index++;
                        } catch ( Exception $e ) { /* retailer does not exist */ }
                    endforeach;
                endif;
                ?>
            </tbody>
            <tfoot>
            <tr>
                <td>
                    <?php echo wc_help_tip( __( 'Search for a retailer to add to this product. You may add multiple retailers by searching for them first.', 'woocommerce-product-retailers' ) ); ?>
                </td>
                <td colspan="3">
                    <?php $placeholder = sprintf( esc_attr__( 'Search for a retailer to add%s', 'woocommerce-product-retailers' ), '&hellip;' ); ?>
                    <?php if ( SV_WC_Plugin_Compatibility::is_wc_version_gte_3_0() ) : ?>
                    <select class="wc-retailers-search" multiple="multiple" style="width: 50%" name="wc_product_retailers_retailer_search[]" data-placeholder="<?php echo $placeholder; ?>">
                        <option></option>
                    </select>
                                    <input type="hidden" id="tab-product-retailers-retailer-search" class="tab-retailers-search" name="tab_product_retailers_retailer_search" style="width:50%;"
                        data-placeholder="<?php echo $placeholder; ?>" value="ret"
                                               /> 
                    <?php else: ?>
                    <input type="hidden" id="wc-product-retailers-retailer-search" class="tab-retailers-search" name="wc_product_retailers_retailer_search" style="width:50%;"
                        data-placeholder="<?php echo $placeholder; ?>"
                        />
                    <?php endif; ?>
                    <button type="button" class="button button-primary wc-product-retailers-add-retailer"><?php esc_html_e( 'Add Retailer', 'woocommerce-product-retailers' ); ?></button>
                    <button type="button" class="button button-secondary wc-product-retailers-delete-retailer"><?php esc_html_e( 'Delete Selected', 'woocommerce-product-retailers' ); ?></button>
                </td>
            </tr>
            </tfoot>
        </table>
        <?php
    }
        //For after market
        public function add_product_tab_options_aftermarket() {
        global $post_id;

        ?>
            <div id="wc-product-retailers-data_aftermarket" class="panel woocommerce_options_panel">
                <div class="options_group">
                    <?php $this->add_retailers_table_aftermarket(); ?>
                </div>
            </div>
        <?php
    }
        private function add_retailers_table_aftermarket() {
        global $post;
        ?>
                <p>Show tab on front-end</p>
                <?php $aftermarket_switch = get_post_meta( $post->ID, '_wc_product_retailers_aftermarket_switch', true ); ?>
                <input type="checkbox" name="aftermarket_switch" value='1' <?=($aftermarket_switch==1) ? 'checked="checked"' : ''?> /> On

                
                
                <table class="widefat wc-product-retailers_aftermarket">
            <thead>
            <tr>
                    <td class="check-column"><input type="checkbox"></td>
                    <th class="wc-product-retailer-name"><?php esc_html_e( 'Retailer', 'woocommerce-product-retailers' ); ?></th>
                    <th class="wc-product-retailer-price"><?php esc_html_e( 'Product Price', 'woocommerce-product-retailers' ); ?></th>
                    <th class="wc-product-retailer-price"><?php esc_html_e( 'Date', 'woocommerce-product-retailers' ); ?></th>
                                        <th class="wc-product-retailer-price"><?php esc_html_e( 'Coupon', 'woocommerce-product-retailers' ); ?></th>
                                        <th class="wc-product-retailer-price"><?php esc_html_e( 'Sale Price', 'woocommerce-product-retailers' ); ?></th>
                                        <th class="wc-product-retailer-price"><?php esc_html_e( 'Color', 'woocommerce-product-retailers' ); ?></th>
                    <th class="wc-product-retailer-product-url"><?php esc_html_e( 'Product URL', 'woocommerce-product-retailers' ); ?></th>
                                       
                </tr>
            </thead>
            <tbody>
                <?php
                $retailers = get_post_meta( $post->ID, '_wc_product_retailers_aftermarket', true );
                $index     = 0;

                if ( ! empty( $retailers) ) :

                    foreach ( $retailers as $retailer ) :

                        try {
                            // build the retailer object and override the URL as needed
                            $_retailer = new WC_Product_Retailers_Retailer( $retailer['id'] );
                                                       
                            // product URL for retailer
                            if ( ! empty( $retailer['product_url'] ) ) {
                                $_retailer->set_url( $retailer['product_url'] );
                            }

                            if ( ! empty( $retailer['product_img'] ) ) {
                                $_retailer->set_img( $retailer['product_img'] );
                            }

                            // product price for retailer
                            if ( isset( $retailer['product_price'] ) ) {
                                $_retailer->set_price( $retailer['product_price'] );
                            }
                            
                            if ( isset( $retailer['retailer_date'] ) ) {
                                $_retailer->set_retailer_date( $retailer['retailer_date'] );
                            }
                                                        
                                                        if ( isset( $retailer['retailer_coupon'] ) ) {
                                $_retailer->set_retailer_coupon( $retailer['retailer_coupon'] );
                            }
                                                        
                                                        if ( isset( $retailer['retailer_saleprice'] ) ) {
                                $_retailer->set_retailer_saleprice( $retailer['retailer_saleprice'] );
                            }
                                                        
                                                        if ( isset( $retailer['retailer_color'] ) ) {
                                $_retailer->set_retailer_color( $retailer['retailer_color'] );
                            }

                            // if the retailer is not available (trashed) exclude it
                            if ( ! $_retailer->is_available( true ) ) {
                                continue;
                            }


                            ?>
                            <tr class="wc-product-retailer_aftermarket">
                                <td class="check-column">
                                    <input type="checkbox" name="select" />
                                    <input type="hidden" name="_wc_product_retailer_id_aftermarket[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_id() ); ?>" />
                                </td>
                                <td class="wc-product-retailer_name"><?php echo esc_html( $_retailer->get_name() ); ?></td>
                                <td class="wc-product-retailer-product-price">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-price-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_price_aftermarket[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_price() ); ?>" />
                                </td>
                                <td class="wc-product-retailer-product-date">
                                    <input type="datetime-local" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-date-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_date_aftermarket[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_retailer_date() ); ?>" />
                                </td>
                                                                <td class="wc-product-retailer-product-coupon">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-coupon-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_coupon_aftermarket[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_retailer_coupon() ); ?>" />
                                </td>
                                                                <td class="wc-product-retailer-product-saleprice">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-saleprice-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_saleprice_aftermarket[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_retailer_saleprice() ); ?>" />
                                </td>
                                                                <td class="wc-product-retailer-product-color">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-color-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_color_aftermarket[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_retailer_color() ); ?>" />
                                </td>
                                <td class="wc-product-retailer-product-url">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-product-url-aftermarket<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_url_aftermarket[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_url() ); ?>" />
                                </td>                     
                                                        </tr>
                            <?php
                            $index++;
                        } catch ( Exception $e ) { /* retailer does not exist */ }
                    endforeach;
                endif;
                ?>
            </tbody>
            <tfoot>
            <tr>
                <td>
                    <?php echo wc_help_tip( __( 'Search for a retailer to add to this product. You may add multiple retailers by searching for them first.', 'woocommerce-product-retailers' ) ); ?>
                </td>
                <td colspan="3">
                    <?php $placeholder = sprintf( esc_attr__( 'Search for a retailer to add%s', 'woocommerce-product-retailers' ), '&hellip;' ); ?>
                    <?php if ( SV_WC_Plugin_Compatibility::is_wc_version_gte_3_0() ) : ?>
                    <select class="wc-retailers-search_aftermarket" multiple="multiple" style="width: 50%" name="wc_product_retailers_retailer_search[]" data-placeholder="<?php echo $placeholder; ?>">
                        <option></option>
                    </select>
                                    <input type="hidden" id="tab-product-retailers-retailer-search" class="tab-retailers-search-aftermarket" name="tab_product_retailers_retailer_search" style="width:50%;"
                        data-placeholder="<?php echo $placeholder; ?>" value="aftermarket"
                                               /> 
                    <?php else: ?>
                    <input type="hidden" id="wc-product-retailers-retailer-search" class="tab-retailers-search-aftermarket" name="wc_product_retailers_retailer_search" style="width:50%;"
                        data-placeholder="<?php echo $placeholder; ?>"
                                        />
                                        <input type="hidden" id="tab-product-retailers-retailer-search" class="tab-retailers-search" name="tab_product_retailers_retailer_search" style="width:50%;"
                        data-placeholder="<?php echo $placeholder; ?>"
                                               /> 
                    <?php endif; ?>
                    <button type="button" class="button button-primary wc-product-retailers-add-retailer-aftermarket"><?php esc_html_e( 'Add Retailer', 'woocommerce-product-retailers' ); ?></button>
                    <button type="button" class="button button-secondary wc-product-retailers-delete-retailer-aftermarket"><?php esc_html_e( 'Delete Selected', 'woocommerce-product-retailers' ); ?></button>
                </td>
            </tr>
            </tfoot>
        </table>
        <?php
    }
    // Raffles
    public function add_product_tab_options_raffles() {
        global $post_id;

        ?>
            <div id="wc-product-retailers-data_raffles" class="panel woocommerce_options_panel">
                
                <div class="options_group">
                    <?php $this->add_retailers_table_raffles(); ?>
                </div>
            </div>
        <?php

        
    }
    private function add_retailers_table_raffles() {
        global $post;
        ?>
                <p>Show tab on front-end</p>
                
                <?php $raffles_switch_tab = get_post_meta( $post->ID, '_wc_product_retailers_raffles_switch_tab', true ); ?>
                <input type="checkbox" name="raffles_switch_tab" value='1' <?=($raffles_switch_tab==1) ? 'checked="checked"' : ''?> /> On

        <table class="widefat wc-product-retailers_raffles">
            <thead>
            <tr>
                    <td class="check-column"><input type="checkbox"></td>
                    <th class="wc-product-retailer-name"><?php esc_html_e( 'Retailerr', 'woocommerce-product-retailers' ); ?></th>
                    <th class="wc-product-retailer-price"><?php esc_html_e( 'Product Price', 'woocommerce-product-retailers' ); ?></th>
                    <th class="wc-product-retailer-price"><?php esc_html_e( 'Date', 'woocommerce-product-retailers' ); ?></th>
                                        <th class="wc-product-retailer-price"><?php esc_html_e( 'Coupon', 'woocommerce-product-retailers' ); ?></th>
                                        <th class="wc-product-retailer-price"><?php esc_html_e( 'Sale Price', 'woocommerce-product-retailers' ); ?></th>
                                        <th class="wc-product-retailer-price"><?php esc_html_e( 'Color', 'woocommerce-product-retailers' ); ?></th>
                    <th class="wc-product-retailer-product-url"><?php esc_html_e( 'Product URL', 'woocommerce-product-retailers' ); ?></th>
                                       
                </tr>
            </thead>
            <tbody>
                <?php
                $retailers = get_post_meta( $post->ID, '_wc_product_retailers_raffles', true );
                $index     = 0;

                if ( ! empty( $retailers) ) :

                    foreach ( $retailers as $retailer ) :

                        try {
                            // build the retailer object and override the URL as needed
                            $_retailer = new WC_Product_Retailers_Retailer( $retailer['id'] );
                                                       
                            // product URL for retailer
                            if ( ! empty( $retailer['product_url'] ) ) {
                                $_retailer->set_url( $retailer['product_url'] );
                            }

                            if ( ! empty( $retailer['product_img'] ) ) {
                                $_retailer->set_img( $retailer['product_img'] );
                            }

                            // product price for retailer
                            if ( isset( $retailer['product_price'] ) ) {
                                $_retailer->set_price( $retailer['product_price'] );
                            }
                            
                            if ( isset( $retailer['retailer_date'] ) ) {
                                $_retailer->set_retailer_date( $retailer['retailer_date'] );
                            }
                                                        
                                                        if ( isset( $retailer['retailer_coupon'] ) ) {
                                $_retailer->set_retailer_coupon( $retailer['retailer_coupon'] );
                            }
                                                        
                                                        if ( isset( $retailer['retailer_saleprice'] ) ) {
                                $_retailer->set_retailer_saleprice( $retailer['retailer_saleprice'] );
                            }
                                                        
                                                        if ( isset( $retailer['retailer_color'] ) ) {
                                $_retailer->set_retailer_color( $retailer['retailer_color'] );
                            }

                            // if the retailer is not available (trashed) exclude it
                            if ( ! $_retailer->is_available( true ) ) {
                                continue;
                            }


                            ?>
                            <tr class="wc-product-retailer_raffles">
                                <td class="check-column">
                                    <input type="checkbox" name="select" />
                                    <input type="hidden" name="_wc_product_retailer_id_raffles[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_id() ); ?>" />
                                </td>
                                <td class="wc-product-retailer_name"><?php echo esc_html( $_retailer->get_name() ); ?></td>
                                <td class="wc-product-retailer-product-price">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-price-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_price_raffles[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_price() ); ?>" />
                                </td>
                                <td class="wc-product-retailer-product-date">
                                    <input type="datetime-local" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-date-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_date_raffles[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_retailer_date() ); ?>" />
                                </td>
                                                                <td class="wc-product-retailer-product-coupon">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-coupon-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_coupon_raffles[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_retailer_coupon() ); ?>" />
                                </td>
                                                                <td class="wc-product-retailer-product-saleprice">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-saleprice-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_saleprice_raffles[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_retailer_saleprice() ); ?>" />
                                </td>
                                                                <td class="wc-product-retailer-product-color">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-color-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_color_raffles[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_retailer_color() ); ?>" />
                                </td>
                                <td class="wc-product-retailer-product-url">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-product-url-raffles<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_url_raffles[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_url() ); ?>" />
                                </td>                     
                                                        </tr>
                            <?php
                            $index++;
                        } catch ( Exception $e ) { /* retailer does not exist */ }
                    endforeach;
                endif;
                ?>
            </tbody>
            <tfoot>
            <tr>
                <td>
                    <?php echo wc_help_tip( __( 'Search for a retailer to add to this product. You may add multiple retailers by searching for them first.', 'woocommerce-product-retailers' ) ); ?>
                </td>
                <td colspan="3">
                    <?php $placeholder = sprintf( esc_attr__( 'Search for a retailer to add%s', 'woocommerce-product-retailers' ), '&hellip;' ); ?>
                    <?php if ( SV_WC_Plugin_Compatibility::is_wc_version_gte_3_0() ) : ?>
                    <select class="wc-retailers-search_raffles" multiple="multiple" style="width: 50%" name="wc_product_retailers_retailer_search[]" data-placeholder="<?php echo $placeholder; ?>">
                        <option></option>
                    </select>
                                    <input type="hidden" id="tab-product-retailers-retailer-search" class="tab-retailers-search-raffles" name="tab_product_retailers_retailer_search" style="width:50%;"
                        data-placeholder="<?php echo $placeholder; ?>" value="raffles"
                                               /> 
                    <?php else: ?>
                    <input type="hidden" id="wc-product-retailers-retailer-search" class="tab-retailers-search-raffles" name="wc_product_retailers_retailer_search" style="width:50%;"
                        data-placeholder="<?php echo $placeholder; ?>"
                                        />
                                        <input type="hidden" id="tab-product-retailers-retailer-search" class="tab-retailers-search" name="tab_product_retailers_retailer_search" style="width:50%;"
                        data-placeholder="<?php echo $placeholder; ?>"
                                               /> 
                    <?php endif; ?>
                    <button type="button" class="button button-primary wc-product-retailers-add-retailer-raffles"><?php esc_html_e( 'Add Retailer', 'woocommerce-product-retailers' ); ?></button>
                    <button type="button" class="button button-secondary wc-product-retailers-delete-retailer-raffles"><?php esc_html_e( 'Delete Selected', 'woocommerce-product-retailers' ); ?></button>
                </td>
            </tr>
            </tfoot>
        </table>
        <?php
    }
    // WHere to buy
    public function add_product_tab_options_wheretobuy() {
        global $post_id;

        ?>
            <div id="wc-product-retailers-data_wheretobuy" class="panel woocommerce_options_panel">
                
                <div class="options_group">
                    <?php $this->add_retailers_table_wheretobuy(); ?>
                </div>
            </div>
        <?php

        
    }
    private function add_retailers_table_wheretobuy() {
        global $post;
        ?>
                <p>Show tab on front-end</p>
             
                <?php $wheretobuy_switch = get_post_meta( $post->ID, '_wc_product_retailers_wheretobuy_switch', true ); ?>
                <input type="checkbox" name="wheretobuy_switch" value='1' <?=($wheretobuy_switch==1) ? 'checked="checked"' : ''?> /> On

        <table class="widefat wc-product-retailers_wheretobuy">
            <thead>
            <tr>
                    <td class="check-column"><input type="checkbox"></td>
                    <th class="wc-product-retailer-name"><?php esc_html_e( 'Retailer', 'woocommerce-product-retailers' ); ?></th>
                    <th class="wc-product-retailer-price"><?php esc_html_e( 'Product Price', 'woocommerce-product-retailers' ); ?></th>
                    <th class="wc-product-retailer-price"><?php esc_html_e( 'Date', 'woocommerce-product-retailers' ); ?></th>
                                        <th class="wc-product-retailer-price"><?php esc_html_e( 'Coupon', 'woocommerce-product-retailers' ); ?></th>
                                        <th class="wc-product-retailer-price"><?php esc_html_e( 'Sale Price', 'woocommerce-product-retailers' ); ?></th>
                                        <th class="wc-product-retailer-price"><?php esc_html_e( 'Color', 'woocommerce-product-retailers' ); ?></th>
                    <th class="wc-product-retailer-product-url"><?php esc_html_e( 'Product URL', 'woocommerce-product-retailers' ); ?></th>
                                       
                </tr>
            </thead>
            <tbody>
                <?php
                $retailers = get_post_meta( $post->ID, '_wc_product_retailers_wheretobuy', true );
                $index     = 0;

                if ( ! empty( $retailers) ) :

                    foreach ( $retailers as $retailer ) :

                        try {
                            // build the retailer object and override the URL as needed
                            $_retailer = new WC_Product_Retailers_Retailer( $retailer['id'] );
                                                       
                            // product URL for retailer
                            if ( ! empty( $retailer['product_url'] ) ) {
                                $_retailer->set_url( $retailer['product_url'] );
                            }

                            if ( ! empty( $retailer['product_img'] ) ) {
                                $_retailer->set_img( $retailer['product_img'] );
                            }

                            // product price for retailer
                            if ( isset( $retailer['product_price'] ) ) {
                                $_retailer->set_price( $retailer['product_price'] );
                            }
                            
                            if ( isset( $retailer['retailer_date'] ) ) {
                                $_retailer->set_retailer_date( $retailer['retailer_date'] );
                            }
                                                        
                                                        if ( isset( $retailer['retailer_coupon'] ) ) {
                                $_retailer->set_retailer_coupon( $retailer['retailer_coupon'] );
                            }
                                                        
                                                        if ( isset( $retailer['retailer_saleprice'] ) ) {
                                $_retailer->set_retailer_saleprice( $retailer['retailer_saleprice'] );
                            }
                                                        
                                                        if ( isset( $retailer['retailer_color'] ) ) {
                                $_retailer->set_retailer_color( $retailer['retailer_color'] );
                            }

                            // if the retailer is not available (trashed) exclude it
                            if ( ! $_retailer->is_available( true ) ) {
                                continue;
                            }


                            ?>
                            <tr class="wc-product-retailer_wheretobuy">
                                <td class="check-column">
                                    <input type="checkbox" name="select" />
                                    <input type="hidden" name="_wc_product_retailer_id_wheretobuy[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_id() ); ?>" />
                                </td>
                                <td class="wc-product-retailer_name"><?php echo esc_html( $_retailer->get_name() ); ?></td>
                                <td class="wc-product-retailer-product-price">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-price-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_price_wheretobuy[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_price() ); ?>" />
                                </td>
                                <td class="wc-product-retailer-product-date">
                                    <input type="datetime-local" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-date-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_date_wheretobuy[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_retailer_date() ); ?>" />
                                </td>
                                                                <td class="wc-product-retailer-product-coupon">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-coupon-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_coupon_wheretobuy[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_retailer_coupon() ); ?>" />
                                </td>
                                                                <td class="wc-product-retailer-product-saleprice">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-saleprice-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_saleprice_wheretobuy[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_retailer_saleprice() ); ?>" />
                                </td>
                                                                <td class="wc-product-retailer-product-color">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-color-<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_color_wheretobuy[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_retailer_color() ); ?>" />
                                </td>
                                <td class="wc-product-retailer-product-url">
                                    <input type="text" data-post-id="<?php echo esc_attr( $_retailer->get_id() ); ?>" id="wc-product-retailer-product-url-wheretobuy<?php echo esc_attr( $_retailer->get_id() ); ?>" name="_wc_product_retailer_product_url_wheretobuy[<?php echo $index; ?>]" value="<?php echo esc_attr( $_retailer->get_url() ); ?>" />
                                </td>                     
                                                        </tr>
                            <?php
                            $index++;
                        } catch ( Exception $e ) { /* retailer does not exist */ }
                    endforeach;
                endif;
                ?>
            </tbody>
            <tfoot>
            <tr>
                <td>
                    <?php echo wc_help_tip( __( 'Search for a retailer to add to this product. You may add multiple retailers by searching for them first.', 'woocommerce-product-retailers' ) ); ?>
                </td>
                <td colspan="3">
                    <?php $placeholder = sprintf( esc_attr__( 'Search for a retailer to add%s', 'woocommerce-product-retailers' ), '&hellip;' ); ?>
                    <?php if ( SV_WC_Plugin_Compatibility::is_wc_version_gte_3_0() ) : ?>
                    <select class="wc-retailers-search_wheretobuy" multiple="multiple" style="width: 50%" name="wc_product_retailers_retailer_search[]" data-placeholder="<?php echo $placeholder; ?>">
                        <option></option>
                    </select>
                                    <input type="hidden" id="tab-product-retailers-retailer-search" class="tab-retailers-search-wheretobuy" name="tab_product_retailers_retailer_search" style="width:50%;"
                        data-placeholder="<?php echo $placeholder; ?>" value="wheretobuy"
                                               /> 
                    <?php else: ?>
                    <input type="hidden" id="wc-product-retailers-retailer-search" class="tab-retailers-search-wheretobuy" name="wc_product_retailers_retailer_search" style="width:50%;"
                        data-placeholder="<?php echo $placeholder; ?>"
                                        />
                                        <input type="hidden" id="tab-product-retailers-retailer-search" class="tab-retailers-search" name="tab_product_retailers_retailer_search" style="width:50%;"
                        data-placeholder="<?php echo $placeholder; ?>"
                                               /> 
                    <?php endif; ?>
                    <button type="button" class="button button-primary wc-product-retailers-add-retailer-wheretobuy"><?php esc_html_e( 'Add Retailer', 'woocommerce-product-retailers' ); ?></button>
                    <button type="button" class="button button-secondary wc-product-retailers-delete-retailer-wheretobuy"><?php esc_html_e( 'Delete Selected', 'woocommerce-product-retailers' ); ?></button>
                </td>
            </tr>
            </tfoot>
        </table>
        <?php
    }
    /**
     * Save product retailers options at the product level.
     *
     * @since 1.0.0
     * @param int $post_id the ID of the product being saved
     */
    public function save_product_tab_options( $post_id ) {

        // retailer availability
        if ( isset( $_POST['_wc_product_retailers_retailer_availability'] ) ) {
            update_post_meta( $post_id, '_wc_product_retailers_retailer_availability', $_POST['_wc_product_retailers_retailer_availability'] );
        }

        // use buttons rather than a dropdown?
        update_post_meta(
            $post_id,
            '_wc_product_retailers_use_buttons',
            isset( $_POST['_wc_product_retailers_use_buttons'] ) && 'yes' === $_POST['_wc_product_retailers_use_buttons'] ? 'yes' : 'no'
        );
                // use buttons rather than a dropdown?
        update_post_meta(
            $post_id,
            '_wc_product_retailers_on_switch',
            isset( $_POST['_wc_product_retailers_on_switch'] ) && 'yes' === $_POST['_wc_product_retailers_on_switch'] ? 'yes' : 'no'
        );

        // product button text
        if ( isset( $_POST['_wc_product_retailers_product_button_text'] ) ) {
            update_post_meta( $post_id, '_wc_product_retailers_product_button_text', $_POST['_wc_product_retailers_product_button_text'] );
        }

        // catalog button text
        if ( isset( $_POST['_wc_product_retailers_catalog_button_text'] ) ) {
            update_post_meta( $post_id, '_wc_product_retailers_catalog_button_text', $_POST['_wc_product_retailers_catalog_button_text'] );
        }

        // whether to hide the product retailers
        update_post_meta(
            $post_id,
            '_wc_product_retailers_hide',
            isset( $_POST['_wc_product_retailers_hide'] ) && 'yes' === $_POST['_wc_product_retailers_hide'] ? 'yes' : 'no'
        );

        $retailers = array();

        // persist any retailers assigned to this product Retailers
        if ( ! empty( $_POST['_wc_product_retailer_product_url_ret'] ) && is_array( $_POST['_wc_product_retailer_product_url_ret'] ) ) {

            foreach ( $_POST['_wc_product_retailer_product_url_ret'] as $index => $retailer_product_url_ret ) {

                $retailer_id = $_POST['_wc_product_retailer_id_ret'][ $index ];

                $retailer_price = $_POST['_wc_product_retailer_product_price_ret'][ $index ];
                $retailer_date = $_POST['_wc_product_retailer_product_date_ret'][ $index ];
                                $retailer_coupon = $_POST['_wc_product_retailer_product_coupon_ret'][ $index ];
                                $retailer_saleprice = $_POST['_wc_product_retailer_product_saleprice_ret'][ $index ];
                                $retailer_color = $_POST['_wc_product_retailer_product_color_ret'][ $index ];

                // only save the product URL if it's unique to the product
                $retailers_ret[] = array(
                    'id'            => $retailer_id,
                    'product_price' => $retailer_price,
                    'retailer_date' => $retailer_date,
                                        'retailer_coupon' => $retailer_coupon,
                                        'retailer_saleprice' => $retailer_saleprice,
                    'retailer_color' => $retailer_color,
                                        'product_url'   => $retailer_product_url_ret !== get_post_meta( $retailer_id, '_product_retailer_default_url_ret', true ) ? esc_url_raw( $retailer_product_url_ret ) : ''
                );
            }
        }
                
                // persist any retailers assigned to this product Retailers -- After Market
        // persist any retailers assigned to this product
        if ( ! empty( $_POST['_wc_product_retailer_product_url_aftermarket'] ) && is_array( $_POST['_wc_product_retailer_product_url_aftermarket'] ) ) {
                    

            foreach ( $_POST['_wc_product_retailer_product_url_aftermarket'] as $index => $retailer_product_url_aftermarket ) {
                                
                $retailer_id = $_POST['_wc_product_retailer_id_aftermarket'][ $index ];

                $retailer_price = $_POST['_wc_product_retailer_product_price_aftermarket'][ $index ];
                $retailer_date = $_POST['_wc_product_retailer_product_date_aftermarket'][ $index ];
                                //$retailer_url = $_POST['_wc_product_retailer_product_url_aftermarket'][ $index ];
                                $retailer_coupon = $_POST['_wc_product_retailer_product_coupon_aftermarket'][ $index ];
                                $retailer_saleprice = $_POST['_wc_product_retailer_product_saleprice_aftermarket'][ $index ];
                                $retailer_color = $_POST['_wc_product_retailer_product_color_aftermarket'][ $index ];

                // only save the product URL if it's unique to the product
                $retailers_aftermarket[] = array(
                    'id'            => $retailer_id,
                    'product_price' => $retailer_price,
                    'retailer_date' => $retailer_date,
                                        'retailer_coupon' => $retailer_coupon,
                                        'retailer_saleprice' => $retailer_saleprice,
                                        'retailer_color' => $retailer_color,
                    'product_url'   => $retailer_product_url_aftermarket !== get_post_meta( $retailer_id, '_product_retailer_default_url_aftermarket', true ) ? esc_url_raw( $retailer_product_url_aftermarket ) : ''
                );
            }
        }
         // persist any retailers assigned to this product Retailers -- Raffles
        // persist any retailers assigned to this product
        if ( ! empty( $_POST['_wc_product_retailer_product_url_raffles'] ) && is_array( $_POST['_wc_product_retailer_product_url_raffles'] ) ) {
                    

            foreach ( $_POST['_wc_product_retailer_product_url_raffles'] as $index => $retailer_product_url_raffles ) {
                                
                $retailer_id = $_POST['_wc_product_retailer_id_raffles'][ $index ];

                $retailer_price = $_POST['_wc_product_retailer_product_price_raffles'][ $index ];
                $retailer_date = $_POST['_wc_product_retailer_product_date_raffles'][ $index ];
                                //$retailer_url = $_POST['_wc_product_retailer_product_url_raffles'][ $index ];
                                $retailer_coupon = $_POST['_wc_product_retailer_product_coupon_raffles'][ $index ];
                                $retailer_saleprice = $_POST['_wc_product_retailer_product_saleprice_raffles'][ $index ];
                                $retailer_color = $_POST['_wc_product_retailer_product_color_raffles'][ $index ];

                // only save the product URL if it's unique to the product
                $retailers_raffles[] = array(
                    'id'            => $retailer_id,
                    'product_price' => $retailer_price,
                    'retailer_date' => $retailer_date,
                                        'retailer_coupon' => $retailer_coupon,
                                        'retailer_saleprice' => $retailer_saleprice,
                                        'retailer_color' => $retailer_color,
                    'product_url'   => $retailer_product_url_raffles !== get_post_meta( $retailer_id, '_product_retailer_default_url_raffles', true ) ? esc_url_raw( $retailer_product_url_raffles ) : ''
                );
            }
        }
        // persist any retailers assigned to this product Retailers -- Where to Buy
        // persist any retailers assigned to this product
        if ( ! empty( $_POST['_wc_product_retailer_product_url_wheretobuy'] ) && is_array( $_POST['_wc_product_retailer_product_url_wheretobuy'] ) ) {
                    

            foreach ( $_POST['_wc_product_retailer_product_url_wheretobuy'] as $index => $retailer_product_url_wheretobuy ) {
                                
                $retailer_id = $_POST['_wc_product_retailer_id_wheretobuy'][ $index ];

                $retailer_price = $_POST['_wc_product_retailer_product_price_wheretobuy'][ $index ];
                $retailer_date = $_POST['_wc_product_retailer_product_date_wheretobuy'][ $index ];
                                //$retailer_url = $_POST['_wc_product_retailer_product_url_wheretobuy'][ $index ];
                                $retailer_coupon = $_POST['_wc_product_retailer_product_coupon_wheretobuy'][ $index ];
                                $retailer_saleprice = $_POST['_wc_product_retailer_product_saleprice_wheretobuy'][ $index ];
                                $retailer_color = $_POST['_wc_product_retailer_product_color_wheretobuy'][ $index ];

                // only save the product URL if it's unique to the product
                $retailers_wheretobuy[] = array(
                    'id'            => $retailer_id,
                    'product_price' => $retailer_price,
                    'retailer_date' => $retailer_date,
                                        'retailer_coupon' => $retailer_coupon,
                                        'retailer_saleprice' => $retailer_saleprice,
                                        'retailer_color' => $retailer_color,
                    'product_url'   => $retailer_product_url_wheretobuy !== get_post_meta( $retailer_id, '_product_retailer_default_url_wheretobuy', true ) ? esc_url_raw( $retailer_product_url_wheretobuy ) : ''
                );
            }
        }
        update_post_meta( $post_id, '_wc_product_retailers_ret', $retailers_ret );
                update_post_meta( $post_id, '_wc_product_retailers_aftermarket', $retailers_aftermarket );
                update_post_meta( $post_id, '_wc_product_retailers_raffles', $retailers_raffles );
                update_post_meta( $post_id, '_wc_product_retailers_wheretobuy', $retailers_wheretobuy );

                update_post_meta( $post_id, '_wc_product_retailers_raffles_switch',  $_POST['raffles_switch'] );
                update_post_meta( $post_id, '_wc_product_retailers_retailer_switch',  $_POST['retailer_switch'] );
                update_post_meta( $post_id, '_wc_product_retailers_aftermarket_switch',  $_POST['aftermarket_switch'] );
                update_post_meta( $post_id, '_wc_product_retailers_raffles_switch_tab',  $_POST['raffles_switch_tab'] );
                update_post_meta( $post_id, '_wc_product_retailers_wheretobuy_switch',  $_POST['wheretobuy_switch'] );
                update_post_meta( $post_id, '_wc_product_retailers_tablist',  $_POST['tablist'] );
                update_post_meta( $post_id, '_wc_product_retailers_firstlist',  $_POST['firstlist'] ); 
    }

    /**
     * Processes the AJAX retailer search on the edit product page.
     *
     * @since 1.0.0
     */
    public function ajax_search_retailers() {

        // security check
        check_ajax_referer( 'search_retailers', 'security' );

        // get search term
        $term = (string) urldecode( stripslashes( strip_tags( $_GET['term'] ) ) );
                $tab = (string) urldecode( stripslashes( strip_tags( $_GET['tab'] ) ) );
        if ( empty( $term ) ) {
        }

        $args = array(
            'post_type'    => 'wc_product_retailer',
            'post_status'  => 'publish',
            'nopaging'     => true,
        );

        if ( is_numeric( $term ) ) {

            //search by retailer ID
            $args['p'] = $term;

        } else {

            // search by retailer name
            $args['s'] = $term;

        }

        $posts = get_posts( $args );

        $retailers = array();

        // build the set of found retailers
        if ( ! empty( $posts ) ) {

            foreach ( $posts as $post ) {

                $retailers[] = array(
                    'id'          => $post->ID,
                    'name'        => $post->post_title,
                                        'tab'        => $tab,
                    'product_url' => get_post_meta( $post->ID, '_product_retailer_default_url', true ),
                                        'product_img' => get_post_meta( $post->ID, '_product_retailer_default_img', true )
                                        
                );
            }
        }

        wp_send_json( $retailers );
    }


}
