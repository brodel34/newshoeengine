<?php
/**
 * Social icons cuqstom shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Shortcodes
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wvc_shortcode_socials_custom' ) ) {
	/**
	 * Socials custom shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wvc_shortcode_socials_custom( $atts ) {

		global $wvc_team_member_socials;

		if ( class_exists( 'Vc_Manager' ) && function_exists( 'vc_map_get_attributes' ) ) {
			$atts = vc_map_get_attributes( 'wvc_socials_custom', $atts );
		}

		extract( shortcode_atts( array(
			'size' 			=> '2x',
			'type' 			=> 'normal',
			'target' 		=> '_blank',
			'custom_style' 	=> 'no',
			'hover_effect' 		=> 'none',
			'margin' 		=> '',
			'bg_color' 		=> '',
			'icon_color' 		=> '',
			'border_color' 	=> '',
			'bg_color_hover' 	=> '',
			'icon_color_hover' 	=> '',
			'border_color_hover' 	=> '',
			'alignment' 		=> 'center',
			'animation' 		=> '',
			'animation_delay' 	=> '',
			'inline_style'		=> '',
			'extra_class'		=> '',
		), $atts ) );
		foreach ( $wvc_team_member_socials as $social ) {
		}

		$atts['services'] = array();

		foreach ( $wvc_team_member_socials as $social ) {
			if ( isset( $atts[ $social ] ) ) {
				$atts['services'][ $social ] = $atts[ $social ];
			}
		}

		return wvc_socials( $atts );
	}
	add_shortcode( 'wvc_socials_custom', 'wvc_shortcode_socials_custom' );
}