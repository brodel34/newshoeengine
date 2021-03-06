<?php
/*
  This is the Prequelle child theme functions.php file.
  You can use this file to overwrite existing functions, filter and actions to customize the parent theme.
  https://wolfthemes.ticksy.com/article/11659/
 */
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 40); //
add_action('post_edit_form_tag', 'add_post_enctype');

function add_post_enctype() {
    echo ' enctype="multipart/form-data"';
}

/**
 * Secondary navigation hook
 *
 * Display cart icons, social icons or secondary menu depending on cuzstimizer option
 */
function aqib_output_complementary_menu($context = 'desktop') {

    $cta_content = prequelle_get_inherit_mod('menu_cta_content_type', 'none');

    /**
     * Force shop icons on woocommerce pages
     */
    $is_wc_page_child = is_page() && wp_get_post_parent_id(get_the_ID()) == prequelle_get_woocommerce_shop_page_id() && prequelle_get_woocommerce_shop_page_id();
    $is_wc = prequelle_is_woocommerce_page() || is_singular('product') || $is_wc_page_child;

    if (apply_filters('prequelle_force_display_nav_shop_icons', $is_wc)) { // can be disable just in case
        $cta_content = 'shop_icons';
    }

    /**
     * If shop icons are set on discography page, apply on all release pages
     */
    $is_disco_page_child = is_page() && wp_get_post_parent_id(get_the_ID()) == prequelle_get_discography_page_id() && prequelle_get_discography_page_id();
    $is_disco_page = is_page(prequelle_get_discography_page_id()) || is_singular('release') || $is_disco_page_child;

    if ($is_disco_page && get_post_meta(prequelle_get_discography_page_id(), '_post_menu_cta_content_type', true)) {
        $cta_content = get_post_meta(prequelle_get_discography_page_id(), '_post_menu_cta_content_type', true);
    }

    /**
     * If shop icons are set on events page, apply on all event pages
     */
    $is_events_page_child = is_page() && wp_get_post_parent_id(get_the_ID()) == prequelle_get_events_page_id() && prequelle_get_events_page_id();
    $is_events_page = is_page(prequelle_get_events_page_id()) || is_singular('event') || $is_events_page_child;

    if ($is_events_page && get_post_meta(prequelle_get_events_page_id(), '_post_menu_cta_content_type', true)) {
        $cta_content = get_post_meta(prequelle_get_events_page_id(), '_post_menu_cta_content_type', true);
    }
    ?>


                                                    <!-- mobile new design header end -->



    <?php if ('shop_icons' === $cta_content && 'desktop' === $context) { ?>
        <?php if (prequelle_display_shop_search_menu_item()) : ?>
            <div class="search-container cta-item">
                <?php ?>
                
                  <!-- Search -->
                 
                <?php
                prequelle_search_menu_item();
                ?>
            </div><!-- .search-container -->
           
        <?php endif ?>
        <div class="feed-desktop">	
            <a href="https://duragnation.com/feed-2/"><img src="https://duragnation.com/wp-content/uploads/2018/10/news-feed-icon-png-8.png"   class="menu-link internal-link feed-padding feed-icon-cust" itemprop="url"><span class="menu-item-inner"><span class="menu-item-text-container" itemprop="name"></span></span></a>
            <!-- .cart-container -->	
        </div>	<!-- .cart-container -->



                                                    <!-- mobile new design header end -->


        <?php
    } elseif ('socials' === $cta_content) {

        if (prequelle_is_wvc_activated() && function_exists('wvc_socials')) {
            echo wvc_socials(array('services' => prequelle_get_inherit_mod('menu_socials', 'facebook,twitter,instagram'),));
        }
    } elseif ('secondary-menu' === $cta_content && 'desktop' === $context) {

        prequelle_secondary_desktop_navigation();
    } elseif ('wpml' === $cta_content && 'desktop' === $context) {

        do_action('wpml_add_language_selector');
    } // end type
}

add_action('prequelle_secondary_menu', 'aqib_output_complementary_menu', 10, 1);

function new_custom_scripts(){
	
	wp_enqueue_script('countdow', get_template_directory_uri() . '/assets/js/jquery.countdown.js', array('jquery'), 1.1, true);
	wp_enqueue_script('moment', get_template_directory_uri() . '/assets/js/moment.min.js', array('jquery'), 1.1, true);

}
add_action('wp_enqueue_scripts', 'new_custom_scripts');

