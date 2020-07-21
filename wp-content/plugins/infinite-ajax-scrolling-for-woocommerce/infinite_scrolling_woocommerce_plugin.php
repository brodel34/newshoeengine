<?php
/*
Plugin Name: Infinite Ajax Scrolling Lite For Woocommerce
Plugin URI: https://www.phoeniixx.com/product/infinite-ajax-scrolling-for-woocommerce/
Description: There is a tendency to scroll down till one reaches the end of a web page. Infinite Scrolling Plugin uses this insight. 
Author: phoeniixx
Author URI: http://phoeniixx.com/
Version: 1.4.9
Text Domain:phoen-infinite
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
WC requires at least: 2.6.0
WC tested up to: 3.9.0
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
{
	
	include "backend_settings.php";
	
	add_action('wp_head', 'infinite_scroll_header_function');
	
	function infinite_scroll_header_function()
	{
	  
		if( get_option('scrolling_status') == 'on' && ( is_shop() || is_product_category() ) ) 
		{
		
			update_option('posts_per_page',12,'yes');
			
			

?>

			<script type="text/javascript">   
			
			var next_Selector = '<?php echo get_option("scroll_nextSelector"); ?>' ;
			
			var item_Selector = '<?php echo get_option("scroll_itemSelector"); ?>' ;
			
			var content_Selector = '<?php echo get_option("scroll_contentSelector"); ?>' ;
			
			var image_loader = '<?php echo get_option("image_url"); ?>' ;
			
			</script>
			<style>
				.woocommerce-pagination{
					 display: none;
				}
			
			</style>
<?php
			
			wp_enqueue_script("scroll-js",plugins_url( '' , __FILE__ ).'/assets/js/wo_infinite_scroll.js',array('jquery'),'',true);	
			
			wp_localize_script("scroll-js","infi_scrol_ajaxurl",array('ajaxurl'=> admin_url('admin-ajax.php')) );
			
			
		}
	
	}
	
	register_activation_hook(__FILE__, 'phoen_infinite_scroll_pages');
	
	function phoen_infinite_scroll_pages(){
		
		$content_Selector = get_option('scroll_contentSelector');
		
		$next_Selector = get_option('scroll_nextSelector');
		
		$scroll_contentSelector = get_option('scroll_itemSelector');
		
		if(empty($content_Selector)){
			update_option("scroll_contentSelector", sanitize_text_field($_POST['scroll_infinite_contentSelector']), "yes");
		}
		if(empty($next_Selector)){
			update_option("scroll_nextSelector", sanitize_text_field($_POST['scroll_infinite_nextSelector']), "yes");
		}
		if(empty($scroll_contentSelector)){
			update_option("scroll_itemSelector", sanitize_text_field($_POST['scroll_infinite_itemSelector']), "yes");
		}
	
		
	} 

}
else
{ 

?>

    <div class="error notice is-dismissible " id="message"><p>Please <strong>Activate</strong> WooCommerce Plugin First, to use Infinite Scrolling - Woocommerce Plugin.</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
        
<?php 

}  

?>
