<?php
/**
 * Social icons shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'services' 		=> '',
	'target' 		=> '_blank',
	'rel' 			=> '',
	'alignment' 		=> 'center',
	'color'			=> 'default',
	'custom_color'		=> '',
	'background_style'	=> 'none',
	'background_color'	=> '',
	'custom_background_color'	=> '',
	'size'              	=> '',
	'hover_effect'		=> 'none',
	'css_animation' 	=> '',
	'css_animation_delay' => '',
	'el_class' => '',
	'hide_class' => '',
	'css' => '',
	'inline_style' => '',
	'add_spotify_follow_button' => '',
), $atts ) );

echo wvc_socials( $atts );