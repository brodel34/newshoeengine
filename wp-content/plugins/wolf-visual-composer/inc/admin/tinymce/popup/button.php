<?php
/**
 * Button dialog box
 *
 * @class WVC_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfVisualComposer/Admin
 * @version 3.1.1
 */
$button_color_array = array(
	'accent-color'  => esc_html__( 'theme color', 'wolf-visual-composer' ),
	'accent-color-bnw'  => esc_html__( 'theme color black/white on hover', 'wolf-visual-composer' ),
	'border-button'  => esc_html__( 'black/white', 'wolf-visual-composer' ),
	'border-button-accent-hover'  => esc_html__( 'black/white theme color on hover', 'wolf-visual-composer' ),
);

$button_type_array =  array(
	'square' => esc_html__( 'Square', 'wolf-visual-composer' ),
	'round' => esc_html__( 'Round', 'wolf-visual-composer' ),
);

$button_size_array =  array(
	'medium' => esc_html__( 'Medium', 'wolf-visual-composer' ),
	'small' => esc_html__( 'Small', 'wolf-visual-composer' ),
	'large' => esc_html__( 'Large', 'wolf-visual-composer' ),
);

global $wvc_icons;

$title = esc_html__( 'Button', 'wolf-visual-composer' );
$params = array(

	array(
		'id' => 'text',
		'label' => esc_html__( 'Text', 'wolf-visual-composer' ),
		'value' => esc_html__( 'Button', 'wolf-visual-composer' ),
	),

	array(
		'id' => 'link_url',
		'label' => esc_html__( 'Link', 'wolf-visual-composer' ),
		'placeholder' => esc_html__( 'http://', 'wolf-visual-composer' ),
	),

	array(
		'id' => 'tagline',
		'label' => esc_html__( 'Tagline', 'wolf-visual-composer' ),
	),

	array(
		'id' => 'size',
		'label' => esc_html__( 'Size', 'wolf-visual-composer' ),
		'type' => 'select',
		'options' => $button_size_array,
	),

	array(
		'id' => 'type',
		'label' => esc_html__( 'Type', 'wolf-visual-composer' ),
		'type' => 'select',
		'options' => $button_type_array,
	),

	array(
		'id' => 'link_target',
		'label' => esc_html__( 'Open link in a new tab', 'wolf-visual-composer' ),
		'type' => 'checkbox',
		'value' => '_blank',
	),

	array(
		'id' => 'scroll_to_anchor',
		'label' => esc_html__( 'Scroll to anchor', 'wolf-visual-composer' ),
		'type' => 'checkbox',
		'value' => true,
	),

	array(
		'id' => 'add_button_icon',
		'label' => esc_html__( 'Add Icon', 'wolf-visual-composer' ),
		'type' => 'checkbox',
		'value' => 'yes',
	),

	array(
		'id' => 'icon',
		'label' => esc_html__( 'Icon', 'wolf-visual-composer' ),
		'type' => 'select',
		'options' => $wvc_icons,
	),

	array(
		'id' => 'icon_position',
		'label' => esc_html__( 'Icon position', 'wolf-visual-composer' ),
		'type' => 'select',
		'options' => array(
			'after' => esc_html__( 'after', 'wolf-visual-composer' ),
			'before' => esc_html__( 'before', 'wolf-visual-composer' ),
		),
	),
);
echo wvc_generate_tinymce_popup( 'wvc_button', $params, $title );