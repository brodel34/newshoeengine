<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

/**
 * prequelle_post_content_start hook
 *
 * @see inc/fontend/hooks.php
 */
do_action( 'prequelle_post_content_start' );
?>
<div class="page-entry-content clearfix">
	<?php the_content(); ?>
	<?php wp_link_pages( array( 'before' => '<div class="clear"></div><div class="page-links clearfix"><span class="page-links-title">' . esc_html__( 'Pages:', 'prequelle' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
</div><!-- .page-entry-content -->

<footer class="entry-meta page-entry-meta">
	<?php edit_post_link( esc_html__( 'Edit', 'prequelle' ), '<span class="edit-link">', '</span>' ); ?>
</footer><!-- .entry-meta -->