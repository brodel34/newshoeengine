<?php
/**
 * Prequelle Navigation hook functions
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Output the main menu in the header
 */
function prequelle_output_main_navigation() {

    if ('none' === prequelle_get_inherit_mod('menu_layout', 'top-right')) {
        return;
    }
    ?>
    <div id="desktop-navigation" class="clearfix">
        <?php
        /**
         * Desktop Navigation
         */
        get_template_part('components/navigation/content', prequelle_get_inherit_mod('menu_layout', 'top-right'));

        /**
         * Search form
         */
        prequelle_nav_search_form();
        ?>
    </div><!-- #desktop-navigation -->
    <div id="mobile-navigation">
        <?php
        /**
         * Mobile Navigation
         */
        get_template_part('components/navigation/' . apply_filters('prequelle_mobile_menu_template', 'content-mobile'));
        ?>
    </div><!-- #mobile-navigation -->
    <?php
}

add_action('prequelle_main_navigation', 'prequelle_output_main_navigation');

/**
 * Secondary navigation hook
 *
 * Display cart icons, social icons or secondary menu depending on cuzstimizer option
 */
function prequelle_output_complementary_menu($context = 'desktop') {

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
    <?php if ('shop_icons' === $cta_content && 'desktop' === $context) { ?>
        <?php if (prequelle_display_shop_search_menu_item()) : ?>
            <div class="search-container cta-item">
                <?php
                /**
                 * Search
                 */
                prequelle_search_menu_item();
                ?>
            </div><!-- .search-container -->
        <?php endif ?>

        <?php if (prequelle_display_cart_menu_item()) : ?>
            <?php
            if (is_user_logged_in()) {
                $product_ids = www_get_wishlist_product_ids();
                $args = array(
                    'post_type' => array('general_feeds'),
                    'posts_per_page' => 300,
                    'meta_query' => array(
                        array(
                            'key' => 'product',
                            'value' => $product_ids,
                            'compare' => 'IN'
                        )
                    )
                );
                $notificationsCount = 0;
                $notifications = new WP_Query($args);
                $user_product_ids_timings = get_user_meta(get_current_user_id(), 'shoe_engine_wc_wishlisttiming');
                if (count($user_product_ids_timings) > 0) {
                    $user_product_ids_timings = $user_product_ids_timings[0];
                }
                if (count($notifications->posts) > 0) {
                    foreach ($notifications->posts as $notify_post) {
                        $product_id = get_field('product', $notify_post->ID);
                        $published_at = strtotime($notify_post->post_date);
                        if (isset($user_product_ids_timings[$product_id]) && $user_product_ids_timings[$product_id] < $published_at) {
                            $notificationsCount++;
                        }
                    }
                }
                $user_notifications_ser = get_user_meta(get_current_user_id(), 'user_readed_notification', true);
                $user_notifications = unserialize($user_notifications_ser);
                if ($user_notifications_ser == '') {
                    $user_notifications_count = 0;
                } else {
                    $user_notifications_count = count($user_notifications);
                }
                $notificationDisplay = $notificationsCount - $user_notifications_count;
                global $wp;
                if ($wp->request == 'notifications') {
                    $notificationDisplay = 0;
                }
                ?>
                <?php if ($notificationDisplay != 0) { ?>
                    <div class="cart-container cta-item">
                        <a href="<?php echo get_bloginfo('url'); ?>/notifications" class="bell-cust"></a><span class="notification_count"><?php echo $notificationDisplay; ?></span>
                    </div><!-- .cart-container -->
                <?php } else {
                    ?>
                    <div class="cart-container cta-item">
                        <a href="<?php echo get_bloginfo('url'); ?>/notifications" class="bell-cust"></a>
                    </div><!-- .cart-container -->
                    <?php }
                ?>
            <?php } else { ?>
                <div class="cart-container cta-item">
                    <a href="#" class="bell-cust account-item-icon-user-not-logged-in"></a>
                </div><!-- .cart-container -->
            <?php } ?>
        <?php endif ?>
        <div class="account-container cta-item">


            <?php if (prequelle_display_account_menu_item()) : ?>


                <?php
                /**
                 * account icon
                 */
                prequelle_account_menu_item();
                ?>
            </div><!-- .cart-container -->
        <?php endif ?>
        <?php if (prequelle_display_wishlist_menu_item()) : ?>
            <div class="wishlist-container cta-item">
                <?php
                /**
                 * Wishlist icon
                 */
                prequelle_wishlist_menu_item();
                ?>
            </div><!-- .cart-container -->
        <?php endif ?>


    <?php } elseif ('search_icon' === $cta_content && 'desktop' === $context) { ?>

        <div class="search-container cta-item">
            <?php
            /**
             * Search
             */
            prequelle_search_menu_item();
            ?>
        </div><!-- .search-container -->

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

add_action('prequelle_secondary_menu', 'prequelle_output_complementary_menu', 10, 1);

/**
 * Add side panel
 */
function prequelle_side_panel() {

    if (prequelle_can_display_sidepanel()) {
        get_template_part('components/layout/sidepanel');
    }
}

add_action('prequelle_body_start', 'prequelle_side_panel');

/**
 * Overwrite sidepanel position for non-top menu
 */
function prequelle_overwrite_side_panel_position($position) {

    $menu_layout = prequelle_get_inherit_mod('menu_layout', 'top-right');

    if ($position && 'overlay' === $menu_layout) {
        $position = 'left';
    }

    return $position;
}

add_action('prequelle_side_panel_position', 'prequelle_overwrite_side_panel_position');

/**
 * Off Canvas menus
 */
function prequelle_offcanvas_menu() {

    if ('offcanvas' !== prequelle_get_inherit_mod('menu_layout')) {
        return;
    }
    ?>
    <div class="offcanvas-menu-panel">
        <div class="offcanvas-menu-panel-inner">
            <?php
            /**
             * Menu
             */
            prequelle_primary_vertical_navigation();
            ?>
        </div><!-- .offcanvas-menu-panel-inner -->
    </div><!-- .offcanvas-menu-panel -->
    <?php
}

add_action('prequelle_body_start', 'prequelle_offcanvas_menu');

/**
 * Infinite scroll pagination
 *
 * @param object $query
 * @param string $pagination_type
 */
function prequelle_output_pagination($query = null, $pagination_args = array()) {

    if (!$query) {
        global $wp_query;
        $main_query = $wp_query;
        $query = $wp_query;
    }

    $pagination_args = extract(wp_parse_args($pagination_args, array(
        'post_type' => 'post',
        'pagination_type' => '',
        'product_category_link_id' => '',
        'paged' => 1,
        'container_id' => '',
                    )
    ));

    $max = $query->max_num_pages;

    $pagination_type = ( $pagination_type ) ? $pagination_type : apply_filters('prequelle_post_pagination', prequelle_get_theme_mod('post_pagination'));

    $button_class = apply_filters('prequelle_loadmore_button_class', 'button', $pagination_type);

    $container_class = apply_filters('prequelle_loadmore_container_class', 'trigger-container wvc-element');

    if ('link_to_blog' === $pagination_type) {
        ?>
        <div class="<?php echo prequelle_sanitize_html_classes($container_class); ?>">
            <a class="<?php echo esc_attr($button_class); ?>" data-aos="fade" data-aos-once="true" href="<?php echo prequelle_get_blog_url(); ?>"><?php echo apply_filters('prequelle_view_more_posts_text', esc_html__('View more posts', 'prequelle')); ?></a>
        </div>
        <?php
    } elseif ('link_to_shop' === $pagination_type) {
        ?>
        <div class="<?php echo prequelle_sanitize_html_classes($container_class); ?>">
            <a class="<?php echo esc_attr($button_class); ?>" data-aos="fade" data-aos-once="true" href="<?php echo prequelle_get_shop_url(); ?>"><?php echo apply_filters('prequelle_view_more_products_text', esc_html__('View more products', 'prequelle')); ?></a>
        </div>
        <?php
    } elseif ('link_to_shop_category' === $pagination_type && $product_category_link_id) {
        $cat_url = get_category_link($product_category_link_id);
        ?>
        <div class="<?php echo prequelle_sanitize_html_classes($container_class); ?>">
            <a class="<?php echo esc_attr($button_class); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url($cat_url); ?>"><?php echo apply_filters('prequelle_view_more_products_text', esc_html__('View more products', 'prequelle')); ?></a>
        </div>
        <?php
    } elseif ('link_to_portfolio' === $pagination_type) {
        ?>
        <div class="<?php echo prequelle_sanitize_html_classes($container_class); ?>">
            <a class="<?php echo esc_attr($button_class); ?>" data-aos="fade" data-aos-once="true" href="<?php echo prequelle_get_portfolio_url(); ?>"><?php echo apply_filters('prequelle_view_more_works_text', esc_html__('View more works', 'prequelle')); ?></a>
        </div>
        <?php
    } elseif ('link_to_events' === $pagination_type) {
        ?>
        <div class="<?php echo prequelle_sanitize_html_classes($container_class); ?>">
            <a class="<?php echo esc_attr($button_class); ?>" data-aos="fade" data-aos-once="true" href="<?php echo prequelle_get_events_url(); ?>"><?php echo apply_filters('prequelle_view_more_events_text', esc_html__('View more events', 'prequelle')); ?></a>
        </div>
        <?php
    } elseif ('link_to_videos' === $pagination_type) {
        ?>
        <div class="<?php echo prequelle_sanitize_html_classes($container_class); ?>">
            <a class="<?php echo esc_attr($button_class); ?>" data-aos="fade" data-aos-once="true" href="<?php echo prequelle_get_videos_url(); ?>"><?php echo apply_filters('prequelle_view_more_videos_text', esc_html__('View more videos', 'prequelle')); ?></a>
        </div>
        <?php
    } elseif ('link_to_albums' === $pagination_type) {
        ?>
        <div class="<?php echo prequelle_sanitize_html_classes($container_class); ?>">
            <a class="<?php echo esc_attr($button_class); ?>" data-aos="fade" data-aos-once="true" href="<?php echo prequelle_get_albums_url(); ?>"><?php echo apply_filters('prequelle_view_more_albums_text', esc_html__('View more albums', 'prequelle')); ?></a>
        </div>
        <?php
    } elseif ('link_to_discography' === $pagination_type) {
        ?>
        <div class="<?php echo prequelle_sanitize_html_classes($container_class); ?>">
            <a class="<?php echo esc_attr($button_class); ?>" data-aos="fade" data-aos-once="true" href="<?php echo prequelle_get_discography_url(); ?>"><?php echo apply_filters('prequelle_view_more_releases_text', esc_html__('View more releases', 'prequelle')); ?></a>
        </div>
        <?php
    } elseif ('link_to_attachments' === $pagination_type && function_exists('prequelle_get_photos_url') && prequelle_get_photos_url()) {
        ?>
        <div class="<?php echo prequelle_sanitize_html_classes($container_class); ?>">
            <a class="<?php echo esc_attr($button_class); ?>" data-aos="fade" data-aos-once="true" href="<?php echo prequelle_get_photos_url(); ?>"><?php echo apply_filters('prequelle_view_more_albums_text', esc_html__('View more photos', 'prequelle')); ?></a>
        </div>
        <?php
    } elseif ('load_more' === $pagination_type) {

        wp_enqueue_script('prequelle-loadposts');

        $next_page = $paged + 1;

        $next_page_href = get_pagenum_link($next_page);
        ?>
        <?php if (1 < $max && $next_page <= $max) : ?>
            <div class="<?php echo prequelle_sanitize_html_classes($container_class); ?>">
                <a data-current-page="1" data-next-page="<?php echo absint($next_page); ?>" data-max-pages="<?php echo absint($max); ?>" class="<?php echo esc_attr($button_class); ?> loadmore-button" data-current-url="<?php echo prequelle_get_current_url(); ?>" href="<?php echo esc_url($next_page_href); ?>"><span><?php echo apply_filters('prequelle_load_more_posts_text', esc_html__('Load More', 'prequelle')); ?></span></a>
            </div><!-- .trigger-containe -->
        <?php endif; ?>
        <?php
    } elseif ('infinitescroll' === $pagination_type) {

        if ('attachment' === $post_type) {
            prequelle_paging_nav($query);
        }
    } elseif ('none' !== $pagination_type && ( 'numbers' === $pagination_type || 'standard_pagination' === $pagination_type )) {

        /**
         * Pagination numbers
         */
        if (!prequelle_is_home_as_blog()) {
            $GLOBALS['wp_query']->max_num_pages = $max; // overwrite max_num_pages with custom query
            $GLOBALS['wp_query']->query_vars['paged'] = $paged;
        }

        the_posts_pagination(apply_filters('prequelle_the_post_pagination_args', array(
            'prev_text' => '<i class="pagination-icon-prev"></i>',
            'next_text' => '<i class="pagination-icon-next"></i>',
        )));
    }
}

add_action('prequelle_pagination', 'prequelle_output_pagination', 10, 3);
