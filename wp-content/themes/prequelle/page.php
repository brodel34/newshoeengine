<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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
				get_template_part( 'components/page/display/content' );
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			endwhile; // End of the loop.
			?>

		</main><!-- main#content .site-content-->
	</div><!-- #primary .content-area -->
<?php
get_footer();