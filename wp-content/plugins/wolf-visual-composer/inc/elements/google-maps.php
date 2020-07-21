<?php
/**
 * Google Map
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$wvc_gmap_colors = array();

vc_map( array(
	'name' => esc_html__( 'Google Maps', 'wolf-visual-composer' ),
	'base' => 'wvc_google_maps',
	'icon' => 'fa fa-map-marker',
	'category' => esc_html__( 'Content', 'wolf-visual-composer' ),
	'description' => esc_html__( 'Map block', 'wolf-visual-composer' ),
	'admin_enqueue_js' => WVC_JS . '/admin/numeric-slider.js',
	'params' => array(

		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Locations', 'wolf-visual-composer' ),
			'param_name' => 'locations',
			
			'value' => urlencode( json_encode( array(
				array(
					'name' => esc_html__( 'Name', 'wolf-visual-composer' ),
					'data' => esc_html__( 'Coordinates', 'wolf-visual-composer' ),
				),
			) ) ),

			'params' => array(
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Name', 'wolf-visual-composer' ),
					'param_name' => 'name',
					'description' => esc_html__( 'Enter text the location name.', 'wolf-visual-composer' ),
					'admin_label' => true,
				),
				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Coordinates', 'wolf-visual-composer' ),
					'param_name' => 'coordinates',
					'placeholder' => '50.799852, 2.486477',
					'description' => sprintf(
						wp_kses(
							__( 'To extract the Latitude and Longitude of your address, follow the instructions %s. 1) Use the directions under the section "Get the coordinates of a place" 2) Copy the coordinates 3) Paste the coordinates in the field with the "comma" sign.', 'wolf-visual-composer' ),
							array( 'a' => array( 'href' => array(),
								'target' => array() ) ) ),
						'<a href="https://support.google.com/maps/answer/18539?source=gsearch&hl=en" target="_blank">here</a>'
					),
					'admin_label' => true,
				),

			),
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Skin', 'wolf-visual-composer' ),
			'param_name' => 'map_skin',
			'value' => array(
				esc_html__( 'Standard', 'wolf-visual-composer' ) => 'standard',
				esc_html__( 'Light', 'wolf-visual-composer' ) => 'silver',
				esc_html__( 'Retro', 'wolf-visual-composer' ) => 'retro',
				esc_html__( 'Dark', 'wolf-visual-composer' ) => 'dark',
				esc_html__( 'Night', 'wolf-visual-composer' ) => 'night',
				esc_html__( 'Aubergine', 'wolf-visual-composer' ) => 'aubergine',
				esc_html__( 'Ultra Light with Labels', 'wolf-visual-composer' ) => 'ultra_light',
				esc_html__( 'Shades of Grey', 'wolf-visual-composer' ) => 'shades_of_grey',
				esc_html__( 'Cool Grey', 'wolf-visual-composer' ) => 'cool_grey',
				esc_html__( 'Pale Dawn', 'wolf-visual-composer' ) => 'pale_dawn',
				esc_html__( 'Medium Green', 'wolf-visual-composer' ) => 'map',
				esc_html__( 'Custom', 'wolf-visual-composer' ) => 'custom',
			),
			'admin_label' => true,
		),

		array(
			'type' => 'textarea_raw_html',
			'heading' => esc_html__( 'Custom code', 'wolf-visual-composer' ),
			'param_name' => 'custom_map_skin',
			'description' => sprintf( wvc_kses( __( 'You can get a custom code from <a href="%s" target="_blank">https://snazzymaps.com</a> and paste it here', 'wolf-visual-composer' ) ), 'https://snazzymaps.com/' ),
			'dependency' => array( 'element' => 'map_skin', 'value' => array( 'custom' ) ),
		),

		array(
			'type' => 'wvc_numeric_slider',
			'heading' => esc_html__( 'Zoom', 'wolf-visual-composer' ),
			'param_name' => 'zoom',
			'min' => 1,
			'max' => 20,
			'step' => 1,
			'std' => 10,
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Marker', 'wolf-visual-composer' ),
			'param_name' => 'marker',
			'value' => array(
				esc_html__( 'Default', 'wolf-visual-composer' ) => 'default',
				esc_html__( 'Custom Image', 'wolf-visual-composer' ) => 'custom',
			),
			'std' => 'default',
		),

		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Image', 'wolf-visual-composer' ),
			'param_name' => 'marker_img',
			'value' => '',
			'description' => esc_html__( 'Select image from media library.', 'wolf-visual-composer' ),
			'dependency' => array(
				'element' => 'marker',
				'value' => 'custom',
			),
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Marker Color', 'wolf-visual-composer' ),
			'param_name' => 'marker_color',
			'value' => array_merge(
				array( esc_html__( 'Default color', 'wolf-visual-composer' ) => 'default', ),
				wvc_get_shared_colors(),
				array( esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom', )
			),
			'std' => 'default',
			'description' => esc_html__( 'Select a marker color.', 'wolf-visual-composer' ),
			'param_holder_class' => 'wvc_colored-dropdown',
			'dependency' => array(
				'element' => 'marker',
				'value' => 'default',
			),
		),

		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Marker Custom Color', 'wolf-visual-composer' ),
			'param_name' => 'marker_custom_color',
			'dependency' => array(
				'element' => 'marker_color',
				'value' => 'custom',
			),
		),

		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Map height', 'wolf-visual-composer' ),
			'param_name' => 'size',
			'value' => '500px',
			'admin_label' => true,
		),
		array(
			'type' => 'textarea_safe',
			'heading' => esc_html__( 'Address', 'wolf-visual-composer' ),
			'param_name' => 'address',
			'description' => esc_html__( 'Insert the address here if you want it to be display below the map.', 'wolf-visual-composer' ),
			'admin_label' => true,
		),
	)
));

class WPBakeryShortCode_Wvc_Google_Maps extends WPBakeryShortCode {}
