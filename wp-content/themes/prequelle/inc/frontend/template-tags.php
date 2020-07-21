<?php
/**
 * Prequelle template tags
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Edit post link
 */
function prequelle_edit_post_link($echo = true) {
    ob_start();
    edit_post_link(esc_html__('Edit', 'prequelle'), '<span class="meta-icon edit-pencil"></span>');
    $output = '<span class="custom-edit-link">' . ob_get_clean() . '</span>';

    if ($echo && $output) {
        echo prequelle_kses($output);
    }

    return $output;
}

/**
 * Get extra post meta
 *
 * Display comment count, likes, views and reading time
 */
function prequelle_get_extra_meta($echo = true, $post_type = null) {
    $output = '';

    $post_type = ( $post_type ) ? $post_type : get_post_type();

    $output .= '<div class="post-extra-meta">';

    $comments = prequelle_get_comments_count(false);

    if (class_exists('Wolf_Custom_Post_Meta')) {

        $likes = wolf_custom_post_meta_get_likes();
        $views = wolf_custom_post_meta_get_views();
        $reading_time = wolf_custom_post_meta_get_post_reading_time();

        $display_meta = prequelle_list_to_array(prequelle_get_theme_mod('enable_custom_post_meta'));

        if ('post' !== $post_type) {
            $display_meta = prequelle_list_to_array(prequelle_get_theme_mod($post_type . '_enable_custom_post_meta'));
        }

        $post_enable_views = ( in_array($post_type . '_enable_views', $display_meta) );
        $post_enable_likes = ( in_array($post_type . '_enable_likes', $display_meta) );
        $post_enable_reading_time = ( in_array($post_type . '_enable_reading_time', $display_meta) );

        if ($post_enable_likes) {

            $output .= '<span class="post-meta post-likes wolf-like-this" data-post-id="' . esc_attr(get_the_ID()) . '"><i class="fa fa-heart-o likes-icon meta-icon"></i>' . sprintf(
                            wp_kses(
                                    __('<span class="wolf-likes-count">%s</span> likes', 'prequelle'), array(
                        'span' => array(
                            'class' => array(),
                        ),
                                    )
                            ), $likes) . '</span>';
        }

        if ($post_enable_views) {

            $output .= '<span class="post-meta post-views"><i class="meta-icon views-icon"></i>' . sprintf(esc_html__('%s views', 'prequelle'), $views) . '</span>';
        }

        if ($post_enable_reading_time) {

            $output .= '<span class="post-meta post-reading-time"><i class="meta-icon reading-time-icon"></i>' . sprintf(esc_html__('%s min', 'prequelle'), $reading_time) . '</span>';
        }
    }

    if (0 < get_comments_number() && comments_open()) {
        $output .= '<span class="post-meta post-comments">
			<a class="scroll" href="' . esc_url(get_permalink() . '#comments') . '">
			<span class="meta-icon comments-icon"></span>' . sprintf(_n('%s comment', '%s comments', $comments, 'prequelle'), $comments) . '</a>
		</span>';
    }

    $output .= '</div><!-- .post-extra-meta -->';

    if ($echo) {
        echo prequelle_kses($output);
    }

    return $output;
}

/**
 * Get date
 *
 * @param bool $echo
 * @return string $date
 */
function prequelle_entry_date($echo = true, $link = false) {

    $display_time = get_the_date();
    $modified_display_time = get_the_modified_date();

    if ('human_diff' == prequelle_get_theme_mod('date_format')) {
        $display_time = sprintf(esc_html__('%s ago', 'prequelle'), human_time_diff(get_the_time('U'), current_time('timestamp')));
        $modified_display_time = sprintf(esc_html__('%s ago', 'prequelle'), human_time_diff(get_the_modified_time('U'), current_time('timestamp')));
    }

    $date = $display_time;

    if (get_the_time('U') !== get_the_modified_time('U')) {
        $time_string = '<time itemprop="datePublished" class="published" datetime="%1$s">%2$s</time><time itemprop="dateModified" class="updated" datetime="%3$s">%4$s</time>';
    } else {
        $time_string = '<time itemprop="datePublished" class="published updated" datetime="%1$s">%2$s</time>';
    }

    $_time = sprintf(
            $time_string, esc_attr(get_the_date('c')), esc_html($display_time), esc_attr(get_the_modified_date('c')), esc_html($modified_display_time)
    );

    if ($link) {
        $date = sprintf(
                '<span class="posted-on date"><a href="%1$s" rel="bookmark">%2$s</a></span>', esc_url(get_permalink()), $_time
        );
    } else {
        $date = sprintf(
                '<span class="posted-on date">%2$s</span>', esc_url(get_permalink()), $_time
        );
    }

    if ($echo) {
        echo apply_filters('prequelle_entry_date', prequelle_kses($date));
    }

    return apply_filters('prequelle_entry_date', prequelle_kses($date));
}

/**
 * Get comments count
 */
function prequelle_get_comments_count($echo = true) {

    if ($echo) {
        echo get_comments_number();
    }

    return get_comments_number();
}

/**
 * Get Author Avatar
 */
