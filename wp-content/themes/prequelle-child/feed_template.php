<?php /* Template Name: Feed Template */ ?>
<?php get_header(); ?>
<div id="primary" class="content-area">
    <?php  
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 10,
        'product_cat'    => 'air-jordan'
    );

    $loop = new WP_Query( $args );

    while ( $loop->have_posts() ) : $loop->the_post();
        global $product;
        global $post;
        //echo '<br /><a href="'.get_permalink().'">' . woocommerce_get_product_thumbnail().' '.get_the_title().'</a>';
        ?>
    <div class="feed-container">
        <div class="feed-img">
            <?php
            echo '<a href="'.get_permalink().'">' . woocommerce_get_product_thumbnail().'</a>';
            ?>
        </div>
        <div class="feed-content">
            <p>
            <?php echo '<a href="'.get_permalink().'">' .get_the_title().'</a>';
            $cate = get_queried_object();
$cateID = $cate->term_id;
echo $cateID;
            ?>
            </p>
        </div>
    </div>
        <?php
    endwhile;

    wp_reset_query();
?>
 
</div>
<?php get_footer(); ?>