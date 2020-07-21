<?php namespace Premmerce\UrlManager\Frontend;

use Premmerce\UrlManager\Admin\Settings;
use WP_Post;
use WP_Term;

/**
 * Class Frontend
 *
 * @package Premmerce\UrlManager
 */
class Frontend
{
    const WOO_PRODUCT = 'product';

    /**
     * Frontend constructor.
     */
    public function __construct()
    {
        $options = get_option(Settings::OPTIONS);

        if (! empty($options['product'])) {
            add_action('request', array($this, 'replaceRequest'), 11);
        }

        if (! empty($options['canonical'])) {
            add_action('wp_head', array($this, 'addCanonical'));
        }

        #premmerce_clear
        if (premmerce_wpm_fs()->is__premium_only()) {
            #/premmerce_clear
            if (! empty($options['redirect'])) {
                add_action('template_redirect', array($this, 'redirectCanonical__premium_only'));
            }
            #premmerce_clear
        }
        #/premmerce_clear
    }

    /**
     * Replace request if product found
     *
     * @param array $request
     *
     * @return array
     */
    public function replaceRequest($request)
    {
        global $wp, $wpdb;

        $url = $wp->request;

        if (! empty($url)) {
            $url = explode('/', $url);

            $slug = array_pop($url);

            $replace = array();

            if ($slug === 'feed') {
                $replace['feed'] = $slug;
                $slug            = array_pop($url);
            }

            if ($slug === 'amp') {
                $replace['amp'] = $slug;
                $slug           = array_pop($url);
            }

            $commentsPosition = strpos($slug, 'comment-page-');

            if ($commentsPosition === 0) {
                $replace['cpage'] = substr($slug, strlen('comment-page-'));
                $slug             = array_pop($url);
            }

            $sql = "SELECT COUNT(ID) as count_id FROM {$wpdb->posts} WHERE post_name = %s AND post_type = %s";

            $query = $wpdb->prepare($sql, array($slug, self::WOO_PRODUCT));

            $num = intval($wpdb->get_var($query));

            if ($num > 0) {
                $replace['page']      = '';
                $replace['post_type'] = self::WOO_PRODUCT;
                $replace['product']   = $slug;
                $replace['name']      = $slug;

                return $replace;
            }
        }

        return $request;
    }

    public function addCanonical()
    {
        //avoid canonicals duplication
        if (! defined('WPSEO_VERSION') && ! (get_queried_object() instanceof WP_Post)) {
            $canonical = apply_filters('premmerce_permalink_manager_canonical', $this->getCanonical());

            if (! empty($canonical)) {
                echo '<link rel="canonical" href="' . esc_url($canonical) . '" />' . "\n";
            }
        }
    }

    public function redirectCanonical__premium_only()
    {
        global $wp;

        if (! is_product() && ! is_product_category() && ! is_product_tag()) {
            return;
        }

        $isAmp = (false !== get_query_var('amp', false));

        if (is_product() && $isAmp) {
            return;
        }

        /** @var WP_Post $post */
        $post = get_queried_object();

        if ($post instanceof WP_Post && $post->post_status !== 'publish') {
            return;
        }

        $canonical = $this->getCanonical(true);

        $location = null;

        if ($canonical) {
            $query    = empty($_SERVER['QUERY_STRING']) ? '' : '?' . $_SERVER['QUERY_STRING'];
            $location = $canonical . $query;
        }

        $current_url = esc_url(home_url(add_query_arg(array(), urldecode($wp->request))));

        if (trim(urldecode($canonical), '/') == trim($current_url, '/')) {
            $location = null;
        }

        $location = apply_filters('premmerce_permalink_manager_redirect_location', $location);

        if ($location) {
            wp_safe_redirect($location, 301);
            die;
        }
    }

    private function getCanonical($useCommentsPagination = false)
    {
        global $wp_rewrite;

        $qo = get_queried_object();

        $canonical = null;

        if ($qo instanceof WP_Term) {
            $canonical = get_term_link($qo);
            $paged     = get_query_var('paged');

            if ($paged > 1) {
                $canonical = trailingslashit($canonical) . trailingslashit($wp_rewrite->pagination_base) . $paged;
            }
        } elseif ($qo instanceof WP_Post) {
            $canonical = get_permalink($qo);

            if ($useCommentsPagination) {
                $page = get_query_var('cpage');

                if ($page > 1) {
                    $canonical = trailingslashit($canonical) . $wp_rewrite->comments_pagination_base . '-' . $page;
                }
            }
        }


        if ($canonical) {
            return user_trailingslashit($canonical);
        }
    }
}
