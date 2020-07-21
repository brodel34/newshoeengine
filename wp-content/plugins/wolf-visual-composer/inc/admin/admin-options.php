<?php
/**
 * Wolf WPBakery Page Builder Extension Plugin Settings
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Admin
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$social_fields = array();

$wvc_socials = wvc_get_socials();

foreach ( $wvc_socials as $social ) {

	$no_http = array( 'skype', 'email' );

	if ( in_array( $social, $no_http ) ) {
		$type = 'text';
		$placeholder = '';
	} else {
		$type = 'url';
		$placeholder = 'http://';
	}

	$social_fields[] = array(
		'type' => $type,
		'field_id' => $social,
		'label' => ucfirst( $social ) . ' URL',
		'placeholder' => $placeholder,
	);
}

$social_fields[] = array(
	'type' => 'message',
	'field_id' => 'social_message',
	'description' => sprintf( esc_html( 'Need more social services? Send us an email! %s', 'wolf-visual-composer' ), 'contact@wolfthemes.com' ),
);

/**
 * WVC settings panel
 */
$wvc_options = array(

	array(
		'title' => esc_html__( 'Google Map', 'wolf-visual-composer' ),
		'settings_id' => 'wvc-google-map',
		'settings_slug' => 'google-map',
		'fields' => array(
			array(
				'type' => 'text',
				'field_id' => 'google_maps_api_key',
				'label' => esc_html__( 'Google Map API key', 'wolf-visual-composer' ),
				'description' => sprintf(
					wp_kses_post( __( 'You can get a Google Map API key <a href="%s" target="_blank">here</a>.', 'wolf-visual-composer' ) ),
					esc_url( 'https://developers.google.com/maps/documentation/javascript/get-api-key' ) ),
				'placeholder' => 'CIzaqsdMik5OYxo5hIZGvi6XhIQsvsOdUJQmm_beS8-us8',
			),
		),
	),

	array(
		'title' => esc_html__( 'MailChimp', 'wolf-visual-composer' ),
		'settings_id' => 'wvc-mailchimp',
		'settings_slug' => 'mailchimp',
		'fields' => array(
			array(
				'type' => 'text',
				'field_id' => 'mailchimp_api_key',
				'label' => esc_html__( 'MailChimp API key', 'wolf-visual-composer' ),
				'description' => sprintf(
					wp_kses_post( __( 'You can get a MailChimp API key <a href="%s" target="_blank">here</a>.', 'wolf-visual-composer' ) ),
					esc_url( 'http://kb.mailchimp.com/integrations/api-integrations/about-api-keys' ) ),
				'placeholder' => '565b514d72e6fd8875u04884069721c1-us6',
			),

			array(
				'type' => 'text',
				'field_id' => 'default_mailchimp_list_id',
				'label' => esc_html__( 'Default MailChimp list ID', 'wolf-visual-composer' ),
				'description' => sprintf(
					wp_kses_post( __( '<a href="%s" target="_blank">Find Your List ID</a>.', 'wolf-visual-composer' ) ),
					esc_url( 'http://kb.mailchimp.com/lists/manage-contacts/find-your-list-id' ) ),
				'placeholder' => 'eg7ab65dc8',
			),

			array(
				'type' => 'text',
				'field_id' => 'label',
				'label' => esc_html__( 'Newsletter form title', 'wolf-visual-composer' ),
				'placeholder' => esc_html__( 'Subscribe to our newsletter', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'text',
				'field_id' => 'subscribe_text',
				'label' => esc_html__( '"Subscribe" button text', 'wolf-visual-composer' ),
				'placeholder' => esc_html__( 'Subscribe', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'text',
				'field_id' => 'placeholder_f_name',
				'label' => esc_html__( 'Form first name input placeholder', 'wolf-visual-composer' ),
				'placeholder' => esc_html__( 'Your first name', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'text',
				'field_id' => 'placeholder_l_name',
				'label' => esc_html__( 'Form last name input placeholder', 'wolf-visual-composer' ),
				'placeholder' => esc_html__( 'Your last name', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'text',
				'field_id' => 'placeholder',
				'label' => esc_html__( 'Form email input placeholder', 'wolf-visual-composer' ),
				'placeholder' => esc_html__( 'Your email', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'text',
				'field_id' => 'thank_you_message',
				'label' => esc_html__( 'Thank you message', 'wolf-visual-composer' ),
				'placeholder' => esc_html__( 'Thanks for subscribing', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'image',
				'field_id' => 'background',
				'label' => esc_html__( 'Background image', 'wolf-visual-composer' ),
			),
		),
	),
	array(
		'title' => esc_html__( 'Fonts Loader', 'wolf-visual-composer' ),
		'settings_id' => 'wvc-fonts',
		'settings_slug' => 'fonts',
		'fields' => array(
			array(
				'type' => 'text',
				'field_id' => 'google_fonts',
				'label' => esc_html__( 'Google fonts', 'wolf-visual-composer' ),
				'placeholder' => 'Roboto:400,700|Lora:400,700',
				'description' =>  sprintf( __( 'You can get your fonts on the <a href="%s" target="_blank">Google Fonts</a> website.', 'wolf-visual-composer' ), 'https://www.google.com/fonts'
				),
			),
		),
	),
	array(
		'title' => esc_html__( 'Social Profiles', 'wolf-visual-composer' ),
		'settings_id' => 'wvc-socials',
		'settings_slug' => 'socials',
		'fields' => $social_fields,
	)
);

if ( class_exists( 'Wolf_Vc_Content_Block' ) ) {

	$content_block_posts = get_posts( 'post_type="wvc_content_block"&numberposts=-1' );

	$content_blocks = array(
			'' => '&mdash; ' . esc_html__( 'Disabled', 'wolf-visual-composer' ) . ' &mdash;',
		);
		if ( $content_block_posts ) {
			foreach ( $content_block_posts as $content_block_options ) {
				$content_blocks[ $content_block_options->ID ] = $content_block_options->post_title;
			}
		} else {
			$content_blocks[0] = esc_html__( 'No Content Block Yet', 'wolf-visual-composer' );
		}

	$wvc_options[] = array(
		'title' => esc_html__( 'Modal Window', 'wolf-visual-composer' ),
		'settings_id' => 'wvc-modal-window',
		'parent_slug' => 'themes.php',
		'settings_slug' => 'modal_window',
		'fields' => array(
			array(
				'type' => 'select',
				'field_id' => 'content_block_id',
				'label' => esc_html__( 'Modal Window Content', 'wolf-visual-composer' ),
				'choices' => $content_blocks,
				'description' => sprintf(
					wp_kses_post( __( 'Choose a <a href="%s" target="_blank">content block</a> to display in your modal window.', 'wolf-visual-composer' ) ),
					esc_url( 'http://wlfthm.es/content-blocks' ) ),
			),

			array(
				'type' => 'select',
				'field_id' => 'type',
				'label' => esc_html__( 'Modal Window Type', 'wolf-visual-composer' ),
				'choices' => array(
					'full' => esc_html__( 'Standard', 'wolf-visual-composer' ),
					'non_intrusive' => esc_html__( 'Non-Intrusive (bottom right corner)', 'wolf-visual-composer' ),
				),
			),

			array(
				'type' => 'checkbox',
				'field_id' => 'exclude_mc_subs',
				'label' => esc_html__( 'Exclude MailChimp subscribers', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'text',
				'field_id' => 'delay',
				'label' => esc_html__( 'Pop-up Delay', 'wolf-visual-composer' ),
				'placeholder' => 3,
				'description' => wp_kses_post( __( 'The time before the modal window pops up in seconds.<br>You can set a very high number to prevent the window to pop-up automatically if you want it to be open via a link (see the "info" section at the bottom of this page).', 'wolf-visual-composer' ) ),
			),

			array(
				'type' => 'checkbox',
				'field_id' => 'show_once',
				'label' => esc_html__( 'Show Only Once', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Don\'t show the pop-up again once it is closed. If this option is not checked, an opt-out link will be displayed below the window.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'checkbox',
				'field_id' => 'show_navigate_away',
				'label' => esc_html__( 'Show When Navigates Away', 'wolf-visual-composer' ),
				'description' => esc_html__( 'The window will pop up only when the mouse leave the main window. The pop-up delay will still be applied.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'text',
				'field_id' => 'cookie_time',
				'label' => esc_html__( 'Cookie Persistency', 'wolf-visual-composer' ),
				'placeholder' => 1,
				'description' => esc_html__( 'How long the browser will remember the user opt-out action (in days).', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'text',
				'field_id' => 'content_width',
				'label' => esc_html__( 'Modal Window Width', 'wolf-visual-composer' ),
				'placeholder' => '960px',
			),

			array(
				'type' => 'text',
				'field_id' => 'exclude_post_types',
				'label' => esc_html__( 'Exclude Post Types', 'wolf-visual-composer' ),
				'placeholder' => 'post,page',
				'description' => esc_html__( 'The modal window will NOT popup in these specific post types. Separate each post type by a comma.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'text',
				'field_id' => 'include_post_types',
				'label' => esc_html__( 'Include Post Types', 'wolf-visual-composer' ),
				'placeholder' => 'post,page',
				'description' => esc_html__( 'The modal window will popup ONLY in these specific post types. Separate each post type by a comma.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'text',
				'field_id' => 'exclude_ids',
				'label' => esc_html__( 'Exclude Post IDs', 'wolf-visual-composer' ),
				'placeholder' => '654,897,123',
				'description' => esc_html__( 'The modal window will NOT popup in these specific posts. Separate each ID by a comma.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'text',
				'field_id' => 'include_ids',
				'label' => esc_html__( 'Include Post IDs', 'wolf-visual-composer' ),
				'placeholder' => '654,897,123',
				'description' => esc_html__( 'The modal window will popup ONLY in these specific posts. Separate each ID by a comma.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'colorpicker',
				'field_id' => 'close_button_color',
				'label' => esc_html__( 'Close Button Color', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'message',
				'field_id' => 'info',
				'label' => esc_html__( 'Info', 'wolf-visual-composer' ),
				'description' =>  sprintf(
					wp_kses_post( __( 'You can add the <strong>"%s"</strong> class to any link to use it as pop-up window "close" button.<br>Also add the <strong>"%s"</strong> class to use it as opt-out button. ("Don\'t show this message again" link)<br>Additionally, if you need a link that open the modal window, you can use the <strong>"%s"</strong> class.', 'wolf-visual-composer' ) ),
					'wvc-modal-window-close',
					'wvc-modal-window-opt-out',
					'wvc-modal-window-open'
				),
			),
		),
	);

	$page_option = array( '' => '&mdash; ' . esc_html__( 'Disabled', 'wolf-visual-composer' ) . ' &mdash;', );
	$pages = get_pages();

	foreach ( $pages as $page ) {

		if ( get_post_field( 'post_parent', $page->ID ) ) {
			$page_option[ absint( $page->ID ) ] = '&nbsp;&nbsp;&nbsp; ' . sanitize_text_field( $page->post_title );
		} else {
			$page_option[ absint( $page->ID ) ] = sanitize_text_field( $page->post_title );
		}
	}

	$wvc_options[] = array(
		'title' => esc_html__( 'Privacy Policy Message', 'wolf-visual-composer' ),
		'settings_id' => 'wvc-privacy-policy-message',
		'settings_slug' => 'privacy_policy_message',
		'parent_slug' => 'themes.php',
		'fields' => array(
			
			array(
				'type' => 'select',
				'field_id' => 'status',
				'label' => esc_html__( 'Status', 'wolf-visual-composer' ),
				'choices' => array(
					'' => '&mdash; ' . esc_html__( 'Disabled', 'wolf-visual-composer' ) . ' &mdash;',
					'enabled' => esc_html__( 'Enabled', 'wolf-visual-composer' ),
				),
			),

			array(
				'type' => 'textarea',
				'field_id' => 'privacy_policy_message',
				'label' => esc_html__( 'Privacy Policy Message', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'select',
				'field_id' => 'privacy_policy_page',
				'label' => esc_html__( 'Privacy Policy Page', 'wolf-visual-composer' ),
				'choices' => $page_option,
				'description' => esc_html__( 'If a page is set, a link to the Privacy Policy Page will be displayed.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'text',
				'field_id' => 'link_text',
				'label' => esc_html__( 'Link Text', 'wolf-visual-composer' ),
				'placeholder' => esc_html__( 'Read more', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'colorpicker',
				'field_id' => 'bg_color',
				'label' => esc_html__( 'Background Color', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'colorpicker',
				'field_id' => 'font_color',
				'label' => esc_html__( 'Font Color', 'wolf-visual-composer' ),
			),
		),
	);
}

return new WVC_Options( $wvc_options );