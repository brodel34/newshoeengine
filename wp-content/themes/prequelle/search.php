
<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
get_header(); ?>

	<div id="primary" class="content-area">

		<main id="content" class="clearfix">
			<?php
				/**
				 * prequelle_search_content_before hook
				 *
				 * @see inc/fontend/hooks.php
				 */
				do_action( 'prequelle_search_content_before' );
			?>
			<div id="search-index" class="clearfix items masonry-container grid grid-padding-yes">
				<?php if ( have_posts() ) :
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'components/post/content', 'search' );
						endwhile; // End of the loop.
				?>
			</div><!-- #search-index -->
				<?php
					the_posts_pagination( array(
						'prev_text' => '<i class="pagination-icon-prev"></i>',
						'next_text' => '<i class="pagination-icon-next"></i>',
					) );
				?>
			<?php

				else :

					get_template_part( 'components/post/content', 'none' );
				endif;
			?>
		</main><!-- #content -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
?>