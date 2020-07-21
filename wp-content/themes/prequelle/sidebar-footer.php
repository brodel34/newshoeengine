<?php
/**
 * The sidebar containing the footer widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
if ( is_active_sidebar( 'sidebar-footer' ) ) :
	$class = 'sidebar-footer';
	$class .= ' ' . apply_filters( 'prequelle_sidebar_footer_class', '' );
?>
	<div id="tertiary" class="<?php echo prequelle_sanitize_html_classes( $class ); ?>">
		<div class="sidebar-footer-inner wrap">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-footer' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-footer-inner -->
	</div><!-- #tertiary .sidebar-footer -->
<?php endif; ?>