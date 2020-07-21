<?php
/**
 * Notification dialog box
 *
 * @class WVC_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfVisualComposer/Admin
 * @version 3.1.1
 */
$title = esc_html__( 'Notification', 'wolf-visual-composer' );
$params = array(

	array(
		'id' => 'message',
		'label' => esc_html__( 'Message', 'wolf-visual-composer' ),
		'placeholder' => esc_html__( 'Your notification message', 'wolf-visual-composer' )
	),

	array(
		'id' => 'type',
		'label' => esc_html__( 'Type', 'wolf-visual-composer' ),
		'type' => 'select',
		'options' => array(
			'success' => esc_html__( 'success', 'wolf-visual-composer' ),
			'info' => esc_html__( 'info', 'wolf-visual-composer' ),
			'tip' => esc_html__( 'tip', 'wolf-visual-composer' ),
			'error' => esc_html__( 'error', 'wolf-visual-composer' ),
		),
	)
);
echo wvc_generate_tinymce_popup( 'wvc_alert_message', $params, $title );