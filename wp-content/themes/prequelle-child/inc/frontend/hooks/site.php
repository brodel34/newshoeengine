<?php
/**
 * Prequelle site hook functions
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function prequelle_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'prequelle_pingback_header' );

/**
 * Output anchor at the very top of the page
 */
function prequelle_output_top_anchor() {
	?>
	<div id="top"></div>
	<?php
}
add_action( 'prequelle_body_start', 'prequelle_output_top_anchor' );

/**
 * Output loader overlay
 */
function prequelle_page_loading_overlay() {

	$show_overlay = apply_filters( 'prequelle_display_loading_overlay', 'none' != prequelle_get_inherit_mod( 'loading_animation_type', 'none' ) );

	if ( ! $show_overlay ) {
		return;
	}
	?>
	<div id="loading-overlay" class="loading-overlay">
		<?php prequelle_spinner(); ?>
	</div><!-- #loading-overlay.loading-overlay -->
	<?php
}
add_action( 'prequelle_body_start', 'prequelle_page_loading_overlay' );

/**
 * Output ajax loader overlay
 */
function prequelle_ajax_loading_overlay() {

	if ( 'none' === prequelle_get_theme_mod( 'ajax_animation_type', 'none' ) ) {
		return;
	}
	?>
	<div id="ajax-loading-overlay" class="loading-overlay">
		<?php prequelle_spinner(); ?>
	</div><!-- #loading-overlay.loading-overlay -->
	<?php
}
add_action( 'wolf_site_content_start', 'prequelle_ajax_loading_overlay' );

/**
 * Add mobile closer overlay
 */
function prequelle_add_panel_closer_overlay() {
	$toggle_class = 'toggle-side-panel';

	if ( 'offcanvas' === prequelle_get_inherit_mod( 'menu_layout' ) ) {
		$toggle_class = 'toggle-offcanvas-menu';
	}
	?>
	<div id="panel-closer-overlay" class="panel-closer-overlay <?php echo prequelle_sanitize_html_classes( $toggle_class ); ?>"></div>
	<?php
}
add_action( 'prequelle_main_content_start', 'prequelle_add_panel_closer_overlay' );

/**
 * Scroll to top arrow
 */
function prequelle_scroll_top_link() {
	?>
	<a href="#top" id="back-to-top"><?php esc_html_e( 'Back to the top', 'prequelle' ); ?></a>
	<?php
}
add_action( 'prequelle_body_start', 'prequelle_scroll_top_link' );

/**
 * Output frame
 */
function prequelle_frame_border() {

	if ( 'frame' === prequelle_get_inherit_mod( 'site_layout' ) || prequelle_is_customizer() ) {
		?>
		<span class="frame-border frame-border-top"></span>
		<span class="frame-border frame-border-bottom"></span>
		<span class="frame-border frame-border-left"></span>
		<span class="frame-border frame-border-right"></span>
		<?php
	}
}
add_action( 'prequelle_body_start', 'prequelle_frame_border' );

/**
 * Hero
 */
function prequelle_output_hero_content() {

	$show_hero = true;

	$no_hero_post_types = apply_filters( 'prequelle_no_header_post_types', array( 'product', 'release', 'event', 'proof_gallery', 'attachment' ) );
	
	if ( is_single() && in_array( get_post_type(), $no_hero_post_types ) ) {
		$show_hero = false;
	}

	if ( is_single() && 'none' === get_post_meta( get_the_ID(), '_post_hero_layout', true ) ) {
		$show_hero = false;
	}

	if ( apply_filters( 'prequelle_show_hero', $show_hero ) ) {
		get_template_part( 'components/layout/hero', 'content' );
	}
}
add_action( 'prequelle_hero', 'prequelle_output_hero_content' );

/**
 * Output Hero background
 *
 * Diplsay the hero background through the hero_background hook
 */
function prequelle_output_hero_background() {

	echo prequelle_get_hero_background();

	if ( prequelle_get_inherit_mod( 'hero_scrolldown_arrow' ) ) {
		echo '<a class="scroll-down" id="hero-scroll-down-arrow" href="#"><i class="fa scroll-down-icon"></i></a>';
	}
}
add_action( 'prequelle_hero_background', 'prequelle_output_hero_background' );

/**
 * Output bottom bar with menu copyright text and social icons
 */
function prequelle_bottom_bar() {

	$class = 'site-infos wrap';
	$hide_bottom_bar = get_post_meta( get_the_ID(), '_post_bottom_bar_hidden', true );
	$services = sanitize_text_field( prequelle_get_theme_mod( 'footer_socials' ) );
	$display_menu = has_nav_menu( 'tertiary' );
	$display_menu = false;
	$credits = prequelle_get_theme_mod( 'copyright' );

	if ( 'yes' === $hide_bottom_bar ) {
		return;
	}

	if ( $services || $display_menu || $credits ) :
	?>
	<div class="site-infos clearfix">
		<div class="wrap">
			<div class="bottom-social-links">
				<?php
					/**
					 * Social icons
					 */
					if ( function_exists( 'wvc_socials' ) && $services ) {
						echo wvc_socials( array( 'services' => $services, 'size' => 'fa-1x' ) );
					}
				?>
			</div><!-- .bottom-social-links -->
			<?php
				/**
				 * Fires in the Prequelle bottom menu
				 *
				 */
				do_action( 'prequelle_bottom_menu' );
			?>
			<?php if ( has_nav_menu( 'tertiary' ) ) : ?>
			<div class="clear"></div>
			<?php endif; ?>
			<div class="credits">
				<?php
					/**
					 * Fires in the Prequelle footer text for customization.
					 *
					 * @since Prequelle 1.0
					 */
					do_action( 'prequelle_credits' );
				?>
			</div><!-- .credits -->
		</div>
	</div><!-- .site-infos -->
	<?php
	endif;

}
add_action( 'prequelle_bottom_bar', 'prequelle_bottom_bar' );

