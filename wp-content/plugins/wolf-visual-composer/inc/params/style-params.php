<?php
/**
 * Style params for containers
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Row custom params
 */
function wvc_style_params() {
	return array(
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'CSS box', 'wolf-visual-composer' ),
			'param_name' => 'css',
			'group' => esc_html__( 'Custom', 'wolf-visual-composer' ),
			'weight' => -1,
		),
	);
}