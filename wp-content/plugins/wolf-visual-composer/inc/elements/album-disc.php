<?php
/**
 * Album Disc
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Album Disc', 'wolf-visual-composer' ),
		'description' => esc_html__( 'A stylish presentation for your release', 'wolf-visual-composer' ),
		'base' => 'wvc_album_disc',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'dashicons-before dashicons-album',
		'params' => array(

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Alignment', 'wolf-visual-composer' ),
				'param_name' => 'alignment',
				'std' => 'left',
				'value' => array(
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Type', 'wolf-visual-composer' ),
				'param_name' => 'type',
				'value' => array(
					esc_html__( 'CD', 'wolf-visual-composer' ) => 'cd',
					esc_html__( 'Vinyl', 'wolf-visual-composer' ) => 'vinyl',
				),
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Cover Image', 'wolf-visual-composer' ),
				'param_name' => 'cover_image',
				'description' => esc_html__( 'Select image from media library.', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Disc Image', 'wolf-visual-composer' ),
				'param_name' => 'disc_image',
				'description' => esc_html__( 'A secondary image that will be used for the CD or vinyl artwork.', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Link', 'wolf-visual-composer' ),
				'param_name' => 'link',
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Worn Border Effect', 'wolf-visual-composer' ),
				'param_name' => 'worn_border',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'no',
				),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Disc Rotate Effect', 'wolf-visual-composer' ),
				'param_name' => 'rotate',
				'std' => 'hover',
				'value' => array(
					esc_html__( 'On Hover', 'wolf-visual-composer' ) => 'hover',
					esc_html__( 'Stop On Hover', 'wolf-visual-composer' ) => 'hover-stop',
					esc_html__( 'Always', 'wolf-visual-composer' ) => 'always',
					esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Disc Rotation Speed (in ms)', 'wolf-visual-composer' ),
				'param_name' => 'rotation_speed',
				'placeholder' => apply_filters( 'wvc_default_album_disc_rotation_speed', 3500 ),
				'std' => apply_filters( 'wvc_default_album_disc_rotation_speed', 3500 ),
			),
		),
	)
);

class WPBakeryShortCode_Wvc_Album_Disc extends WPBakeryShortCode {}