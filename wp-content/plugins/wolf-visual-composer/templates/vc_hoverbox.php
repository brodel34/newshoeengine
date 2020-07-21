<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * @var $this \WPBakeryShortCode_VC_Hoverbox
 * @var $atts array
 * @var $content string
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'primary_title' => '',
	'primary_title_font_size' => 72,
	'primary_title_font_family' => '',
	'primary_title_letter_spacing' => 0,
	'primary_title_font_weight' => '',
	'primary_title_line_height' => '',
	'primary_title_text_transform' => '',
	'primary_title_font_style' => '',
	'primary_title_text_align' => 'center',
	'primary_title_color' => '',
	'primary_title_custom_color' => '',
	'primary_title_text' => '',
	'primary_title_tag' => 'h2',
	'primary_title_link' => '',
	'primary_title_css_animation' => '',
	'primary_title_css_animation_delay' => '',
	'primary_title_el_class' => '',
	'primary_title_el_id' => '',
	'primary_title_css' => '',
	'primary_title_inline_style' => '',


	'hover_background_color' => 'default',

	'hover_title' => '',
	'hover_title_font_size' => 72,
	'hover_title_font_family' => '',
	'hover_title_letter_spacing' => 0,
	'hover_title_font_weight' => '',
	'hover_title_line_height' => '',
	'hover_title_text_transform' => '',
	'hover_title_font_style' => '',
	'hover_title_text_align' => 'center',
	'hover_title_color' => '',
	'hover_title_custom_color' => '',
	'hover_title_text' => '',
	'hover_title_tag' => 'h2',
	'hover_title_link' => '',
	'hover_title_css_animation' => '',
	'hover_title_css_animation_delay' => '',
	'hover_title_el_class' => '',
	'hover_title_el_id' => '',
	'hover_title_css' => '',
	'hover_title_inline_style' => '',

	'hover_btn_title' => esc_html__( 'My Button', 'wolf-visual-composer' ),
	'hover_btn_link' => '',
	'hover_btn_color' => '',
	'hover_btn_custom_color' => '',
	'hover_btn_shape' => '',
	'hover_btn_style' => '',
	'hover_btn_size' => '',
	'hover_btn_font_weight' => '',
	'hover_btn_scroll_to_anchor' => '',
	//'hover_btn_align' => '',
	'hover_btn_button_block' => '',
	'hover_btn_hover_effect' => '',
	'hover_btn_add_icon' => '',
	'hover_btn_i_align' => '',
	'hover_btn_i_type' => '',
	'hover_btn_i_hover' => '',

	'el_class' => '',
	'el_id' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

if ( ! empty( $atts['image'] ) ) {
	$image = intval( $atts['image'] );
	$image_data = wp_get_attachment_image_src( $image, 'large' );
	$image_src = $image_data[0];
} else {
	$image_src = vc_asset_url( 'vc/no_image.png' );
}
$image_src = esc_url( $image_src );

$align = 'vc-hoverbox-align--' . esc_attr( $atts['align'] );
$shape = 'vc-hoverbox-shape--' . esc_attr( $atts['shape'] );
$width = 'vc-hoverbox-width--' . esc_attr( $atts['el_width'] );
$reverse = 'vc-hoverbox-direction--default';
if ( ! empty( $atts['reverse'] ) ) {
	$reverse = 'vc-hoverbox-direction--reverse';
}
$id = '';
if ( ! empty( $atts['el_id'] ) ) {
	$id = 'id="' . esc_attr( $atts['el_id'] ) . '"';
}

//$class_to_filter = vc_shortcode_custom_class( $atts['css'], ' ' ) . $this->getExtraClass( $atts['el_class'] ) . $this->getCSSAnimation( $atts['css_animation'] );
//$class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

// Hover Background color
// if ( 'custom' !== $atts['hover_background_color'] ) {
// 	$hover_background_color = vc_convert_vc_color( $atts['hover_background_color'] );
// } else {
// 	$hover_background_color = esc_attr( $atts['hover_custom_background'] );
// }

if ( 'custom' === $atts['hover_background_color'] ) {
	$hover_background_color = esc_attr( $atts['hover_custom_background'] );
}

