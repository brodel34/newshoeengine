<?php
/**
 * Dropcap dialog box
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

$title = esc_html__( 'Dropcap', 'wolf-visual-composer' );
$params = array(

	array(
		'id' => 'text',
		'label' => esc_html__( 'Letter', 'wolf-visual-composer' ),
	),

	array(
		'id' => 'font',
		'label' => esc_html__( 'Font Family', 'wolf-visual-composer' ),
		'type' => 'select',
		'options' => $font_list,
	),
);
echo wvc_generate_tinymce_popup( 'wvc_dropcap', $params, $title );