function product_retailer_custom_content() {
    global $post;

    $_wc_product_retailers_tablist = get_post_meta($post->ID, '_wc_product_retailers_tablist', true);
    $_wc_product_retailers_firstlist = get_post_meta($post->ID, '_wc_product_retailers_firstlist', true);
    echo '<div class="retailer-tabs">';
    ?>
    <script>var sticky = '<?= $_wc_product_retailers_tablist ?>';</script>
    <script>var sticky_first = '<?= $_wc_product_retailers_firstlist ?>';</script>
    <div class="tab pro-retailers-tab">
        <?php
        $_wc_product_retailers_raffles_switch = get_post_meta($post->ID, '_wc_product_retailers_raffles_switch', true);
        $_wc_product_retailers_retailer_switch = get_post_meta($post->ID, '_wc_product_retailers_retailer_switch', true);
        $_wc_product_retailers_aftermarket_switch = get_post_meta($post->ID, '_wc_product_retailers_aftermarket_switch', true);
        $_wc_product_retailers_raffles_switch_tab = get_post_meta($post->ID, '_wc_product_retailers_raffles_switch_tab', true);
        $_wc_product_retailers_wheretobuy_switch = get_post_meta($post->ID, '_wc_product_retailers_wheretobuy_switch', true);
        ?>
        <?php
        if ($_wc_product_retailers_tablist == 'Retailers') {
            ?>
            <?php if ($_wc_product_retailers_retailer_switch == 1) { ?>
                <button class="tablinks active" onclick="openCity(event, 'Retailers')">Retailers</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_raffles_switch == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'All')">All</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_aftermarket_switch == 1) { ?>
                <button class="tablinks active" onclick="openCity(event, 'After-Market')">After-Market</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_raffles_switch_tab == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'Raffles')">Raffles</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_wheretobuy_switch == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'Where_to_Buy')">Where to Buy</button>
            <?php } ?>
            <?php
        } elseif ($_wc_product_retailers_tablist == 'After-Market') {
            ?>
            <?php if ($_wc_product_retailers_aftermarket_switch == 1) { ?>
                <button class="tablinks active" onclick="openCity(event, 'After-Market')">After-Market</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_raffles_switch == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'All')">All</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_retailer_switch == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'Retailers')">Retailers</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_raffles_switch_tab == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'Raffles')">Raffles</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_wheretobuy_switch == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'Where_to_Buy')">Where to Buy</button>
            <?php } ?>

            <?php
        } elseif ($_wc_product_retailers_tablist == 'Raffles') {
            ?>
            <?php if ($_wc_product_retailers_raffles_switch_tab == 1) { ?>
                <button class="tablinks active" onclick="openCity(event, 'Raffles')">Raffles</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_raffles_switch == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'All')">All</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_retailer_switch == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'Retailers')">Retailers</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_aftermarket_switch == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'After-Market')">After-Market</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_wheretobuy_switch == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'Where_to_Buy')">Where to Buy</button>
            <?php } ?>
            <?php
        } elseif ($_wc_product_retailers_tablist == 'Where to Buy') {
            ?>
            <?php if ($_wc_product_retailers_wheretobuy_switch == 1) { ?>
                <button class="tablinks active" onclick="openCity(event, 'Where_to_Buy')">Where to Buy</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_raffles_switch == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'All')">All</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_retailer_switch == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'Retailers')">Retailers</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_aftermarket_switch == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'After-Market')">After-Market</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_raffles_switch_tab == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'Raffles')">Raffles</button>
            <?php } ?>
            <?php
        } else {
            ?>
            <?php if ($_wc_product_retailers_raffles_switch == 1) { ?>
                <button class="tablinks active" onclick="openCity(event, 'All')">All</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_retailer_switch == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'Retailers')">Retailers</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_aftermarket_switch == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'After-Market')">After-Market</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_raffles_switch_tab == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'Raffles')">Raffles</button>
            <?php } ?>
            <?php if ($_wc_product_retailers_wheretobuy_switch == 1) { ?>
                <button class="tablinks" onclick="openCity(event, 'Where_to_Buy')">Where to Buy</button>
            <?php } ?>
        <?php } ?>
    </div>
    <div id="All" class="tabcontent">
        <?php
        $retailers = get_post_meta($post->ID, '_wc_product_retailers_ret', true);
        
        $index = 0;
        if (!empty($retailers)) :
            ?>
            <table>
                <?php 
                foreach ($retailers as $retailer) :
                    try {
                        // build the retailer object and override the URL as needed
                        $_retailer = new WC_Product_Retailers_Retailer($retailer['id']);
                        // product URL for retailer
                        if (!empty($retailer['product_url'])) {
                            $_retailer->set_url($retailer['product_url']);
                        }

                        if (!empty($retailer['product_img'])) {
                            $_retailer->set_img($retailer['product_img']);
                        }

                        // product price for retailer
                        if (isset($retailer['product_price'])) {
                            $_retailer->set_price($retailer['product_price']);
                        }

                        if (isset($retailer['retailer_date'])) {
                            $_retailer->set_retailer_date($retailer['retailer_date']);
                        }

                        if (isset($retailer['retailer_stock'])) {
                            $_retailer->set_retailer_stock($retailer['retailer_stock']);
                        }

                        if (isset($retailer['retailer_coupon'])) {
                            $_retailer->set_retailer_coupon($retailer['retailer_coupon']);
                        }

                        if (isset($retailer['retailer_saleprice'])) {
                            $_retailer->set_retailer_saleprice($retailer['retailer_saleprice']);
                        }

                        if (isset($retailer['retailer_color'])) {
                            $_retailer->set_retailer_color($retailer['retailer_color']);
                        }

                        // if the retailer is not available (trashed) exclude it
                        if (!$_retailer->is_available(true)) {
                            continue;
                        }
                        ?>

                        <tr class="wc-product-retailer">
                            <td class="wc-product-retailer_name"><img width="40" height="20" src="<?php echo esc_html($_retailer->get_img()); ?>" /></td>
                            <?php if($_retailer->get_retailer_date()) { ?>
                                <td class="wc-product-retailer-product-date" data-countdown="<?php echo date("Y/m/d  H:i:s", strtotime(esc_attr($_retailer->get_retailer_date()))); ?>" >
                                <?php echo esc_attr($_retailer->get_retailer_date()); ?>
                            </td> 
                            <?php     
                            }
                            else {
                            ?>
                          <td class = "wc-product-retailer-product-date"> 00:00:00:00 </td>
                            <?php 
                            }
                            ?>
                            <td class="wc-product-retailer-product-price">
                                <?php echo esc_attr($_retailer->get_price()); ?>
                            </td>
                            <td class="wc-product-retailer-product-url">
                                <a  href="<?php echo esc_attr($_retailer->get_url()); ?>" class="button <?php echo (esc_attr($_retailer->get_retailer_color()) == 1) ? 'btn-greyed' : '' ?>" target="_blank">Buy<i id="retail-buy-arrow" class="fa lnr-arrow-right"></i></a>
                            </td>
                            <td class="wc-product-retailer-product-clipboard">
                                <button id="refcopyBtn" data-clipboard-text="<?php echo esc_attr($_retailer->get_url()); ?>" class="btn ref-copy-btn" onclick="copyText();"><img src="https://duragnation.com/wp-content/uploads/2018/08/copy.png" width="20px"></button>
                            </td>
                        </tr>
                        <?php
                        $index++;
                    } catch (Exception $e) { /* retailer does not exist */
                    }
                endforeach;
            endif;


            $retailers = get_post_meta($post->ID, '_wc_product_retailers_aftermarket', true);
            $index = 0;

            if (!empty($retailers)) :


                foreach ($retailers as $retailer) :

                    try {
                        // build the retailer object and override the URL as needed
                        $_retailer = new WC_Product_Retailers_Retailer($retailer['id']);

                        // product URL for retailer
                        if (!empty($retailer['product_url'])) {
                            $_retailer->set_url($retailer['product_url']);
                        }

                        if (!empty($retailer['product_img'])) {
                            $_retailer->set_img($retailer['product_img']);
                        }

                        // product price for retailer
                        if (isset($retailer['product_price'])) {
                            $_retailer->set_price($retailer['product_price']);
                        }

                        if (isset($retailer['retailer_date'])) {
                            $_retailer->set_retailer_date($retailer['retailer_date']);
                        }

                        if (isset($retailer['retailer_stock'])) {
                            $_retailer->set_retailer_stock($retailer['retailer_stock']);
                        }

                        if (isset($retailer['retailer_coupon'])) {
                            $_retailer->set_retailer_coupon($retailer['retailer_coupon']);
                        }

                        if (isset($retailer['retailer_saleprice'])) {
                            $_retailer->set_retailer_saleprice($retailer['retailer_saleprice']);
                        }

                        if (isset($retailer['retailer_color'])) {
                            $_retailer->set_retailer_color($retailer['retailer_color']);
                        }

                        // if the retailer is not available (trashed) exclude it
                        if (!$_retailer->is_available(true)) {
                            continue;
                        }
                        ?>

                        <tr class="wc-product-retailer_aftermarket">
                            <td class="wc-product-retailer_name"><img width="40" height="20" src="<?php echo esc_html($_retailer->get_img()); ?>" /></td>
                           
                            <?php if($_retailer->get_retailer_date()) { ?>
                                <td class="wc-product-retailer-product-date" data-countdown="<?php echo date("Y/m/d  H:i:s", strtotime(esc_attr($_retailer->get_retailer_date()))); ?>" >
                                <?php echo esc_attr($_retailer->get_retailer_date()); ?>
                            </td> 
                            <?php     
                            }
                            else {
                            ?>
                           <td class = "wc-product-retailer-product-date"> 00:00:00:00 </td>
                            <?php 
                            }
                            ?>
                           
                         
                            <td class="wc-product-retailer-product-price">
                                <?php echo esc_attr($_retailer->get_price()); ?>
                            </td>
                            <td class="wc-product-retailer-product-url">
                                <a  href="<?php echo esc_attr($_retailer->get_url()); ?>" class="button <?php echo (esc_attr($_retailer->get_retailer_color()) == 1) ? 'btn-greyed' : '' ?>" target="_blank">Buy<i id="retail-buy-arrow" class="fa lnr-arrow-right"></i></a>
                            </td>
                            <td class="wc-product-retailer-product-clipboard">
                                <button id="refcopyBtn" data-clipboard-text="<?php echo esc_attr($_retailer->get_url()); ?>" class="btn ref-copy-btn" onclick="copyText();"><img src="https://duragnation.com/wp-content/uploads/2018/08/copy.png" width="20px"></button>
                            </td>
                        </tr>
                        <?php
                        $index++;
                    } catch (Exception $e) { /* retailer does not exist */
                    }
                endforeach;
            endif;

            $retailers = get_post_meta($post->ID, '_wc_product_retailers_raffles', true);
            $index = 0;

            if (!empty($retailers)) :

                foreach ($retailers as $retailer) :

                    try {
                        // build the retailer object and override the URL as needed
                        $_retailer = new WC_Product_Retailers_Retailer($retailer['id']);

                        // product URL for retailer
                        if (!empty($retailer['product_url'])) {
                            $_retailer->set_url($retailer['product_url']);
                        }

                        if (!empty($retailer['product_img'])) {
                            $_retailer->set_img($retailer['product_img']);
                        }

                        // product price for retailer
                        if (isset($retailer['product_price'])) {
                            $_retailer->set_price($retailer['product_price']);
                        }

                         if (isset($retailer['retailer_date'])) {
                             $_retailer->set_retailer_date($retailer['retailer_date']);
                         } 
                        
                    

                        if (isset($retailer['retailer_stock'])) {
                            $_retailer->set_retailer_stock($retailer['retailer_stock']);
                        }

                        if (isset($retailer['retailer_coupon'])) {
                            $_retailer->set_retailer_coupon($retailer['retailer_coupon']);
                        }

                        if (isset($retailer['retailer_saleprice'])) {
                            $_retailer->set_retailer_saleprice($retailer['retailer_saleprice']);
                        }

                        if (isset($retailer['retailer_color'])) {
                            $_retailer->set_retailer_color($retailer['retailer_color']);
                        }

                        // if the retailer is not available (trashed) exclude it
                        if (!$_retailer->is_available(true)) {
                            continue;
                        }
                        ?>
                        <tr class="wc-product-retailer_raffles">
                            <td class="wc-product-retailer_name"><img width="40" height="20" src="<?php echo esc_html($_retailer->get_img()); ?>" /></td>
                            
                            <?php if($_retailer->get_retailer_date()) { ?>
                                <td class="wc-product-retailer-product-date" data-countdown="<?php echo date("Y/m/d  H:i:s", strtotime(esc_attr($_retailer->get_retailer_date()))); ?>" >
                                <?php echo esc_attr($_retailer->get_retailer_date()); ?>
                            </td> 
                            <?php     
                            }
                            else {
                            ?>
                           <td class = "wc-product-retailer-product-date"> 00:00:00:00 </td>
                            <?php 
                            }
                            ?>
                            
                            
                           
                            <td class="wc-product-retailer-product-price">
                                <?php echo esc_attr($_retailer->get_price()); ?>
                            </td>
                            <td class="wc-product-retailer-product-url">
                                <a  href="<?php echo esc_attr($_retailer->get_url()); ?>" class="button <?php echo (esc_attr($_retailer->get_retailer_color()) == 1) ? 'btn-greyed' : '' ?>" target="_blank">Buy<i id="retail-buy-arrow" class="fa lnr-arrow-right"></i></a>
                            </td>
                            <td class="wc-product-retailer-product-clipboard">
                                <button id="refcopyBtn" data-clipboard-text="<?php echo esc_attr($_retailer->get_url()); ?>" class="btn ref-copy-btn" onclick="copyText();"><img src="https://duragnation.com/wp-content/uploads/2018/08/copy.png" width="20px"></button>
                            </td>
                        </tr>
                        <?php
                        $index++;
                    } catch (Exception $e) { /* retailer does not exist */
                    }
                endforeach;
            endif;
            ?>
        </table>
    </div>
    <div id="Retailers" class="tabcontent">
        <?php
        $retailers = get_post_meta($post->ID, '_wc_product_retailers_ret', true);
        $index = 0;
        if (!empty($retailers)) :
            ?>
            <table>
                <?php
                foreach ($retailers as $retailer) :
                    try {
                        // build the retailer object and override the URL as needed
                        $_retailer = new WC_Product_Retailers_Retailer($retailer['id']);
                        // product URL for retailer
                        if (!empty($retailer['product_url'])) {
                            $_retailer->set_url($retailer['product_url']);
                        }

                        if (!empty($retailer['product_img'])) {
                            $_retailer->set_img($retailer['product_img']);
                        }

                        // product price for retailer
                        if (isset($retailer['product_price'])) {
                            $_retailer->set_price($retailer['product_price']);
                        }

                        if (isset($retailer['retailer_date'])) {
                            $_retailer->set_retailer_date($retailer['retailer_date']);
                        }

                        if (isset($retailer['retailer_stock'])) {
                            $_retailer->set_retailer_stock($retailer['retailer_stock']);
                        }

                        if (isset($retailer['retailer_coupon'])) {
                            $_retailer->set_retailer_coupon($retailer['retailer_coupon']);
                        }

                        if (isset($retailer['retailer_saleprice'])) {
                            $_retailer->set_retailer_saleprice($retailer['retailer_saleprice']);
                        }

                        if (isset($retailer['retailer_color'])) {
                            $_retailer->set_retailer_color($retailer['retailer_color']);
                        }

                        // if the retailer is not available (trashed) exclude it
                        if (!$_retailer->is_available(true)) {
                            continue;
                        }
                        ?>

                        <tr class="wc-product-retailer">
                            <td class="wc-product-retailer_name"><img width="40" height="20" src="<?php echo esc_html($_retailer->get_img()); ?>" /></td>
                            
                            <?php if($_retailer->get_retailer_date()) { ?>
                                <td class="wc-product-retailer-product-date" data-countdown="<?php echo date("Y/m/d  H:i:s", strtotime(esc_attr($_retailer->get_retailer_date()))); ?>" >
                                <?php echo esc_attr($_retailer->get_retailer_date()); ?>
                            </td> 
                            <?php     
                            }
                            else {
                            ?>
                         <td class = "wc-product-retailer-product-date"> 00:00:00:00 </td>
                            <?php 
                            }
                            ?>
                            
                            
                          
                            <td class="wc-product-retailer-product-price">
                                <?php echo esc_attr($_retailer->get_price()); ?>
                            </td>
                            <td class="wc-product-retailer-product-url">
                                <a  href="<?php echo esc_attr($_retailer->get_url()); ?>" class="button <?php echo (esc_attr($_retailer->get_retailer_color()) == 1) ? 'btn-greyed' : '' ?>" target="_blank">Buy<i id="retail-buy-arrow" class="fa lnr-arrow-right"></i></a>
                            </td>
                            <td class="wc-product-retailer-product-clipboard">
                                <button id="refcopyBtn" data-clipboard-text="<?php echo esc_attr($_retailer->get_url()); ?>" class="btn ref-copy-btn" onclick="copyText();"><img src="https://duragnation.com/wp-content/uploads/2018/08/copy.png" width="20px"></button>
                            </td>
                        </tr>
                        <?php
                        $index++;
                    } catch (Exception $e) { /* retailer does not exist */
                    }
                endforeach;
            endif;
            ?>
        </table>
    </div>
    <div id="After-Market" class="tabcontent">
        <?php
        $retailers = get_post_meta($post->ID, '_wc_product_retailers_aftermarket', true);
        $index = 0;

        if (!empty($retailers)) :
            ?>
            <table>
                <?php
                foreach ($retailers as $retailer) :

                    try {
                        // build the retailer object and override the URL as needed
                        $_retailer = new WC_Product_Retailers_Retailer($retailer['id']);

                        // product URL for retailer
                        if (!empty($retailer['product_url'])) {
                            $_retailer->set_url($retailer['product_url']);
                        }

                        if (!empty($retailer['product_img'])) {
                            $_retailer->set_img($retailer['product_img']);
                        }

                        // product price for retailer
                        if (isset($retailer['product_price'])) {
                            $_retailer->set_price($retailer['product_price']);
                        }

                        if (isset($retailer['retailer_date'])) {
                            $_retailer->set_retailer_date($retailer['retailer_date']);
                        }

                        if (isset($retailer['retailer_stock'])) {
                            $_retailer->set_retailer_stock($retailer['retailer_stock']);
                        }

                        if (isset($retailer['retailer_coupon'])) {
                            $_retailer->set_retailer_coupon($retailer['retailer_coupon']);
                        }

                        if (isset($retailer['retailer_saleprice'])) {
                            $_retailer->set_retailer_saleprice($retailer['retailer_saleprice']);
                        }

                        if (isset($retailer['retailer_color'])) {
                            $_retailer->set_retailer_color($retailer['retailer_color']);
                        }

                        // if the retailer is not available (trashed) exclude it
                        if (!$_retailer->is_available(true)) {
                            continue;
                        }
                        ?>

                        <tr class="wc-product-retailer_aftermarket">
                            <td class="wc-product-retailer_name"><img width="40" height="20" src="<?php echo esc_html($_retailer->get_img()); ?>" /></td>
                           
                            <?php if($_retailer->get_retailer_date()) { ?>
                                <td class="wc-product-retailer-product-date" data-countdown="<?php echo date("Y/m/d  H:i:s", strtotime(esc_attr($_retailer->get_retailer_date()))); ?>" >
                                <?php echo esc_attr($_retailer->get_retailer_date()); ?>
                            </td> 
                            <?php     
                            }
                            else {
                            ?>
                           <td class = "wc-product-retailer-product-date"> 00:00:00:00 </td>
                            <?php 
                            }
                            ?>
                           
                           
                        
                            <td class="wc-product-retailer-product-price">
                                <?php echo esc_attr($_retailer->get_price()); ?>
                            </td>
                            <td class="wc-product-retailer-product-url">
                                <a   href="<?php echo esc_attr($_retailer->get_url()); ?>" class="button <?php echo (esc_attr($_retailer->get_retailer_color()) == 1) ? 'btn-greyed' : '' ?>" target="_blank">Buy<i id="retail-buy-arrow" class="fa lnr-arrow-right"></i></a>
                            </td>
                            <td class="wc-product-retailer-product-clipboard">
                                <button id="refcopyBtn" data-clipboard-text="<?php echo esc_attr($_retailer->get_url()); ?>" class="btn ref-copy-btn" onclick="copyText();"><img src="https://duragnation.com/wp-content/uploads/2018/08/copy.png" width="20px"></button>
                            </td>
                        </tr>
                        <?php
                        $index++;
                    } catch (Exception $e) { /* retailer does not exist */
                    }
                endforeach;
            endif;
            ?>
        </table>
    </div>
    <div id="Raffles" class="tabcontent">
        <?php
        $retailers = get_post_meta($post->ID, '_wc_product_retailers_raffles', true);
        $index = 0;

        if (!empty($retailers)) :
            ?>
            <table>
                <?php
                foreach ($retailers as $retailer) :

                    try {
                        // build the retailer object and override the URL as needed
                        $_retailer = new WC_Product_Retailers_Retailer($retailer['id']);

                        // product URL for retailer
                        if (!empty($retailer['product_url'])) {
                            $_retailer->set_url($retailer['product_url']);
                        }

                        if (!empty($retailer['product_img'])) {
                            $_retailer->set_img($retailer['product_img']);
                        }

                        // product price for retailer
                        if (isset($retailer['product_price'])) {
                            $_retailer->set_price($retailer['product_price']);
                        }

                        if (isset($retailer['retailer_date'])) {
                            $_retailer->set_retailer_date($retailer['retailer_date']);
                        }

                        if (isset($retailer['retailer_stock'])) {
                            $_retailer->set_retailer_stock($retailer['retailer_stock']);
                        }

                        if (isset($retailer['retailer_coupon'])) {
                            $_retailer->set_retailer_coupon($retailer['retailer_coupon']);
                        }

                        if (isset($retailer['retailer_saleprice'])) {
                            $_retailer->set_retailer_saleprice($retailer['retailer_saleprice']);
                        }

                        if (isset($retailer['retailer_color'])) {
                            $_retailer->set_retailer_color($retailer['retailer_color']);
                        }

                        // if the retailer is not available (trashed) exclude it
                        if (!$_retailer->is_available(true)) {
                            continue;
                        }
                        ?>
                        <tr class="wc-product-retailer_raffles">
                            <td class="wc-product-retailer_name"><img width="40" height="20" src="<?php echo esc_html($_retailer->get_img()); ?>" /></td>
                           
                            <?php if($_retailer->get_retailer_date()) { ?>
                                <td class="wc-product-retailer-product-date" data-countdown="<?php echo date("Y/m/d  H:i:s", strtotime(esc_attr($_retailer->get_retailer_date()))); ?>" >
                                <?php echo esc_attr($_retailer->get_retailer_date()); ?>
                            </td> 
                            <?php     
                            }
                            else {
                            ?>
                        
                            
                        <td class = "wc-product-retailer-product-date"> 00:00:00:00 </td>
                            <?php 
                            }
                            ?>
                           
                           
                           
                            
                            <td class="wc-product-retailer-product-price">
                                <?php echo esc_attr($_retailer->get_price()); ?>
                            </td>
                            <td class="wc-product-retailer-product-url">
                                <a  href="<?php echo esc_attr($_retailer->get_url()); ?>" class="button <?php echo (esc_attr($_retailer->get_retailer_color()) == 1) ? 'btn-greyed' : '' ?>" target="_blank">Buy<i id="retail-buy-arrow" class="fa lnr-arrow-right"></i></a>
                            </td>
                            <td class="wc-product-retailer-product-clipboard">
                                <button id="refcopyBtn" data-clipboard-text="<?php echo esc_attr($_retailer->get_url()); ?>" class="btn ref-copy-btn" onclick="copyText();"><img src="https://duragnation.com/wp-content/uploads/2018/08/copy.png" width="20px"></button>
                            </td>
                        </tr>
                        <?php
                        $index++;
                    } catch (Exception $e) { /* retailer does not exist */
                    }
                endforeach;
            endif;
            ?>
        </table>
    </div>
    <div id="Where_to_Buy" class="tabcontent">
        <?php
        $retailers = get_post_meta($post->ID, '_wc_product_retailers_wheretobuy', true);
        $index = 0;

        if (!empty($retailers)) :
            ?>
            <table>
                <?php
                foreach ($retailers as $retailer) :

                    try {
                        // build the retailer object and override the URL as needed
                        $_retailer = new WC_Product_Retailers_Retailer($retailer['id']);

                        // product URL for retailer
                        if (!empty($retailer['product_url'])) {
                            $_retailer->set_url($retailer['product_url']);
                        }

                        if (!empty($retailer['product_img'])) {
                            $_retailer->set_img($retailer['product_img']);
                        }

                        // product price for retailer
                        if (isset($retailer['product_price'])) {
                            $_retailer->set_price($retailer['product_price']);
                        }

                        if (isset($retailer['retailer_date'])) {
                            $_retailer->set_retailer_date($retailer['retailer_date']);
                        }

                        if (isset($retailer['retailer_stock'])) {
                            $_retailer->set_retailer_stock($retailer['retailer_stock']);
                        }

                        if (isset($retailer['retailer_coupon'])) {
                            $_retailer->set_retailer_coupon($retailer['retailer_coupon']);
                        }

                        if (isset($retailer['retailer_saleprice'])) {
                            $_retailer->set_retailer_saleprice($retailer['retailer_saleprice']);
                        }

                        if (isset($retailer['retailer_color'])) {
                            $_retailer->set_retailer_color($retailer['retailer_color']);
                        }

                        // if the retailer is not available (trashed) exclude it
                        if (!$_retailer->is_available(true)) {
                            continue;
                        }
                        ?>
                        <tr class="wc-product-retailer_wheretobuy">
                            <td class="wc-product-retailer_name"><img width="40" height="20" src="<?php echo esc_html($_retailer->get_img()); ?>" /></td>
                            
                            <?php if($_retailer->get_retailer_date()) { ?>
                                <td class="wc-product-retailer-product-date" data-countdown="<?php echo date("Y/m/d  H:i:s", strtotime(esc_attr($_retailer->get_retailer_date()))); ?>" >
                                <?php echo esc_attr($_retailer->get_retailer_date()); ?>
                            </td> 
                            <?php     
                            }
                            else {
                            ?>
                            <td class = "wc-product-retailer-product-date"> 00:00:00:00 </td>
                            <?php 
                            }
                            ?>
                            
                            
                            
                          
                            <td class="wc-product-retailer-product-price">
                                <?php echo esc_attr($_retailer->get_price()); ?>
                            </td>
                            <td class="wc-product-retailer-product-url">
                                <a  href="<?php echo esc_attr($_retailer->get_url()); ?>" class="button <?php echo (esc_attr($_retailer->get_retailer_color()) == 1) ? 'btn-greyed' : '' ?>" target="_blank">Buy<i id="retail-buy-arrow" class="fa lnr-arrow-right"></i></a>
                            </td>
                            <td class="wc-product-retailer-product-clipboard">
                                <button id="refcopyBtn" data-clipboard-text="<?php echo esc_attr($_retailer->get_url()); ?>" class="btn ref-copy-btn" onclick="copyText();"><img src="https://duragnation.com/wp-content/uploads/2018/08/copy.png" width="20px"></button>
                            </td>
                        </tr>
                        <?php
                        $index++;
                    } catch (Exception $e) { /* retailer does not exist */
                    }
                endforeach;
            endif;
            ?>
        </table>
    </div>


    </div>
    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        document.addEventListener("DOMContentLoaded", function (event) {
            openCity(event, sticky);
        });

    </script>

    <nav class="woocommerce-breadcrumb product-category-list">
        <?php
        $terms = get_the_terms($post->ID, 'product_cat');
        foreach ($terms as $term) {
            echo '<a href="' . get_bloginfo("url") . '/product-category/' . $term->slug . '">' . $term->name . '</a>';
        }

        //do_action('woocommerce_before_main_content');
        ?>
    </nav>
    <?php
}

