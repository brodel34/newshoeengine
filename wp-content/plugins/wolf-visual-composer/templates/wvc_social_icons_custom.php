<?php
/**
 * Social icons custom shortcode template
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
	'target' 			=> '_blank',
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
	'css' => '',
	'inline_style' => '',
), $atts ) );

$socials = wvc_get_socials();

foreach ( $socials as $social ) {
	if ( isset( $atts[ $social ] ) ) {
		$atts['services'][ $social ] = $atts[ $social ];
	}
}

echo wvc_socials( $atts );