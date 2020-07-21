<?php
/**
 * Template part for displaying the author box
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
if ( ! get_the_author_meta( 'description' ) ) {
	return;
}
?>
<section class="author-box-container entry-section">
	<div class="author-box clearfix">
		<div class="author-avatar">
			<a itemprop="url" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
			</a>
		</div><!-- .author-avatar -->
		<div class="author-description" itemprop="author" itemscope itemtype="http://schema.org/Person">
			<h5 class="author-name"><span itemprop="name"><?php the_author_meta( 'display_name' ); ?></span></h5>
			<p>
				<?php the_author_meta( 'description' ); ?>
			</p>
			<p>
				<a itemprop="url" class="author-page-link <?php echo apply_filters( 'prequelle_author_page_link_button_class', 'button-secondary' ); ?>" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
					<?php printf( esc_html__( 'View all posts by %s &nbsp; &rarr;', 'prequelle' ), get_the_author() ); ?>
				</a>
			</p>
		</div><!-- .author-description -->
	</div><!-- .author-box -->
</section><!-- .author-box-container -->
