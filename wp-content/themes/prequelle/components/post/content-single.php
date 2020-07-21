<?php
/**
 * Template part for displaying single post content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
?>
<article <?php prequelle_post_attr( 'content-section' ); ?>>
		<?php
			/**
			 * prequelle_post_content_before hook
			 *
			 * @see inc/fontend/hooks.php
			 */
			do_action( 'prequelle_post_content_before' );
		?>
		<div class="single-post-content-container">
			<?php
				/**
				 * prequelle_post_content_start hook
				 *
				 * @see inc/fontend/hooks.php
				 */
				do_action( 'prequelle_post_content_start' );
			?>
				<div class="entry-content clearfix">
					<?php
						/**
						 * The post content
						 */
						the_content();

						wp_link_pages( array(
							'before' => '<div class="clear"></div><div class="page-links clearfix">' . esc_html__( 'Pages:', 'prequelle' ),
							'after' => '</div>',
							'link_before' => '<span class="page-number">',
							'link_after' => '</span>',
						) );
					?>
				</div><!-- .entry-content -->
			<?php
				/**
				 * prequelle_post_content_end hook
				 *
				 * @see inc/fontend/hooks.php
				 */
				do_action( 'prequelle_post_content_end' );
			?>
		</div><!-- .single-post-content-container -->
		<?php
			/**
			 * prequelle_post_content_after hook
			 *
			 * @see inc/fontend/hooks.php
			 */
			do_action( 'prequelle_post_content_after' );
		?>
</article>