function prequelle_get_author_avatar($size = 20) {

    $output = '<span class="author-meta">';
    $output .= '<a class="author-link" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" rel="author">';
    $output .= get_avatar(get_the_author_meta('user_email'), $size);
    $output .= '</a>';

    $output .= sprintf(
            '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>', esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_attr(sprintf(__('View all posts by %s', 'prequelle'), get_the_author())), apply_filters('prequelle_author_name_meta', prequelle_the_author(false))
    );

    $output .= '</span><!--.author-meta-->';

    echo prequelle_kses($output);
}

/**
 * Get Author
 */
function prequelle_get_author() {

    $output = sprintf(
            '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s %4$s</a></span>', esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_attr(sprintf(__('View all posts by %s', 'prequelle'), get_the_author())), esc_html__('by', 'prequelle'), prequelle_the_author(false)
    );

    echo prequelle_kses($output);
}

/**
 * Get author instagram URL and username
 *
 * @return array
 */
function prequelle_get_author_instagram_username($author_id = null) {


    if (!$author_id) {
        global $post;

        if (!is_object($post)) {
            return;
        }

        $author_id = $post->post_author;
    }

    $author_instagram = get_the_author_meta('instagram', $author_id);

    if ($author_instagram) {
        if (preg_match('/instagram.com\/[a-zA-Z0-9_]+/', $author_instagram, $match)) {
            $insta_username = str_replace('instagram.com/', '', $match[0]);
            return $insta_username;
        }
    }
}

/**
 * Display work meta for Portfolio "work" post type
 */
function prequelle_work_meta() {
    $post_id = get_the_ID();
    $client = get_post_meta($post_id, '_work_client', true);
    $link = get_post_meta($post_id, '_work_link', true);
    $skills = get_the_term_list($post_id, 'work_type', '', esc_html__(', ', 'prequelle'), '');
    ?>
    <?php if ($skills) : ?>
        <div class="work-meta work-categories">
            <i class="fa fa-tag"></i> <span class="work-meta-label"><?php esc_html_e('Category', 'prequelle'); ?></span> <span class="work-meta-separator">&mdash;</span> <span class="work-meta-value"><?php echo prequelle_kses($skills); ?></span>
        </div>
    <?php endif; ?>

    <?php if ($client) : ?>
        <div class="work-meta work-client">
            <i class="fa fa-user-o"></i> <span class="work-meta-label"><?php esc_html_e('Client', 'prequelle'); ?></span> <span class="work-meta-separator">&mdash;</span> <span class="work-meta-value"><?php echo sanitize_text_field($client); ?></span>
        </div>
    <?php endif; ?>

    <?php
    if ($link) :
        $link_text = mb_strimwidth(str_replace('http://', '', $link), 0, 25, '...');
        ?>
        <div class="work-meta work-link">
            <i class="fa fa-link"></i> <span class="work-meta-label"><?php esc_html_e('Link', 'prequelle'); ?></span> <span class="work-meta-separator">&mdash;</span> <span class="work-meta-value"><a href="<?php echo esc_url($link); ?>"><?php echo sanitize_text_field($link_text); ?></a></span>
        </div>
    <?php endif; ?>
    <?php
}

if (!function_exists('prequelle_the_author')) {

    /**
     * Get the author
     *
     * @param bool $echo
     * @return string $author
     */
    function prequelle_the_author($echo = true) {

        global $post;

        if (!is_object($post))
            return;

        $author_id = $post->post_author;
        $author = get_the_author_meta('user_nicename', $author_id);

        if (get_the_author_meta('nickname', $author_id)) {
            $author = get_the_author_meta('nickname', $author_id);
        }

        if (get_the_author_meta('first_name', $author_id)) {
            $author = get_the_author_meta('first_name', $author_id);

            if (get_the_author_meta('last_name', $author_id)) {
                $author .= ' ' . get_the_author_meta('last_name', $author_id);
            }
        }

        if ($echo) {
            $author = sprintf('<span class="vcard author"><span class="fn">%s</span></span>', $author);
            echo prequelle_kses($author);
        }

        return $author;
    }

}

/**
 * Navigation search form
 */
function prequelle_nav_search_form() {

    $cta_content = prequelle_get_inherit_mod('menu_cta_content_type', 'search_icon');

    $type = ( 'shop_icons' === $cta_content ) ? 'shop' : 'blog';

    /**
     * Force shop icons on woocommerce pages
     */
    $is_wc_page_child = is_page() && wp_get_post_parent_id(get_the_ID()) == prequelle_get_woocommerce_shop_page_id() && prequelle_is_woocommerce();
    $is_wc = prequelle_is_woocommerce_page() || is_singular('product') || $is_wc_page_child;

    if (apply_filters('prequelle_force_display_nav_shop_icons', $is_wc)) {
        $type = 'shop';
    }

    if (apply_filters('prequelle_force_nav_search_product', $is_wc)) {
        $type = 'shop';
    }

    if (prequelle_get_inherit_mod('menu_cta_content_type', 'search_product_icon')) {
        $type = 'shop';
    }

    if (!class_exists('WooCommerce')) {
        $type = 'blog';
    }
    ?>
    <div class="nav-search-form search-type-<?php echo prequelle_sanitize_html_classes($type); ?>">
        <div class="nav-search-form-container">
            <?php
            /**
             * Output product or post search form
             */
            if ('shop' === $type) {
                if (function_exists('get_product_search_form')) {
                    get_product_search_form();
                }
            } else {
                get_search_form();
            }
            ?>
            <span id="nav-search-loader" class="fa fa-circle-o-notch fa-spin"></span>
            <span id="nav-search-close" class="toggle-search fa lnr-cross"></span>
        </div><!-- .nav-search-form-container -->
    </div><!-- .nav-search-form -->
    <?php
}

