<?php
/**
 * Wolf WPBakery Page Builder Extension admin utitliy functions
 *
 * Functions available on admin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Admin
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

function wvc_target_param_list() {
	return array(
		esc_html__( 'Same window', 'wolf-visual-composer' ) => '_self',
		esc_html__( 'New window', 'wolf-visual-composer' ) => '_blank',
	);
}