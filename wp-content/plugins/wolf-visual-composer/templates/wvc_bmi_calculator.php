<?php
/**
 * Video shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Templates
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'title' => '',
	'subtitle' => '',
	'unit' => 'metric',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_script( 'wvc-bmic' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$class .= ' wvc-bmic-container wvc-element';
?>

<div  class="<?php echo wvc_sanitize_html_classes( $class ); ?>"
	style="<?php echo wvc_esc_style_attr( $inline_style ); ?>"
<?php echo wvc_element_aos_animation_data_attr( $atts ); ?>
>
	<div class="wvc-bmic-inner row">
		<div class="wvc-bmic-table-container col col-6">
			<h3 class="wvc-bmic-title"><?php esc_html_e( 'BMI Calculator Chart', 'wolf-visual-composer' ); ?></h3>
			<table>
				<thead>
					<tr>
						<th><?php esc_html_e( 'BMI', 'wolf-visual-composer' ); ?></th>
						<th><?php esc_html_e( 'Weight Status', 'wolf-visual-composer' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php printf( wvc_kses( __( 'Below %s', 'wolf-visual-composer' ) ), '18.5' );?></td>
						<td><?php esc_html_e( 'Underweight', 'wolf-visual-composer' ); ?></td>
					</tr>
					<tr>
						<td>18.5 - 24.9</td>
						<td><?php esc_html_e( 'Healthy', 'wolf-visual-composer' ); ?></td>
					<tr>
					</tr>
						<td>25.0 - 29.9</td>
						<td><?php esc_html_e( 'Overweight', 'wolf-visual-composer' ); ?></td>
					</tr>
					</tr>
						<td><?php printf( wvc_kses( __( '%s - and Above', 'wolf-visual-composer' ) ), '30.0' ); ?></td>
						<td><?php esc_html_e( 'Obese', 'wolf-visual-composer' ); ?></td>
					</tr>
				</tbody>
			</table>
			<div class="wvc-bmic-legend">
				<span>
				<sup>*</sup> <span class="wvc-bmic-legend-bold">BMR</span> Metabolic Rate / <span class="wvc-bmic-legend-bold">BMI</span> Body Mass Index
				</span>
			</div>
		</div>
		<div class="wvc-bmic-form-container col col-6">
			<?php if ( $title ) : ?>
				<h3 class="wvc-bmic-title"><?php echo sanitize_text_field( $title ); ?></h3>
			<?php endif; ?>

			<?php if ( $content ) : ?>
				<div class="wvc-bmic-subtitle"><?php echo wpb_js_remove_wpautop( $content, true ); ?></div>
			<?php endif; ?>
			
			<form class="wvc-bmic-form" action="#" method="POST">
				<input type="hidden" name="unit" value="<?php echo esc_attr( $unit ); ?>" class="wvc-bmi-unit">
				<div class="wpcf7-inline-wrapper">
					<p class="wpcf7-inline-field">
						<?php if ( 'metric' === $unit ): ?>
							<input placeholder="<?php esc_html_e( 'Height / cm', 'wolf-visual-composer' ) ?>" type="text" name="height" class="wvc-bmi-height">
						<?php else : ?>
							<input placeholder="<?php esc_html_e( 'Height / in', 'wolf-visual-composer' ) ?>" type="text" name="height" class="wvc-bmi-height">
						<?php endif; ?>
						
					</p>
					<p class="wpcf7-inline-field">
						<?php if ( 'metric' === $unit ): ?>
							<input placeholder="<?php esc_html_e( 'Weight / kg', 'wolf-visual-composer' ) ?>" type="text" name="weight" class="wvc-bmi-weight">
						<?php else : ?>
							<input placeholder="<?php esc_html_e( 'Weight / lbs', 'wolf-visual-composer' ) ?>" type="text" name="weight" class="wvc-bmi-weight">
						<?php endif; ?>
					</p>
				</div>

				<div class="wpcf7-inline-wrapper">
					<p class="wpcf7-inline-field">
						<input placeholder="<?php esc_html_e( 'Age', 'wolf-visual-composer' ) ?>" type="text" name="age" class="wvc-bmi-age">
					</p>
					<p class="wpcf7-inline-field">
						<select name="sex" class="wvc-bmi-sex">
							<option value=""><?php esc_html_e( 'Sex', 'wolf-visual-composer' ) ?></option>
							<option value="female"><?php esc_html_e( 'Female', 'wolf-visual-composer' ) ?></option>
							<option value="male"><?php esc_html_e( 'Male', 'wolf-visual-composer' ) ?></option>
						</select>
					</p>
				</div>

				<div class="wpcf7-wrapper">
					<p class="wpcf7-field">
						<select name="af" class="wvc-bmi-activity-factor">
							<option value=""><?php esc_html_e( 'Activity', 'wolf-visual-composer' ) ?></option>
							<option value="inactive"><?php esc_html_e( 'Little or no Exercise / desk job', 'wolf-visual-composer' ); ?></option>
							<option value="low"><?php esc_html_e( 'Light exercise / sports 1 – 3 days/ week', 'wolf-visual-composer' ); ?></option>
							<option value="moderate"><?php esc_html_e( 'Moderate Exercise, sports 3 – 5 days / week', 'wolf-visual-composer' ); ?></option>
							<option value="high"><?php esc_html_e( 'Heavy Exercise/ sports 6 – 7 days / week', 'wolf-visual-composer' ); ?></option>
							<option value="very-high"><?php esc_html_e( 'Very Heavy Exercise/ sports & physical job or 2x training', 'wolf-visual-composer' ); ?></option>
						</select>
					</p>
				</div>
				<button class="<?php echo apply_filters( 'wvc_bmic_submit_button_class', 'button' ); ?> wvc-bmic-submit"><?php esc_html_e( 'Calculate', 'wolf-visual-composer' ); ?></button>
			</form>
		</div>
	</div><!-- .wvc-bmic-inner -->
<div class="wvc-bmic-result clearfix"><div class="wvc-bmic-result-inner"></div><span class="wvc-bmic-result-close">X</span></div>
</div>