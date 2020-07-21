<?php
/**
 * Prequelle Page Builder
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function prequelle_set_wvc_mods( $mods ) {

	if ( class_exists( 'Wolf_Visual_Composer' ) ) {
		$mods['blog']['options']['newsletter'] = array(
			'id' =>'newsletter_form_single_blog_post',
			'label' => esc_html__( 'Add newsletter form below single post', 'prequelle' ),
			'type' => 'checkbox',
			'description' => esc_html__( 'Display a newsletter sign up form at the bottom of each blog post.', 'prequelle' ),
		);
	}

	return $mods;
}
add_filter( 'prequelle_customizer_mods', 'prequelle_set_wvc_mods' );