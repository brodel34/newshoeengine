<?php
/**
 * Template part for displaying single work content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
$layout = ( get_post_meta( get_the_ID(), '_post_layout', true ) ) ? get_post_meta( get_the_ID(), '_post_layout', true ) : 'centered';
$info_position = ( get_post_meta( get_the_ID(), '_post_work_info_position', true ) ) ? get_post_meta( get_the_ID(), '_post_work_info_position', true ) : 'after';

if ( 'centered' !== $layout ) {
	$info_position = 'after';
}
?>
<article <?php prequelle_post_attr(); ?>>
	<?php if ( 'before' === $info_position ) : ?>
		<div class="work-info-container clearfix">
			<h2 class="entry-title"><?php echo apply_filters( 'prequelle_single_work_title', get_the_title() ); ?></h2>
			<div class="work-excerpt-container">
				<?php
					if ( has_excerpt() ) {
						/**
						 * The excerpt
						 */
						the_excerpt();
					}
				?>
			</div><!-- .work-excerpt-container -->
			<div class="work-meta-container">
				<?php
					/**
					 * Work Meta Hook
					 */
					do_action( 'prequelle_work_meta' );
				?>
			</div><!-- .work-meta-container -->
		</div><!-- .work-info -->
	<?php endif; ?>
	<div class="work-content clearfix">
		<?php
			/**
			 * The post content
			 */
			the_content();
		?>
	</div><!-- .work-content -->
	<?php if ( 'after' === $info_position ) : ?>
		<div class="work-info-container clearfix">
			<h2 class="entry-title"><?php echo apply_filters( 'prequelle_single_work_title', get_the_title() ); ?></h2>
			<div class="work-excerpt-container">
				<?php
					if ( has_excerpt() ) {
						/**
						 * The excerpt
						 */
						the_excerpt();
					}
				?>
			</div><!-- .work-excerpt-container -->
			<div class="work-meta-container">
				<?php
					/**
					 * Work Meta Hook
					 */
					do_action( 'prequelle_work_meta' );
				?>
			</div><!-- .work-meta-container -->
		</div><!-- .work-info -->
	<?php endif; ?>
</article><!-- #post-## -->