/**
 * Output logo
 */
function prequelle_logo($echo = true) {

    $output = '';

    $logo_svg = apply_filters('prequelle_logo_svg', prequelle_get_theme_mod('logo_svg'));
    $logo_light = apply_filters('prequelle_logo_light', prequelle_get_theme_mod('logo_light'));
    $logo_dark = apply_filters('prequelle_logo_dark', prequelle_get_theme_mod('logo_dark'));

    if ($logo_svg || $logo_light || $logo_dark) {

        $output = '<div class="logo">
			<a href="' . esc_url(home_url('/')) . '" rel="home" class="logo-link">';

        if ($logo_svg) {
            $output .= '<img src="' . esc_url($logo_svg) . '" alt="logo-svg" class="svg logo-img logo-svg">';
        } else {
            if ($logo_light) {
                $output .= '<img src="' . esc_url($logo_light) . '" alt="logo-light" class="logo-img logo-light">';
            }

            if ($logo_dark) {
                $output .= '<img src="' . esc_url($logo_dark) . '" alt="logo-dark" class="logo-img logo-dark">';
            }
        }

        $output .= '</a>
			</div><!-- .logo -->';
    } else {
        $output .= '<div class="logo logo-is-text"><a class="logo-text" href="' . esc_url(home_url('/')) . '" rel="home">';

        $output .= get_bloginfo('name');

        $output .= '</a></div>';
    }

    if ($echo && $output) {
        echo prequelle_kses($output);
    }

    return prequelle_kses($output);
}

/**
 * Get the first embed video URL to use as video background
 *
 * Supports self hosted video and youtube
 */
function prequelle_entry_video_background() {

    if (prequelle_get_first_url()) {

        $video_url = prequelle_get_first_url();

        $img_src = get_the_post_thumbnail_url(get_the_ID(), 'large');

        if (preg_match('#youtu#', $video_url, $match)) {

            echo prequelle_youtube_video_bg($video_url, $img_src);
        } elseif (preg_match('#.vimeo#', $video_url, $match)) {

            echo prequelle_vimeo_bg($video_url);
        } elseif (preg_match('#.mp4#', $video_url, $match)) {

            echo prequelle_video_bg($video_url);
        }
    }
}

/**
 * Display social networks in author bio box
 */
function prequelle_author_socials($author_id = null) {

    if (!$author_id) {
        $author_id = get_the_author_meta('ID');
    }

    $name = get_the_author_meta('user_nicename', $author_id);
    $website = get_the_author_meta('user_url', $author_id);

    if (function_exists('wvc_get_team_member_socials')) {

        $services = wvc_get_team_member_socials();

        foreach ($services as $service) {

            $link = get_the_author_meta($service);
            $icon_slug = $service;

            $title_attr = sprintf(esc_html__('Visit %s\'s %s profile', 'prequelle'), $name, ucfirst($service));

            if ('email' === $service) {
                $icon_slug = 'envelope';
                $title_attr = sprintf(esc_html__('Send an email to %s', 'prequelle'), $name);
            }

            if ($link) {
                echo '<a target="_blank" title="' . esc_attr($title_attr) . '" href="' . esc_url($link) . '" class="author-link hastip"><i class="fa fa-' . $icon_slug . '"></i></a>';
            }
        }
    } else {

        $googleplus = get_the_author_meta('googleplus', $author_id);
        $twitter = get_the_author_meta('twitter', $author_id);
        $facebook = get_the_author_meta('facebook', $author_id);

        if ($facebook) {
            echo '<a target="_blank" title="' . esc_attr(sprintf(__('Visit %s\'s Facebook profile', 'prequelle'), $name)) . '" href="' . esc_url($facebook) . '" class="author-link"><i class="fa fa-facebook"></i></a>';
        }

        if ($twitter) {
            
        }

        if ($googleplus) {
            echo '<a target="_blank" title="' . esc_attr(sprintf(__('Visit %s\'s Google+ profile', 'prequelle'), $name)) . '" href="' . esc_url($googleplus) . '" class="author-link hastip"><i class="fa fa-google"></i></a>';
        }
    }

    if ($website) {
        echo '<a target="_blank" title="' . esc_attr(sprintf(__('Visit %s\'s website', 'prequelle'), $name)) . '" href="' . esc_url($website) . '" class="author-link hastip"><i class="fa fa-link"></i></a>';
    }
}

/**
 * Template tag to display the loader
 */
function prequelle_spinner() {

    $loading_logo = prequelle_get_inherit_mod('loading_logo');
    $loading_logo_animation = prequelle_get_inherit_mod('loading_logo_animation');
    $loading_animation_type = prequelle_get_inherit_mod('loading_animation_type');


    $show_logo = apply_filters('prequelle_display_loading_logo', $loading_logo);

    if ('none' === $loading_animation_type) {
        return;
    }
    ?>
    <div class="loader">
        <?php if ($show_logo) : ?>
            <?php ob_start(); ?>
            <img class="loading-logo <?php echo sanitize_html_class($loading_logo_animation); ?>" src="<?php echo esc_url($loading_logo); ?>" alt="<?php esc_attr_e(__('loading logo', 'prequelle')); ?>">
            <?php echo apply_filters('prequelle_loading_logo', ob_get_clean()); ?>
        <?php else : ?>
            <?php get_template_part(apply_filters('prequelle_spinners_folder', 'components/spinner/') . $loading_animation_type) ?>
        <?php endif; ?>
    </div><!-- #loader.loader -->
    <?php
}

