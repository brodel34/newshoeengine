<?php
/**
 * Template part for displaying posts with the "classic" display
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
if ( has_post_thumbnail() && ( prequelle_is_short_post_format() ) ) {
	$style = 'background-image:url(' . get_the_post_thumbnail_url( get_the_ID(), 'large' ) . ');';
}

extract( wp_parse_args( $template_args, array(
	'post_excerpt_type' => 'auto',
	'post_excerpt_length' => 'shorten',
	'post_display_elements' => 'show_thumbnail,show_date,show_text,show_author,show_category,show_extra_meta',
) ) );

$post_display_elements = prequelle_list_to_array( $post_display_elements );
$show_thumbnail = ( in_array( 'show_thumbnail', $post_display_elements ) );
$show_date = ( in_array( 'show_date', $post_display_elements ) );
$show_text = ( in_array( 'show_text', $post_display_elements ) );
$show_author = ( in_array( 'show_author', $post_display_elements ) );
$show_category = ( in_array( 'show_category', $post_display_elements ) );
$show_tags = ( in_array( 'show_tags', $post_display_elements ) );
$show_extra_meta = ( in_array( 'show_extra_meta', $post_display_elements ) );
?>
<article <?php prequelle_post_attr( 'post-excert-type-' . $post_excerpt_type ); ?>>
	<div class="entry-container">
		<?php
			if ( is_sticky() && ! is_paged() ) {
				echo '<span class="sticky-post" title="' . esc_attr( __( 'Featured', 'prequelle' ) ) . '"></span>';
			}
		?>
		<?php if ( $show_thumbnail ) : ?>
			<?php if ( prequelle_featured_media() ) : ?>
				<div class="entry-media">
					<?php echo prequelle_featured_media(); ?>
				</div>
			<?php endif ?>
		<?php endif; ?>
			<?php if ( '' == get_post_format() || 'video' === get_post_format() || 'gallery' === get_post_format() || 'image' === get_post_format() || 'audio' === get_post_format() ) : ?>
				<header class="entry-header">
					<?php if ( $show_date ) : ?>
						<span class="entry-date">
							<?php prequelle_entry_date( true, true ); ?>
						</span>
					<?php endif; ?>
					<?php the_title( '<h2 class="entry-title"><a class="entry-link" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
				</header>
			<?php endif; ?>
		<?php if ( $show_text ) : ?>
			<?php //if ( ! prequelle_featured_media() || '' == get_post_format() ) : ?>
			<?php if ( ! prequelle_is_short_post_format() ) : ?>
				<div class="entry-summary clearfix">
					<?php
						
						/**
						 * The excerpt
						 */
						do_action( 'prequelle_the_excerpt', $post_excerpt_type );

						wp_link_pages( array(
							'before'      => '<div class="clear"></div><div class="page-links clearfix">' . esc_html__( 'Pages:', 'prequelle' ),
							'after'       => '</div>',
							'link_before' => '<span class="page-number">',
							'link_after'  => '</span>',
						) );
					?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php if ( ( $show_author || $show_extra_meta || $show_category || prequelle_edit_post_link( false ) ) && ! prequelle_is_short_post_format() ) : ?>
			<footer class="entry-meta">
				<?php if ( $show_author ) : ?>
					<?php prequelle_get_author_avatar(); ?>
				<?php endif; ?>
				<?php if ( $show_category ) : ?>
					<span class="entry-category-list">
						<?php echo apply_filters( 'prequelle_entry_category_list_icon', '<span class="meta-icon category-icon"></span>' ); ?>
						<?php echo get_the_term_list( get_the_ID(), 'category', '', esc_html__( ', ', 'prequelle' ), '' ) ?>
					</span>
				<?php endif; ?>
				<?php if ( $show_tags ) : ?>
					<?php prequelle_entry_tags(); ?>
				<?php endif; ?>
				<?php if ( $show_extra_meta ) : ?>
					<?php prequelle_get_extra_meta(); ?>
				<?php endif; ?>
				<?php prequelle_edit_post_link(); ?>
			</footer><!-- .entry-meta -->
		<?php endif; ?>
	</div>
</article><!-- #post-## -->