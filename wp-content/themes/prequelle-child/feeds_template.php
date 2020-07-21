<?php


/*newwwwwwwwwwwwwwwwww
 *  Template Name: Feeds Template
 *  Developer: Rehan Aziz
 *  Company: Explore Logics
 *  Dated: 30-08-2018 02:02 AM 
 */
?>
<?php get_header(); ?>
<div id="primary" class="content-area myScroll">

    <?php
    $args = array(
//        'post_type' => array('released_feeds', 'general_feeds', 'restocked_feeds'),
        'post_type' => array('general_feeds'),
        'posts_per_page' => 100,
    );
    $feedsCount = 0;
    $loop = new WP_Query($args);
    while ($loop->have_posts()) : $loop->the_post();
        global $product;
        global $post;
            $originalPrice = '';
            $salePrice = '';
            $couponCode = '';
        if (get_post_type() == 'released_feeds') {
            $typeToDisplay = 'released';
        } elseif (get_post_type() == 'restocked_feeds') {
            $typeToDisplay = 'restocked';
        }elseif (get_field('sale_price', get_the_ID()) != null) {
            $typeToDisplay = '<span style="color:green"><b>On Sale:</b></span>';
            $originalPrice = '<span style="color:gray"><b><s>'.get_field('original_price', get_the_ID()).'</s></b></span>';
            $salePrice = '<span style="color:green"><b>'.get_field('sale_price', get_the_ID()).'</b></span>';
        } else {
            $typeToDisplay = get_field('feed_type', get_the_ID());
        }
        if (get_field('promo/coupon_code', get_the_ID()) != null) {
            $name = get_field('promo/coupon_code', get_the_ID());
            $couponCode = '<b style="
            margin-left: -10px !important;
        ">Copy Code:</b> 
        
        <button class="btn ref-copy-btn"
            data-clipboard-text="' . esc_attr($name).'"
            onclick="copyCoupon();" style="border-radius: 5px;
            font-size: 10px;
            letter-spacing: 0.1em;
            line-height: 0.556;
            font-weight: bold;
            border: 2px #555555;
            background-color: white;
            color: black;
            border-style: dashed;
            padding: 1px 6px 1px 9px;
            position: relative;
            height: 19px;
            top: -3px;">'.get_field('promo/coupon_code', get_the_ID()).'</button>';
        }
        
        $product_id = get_field('product', get_the_ID());
        $feedsCount++;
        $number = ceil($feedsCount / 10);
        //echo '<br /><a href="'.get_permalink().'">' . woocommerce_get_product_thumbnail().' '.get_the_title().'</a>';
        ?>
        
        <div class="feed-container notifications-block  <?php echo $number; ?>">
            <div class="feed-img">
                <?php
                echo '<a target="_blank" href="' . get_field('title_custom_link', get_the_ID()) . '">' . get_the_post_thumbnail($product_id) . '</a>'
                ?>
            </div>
            <div class="feed-content">
                <p class="feeds-title">
                    <?php echo '<a target="_blank" href="' . get_field('title_custom_link', get_the_ID()) . '">' . get_the_title() . '</a>';
                    ?>
                </p>
                <p class="feeds-details">
                <span class="sale_price" style="
    margin-right: 0px !important;
"><?php echo $typeToDisplay; echo $originalPrice; echo $salePrice;?></span>
                <i class="fa fa-clock-o"></i><span class="span-time"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ' . __('ago'); ?></span>
                <span><?php echo get_field('retailer_name', get_the_ID()) ? '<span class="via-txt-color">via</span> ' . get_field('retailer_name', get_the_ID()) : ''; ?></span>
                <?php echo $couponCode;?>
                 |<a href="<?php echo get_permalink($product_id); ?>">more</a>
                 <!-- <?php echo $couponCode;?> -->
                 </p>
            </div>
        </div>
        <?php
    endwhile;

    wp_reset_query();
    ?>

    <!-- <div class="text-center image-loading-div">
        <img style="margin: 40px;" src="http://138.197.64.28/wp-content/plugins/infinite-ajax-scrolling-for-woocommerce/assets/img/loader.gif" />
    </div>  -->
</div>
<script>
    // var notifybolocks = parseInt(<?php echo $feedsCount; ?>);
    // var pages = Math.ceil(notifybolocks / 10);
    // for (var i = 2; i < (pages + 1); i++) {
    //     jQuery('.notifications-block' + i).hide();
    // }
    // var j = 2;
    // $(window).scroll(function () {
    //     wH = $('.site-infos').offset().top,
    //             wS = $(this).scrollTop();
    //     console.log('#################');
    //     console.log(wH - wS);
    //     console.log(j);
    //     console.log(pages);
    //     console.log($(window).height());
    //     console.log('#################');
    //     if (wH - wS < $(window).height() && (!(j > pages))) {
    //         jQuery('.image-loading-div').show();
    //         setTimeout(function () {
    //             jQuery('.image-loading-div').hide();
    //             jQuery('.notifications-block' + j).show();
    //             j++;
    //         }, 500);
    //     }
    // });
    var counter=0;
        $(window).scroll(function () {
            if ($(window).scrollTop() == $(document).height() - $(window).height() && counter < 50) {
                appendData();
            }
        });
        function appendData() {
            console.log('111');
            var html = '';
            // for (i = 0; i < 10; i++) {
            //     html += '<p class="dynamic">Dynamic Data :  This is test data.<br />Next line.</p>';
            // }
            $('.myScroll').append(html);
			counter++;
			
			// if(counter==50)
			// $('.myScroll').append('<img style="margin: 40px;" src="http://138.197.64.28/wp-content/plugins/infinite-ajax-scrolling-for-woocommerce/assets/img/loader.gif">');
        }
</script>
<?php get_footer(); ?>