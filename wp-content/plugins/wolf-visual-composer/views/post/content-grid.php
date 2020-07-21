<?php
/**
 * Post grid content
 *
 * This template is used inside the posts column shortcode
 *
 * @see templates/wvc_last_posts.php
 */
$format = get_post_format() ? get_post_format() : 'standard';
?>
<article <?php wvc_post_attr() ?> class="wvc-post-column">
	<div class="wvc-post-column-entry-thumbnail">
		<a href="<?php the_permalink(); ?>" class="wvc-post-column-entry-thumbnail-link entry-link">
			<div class="wvc-cover-landscape">
				<?php
					echo wvc_background_img( array( 'background_img_lazyload' => false, ) );
				?>
			</div><!-- .wvc-cover-landscape -->
		</a>
	</div><!-- .wvc-post-column-entry-thumbnail -->
	<h3 class="wvc-post-column-entry-title wvc-entry-title entry-title">
		<a href="<?php the_permalink(); ?>" rel="bookmark" class="wvc-post-column-entry-link entry-link"><?php the_title(); ?></a>
	</h3>
	<div class="wvc-post-column-entry-meta wvc-entry-meta entry-meta">
		<?php wvc_entry_meta(); ?>
		<?php edit_post_link( esc_html__( 'Edit', 'wolf-visual-composer' ), '<span class="edit-link wvc-edit-link">', '</span>' ); ?>
	</div>
	<div class="wvc-post-column-entry-summary wvc-entry-summary entry-summary">
		<p><?php echo wvc_sample( get_the_excerpt() , 28 ); ?><p>
	</div>
</article>