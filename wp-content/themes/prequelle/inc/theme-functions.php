<?php
/**
 * Prequelle frontend theme specific functions
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Add custom font
 */
function prequelle_add_google_font( $google_fonts ) {

	$default_fonts = array(
		'Cabin' =>  'Cabin:400,700,900',
		'Rubik' =>  'Rubik:400,700,900',
		'Playfair Display' => 'Playfair+Display:400,700',
		'Oswald' => 'Oswald:400,700',
	);

	foreach ( $default_fonts as $key => $value ) {
		if ( ! isset( $google_fonts[ $key ] ) ) {
			$google_fonts[ $key ] = $value;
		}
	}

	return $google_fonts;
}
add_filter( 'prequelle_google_fonts', 'prequelle_add_google_font' );

/**
 * Overwrite standard post entry slider image size
 */
function prequelle_overwrite_entry_slider_img_size( $size ) {

	add_image_size( 'prequelle-slide', 750, 450, true );

}
add_action( 'after_setup_theme', 'prequelle_overwrite_entry_slider_img_size', 50 );

/**
 * Add custom elements to theme
 *
 * @param array $elements
 * @return  array $elements
 */
function prequelle_add_available_wvc_elements( $elements ) {

	$elements[] = 'showcase-vertical-carousel';
	$elements[] = 'showcase-vertical-carousel-item';
	$elements[] = 'login-form';

	if ( class_exists( 'WooCommerce' ) ) {
		$elements[] = 'product-presentation';
	}
	

	return $elements;
}
add_filter( 'wvc_element_list', 'prequelle_add_available_wvc_elements', 44 );

/**
 * Disable default loading and transition animation
 *
 * @param bool $bool
 * @return bool
 */
function prequelle_reset_loading_anim( $bool ) {
	return false;
}
add_filter( 'prequelle_display_loading_logo', 'prequelle_reset_loading_anim' );
add_filter( 'prequelle_display_loading_overlay', 'prequelle_reset_loading_anim' );
add_filter( 'prequelle_default_page_loading_animation', 'prequelle_reset_loading_anim' );
add_filter( 'prequelle_default_page_transition_animation', 'prequelle_reset_loading_anim' );

/**
 * Loading title markup
 *
 * @param bool $bool
 * @return bool
 */
function prequelle_loading_animation_markup() {
		
	if ( 'none' !== prequelle_get_inherit_mod( 'loading_animation_type', 'overlay' ) ) :
	?>
	<div class="prequelle-loader-overlay">
		<div class="prequelle-loader">
			<?php if ( 'prequelle' === prequelle_get_inherit_mod( 'loading_animation_type', 'overlay' ) ) : ?>
				<div id="prequelle-loading-before" class="prequelle-loading-block"></div>
				<div id="prequelle-loading-line">
					<span id="prequelle-percent">0%</span>
				</div>
				<div id="prequelle-loading-after" class="prequelle-loading-block"></div>
			<?php endif; ?>
		</div>
	</div>
	<?php endif;
}
add_action( 'prequelle_body_start', 'prequelle_loading_animation_markup', 0 );

/**
 * Add tertiary menu for the vertical bar
 */
function prequelle_add_tertiary_menu( $menus ) {

	$menus['tertiary'] = esc_html__( 'Tertiary Menu (Vertical bar optional menu)', 'prequelle' );

	return $menus;

}
add_filter( 'prequelle_menus', 'prequelle_add_tertiary_menu' );

/**
 * Vertical Bar markup
 *
 * @param bool $bool
 * @return bool
 */
