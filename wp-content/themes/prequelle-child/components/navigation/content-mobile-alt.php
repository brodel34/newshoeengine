<?php
/**
 * Displays mobile navigation
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
?>

<div id="mobile-bar" class="nav-bar">
	<div class="flex-mobile-wrap">
		<div class="logo-container">
			<?php
			
				/**
				 * Logo
				 */
				prequelle_logo();
			?>
		</div><!-- .logo-container -->
		
		 <!-- <a href="http://demoapps.devbatch.com/shoeengine/feed-2/"><img src="http://demoapps.devbatch.com/shoeengine/wp-content/uploads/2018/10/news-feed-icon-png-8.png"   class="menu-link internal-link feed-padding feed-icon-cust" itemprop="url"><span class="menu-item-inner"><span class="menu-item-text-container" itemprop="name"></span></span></a>
		 <a> <img src="http://demoapps.devbatch.com/shoeengine/wp-content/uploads/2018/10/download-3.png"    class="search-icon-mobileapp"></a> -->
		
		<div class="cta-container">
		
			<?php
				/**
				 * Secondary menu hook
				 */
				do_action( 'prequelle_secondary_menu', 'desktop' );
			?>
	
		</div><!-- .cta-container -->
		
		<div class="feed-bg-mobile white-bg gray-bg showhide"><a href="http://138.197.64.28/feed-2/"><img src="<?php echo site_url(); ?>/wp-content/uploads/2018/10/news-feed-icon-png-8.png"   class="menu-link internal-link feed-padding feed-mobiledesign" itemprop="url"><span class="menu-item-inner"><span class="menu-item-text-container" itemprop="name"></span></span></a></div> 
		
		<!-- search toggle -->
	<div class="search-bg-mobile white-bg gray-bg showhide">
		<a onclick="js_function_seaxch()"> <img src="<?php echo site_url(); ?>/wp-content/uploads/2018/10/search.png"    class="search-icon-mobileapp"></a>
		 
		</div>
		<div id="myDropdown" class="dropdown-content">
		<?php echo do_shortcode('[aws_search_form]'); ?>
		</div>
		 <!-- search toggle -->
		
		
		<div class="hamburger-container">
		
		<?php
				/**
				 * Menu hamburger icon
				 */
				prequelle_hamburger_icon( 'toggle-mobile-menu' );
		
			?>
			
		</div><!-- .hamburger-container -->
	</div><!-- .flex-wrap -->
</div><!-- #navbar-container -->


 <!-- <div class="dropdown">
 <button onclick="myFunction()" class="dropbtn">Dropdown</button>
   <div id="myDropdown" class="dropdown-content">
   </div>
 </div> -->




