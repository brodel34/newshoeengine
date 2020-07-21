<?php
/**
 * Message
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Notification', 'wolf-visual-composer' ),
		'base' => 'vc_message',
		'description' => esc_html__( 'Message box', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-info',
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Type', 'wolf-visual-composer' ),
				'param_name' => 'type',
				'value' => array(
					esc_html__( 'Success', 'wolf-visual-composer' ) => 'success',
					esc_html__( 'Info', 'wolf-visual-composer' ) => 'info',
					esc_html__( 'Alert', 'wolf-visual-composer' ) => 'alert',
					esc_html__( 'Error', 'wolf-visual-composer' ) => 'error',
				),
				'admin_label' => true,
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'class' => 'messagebox_text',
				'heading' => esc_html__( 'Message text', 'wolf-visual-composer' ),
				'param_name' => 'content',
				'value' => esc_html__( 'I am message box. Click edit button to change this text.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Display Icon', 'wolf-visual-composer' ),
				'param_name' => 'display_icon',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'no',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Allow the visitor to dismiss the message', 'wolf-visual-composer' ),
				'param_name' => 'close',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'no',
				),
			),
		),
	)
);