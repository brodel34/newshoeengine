<?php
/**
 * Wolf Portfolio Functions
 *
 * Wolf Portfolio front-end functions
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPortfolio/Functions
 * @since 1.1.6
 */

/**
 * Enqueue scripts
 */
function wfolio_enqueue_scripts() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	/* Styles */
	wp_enqueue_style( 'wolf-portfolio', WFOLIO_CSS . '/portfolio' . $suffix . '.css', array(), WFOLIO_VERSION, 'all' );

	/* Scripts libraries */
	wp_register_script( 'imagesloaded', WFOLIO_JS . '/lib/imagesloaded.pkgd.min.js', array( 'jquery' ), '4.1.0', true );
	wp_register_script( 'isotope', WFOLIO_JS . '/lib/isotope.pkgd.min.js', array( 'jquery' ), '3.0.1', true );

	/* Scripts */
	wp_register_script( 'wolf-portfolio', WFOLIO_JS . '/portfolio' . $suffix . '.js', array( 'jquery' ), WFOLIO_VERSION, true );

	if ( is_page( wolf_portfolio_get_page_id() ) ) {
		wp_enqueue_script( 'imagesloaded' );
		wp_enqueue_script( 'isotope' );
		wp_enqueue_script( 'wolf-portfolio' );
	}
}
add_action( 'wp_enqueue_scripts', 'wfolio_enqueue_scripts' );

/**
 * Handle redirects before content is output - hooked into template_redirect so is_page portfolio.
 *
 */
function wolf_portfolio_template_redirect() {

	if ( is_page( wolf_portfolio_get_page_id() ) && ! post_password_required() ) {
		wolf_portfolio_get_template( 'portfolio-template.php' );
		exit();
	}
}

/**
 * Get the first image if no featured image is set
 *
 * @param bool $echo
 * @return string $thumbnail
 */
function wolf_portfolio_get_thumbnail( $size = 'portfolio-thumb' ) {

	$format = get_post_format() ? get_post_format() : 'standard';
	$size = ( $format == 'video' ) ? 'portfolio-video-thumb' : 'portfolio-thumb';

	if ( '1' == wolf_portfolio_get_option( 'col' ) ) {
		$thumb_size = 'large';
	}

	$thumbnail = get_the_post_thumbnail( get_the_ID(), apply_filters( 'wolf_portoflio_thumbnail_size', $size ) );

	return $thumbnail;
}

if ( ! function_exists( 'wolf_portfolio_nav' ) ) {
	/**
	 * Displays navigation to next/previous post when applicable.
	 *
	 *
	 * @return string/bool
	 */
	function wolf_portfolio_nav() {

		global $post;

		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
		?>
		<nav class="work-navigation" role="navigation">
			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'wolf-portfolio' ) ); ?>
			<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'wolf-portfolio' ) ); ?>
		</nav><!-- .navigation -->
		<?php
	}
}