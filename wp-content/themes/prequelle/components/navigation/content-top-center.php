<?php
/**
 * Displays top center navigation type
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
?>
<div class="logo-bar">
	<div class="logo-container">
		<?php
			/**
			 * Logo
			 */
			prequelle_logo();
		?>
	</div><!-- .logo-container -->
</div><!-- .logo-bar -->
<div id="nav-bar" class="nav-bar">
	<div class="flex-wrap">
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
		<nav class="menu-container" itemscope="itemscope"  itemtype="http://schema.org/SiteNavigationElement">
			<?php
				/**
				 * Menu
				 */
				prequelle_primary_desktop_navigation();
			?>
		</nav><!-- .menu-container -->
		<div class="cta-container">
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
</div><!-- #nav-bar -->