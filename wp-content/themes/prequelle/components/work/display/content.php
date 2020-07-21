<?php
/**
 * Template part for displaying work posts common layout
 *
 * As all work posts share the same markup, we use this common template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */
extract( wp_parse_args( $template_args, array(
	'layout' => '',
	'overlay_color' => 'auto',
	'overlay_custom_color' => '',
	'overlay_opacity' => 88,
	'overlay_text_color' => '',
	'overlay_text_custom_color' => '',
) ) );
$text_style = '';

if ( function_exists( 'wvc_convert_color_class_to_hex_value' ) && $overlay_text_color && 'overlay' === $layout ) {
	$text_color = wvc_convert_color_class_to_hex_value( $overlay_text_color, $overlay_text_custom_color );
	if ( $text_color ) {
		$text_style .= 'color:' . prequelle_sanitize_color( $text_color ) . ';';
	}
}

$dominant_color = prequelle_get_image_dominant_color( get_post_thumbnail_id() );
$actual_overlay_color = '';

if ( 'auto' === $overlay_color ) {

	$actual_overlay_color = $dominant_color;

} elseif ( function_exists( 'wvc_convert_color_class_to_hex_value' ) ) {
	$actual_overlay_color = wvc_convert_color_class_to_hex_value( $overlay_color, $overlay_custom_color );
}

$overlay_tone_class = 'overlay-tone-' . prequelle_get_color_tone( $actual_overlay_color );
?>
<figure <?php prequelle_post_attr( array( $overlay_tone_class ) ); ?>>
	<div class="entry-box">
		<div class="entry-container">
			<a class="entry-link" href="<?php the_permalink(); ?>">
				<div class="entry-image">
					<div class="entry-cover">
						<?php
							$size = ( prequelle_is_gif( get_post_thumbnail_id() ) ) ? 'full' : 'large';
							echo prequelle_background_img( array( 'background_img_size' => $size, ) );
						?>
					</div><!-- entry-cover -->
				</div>
			</a>
			<div class="entry-inner">
				<a class="entry-link entry-link-mask" href="<?php the_permalink(); ?>"></a>
				<div class="entry-inner-padding">
					<?php
						if ( $dominant_color && 'auto' === $overlay_color ) {
							$overlay_custom_color = $dominant_color;
						}

						/**
						 * Overlay
						 */
						echo prequelle_background_overlay( array(
							'overlay_color' => $overlay_color,
							'overlay_custom_color' => $overlay_custom_color,
							'overlay_opacity' => $overlay_opacity, )
						);
					?>
					<div style="<?php echo prequelle_esc_style_attr( $text_style ); ?>" class="entry-summary">
						<h3 class="entry-title"><a href="<?php the_permalink(); ?>" style="<?php echo prequelle_esc_style_attr( $text_style ); ?>"><?php the_title(); ?></a></h3>
						<div class="entry-taxonomy">
							<?php echo get_the_term_list( get_the_ID(), 'work_type', '', ' <span class="work-taxonomy-separator">/</span> ', '' ); ?>
						</div><!-- .entry-taxonomy -->
					</div><!--  .entry-summary -->
				</div><!-- .entry-inner-padding -->
			</div><!--  .entry-inner -->
		</div>
	</div><!-- .entry-container -->
</figure><!-- #post-## -->