/**
 * Search icon menu item
 */
function prequelle_search_menu_item($echo = true) {

    ob_start();
    ?>
    <span title="<?php esc_attr_e(__('Search', 'prequelle')); ?>" class="search-item-icon toggle-search"></span>
    <?php
    $search_item = ob_get_clean();


    if ($echo) {
        echo prequelle_kses($search_item);
    }

    return $search_item;
}

/**
 * Account menu item
 */
function prequelle_account_menu_item($echo = true) {

    if (!function_exists('wc_get_page_id')) {
        return;
    }

    $label = esc_html__('Sign In or Register', 'prequelle');
    $class = 'account-item-icon';

    if (is_user_logged_in()) {
        $label = esc_html__('My account', 'prequelle');
        $class .= ' account-item-icon-user-logged-in';
    } else {
        $label = esc_html__('Sign In or Register', 'prequelle');
        $class .= ' account-item-icon-user-not-logged-in';
    }

    if (WP_DEBUG) {
        $class .= ' account-item-icon-user-not-logged-in';
    }

    $account_url = get_permalink(wc_get_page_id('myaccount'));

    ob_start();
    ?>
    <!-- class <?php echo prequelle_sanitize_html_classes($class); ?> -->
    <a class="account-item-icon" href="<?php echo esc_url($account_url); ?>" title="<?php echo esc_attr($label); ?>">
    </a>
    <?php
    $account_item = ob_get_clean();

    if ($echo) {
        echo prequelle_kses($account_item);
    }

    return $account_item;
}

/**
 * Cart menu item
 */
function prequelle_cart_menu_item($echo = true) {

    if (!function_exists('wc_get_cart_url')) {
        return;
    }

    $product_count = WC()->cart->get_cart_contents_count();

    ob_start();
    ?>
    <a href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_attr_e(__('Cart', 'prequelle')); ?>" class="cart-item-icon toggle-cart">
        <span class="cart-icon-product-count"><?php echo absint($product_count); ?></span>
    </a>
    <?php
    $cart_item = ob_get_clean();

    if ($echo) {
        echo prequelle_kses($cart_item);
    }

    return $cart_item;
}

/**
 * Cart menu item for mobile menu
 */
function prequelle_cart_menu_item_mobile($echo = true) {

    if (!function_exists('wc_get_page_id')) {
        return;
    }

    $cta_content = prequelle_get_inherit_mod('menu_cta_content_type', 'search_icon');

    if ('shop_icons' !== $cta_content) {
        return;
    }

    $product_count = WC()->cart->get_cart_contents_count();
    ob_start();
    ?>
    <a href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_attr_e(__('Cart', 'prequelle')); ?>" class="cart-item-mobile toggle-cart-mobile">
        <span class="cart-label-mobile"><?php esc_html_e('Cart', 'prequelle'); ?>
            <span class="cart-icon-product-count"><?php echo absint($product_count); ?></span>
        </span>
    </a>
    <?php
    $cart_item = ob_get_clean();

    if ($echo) {
        echo prequelle_kses($cart_item);
    }

    return $cart_item;
}

/**
 * Wishlist menu item
 */
function prequelle_wishlist_menu_item($echo = true) {

    if (!function_exists('wolf_get_wishlist_url')) {
        return;
    }

    $wishlist_url = wolf_get_wishlist_url();
    ob_start();
    ?>
    <?php if (is_user_logged_in()) {?>
        <a href="<?php echo get_site_url(); ?>/shop/wishlist-new/" title="<?php esc_attr_e(__('My Likes', 'prequelle')); ?>" class="wishlist-item-icon"></a>
    <?php } else { ?>
        <a href="javascript;void();" title="<?php esc_attr_e(__('My Likes', 'prequelle')); ?>" class="wishlist-item-icon account-item-icon-user-not-logged-in"></a>
    <?php } ?>
    <?php
    $cart_item = ob_get_clean();

    if ($echo) {
        echo prequelle_kses($cart_item);
    }

    return $cart_item;
}

