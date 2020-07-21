<?php
/**
 * Spacer dialog box
 *
 * @class WVC_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfVisualComposer/Admin
 * @version 3.1.1
 */
$title = esc_html__( 'Height', 'wolf-visual-composer' );
$params = array(

	array(
		'id' => 'height',
		'label' => esc_html__( 'Height', 'wolf-visual-composer' ),
		'value' => '100px',
	),
);
echo wvc_generate_tinymce_popup( 'wvc_empty_space', $params, $title );