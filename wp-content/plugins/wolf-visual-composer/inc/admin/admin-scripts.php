<?php
/**
 * Wolf WPBakery Page Builder Extension Admin scripts
 *
 * @author WolfThemes
 * @category Admin
 * @package WolfVisualComposer/Admin
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Enqueue admin scripts
 *
 * Styles and scripts for the admin
 */
function wvc_enqueue_admin_scripts() {
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : WVC_VERSION;

	/* Styles */
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style( 'wvc-admin', WVC_CSS . '/admin/admin' . $suffix . '.css', array(), $version, 'all' );

	/* Scripts */
	/* load jQuery-ui slider */
	wp_enqueue_script( 'jquery-ui-slider' );
	wp_enqueue_script( 'wvc-numeric-slider', WVC_JS . '/admin/numeric-slider.js', array( 'jquery-ui-slider' ), $version, true );
	wp_enqueue_script( 'wvc-font-preview', WVC_JS . '/admin/font-preview.js', array( 'jquery' ), $version, true );

	wp_enqueue_media();
	wp_enqueue_script( 'wvc-media', WVC_JS . '/admin/media.js', array( 'jquery', 'wp-color-picker' ), $version, true );
	wp_enqueue_script( 'wvc-admin', WVC_JS . '/admin/admin.js', array( 'jquery', 'wp-color-picker' ), $version, true );

	wp_localize_script( 'wvc-admin', 'WVCAdminParams', array(
		'ajaxUrl' => esc_url( admin_url( 'admin-ajax.php' ) ),
		'chooseImage' => esc_html__( 'Select an image', 'wolf-visual-composer' ),
		'chooseMultipleImage' => esc_html__( 'Select a set of images', 'wolf-visual-composer' ),
		'chooseFile' => esc_html__( 'Select a file', 'wolf-visual-composer' ),
		'confirmRemoveAllImages' => esc_html__( 'This will remove the entire image set', 'wolf-visual-composer' ),
		'VCPurchaseUrl' => wvc_vc_purchase_url(),
	) );
}
add_action( 'admin_enqueue_scripts', 'wvc_enqueue_admin_scripts' );