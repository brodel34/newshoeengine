<?php
/**
 * Mailchimp shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'list' => wolf_vc_get_option( 'mailchimp', 'default_mailchimp_list_id' ),
	'f_name' => '',
	'l_name' => '',
	'size' => 'normal',
	'label' => wolf_vc_get_option( 'mailchimp', 'label' ),
	'submit_type' => 'text',
	'submit_text' => wolf_vc_get_option( 'mailchimp', 'subscribe_text', esc_html__( 'Subscribe', 'wolf-visual-composer' ) ),
	'si_type' => '',
	'icon' => '',
	'bottom_line' => wolf_vc_get_option( 'mailchimp', 'bottom_line' ),
	'image_id' => wolf_vc_get_option( 'mailchimp', 'background' ),
	'show_bg' => true,
	'show_label' => true,
	'show_name' => 'no',
	'placeholder' =>  wolf_vc_get_option( 'mailchimp', 'placeholder', esc_html__( 'enter your email address', 'wolf-visual-composer' ) ),
	'button_style' => '',
	'alignment' => 'center',
	'text_alignment' => 'center',
	'enqueue_script' => true,
	'css_animation' => '',
	'css_animation_delay' => '',
	'submit_button_class' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

vc_icon_element_fonts_enqueue( $si_type );

// Icon
$icon = ( isset( $atts["si_icon_$si_type"] ) ) ? $atts["si_icon_$si_type"] : '';

echo wvc_mailchimp( array_merge( array( 'icon' => $icon ), $atts ) );