if (!function_exists('prequelle_cart_panel')) {

    /**
     * Cart menu item
     */
    function prequelle_cart_panel() {

        if (!function_exists('WC')) {
            return;
        }

        $cart_url = wc_get_cart_url();
        $checkout_url = wc_get_checkout_url();
        $items = WC()->cart->get_cart();

        ob_start();
        ?>
        <div class="cart-panel">
            <ul class="cart-item-list">
                <?php if ($items) : ?>
                    <?php foreach ($items as $cart_item_key => $cart_item) : ?>
                        <?php
                        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) :

                            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                            ?>
                            <li class="cart-item-list-item clearfix">
                                <span class="cart-item-image">
                                    <?php
                                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                                    if (!$product_permalink) {
                                        echo prequelle_kses($thumbnail);
                                    } else {
                                        printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail);
                                    }
                                    ?>
                                </span>
                                <span class="cart-item-details">
                                    <span class="cart-item-title">
                                        <?php
                                        if (!$product_permalink) {
                                            echo apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key) . '&nbsp;';
                                        } else {
                                            echo apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_title()), $cart_item, $cart_item_key);
                                        }
                                        ?>
                                    </span>
                                    <span class="cart-item-price">
                                        <?php echo esc_attr($cart_item['quantity']); ?> x
                                        <?php
                                        echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                                        ?>
                                    </span>

                                </span>
                            </li>
                        <?php endif; // endif visible ?>
                    <?php endforeach; ?>

                    <li class="cart-panel-subtotal">
                        <span class="cart-subtotal-label">
                            <?php esc_html_e('Subtotal', 'prequelle'); ?>:
                        </span>
                        <span class="cart-subtotal">
                            <?php echo WC()->cart->get_cart_subtotal(); ?>
                        </span>
                    </li>
                    <li class="cart-panel-buttons">
                        <a href="<?php echo wc_get_cart_url(); ?>">
                            <i class="fa cart-panel-cart-icon"></i>
                            <?php esc_html_e('View Cart', 'prequelle') ?>
                        </a>
                        <a href="<?php echo wc_get_checkout_url(); ?>">
                            <i class="fa cart-panel-checkout-icon"></i>
                            <?php esc_html_e('Checkout', 'prequelle'); ?>
                        </a>
                    </li>
                <?php else : ?>
                    <li class="cart-panel-no-product"><?php esc_html_e('No product in cart yet.', 'prequelle'); ?></li>
                <?php endif; ?>
            </ul><!-- .cart-item-list -->
        </div><!-- .cart-panel -->
        <?php
        $cart_item = ob_get_clean();

        return $cart_item;
    }

} // end function check

/**
 * Get audio embed content
 */
function prequelle_get_audio_embed_content($embed = true) {
    $audio = null;

    $pattern = get_shortcode_regex();
    $first_url = prequelle_get_first_url();

    $shortcodes = array(
        'audio',
        'playlist',
        'wolf_jplayer_playlist',
        'wolf_playlist',
        'wvc_playlist',
        'wvc_audio',
        'wvc_audio_embed',
        'mixcloud',
        'reverbnation',
        'soundcloud',
        'spotify',
    );

    if (prequelle_is_audio_embed_post()) {

        if ($embed) {
            $audio = wp_oembed_get($first_url);
        } else {
            $audio = $first_url;
        }
    } else {
        foreach ($shortcodes as $shortcode) {
            if (prequelle_shortcode_preg_match($shortcode)) {
                $match = prequelle_shortcode_preg_match($shortcode);
                if ($embed) {
                    $audio = do_shortcode($match[0]);
                } else {
                    $audio = $match[0];
                }
                break;
            }
        }
    }

    return $audio;
}

/**
 * Output primary desktop navigation
 */
function prequelle_primary_desktop_navigation() {
    get_template_part('components/menu/menu', 'desktop');
}

/**
 * Output primary vertical navigation
 */
function prequelle_primary_vertical_navigation() {
    get_template_part('components/menu/menu', 'vertical');
}

/**
 * Output secondary desktop navigation
 */
function prequelle_secondary_desktop_navigation() {
    get_template_part('components/menu/menu', 'secondary');
}

/**
 * Output primary mobile navigation
 */
function prequelle_primary_mobile_navigation() {
    get_template_part('components/menu/menu', 'mobile');
}

/**
 * Hamburger icon
 */
function prequelle_hamburger_icon($class = 'toggle-mobile-menu') {

    if ('toggle-side-panel' === $class) {
        $title_attr = esc_html__('Side Panel', 'prequelle');
    } else {
        $title_attr = esc_html__('Menu', 'prequelle');
    }

    ob_start();
    ?>
    <a class="hamburger-icon <?php echo esc_attr($class); ?>" href="#" title="<?php echo esc_attr($title_attr); ?>">
        <span class="line line-1"></span>
        <span class="line line-2"></span>
        <span class="line line-3"></span>
    </a>
    <?php
    $html = ob_get_clean();

    echo apply_filters('wolfthemes_hamburger_icon', wp_kses($html, array(
        'a' => array(
            'class' => array(),
            'href' => array(),
            'title' => array(),
        ),
        'span' => array(
            'class' => array(),
        ),
            )), $class, $title_attr);
}

/**
 * Returns page title outside the loop
 *
 * @return string
 */
function prequelle_output_post_title() {

    if (is_author() && class_exists('Wolf_Photos')) {

        get_template_part('components/post/author', 'heading');
        rewind_posts();
    } elseif (prequelle_get_post_title()) {

        $title = prequelle_get_post_title();
        $title_inline_style = '';
        $title_class = 'post-title';

        /* Big text & custom header font */
        if (is_single() || is_page()) {

            $bigtext = get_post_meta(get_the_ID(), '_post_hero_title_bigtext', true);
            $font_family = get_post_meta(get_the_ID(), '_post_hero_title_font_family', true);
            $font_transform = get_post_meta(get_the_ID(), '_post_hero_title_font_transform', true);

            if ($bigtext) {
                $title_class .= ' wvc-bigtext';
            }

            if ($font_family) {
                $title_inline_style .= 'font-family:' . esc_attr($font_family) . ';';
            }

            if ($font_transform) {
                $title_class .= ' text-transform-' . esc_attr($font_transform);
            }
        }

        $output = '<h1 itemprop="name" style="' . prequelle_esc_style_attr($title_inline_style) . '" class="' . prequelle_sanitize_html_classes($title_class) . '"><span>' . sanitize_text_field(apply_filters('prequelle_page_title', $title)) . '</span></h1>';

        echo prequelle_kses($output);
    }
}

