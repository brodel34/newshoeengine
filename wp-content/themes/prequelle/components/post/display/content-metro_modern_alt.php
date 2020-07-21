<?php
/**
 * Template part for displaying the post metro modern alt layout
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
$format = get_post_format();
$the_permalink = ( 'link' === $format && prequelle_get_first_url() ) ? prequelle_get_first_url() : get_the_permalink();
$target = ( 'link' === $format && prequelle_get_first_url() ) ? '_blank' : '_self';
?>
<article <?php prequelle_post_attr(); ?>>
	<div class="entry-box">
		<a class="entry-link-mask" href="<?php echo esc_url( $the_permalink ); ?>" target="<?php echo esc_attr( $target ); ?>"></a>
		<div class="entry-outer">
			<div class="entry-container">
					<?php
						/**
						 * See frontend/hooks/post.php prequelle_output_post_grid_summary()
						 */
						do_action( 'prequelle_post_grid_summary' );
					?>
			</div><!-- .entry-container -->
		</div><!-- .entry-outer -->
	</div><!-- .entry-box -->
</article><!-- #post-## -->