<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing divs of the main content and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
?>
						</div><!-- .content-wrapper -->
					</div><!-- .content-inner -->
					<?php
						/**
						 * prequelle_after_content
						 */
						do_action( 'prequelle_before_footer_block' );
					?>
				</div><!-- .site-content -->
			</div><!-- #main -->
		</div><!-- #page-content -->
		<div class="clear"></div>
		<?php
			/**
			 * prequelle_footer_before hook
			 */
			do_action( 'prequelle_footer_before' );
		?>
		<?php
			if ( 'hidden' !== prequelle_get_inherit_mod( 'footer_type' ) && is_active_sidebar( 'sidebar-footer' ) ) : ?>
			<footer id="colophon" class="site-footer" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
				<div class="footer-inner clearfix">
					<?php get_sidebar( 'footer' ); ?>
				</div><!-- .footer-inner -->
			</footer><!-- footer#colophon .site-footer -->
		<?php endif; ?>
		<?php
			/**
			 * Fires the Prequelle bottom bar
			 */
			do_action( 'prequelle_bottom_bar' );
		?>
	</div><!-- #page .hfeed .site -->
</div><!-- .site-container -->
<?php wp_footer(); ?>
<div class="register-popup-main login"><h2 class="close"><span class="popup">X</span></h2>
<div class="register-popup-inner"> <?php echo do_shortcode("[nm-wp-login]"); ?> <p class="register-text">
	if you are not registered <a class="registered-ko-bulao" href="#" style="
    color: orange !IMPORTANT;
">Get Registered First</a>
	</p></div> </div>
<div class="register-popup-main reg"><h2 class="close"><span class="popup">X</span></h2>
<div class="register-popup-inner"> <?php echo do_shortcode("[nm-wp-registration]"); ?></div> </div>
</body>
</html>
<script>jQuery('.single-add-to-wishlist-label').text('');</script>
<script>jQuery(".popup").click(function () {
    jQuery(".register-popup-main").css("display", "none");
});</script>
<script>setTimeout(function(){jQuery( ".pro-retailers-tab button" ).first().addClass( "active" )}, 2000);</script>

<script>
jQuery(document).ready(function(){

	// $('.orderby').append('<option id="123" value="http://google.com">test</option>');

});

</script>

<script>//jQuery('.wolf_add_to_wishlist').data('tooltipsy').destroy();</script>
<script>//jQuery('.wolf_add_to_wishlist').data('tooltipsy').hide();</script>

<script>setTimeout(function(){jQuery('.orderby').chosen()}, 1000);</script>
<script>
	jQuery(document).ready(function(jQuery){
	jQuery(document).scroll( function () { console.log('####G1'); setTimeout(function(){  console.log('####G2'); jQuery(window).scroll(); }, 2000) });
	});
</script>
<script>
jQuery(document).ready(function(){
jQuery(".mob-filter").click(function(){
setTimeout(function(){ jQuery(".woof_redraw_zone").css("display", "block") }, 500);
jQuery(".woof_redraw_zone").fadeIn(1000);
});
});

jQuery(document).ready(function(){
jQuery(".mob-filter").click(function(){
setTimeout(function(){ jQuery(".cus-trend").css("display", "block") }, 500);
jQuery(".cus-trend").fadeIn(1000);
});
});

</script>
<script>
jQuery(document).ready(function(){
jQuery(".h2-close").click(function(){
setTimeout(function(){ jQuery(".woof_redraw_zone").css("display", "none") }, 500);
jQuery(".woof_redraw_zone").fadeIn(1000);
});
});</script>
<script>
jQuery(document).ready(function(){
jQuery(".mob-filter").click(function(){
setTimeout(function(){ jQuery(".h2-close").css("display", "block") }, 500);
jQuery(".h2-close").fadeIn(1000);
});
});

jQuery(document).ready(function(){
jQuery(".h2-close").click(function(){
setTimeout(function(){ jQuery(".cus-trend").css("display", "none") }, 500);
jQuery(".cus-trend").fadeIn(1000);
});
});

</script>
<script>
jQuery(document).ready(function(){
jQuery(".h2-close").click(function(){
setTimeout(function(){ jQuery(".h2-close").css("display", "none") }, 500);
jQuery(".h2-close").fadeIn(1000);
});
});</script>
<script>
jQuery(document).ready(function(){
    //alert(sticky);
    var table = jQuery('#All table');
    var first_tab = sticky_first.toLowerCase();
	table.prepend(jQuery('#All table .wc-product-retailer_'+first_tab));

	$(".woocommerce-product-gallery__trigger").html('<img src="http://138.197.64.28/wp-content/uploads/2019/02/b71cf1cbdbdc88e378a39c852d158958.png">')

	$(".single-add-to-wishlist").add_action( 'tinv_wishlist_addtowishlist_button', array( $this, 'button' ) );

	$('.orderby').append('<option value="5">test</option>');

});
// jQuery(document).ready(function(){
   
// 	$(".active-result result-selected").click(function () {
// 		wcmvp_display_most_viewed_products( 10 ); 

// });
</script>