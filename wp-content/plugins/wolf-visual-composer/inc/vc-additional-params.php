<?php
/**
 * Wolf WPBakery Page Builder Extension Element Additional Settings
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Admin
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add styling option to post modules
 *
 * @param array $elements
 * @return array $elements
 */
function wvc_add_params_to_post_modules(  $elements ) {

	$modules = array(
		'wvc_page_index',
		'wvc_post_index',
		'wvc_work_index',
		'wvc_product_index',
		'wvc_release_index',
		'wvc_event_index',
		'wvc_gallery_index',
		'wvc_artist_index',
		'wvc_video_index',
		'wvc_attachment_index',
		'wvc_mp_event_index',
	);

	$elements = array_merge( $elements, $modules );

	return $elements;
}
add_filter( 'wvc_stylable_elements', 'wvc_add_params_to_post_modules' );
add_filter( 'wvc_extra_class_elements', 'wvc_add_params_to_post_modules' );
add_filter( 'wvc_visibility_elements', 'wvc_add_params_to_post_modules' );

/**
 * Add class name param
 */
$extra_class_elements = apply_filters( 'wvc_extra_class_elements', array(
	'vc_accordion',
	'vc_accordion_tab',
	'vc_button',
	'vc_cta',
	'vc_column',
	'vc_column_inner',
	'vc_column_text',
	'vc_custom_heading',
	'vc_gallery',
	'vc_gmaps',
	'vc_icon',
	'vc_message',
	'vc_pie',
	'vc_progress_bar',
	'vc_separator',
	'vc_single_image',
	'vc_tabs',
	'vc_tab',
	'vc_toggle',
	'vc_video',
	'vc_zigzag',
	'wvc_advanced_slider',
	'wvc_advanced_slide',
	'wvc_audio',
	'wvc_audio_button',
	'wvc_audio_embed',
	'wvc_album_disc',
	'wvc_album_tracklist',
	'wvc_bandsintown_events',
	'wvc_banner',
	'wvc_bigtext',
	'wvc_breadcrumb',
	'wvc_cocoen',
	'wvc_countdown',
	'wvc_counter',
	'wvc_embed_video',
	'wvc_facebook_page_box',
	'wvc_fittext',
	'wvc_google_maps',
	'wvc_hours',
	'wvc_image_device_slider',
	'wvc_image_link',
	'wvc_instagram',
	'wvc_instagram_gallery',
	'wvc_interactive_link_item',
	'wvc_item_price',
	'wvc_list',
	'wvc_mailchimp',
	'wvc_playlist',
	'wvc_posts_slider',
	'wvc_posts_big_slider',
	'wvc_pricing_table',
	'wvc_process_container',
	'wvc_process_item',
	'wvc_service_table',
	'wvc_social_icons',
	'wvc_social_icons_custom',
	'wvc_soundcloud',
	'wvc_spotify_player',
	'wvc_spotify_follow_button',
	'wvc_testimonial_slider',
	'wvc_testimonials',
	'wvc_team_member',
	'wvc_twitter',
	'wvc_typed',
	'wvc_video_opener',
	'wvc_video_switcher',
	'wvc_wc_categories',
) );

foreach ( $extra_class_elements as $extra_class_element ) {
	vc_add_param(
		$extra_class_element,
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'wolf-visual-composer' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'wolf-visual-composer' ),
			'weight' => -1000,
			'group' => esc_html__( 'Extra', 'wolf-visual-composer' ),
		)
	);
}

/**
 * Add slider settings
 */
$slider_elements = apply_filters( 'wvc_slider_elements', array(
	'wvc_image_device_slider',
	'wvc_advanced_slider',
	'wvc_anything_slider',
	'wvc_post_slider',
) );