add_action('prequelle_hero_title', 'prequelle_output_post_title');

/**
 * Returns page title outside the loop
 *
 * @return string
 */
function prequelle_get_post_title() {

    $title = get_the_title();

    if (prequelle_is_home_as_blog()) {
        $title = get_bloginfo('description');
    }

    /* Main condition not 404 and not woocommerce page */
    if (!is_404() && !prequelle_is_woocommerce_page()) {

        if (prequelle_is_blog()) {

            if (is_category()) {

                $title = single_cat_title('', false);
            } elseif (is_tag()) {

                $title = single_tag_title('', false);
            } elseif (is_author()) {

                $title = get_the_author();
            } elseif (is_day()) {

                $title = get_the_date();
            } elseif (is_month()) {

                $title = get_the_date('F Y');
            } elseif (is_year()) {

                $title = get_the_date('Y');

                /* is blog index */
            } elseif (prequelle_is_blog_index() && !prequelle_is_home_as_blog()) {

                $title = get_the_title(get_option('page_for_posts'));
            }
        } elseif (is_tax()) {

            $queried_object = get_queried_object();

            if (is_object($queried_object) && isset($queried_object->name)) {
                $title = $queried_object->name;
            }
        } elseif (isset($_GET['s']) && isset($_GET['post_type']) && 'attachment' === $_GET['post_type']) {

            $s = esc_attr($_GET['s']);

            $title = sprintf(esc_html__('Search results for %s', 'prequelle'), '<span class="search-query-text">&quot;' . esc_html($s) . '&quot;</span>');
        } elseif (is_single()) {

            $title = get_the_title();
        }
    } elseif (prequelle_is_woocommerce_page()) { // shop title
        if (is_shop() || is_product_taxonomy()) {

            $title = ( function_exists('woocommerce_page_title') ) ? woocommerce_page_title(false) : '';
        } else {
            $title = get_the_title();
        }
    }

    if (is_search()) {
        $title = sprintf(esc_html__('Search results for %s', 'prequelle'), '<span class="search-query-text">&quot;' . esc_html(get_search_query()) . '&quot;</span>');
    }

    return $title;
}

/**
 * Return the subheading of a post
 *
 * @param int $post_id
 * @return string
 */
function prequelle_get_the_subheading($post_id = null) {

    if (!$post_id) {
        $post_id = prequelle_get_the_ID();
    }

    return get_post_meta($post_id, '_post_subheading', true);
}

/**
 * Fire add to wishlist function
 *
 * If Wolf WooCommerce Wishlist is installed, it will output the add to wishlist button
 */
function prequelle_add_to_wishlist() {
    if (function_exists('wolf_add_to_wishlist')) {
        wolf_add_to_wishlist();
    }
}

/**
 * Display slideshow background
 *
 * @param array $args
 * @return string $output
 */
function prequelle_entry_slider($args = array()) {

    extract(wp_parse_args($args, array(
        'slideshow_image_size' => 'prequelle-slide',
        'slideshow_img_ids' => '',
        'slideshow_speed' => 4000,
    )));

    $output = '';

    if ('' == $slideshow_img_ids) {

        $slideshow_img_ids = prequelle_get_post_gallery_ids();
    }

    $slideshow_img_ids = prequelle_list_to_array($slideshow_img_ids);

    if (array() != $slideshow_img_ids) {

        $slideshow_img_ids = array_slice($slideshow_img_ids, 0, 3); // first 3 ids only

        $output .= '<div data-slideshow-speed="' . absint($slideshow_speed) . '" class="entry-slider flexslider"><ul class="slides">';

        foreach ($slideshow_img_ids as $image_id) {

            $output .= '<li class="slide">';
            $output .= wp_get_attachment_image($image_id, $slideshow_image_size);
            $output .= '</li>';
        }

        $output .= '</ul></div>';
    }

    return $output;
}

/**
 * Filter password form
 */
function prequelle_get_the_password_form($output) {

    global $post;
    $post = get_post($post);
    $label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );

    $output = '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" class="post-password-form clearfix" method="post">
	<p>' . esc_html__('This content is password protected. To view it please enter your password below:', 'prequelle') . '</p>
	<p><label for="' . $label . '">' . esc_html__('Password:', 'prequelle') . '</label> <input name="post_password" id="' . $label . '" type="password"> <input class="password-submit" type="submit" name="Submit" value="' . esc_attr_x('Enter', 'post password form', 'prequelle') . '" /></p></form>
	';

    return $output;
}

add_filter('the_password_form', 'prequelle_get_the_password_form');

/**
 * Excerpt more
 * Render "Read more" link text differenttly depending on post format
 *
 * @return string
 */
function prequelle_more_text() {

    $text = '<span>' . esc_html__('Continue reading', 'prequelle') . '</span>';

    return apply_filters('prequelle_more_text', $text);
}

/**
 * Output "more" button
 */
function prequelle_more_button() {

    return '<a rel="bookmark" class="' . apply_filters('prequelle_more_link_button_class', 'more-link') . '" href="' . get_permalink() . '">' . prequelle_more_text() . '</a>';
}