add_action('woocommerce_single_product_summary', 'product_retailer_custom_content', 40);

function retailer_custom_scripts() {

    //wp_enqueue_script( 'sweetalert-dev', get_stylesheet_directory_uri() . '/sweetalert-dev.js', array ( 'jquery' ), 1.1, true);
    wp_enqueue_script('clipboard', get_stylesheet_directory_uri() . '/clipboard.min.js', array('jquery'), 1.1, true);
    wp_enqueue_script('my_retailer_script', get_stylesheet_directory_uri() . '/my_retailer_script.js', array('jquery'), 1.1, true);
    wp_enqueue_script('alertify', get_stylesheet_directory_uri() . '/alertify.js', array('jquery'), 1.1, true);
   wp_enqueue_script('my_stickybox_script', get_stylesheet_directory_uri() . '/jquery.stickybox.js', array('jquery'), 1.1, true);
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'retailer_custom_scripts');

function retailer_custom_styles() {
    wp_enqueue_style('style', get_stylesheet_uri());

    wp_enqueue_style('alertifycss', get_stylesheet_directory_uri() . '/alertify.css', array(), '1.1', 'all');
}
add_action('wp_enqueue_style', 'retailer_custom_styles');

function mytheme_add_woocommerce_support() {
    add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'mytheme_add_woocommerce_support');


