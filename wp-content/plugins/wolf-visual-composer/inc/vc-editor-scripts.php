<?php
/**
 * Wolf WPBakery Page Builder Extension VC editor scripts
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Enqueue editor scripts
 *
 * Script available only for VC editor
 */
function wvc_enqueue_vc_editor_scripts() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : WVC_VERSION;

	wp_enqueue_script( 'wvc-vc-editor', WVC_JS . '/admin/vc-editor.js', array(), $version, true );
}

add_action('vc_backend_editor_render', 'wvc_enqueue_vc_editor_scripts');