function prequelle_vertical_bar_markup() {
		
	$disable_bar = get_post_meta( get_the_ID(), '_post_disable_vertical_bar', true );

	if ( ! $disable_bar && ( prequelle_get_theme_mod( 'vertical_bar_content_type_top' ) || prequelle_get_theme_mod( 'vertical_bar_content_type_middle' ) || prequelle_get_theme_mod( 'vertical_bar_content_type_bottom' ) ) ) :

	?>
	<div id="vertical-bar">
		<div id="vertical-bar-inner">
			<?php if ( prequelle_get_theme_mod( 'vertical_bar_content_type_top' ) ) : ?>
				<div id="vertical-bar-top" class="vertical-bar-cell">
					<?php prequelle_vertical_bar_content( 'top' ); ?>
				</div>
			<?php endif; ?>
			<?php if ( prequelle_get_theme_mod( 'vertical_bar_content_type_middle' ) ) : ?>
				<div id="vertical-bar-middle" class="vertical-bar-cell">
					<?php prequelle_vertical_bar_content( 'middle' ); ?>
				</div>
			<?php endif; ?>
			<?php if ( prequelle_get_theme_mod( 'vertical_bar_content_type_bottom' ) ) : ?>
				<div id="vertical-bar-bottom" class="vertical-bar-cell">
					<?php prequelle_vertical_bar_content( 'bottom' ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php endif;
}
add_action( 'prequelle_body_start', 'prequelle_vertical_bar_markup', 0 );

/**
 * Vertical Bar panel markup
 */
function prequelle_vertical_bar_panel_markup() {
		
	if ( 'toggle_panel' === prequelle_get_inherit_mod( 'vertical_bar_content_type_top' ) || 'toggle_panel' === prequelle_get_inherit_mod( 'vertical_bar_content_type_middle' ) || 'toggle_panel' === prequelle_get_inherit_mod( 'vertical_bar_content_type_bottom' ) && is_active_sidebar( 'sidebar-vertical-bar' ) ) :

	?>
	<div id="vertical-bar-panel">
		<div id="vertical-bar-panel-inner">
			<?php get_sidebar( 'vertical-bar' ); ?>
		</div>
	</div>
	<?php endif;
}
add_action( 'prequelle_body_start', 'prequelle_vertical_bar_panel_markup', 0 );


/**
 * Vertical Bar overlay markup
 */
function prequelle_vertical_bar_overlay_markup() {


	if ( 'toggle_overlay' === prequelle_get_inherit_mod( 'vertical_bar_content_type_top' ) || 'toggle_overlay' === prequelle_get_inherit_mod( 'vertical_bar_content_type_middle' ) || 'toggle_overlay' === prequelle_get_inherit_mod( 'vertical_bar_content_type_bottom' ) ) :

		$block_id = prequelle_get_inherit_mod( 'vertical_bar_overlay_block_id' );

		if ( ! $block_id || ! function_exists( 'wccb_block' ) ) {
			return;
		}

	?>
	<div id="vertical-bar-overlay">
		<!-- <a href="#" id="close-vertical-bar-menu-icon" class="close-panel-button toggle-vertical-bar-overlay">X</a> -->
		<div id="vertical-bar-overlay-inner">
			<div id="vertical-bar-overlay-content">
				<?php
					/**
					 * Content Block
					 */
					echo wccb_block( $block_id );
				?>
			</div>
		</div>
	</div>
	<?php endif;
}
add_action( 'prequelle_body_start', 'prequelle_vertical_bar_overlay_markup', 5 );

/**
 * Login popup markup
 *
 * @param bool $bool
 * @return bool
 */
function prequelle_login_form_markup() {
	if ( function_exists( 'wvc_login_form' ) ) {
		?>
		<div id="loginform-overlay">
			<div id="loginform-overlay-inner">
				<div id="loginform-overlay-content" class="wvc-font-dark">
					<a href="#" id="close-vertical-bar-menu-icon" class="close-panel-button close-loginform-button">X</a>
					<?php echo wvc_login_form(); ?>
				</div>
			</div>
		</div>
		<?php
	}
}
add_action( 'prequelle_body_start', 'prequelle_login_form_markup', 5 );

/**
 * Vertical Bar overlay markup
 */
function prequelle_vertical_bar_newsletter_markup() {

	if ( get_post_meta( get_the_ID(), '_post_disable_vertical_bar', true ) ) {
		return;
	}

	if ( 'toggle_newsletter' === prequelle_get_inherit_mod( 'vertical_bar_content_type_top' ) || 'toggle_newsletter' === prequelle_get_inherit_mod( 'vertical_bar_content_type_middle' ) || 'toggle_newsletter' === prequelle_get_inherit_mod( 'vertical_bar_content_type_bottom' ) ) :

		$color_tone = prequelle_get_color_tone( prequelle_get_inherit_mod( 'vertical_bar_bg_color' ) );
		$font_class = 'light' ===  $color_tone ? 'wvc-font-dark' : 'wvc-font-light';
	?>
	<div id="vertical-bar-newsletter" class="vb-newsletter-<?php echo esc_attr( $color_tone ); ?>">
		<a href="#" id="close-vertical-bar-menu-icon" class="close-panel-button toggle-vertical-bar-newsletter">X</a>
		<div id="vertical-bar-newsletter-inner">
			<div id="vertical-bar-newsletter-content" class="<?php echo esc_attr( $font_class ); ?>">
				<?php
					if ( function_exists( 'wvc_mailchimp' ) ) {
						echo wvc_mailchimp( array(
							'size' => 'large',
							'show_bg' => false,
							'show_label' => true,
							'text_alignment' => 'left',
						) );
					}
				?>
			</div>
		</div>
	</div>
	<?php endif;
}
add_action( 'prequelle_body_start', 'prequelle_vertical_bar_newsletter_markup', 5 );

/**
 * Vertical bar shop menu icons
 */
function prequelle_vertical_bar_shop_icons() {

	?>
	<?php if ( prequelle_display_cart_menu_item() ) : ?>
		<div class="cart-container vertical-cta-item">
			<?php
				/**
				 * Cart icon
				 */
				prequelle_cart_menu_item();

				
				/**
				 * Cart panel
				 */
				echo prequelle_cart_panel();
			?>
		</div><!-- .cart-container -->
	<?php endif ?>
	<?php if ( prequelle_display_wishlist_menu_item() ) : ?>
		<div class="wishlist-container vertical-cta-item">
			<?php
				/**
				 * Wishlist icon
				 */
				prequelle_wishlist_menu_item();
			?>
		</div><!-- .cart-container -->
	<?php endif ?>
	<?php if ( prequelle_display_account_menu_item() ) : ?>
		<div class="account-container vertical-cta-item">
			<?php
				/**
				 * account icon
				 */
				prequelle_account_menu_item();
			?>
		</div><!-- .cart-container -->
	<?php endif ?>
	<?php if ( prequelle_display_shop_search_menu_item() ) : ?>
		<div class="search-container vertical-cta-item">
			<?php
				/**
				 * Search
				 */
				prequelle_search_menu_item();
			?>
		</div><!-- .search-container -->
	<?php endif ?>
	<?php
}

/**
 * Vertical bar content choices
 */
function prequelle_get_vertical_bar_content_choices() {
	$vertical_bar_content_type_choices = array(
		'' => '&mdash;'  .esc_html__( 'None', 'prequelle' ) . '&mdash;',
		'socials' => esc_html__( 'Socials', 'prequelle' ),
		'tertiary_nav' => esc_html__( 'Tertiary Menu', 'prequelle' ),
		'toggle_panel' => esc_html__( 'Toggle Panel (vertical bar widgets area content)', 'prequelle' ),
		'toggle_overlay_menu' => esc_html__( 'Toggle Overlay Menu', 'prequelle' ),
		'tagline' => esc_html__( 'Tagline or Copyright Text', 'prequelle' ),
	);

	if ( class_exists( 'Wolf_Vc_Content_Block' ) && defined( 'WPB_VC_VERSION' ) ) {
		$vertical_bar_content_type_choices['toggle_overlay'] = esc_html__( 'Toggle Overlay (set the overlay content below)', 'prequelle' );
	}

	if ( class_exists( 'Wolf_Visual_Composer' ) && defined( 'WPB_VC_VERSION' ) ) {
		$vertical_bar_content_type_choices['toggle_newsletter'] = esc_html__( 'Toggle Newsletter Pop-up', 'prequelle' );
	}

	if ( class_exists( 'WooCommerce' ) ) {
		$vertical_bar_content_type_choices['shop_icons'] = esc_html__( 'Shop Icons', 'prequelle' );
	}

	return $vertical_bar_content_type_choices;
}

/**
 * Get vertical bar content
 */
function prequelle_vertical_bar_content( $part = 'middle' ) {
	$c_type = prequelle_get_inherit_mod( 'vertical_bar_content_type_' . $part );

	if ( 'socials' === $c_type ) { ?>
		<?php
			if ( prequelle_is_wvc_activated() && function_exists( 'wvc_socials' ) ) {
				echo wvc_socials( array( 'services' => prequelle_get_inherit_mod( 'vertical_bar_socials', 'facebook,twitter,instagram' ), ) );
			}
		?>
		<?php } else if ( 'tertiary_nav' === $c_type ) { ?>
			<?php wp_nav_menu( prequelle_get_menu_args( 'tertiary', 'vertical-bar' ) ); ?>
		<?php } else if ( 'shop_icons' === $c_type ) { ?>
			<?php prequelle_vertical_bar_shop_icons(); ?>
		<?php } else if ( 'toggle_panel' === $c_type ) { ?>
				<div class="vertical-bar-hamburger">
				<?php prequelle_hamburger_icon( 'toggle-vertical-bar-panel' ); ?>
				</div>
		<?php } else if ( 'toggle_overlay' === $c_type ) { ?>
				<div class="vertical-bar-hamburger">
					<?php prequelle_hamburger_icon( 'toggle-vertical-bar-overlay' ); ?>
				</div>
		<?php } else if ( 'toggle_overlay_menu' === $c_type ) { ?>
				<div class="vertical-bar-hamburger">
					<?php prequelle_hamburger_icon( 'toggle-overlay-menu' ); ?>
				</div>
		<?php } else if ( 'toggle_newsletter' === $c_type ) { ?>
				<div class="newsletter-icon-container vertical-cta-item">
					<span title="<?php esc_html_e( 'Newsletter', 'prequelle' ); ?>" class="fa dripicons-mail toggle-vertical-bar-newsletter"></span>
				</div>
		<?php } else if ( 'tagline' === $c_type ) { ?>
				<div class="vertical-bar-tagline">
					<?php echo prequelle_get_inherit_mod( 'vertical_bar_tagline' ); ?>
				</div>
		<?php }
}

/**
 * Output overlay menu if "toggle_overlay_menu" option is set in vertical bar
 */
function prequelle_do_output_overlay_menu() {
	?>
	<div class="overlay-menu-panel">
		<?php
			/**
			 * overlay_menu_panel_start hook
			 */
			do_action( 'prequelle_overlay_menu_panel_start' );
		?>
		<div class="overlay-menu-table">
			<div class="overlay-menu-panel-inner">
				<div class="menu-container" itemscope="itemscope"  itemtype="http://schema.org/SiteNavigationElement">
					<?php
						/**
						 * Menu
						 */
						prequelle_primary_vertical_navigation();
					?>
				</div>
			</div><!-- .overlay-menu-panel-inner -->
		</div>
	</div><!-- .overlay-menu-panel -->
	<?php
}
add_action( 'prequelle_main_navigation', 'prequelle_do_output_overlay_menu' );

/**
 * Register blog and page sidebar and footer widget area.
 */
function prequelle_register_vertical_bar_sidebar() {

	register_sidebar(
		array(
			'name'          		=> esc_html__( 'Vertical Bar Panel Sidebar', 'prequelle' ),
			'id'            		=> 'sidebar-vertical-bar',
			'description'		=> esc_html__( 'Add widgets here to appear in the vertical bar panel.', 'prequelle' ),
			'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  		=> '</div></aside>',
			'before_title' 	 	=> '<h3 class="widget-title">',
			'after_title'  	 	=> '</h3>',
		)
	);

	unregister_sidebar( 'sidebar-side-panel' );
}
add_action( 'widgets_init', 'prequelle_register_vertical_bar_sidebar' );

/**
 * Get available display options for posts
 *
 * @return array
 */
function prequelle_set_post_display_options() {

	return array(
		'standard' => esc_html__( 'Standard', 'prequelle' ),
		'metro_modern_alt' => esc_html__( 'Metro', 'prequelle' ),
		'grid_classic' => esc_html__( 'Grid', 'prequelle' ),
	);
}
add_filter( 'prequelle_post_display_options', 'prequelle_set_post_display_options' );

/**
 * Get available display options for pages
 *
 * @return array
 */
function prequelle_set_page_display_options() {

	return array(
		'grid_overlay' => esc_html__( 'Image Grid', 'prequelle' ),
		'masonry' => esc_html__( 'Masonry', 'prequelle' ),
	);
}
add_filter( 'prequelle_page_display_options', 'prequelle_set_page_display_options' );

/**
 * Get available display options for works
 *
 * @return array
 */
function prequelle_set_work_display_options() {

	return array(
		'grid' => esc_html__( 'Grid', 'prequelle' ),
		'masonry' => esc_html__( 'Masonry', 'prequelle' ),
	);
}
add_filter( 'prequelle_work_display_options', 'prequelle_set_work_display_options' );

/**
 * Set portfolio template folder
 */
function prequelle_set_portfolio_template_url( $template_url ) {

	return 'portfolio/';
}
add_filter( 'wolf_portfolio_template_url', 'prequelle_set_portfolio_template_url' );

/**
 * Set mobile menu template
 *
 * @param string $string
 * @return string
 */
function prequelle_set_mobile_menu_template( $string ) {

	return 'content-mobile-alt';
}
add_filter( 'prequelle_mobile_menu_template', 'prequelle_set_mobile_menu_template' );

/**
 * Add mobile closer overlay
 */
function prequelle_add_mobile_panel_closer_overlay() {
	?>
	<div id="mobile-panel-closer-overlay" class="panel-closer-overlay toggle-mobile-menu"></div>
	<?php
}
add_action( 'prequelle_main_content_start', 'prequelle_add_mobile_panel_closer_overlay' );

/**
 * Add mobile alt body class
 *
 * @param array
 * @return array
 */
function prequelle_add_mobile_lat_menu_body_class( $classes ) {

	$classes[] = 'mobile-menu-alt';

	$disable_bar = get_post_meta( get_the_ID(), '_post_disable_vertical_bar', true );

	if ( ! $disable_bar && ( prequelle_get_theme_mod( 'vertical_bar_content_type_top' ) || prequelle_get_theme_mod( 'vertical_bar_content_type_middle' ) || prequelle_get_theme_mod( 'vertical_bar_content_type_bottom' ) ) ) {
		$classes[] = 'has-vertical-bar';
	}

	if ( prequelle_get_inherit_mod( 'vertical_bar_transparent_at_top' ) ) {
		$classes[] = 'vertical-bar-transparent-at-top';
	}

	$sticky_details_meta = prequelle_get_inherit_mod( 'product_sticky' );
	$single_product_layout = prequelle_get_inherit_mod( 'product_single_layout' );
	
	if ( is_singular( 'product' ) && $sticky_details_meta && 'sidebar-right' !== $single_product_layout && 'sidebar-left' !== $single_product_layout ) {
		$classes[] = 'sticky-product-details';
	}

	return $classes;

}
add_filter( 'body_class', 'prequelle_add_mobile_lat_menu_body_class' );

/**
 * Off mobile menu
 */
function prequelle_mobile_alt_menu() {
	?>
	<div id="mobile-menu-panel">
		<a href="#" id="close-mobile-menu-icon" class="close-panel-button toggle-mobile-menu">X</a>
		<div id="mobile-menu-panel-inner">
		
		<?php
		
			/**
			 * Menu
			 */
			prequelle_primary_mobile_navigation();
		?>
		</div><!-- .mobile-menu-panel-inner -->
	</div><!-- #mobile-menu-panel -->
	<?php
}
add_action( 'prequelle_body_start', 'prequelle_mobile_alt_menu' );

/**
 * Add panel closer icon
 */
function prequelle_add_side_panel_close_button() {
	?>
	<a href="#" id="close-side-panel-icon" class="close-panel-button toggle-side-panel">X</a>
	<?php
}
add_action( 'prequelle_sidepanel_start', 'prequelle_add_side_panel_close_button' );

/**
 * Overwrite hamburger icon
 */
function prequelle_set_hamburger_icon( $html, $class, $title_attr ) {

	if ( 'toggle-side-panel' === $class || 'toggle-vertical-bar-panel' === $class ) {
		
		$title_attr = esc_html__( 'Side Panel', 'prequelle' );
	
	} elseif ( 'toggle-vertical-bar-overlay' === $class ) {

		$title_attr = esc_html__( 'Show Panel', 'prequelle' );
	
	} else {
		$title_attr = esc_html__( 'Menu', 'prequelle' );
	}

	ob_start();
	?>
	<a class="hamburger-icon hamburger-icon-vertical-bar <?php esc_attr_e( $class ); ?>" href="#" title="<?php esc_attr_e( $title_attr ); ?>">
		<span class="line line-first"></span>
		<span class="line line-second"></span>
		<span class="line line-third"></span>
		<span class="cross">
			<span></span>
			<span></span>
		</span>
	</a>
	<?php
	$html = ob_get_clean();

	return $html;

}
add_filter( 'wolfthemes_hamburger_icon', 'prequelle_set_hamburger_icon', 10, 3 );

/**
 * Filter fullPage Transition
 *
 * @return array
 */
function prequelle_set_fullpage_transition( $transition ) {

	if ( is_page() || is_single() ) {
		if ( get_post_meta( wvc_get_the_ID(), '_post_fullpage', true ) ) {
			$transition = get_post_meta( wvc_get_the_ID(), '_post_fullpage_transition', true );
		}
	}

	return $transition;
}
add_filter( 'wvc_fp_transition_effect', 'prequelle_set_fullpage_transition' );


add_filter( 'prequelle_entry_tag_list_separator', function() {
	return ', ';
} );

/**
 * Filter post modules
 *
 * @param array $atts
 * @return array $atts
 */
function prequelle_filter_post_module_atts( $atts ) {

	$post_type = $atts['post_type'];
	$affected_post_types = array( 'release' );

	if ( isset( $atts[ $post_type . '_hover_effect' ] ) ) {
		if ( 'cursor' === $atts[ $post_type . '_hover_effect' ] ) {
			
			$atts[ $post_type . '_layout' ] = 'standard';
			
			if ( 'list' === $post_type . '_display' ) {
				$atts[ $post_type . '_display' ] = 'grid';
			}
		}

		if ( 'splatters' === $atts[ $post_type . '_hover_effect' ] ) {
			$atts[ $post_type . '_layout' ] = 'overlay';
			$atts[ 'overlay_color' ] = '';
		}

		if ( 'slide-up' === $atts[ $post_type . '_hover_effect' ] ) {
			$atts[ $post_type . '_layout' ] = 'overlay';
			$atts[ 'overlay_color' ] = 'auto';
		}
	}

	return $atts;
}
add_filter( 'prequelle_post_module_atts', 'prequelle_filter_post_module_atts' );

/**
 * No header post types
 */
function prequelle_filter_no_hero_post_types( $post_types ) {

	$post_types = array( 'product', 'attachment', 'wpm_playlist' );

	return $post_types;
}
add_filter( 'prequelle_no_header_post_types', 'prequelle_filter_no_hero_post_types', 40 );

function prequelle_show_shop_header_content_block_single_product( $bool ) {

	if ( is_singular( 'product' ) ) {
		$bool = true;
	}
	
	return $bool;
}
add_filter( 'prequelle_force_display_shop_after_header_block', 'prequelle_show_shop_header_content_block_single_product' );


/**
 * Disable single post pagination
 *
 * @param bool $bool
 * @return bool
 */
add_filter( 'prequelle_disable_single_post_pagination', '__return_true' );

/**
 * Disable forcing shop icons in menu on WC pages
 * Shop icons are most likely in the vertical bar
 *
 * @param bool
 * @return bool
 */
function prequelle_filter_force_display_nav_shop_icons( $bool ) {

	$disable_bar = get_post_meta( get_the_ID(), '_post_disable_vertical_bar', true );

	if ( ! $disable_bar && ( 'shop_icons' === prequelle_get_theme_mod( 'vertical_bar_content_type_top' ) || 'shop_icons' === prequelle_get_theme_mod( 'vertical_bar_content_type_middle' ) || 'shop_icons' === prequelle_get_theme_mod( 'vertical_bar_content_type_bottom' ) ) ) {
		$bool = false;
	}

	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	return $bool;
}
add_filter( 'prequelle_force_display_nav_shop_icons', 'prequelle_filter_force_display_nav_shop_icons' );
add_filter( 'prequelle_force_nav_search_product', 'prequelle_filter_force_display_nav_shop_icons' );

/**
 * Quickview product excerpt lenght
 */
add_filter( 'wwcqv_excerpt_length', function() {
	return 28;
} );

/**
 * After quickview summary hook
 */
add_action( 'wwcqv_product_summary', function() {
	?>
	<hr>
	<div class="single-add-to-wishlist">
		<span class="single-add-to-wishlist-label"><?php esc_html_e( 'Wishlist', 'prequelle' ); ?></span>
		<?php prequelle_add_to_wishlist(); ?>
	</div><!-- .single-add-to-wishlist -->
	<hr>
	<p><a class="wvc-button wvc-button-size-sm prequelle-button-simple" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View details', 'prequelle' ); ?></a></p>
	<?php
}, 30 );

/**
 * Product stacked images + sticky details
 */
function prequelle_single_product_sticky_layout() {

	if ( ! prequelle_get_inherit_mod( 'product_sticky' ) ) {
		return;
	}

	/* Remove default images */
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

	global $product;

	$product_id = $product->get_id();

	echo '<div class="images">';

	woocommerce_show_product_sale_flash();
	/**
	 * If gallery
	 */
	$attachment_ids = $product->get_gallery_image_ids();

	if ( is_array( $attachment_ids ) && ! empty( $attachment_ids ) ) {

		echo '<ul>';

		if ( has_post_thumbnail( $product_id ) ) {
			?>
			<li class="stacked-image">
				<a class="lightbox" data-fancybox="wc-stacked-images-<?php echo absint( $product_id ); ?>" href="<?php echo get_the_post_thumbnail_url( $product_id, 'full' ); ?>">
					<?php echo $product->get_image( 'large' ); ?>
				</a>
			</li>
			<?php
		}

		foreach ( $attachment_ids as $attachment_id ) {
			if ( wp_attachment_is_image( $attachment_id ) ) {
				?>
				<li class="stacked-image">
					<a class="lightbox" data-fancybox="wc-stacked-images-<?php echo absint( $product_id ); ?>" href="<?php echo wp_get_attachment_url( $attachment_id, 'full' ); ?>">
						<?php echo wp_get_attachment_image( $attachment_id, 'large' ); ?>
					</a>
				</li>
				<?php
			}
		}

		echo '</ul>';

	/**
	 * If featured image only
	 */
	} elseif ( has_post_thumbnail( $product_id ) ) {
		?>
		<span class="stacked-image">
			<a class="lightbox" data-fancybox="wc-stacked-images-<?php echo absint( $product_id ); ?>" href="<?php echo get_the_post_thumbnail_url( $product_id, 'full' ); ?>">
				<?php echo $product->get_image( 'large' ); ?>
			</a>
		</span>
		<?php

	/**
	 * Placeholder
	 */
	} else {
		
		$html  = '<span class="woocommerce-product-gallery__image--placeholder">';
		$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
		$html .= '</span>';

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
	}

	echo '</div>';
}
add_action( 'woocommerce_before_single_product_summary', 'prequelle_single_product_sticky_layout' );

/**
 * Read more text
 */
function prequelle_view_post_text( $string ) {
	return esc_html__( 'Read more', 'prequelle' );
}
add_filter( 'prequelle_view_post_text', 'prequelle_view_post_text' );

/**
 * Search form placeholder
 */
function prequelle_set_searchform_placeholder( $string ) {
	return esc_attr_x( 'Search&hellip;', 'placeholder', 'prequelle' );
}
add_filter( 'prequelle_searchform_placeholder', 'prequelle_set_searchform_placeholder', 40 );

/**
 * Filter WVC theme accent color
 *
 * @param string $color
 * @return string $color
 */
function prequelle_set_wvc_secondary_theme_accent_color( $color ) {
	return prequelle_get_inherit_mod( 'secondary_accent_color' );
}
add_filter( 'wvc_theme_secondary_accent_color', 'prequelle_set_wvc_theme_secondary_accent_color' );

/**
 * Add theme secondary accent color to shared colors
 *
 * @param array $colors
 * @return array $colors
 */
function prequelle_wvc_add_secondary_accent_color_option( $colors ) {

	$colors = array( esc_html__( 'Theme Secondary Accent Color', 'prequelle' ) => 'secondary_accent' ) + $colors;

	return $colors;
}
add_filter( 'wvc_shared_colors', 'prequelle_wvc_add_secondary_accent_color_option' );

/**
 * Filter WVC shared color hex
 *
 * @param array $colors
 * @return array $colors
 */
function prequelle_add_secondary_accent_color_hex( $colors ) {
	
	$secondary_accent_color = get_theme_mod( 'secondary_accent_color' );

	if ( $secondary_accent_color ) {
		$colors['secondary_accent'] = $secondary_accent_color;
	}

	return $colors;
}
add_filter( 'wvc_shared_colors_hex', 'prequelle_add_secondary_accent_color_hex' );

/**
 * Add form in no result page
 */
function prequelle_add_no_result_form() {
	get_search_form();
}
add_action( 'prequelle_no_result_end', 'prequelle_add_no_result_form' );

/**
 * Set release taxonomy before string
 */
function prequelle_set_breadcrump_delimiter( $string ) {

	return ' &mdash; ';

}
add_filter( 'wvc_breadcrumb_delimiter', 'prequelle_set_breadcrump_delimiter' );

/**
 * Remove unused mods
 */
function prequelle_remove_mods( $mods ) {
	unset( $mods['layout']['options']['button_style'] );
	unset( $mods['layout']['options']['site_layout'] );
	
	unset( $mods['fonts']['options']['body_font_size'] );

	unset( $mods['navigation']['options']['menu_hover_style'] );
	unset( $mods['navigation']['options']['side_panel_position'] );
	unset( $mods['navigation']['options']['menu_layout']['choices']['lateral'] );
	unset( $mods['navigation']['options']['menu_layout']['choices']['offcanvas'] );
	unset( $mods['navigation']['options']['menu_layout']['choices']['overlay'] );

	unset( $mods['header_settings']['options']['hero_scrolldown_arrow'] );
	
	unset( $mods['blog']['options']['post_display'] );

	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_remove_mods', 20 );

function prequelle_add_menu_cta_content_type_options( $array ) {

	if ( class_exists( 'WooCommerce' ) ) {
		$array['search_product_icon'] = esc_html__( 'Search Product Icon', 'prequelle' );
	}

	return $array;
}
add_filter( 'prequelle_menu_cta_content_type_options', 'prequelle_add_menu_cta_content_type_options' );

/**
 * Disable parallax effect in masonry
 *
 * @param string $string
 * @return string
 */
function prequelle_disable_masonry_parallax_effect( $string ) {

	return 'none';
}
add_filter( 'prequelle_masonry_modern_image_format_effect', 'prequelle_disable_masonry_parallax_effect' );

/**
 * Albums masonry thumbnail size
 */
function prequelle_set_portfolio_masonry_thumbnail_size( $size ) {

	return 'prequelle-masonry-small';

}
add_filter( 'prequelle_portfolio_masonry_thumbnail_size', 'prequelle_set_portfolio_masonry_thumbnail_size' );

/**
 * Filter single work title
 *
 * @param string $string
 * @return string
 */
function prequelle_set_single_work_title( $string ) {

	return esc_html__( 'Details & Info', 'prequelle' );
}
add_filter( 'prequelle_single_work_title', 'prequelle_set_single_work_title', 40 );

/**
 * Add theme button option
 */
function prequelle_add_button_dependency_params() {

	if ( ! class_exists( 'WPBMap' ) || ! class_exists( 'Wolf_Visual_Composer' ) || ! defined( 'WVC_OK' ) || ! WVC_OK ) {
		return;
	}

	$param = WPBMap::getParam( 'vc_button', 'color' );
	$param['dependency'] = array(
		'element' => 'button_type',
		'value' => 'default',
	);
	vc_update_shortcode_param( 'vc_button', $param );

	$param = WPBMap::getParam( 'vc_button', 'shape' );
	$param['dependency'] = array(
		'element' => 'button_type',
		'value' => 'default',
	);
	vc_update_shortcode_param( 'vc_button', $param );

	$param = WPBMap::getParam( 'vc_button', 'hover_effect' );
	$param['dependency'] = array(
		'element' => 'button_type',
		'value' => 'default',
	);
	vc_update_shortcode_param( 'vc_button', $param );

	$param = WPBMap::getParam( 'vc_cta', 'btn_color' );
	$param['dependency'] = array(
		'element' => 'btn_button_type',
		'value' => 'default',
	);
	
	vc_update_shortcode_param( 'vc_cta', $param );

	$param = WPBMap::getParam( 'vc_cta', 'btn_shape' );
	$param['dependency'] = array(
		'element' => 'btn_button_type',
		'value' => 'default',
	);
	vc_update_shortcode_param( 'vc_cta', $param );

	$param = WPBMap::getParam( 'vc_cta', 'btn_hover_effect' );
	$param['dependency'] = array(
		'element' => 'btn_button_type',
		'value' => 'default',
	);
	vc_update_shortcode_param( 'vc_cta', $param );
}
add_action( 'init', 'prequelle_add_button_dependency_params' );

/**
 * Filter button attribute
 *
 * @param array $atts
 * @return array $atts
 */
function woltheme_filter_button_atts( $atts ) {
	if ( isset( $atts['button_type'] ) && 'default' !== $atts['button_type'] ) {
		$atts['shape'] = '';
		$atts['color'] = '';
		$atts['hover_effect'] = '';

		if ( prequelle_is_edge() && ( 'prequelle-button-special' === $atts['button_type'] ) ) {
			$atts['button_type'] = 'prequelle-button-outline';
		}

		$atts['el_class'] .= ' ' . $atts['button_type'];
	}

	return $atts;
}
add_filter( 'wvc_button_atts', 'woltheme_filter_button_atts' );

/**
 * Filter CTA button attribute
 *
 * @param array $atts the shortcode atts we get
 * @param array $btn_params the button attribute to filter
 * @return array $btn_params
 */
function woltheme_filter_cta_button_atts( $btn_params, $atts ) {
	if ( isset( $atts['btn_button_type'] ) && 'default' !== $atts['btn_button_type'] ) {
		$btn_params['shape'] = '';
		$btn_params['color'] = '';
		$btn_params['hover_effect'] = '';
		$btn_params['el_class'] .= ' ' . $atts['btn_button_type'];
	}

	return $btn_params;
}
add_filter( 'wvc_cta_button_atts', 'woltheme_filter_cta_button_atts', 10, 2 );

/**
 * Add theme button option to Button element
 */
function prequelle_add_theme_buttons() {

	if ( function_exists( 'vc_add_params' ) ) {
		vc_add_params(
			'vc_button',
			array(
				array(
					'heading' => esc_html__( 'Button Type', 'prequelle' ),
					'param_name' => 'button_type',
					'type' => 'dropdown',
					'value' => prequelle_custom_button_types(),
					'weight' => 1000,
				),
			)
		);

		vc_add_params(
			'vc_cta',
			array(
				array(
					'heading' => esc_html__( 'Button Type', 'prequelle' ),
					'param_name' => 'btn_button_type',
					'type' => 'dropdown',
					'value' => prequelle_custom_button_types(),
					'weight' => 10,
					'group' => esc_html__( 'Button', 'prequelle' ),
				),
			)
		);

		vc_add_params(
			'wvc_advanced_slide',
			array(
				array(
					'heading' => esc_html__( 'Button Type', 'prequelle' ),
					'param_name' => 'b1_button_type',
					'type' => 'dropdown',
					'value' => prequelle_custom_button_types(),
					'weight' => 10,
					'group' => esc_html__( 'Button 1', 'prequelle' ),
					'dependency' => array(
						'element' => 'add_button_1',
						'value' => array( 'true' ),
					),
				),
			)
		);

		vc_add_params(
			'wvc_advanced_slide',
			array(
				array(
					'heading' => esc_html__( 'Button Type', 'prequelle' ),
					'param_name' => 'b2_button_type',
					'type' => 'dropdown',
					'value' => prequelle_custom_button_types(),
					'weight' => 10,
					'group' => esc_html__( 'Button 2', 'prequelle' ),
					'dependency' => array(
						'element' => 'add_button_2',
						'value' => array( 'true' ),
					),
				),
			)
		);

		vc_add_params(
			'vc_custom_heading',
			array(
				array(
					'heading' => esc_html__( 'Style', 'prequelle' ),
					'param_name' => 'style',
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Theme Style', 'prequelle' ) => 'prequelle-heading',
						esc_html__( 'Default', 'prequelle' ) => '',
					),
					'weight' => 10,
				),
			)
		);
	}
}
add_action( 'init', 'prequelle_add_theme_buttons' );

/**
 * Filter button attribute
 *
 * @param array $atts
 * @return array $atts
 */
function woltheme_filter_heading_atts( $atts ) {
	if ( isset( $atts['style'] ) ) {
		$atts['el_class'] .= $atts['el_class'] . ' ' . $atts['style'];
	}

	return $atts;
}
add_filter( 'wvc_heading_atts', 'woltheme_filter_heading_atts' );

/**
 * Add work hover effects
 */
function prequelle_add_work_hover_effects() {
	if ( function_exists( 'vc_add_params' ) ) {
		vc_add_params(
			'wvc_work_index',
			array(
				array(
					'heading' => esc_html__( 'Hover Effect', 'prequelle' ),
					'param_name' => 'work_hover_effect',
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Underline', 'prequelle' ) => 'default',
						esc_html__( 'Big White Border', 'prequelle' ) => 'border',
						esc_html__( 'Simple', 'prequelle' ) => 'simple',
					),
					'dependency' => array(
						'element' => 'work_display',
						'value_not_equal_to' => array( 'list_minimal' )
					),
				),
			)
		);
	}
}

