<?php
/**
 * Instagram Gallery
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
$metro_patterns = wvc_get_metro_patterns();
if ( ( $key = array_search( 'auto', $metro_patterns ) ) !== false ) {
    unset( $metro_patterns[ $key ] );
}

vc_map(
	array(
		'name' => esc_html__( 'Instagram Gallery', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Your Instagram pics with advanced layout options', 'wolf-visual-composer' ),
		'base' => 'wvc_instagram_gallery',
		'category' => esc_html__( 'Media' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-instagram',
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Image Count', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Note that the instagram API may limit the number of image to display.', 'wolf-visual-composer' ),
				'param_name' => 'count',
				'value' => 18,
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Username (optional)', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Leave empty to use the default username', 'wolf-visual-composer' ),
				'param_name' => 'username',
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'API key (optional)', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Leave empty to use the default API key', 'wolf-visual-composer' ),
				'param_name' => 'api_key',
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Hashtag', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Only one hashtag allowed', 'wolf-visual-composer' ),
				'param_name' => 'tag',
				'admin_label' => true,
			),
			
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Layout', 'wolf-visual-composer' ),
				'param_name' => 'type',
				'value' => array(
					esc_html__( 'Grid', 'wolf-visual-composer' ) => 'image_grid',
					esc_html__( 'Carousel', 'wolf-visual-composer' ) => 'carousel',
					esc_html__( 'Metro', 'wolf-visual-composer' ) => 'metro',
					esc_html__( 'Masonry', 'wolf-visual-composer' ) => 'masonry',
				),
				'admin_label' => true,
			),

			array(
				'param_name' => 'metro_pattern',
				'heading' => esc_html__( 'Metro Pattern', 'wolf-visual-composer' ),
				'type' => 'dropdown',
				'value' => $metro_patterns,
				'std' => 'auto',
				'dependency' => array( 'element' => 'type', 'value' => array( 'metro' ) ),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Columns', 'wolf-visual-composer' ),
				'param_name' => 'slides_per_view',
				'value' => array(
					4,1,2,3,5,6, 'auto',
				),
				'dependency' => array( 'element' => 'type', 'value' => array( 'image_grid', 'carousel', 'masonry' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Padding', 'wolf-visual-composer' ),
				'param_name' => 'img_padding',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'no',
				),
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Animate Image One By One', 'wolf-visual-composer' ),
				'param_name' => 'css_animation_each',
				'group' => esc_html__( 'Animation', 'wolf-visual-composer' ),
				'weight' => -5,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Autoplay', 'wolf-visual-composer' ),
				'param_name' => 'autoplay',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'carousel' ) ),
			),
		
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Pause on Hover (if autoplay)', 'wolf-visual-composer' ),
				'param_name' => 'pause_on_hover',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'carousel' ) ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Slideshow Speed in ms', 'wolf-visual-composer' ),
				'param_name' => 'slideshow_speed',
				'value' => 6000,
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'carousel' ) ),
			),
	
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Show Navigation Bullets', 'wolf-visual-composer' ),
				'param_name' => 'nav_bullets',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'carousel' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Show Navigation Arrows', 'wolf-visual-composer' ),
				'param_name' => 'nav_arrows',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'carousel' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Group Cells', 'wolf-visual-composer' ),
				'param_name' => 'group_cells',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'carousel' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Navigation Arrows Tone', 'wolf-visual-composer' ),
				'param_name' => 'nav_arrows_tone',
				'value' => array(
					esc_html__( 'Light', 'wolf-visual-composer' ) => 'light',
					esc_html__( 'Dark', 'wolf-visual-composer' ) => 'dark',
				),
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'carousel' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Navigation Dots Tone', 'wolf-visual-composer' ),
				'param_name' => 'nav_dots_tone',
				'value' => array(
					esc_html__( 'Light', 'wolf-visual-composer' ) => 'light',
					esc_html__( 'Dark', 'wolf-visual-composer' ) => 'dark',
				),
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'type', 'value' => array( 'carousel' ) ),
			),
		)
	)
);

class WPBakeryShortCode_Wvc_Instagram_Gallery extends WPBakeryShortCode {}