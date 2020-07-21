<?php
/**
 * Socials dialog box
 *
 * @class WVC_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfVisualComposer/Admin
 * @version 3.1.1
 */
$title = esc_html__( 'Socials', 'wolf-visual-composer' );
$params = array(

	array(
		'id' => 'services',
		'label' => esc_html__( 'Services', 'wolf-visual-composer' ),
		'desc' => wp_kses(
			__( 'Leave empty to display them all.<br>* See the social networks available in the plugin options.', 'wolf-visual-composer' ),
			array( 'br' => array() )
		),
		'placeholder' => 'facebook,twitter',
	),

	array(
		'id' => 'type',
		'label' => esc_html__( 'Type', 'wolf-visual-composer' ),
		'type' => 'select',
		'options' => array(
			'normal' => esc_html__( 'Normal', 'wolf-visual-composer' ),
			'circle' => esc_html__( 'Circle', 'wolf-visual-composer' ),
			'square' => esc_html__( 'Square', 'wolf-visual-composer' ),
		),
	),

	array(
		'id' => 'size',
		'label' => esc_html__( 'Size', 'wolf-visual-composer' ),
		'type' => 'select',
		'options' => array(
			'1x' => esc_html__( 'Small', 'wolf-visual-composer' ),
			'2x' => esc_html__( 'Medium', 'wolf-visual-composer' ),
			'3x' => esc_html__( 'Large', 'wolf-visual-composer' ),
			'4x' => esc_html__( 'Very Large', 'wolf-visual-composer' ),
		),
	),
);
echo wvc_generate_tinymce_popup( 'wvc_socials', $params, $title );