/**
 *  Set default button shape
 *
 * @param string $shape
 * @return string $shape
 */
function prequelle_set_default_wvc_button_shape( $shape ) {
	return 'boxed';
}
add_filter( 'wvc_default_button_shape', 'prequelle_set_default_wvc_button_shape', 40 );

/**
 *  Set default button shape
 *
 * @param string $shape
 * @return string $shape
 */
function prequelle_set_default_theme_button_shape( $shape ) {
	return 'square';
}
add_filter( 'prequelle_mod_button_style', 'prequelle_set_default_theme_button_shape', 40 );

/**
 *  Set default button font weight
 *
 * @param string $shape
 * @return string $shape
 */
function prequelle_set_default_wvc_button_font_weight( $font_weight ) {
	return 400;
}
add_filter( 'wvc_button_default_font_weight', 'prequelle_set_default_wvc_button_font_weight', 40 );

/**
 *  Set default pie chart line width
 *
 * @param string $width
 * @return string $width
 */
function wvc_set_default_pie_chart_line_width( $width ) {

	return 2;
}
add_filter( 'wvc_default_pie_chart_line_width', 'wvc_set_default_pie_chart_line_width', 40 );

/**
 *  Set default team member v align
 *
 * @param string $string
 * @return string $string
 */
function wvc_set_default_team_member_text_vertical_alignement( $string ) {

	return 'bottom';
}
add_filter( 'wvc_default_team_member_text_vertical_alignement', 'wvc_set_default_team_member_text_vertical_alignement', 40 );

