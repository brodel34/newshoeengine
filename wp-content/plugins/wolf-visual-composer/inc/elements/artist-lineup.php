<?php
/**
 * List
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Artist Line-Up', 'wolf-visual-composer' ),
		'base' => 'wvc_artist_lineup',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'description' => esc_html__( 'A List of Artist Names', 'wolf-visual-composer' ),
		'icon' => 'fa fa-list',
		'params' => array(
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Before text', 'wolf-visual-composer' ) ,
				'param_name' => 'before_text',
				'admin_label' => true,
				'description' => esc_html__( 'A text to display before the list.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'textarea_html',
				'heading' => esc_html__( 'List text', 'wolf-visual-composer' ) ,
				'param_name' => 'content',
				'value' => '<ul><li>Artist #1</li><li>Artist #2</li></ul>',
				'admin_label' => true,
				'description' => esc_html__( 'The names set in bold in the text editor will be highlighted.', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Separator', 'wolf-visual-composer' ) ,
				'param_name' => 'separator',
				'admin_label' => true,
				'description' => esc_html__( 'A space will be used by default.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Alignment', 'wolf-visual-composer' ),
				'param_name' => 'text_align',
				'value' => array(
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
				),
			),
		),
	)
);

class WPBakeryShortCode_Wvc_Artist_lineup extends WPBakeryShortCode {}