// Wishlist Editing
// Enabling and Displaying Fields in backend
add_action('woocommerce_product_options_general_product_data', 'woo_add_custom_general_fields');

function woo_add_custom_general_fields() {

    echo '<div class="options_group">';
    $taxonomy = 'product_cat';
    $orderby = 'name';
    $show_count = 0;      // 1 for yes, 0 for no
    $pad_counts = 0;      // 1 for yes, 0 for no
    $hierarchical = 1;      // 1 for yes, 0 for no  
    $title = '';
    $empty = 0;

    $args = array(
        'taxonomy' => $taxonomy,
        'orderby' => $orderby,
        'show_count' => $show_count,
        'pad_counts' => $pad_counts,
        'hierarchical' => $hierarchical,
        'title_li' => $title,
        'hide_empty' => $empty
    );
    $options[''] = __('Select Related Product Category', 'woocommerce');
    $all_categories = get_categories($args);
    foreach ($all_categories as $cat) {
        $options[$cat->term_id] = $cat->name;
    }
    woocommerce_wp_select(array(// Text Field type
        'id' => '_Related_Poduct_Category',
        'label' => __('Related Products Category', 'woocommerce'),
        'description' => __('Related Products Category', 'woocommerce'),
        'desc_tip' => true,
        'options' => $options
    ));

    echo '</div>';
}