foreach ( $slider_elements as $slider_element ) {
	vc_add_params(
		$slider_element,
		array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Autoplay', 'wolf-visual-composer' ),
				'param_name' => 'autoplay',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
				'group' => esc_html__( 'Slider Settings', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Pause on Hover (if autoplay)', 'wolf-visual-composer' ),
				'param_name' => 'pause_on_hover',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
				'group' => esc_html__( 'Slider Settings', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Transition', 'wolf-visual-composer' ),
				'param_name' => 'transition',
				'value' => array(
					esc_html__( 'Auto (fade by default and slide on touchable devices)', 'wolf-visual-composer' ) => 'auto',
					esc_html__( 'Slide', 'wolf-visual-composer' ) => 'slide',
					esc_html__( 'Fade', 'wolf-visual-composer' ) => 'fade',
				),
				'group' => esc_html__( 'Slider Settings', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Slideshow Speed in ms', 'wolf-visual-composer' ),
				'param_name' => 'slideshow_speed',
				'value' => 6000,
				'group' => esc_html__( 'Slider Settings', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Show Navigation Bullets', 'wolf-visual-composer' ),
				'param_name' => 'nav_bullets',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
				'group' => esc_html__( 'Slider Settings', 'wolf-visual-composer' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Show Navigation Arrows', 'wolf-visual-composer' ),
				'param_name' => 'nav_arrows',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
				'group' => esc_html__( 'Slider Settings', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Navigation Tone', 'wolf-visual-composer' ),
				'param_name' => 'nav_tone',
				'value' => array(
					esc_html__( 'Light', 'wolf-visual-composer' ) => 'light',
					esc_html__( 'Dark', 'wolf-visual-composer' ) => 'dark',
				),
				'group' => esc_html__( 'Slider Settings', 'wolf-visual-composer' ),
			),
		)
	);
}

/**
 * Add animation and animation delay settings to certain elements
 */
$animated_elements = apply_filters( 'wvc_animated_elements', array(
	'vc_accordion',
	'vc_button',
	'vc_cta',
	'vc_column',
	'vc_column_inner',
	'vc_column_text',
	'vc_custom_heading',
	'vc_gallery',
	'vc_gmaps',
	'vc_icon',
	'vc_message',
	'vc_pie',
	'vc_progress_bar',
	'vc_separator',
	'vc_single_image',
	'vc_tabs',
	'vc_toggle',
	'vc_video',
	'vc_zigzag',
	'wvc_advanced_slider',
	'wvc_audio',
	'wvc_audio_button',
	'wvc_audio_embed',
	'wvc_album_disc',
	'wvc_album_tracklist',
	'wvc_bandsintown_events',
	'wvc_banner',
	'wvc_bigtext',
	'wvc_breadcrumb',
	'wvc_cocoen',
	'wvc_embed_video',
	'wvc_facebook_page_box',
	'wvc_google_maps',
	'wvc_image_device_slider',
	'wvc_headline',
	'wvc_hours',
	'wvc_image_link',
	'wvc_instagram_gallery',
	'wvc_item_price',
	'wvc_list',
	'wvc_mailchimp',
	'wvc_playlist',
	'wvc_posts_slider',
	'wvc_posts_big_slider',
	'wvc_pricing_table',
	'wvc_process_container',
	'wvc_service_table',
	'wvc_social_icons',
	'wvc_social_icons_custom',
	'wvc_soundcloud',
	'wvc_spotify_player',
	'wvc_spotify_follow_button',
	'wvc_testimonial_slider',
	'wvc_testimonials',
	'wvc_team_member',
	'wvc_twitter',
	'wvc_typed',
	'wvc_video_switcher',
	'wvc_wc_categories',
) );

foreach ( $animated_elements as $animated_element ) {

	vc_add_params(
		$animated_element,
		array(
			array(
				'type' => 'animation_style',
				'heading' => esc_html__( 'Animation', 'wolf-visual-composer' ),
				'param_name' => 'css_animation',
				'group' => esc_html__( 'Animation', 'wolf-visual-composer' ),
				'weight' => -1,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Animation Delay (in ms)', 'wolf-visual-composer' ),
				'param_name' => 'css_animation_delay',
				'placeholder' => 0,
				'group' => esc_html__( 'Animation', 'wolf-visual-composer' ),
				'weight' => -1,
			),
		)
	);
}

/**
 * Add design tab to chosen elements
 */
$stylable_elements = apply_filters( 'wvc_stylable_elements', array(
	'vc_accordion',
	'vc_accordion_tab',
	'vc_button',
	'vc_cta',
	'vc_column',
	'vc_column_inner',
	'vc_column_text',
	'vc_custom_heading',
	'vc_gallery',
	'vc_gmaps',
	'vc_icon',
	'vc_message',
	'vc_pie',
	'vc_progress_bar',
	'vc_separator',
	'vc_single_image',
	'vc_row_inner',
	'vc_toggle',
	'vc_tabs',
	'vc_tab',
	'vc_video',
	'vc_zigzag',
	'wvc_audio',
	'wvc_audio_button',
	'wvc_audio_embed',
	'wvc_album_disc',
	'wvc_album_tracklist',
	'wvc_bandsintown_events',
	'wvc_banner',
	'wvc_bigtext',
	'wvc_breadcrumb',
	'wvc_call_to_action',
	'wvc_cocoen',
	'wvc_countdown',
	'wvc_counter',
	'wvc_device_image_slider',
	'wvc_embed_video',
	'wvc_facebook_page_box',
	'wvc_fittext',
	'wvc_google_maps',
	'wvc_hours',
	'wvc_image_device_slider',
	'wvc_image_link',
	'wvc_instagram',
	'wvc_item_price',
	'wvc_list',
	'wvc_mailchimp',
	'wvc_playlist',
	'wvc_pricing_table',
	'wvc_process_container',
	'wvc_posts_slider',
	'wvc_posts_big_slider',
	'wvc_separator',
	'wvc_service_table',
	'wvc_skill_bar',
	'wvc_soundcloud',
	'wvc_social_icons',
	'wvc_social_icons_custom',
	'wvc_spotify_player',
	'wvc_spotify_follow_button',
	'wvc_team_member',
	'wvc_testimonial_slider',
	'wvc_twitter',
	'wvc_typed',
	'wvc_video_opener',
	'wvc_video_switcher',
	'wvc_youtube',
	'wvc_wc_categories',
) );

foreach ( $stylable_elements as $stylable_element ) {
	vc_add_params(
		$stylable_element,
		array(
			array(
				'type' => 'css_editor',
				'heading' => esc_html__( 'Css', 'wolf-visual-composer' ),
				'param_name' => 'css',
				'group' => esc_html__( 'Custom', 'wolf-visual-composer' ),
				'weight' => -10,
			),
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Inline Style', 'wolf-visual-composer' ),
				'param_name' => 'inline_style',
				'group' => esc_html__( 'Custom', 'wolf-visual-composer' ),
				'description' => sprintf( esc_html__( 'Additional inline CSS that will be applied to the element. (e.g: %s)', 'wolf-visual-composer' ), 'color:red;' ),
				'weight' => -100, // be sure it's at the end of the form
			),
		)
	);
}

/**
 * Add carousel settings
 */
$carousel_elements = apply_filters( 'wvc_carousel_elements', array(
	'wvc_testimonials',
	'wvc_testimonial_slider',
) );

foreach ( $carousel_elements as $carousel_element ) {
	vc_add_params(
		$carousel_element,
		array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Autoplay', 'wolf-visual-composer' ),
				'param_name' => 'autoplay',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'true',
					esc_html__( 'No', 'wolf-visual-composer' ) => 'false',
				),
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
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
			),
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Slideshow Speed in ms', 'wolf-visual-composer' ),
				'param_name' => 'slideshow_speed',
				'value' => 6000,
				'group' => esc_html__( 'Carousel Settings', 'wolf-visual-composer' ),
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
			),
		)
	);
}