/**
 * Add custom class to the more link
 *
 * @param string $link
 * @param string $text
 */
function prequelle_add_more_link_class($link, $text) {

    return str_replace(
            'more-link', apply_filters('prequelle_more_link_button_class', 'more-link'), $link
    );
}

add_action('the_content_more_link', 'prequelle_add_more_link_class', 10, 2);

/**
 * Get exceprt lenght
 */
function prequelle_get_excerpt_lenght() {
    return absint(apply_filters('prequelle_excerpt_length', 14));
}

/**
 * Excerpt length hook
 * Set the number of character to display in the excerpt
 *
 * @param int $length
 * @return int
 */
function prequelle_excerpt_length($length) {

    if (is_single()) {
        $lenght = 999999;
    } else {
        $lenght = prequelle_get_excerpt_lenght();
    }

    return $length;
}

add_filter('excerpt_length', 'prequelle_excerpt_length');

/**
 * Excerpt "more" link
 *
 * @param string $more
 * @return string
 */
function prequelle_excerpt_more($more) {

    return '...<p>' . prequelle_more_button() . '</p>';
}

add_filter('excerpt_more', 'prequelle_excerpt_more');

/**
 * Filter previous comments link
 */
function prequelle_comments_link_prev_class($atts) {

    return 'class="pagination-icon-prev"';
}

add_filter('previous_comments_link_attributes', 'prequelle_comments_link_prev_class');

/**
 * Filter next comments link
 */
function prequelle_comments_link_next_class($atts) {
    return 'class="pagination-icon-next"';
}

add_filter('next_comments_link_attributes', 'prequelle_comments_link_next_class');

/**
 * Get one page menu
 */
function prequelle_one_page_menu($context = 'desktop', $vertical = false) {

    if (!is_page()) {
        return;
    }

    $output = '';

    global $post;

    $content = $post->post_content;
    $pattern = get_shortcode_regex();

    if (preg_match_all('/' . $pattern . '/s', $content, $matches) && array_key_exists(2, $matches) && in_array('vc_row', $matches[2])
    ) {

        $rows = $matches[0];
        $output .= '<div class="menu-one-page-menu-container">';

        if ('mobile' === $context) {
            $output .= '<ul id="site-navigation-primary-mobile" class="nav-menu nav-menu-mobile">';
        } else {

            $menu_class = ( $vertical ) ? 'nav-menu-vertical' : 'nav-menu-desktop';

            $output .= '<ul id="site-navigation-primary-desktop" class="nav-menu ' . esc_attr($menu_class) . '">';
        }

        $scroll_link_class = ( prequelle_do_fullpage() ) ? 'wvc-fp-nav' : 'scroll';

        foreach ($rows as $row) {

            $reg_ex = '[a-zA-ZŽžšŠÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçČčÌÍÎÏìíîïÙÚÛÜùúûüÿÑñйА-яц一-龯0-9 #!?$@]+';
            if (preg_match('/row_name="' . $reg_ex . '"/', $row, $match_row_name)) {

                if (isset($match_row_name[0])) {
                    $row_name = str_replace(array('row_name="', '"'), '', $match_row_name[0]);
                    $anchor = sanitize_title($row_name);
                    $output .= '<li class="menu-item menu-item-type-custom menu-item-object-custom">';

                    $output .= '<a href="#' . esc_attr($anchor) . '" class="menu-link ' . esc_attr($scroll_link_class) . '">';

                    $output .= '<span class="menu-item-inner">';
                    $output .= '<span class="menu-item-text-container" itemprop="name">';
                    $output .= $row_name;
                    $output .= '</span>';
                    $output .= '</span>';
                    $output .= '</a>';
                    $output .= '</li>';
                }
            }
        }
        $output .= '</ul></div>';
    }

    return $output;
}

if (!function_exists('prequelle_entry_tags')) {

    /**
     * Get the entry tags
     */
    function prequelle_entry_tags($echo = true) {

        $output = '';

        if (get_the_tag_list()) {
            ob_start();
            ?>
            <span class="entry-tags-list">
                <?php echo apply_filters('prequelle_entry_tag_list_icon', '<span class="meta-icon hashtag"></span>'); ?>
                <?php echo get_the_tag_list('', apply_filters('prequelle_entry_tag_list_separator', ' ')); ?>
            </span>
            <?php
            $output = ob_get_clean();

            if ($echo) {
                echo wp_kses($output, array(
                    'span' => array(
                        'class' => array(),
                    ),
                    'a' => array(
                        'class' => array(),
                        'href' => array(),
                        'rel' => array(),
                    ),
                ));
            }

            return $output;
        }
    }

}

if (!function_exists('prequelle_post_thumbnail')) {

    /**
     * Post thumbnail
     */
    function prequelle_post_thumbnail($size = '') {

        $thumbnail = get_the_post_thumbnail('', $size);

        if (!$thumbnail && prequelle_is_instagram_post()) {
            $thumbnail = prequelle_get_instagram_image(prequelle_get_first_url());
        }

        return $thumbnail;
    }

}

