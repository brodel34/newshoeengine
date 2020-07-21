<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    function ph_infinite_add_menu()
	{
	   
		
		$page_title='Infinite Scrolling Settings';
		
		$menu_title='Infinite Scrolling';
		
		$capability='manage_options';
		
		$menu_slug='infinite_scrolling_settings';
		
		$function='infi_settings';
     	
		add_menu_page('phoeniixx','Infinite Scrolling','manage_options',$menu_slug,'',plugin_dir_url(__FILE__).'assets/img/logo-wp.png',57);
		
		add_submenu_page( 'phoeniixx','Infinite Scrolling','phoeniixx','manage_options',$menu_slug,'infi_settings');

	}
	
    add_action("admin_menu","ph_infinite_add_menu",99);
	 
	function infi_settings()
	{
		$plugin_dir_url =  plugin_dir_url( __FILE__ );
        
		echo"<h3>Infinite Scrolling Plugin Settings </h3>";
		
		if ( ! empty( $_POST ) && check_admin_referer('phoen_infinite_setting_my_action', 'phoen_infinite_setting_my_fields') ) {
		
			if(isset($_POST['submit']))
			{
				
				$checkbox_status = isset($_POST['scrolling'])?sanitize_text_field($_POST['scrolling']):'';
				
				$img_url = (sanitize_text_field($_POST['loader_img']))? sanitize_text_field($_POST['loader_img'] ): plugins_url( '' , __FILE__ ).'/assets/img/loader.gif' ;
				
				update_option("image_url", $img_url, "yes");
				
				$scroll_infinite_contentSelector=isset($_POST['scroll_infinite_contentSelector'])?sanitize_text_field($_POST['scroll_infinite_contentSelector']):'';
				
				$scroll_infinite_nextSelector=isset($_POST['scroll_infinite_nextSelector'])?sanitize_text_field($_POST['scroll_infinite_nextSelector']):'';
				
				$scroll_infinite_itemSelector=isset($_POST['scroll_infinite_itemSelector'])?sanitize_text_field($_POST['scroll_infinite_itemSelector']):'';
				
				update_option("scroll_contentSelector", $scroll_infinite_contentSelector, "yes");
				
				update_option("scroll_nextSelector", $scroll_infinite_nextSelector, "yes");
				
				update_option("scroll_itemSelector", $scroll_infinite_itemSelector, "yes");
				
				if($checkbox_status == 'on')
				{
					
					$option = "scrolling_status";
					
					$value = "on";
					
					$autoload = "yes";
					
					update_option($option, $value, $autoload);
					
					echo '<div class="updated notice is-dismissible below-h2" id="message"><p>Successfully saved. </p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
				
				}
				else
				{
					
					$option = "scrolling_status";
					
					$value = "off";
					
					$autoload = "yes";
					
					update_option($option, $value, $autoload);
					
					echo '<div class="updated notice is-dismissible below-h2" id="message"><p>Successfully saved. </p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
					
				}
				
			}
		}

	$tab = isset($_GET['tab'] )?sanitize_text_field( $_GET['tab'] ):'';

?>
		
			<div class="wrap" id="profile-page">
				<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
						<a class="nav-tab <?php if($tab == 'general' || $tab == ''){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=infinite_scrolling_settings&amp;tab=general">General</a>						<a class="nav-tab <?php if($tab == 'prem'){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=infinite_scrolling_settings&amp;tab=prem">Premium Version</a>														
						
				</h2>
				<style>
				.upgrade-heading{padding-left: 11px; font-size: 23px;}

				.upgrade-setting{font-size: 23px;}

				.grn-btn{  background: none repeat scroll 0 0 #6cab3d !important;
					border: medium none #6cab3d !important;}
					
				.grn-btn:hover{ background:#5a8f32 !important;}
				.phoeniixx_page_infinite_scrolling_settings .upgrade-setting {
    font-size: 23px;
    padding-left: 13px;
}
				</style>
				<?php
              
                
				if($tab == 'general' || $tab == '')
				{
				   
					
				?>
			<div class="meta-box-sortables" id="normal-sortables">
				<div class="postbox " id="pho_wcpc_box">
					<div class="inside">
						<div class="pho_check_pin">

							<div class="column two">
								
									<div class="pho-upgrade-btn">
										<a target="_blank" href="http://www.phoeniixx.com/product/infinite-ajax-scrolling-for-woocommerce/?utm_source=Free%20Plugin&utm_medium=Promotion&utm_campaign=Free%20Plugin/"><img src="<?php echo $plugin_dir_url; ?>assets/img/premium-btn.png" /></a>
										<a target="_blank" href="http://infinitescroll.phoeniixxdemo.com/"><img src="<?php echo $plugin_dir_url; ?>assets/img/demo-btn.png" /></a>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
				<form action="" id="form7" method="post">
				
				<?php wp_nonce_field( 'phoen_infinite_setting_my_action', 'phoen_infinite_setting_my_fields' ); ?>
				
				<table class="form-table">
				<tbody>	
				
				<tr class="user-nickname-wrap">
					<th><label>Enable infinite scrolling </label></th><td><input type="checkbox" id="scrolling" name="scrolling"  <?php echo esc_attr(get_option("scrolling_status") == "on")? 'checked' : ''  ?>  /></td>
				</tr>
				
				<tr class="user-nickname-wrap">
					<th colspan=2><label>Note: </label>"Selectors can be ID or class: if ID use '#id_name' and if class use '.class_name' " </th>
				</tr>
				
				<tr class="user-nickname-wrap">
					<th><label>Content selector on shop page	</label></th>
					<td><input type="text" class="regular-text" id="scroll_infinite_contentSelector" name="scroll_infinite_contentSelector" value ="<?php echo esc_attr(get_option('scroll_contentSelector'))? get_option('scroll_contentSelector'): '.products' ; ?>" ><br>
						
					</td>
				</tr>
				
				<tr class="user-nickname-wrap">
					<th><label>Next selector on shop page</label></th>
					<td><input type="text" class="regular-text" id="scroll_infinite_nextSelector" name="scroll_infinite_nextSelector" value ="<?php echo esc_attr(get_option('scroll_nextSelector'))? get_option('scroll_nextSelector'): '.next' ; ?>" ><br>
						
					</td>
				</tr>
				
				<tr class="user-nickname-wrap">
					<th><label>Item selector on shop page</label></th>
					<td><input type="text" class="regular-text" id="scroll_infinite_itemSelector" name="scroll_infinite_itemSelector" value ="<?php echo esc_attr(get_option('scroll_itemSelector'))? get_option('scroll_itemSelector'): '.product' ; ?>" ><br>
						
					</td>
				</tr>
				
				<tr class="user-nickname-wrap" >
					<th><label>Loader image </label></th><td><input type="text" class="regular-text"  id="loader_img" name="loader_img" value ="<?php echo esc_attr(get_option('image_url'))? get_option('image_url'): plugins_url( '' , __FILE__ ).'/assets/img/loader.gif'; ?>"  />  
					<input type="button" id="img_upload_button" class="button" name="img_upload_button" value="Upload"  /></td>
				</tr> 
				
				<tr class="user-nickname-wrap">
					<td colspan="2"><input type="submit" class="button button-primary" id="submit" name="submit" value="Save" /> </td>
				</tr>
				
				</tbody>	
				</table>
				</form>
				<?php
				}								
				if($tab == 'prem'){	 		?>				
				
				<div><!-------**------premium versin start from here-------**------>						
					<div class="premium-box">					
							<div class="premium-box-head">
                               <div class="pho-upgrade-btn">
                               <a target="_blank" href="http://www.phoeniixx.com/product/infinite-ajax-scrolling-for-woocommerce/?utm_source=Free%20Plugin&utm_medium=Promotion&utm_campaign=Free%20Plugin/"><img src="<?php echo $plugin_dir_url; ?>assets/img/premium-btn.png" /></a>
							   <a target="_blank" href="http://infinitescroll.phoeniixxdemo.com/"><img src="<?php echo $plugin_dir_url; ?>assets/img/demo-btn.png" /></a>
                               </div>
                               </div>
                                <div class="main-heading">
                               <h1> <img src="<?php echo $plugin_dir_url; ?>assets/img/premium-head.png" />
                               
                              </h1>
                               </div>
                               <div class="premium-box-container">
                               <div class="description">
                                    <div class="pho-desc-head">
                                    <h2>Select Types of Pagination</h2></div>
                                    
                                        <div class="pho-plugin-content">
                                            <p>This option allows you to pick the type of Pagination you would like to have. The available options include: Infinite Scrolling, Load More Button and Ajax Pagination.</p>
                                            <div class="pho-img-bg">
                                            <img src="<?php echo $plugin_dir_url; ?>assets/img/type-pagitpic.jpg" />
                                            </div>
                                        </div>
                                </div> <!-- description end -->
                                 <div class="description">
                                    <div class="pho-desc-head">
                                    <h2>Loader Option</h2></div>
                                    
                                        <div class="pho-plugin-content">
                                            <p>You have the choice to upload a Loader Image or you could choose a Loader from the available options.</p>
                                            <div class="pho-img-bg">
                                            <img src="<?php echo $plugin_dir_url; ?>assets/img/loader-option-pic.jpg" />
                                            </div>
                                        </div>
                                </div> <!-- description end -->
                                 <div class="description">
                                    <div class="pho-desc-head">
                                    <h2>Select Loading Effect</h2></div>
                                    
                                        <div class="pho-plugin-content">
                                            <p>You could pick a Loading effect from a list of options (Zoom in, Bounce in, Fade in, Fade in from top to down, Fade in from down to top, Fade in from right to left, Fade in from left to right).</p>
                                            <div class="pho-img-bg">
                                            <img src="<?php echo $plugin_dir_url; ?>assets/img/select-loading-efefcts.png" />
                                            </div>
                                        </div>
                                </div> <!-- description end -->
                                 <div class="description">
                                    <div class="pho-desc-head">
                                    <h2>Styling Option</h2></div>
                                    
                                        <div class="pho-plugin-content">
                                            <p>You could also pick a Styling Option from the available options.</p>
                                            <div class="pho-img-bg">
                                            <img src="<?php echo $plugin_dir_url; ?>assets/img/styling-option.png" />
                                            </div>
                                        </div>
                                </div> <!-- description end -->
                                	</div>			
					
							<div class="pho-upgrade-btn">
        <a target="_blank" href="http://www.phoeniixx.com/product/infinite-ajax-scrolling-for-woocommerce/?utm_source=Free%20Plugin&utm_medium=Promotion&utm_campaign=Free%20Plugin/"><img src="<?php echo $plugin_dir_url; ?>assets/img/premium-btn.png" /></a>
		<a target="_blank" href="http://infinitescroll.phoeniixxdemo.com/"><img src="<?php echo $plugin_dir_url; ?>assets/img/demo-btn.png" /></a>
        </div>
							  </div>
				</div>	
				
					<style type="text/css"> .premium-box{ width:100%; height:auto; background:#fff;  }		.premium-features{}		.premium-heading{  color: #484747;font-size: 40px;padding-top: 35px;text-align: center;text-transform: uppercase;}		.premium-features li:nth-child(1){ padding-bottom: 0;}		.premium-features li{ width:100%; float:left;  padding: 80px 0; margin: 0; }		.premium-features li .detail{ width:50%; }		.premium-features li .img-box{ width:50%; }		.premium-features li:nth-child(odd) { background:#f4f4f9; }		.premium-features li:nth-child(odd) .detail{float:right; text-align:left; }		.premium-features li:nth-child(odd) .detail .inner-detail{}		.premium-features li:nth-child(odd) .detail p{ }		.premium-features li:nth-child(odd) .img-box{ float:left; text-align:right;}		.premium-features li:nth-child(even){  }		.premium-features li:nth-child(even) .detail{ float:left; text-align:right;}		.premium-features li:nth-child(even) .detail .inner-detail{ margin-right: 46px;}		.premium-features li:nth-child(even) .detail p{ float:right;} 		.premium-features li:nth-child(even) .img-box{ float:right;}		.premium-features .detail{}		.premium-features .detail h2{ color: #484747;  font-size: 24px; font-weight: 700; padding: 0;}		.premium-features .detail p{  color: #484747;  font-size: 13px; }		/**images**/		.pagignation-type{ background:url("<?php echo $plugin_dir_url; ?>assets/img/type-pagitpic.jpg"); width:507px; height:80px; display:inline-block; margin-right: 25px; background-repeat:no-repeat; background-size: 100% auto;}		.loader-option{ background:url("<?php echo $plugin_dir_url; ?>assets/img/loader-option-pic.jpg"); width:500px; height:80px; display:inline-block; background-size:500px auto; margin-right:30px; background-repeat:no-repeat; background-size: 100% auto;}		.loading-effects{background:url("<?php echo $plugin_dir_url; ?>assets/img/select-loading-efefcts.png"); width:507px; height:275px; display:inline-block; background-repeat:no-repeat;}		.styling-option{background:url("<?php echo $plugin_dir_url; ?>assets/img/styling-option.png") top right ; width:92%; height:414px; display:inline-block; margin-right:30px; background-repeat:no-repeat ;background-size: 90%;  }		/*upgrade css*/		.upgrade{background:#f4f4f9;padding: 50px 0; width:100%; clear: both;}		.upgrade .upgrade-box{ background-color: #808a97;			color: #fff;			margin: 0 auto;		   min-height: 110px;			position: relative;			width: 60%;}		.upgrade .upgrade-box p{ font-size: 15px;			 padding: 19px 20px;			text-align: center;}		.upgrade .upgrade-box a{background: none repeat scroll 0 0 #6cab3d;			border-color: #ff643f;			color: #fff;			display: inline-block;			font-size: 17px;			left: 50%;			margin-left: -150px;			outline: medium none;			padding: 11px 6px;			position: absolute;			text-align: center;			text-decoration: none;			top: 36%;			width: 277px;}		.upgrade .upgrade-box a:hover{background: none repeat scroll 0 0 #72b93c;}		.premium-vr{ text-transform:capitalize;} .phoeniixx_page_infinite_scrolling_settings .upgrade-setting {
    padding-left: 11px;
}												

.premium-box-head {
    background: #eae8e7 none repeat scroll 0 0;
    height: 500px;
    text-align: center;
    width: 100%;
}
.pho-upgrade-btn a {
    display: inline-block;
    margin-top: 75px;
}
.main-heading {
    background: #fff none repeat scroll 0 0;
    margin-bottom: -70px;
    text-align: center;
}
.main-heading img {
    margin-top: -200px;
}
.premium-box-container {
    margin: 0 auto;
}
.premium-box-container .description:nth-child(2n+1) {
    background: #fff none repeat scroll 0 0;
}
.main-heading h1{ margin: 0px;}
.premium-box {
    background: none;
    height: auto;
    width: 100%;
}

.premium-box-container .description {
    display: block;
    padding: 35px 0;
    text-align: center;
}
.premium-box-container .pho-desc-head::after {
    background:url("<?php echo $plugin_dir_url; ?>assets/img/head-arrow.png") no-repeat;
    content: "";
    height: 98px;
    position: absolute;
    right: -40px;
    top: -6px;
    width: 69px;
}
.premium-box-container .pho-desc-head {
    margin: 0 auto;
    position: relative;
    width: 768px;
}
.pho-plugin-content {
    margin: 0 auto;
    overflow: hidden;
    width: 768px;
}
.pho-plugin-content img {
    max-width: 100%;
    width: auto;
}
.premium-box-container .pho-desc-head h2{ line-height:38px;}

.premium-box-container .pho-desc-head h2 {
    color: #02c277;
    font-size: 28px;
    font-weight: bolder;
    margin: 0;
    text-transform: capitalize;
}
.pho-plugin-content p {
    color: #212121;
    font-size: 18px;
    line-height: 32px;
}
.premium-box-container .description:nth-child(2n+1) .pho-img-bg {
    background: #f1f1f1 url("<?php echo $plugin_dir_url; ?>assets/img/image-frame-odd.png") no-repeat 100% top;
}
.description .pho-plugin-content .pho-img-bg {
    border-radius: 5px 5px 0 0;
    height: auto;
    margin: 0 auto;
    padding: 70px 0 40px;
    width: 750px;
}
.pho-upgrade-btn {
    text-align: center;
}
.premium-box-container .description:nth-child(2n) {
    background: #eae8e7 none repeat scroll 0 0;
}
.premium-box-container .description:nth-child(2n) .pho-img-bg {
    background: #f1f1f1 url("<?php echo $plugin_dir_url; ?>assets/img/image-frame-even.png") no-repeat 100% top;
}




</style>			
	<?php									}
				
				
				?>
			</div>       
			
<?php	
	
		wp_enqueue_script("conditions-js",plugins_url( '' , __FILE__ ).'/assets/js/custom.js',array('jquery'),'',true);
	
	} 
		
    add_action('admin_enqueue_scripts', 'script_for_upload');
 
	function script_for_upload() 
	{
		
		if (isset($_GET['page']) && $_GET['page'] == 'infinite_scrolling_settings') 
		{
			
			wp_enqueue_media();
			
		}
		
	}
	
?>