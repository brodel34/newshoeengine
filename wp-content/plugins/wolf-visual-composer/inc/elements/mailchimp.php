<?php
/**
 * MailChimp
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
$icons_params = vc_map_integrate_shortcode( wvc_icon_params(), 'si_', '', array(
	'include_only_regex' => '/^(type|icon_\w*)/',
), array(
	'element' => 'submit_type',
	'value' => 'icon',
) );
if ( is_array( $icons_params ) && ! empty( $icons_params ) ) {
	foreach ( $icons_params as $key => $param ) {
		if ( is_array( $param ) && ! empty( $param ) ) {

			if ( ! isset( $param['group'] ) ) {
			}

			if ( 'si_type' == $param['param_name'] ) {
				$icons_params[ $key ]['dependency'] = array(
					'element' => 'submit_type',
					'value' => 'icon',
				);
			}

			if ( isset( $param['admin_label'] ) ) {
				unset( $icons_params[ $key ]['admin_label'] );
			}
		}
	}
}

vc_map(
	array(
		'name' => esc_html__( 'MailChimp', 'wolf-visual-composer' ),
		'base' => 'wvc_mailchimp',
		'category' => esc_html__( 'Social' , 'wolf-visual-composer' ),
		'description' => esc_html__( 'Newsletter subscription form', 'wolf-visual-composer' ),
		'icon' => 'fa wolficon-mailchimp',
		'params' => array_merge(
			array(
				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'List ID', 'wolf-visual-composer' ),
					'param_name' => 'list',
					'description' => esc_html__( 'It can be found in your MailChimp account -> Lists -> Your List Name -> Settings -> List Name & default', 'wolf-visual-composer' ),
					'value' => wolf_vc_get_option( 'mailchimp', 'default_mailchimp_list_id' ),
					'admin_label' => true,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Ask name', 'wolf-visual-composer' ),
					'param_name' => 'show_name',
					'value' => array(
						esc_html__( 'No', 'wolf-visual-composer' ) => 'no',
						esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
					),
					'admin_label' => true,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Show Default Background', 'wolf-visual-composer' ),
					'description' => esc_html__( 'You can set a background in the MailChimp plugin settings.', 'wolf-visual-composer' ),
					'param_name' => 'show_bg',
					'value' => array(
						esc_html__( 'No', 'wolf-visual-composer' ) => 'no',
						esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
					),
					'admin_label' => true,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Show Default Label', 'wolf-visual-composer' ),
					'description' => esc_html__( 'You can set a label in the MailChimp plugin settings.', 'wolf-visual-composer' ),
					'param_name' => 'show_label',
					'value' => array(
						esc_html__( 'No', 'wolf-visual-composer' ) => 'no',
						esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
					),
					'admin_label' => true,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Size', 'wolf-visual-composer' ),
					'param_name' => 'size',
					'value' => array(
						esc_html__( 'Inline', 'wolf-visual-composer' ) => 'large',
						esc_html__( 'Normal', 'wolf-visual-composer' ) => 'normal',
					),
					'admin_label' => true,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Submit Type', 'wolf-visual-composer' ),
					'param_name' => 'submit_type',
					'value' => array(
						esc_html__( 'Text', 'wolf-visual-composer' ) => 'text',
						esc_html__( 'Icon', 'wolf-visual-composer' ) => 'icon',
					),
					'admin_label' => true,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Submit Text', 'wolf-visual-composer' ),
					'param_name' => 'submit_text',
					'value' => wolf_vc_get_option( 'mailchimp', 'subscribe_text', esc_html__( 'Subscribe', 'wolf-visual-composer' ) ),
					'std' => wolf_vc_get_option( 'mailchimp', 'subscribe_text', esc_html__( 'Subscribe', 'wolf-visual-composer' ) ),
					'admin_label' => true,
					'dependency' => array(
						'element' => 'submit_type',
						'value' => 'text',
					),
				),
			),
			$icons_params,
			array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Text Alignment', 'wolf-visual-composer' ),
					'param_name' => 'text_alignment',
					'value' => array(
						esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
						esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
						esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
					),
					'admin_label' => true,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Alignment', 'wolf-visual-composer' ),
					'param_name' => 'alignment',
					'value' => array(
						esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
						esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
						esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
					),
					'admin_label' => true,
				),
			)
		)
	)
);

class WPBakeryShortCode_Wvc_Mailchimp extends WPBakeryShortCode {}