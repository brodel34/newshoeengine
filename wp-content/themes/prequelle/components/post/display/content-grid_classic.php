<?php
/**
 * Template part for displaying posts with the "grid" display
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
extract( wp_parse_args( $template_args, array(
	'post_excerpt_length' => 'shorten',
	'post_display_elements' => 'show_thumbnail,show_date,show_text,show_author,show_category',
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
<article <?php prequelle_post_attr(); ?>>
	<a href="<?php the_permalink(); ?>" class="entry-link-mask"></a>
	<div class="entry-box">
		<div class="entry-container">
			<?php if ( $show_thumbnail ) : ?>
				<?php if ( prequelle_has_post_thumbnail() ) : ?>
					<div class="entry-image">
						<?php if ( $show_category ) : ?>
							<a class="category-label" href="<?php echo prequelle_get_first_category_url(); ?>"><?php echo prequelle_get_first_category(); ?></a>
						<?php endif; ?>
						<?php
							if ( is_sticky() && ! is_paged() ) {
								echo '<span class="sticky-post" title="' . esc_attr( __( 'Featured', 'prequelle' ) ) . '"></span>';
							}
						?>
						<div class="entry-cover">
							<?php
								echo prequelle_background_img( array( 'background_img_size' => 'medium', ) );
							?>
						</div><!-- entry-cover -->
					</div><!-- .entry-image -->
				<?php endif; ?>
			<?php endif; ?>
			<div class="entry-summary">
				<div class="entry-summary-inner">
					<div class="entry-summary-content">
						<?php if ( $show_date ) : ?>
							<span class="entry-date">
								<?php prequelle_entry_date(); ?>
							</span>
						<?php endif; ?>
						<h2 class="entry-title">
							<?php if ( ! has_post_thumbnail() || ! $show_thumbnail ) : ?>
								<?php
									if ( is_sticky() && ! is_paged() ) {
										echo '<span class="sticky-post" title="' . esc_attr( __( 'Featured', 'prequelle' ) ) . '"></span>';
									}
								?>
							<?php endif; ?>
							<?php the_title(); ?>
						</h2>
						<?php if ( $show_text ) : ?>
							<div class="entry-excerpt">
								<?php echo prequelle_sample( get_the_excerpt(), prequelle_get_excerpt_lenght() ); ?>
							</div><!-- .entry-excerpt -->
						<?php endif; ?>
						<?php if ( $show_category && ( ! has_post_thumbnail() || ! $show_thumbnail ) ) : ?>
							<div class="entry-category-list">
								<?php echo get_the_term_list( get_the_ID(), 'category', esc_html__( 'In', 'prequelle' ) . ' ', esc_html__( ', ', 'prequelle' ), '' ) ?>

							</div>
						<?php endif; ?>
					</div><!-- .entry-text -->
				</div><!-- .entry-summary-inner -->
				<?php if ( $show_author || $show_tags || $show_extra_meta || prequelle_edit_post_link( false ) ) : ?>
					<div class="entry-meta">
						<?php if ( $show_author ) : ?>
							<?php prequelle_get_author_avatar(); ?>
						<?php endif; ?>
						<?php if ( $show_tags ) : ?>
							<?php prequelle_entry_tags(); ?>
						<?php endif; ?>
						<?php if ( $show_extra_meta ) : ?>
							<?php prequelle_get_extra_meta(); ?>
						<?php endif; ?>
						<?php prequelle_edit_post_link(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</div><!-- .entry-summary -->
		</div><!-- .entry-container -->
	</div><!-- .entry-box -->
</article><!-- #post-## -->