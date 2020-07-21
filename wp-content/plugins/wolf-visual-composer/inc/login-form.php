<?php
/**
 * Wolf WPBakery Page Builder Extension login form function
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns a login form
 *
 * @param array $atts
 */
function wvc_login_form( $atts = array() ) {

	if ( ! function_exists( 'wc_get_page_id' ) ) {
		return;
	}

	$atts = wp_parse_args( $atts, array(
		'css_animation' => '',
		'css_animation_delay' => '',
		'css' => '',
		'el_class' => '',
		'inline_style' => '',
	) );

	$atts = apply_filters( 'wvc_login_form_atts', $atts );

	extract( $atts );

	$output = '';

	wp_enqueue_script( 'jquery-ui-tabs', true );
	wp_enqueue_script( 'wvc-loginform' );

	$class = $el_class;
	$inline_style = wvc_sanitize_css_field( $inline_style );
	$inline_style .= wvc_shortcode_custom_style( $css );

	/*Animate */
	if ( ! wvc_is_new_animation( $css_animation ) ) {
		$class .= wvc_get_css_animation( $css_animation );
		$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
	}

	$class .= " wvc-login-form wvc-login-form-container";

	$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

	$output .= wvc_element_aos_animation_data_attr( $atts );

	$output .= '>';
	
	$output .= '<div class="wvc-login-form-inner">';

	/* Title */
	$output .= '<div class="wvc-login-form-title-container">';
	$output .= '<h3 class="wvc-login-form-title">';
	$output .= esc_html__( 'Login', 'wolf-visual-composer' );
	$output .= '</h3>';
	$output .= '</div>';

	ob_start();

	?>
	<form class="wvc-login-form" action="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>" method="post">
			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="login-usernam">
				<label for="username"><?php esc_html_e( 'Username or email address', 'wolf-visual-composer' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>
			<p class="login-password">
				<label for="password"><?php esc_html_e( 'Password', 'wolf-visual-composer' ); ?>&nbsp;<span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="login-remember">
				<label>
					<input name="rememberme" type="checkbox" id="rememberme" value="forever"><span><?php esc_html_e( 'Remember me', 'wolf-visual-composer' ); ?></span>
				</label>
			</p>
	
			<p class="login-submit">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<input id="wp-submit" type="submit" class="<?php echo apply_filters( 'wvc_login_form_submit_button_class', 'button button-primary' ); ?>" name="login" value="<?php esc_attr_e( 'Log in', 'wolf-visual-composer' ); ?>">
			</p>

			<p class="wvc-login-form-links">
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>"><?php esc_html_e( 'I need to register', 'wolf-visual-composer' ); ?></a>
				
				<?php echo apply_filters( 'wvc_login_form_bottom_link_separator', '|' ); ?>

				<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'wolf-visual-composer' ); ?></a>
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>
		</form>
	<?php

	$output .= ob_get_clean();

	$output .= '</div><!--.wvc-login-form-inner-->';

	$output .= '</div><!--.wvc-login-form-->';

	return $output;
}