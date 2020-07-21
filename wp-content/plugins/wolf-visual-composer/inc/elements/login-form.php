<?php
/**
 * Login form
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Login Form', 'wolf-visual-composer' ),
		'base' => 'wvc_login_form',
		'description' => esc_html__( 'A membership frontent login form', 'wolf-visual-composer' ),
		'icon' => 'icon-wpb-wp',
		'category' => esc_html__( 'Music' , 'wolf-visual-composer' ),
		'params' => array(
		),
	)
);

class WPBakeryShortCode_Wvc_Login_Form extends WPBakeryShortCode {}