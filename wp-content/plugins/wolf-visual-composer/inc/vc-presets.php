<?php
/**
 * Wolf WPBakery Page Builder Extension VC presets functions
 *
 * Set default setttings values for in-built elements
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Core
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Set section presets
 */
function wvc_add_section_presets() {
	do_action(
		'vc_register_settings_preset',
		esc_html__( 'Wolf Row Presets', 'wolf-visual-composer' ),
		'vc_row',
		array(
			'full_width' => 'stretch_row',
			'gap' => '35',
		),
	true );
}
