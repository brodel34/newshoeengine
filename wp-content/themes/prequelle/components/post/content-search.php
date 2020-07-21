
<?php
/**
 * Template part for displaying posts with excerpts
 *
 * Used in Search Results and for Recent Posts in Front Page panels.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
* @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
?>
<article <?php prequelle_post_attr(); ?>>
	<a href="<?php the_permalink(); ?>" class="entry-link-mask"></a>
	<div class="entry-container">
		<div class="entry-box">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-image">
					<?php echo prequelle_post_thumbnail( 'prequelle-masonry' ); ?>
				</div><!-- .entry-image -->
			<?php endif; ?>
			<div class="entry-summary">
				<div class="entry-summary-inner">
					<?php if ( prequelle_get_post_type_name() ) : ?>
						<span class="entry-post-type-name"><?php echo prequelle_get_post_type_name(); ?></span>
					<?php endif; ?>
					<h2 class="entry-title">
						<?php the_title(); ?>
					</h2>
					<div class="entry-excerpt">
						<?php echo prequelle_sample( get_the_excerpt(), 14 ); ?>
					</div><!-- .entry-excerpt -->
				</div><!-- .entry-summary-inner -->
			</div><!-- .entry-summary -->
		</div><!-- .entry-box -->
	</div><!-- .entry-container -->
</article><!-- #post-## -->