/**
 * Added selector to heading_family_selectors
 *
 * @param array $selectors
 * @return array $selectors
 */
function prequelle_add_heading_family_selectors( $selectors ) {

	$selectors[] = '.wvc-tabs-menu li a';
	$selectors[] = '.woocommerce-tabs ul.tabs li a';
	$selectors[] = '.wvc-process-number';
	$selectors[] = '.wvc-button';
	$selectors[] = '.button';
	$selectors[] = '.onsale';
	$selectors[] = '.entry-post-grid_classic .sticky-post';
	$selectors[] = 'input[type=submit], .wvc-mailchimp-submit';
	$selectors[] = '.nav-next,.nav-previous';
	$selectors[] = '.wvc-embed-video-play-button';
	$selectors[] = '.category-filter ul li';
	$selectors[] = '.wvc-ati-title';
	$selectors[] = '.cart-panel-buttons a';
	$selectors[] = '.wvc-team-member-role';
	$selectors[] = '.wvc-svc-item-tagline';
	$selectors[] = '.entry-metro_modern_alt insta-username';
	$selectors[] = '.wvc-testimonial-cite';
	$selectors[] = '.prequelle-button-dir-aware';
	$selectors[] = '.preqelle-button-dir-aware-alt';
	$selectors[] = '.prequelle-button-outline';
	$selectors[] = '.prequelle-button-outline-alt';
	$selectors[] = '.prequelle-button-simple';
	$selectors[] = '.wvc-wc-cat-title';
	$selectors[] = '.wvc-pricing-table-button a';
	$selectors[] = '.load-more-button-line';
	$selectors[] = '.view-post';
	$selectors[] = '.wolf-gram-follow-button';
	$selectors[] = '#prequelle-percent';

	return $selectors;
}
add_filter( 'prequelle_heading_family_selectors', 'prequelle_add_heading_family_selectors' );

