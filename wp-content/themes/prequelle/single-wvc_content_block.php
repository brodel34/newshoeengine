<?php
/**
 * The template for displaying the content block for preview
 *
 * Content blocks shouldn't be displayed on their own as they are meant to be page fragments.
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
get_header();
?>
	<div id="primary" class="content-area">
		<main id="content" class="clearfix">

			<?php
			while ( have_posts() ) : the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content clearfix">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post -->
				<?php
			endwhile; // End of the loop.
			?>

		</main><!-- main#content .site-content-->
	</div><!-- #primary .content-area -->
<?php
get_footer();
?>