// Save Fields values to database when submitted (Backend)
add_action('woocommerce_process_product_meta', 'woo_save_custom_general_fields', 30, 1);

function woo_save_custom_general_fields($post_id) {

    // Saving "Conditions" field key/value
    $posted_field_value = $_POST['_Related_Poduct_Category'];
    if (!empty($posted_field_value))
        update_post_meta($post_id, '_Related_Poduct_Category', esc_attr($posted_field_value));
}

// Display In front end
add_action('woocommerce_product_meta_start', 'woo_display_custom_general_fields_values', 50);

function woo_display_custom_general_fields_values() {
    global $product;

    // compatibility with WC +3
    $product_id = method_exists($product, 'get_id') ? $product->get_id() : $product->id;

    echo '<span class="stan">Stan: ' . get_post_meta($product_id, '_Related_Poduct_Category', true) . '</span>';
}

function create_posttype() {
//    register_post_type('released_feeds', array(
//        'labels' => array(
//            'name' => __('Released'),
//            'singular_name' => __('Released')
//        ),
//        'public' => true,
//        'has_archive' => true,
//        'rewrite' => array('slug' => 'released'),
//        'menu_icon' => 'dashicons-megaphone',
//            )
//    );
//    register_post_type('restocked_feeds', array(
//        'labels' => array(
//            'name' => __('Restocked'),
//            'singular_name' => __('Restocked')
//        ),
//        'public' => true,
//        'has_archive' => true,
//        'rewrite' => array('slug' => 'restocked'),
//        'menu_icon' => 'dashicons-image-rotate',
//            )
//    );
    register_post_type('general_feeds', array(
        'labels' => array(
            'name' => __('Feeds'),
            'singular_name' => __('Feed')
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'released'),
        'menu_icon' => 'dashicons-rss',
            )
    );
}