/**
 * Added selector to heading_family_selectors
 *
 * @param array $selectors
 * @return array $selectors
 */
function prequelle_add_prequelle_heading_selectors( $selectors ) {

	$selectors[] = '.wvc-tabs-menu li a';
	$selectors[] = '.woocommerce-tabs ul.tabs li a';
	$selectors[] = '.wvc-process-number';

	$selectors[] = '.wvc-wc-cat-title';

	return $selectors;
}
add_filter( 'prequelle_heading_selectors', 'prequelle_add_prequelle_heading_selectors' );

/**
 *  Set default heading font size
 *
 * @param int $font_size
 * @return int $font_size
 */
function wvc_set_default_custom_heading_font_size( $font_size ) {
	return 24;
}
add_filter( 'wvc_default_custom_heading_font_size', 'wvc_set_default_custom_heading_font_size', 40 );
add_filter( 'wvc_default_advanced_slide_title_font_size', 'wvc_set_default_custom_heading_font_size', 40 );

/**
 *  Set default heading font size
 *
 * @param string $font_size
 * @return string $font_size
 */
function wvc_set_default_cta_font_size( $font_size ) {
	return 24;
}
add_filter( 'wvc_default_cta_font_size', 'wvc_set_default_cta_font_size', 40 );

/**
 *  Set default heading layout
 *
 * @param string $layout
 * @return string $layout
 */
function wvc_set_default_team_member_layout( $layout ) {
	return 'overlay';
}
add_filter( 'wvc_default_team_member_layout', 'wvc_set_default_team_member_layout', 40 );

/**
 *  Set default team member title font size
 *
 * @param string $font_size
 * @return string $font_size
 */
function wvc_set_default_team_member_font_size( $font_size ) {
	return 24;
}
add_filter( 'wvc_default_team_member_title_font_size', 'wvc_set_default_team_member_font_size', 40 );
add_filter( 'wvc_default_single_image_title_font_size', 'wvc_set_default_team_member_font_size', 40 );

/**
 * Primary buttons class
 *
 * @param string $string
 * @return string
 */
function prequelle_set_primary_button_class( $class ) {

	$prequelle_button_class = 'prequelle-button-outline';

	$class = $prequelle_button_class . ' wvc-button wvc-button-size-xs';

	return $class;
}
add_filter( 'wvc_last_posts_big_slide_button_class', 'prequelle_set_primary_button_class' );
add_filter( 'prequelle_404_button_class', 'prequelle_set_primary_button_class' );
add_filter( 'prequelle_post_product_button', 'prequelle_set_primary_button_class' );

/**
 * Main buttons class
 *
 * @param string $string
 * @return string
 */
function prequelle_set_alt_button_class( $class, $pagination_type ) {

		
	$class = 'load-more-button-line';

	return $class;
}
add_filter( 'prequelle_loadmore_button_class', 'prequelle_set_alt_button_class', 10, 2 );

/**
 * Author box buttons class
 *
 * @param string $string
 * @return string
 */
function prequelle_set_author_box_button_class( $class ) {

	$class = ' wvc-button wvc-button-size-xs prequelle-button-outline-alt';

	return $class;
}
add_filter( 'prequelle_author_page_link_button_class', 'prequelle_set_author_box_button_class' );


/**
 * Excerpt more
 *
 * Add span to allow more CSS tricks
 *
 * @return string
 */
function prequelle_custom_more_text( $string ) {

	$text = '<span>' . esc_html__( 'Read more', 'prequelle' ) . '</span>';

	return $text;
}
add_filter( 'prequelle_more_text', 'prequelle_custom_more_text', 40 );

/**
 * Filter empty p tags in excerpt
 */
function prequelle_filter_excerpt_empty_p_tags( $excerpt ) {

	return str_replace( '<p></p>', '', $excerpt );

}
add_filter( 'get_the_excerpt', 'prequelle_filter_excerpt_empty_p_tags', 100 );

/**
 * Set related posts text
 *
 * @param string $string
 * @return string
 */
function prequelle_set_related_posts_text( $text ) {

	return esc_html__( 'You May Also Like', 'prequelle' );
}
add_filter( 'prequelle_related_posts_text', 'prequelle_set_related_posts_text' );

/**
 *  Set default item overlay color
 *
 * @param string $color
 * @return string $color
 */
function prequelle_set_default_item_overlay_color( $color ) {
	return 'black';
}
add_filter( 'wvc_default_item_overlay_color', 'prequelle_set_default_item_overlay_color', 40 );

/**
 *  Set default item overlay text color
 *
 * @param string $color
 * @return string $color
 */
function prequelle_set_item_overlay_text_color( $color ) {
	return 'white';
}
add_filter( 'wvc_default_item_overlay_text_color', 'prequelle_set_item_overlay_text_color', 40 );

/**
 *  Set default item overlay opacity
 *
 * @param int $color
 * @return int $color
 */
function prequelle_set_item_overlay_opacity( $opacity ) {
	return 40;
}
add_filter( 'wvc_default_item_overlay_opacity', 'prequelle_set_item_overlay_opacity', 40 );

/**
 * Excerpt length hook
 * Set the number of character to display in the excerpt
 *
 * @param int $length
 * @return int
 */
function prequelle_overwrite_excerpt_length( $length ) {

	return 23;
}
add_filter( 'prequelle_excerpt_length', 'prequelle_overwrite_excerpt_length' );

/**
 * Excerpt length hook
 * Set the number of character to display in the excerpt
 *
 * @param int $length
 * @return int
 */
function prequelle_overwrite_sticky_menu_height( $length ) {

	return 55;
}
add_filter( 'prequelle_sticky_menu_height', 'prequelle_overwrite_sticky_menu_height' );

/**
 * Set menu hover effect
 *
 * @param string $string
 * @return string
 */
function prequelle_set_menu_hover_style( $string ) {

	return 'overline';
}
add_filter( 'prequelle_mod_menu_hover_style', 'prequelle_set_menu_hover_style' );

/**
 * Get available display options for products
 *
 * @return array
 */
function prequelle_set_product_display_options() {

	return array(
		'grid_overlay_quickview' => esc_html__( 'Grid', 'prequelle' ),
		'masonry_overlay_quickview' => esc_html__( 'Masonry', 'prequelle' ),
		'metro_overlay_quickview' => esc_html__( 'Metro', 'prequelle' ),
	);
}
add_filter( 'prequelle_product_display_options', 'prequelle_set_product_display_options' );

/**
 * Display sale label condition
 *
 * @param bool $bool
 * @return bool
 */
function prequelle_do_show_sale_label( $bool ) {

	if ( get_post_meta( get_the_ID(), '_post_product_label', true ) ) {
		$bool = true;
	}

	return $bool;
}
add_filter( 'prequelle_show_sale_label', 'prequelle_do_show_sale_label' );

/**
 * Sale label text
 *
 * @param string $string
 * @return string
 */
function prequelle_sale_label( $string ) {

	if ( get_post_meta( get_the_ID(), '_post_product_label', true ) ) {
		$string = '<span class="onsale">' . esc_attr( get_post_meta( get_the_ID(), '_post_product_label', true ) ) . '</span>';
	}

	return $string;
}
add_filter( 'woocommerce_sale_flash', 'prequelle_sale_label' );

/**
 * Set video display
 *
 * @param string $string
 * @return string
 */
function prequelle_set_video_display( $string ) {

	return 'grid';
}
add_filter( 'prequelle_mod_video_display', 'prequelle_set_video_display', 44 );

/**
 * Product quickview button
 *
 * @param string $string
 * @return string
 */
function prequelle_output_product_quickview_button() {

	if ( function_exists( 'wolf_quickview_button' ) ) {
		wolf_quickview_button();
	}
}
add_filter( 'prequelle_product_quickview_button', 'prequelle_output_product_quickview_button' );

/**
 * Product wishlist button
 *
 * @param string $string
 * @return string
 */
