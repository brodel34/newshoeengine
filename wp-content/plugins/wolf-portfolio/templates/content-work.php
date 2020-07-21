<?php
/**
 * The template for displaying work content within loops.
 *
 * Override this template by copying it to yourtheme/wolf-portfolio/content-work.php
 *
 * @author WolfThemes
 * @package WolfPortfolio/Templates
 * @since 1.1.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$term_list = '';
$post_id   = get_the_ID();
if ( get_the_terms( $post_id, 'work_type' ) ) {
	foreach ( get_the_terms( $post_id, 'work_type' ) as $term ) {
		$term_list .= $term->slug .' ';
	}
}
$term_list  = ( $term_list ) ? substr( $term_list, 0, -1 ) : '';
$format     = get_post_format() ? get_post_format() : 'standard';
$thumb_size = ( $format == 'video' ) ? 'portfolio-video-thumb' : 'portfolio-thumb';

if ( '1' == wolf_portfolio_get_option( 'col' ) ) {
	$thumb_size = 'large';
}
?>
<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'work-item', $term_list ) ); ?>>
		<span class="work-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'wolf' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
				<?php the_post_thumbnail( $thumb_size ); ?>
				<h2 class="work-title"><?php the_title(); ?></h2>
			</a>
		</span><!-- span.work-thumbnail -->
	</article><!-- li.work-item -->
<?php endif; ?>