add_action('init', 'create_posttype');

function acf_load_product_field_choices($field) {

    // reset choices
    $field['choices'] = array();

    $args = array('post_type' => 'product', 'posts_per_page' => -1);
    $products = get_posts($args);
    $choices = [];
    foreach ($products as $product) {
        $productObj = wc_get_product( $product->ID );
        $choices[$product->ID] = $product->post_title.'('.$productObj->get_sku().')';
    }

    if (is_array($choices)) {

        foreach ($choices as $choice => $choicesValue) {

            $field['choices'][$choice] = $choicesValue;
        }
    }


    // return the field
    return $field;
}

add_filter('acf/load_field/name=product', 'acf_load_product_field_choices');
define('ACF_EARLY_ACCESS', '5');

// Add the custom columns to the book post type:
add_filter('manage_general_feeds_posts_columns', 'set_custom_edit_general_feeds_columns');

function set_custom_edit_general_feeds_columns($columns) {
    unset($columns['author']);
    $columns['feed_type'] = __('Feed Type');
    $columns['product'] = __('Product');
    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action('manage_general_feeds_posts_custom_column', 'custom_general_feeds_column', 10, 2);

function custom_general_feeds_column($column, $post_id) {
    switch ($column) {

        case 'feed_type' :
            $feed_type_value = get_field('feed_type', $post_id);
            if (is_string($feed_type_value) && (strpos(strtolower($feed_type_value), 'released') !== false))
                echo 'Released';
            elseif (is_string($feed_type_value) && (strpos(strtolower($feed_type_value), 'restocked') !== false))
                echo 'Restocked';
            else
                echo $feed_type_value;
            break;

        case 'product' :
            $product_id = get_field('product', $post_id);
            $product = wc_get_product( $product_id );
            echo '<a class="feed-backend-thumbnail" href="' . get_permalink($product_id) . '">' . get_the_post_thumbnail($product_id) .$product->get_title(). '</a>';
            break;
    }
}

add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
    echo '<style>
a.feed-backend-thumbnail > img {
    width: 50px;
    height: 50px;
}
th#feed_type {
    width: 100px;
}
  </style>';
}
define('DISABLE_WP_CRON', 'true');



