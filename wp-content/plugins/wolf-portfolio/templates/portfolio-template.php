<?php
/**
 * The Template for displaying the main portfolio page
 *
 * Override this template by copying it to yourtheme/wolf-portfolio/portfolio-template.php
 *
 * @author WolfThemes
 * @package WolfPortfolio/Templates
 * @since 1.1.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'portfolio' ); 

	/**
	 * wolf_portfolio_before_main_content hook.
	 *
	 * @hooked wolf_portfolio_output_content_wrapper - 10 (outputs opening divs for the content)
	 * @hooked wolf_portfolio_breadcrumb - 20
	 */
	do_action( 'wolf_portfolio_before_main_content' );

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$posts_per_page = apply_filters( 'wfolio_posts_per_page', -1 );
	
	$args = array(
		'post_type' => 'work',
		'posts_per_page' => $posts_per_page,
	);

	if ( -1 < $posts_per_page ) {
		$args['paged'] = $paged;
	}

	$loop = new WP_Query( $args );
?>
	<div class="work-container">
		<?php if ( $loop->have_posts() ) : ?>
			
			<?php
				/**
				 * Work Category Filter
				 */
				wolf_portfolio_get_template( 'filter.php' );
			?>
			
			<?php wolf_portfolio_loop_start(); ?>
				
				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
				
					<?php wolf_portfolio_get_template_part( 'content', 'work' ); ?>
				
				<?php endwhile; ?>
			
			<?php wolf_portfolio_loop_end(); ?>
			
		<?php else : ?>

			<?php wolf_portfolio_get_template( 'loop/no-work-found.php' ); ?>
		
		<?php endif; // end have_posts() check ?>
	</div><!-- .work-container -->

	<?php
		/**
		 * wolf_portfolio_after_main_content hook.
		 *
		 * @hooked wolf_portfolio_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'wolf_portfolio_after_main_content' );

	?>

<?php get_footer( 'portfolio' ); ?>