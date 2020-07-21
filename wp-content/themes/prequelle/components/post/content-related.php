<?php
/**
 * Template part for displaying related posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
?>
<article <?php prequelle_post_attr(); ?>>
	<div class="entry-box">
		<div class="entry-container">
		<a href="<?php the_permalink() ?>" class="entry-link">
				<?php the_post_thumbnail( apply_filters( 'prequelle_related_post_thumbnail_size', 'medium_large' ), array( 'class' => 'entry-bg cover' ) ); ?>
				<div class="entry-overlay"></div>
				<div class="entry-inner">
					<div class="entry-summary">
						<?php the_title( '<h4 class="entry-title">', '</h4>' ); ?>
						<span class="entry-date">
							<?php prequelle_entry_date(); ?>
						</span>
					</div><!-- .entry-content -->
				</div><!-- .entry-inner -->
			</a>
		</div><!-- .entry-container -->
	</div><!-- .entry-box -->
</article><!-- #post-## -->