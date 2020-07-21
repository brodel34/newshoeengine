<?php
/**
 * Output modal window
 *
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Frontend
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Modal Window markup
 */
function wvc_modal_window( $atts = array() ) {

	$atts = apply_filters( 'wvc_modal_window_atts', wp_parse_args( $atts, array(
		'type' => wolf_vc_get_option( 'modal_window', 'type', 'full' ),
		'content_block_id' => wolf_vc_get_option( 'modal_window', 'content_block_id' ),
		'content_width' => wolf_vc_get_option( 'modal_window', 'content_width', 960 ),
		'show_once' => wolf_vc_get_option( 'modal_window', 'show_once', false ),
		'include_post_types' => wolf_vc_get_option( 'modal_window', 'include_post_types' ),
		'exclude_post_types' => wolf_vc_get_option( 'modal_window', 'exclude_post_types' ),
		'include_ids' => wolf_vc_get_option( 'modal_window', 'include_ids' ),
		'exclude_ids' => wolf_vc_get_option( 'modal_window', 'exclude_ids' ),
		'exclude_mc_subs' => wolf_vc_get_option( 'modal_window', 'exclude_mc_subs' ),
		'close_button_color' => wolf_vc_get_option( 'modal_window', 'close_button_color' ),
	) ) );

	extract( $atts );

	$post_id = wvc_get_the_ID();
	$post_type = get_post_type( $post_id );

	if ( wvc_is_user_mc_sub() && $exclude_mc_subs && ! wvc_is_user_admin() ) {
		return;
	}

	if ( is_404() || wvc_is_maintenance_page() ) {
		return;
	}

	if ( wvc_is_woocommerce_page() ) {
		if ( is_checkout() || is_cart() || is_account_page() ) {
			return;
		}
	}

	if ( ! $content_block_id ) {
		return;
	}

	if ( $post_id == $content_block_id ) {
		return;
	}

	if ( $exclude_post_types ) {
		$exclude_post_types = wvc_list_to_array( $exclude_post_types );

		if ( in_array( $post_type, $exclude_post_types ) ) {
			return;
		}
	}

	if ( $include_post_types ) {
		$include_post_types = wvc_list_to_array( $include_post_types );

		if ( ! in_array( $post_type, $include_post_types ) ) {
			return;
		}
	}

	if ( $exclude_ids ) {
		$exclude_ids = wvc_list_to_array( $exclude_ids );

		if ( in_array( $post_id, $exclude_ids ) ) {
			return;
		}
	}

	if ( $include_ids ) {
		$include_ids = wvc_list_to_array( $include_ids );

		if ( ! in_array( $post_id, $include_ids ) ) {
			return;
		}
	}

	wp_enqueue_script( 'wvc-modal-window' );

	$inline_style = $close_inline_style = $container_inline_style = '';
	
	$content_width = wvc_sanitize_css_value( $content_width );

	$inline_style .= "max-width:$content_width;";

	if ( $close_button_color ) {
		$close_inline_style .= 'color:' . wvc_sanitize_color( $close_button_color ) . ';';
	}

	if ( 'non_intrusive' === $type ) {
		$container_inline_style .= "max-width:$content_width;";
		$inline_style = '';
	}

	ob_start();
	?>
	<div id="wvc-modal-window-overlay" style="<?php echo wvc_esc_style_attr( $container_inline_style ); ?>" class="<?php echo wvc_sanitize_html_classes( 'wvc-modal-window-' . $type ); ?>">
		<div id="wvc-modal-window-container" style="<?php echo wvc_esc_style_attr( $inline_style ); ?>">
			<div id="wvc-modal-window-content">
				<a style="<?php echo wvc_esc_style_attr( $close_inline_style ); ?>" href="#" id="wvc-modal-window-close" class="wvc-modal-window-close">X</a>
				<div id="wvc-modal-window-inner">
					<div id="wvc-modal-window" class="wvc-modal-window">
						<?php
							/**
							 * Content Block
							 */
							echo wccb_block( $content_block_id );
						?>
					</div>
				</div>
			</div>
			<?php if ( ! $show_once ) : ?>
				<span id="wvc-modal-window-bottom-close" class="wvc-modal-window-close wvc-modal-window-opt-out wvc-modal-window-bottom-close"><?php esc_html_e( 'Don\'t show this message again', 'wolf-visual-composer' ); ?></span>
			<?php endif; ?>
		</div>
	</div>
	<?php
	echo apply_filters( 'wvc_modal_window_output', ob_get_clean(), $atts );
}
add_action( 'wolf_body_start', 'wvc_modal_window' );
