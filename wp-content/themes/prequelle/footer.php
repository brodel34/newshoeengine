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
</body>
</html>