<?php
/**
 * Section
 *
 * @package WordPress
 * @subpackage Wolf WPBakery Page Builder Extension
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

/* Removing parameters */
vc_remove_param( 'vc_section', 'el_id' );
vc_remove_param( 'vc_section', 'gap' );
vc_remove_param( 'vc_section', 'full_width' );
vc_remove_param( 'vc_section', 'full_height' );
vc_remove_param( 'vc_section', 'video_bg' );
vc_remove_param( 'vc_section', 'video_bg_url' );
vc_remove_param( 'vc_section', 'video_bg_parallax' );
vc_remove_param( 'vc_section', 'parallax' );
vc_remove_param( 'vc_section', 'parallax_image' );
vc_remove_param( 'vc_section', 'parallax_speed_bg' );
vc_remove_param( 'vc_section', 'parallax_speed_video' );
vc_remove_param( 'vc_section', 'disable_element' );
vc_remove_param( 'vc_section', 'css_animation' );
vc_remove_param( 'vc_section', 'css' );
vc_map_update( 'vc_section', array(
	'icon' => 'fa fa-align-justify',
	'weight' => 1001,
) );
vc_add_params(
	'vc_section',
	array_merge(
		wvc_section_general_params(),
		wvc_background_params(),
		wvc_style_params()
	)
);