<?php
/**
 * Wolf WPBakery Page Builder Extension colors functions
 *
 * Output color CSS
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Frontend
 * @version 3.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Output colors inline CSS
 */
function wvc_output_colors_inline_css() {

	$colors = wvc_get_shared_colors_hex();

	$colors_css = '';

	/*----------------------------------------------------

	BACKGROUND

	-------------------------------------------------------*/
	foreach( $colors as $color => $hex ) {

		/* Background */
		$colors_css .= "
			.wvc-background-color-$color{
				background-color:$hex;
			}
		";

		/* Border */
		$colors_css .= "
			.wvc-border-color-$color{
				border-color:$hex;
			}
		";

		/* Button */
		$colors_css .="
			.wvc-button-background-color-$color{
				background-color:$hex;
				color:$hex;
				border-color:$hex;
			}

			.wvc-button-background-color-$color .wvc-button-background-fill{
				box-shadow:0 0 0 0 $hex;
				background-color:$hex;
			}
		";

		/* Icons */
		$colors_css .="
			.wvc-icon-color-$color{
				color:$hex;
			}

			.wvc-svg-icon-color-$color svg *{
				stroke:$hex!important;
			}

			.wvc-icon-background-color-$color{
				box-shadow:0 0 0 0 $hex;
				background-color:$hex;
				color:$hex;
				border-color:$hex;
			}

			.wvc-icon-background-color-$color .wvc-icon-background-fill{
				box-shadow:0 0 0 0 $hex;
				background-color:$hex;
			}
		";

		/* Text */
		$colors_css .="
			.wvc-text-color-$color{
				color:$hex!important;
			}
		";
	}

	if ( ! SCRIPT_DEBUG ) {
		$colors_css = wvc_clean_spaces( $colors_css );
	}

	wp_add_inline_style( 'wvc-styles', $colors_css );
}
add_action( 'wp_enqueue_scripts', 'wvc_output_colors_inline_css' );