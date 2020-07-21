<?php
/**
 * Wolf Portfolio Shortcode.
 *
 * @class Wolf_Portfolio_Shortcode
 * @author WolfThemes
 * @category Core
 * @package WolfPortfolio/Shortcode
 * @version 1.2.2
 * @since 1.1.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Wolf_Portfolio_Shortcode class.
 */
class Wolf_Portfolio_Shortcode {
	/**
	 * Constructor
	 */
	public function __construct() {

		add_shortcode( 'wolf_last_works', array( $this, 'shortcode' ) );
	}

	/**
	 * Add filter to exlude password protected posts
	 *
	 * Create a new filtering function that will add our where clause to the query
	 */
	public function filter_where( $where = '' ) {
		$where .= " AND post_password = ''";
		return $where;
	}

	/**
	 * Shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	public function shortcode( $atts ) {

		extract(
			shortcode_atts(
				array(
					'count' => 3,
					'category' => null,
					'col' => wolf_portfolio_get_option( 'col', 3 ),
					'padding' => 'yes',
					'display' => '', // for custom appareance in theme
					'animation' => '',
					'animation_delay' => '',
				), $atts
			)
		);

		ob_start();

		$args = array(
			'post_type' => array( 'work' ),
			'posts_per_page' => absint( $count ),
		);

		if ( $category ) {
			$args['work_type'] = $category;
		}

		$class = 'shortcode-work-grid';

		if ( $display ) {
			$class .= ' portfolio-display-' . esc_attr( $display );
		}

		$class .= ' work-grid-col-' . absint( $col );
		$class .= ' shortcode-work-padding-' . esc_attr( $padding );

		add_filter( 'posts_where', array( $this, 'filter_where' ) );
		$loop = new WP_Query( $args );
		remove_filter( 'posts_where', array( $this, 'filter_where' ) );

		if ( $loop->have_posts() ) : ?>
			<div class="<?php echo $class; ?>" data-animation-parent="<?php echo esc_attr( $animation ); ?>">
				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

					<?php wolf_portfolio_get_template_part( 'content', 'work' ); ?>

				<?php endwhile; ?>
			</div><!-- .shortcode-portfolio-grid -->
			<div class="clear"></div>
		<?php else : // no work ?>
			<?php wolf_portfolio_get_template( 'loop/no-work-found.php' ); ?>
		<?php endif;
		wp_reset_postdata();

		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

	/**
	 * Shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	public function shortcode_widget( $atts ) {

		extract(
			shortcode_atts(
				array(
					'count' => 12,
				), $atts
			)
		);

		return wolf_get_photos_widget( $count );
	}

	/**
	 * Helper method to determine if a shortcode attribute is true or false.
	 *
	 * @since 1.2.2
	 *
	 * @param string|int|bool $var Attribute value.
	 * @return bool
	 */
	protected function shortcode_bool( $var ) {
		$falsey = array( 'false', '0', 'no', 'n' );
		return ( ! $var || in_array( strtolower( $var ), $falsey, true ) ) ? false : true;
	}

} // end class

return new Wolf_Portfolio_Shortcode();