add_action( 'after_setup_theme', 'gallery_theme_setup' );

function gallery_theme_setup() {
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );
}



wp_logout_url( 'https://duragnation.com' );






// wp_enqueue_script(){
//     {
//         $('a').on('click', function(){
//         alert('asdasdasdsad')
//         $('body').addClass('aqib');
//     });
//     }
    
// }

add_action( 'after_setup_theme', function() {
    $undash = new Undash_Permalinks( '/' );
    add_filter( 'page_link', [ $undash, 'output' ] );
    add_filter( 'request', [ $undash, 'input' ] );
});

class Undash_Permalinks
{
    /**
     * What to use instead of /
     *
     * @var string
     */
    private $replacement;

    /**
     * Undash_Permalinks constructor.
     *
     * @param string $replacement
     */
    public function __construct( $replacement )
    {
        $this->replacement = $replacement;
    }

    /**
     * Change the output URL
     *
     * @wp-hook page_link
     * @param   string $url
     *
     * @return string
     */
    public function output( $url )
    {
        $home     = home_url( '/' );
        $start    = strlen( $home );
        $sub      = substr( $url, $start );
        $replaced = str_replace( '/', $this->replacement, $sub );

        return $home . $replaced;
    }

    /**
     * Help WordPress to understand the requests as page requests
     *
     * @wp-hook request
     * @param   array $request
     *
     * @return array
     */
    public function input( array $request )
    {
        if ( empty ( $request[ 'name' ] ) )
            return $request;

        if ( FALSE === strpos( $request[ 'name' ], $this->replacement ) )
            return $request;

        $path = str_replace( $this->replacement, '/', $request[ 'name' ] );
        $page = get_page_by_path( $path );

        if ( ! $page )
            return $request;

        // Convince WP that we really have a page.
        $request[ 'pagename' ] = $path;
        unset( $request[ 'name' ] );

        return $request;
    }
}

// define the woocommerce_before_add_to_cart_form callback 
function action_woocommerce_before_add_to_cart_form(  ) { 
    // make action magic happen here... 
    echo do_shortcode( '[ti_wishlists_addtowishlist]' );
}; 
add_action( 'woocommerce_before_add_to_cart_form', 'action_woocommerce_before_add_to_cart_form', 20, 10 ); 

// Defer function
// if (!(is_admin() )) {
//     function defer_parsing_of_js ( $url ) {
//         if ( FALSE === strpos( $url, '.js' ) ) return $url;
//         if ( strpos( $url, 'jquery.js' ) || strpos( $url, 'single-product.min.js' ) ) return $url;
//             return "$url' defer onload='";
//     }
//     add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );
// }
