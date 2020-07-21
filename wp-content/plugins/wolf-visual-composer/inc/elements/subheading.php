<?php
/**
 * Breadcrumb
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;
vc_map(
	array(
		'name' => esc_html__( 'Subheading', 'wolf-visual-composer' ),
		'description' => esc_html__( 'The Current ', 'wolf-visual-composer' ),
		'base' => 'wvc_subheading',
		'category' => esc_html__( 'Content' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-link',
		'params' => array(
		),
	)
);

//class WPBakeryShortCode_Wvc_Subheading extends WPBakeryShortCode {}