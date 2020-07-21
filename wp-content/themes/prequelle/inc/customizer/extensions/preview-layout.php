<?php
/**
 * Prequelle customizer fonts preview functions
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Returns CSS for the layout.
 *
 *
 * @param array $fonts Fonts family.
 * @return string Fonts CSS.
 */
function prequelle_get_layout_css( $values ) {

	$values = wp_parse_args( $values, array(
		'site_width' => '',
		'menu_item_horizontal_padding' => '',
		'logo_max_width' => '',
	) );

	extract( $values );

	$layout_css = '';

	if ( $site_width ) {
	}

	if ( $logo_max_width ) {
		$layout_css .= '
			.logo{
				max-width:'  . $logo_max_width . ';
			}
		';
	}

	if ( $menu_item_horizontal_padding ) {
		$layout_css .= '
			.nav-menu-desktop li a{
				padding: 0 '  .$menu_item_horizontal_padding . 'px;
			}
		';
	}

	/* make "hot" & "new" menu label translatable */
	$layout_css .= '
		.nav-menu li.hot > a .menu-item-text-container:before{
			content : "' . esc_html__( 'hot', 'prequelle' ) . '";
		}

		.nav-menu li.new > a .menu-item-text-container:before{
			content : "' . esc_html__( 'new', 'prequelle' ) . '";
		}

		.nav-menu li.sale > a .menu-item-text-container:before{
			content : "' . esc_html__( 'sale', 'prequelle' ) . '";
		}
	';

	return apply_filters( 'prequelle_layout_css_output', $layout_css, $values );
}

/**
 * Get array of layout values of the Underscore template
 *
 * @return array $values
 */
function prequelle_get_template_layout() {

	$values = array(
		'site_width',
		'logo_max_width',
	);

	foreach ( $values as $id ) {
		$values[ $id ] =  '{{ data.' . $id . ' }}';
	}

	return $values;
}

/**
 * Outputs an Underscore template for generating CSS for the layout.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 */
function prequelle_layout_css_template() {
	$layout = prequelle_get_template_layout();
	?>
	<script type="text/html" id="tmpl-prequelle-layout">
		<?php echo prequelle_get_layout_css( $layout ); ?>
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'prequelle_layout_css_template' );