/**
 * Copyright/site info text
 *
 * @since Prequelle 1.0.0
 */
function prequelle_site_infos() {

	$footer_text = prequelle_get_theme_mod( 'copyright' );

	if ( $footer_text ) {
		$footer_text = '<span class="copyright-text">' . $footer_text . '</span>';
		echo apply_filters( 'prequelle_copyright_text', $footer_text );
	}
}
add_action( 'prequelle_credits', 'prequelle_site_infos' );

/**
 * Output top block after header using WVC Content Block plugin function
 */
function prequelle_output_after_header_block() {

	if ( ! class_exists( 'Wolf_Vc_Content_Block' ) || ! defined( 'WPB_VC_VERSION' ) ) {
		return;
	}

	if ( is_404() ) {
		return;
	}

	$post_id = prequelle_get_the_ID();

	$block_mod = prequelle_get_theme_mod( 'after_header_block' );
	$block_meta = get_post_meta( $post_id, '_post_after_header_block', true );
	
	if ( ! is_single() && ! is_page() ) {
		$block_meta = null;
	}

	$block = ( $block_meta ) ? $block_meta : $block_mod;

	/* Shop page inheritance */
	$wc_meta = get_post_meta( prequelle_get_woocommerce_shop_page_id(), '_post_after_header_block', true );
	$is_wc_page_child = is_page() && wp_get_post_parent_id( $post_id ) == prequelle_get_woocommerce_shop_page_id();
	
	$is_wc = prequelle_is_woocommerce_page() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $wc_meta && apply_filters( 'prequelle_force_display_shop_after_header_block', $is_wc ) ) {
		$block = $wc_meta;
	}

	/* Blog page inheritance */
	$blog_page_id = get_option( 'page_for_posts' );
	$blog_meta = get_post_meta( $blog_page_id, '_post_after_header_block', true );
	$is_blog_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $blog_page_id;
	
	$is_blog = prequelle_is_blog() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $blog_meta && apply_filters( 'prequelle_force_display_blog_after_header_block', $is_blog ) ) {
		$block = $blog_meta;
	}

	/* Video page inheritance */
	$video_page_id = prequelle_get_videos_page_id();
	$video_meta = get_post_meta( $video_page_id, '_post_after_header_block', true );
	$is_video_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $video_page_id;
	
	$is_video = prequelle_is_videos() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $video_meta && apply_filters( 'prequelle_force_display_video_after_header_block', $is_video ) ) {
		$block = $video_meta;
	}

	if ( is_search() ) {
		$block = get_post_meta( get_option( 'page_for_posts' ), '_post_after_header_block', true );

		if ( isset( $_GET['post_type'] ) && 'product' === $_GET['post_type'] ) {

			$block = get_post_meta( prequelle_get_woocommerce_shop_page_id(), '_post_after_header_block', true );
		
		} else {
			$block = get_post_meta( get_option( 'page_for_posts' ), '_post_after_header_block', true );
		}
	}

	if ( $block && 'none' !== $block ) {
		echo wccb_block( $block );
	}
}
add_action( 'prequelle_after_header_block', 'prequelle_output_after_header_block' );

/**
 * Output bottom block before footer using WVC Content Block plugin function
 */
function prequelle_output_before_footer_block() {

	if ( ! class_exists( 'Wolf_Vc_Content_Block' ) || ! defined( 'WPB_VC_VERSION' ) ) {
		return;
	}

	if ( is_404() ) {
		return;
	}

	$post_id = prequelle_get_the_ID();

	$block_mod = prequelle_get_theme_mod( 'before_footer_block' );
	$block_meta = get_post_meta( $post_id, '_post_before_footer_block', true );
	$block = ( $block_meta ) ? $block_meta : $block_mod;

	/* Shop page inheritance */
	$wc_meta = get_post_meta( prequelle_get_woocommerce_shop_page_id(), '_post_before_footer_block', true );
	$is_wc_page_child = is_page() && wp_get_post_parent_id( $post_id ) == prequelle_get_woocommerce_shop_page_id();
	$is_wc = ( prequelle_is_woocommerce_page() || $is_wc_page_child || is_singular( 'product' ) );

	if ( ! $block_meta && 'none' !== $block_meta && $wc_meta && apply_filters( 'prequelle_force_display_shop_pre_footer_block', $is_wc ) ) {
		$block = $wc_meta;
	}

	/* Blog page inheritance */
	$blog_page_id = get_option( 'page_for_posts' );
	$blog_meta = get_post_meta( $blog_page_id, '_post_before_footer_block', true );
	$is_blog_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $blog_page_id;
	$is_blog = ( prequelle_is_blog() || $is_blog_page_child ) && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $blog_meta && apply_filters( 'prequelle_force_display_blog_pre_footer_block', $is_blog ) ) {
		$block = $blog_meta;
	}

	if ( $block && 'none' !== $block ) {
		echo wccb_block( $block );
	}
}
add_action( 'prequelle_before_footer_block', 'prequelle_output_before_footer_block', 28 );


/**
 * Output music network icons
 *
 * @see Wolf Music Network http://wolfthemes.com/plugin/wolf-music-network/
 */
function prequelle_output_music_network() {

	if ( function_exists( 'wolf_music_network' ) ) {
		echo '<div class="music-social-icons-container clearfix">';
			wolf_music_network();
		echo '</div><!--.music-social-icons-container-->';
	}

}
add_action( 'prequelle_footer_before', 'prequelle_output_music_network' );