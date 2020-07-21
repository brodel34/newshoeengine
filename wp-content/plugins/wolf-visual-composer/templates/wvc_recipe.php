<?php
/**
 * Workout Program shortcode template
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
	'image' => '',
	'description' => '',
	'servings' => '',
	'prep_time' => '',
	'cook_time' => '',
	'total_time' => '',
	'calories' => '',
	'protein' => '',
	'carbs' => '',
	'fat' => '',
	'ingredients' => '',
	'instructions' => '',
	'notes' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

wp_enqueue_style( 'font-awesome' );

wp_enqueue_script( 'wvc-responsive' );
wp_enqueue_script( 'wvc-print' );

$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

$class .= " wvc-recipe wvc-printable-element wvc-element";

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );

$output .= '>';

if ( $subtitle || $title ) {
	$output .= '<div class="wvc-recipe-head">';

	// Title
	if ( $title ) {
		$output .= '<div class="wvc-recipe-title-container">';
			$output .= '<h3 class="wvc-recipe-title" itemprop="name">';
			$output .= esc_attr( $title );
			$output .= '</h3>';
		$output .= '</div>';
	}

	// Subtitle
	if ( $subtitle ) {
		$output .= '<div class="wvc-recipe-subtitle-container">';
			$output .= '<span class="wvc-recipe-subtitle">';
			$output .= esc_attr( $subtitle );
			$output .= '</span>';
		$output .= '</div>';
	}

	if ( $image && wp_attachment_is_image( $image ) ) {
		$output .= '<div class="wvc-recipe-image">';

		$img = wpb_getImageBySize( array(
			'attach_id' => $image,
			'thumb_size' => apply_filters( 'wvc_recipe_image_size', 'large' ),
			'class' => 'wvc-recipe-thumbnail',
		) );

		$output .= $img['thumbnail'];

		$output .= '</div>';
	}

	// Deatils
	if ( $calories || $protein || $carbs || $fat || $servings || $prep_time || $cook_time ) {
		$output .= '<div class="wvc-recipe-details wvc-clearfix">';
		
			if ( $calories ) {
				$output .= '<span class="wvc-recipe-meta wvc-recipe-calories" itemprop="nutrition" itemscope itemtype="http://schema.org/NutritionInformation">';
				$output .= '<span class="wvc-hidden wvc-no-print" itemprop="calories">' . esc_attr( $calories ) . '</span>';

				$output .= '<span class="wvc-recipe-counter">';
				
					$output .= '<span class="wvc-recipe-counter-circle">';
					$output .= do_shortcode(
						'[wvc_counter number="' . absint( $calories ) . '" text="kCal"]'
					);
					$output .= '</span>';
				$output .= '</span>';

				$output .= '</span>';
			}

			if ( $protein ) {
				$output .= '<span class="wvc-recipe-meta wvc-recipe-protein">';
				$output .= '<span class="wvc-hidden wvc-no-print">' . esc_attr( $protein ) . '</span>';

				$output .= '<span class="wvc-recipe-counter">';

					$output .= '<span class="wvc-recipe-counter-circle">';
						$output .= do_shortcode(
							'[wvc_counter number="' . absint( $protein ) . '" suffix="g" text="' . esc_html__( 'Protein', 'wolf-visual-composer' ) . '"]'
						);
						$output .= '</span>';
					$output .= '</span>';

				$output .= '</span>';
			}

			if ( $carbs ) {
				$output .= '<span class="wvc-recipe-meta wvc-recipe-carbs">';
				$output .= '<span class="wvc-hidden wvc-no-print">' . esc_attr( $carbs ) . '</span>';

				$output .= '<span class="wvc-recipe-counter">';

					$output .= '<span class="wvc-recipe-counter-circle">';
					$output .= do_shortcode(
						'[wvc_counter number="' . absint( $carbs ) . '" suffix="g" text="' . esc_html__( 'Carbs', 'wolf-visual-composer' ) . '"]'
					);
					$output .= '</span>';
				$output .= '</span>';

				$output .= '</span>';
			}

			if ( $fat ) {
				$output .= '<span class="wvc-recipe-meta wvc-recipe-fat">';
				$output .= '<span class="wvc-hidden wvc-no-print">' . esc_attr( $fat ) . '</span>';

				$output .= '<span class="wvc-recipe-counter">';

					$output .= '<span class="wvc-recipe-counter-circle">';
				$output .= do_shortcode(
					'[wvc_counter number="' . absint( $fat ) . '" suffix="g" text="' . esc_html__( 'Fat', 'wolf-visual-composer' ) . '"]'
				);
				$output .= '</span>';
				$output .= '</span>';

				$output .= '</span>';
			}
			// if ( $prep_time ) {
			// 	$output .= '<span class="wvc-recipe-meta wvc-recipe-prep-time">';
			// 	$output .= '<meta itemprop="prepTime" content="' . wvc_format_minutes_to_iso( $prep_time ) . '">';
			// 	$output .= wr_format_minutes_to_text( $prep_time );
			// 	$output .= '</span>';
			// }

			// if ( $cook_time ) {
			// 	$output .= '<span class="wvc-recipe-meta wvc-recipe-cook-time">';
			// 	$output .= '<meta itemprop="cookTime" content="' . wvc_format_minutes_to_iso( $cook_time ) . '">';
			// 	$output .= wvc_format_minutes_to_text( $cook_time );
			// 	$output .= '</span>';
			// }

			$total_time = absint( $prep_time ) + absint( $cook_time );

			if ( $total_time ) {
				$output .= '<span class="wvc-recipe-meta wvc-recipe-total-time">';
				$output .= '<meta itemprop="totalTime" content="' . wvc_format_minutes_to_iso( $total_time ) . '">';
				
				$output .= '<span class="wvc-recipe-icon">';

				$output .= '<i class="fa fa-2x fa-clock-o"></i>';

				$output .= '<span class="wvc-recipe-total-time-title">' . esc_html__( 'Total Time', 'wolf-visual-composer' ) . '</span>';
				$output .= '<span class="wvc-recipe-total-time-text">';
				$output .= sprintf( wvc_kses( __( '%d min.', 'wolf-visual-composer' ) ), $total_time );
				$output .= '</span>';
				$output .= '</span>';
				$output .= '</span>';
			}

			if ( $servings ) {
				$output .= '<span class="wvc-recipe-meta wvc-recipe-servings">';

				$output .= '<span class="wvc-recipe-icon">';

				$output .= '<i class="fa fa-2x fa-cutlery"></i>';

				$output .= '<span class="wvc-recipe-servings-title">' . esc_html__( 'Servings', 'wolf-visual-composer' ) . '</span>';
				$output .= '<span class="wvc-recipe-servings-text" itemprop="recipeYield">';
				$output .= sprintf( wvc_kses( __( '%d servings', 'wolf-visual-composer' ) ), $servings );
				$output .= '</span>';
				$output .= '</span>';
				$output .= '</span>';
			}

		$output .= '</div>';
	}

	$output .= '<div class="wvc-no-print">';
		$output .= '<button class="' . apply_filters( 'wvc_print_button', '' ) . ' wvc-recipe-print-button wvc-do-print">';
			$output .= '<span class="wvc-print-button-text">' . esc_html__( 'Print', 'wolf-visual-composer' ) . '</span>';
		$output .= '</button>';
	$output .= '</div>';

	$output .= '</div>'; // head

	$output .= '<div class="wvc-recipe-body">';

	// Description
	if ( $description ) {
		$output .= '<div class="wvc-recipe-description-container">';
			$output .= '<span class="wvc-recipe-description">';
			$output .= sanitize_text_field( $description );
			$output .= '</span>';
		$output .= '</div>';
	}

	$output .= '<div class="wvc-recipe-body-row">';
	// Ingredients
	$ingredients_array = wvc_texarea_lines_to_array( $ingredients );

	if ( $ingredients && array() !== $ingredients_array ) {

		$output .= '<div class="wvc-recipe-ingredients">';
		
		$output .= '<h4 class="wvc-recipe-ingredients-title">';
		$output .= esc_html__( 'Ingredients', 'wolf-visual-composer' );
		$output .= '</h4>';

		$output .= '<ul>';

		foreach( $ingredients_array as $ingredient ) {
			$output .= '<li>' . sanitize_text_field( $ingredient ) . '</li>';
		}

		$output .= '</ul>';
		$output .= '</div>';
	}

	// Instructions
	$instructions_array = wvc_texarea_lines_to_array( $instructions );

	if ( $instructions && array() !== $instructions_array ) {

		$output .= '<div class="wvc-recipe-instructions">';
		
		$output .= '<h4 class="wvc-recipe-instructions-title">';
		$output .= esc_html__( 'Instructions', 'wolf-visual-composer' );
		$output .= '</h4>';

		$output .= '<ol>';

		foreach( $instructions_array as $instruction ) {
			$output .= '<li>' . sanitize_text_field( $instruction ) . '</li>';
		}

		$output .= '</ol>';
		$output .= '</div>';
	}

	$output .= '</div>'; // row

	// Notes
	if ( $notes ) {
		$output .= '<div class="wvc-recipe-notes">';
		
		$output .= '<h4 class="wvc-recipe-notes-title">';
		$output .= esc_html__( 'Notes', 'wolf-visual-composer' );
		$output .= '</h4>';

		$output .= $notes;

		$output .= '</div>';
	}

	$output .= '</div>'; // body
}


$output .= '</div><!-- .wvc-recipe -->';

echo $output;