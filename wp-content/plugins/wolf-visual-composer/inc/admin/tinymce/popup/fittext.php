<?php
/**
 * Headline dialog box
 *
 * @class WVC_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfVisualComposer/Admin
 * @version 3.1.1
 */
$font_list = array( '' => esc_html__( 'Default heading font', 'wolf-visual-composer' ) );
$wvc_google_fonts = wvc_get_google_fonts_options();

foreach ( $wvc_google_fonts as $key => $value ) {
	$font_list[ $key ] = $key;
}

$title = esc_html__( 'Headline', 'wolf-visual-composer' );
$params = array(

	array(
		'id' => 'text',
		'label' => esc_html__( 'Text', 'wolf-visual-composer' ),
		'placeholder' => esc_html__( 'My Cool Headline', 'wolf-visual-composer' ),
	),

	array(
		'id' => 'max_font_size',
		'label' => esc_html__( 'Font Size', 'wolf-visual-composer' ),
		'placeholder' => '48px',
	),

	array(
		'id' => 'letter_spacing',
		'label' => esc_html__( 'Letter Spacing', 'wolf-visual-composer' ),
		'placeholder' => '3px',
	),

	array(
		'id' => 'font_family',
		'label' => esc_html__( 'Font Family', 'wolf-visual-composer' ),
		'type' => 'select',
		'options' => $font_list,
	),

	array(
		'id' => 'text_transform',
		'label' => esc_html__( 'Font Transform', 'wolf-visual-composer' ),
		'type' => 'select',
		'options' => array(
			'uppercase' => esc_html__( 'uppercase', 'wolf-visual-composer' ),
			'none' => esc_html__( 'none', 'wolf-visual-composer' ),
		),
	),
);
echo wvc_generate_tinymce_popup( 'wvc_headline', $params, $title );
