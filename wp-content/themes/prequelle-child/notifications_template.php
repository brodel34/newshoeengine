<?php
/*
*new notification
*/
/*
 *  Template Name: Notifications Template
 *  Developer: Rehan Aziz
 *  Company: Explore Logics
 *  Dated: 12-08-2018 12:02 AM 
 */
global $wpdb;

  $user_id = get_current_user_id();

  $wished_products = $wpdb->get_results( "SELECT product_id FROM wp_tinvwl_items WHERE author=$user_id" );
  
  foreach ($wished_products as $value) 
    $array[] = $value->product_id;
 
global $wp_query;
if (isset($wp_query->query_vars['page'])) {
    $page = $wp_query->query_vars['page'];
} else {
    $page = 1;
}
?>
<?php 
get_header();
 ?>

<div id="primary" class="content-area">
    <?php
    // $product_ids = www_get_wishlist_product_ids();
    $product_ids = $array;

//    $args1 = array(
//        'post_type' => array('general_feeds'),
//        'posts_per_page' => 1000,
//        'meta_query' => array(
//            array(
//                'key' => 'product',
//                'value' => $product_ids,
//                'compare' => 'IN'
//            )
//        )
//    );
//    $query1 = new WP_Query($args1);
//    $total = $query1->found_posts;
//    $totalPages = (int) $total / 10;
    $args = array(
        'post_type' => array('general_feeds'),
        'posts_per_page' => 1000,
//        'offset' => ($page - 1) * 10,
        'meta_query' => array(
            array(
                'key' => 'product',
                'value' => $product_ids,
                'compare' => 'IN'
            )
        )
    );
    
    $user_product_ids_timings = get_user_meta(get_current_user_id(), 'shoe_engine_wc_wishlisttiming');
    if (count($user_product_ids_timings) > 0) {
        $user_product_ids_timings = $user_product_ids_timings[0];
    }
    $notificationsArry = [];
    $loop = new WP_Query($args);
    $notify = 0;
    ?> 
    <?php
    while ($loop->have_posts()) : $loop->the_post();
        global $product;
        global $post;
        $published_at_bef = strtotime($post->post_date);
        $published_at = date("Y-m-d h:i:s",$published_at_bef);
        // print_r($ssss);
        // die();
        // echo '<pre>';
        // print_r($published_at);
        // die();
        if (get_post_type() == 'released_feeds') {
            $typeToDisplay = 'released';
        } elseif (get_post_type() == 'restocked_feeds') {
            $typeToDisplay = 'restocked';
        } else {
            $typeToDisplay = get_field('feed_type', get_the_ID());
        }
        $product_id = get_field('product', get_the_ID());
        $wished_products_time_ts = $wpdb->get_results( "SELECT date FROM wp_tinvwl_items WHERE author=$user_id" );
        foreach ($wished_products_time_ts as $value2) 
        $wished_products_time = $value2->date;
// //   echo '<pre>';
// //   print_r($wished_products_time);
// //   die();
//         echo '<pre>';
//   print_r($array22);
//   print_r('          ');
//   print_r($ssss);
//   if($array22 > $ssss){
//       die('ifffff');

//   }elseif($array22 < $ssss){
//       die('elseiffffff');

//   }
//   else{
//       die('elseeeeeee');

//   }
//   die();
        if ( $wished_products_time < $published_at) {
            $notify++;
            array_push($notificationsArry, get_the_ID());
            $number = ceil($notify / 10);
            //echo '<br /><a href="'.get_permalink().'">' . woocommerce_get_product_thumbnail().' '.get_the_title().'</a>';
            ?>
            <div class="feed-container notifications-block<?php echo $number; ?>">
                <div class="feed-img">
                    <?php
                    echo '<a target="_blank" href="' . get_field('title_custom_link', get_the_ID()) . '">' . get_the_post_thumbnail($product_id) . '</a>';
                    ?>
                </div>
                <div class="feed-content">
                    <p class="feeds-title">
                        <?php echo '<a target="_blank" href="' . get_field('title_custom_link', get_the_ID()) . '">' . get_the_title() . '</a>';
                        ?>
                    </p>
                    <p class="feeds-details"><span><?php echo $typeToDisplay; ?></span> <i class="fa fa-clock-o"></i><span class="span-time"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ' . __('ago'); ?></span> <span><?php echo get_field('retailer_name', get_the_ID()) ? '<span class="via-txt-color">via</span> ' . get_field('retailer_name', get_the_ID()) : ''; ?></span> |<a href="<?php echo get_permalink($product_id); ?>">more</a></p>
                </div>
            </div>
            <?php
        }
    endwhile;
    ?>
    <!--    <nav class="woocommerce-pagination">
            <ul class="page-numbers">
    <?php
    // for ($i = 0; $i < $totalPages; $i++) {
    //    if ($i + 1 == $page) {
    ?>
                        <li><span aria-current="page" class="page-numbers current"><?php // echo $i + 1                               ?></span></li>
    <?php // } else { ?>
                        <li><a class="page-numbers internal-link" href="http://demoapps.devbatch.com/shoeengine/notifications/<?php echo $i + 1 ?>/"><?php echo $i + 1 ?></a></li>
    <?php
    //   }
    // }
    ?>
                <li><a class="next page-numbers internal-link" href="http://demoapps.devbatch.com/shoeengine/notifications/<?php echo $page + 1; ?>/"><i class="pagination-icon-next"></i></a></li>
            </ul>
        </nav>-->
    <?php
    if ($notify == 0) {
        ?>
        <div style="
             text-align: center;
             padding: 100px;
             font-size: 27px;">
            Like Products to Receive Notifications.
        </div>
        <?php
    } else {
        ?>
      <!-- <div class="text-center image-loading-div">
            <img style="margin: 40px;" src="http://138.197.64.28/wp-content/plugins/infinite-ajax-scrolling-for-woocommerce/assets/img/loader.gif" />
        </div>  -->
        <?php
    }
    // add_user_meta( get_current_user_id(), 'user_readed_notification', serialize($notificationsArry));
    update_user_meta(get_current_user_id(), 'user_readed_notification', serialize($notificationsArry));
    // echo "<script type='text/javascript'>
    //    window.location=document.location.href;
    //    </script>";
    wp_reset_query();
    ?>

</div>
<script>
    var notifybolocks = parseInt(<?php echo $notify; ?>);
    var pages = Math.ceil(notifybolocks / 10);
    for (var i = 2; i < (pages + 1); i++) {
        jQuery('.notifications-block' + i).hide();
    }
    var j = 2;
    $(window).scroll(function () {
        wH = $('.site-infos').offset().top,
                wS = $(this).scrollTop();
        console.log('#################');
        console.log(wH - wS);
        console.log(j);
        console.log(pages);
        console.log($(window).height());
        console.log('#################');
        if (wH - wS < $(window).height() && (!(j > pages))) {
            jQuery('.image-loading-div').show();
            setTimeout(function () {
                jQuery('.image-loading-div').hide();
                jQuery('.notifications-block' + j).show();
                j++;
            }, 500);
        }
    });
</script>
<?php get_footer(); ?>