function prequelle_output_product_wishlist_button() {

	if ( function_exists( 'wolf_add_to_wishlist' ) ) {
		wolf_add_to_wishlist();
	}
}
add_filter( 'prequelle_add_to_wishlist_button', 'prequelle_output_product_wishlist_button' );

/**
 * Product Add to cart button
 *
 * @param string $string
 * @return string
 */
function prequelle_output_product_add_to_cart_button() {

	echo prequelle_add_to_cart(
		get_the_ID(),
		'quickview-product-add-to-cart product-quickview-button',
		'<span class="fa quickview-product-add-to-cart-icon" title="' . esc_attr( __( 'Add to cart', 'prequelle' ) ). '"></span>'
	);
}
add_filter( 'prequelle_product_add_to_cart_button', 'prequelle_output_product_add_to_cart_button' );

/**
 * Add mods
 *
 * @param array $mods
 * @return array $mods
 */
function prequelle_add_mods( $mods ) {

	$color_scheme = prequelle_get_color_scheme();

	$mods['colors']['options']['secondary_accent_color'] = array(
		'id' => 'secondary_accent_color',
		'label' => esc_html__( 'Secondary Accent Color', 'prequelle' ),
		'type' => 'color',
		'transport' => 'postMessage',
		'default' => $color_scheme[8],
	);

	$mods['loading'] = array(

		'id' => 'loading',
		'title' => esc_html__( 'Loading', 'prequelle' ),
		'icon' => 'update',
		'options' => array(

			array(
				'label' => esc_html__( 'Loading Animation Type', 'prequelle' ),
				'id' => 'loading_animation_type',
				'type' => 'select',
				'choices' => array(
					'none' => esc_html__( 'None', 'prequelle' ),
		 			'overlay' => esc_html__( 'Overlay', 'prequelle' ),
		 			'prequelle' => esc_html__( 'Overlay with animation', 'prequelle' ),
				),
			),
		),
	);

	$vertical_bar_content_type_choices = prequelle_get_vertical_bar_content_choices();

	$content_blocks = array(
		'' => '&mdash; ' . esc_html__( 'None', 'prequelle' ) . ' &mdash;',
	);

	if ( class_exists( 'Wolf_Visual_Composer' ) && class_exists( 'Wolf_Vc_Content_Block' ) && defined( 'WPB_VC_VERSION' ) ) {
		
		$content_block_posts = get_posts( 'post_type="wvc_content_block"&numberposts=-1' );

		$content_blocks = array(
			'' => '&mdash; ' . esc_html__( 'None', 'prequelle' ) . ' &mdash;',
		);
		if ( $content_block_posts ) {
			foreach ( $content_block_posts as $content_block_options ) {
				$content_blocks[ $content_block_options->ID ] = $content_block_options->post_title;
			}
		} else {
			$content_blocks[0] = esc_html__( 'No Content Block Yet', 'prequelle' );
		}
	}

	$mods['vertical_bar'] = array(
		'priority' => 40,
		'id' => 'vertical_bar',
		'title' => esc_html__( 'Vertical Bar', 'prequelle' ),
		'icon' => 'arrow-left-alt2',
		'options' => array(

			'vertical_bar_content_type_top' => array(
				'id' => 'vertical_bar_content_type_top',
				'label' => esc_html__( 'Content Type Top', 'prequelle' ),
				'type' => 'select',
				'choices' => $vertical_bar_content_type_choices,
			),

			'vertical_bar_content_type_middle' => array(
				'id' => 'vertical_bar_content_type_middle',
				'label' => esc_html__( 'Content Type Middle', 'prequelle' ),
				'type' => 'select',
				'choices' => $vertical_bar_content_type_choices,
			),

			'vertical_bar_content_type_bottom' => array(
				'id' => 'vertical_bar_content_type_bottom',
				'label' => esc_html__( 'Content Type Bottom', 'prequelle' ),
				'type' => 'select',
				'choices' => $vertical_bar_content_type_choices,
			),

			'vertical_bar_overlay_block_id' => array(
				'id' => 'vertical_bar_overlay_block_id',
				'label' => esc_html__( 'Overlay Content', 'prequelle' ),
				'type' => 'select',
				'description' => sprintf( prequelle_kses( __( 'If you choose the "Toggle Overlay" option above, select the <a href="%s" target="_blank">Content Block</a> to use as overlay content', 'prequelle' ) ), 'http://wlfthm.es/content-blocks' ),
				'choices' => $content_blocks,
			),

			'vertical_bar_socials' => array(
				'id' => 'vertical_bar_socials',
				'label' => esc_html__( 'Socials', 'prequelle' ),
				'type' => 'text',
				'description' => esc_html__( 'The list of social services to display if the "social icons" option is chosen. (eg: facebook,twitter,instagram)', 'prequelle' ),
			),

			'vertical_bar_tagline' => array(
				'id' => 'vertical_bar_tagline',
				'label' => esc_html__( 'Tagline', 'prequelle' ),
				'type' => 'text',
				'description' => esc_html__( 'A short text to display if the "tagline" option is chosen.', 'prequelle' ),
			),

			'vertical_bar_bg_color' => array(
				'id' => 'vertical_bar_bg_color',
				'label' => esc_html__( 'Background Color', 'prequelle' ),
				'type' => 'color',
			),

			'vertical_bar_font_color' => array(
				'id' => 'vertical_bar_font_color',
				'label' => esc_html__( 'Font Color', 'prequelle' ),
				'type' => 'color',
			),

			'vertical_bar_transparent_at_top' => array(
				'id' => 'vertical_bar_transparent_at_top',
				'label' => esc_html__( 'Transparent at top', 'prequelle' ),
				'type' => 'checkbox',
			),
		),
	);

	if ( isset( $mods['shop'] ) && class_exists( 'WooCommerce' ) ) {
		$mods['shop']['options']['product_sticky'] = array(
			'label'	=> esc_html__( 'Stacked Images with Sticky Product Details', 'prequelle' ),
			'id'	=> 'product_sticky',
			'type'	=> 'checkbox',
			'description' => esc_html__( 'Not compatible with sidebar layouts.', 'prequelle' ),
		);
		$mods['shop']['options']['product_thumbnail_padding'] = array(
			'label'	=> esc_html__( 'Product Thumbnail Padding', 'prequelle' ),
			'id'	=> 'product_thumbnail_padding',
			'type'	=> 'text',
		);
	}

	$mods['blog']['options']['post_hero_layout'] = array(
		'label'	=> esc_html__( 'Single Post Header Layout', 'prequelle' ),
		'id'	=> 'post_hero_layout',
		'type'	=> 'select',
		'choices' => array(
			'' => esc_html__( 'Default', 'prequelle' ),
			'standard' => esc_html__( 'Standard', 'prequelle' ),
			'big' => esc_html__( 'Big', 'prequelle' ),
			'small' => esc_html__( 'Small', 'prequelle' ),
			'fullheight' => esc_html__( 'Full Height', 'prequelle' ),
			'none' => esc_html__( 'No header', 'prequelle' ),
		),
	);

	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_add_mods', 40 );

/**
 * Custom button types
 */
function prequelle_custom_button_types() {
	return array(
		esc_html__( 'Default', 'prequelle' ) => 'default',
		esc_html__( 'Special', 'prequelle' ) => 'prequelle-button-special',
		esc_html__( 'Outline', 'prequelle' ) => 'prequelle-button-outline',
		esc_html__( 'Outline Secondary', 'prequelle' ) => 'prequelle-button-outline-alt',
		esc_html__( 'Simple', 'prequelle' ) => 'prequelle-button-simple',
		
	);
}

/**
 * Remove some params
 */
function prequelle_remove_vc_params() {

	if ( function_exists( 'vc_remove_element' ) ) {
		vc_remove_element( 'wvc_page_index' );
		vc_remove_element( 'wvc_interactive_overlays' );
	}

	if ( function_exists( 'vc_remove_param' ) ) {
		vc_remove_param( 'wvc_product_index', 'product_text_align' );
	
		vc_remove_param( 'wvc_interactive_links', 'align' );
		vc_remove_param( 'wvc_interactive_links', 'display' );
		vc_remove_param( 'wvc_interactive_overlays', 'align' );
		vc_remove_param( 'wvc_interactive_overlays', 'display' );

		vc_remove_param( 'wvc_team_member', 'layout' );
		vc_remove_param( 'wvc_team_member', 'alignment' );
		vc_remove_param( 'wvc_team_member', 'v_alignment' );
	}
}
add_action( 'init', 'prequelle_remove_vc_params' );

/**
 *  Set smooth scroll speed
 *
 * @param string $speed
 * @return string $speed
 */
function prequelle_set_smooth_scroll_speed( $speed ) {
	return 1400;
}
add_filter( 'prequelle_smooth_scroll_speed', 'prequelle_set_smooth_scroll_speed' );
add_filter( 'wvc_smooth_scroll_speed', 'prequelle_set_smooth_scroll_speed' );

/**
 *  Set smooth scroll speed
 *
 * @param string $speed
 * @return string $speed
 */
function prequelle_set_fp_anim_time( $speed ) {

	$speed = 1000;

	if ( is_page() || is_single() ) {
		if ( get_post_meta( prequelle_get_the_ID(), '_post_fullpage_animtime', true ) ) {
			$speed = absint( get_post_meta( prequelle_get_the_ID(), '_post_fullpage_animtime', true ) );
		}
	}

	return $speed;
}
add_filter( 'wvc_fp_animtime', 'prequelle_set_fp_anim_time', 40 );

/**
 * Add additional JS scripts and functions
 */
function prequelle_enqueue_additional_scripts() {
	
	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : prequelle_get_theme_version();

	if ( ! prequelle_is_wvc_activated() ) {
		wp_register_style( 'dripicons', get_template_directory_uri() . '/assets/css/lib/fonts/dripicons-v2/dripicons.min.css', array(), prequelle_get_theme_version() );

		wp_register_script( 'countup', get_template_directory_uri() . '/assets/js/lib/countUp.min.js', array(), '1.9.3', true );
	}

	wp_enqueue_style( 'dripicons' );

	wp_enqueue_script( 'countup' );

	wp_enqueue_script( 'jquery-effects-core' );
	wp_enqueue_script( 'prequelle-custom', get_template_directory_uri() . '/assets/js/t/prequelle.js', array( 'jquery' ), $version, true );
}
add_action( 'wp_enqueue_scripts', 'prequelle_enqueue_additional_scripts', 100 );

/**
 *  Set smooth scroll easing effect
 *
 * @param string $ease
 * @return string $ease
 */
function prequelle_set_smooth_scroll_ease( $ease ) {
	return 'easeOutCubic';
}
add_filter( 'prequelle_smooth_scroll_ease', 'prequelle_set_smooth_scroll_ease' );
add_filter( 'wvc_smooth_scroll_ease', 'prequelle_set_smooth_scroll_ease' );
add_filter( 'wvc_fp_easing', 'prequelle_set_smooth_scroll_ease' );

/**
 * Returns CSS for the color schemes.
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function prequelle_edit_color_scheme_css( $output, $colors ) {

	extract( $colors );

	$output = '';

	$border_color = vsprintf( 'rgba( %s, 0.08)', prequelle_hex_to_rgb( $strong_text_color ) );
	$overlay_panel_bg_color = vsprintf( 'rgba( %s, 0.95)', prequelle_hex_to_rgb( $submenu_background_color ) );

	$link_selector = '.link, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):not(.gallery-quickview)';
	$link_selector_after = '.link:after, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):not(.gallery-quickview):after';

	$output .= "/* Color Scheme */

	/* Body Background Color */
	body,
	.frame-border{
		background-color: $body_background_color;
	}

	/* Page Background Color */
	.site-header,
	.post-header-container,
	.content-inner,
	#logo-bar,
	.nav-bar,
	.loading-overlay,
	.no-hero #hero,
	.wvc-font-default,
	#topbar{
		background-color: $page_background_color;
	}

	.spinner:before,
	.spinner:after{
		background-color: $page_background_color;
	}

	/* Submenu color */
	#site-navigation-primary-desktop .mega-menu-panel,
	#site-navigation-primary-desktop ul.sub-menu,
	#mobile-menu-panel,
	.offcanvas-menu-panel,
	.lateral-menu-panel{
		background:$submenu_background_color;
	}

	.menu-hover-style-border-top .nav-menu li:hover,
	.menu-hover-style-border-top .nav-menu li.current_page_item,
	.menu-hover-style-border-top .nav-menu li.current-menu-parent,
	.menu-hover-style-border-top .nav-menu li.current-menu-ancestor,
	.menu-hover-style-border-top .nav-menu li.current-menu-item,
	.menu-hover-style-border-top .nav-menu li.menu-link-active{
		box-shadow: inset 0px 5px 0px 0px $submenu_background_color;
	}

	.menu-hover-style-plain .nav-menu li:hover,
	.menu-hover-style-plain .nav-menu li.current_page_item,
	.menu-hover-style-plain .nav-menu li.current-menu-parent,
	.menu-hover-style-plain .nav-menu li.current-menu-ancestor,
	.menu-hover-style-plain .nav-menu li.current-menu-item,
	.menu-hover-style-plain .nav-menu li.menu-link-active{
		background:$submenu_background_color;
	}

	.panel-closer-overlay{
		background:$submenu_background_color;
	}

	.overlay-menu-panel{
		background:$overlay_panel_bg_color;
	}

	/* Sub menu Font Color */
	.nav-menu-desktop li ul li:not(.menu-button-primary):not(.menu-button-secondary) .menu-item-text-container,
	.nav-menu-desktop li ul.sub-menu li:not(.menu-button-primary):not(.menu-button-secondary).menu-item-has-children > a:before,
	.nav-menu-desktop li ul li.not-linked > a:first-child .menu-item-text-container{
		color: $submenu_font_color;
	}

	.nav-menu-vertical li a,
	.nav-menu-mobile li a,
	.nav-menu-vertical li.menu-item-has-children:before,
	.nav-menu-vertical li.page_item_has_children:before,
	.nav-menu-vertical li.active:before,
	.nav-menu-mobile li.menu-item-has-children:before,
	.nav-menu-mobile li.page_item_has_children:before,
	.nav-menu-mobile li.active:before{
		color: $submenu_font_color!important;
	}

	.nav-menu-desktop li ul.sub-menu li.menu-item-has-children > a:before{
		color: $submenu_font_color;
	}

	body.wolf.side-panel-toggle.menu-style-transparent .hamburger-icon .line,
	body.wolf.side-panel-toggle.menu-style-semi-transparent-white .hamburger-icon .line,
	body.wolf.side-panel-toggle.menu-style-semi-transparent-black .hamburger-icon .line {
		background-color: $submenu_font_color !important;
	}
	
	/* Accent Color */
	.accent{
		color:$accent_color;
	}

	#prequelle-loading-point{
		color:$accent_color;
	}

	.wvc-single-image-overlay-title span:after{
		color:$accent_color;
	}

	.nav-menu li.sale .menu-item-text-container:before,
	.nav-menu-mobile li.sale .menu-item-text-container:before{
		background:$accent_color!important;
	}

	.entry-post-standard:hover.entry-title,
	.entry-post-grid_classic:hover .entry-title{
		color:$accent_color!important;
	}

	.entry-metro_modern_alt .entry-container{
		background:$accent_color;
	}

	.single-artist .artist-meta a>span{
		color:$accent_color;
	}

	.widget_price_filter .ui-slider .ui-slider-range,
	mark,
	p.demo_store,
	.woocommerce-store-notice{
		background-color:$accent_color;
	}

	.button-secondary{
		background-color:$accent_color;
		border-color:$accent_color;
	}

	.nav-menu li.menu-button-primary > a:first-child > .menu-item-inner{
		border-color:$accent_color;
		background-color:$accent_color;
	}

	.nav-menu li.menu-button-secondary > a:first-child > .menu-item-inner{
		border-color:$accent_color;
	}

	.nav-menu li.menu-button-secondary > a:first-child > .menu-item-inner:hover{
		background-color:$accent_color;
	}

	.fancybox-thumbs>ul>li:before{
		border-color:$accent_color;
	}

	.button,
	.button-download,
	.added_to_cart,
	.more-link{
		background-color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-background-color-accent,
	.entry-post-grid_classic .category-label:hover,
	.entry-post-metro_modern_alt .category-label:hover{
		background-color:$accent_color;
	}

	.page-numbers:hover:before,
	.page-numbers.current:before{
		background-color:$accent_color!important;
	}

	.wvc-highlight-accent{
		background-color:$accent_color;
		color:#fff;
	}

	.wvc-icon-background-color-accent{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-icon-background-color-accent .wvc-icon-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	.wvc-button-background-color-accent{
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-button-background-color-accent .wvc-button-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	.wvc-svg-icon-color-accent svg * {
		stroke:$accent_color!important;
	}

	.accent,
	.comment-reply-link,
	.bypostauthor .avatar{
		color:$accent_color;
	}

	.wvc-button-color-button-accent,
	.more-link,
	.buton-accent{
		background-color: $accent_color;
		border-color: $accent_color;
	}

	.wvc-ils-active .wvc-ils-item-title:after,
	.wvc-interactive-link-item a:hover .wvc-ils-item-title:after {
	    color:$accent_color;
	}

	.wvc-io-active .wvc-io-item-title:after,
	.wvc-interactive-overlay-item a:hover .wvc-io-item-title:after {
	    color:$accent_color;
	}
	
	/* WVC icons */
	.wvc-icon-color-accent{
		color:$accent_color;
	}

	.wvc-icon-background-color-accent{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-icon-background-color-accent .wvc-icon-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	#ajax-progress-bar,
	.cart-icon-product-count{
		background:$accent_color;
	}

	.background-accent,
	.mejs-container .mejs-controls .mejs-time-rail .mejs-time-current,
	.mejs-container .mejs-controls .mejs-time-rail .mejs-time-current, .mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current{
		background: $accent_color!important;
	}

	.trigger{
		background-color: $accent_color!important;
		border : solid 1px $accent_color;
	}

	.bypostauthor .avatar {
		border: 3px solid $accent_color;
	}

	::selection {
		background: $accent_color;
	}
	::-moz-selection {
		background: $accent_color;
	}

	.spinner{
		color:$accent_color;
	}

	/*********************
		WVC
	***********************/

	.wvc-icon-box.wvc-icon-type-circle .wvc-icon-no-custom-style.wvc-hover-fill-in:hover, .wvc-icon-box.wvc-icon-type-square .wvc-icon-no-custom-style.wvc-hover-fill-in:hover {
		-webkit-box-shadow: inset 0 0 0 1em $accent_color;
		box-shadow: inset 0 0 0 1em $accent_color;
		border-color: $accent_color;
	}

	.wvc-pricing-table-featured-text,
	.wvc-pricing-table-price-strike:before,
	.wvc-pricing-table-button a{
		background: $accent_color;
	}

	.wvc-pricing-table-price,
	.wvc-pricing-table-currency{
	}

	.wvc-team-member-social-container a:hover{
		color: $accent_color;
	}

	/* Main Text Color */
	body,
	.nav-label{
		color:$main_text_color;
	}

	.spinner-color, .sk-child:before, .sk-circle:before, .sk-cube:before{
		background-color: $main_text_color!important;
	}

	/* Secondary Text Color */
	
	/* Strong Text Color */
	a,strong,
	.products li .price,
	.products li .star-rating,
	.wr-print-button,
	table.cart thead, #content table.cart thead{
		color: $strong_text_color;
	}

	.menu-hover-style-p-underline .nav-menu-desktop li a span.menu-item-text-container:after,
	.menu-hover-style-underline .nav-menu-desktop li a span.menu-item-text-container:after,
	.menu-hover-style-underline-centered .nav-menu-desktop li a span.menu-item-text-container:after{
		background: $strong_text_color;
	}

	body.wolf.menu-hover-style-overline .nav-menu-desktop li a span.menu-item-text-container:after{
		background: $accent_color!important;
	}

	.menu-hover-style-line .nav-menu li a span.menu-item-text-container:after{
		background-color: $strong_text_color;
	}

	.bit-widget-container,
	.entry-link{
		color: $strong_text_color;
	}

	.wr-stars>span.wr-star-voted:before, .wr-stars>span.wr-star-voted~span:before{
		color: $strong_text_color!important;
	}

	/* Border Color */
	.author-box,
	input[type=text],
	input[type=search],
	input[type=tel],
	input[type=time],
	input[type=url],
	input[type=week],
	input[type=password],
	input[type=checkbox],
	input[type=color],
	input[type=date],
	input[type=datetime],
	input[type=datetime-local],
	input[type=email],
	input[type=month],
	input[type=number],
	select,
	textarea{
		border-color:$border_color;
	}

	.widget-title,
	.woocommerce-tabs ul.tabs{
		border-bottom-color:$border_color;
	}

	.widget_layered_nav_filters ul li a{
		border-color:$border_color;
	}

	hr{
		background:$border_color;
	}
	";

	$link_selector_after = '.link:after, .underline:after, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):after';
	$link_selector_before = '.link:before, .underline:before, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):before';

	$output .= "

		$link_selector_after,
		$link_selector_before{
		}

		.category-filter ul li a:before{
			background-color:$accent_color!important;
		}

		.category-label{
			background:$accent_color!important;
		}

		.entry-video:hover .video-play-button,
		.video-opener:hover{
			border-left-color:$accent_color!important;
		}

		body.wolf.menu-hover-style-highlight .nav-menu-desktop li a span.menu-item-text-container:after{
			background: $accent_color!important;
		}
	
		.widget.widget_tag_cloud .tagcloud a:hover,
		.wvc-font-dark .widget.widget_tag_cloud .tagcloud a:hover,
		.wvc-font-light .widget.widget_tag_cloud .tagcloud a:hover{
			color:$accent_color!important;
		}

		.wvc-breadcrumb a:hover{
			color:$accent_color!important;
		}

		.nav-menu-desktop > li:not(.menu-button-primary):not(.menu-button-secondary) > a:first-child .menu-item-text-container:before{
			color:$accent_color;
		}

		.accent-color-light .category-label{
			color:#333!important;
		}

		.accent-color-dark .category-label{
			color:#fff!important;
		}

		.accent-color-light #back-to-top:hover:after{
			color:#333!important;
		}

		.accent-color-dark #back-to-top:hover:after{
			color:#fff!important;
		}

		span.onsale{
			background:$accent_color;
		}

		.prequelle-button-dir-aware-alt .wvc-button-background-fill{
			background:$accent_color;
		}

		.coupon .button:hover{
			background:$accent_color!important;
			border-color:$accent_color!important;
		}

		.prequelle-button-outline{
			background-color:$accent_color!important;
			border-color:$accent_color!important;
		}

		.prequelle-button-outline-alt{
			border-color:$accent_color!important;
		}

		.prequelle-button-outline-alt:hover{
			background-color:$accent_color!important;
		}

		button.wvc-mailchimp-submit,
		.login-submit #wp-submit,
		.single_add_to_cart_button,
		.wc-proceed-to-checkout .button,
		.woocommerce-form-login .button,
		.woocommerce-alert .button,
		.woocommerce-message .button{
			background:$accent_color!important;
			border-color:$accent_color!important;
		}

		.single_add_to_cart_button{
			background:$accent_color!important;
			border-color:$accent_color;
		}

		.audio-shortcode-container .mejs-container .mejs-controls > .mejs-playpause-button{
			background:$accent_color;
		}

		/* Secondary accent color */
		.wvc-text-color-secondary_accent{
			color:$secondary_accent_color;
		}
		
		.wvc-album-tracklist-item.wvc-album-tracklist-item-active .wvc-ati-title,
		.single-product .entry-single.sale ins .woocommerce-Price-amount{
			color:$accent_color;
		}

		.wolf-bigtweet-content:before,
		.wolf-bigtweet-content a{
			color:$accent_color!important;
		}

		.wvc-background-color-secondary_accent{
			background-color:$secondary_accent_color;
		}

		.wvc-highlight-secondary_accent{
			background-color:$secondary_accent_color;
			color:#fff;
		}

		.wvc-icon-background-color-secondary_accent{
			box-shadow:0 0 0 0 $secondary_accent_color;
			background-color:$secondary_accent_color;
			color:$secondary_accent_color;
			border-color:$secondary_accent_color;
		}

		.wvc-icon-background-color-secondary_accent .wvc-icon-background-fill{
			box-shadow:0 0 0 0 $secondary_accent_color;
			background-color:$secondary_accent_color;
		}

		.wvc-button-background-color-secondary_accent{
			background-color:$secondary_accent_color;
			color:$secondary_accent_color;
			border-color:$secondary_accent_color;
		}

		.wvc-button-background-color-secondary_accent .wvc-button-background-fill{
			box-shadow:0 0 0 0 $secondary_accent_color;
			background-color:$secondary_accent_color;
		}

		.wvc-svg-icon-color-secondary_accent svg * {
			stroke:$secondary_accent_color!important;
		}

		.wvc-button-color-button-secondary_accent{
			background-color: $secondary_accent_color;
			border-color: $secondary_accent_color;
		}
		
		.wvc-pricing-table-button a,
		.wvc-pricing-table-price-strike:before {
			background-color: $secondary_accent_color;
		}

		.wvc-pricing-table-featured .wvc-pricing-table-price,
		.wvc-pricing-table-featured .wvc-pricing-table-currency {
			color: $accent_color;
		}
		
		.wvc-pricing-table-featured .wvc-pricing-table-button a,
		.wvc-pricing-table-featured .wvc-pricing-table-price-strike:before {
			background-color: $accent_color;
		}
		
		/* WVC icons */
		.wvc-icon-color-secondary_accent{
			color:$secondary_accent_color;
		}

		.wvc-icon-background-color-secondary_accent{
			box-shadow:0 0 0 0 $secondary_accent_color;
			background-color:$secondary_accent_color;
			color:$secondary_accent_color;
			border-color:$secondary_accent_color;
		}

		.wvc-icon-background-color-secondary_accent .wvc-icon-background-fill{
			box-shadow:0 0 0 0 $secondary_accent_color;
			background-color:$secondary_accent_color;
		}

	";
	if ( preg_match( '/dark/', prequelle_get_theme_mod( 'color_scheme' ) ) ) {
		$output .= ".wvc-background-color-default.wvc-font-light{
			background-color:$page_background_color;
		}";
	}
	if ( preg_match( '/light/', prequelle_get_theme_mod( 'color_scheme' ) ) ) {
		$output .= ".wvc-background-color-default.wvc-font-dark{
			background-color:$page_background_color;
		}";
	}

	return $output;
}
add_filter( 'prequelle_color_scheme_output', 'prequelle_edit_color_scheme_css', 10, 2 );

