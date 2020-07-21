<?php
/**
 * Mailchimp dialog box
 *
 * @class wvc_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfVisualComposer/Admin
 * @version 3.1.1
 */
$title = esc_html__( 'Mailchimp signup', 'wolf-visual-composer' );
$params = array(

	array(
		'id' => 'list',
		'label' => esc_html__( 'List', 'wolf-visual-composer' ),
		'desc' => esc_html__( 'Your mailchimp list ID.', 'wolf-visual-composer' ),
		'placeholder' => 'mb0sd78fg8',
	),

	array(
		'id' => 'size',
		'label' => esc_html__( 'Size', 'wolf-visual-composer' ),
		'type' => 'select',
		'options' => array(
			'normal' => esc_html__( 'Normal', 'wolf-visual-composer' ),
			'large' => esc_html__( 'Large', 'wolf-visual-composer' ),
		),
	),

	array(
		'id' => 'submit',
		'label' => esc_html__( 'Submit', 'wolf-visual-composer' ),
		'placeholder' => 'Submit',
	),
);
echo wvc_generate_tinymce_popup( 'wvc_mailchimp', $params, $title );