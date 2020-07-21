<?php
/**
 * The Template for displaying the main portfolio page
 *
 * Override this template by copying it to yourtheme/wolf-portfolio/portfolio-template.php
 *
 * @author WpWolf
 * @package WolfPortfolio/Templates
 * @since 1.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'portfolio' ); ?>
	<div class="work-container">
		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * Work Category Filter
				 */
				wolf_portfolio_get_template( 'filter.php' );
			?>

			<?php wolf_portfolio_loop_start(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wolf_portfolio_get_template_part( 'content', 'work' ); ?>

				<?php endwhile; ?>

			<?php wolf_portfolio_loop_end(); ?>

			<?php else : ?>

				<?php wolf_portfolio_get_template( 'loop/no-work-found.php' ); ?>

			<?php endif; // end have_posts() check ?>
	</div><!-- .work-container -->
<?php get_footer( 'portfolio' ); ?>