if (!function_exists('prequelle_justified_post_thumbnail')) {

    /**
     * Post thumbnail
     */
    function prequelle_justified_post_thumbnail($size = 'prequelle-photo', $post_id = '', $echo = true) {

        $thumbnail = '';
        $post_id = ( $post_id ) ? $post_id : get_post_thumbnail_id();
        $src = wp_get_attachment_image_src($post_id, $size);
        $src = $src[0];
        $image_alt = get_post_meta($post_id, '_wp_attachment_image_alt', true);

        $metadata = wp_get_attachment_metadata($post_id);
        $width = '';
        $height = '';

        if (isset($metadata['sizes'][$size])) {
            $width = $metadata['sizes'][$size]['width'];
            $height = $metadata['sizes'][$size]['height'];
        }

        ob_start();
        ?>
        <img
            class="lazy-hidden"
            width="<?php echo esc_attr($width); ?>"
            height="<?php echo esc_attr($height); ?>"
            src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/blank.gif'); ?>"
            title="<?php echo esc_attr(get_the_title()); ?>"
            alt="<?php echo esc_attr($image_alt); ?>"
            data-src="<?php echo esc_url($src); ?>"
            >
            <?php
            $thumbnail = ob_get_clean();

            if ($echo) {
                echo prequelle_kses($thumbnail);
            }

            return $thumbnail;
        }

    }

    /**
     * Metro entry title
     *
     * Use for the metro_modern_alt only ATM
     */
    function prequelle_post_grid_entry_title($title = null) {
        if (!$title) {
            $title = get_the_title();
        }

        $format = get_post_format();
        $the_permalink = ( 'link' === $format && prequelle_get_first_url() ) ? prequelle_get_first_url() : get_the_permalink();

        $product_id = get_post_meta(get_the_ID(), '_post_wc_product_id', true);
        if ($product_id && 'publish' == get_post_status($product_id)) {
            $format = 'product';
        }

        if (!prequelle_is_short_post_format() && 'product' !== $format) :
            ?>
        <span class="date-label">
            <?php if (is_sticky()) : ?>
                <?php esc_html_e('Featured', 'prequelle'); ?>
            <?php else : ?>
                <?php prequelle_entry_date(); ?>
            <?php endif; ?>
        </span>
    <?php endif; ?>
    <span class="entry-summary">
        <?php if ('video' === $format) : ?>
            <?php if (prequelle_get_first_video_url()) : ?>
                <a href="<?php echo prequelle_get_first_video_url(); ?>" class="post-play-video-icon lightbox-video">
                <?php endif; ?>
                <span class="format-label"><?php esc_html_e('Watch', 'prequelle'); ?></span>
                <?php if (prequelle_get_first_video_url()) : ?>
                </a>
            <?php endif; ?>
            <br>
        <?php elseif ('audio' === $format) : ?>
            <?php if (prequelle_get_first_mp3_url()) : ?>
                <a title="<?php esc_attr_e(__('Play audio', 'prequelle')); ?>" href="<?php echo prequelle_get_first_mp3_url(); ?>" class="post-play-audio-icon loop-post-play-button">
                <?php endif; ?>
                <span class="format-label"><?php esc_html_e('Listen', 'prequelle'); ?></span>
                <?php if (prequelle_get_first_mp3_url()) : ?>
                </a>
                <audio class="loop-post-player-audio" id="<?php echo esc_attr(uniqid('loop-post-player-audio-')); ?>" src="<?php echo esc_url(prequelle_get_first_mp3_url()); ?> "></audio>
            <?php endif; ?>
            <br>

            <?php
        elseif ('product' === $format) :
            $product = wc_get_product($product_id);
            $permalink = get_permalink($product->get_id());
            $price = $product->get_price_html();
            $button_class = apply_filters('prequelle_post_product_button', 'button post-product-button');
            ?>
            <a href="<?php echo esc_url($the_permalink); ?>">
                <h2 class="entry-title"><?php echo prequelle_kses($title); ?></h2>
            </a>
            <?php if ($price) : ?>
                <span class="post-product-price">
                    <?php echo prequelle_kses($price); ?>
                </span>
            <?php endif; ?>
            <a class="<?php echo prequelle_sanitize_html_classes($button_class); ?>" href="<?php echo esc_url($permalink); ?>"><?php esc_html_e('Shop Now', 'prequelle'); ?></a>
        <?php endif; ?>
        <?php if ('product' !== $format) : ?>
            <a href="<?php echo esc_url($the_permalink); ?>">
                <h2 class="entry-title"><?php echo prequelle_kses($title); ?></h2>
                <?php if (!prequelle_is_short_post_format() && 'video' !== $format && 'audio' !== $format) : ?>
                    <span class="view-post"><?php esc_html_e('View post', 'prequelle'); ?></span>
                <?php endif; ?>
            </a>
        <?php endif ?>
    </span>
    <?php
}

/**
 * Returns the content for dtandard post layout without the featured media if any
 */
function prequelle_content($more_text) {
    global $post;

    $the_content = '';

    if (!is_single() && $post->post_excerpt || is_search()) {

        $the_content = get_the_excerpt();
    } else {

        $media_to_filter = '';
        $content = get_the_content($more_text);

        if (prequelle_is_instagram_post()) {
            $media_to_filter = prequelle_get_first_url();
        }

        if (prequelle_is_video_post()) {
            $media_to_filter = prequelle_get_first_video_url();
        }

        if ($media_to_filter) {

            $content = str_replace($media_to_filter, '', $content);
        }

        $the_content = apply_filters('the_content', $content);
    }

    return $the_content;
}
