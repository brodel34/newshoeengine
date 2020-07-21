<?php
/**
 * Displays centered logo navigation type
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
?>
<div id="nav-bar" class="nav-bar">
	<div class="flex-wrap cus-flex">
		<?php
			if ( 'left' === prequelle_get_inherit_mod( 'side_panel_position' ) && prequelle_can_display_sidepanel() ) {
				?>
				<div class="hamburger-container hamburger-container-side-panel">
					<?php
						/**
						 * Menu hamburger icon
						 */
						prequelle_hamburger_icon( 'toggle-side-panel' );
					?>
				</div><!-- .hamburger-container -->
				<?php
			}
		?>
<div class="logo-container logo-search">
			<?php
				/**
				 * Logo
				 */prequelle_logo();
				?>
						
								
								
			
				
	<i id="logo-search-icon" class="fa fa-search fa-rotate-90" aria-hidden="true"></i> <?php
	echo do_shortcode('[aws_search_form]');
			?> 
		</div><!-- .logo-container -->
		
		<div class="cta-container cus-cta">
			<?php 
				/**
				 * Secondary menu hook
				 */
				do_action( 'prequelle_secondary_menu', 'desktop' );
			?>
		</div><!-- .cta-container -->
		<?php
			if ( 'right' === prequelle_get_inherit_mod( 'side_panel_position' ) && prequelle_can_display_sidepanel() ) {
				?>
				<div class="hamburger-container hamburger-container-side-panel">
					<?php
						/**
						 * Menu hamburger icon
						 */
						prequelle_hamburger_icon( 'toggle-side-panel' );
					?>
				</div><!-- .hamburger-container -->
				<?php
			}
		?>
	</div><!-- .flex-wrap -->
<nav class="menu-container cus-menu" itemscope="itemscope"  itemtype="http://schema.org/SiteNavigationElement">
			<?php
				/**
				 * Menu
				 */
				prequelle_primary_desktop_navigation();
			?>
		</nav><!-- .menu-container -->
</div><!-- #navbar-container -->