/**
 * Vertical bar colors
 */
function prequelle_output_additional_styles() {

	$output = '';

	/* Content inner background */
	$c_ci_bg_color = prequelle_get_inherit_mod( 'content_inner_bg_color' );

	if ( $c_ci_bg_color ) {
		$output .= ".content-inner{
	background-color: $c_ci_bg_color;
}";
	}

	/* Product thumbnail padding */
	$p_t_padding = prequelle_get_inherit_mod( 'product_thumbnail_padding' );

	if ( $p_t_padding ) {
		$p_t_padding = prequelle_sanitize_css_value( $p_t_padding );
		$output .= ".entry-product-masonry_overlay_quickview .product-thumbnail-container,
.entry-product-grid_overlay_quickview .product-thumbnail-container,
.wwcq-product-quickview-container .product-images .slide-content img{
	padding: $p_t_padding;
}";
	}

	/* Serif font */
	$serif_font_name = prequelle_get_theme_mod( 'serif_font_name', 'Playfair Display' );

	$serif_selector = '.wvc-team-member-tagline, .wvc-svc-item-title, .wp-caption .wp-caption-text, .entry-caption, .wvc-banner-tagline, .wvc-wc-cat-desc';
	
	/* Vertical Bar */
	$vertical_bar_bg_color = prequelle_get_inherit_mod( 'vertical_bar_bg_color' );
	$vertical_bar_font_color = prequelle_get_inherit_mod( 'vertical_bar_font_color' );


	if ( $vertical_bar_bg_color ) {
		$output .= "#vertical-bar, #vertical-bar-overlay, #vertical-bar-newsletter{background-color:$vertical_bar_bg_color}";

		if ( prequelle_color_is_white( $vertical_bar_bg_color ) ) {
			$output .= "#vertical-bar-newsletter{border: 1px solid rgba(0,0,0,0.05); border-left:0;}";
		}
	}

	if ( $vertical_bar_font_color ) {
		$output .= "#vertical-bar, #vertical-bar a{color:$vertical_bar_font_color}";
		$output .= "#vertical-bar .hamburger-icon .line,
		#vertical-bar .hamburger-icon .cross span,
		.nav-menu-vertical-bar li a span.menu-item-text-container:after
		{background-color:$vertical_bar_font_color!important}";
	}

	if ( ! SCRIPT_DEBUG ) {
		$output = prequelle_compact_css( $output );
	}

	wp_add_inline_style( 'prequelle-style', $output );
}
add_action( 'wp_enqueue_scripts', 'prequelle_output_additional_styles', 999 );

/**
 * Save modal window content after import
 */
function prequelle_set_modal_window_content_after_import() {
	$post = get_page_by_title( 'Modal Window Content', OBJECT, 'wvc_content_block' );

	if ( $post && function_exists( 'wvc_update_option' ) ) {
		wvc_update_option( 'modal_window', 'content_block_id', $post->ID );
	}
}
add_action( 'pt-ocdi/after_import', 'prequelle_set_modal_window_content_after_import' );