if ( isset( $atts['hover_background_color'] )
	&& '' !== $atts['hover_background_color']
	&& 'default' !== $atts['hover_background_color']
	&& 'light' !== $atts['hover_background_color']
	&& 'lightgrey' !== $atts['hover_background_color']
) {
	$class .= ' wvc-hover-box-back-has-background';
}

//$primary_title = $this->getHeading( 'primary_title', $atts, $atts['primary_align'] );

$primary_title = wvc_heading(
	array(
		'text' => $primary_title,
		'font_size' => $primary_title_font_size,
		'font_family' => $primary_title_font_family,
		'letter_spacing' => $primary_title_letter_spacing,
		'font_weight' => $primary_title_font_weight,
		'line_height' => $primary_title_line_height,
		'text_transform' => $primary_title_text_transform,
		'font_style' => $primary_title_font_style,
		'text_align' => $primary_title_text_align,
		'color' => $primary_title_color,
		'custom_color' => $primary_title_custom_color,
		'tag' => $primary_title_tag,
		'link' => $primary_title_link,
		'css_animation' => $primary_title_css_animation,
		'css_animation_delay' => $primary_title_css_animation_delay,
		'el_class' => $primary_title_el_class,
		'el_id' => $primary_title_el_id,
	)
);

$hover_title = wvc_heading(
	array(
		'text' => $hover_title,
		'font_size' => $hover_title_font_size,
		'font_family' => $hover_title_font_family,
		'letter_spacing' => $hover_title_letter_spacing,
		'font_weight' => $hover_title_font_weight,
		'line_height' => $hover_title_line_height,
		'text_transform' => $hover_title_text_transform,
		'font_style' => $hover_title_font_style,
		'text_align' => $hover_title_text_align,
		'color' => $hover_title_color,
		'custom_color' => $hover_title_custom_color,
		'tag' => $hover_title_tag,
		'link' => $hover_title_link,
		'css_animation' => $hover_title_css_animation,
		'css_animation_delay' => $hover_title_css_animation_delay,
		'el_class' => $hover_title_el_class,
		'el_id' => $hover_title_el_id,
	)
);

$content = wpb_js_remove_wpautop( $content, true );
// $button = '';
// if ( $atts['hover_add_button'] ) {
// 	$button = $this->renderButton( $atts );
// }

$button_atts = array(
	'title' => $hover_btn_title,
	'link' => $hover_btn_link,
	'color' => $hover_btn_color,
	'custom_color' => $hover_btn_custom_color,
	'shape' => $hover_btn_shape,
	'style' => $hover_btn_style,
	'size' => $hover_btn_size,
	'align' => 'inline',
	'button_block' => $hover_btn_button_block,
	'hover_effect' => $hover_btn_hover_effect,
	'font_weight' => $hover_btn_font_weight,
	'scroll_to_anchor' => $hover_btn_scroll_to_anchor,
	'add_icon' => $hover_btn_add_icon,
	'i_align' => $hover_btn_i_align,
	'i_type' => $hover_btn_i_type,
	'i_hover' => $hover_btn_i_hover,
);

$button_1_icon = ( isset( $atts["hover_btn_i_icon_$hover_btn_i_type"] ) ) ? $atts["hover_btn_i_icon_$hover_btn_i_type"] : '';

$button = wvc_generate_button( array_merge( array( 'icon' => $button_1_icon ), $button_atts ) );

$template = <<<HTML
<div class="vc-hoverbox-wrapper wvc-element $class $shape $align $reverse $width" $id style="$inline_style">
  <div class="vc-hoverbox wvc-hoverbox">
	<div class="vc-hoverbox-inner">
	  <div class="vc-hoverbox-block vc-hoverbox-front" style="background-image: url($image_src);">
		<div class="vc-hoverbox-block-inner vc-hoverbox-front-inner">
			$primary_title
		</div>
	  </div>
	  <div class="vc-hoverbox-block vc-hoverbox-back wvc-background-color-$hover_background_color" style="background-color: $hover_background_color;">
		<div class="vc-hoverbox-block-inner vc-hoverbox-back-inner">
			$hover_title
			$content
			$button
		</div>
	  </div>
	</div>
  </div>
</div>
HTML;

echo $template;