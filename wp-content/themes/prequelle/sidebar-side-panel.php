<?php
/**
 * The sidebar containing the side panel widget areas.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
if ( is_active_sidebar( 'sidebar-side-panel' ) ) : ?>
	<div id="side-panel-widgets" class="sidebar-container sidebar-side-panel" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
		<div class="sidebar-inner">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-side-panel' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-inner -->
	</div><!-- #tertiary .sidebar-container -->
<?php endif; ?>