/**
 * Add visibility settings
 */
$visibility_elements = apply_filters( 'wvc_visibility_elements', array(
	'vc_custom_heading',
	'vc_column_text',
	'vc_empty_space',
	'vc_single_image',
	'wvc_social_icons',
) );

foreach ( $visibility_elements as $visibility_element ) {
	vc_add_params(
		$visibility_element,
		array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Visibility', 'wolf-visual-composer' ),
				'param_name' => 'hide_class',
				'value' => array(
					esc_html__( 'Always visible', 'wolf-visual-composer' ) => '',
					esc_html__( 'Hide on tablet and mobile', 'wolf-visual-composer' ) => 'wvc-hide-tablet',
					esc_html__( 'Hide on mobile', 'wolf-visual-composer' ) => 'wvc-hide-mobile',
					esc_html__( 'Show on tablet and mobile only', 'wolf-visual-composer' ) => 'wvc-show-tablet',
					esc_html__( 'Show on mobile only', 'wolf-visual-composer' ) => 'wvc-show-mobile',
					esc_html__( 'Always hidden', 'wolf-visual-composer' ) => 'wvc-hide',
				),
				'group' => esc_html__( 'Extra', 'wolf-visual-composer' ),
				'weight' => -1000, // be sure it's at the end of the form
			),
		)
	);
}

if ( class_exists( 'Wolf_Videos' ) ) {
	/**
	 * Wolf Videos
	 */
	vc_add_param(
		'wolf_last_videos',
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Padding', 'wolf-visual-composer' ),
			'param_name' => 'padding',
			'value' => array(
				'yes' => esc_html__( 'Yes', 'wolf-visual-composer' ),
				'no' => esc_html__( 'No', 'wolf-visual-composer' ),
			),
		)
	);
	vc_add_param(
		'wolf_last_videos',
		array(
			'type' => 'animation_style',
			'heading' => esc_html__( 'Animation', 'wolf-visual-composer' ),
			'param_name' => 'css_animation',
		)
	);
}

if ( class_exists( 'Wolf_Albums' ) ) {
	/**
	 * Wolf Albums
	 */
	vc_add_param(
		'wolf_last_albums',
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Padding', 'wolf-visual-composer' ),
			'param_name' => 'padding',
			'value' => array(
				'yes' => esc_html__( 'Yes', 'wolf-visual-composer' ),
				'no' => esc_html__( 'No', 'wolf-visual-composer' ),
			),
		)
	);
	vc_add_param(
		'wolf_last_albums',
		array(
			'type' => 'animation_style',
			'heading' => esc_html__( 'Animation', 'wolf-visual-composer' ),
			'param_name' => 'css_animation',
		)
	);
}

if ( class_exists( 'Wolf_Discography' ) ) {
	/**
	 * Wolf Discorgaphy
	 */
	vc_add_param(
		'wolf_last_releases',
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Padding', 'wolf-visual-composer' ),
			'param_name' => 'padding',
			'value' => array(
				'yes' => esc_html__( 'Yes', 'wolf-visual-composer' ),
				'no' => esc_html__( 'No', 'wolf-visual-composer' ),
			),
		)
	);
	vc_add_param(
		'wolf_last_releases',
		array(
			'type' => 'animation_style',
			'heading' => esc_html__( 'Animation', 'wolf-visual-composer' ),
			'param_name' => 'css_animation',
		)
	);
}