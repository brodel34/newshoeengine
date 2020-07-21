<?php
/**
 * Post big slide content
 *
 * This template is used inside the big posts slider shortcode
 *
 * @see templates/wvc_posts_slider.php
 */
extract( wp_parse_args( get_query_var( 'wvc_post_slider_args' ), array(
	'responsive' => '',
	'font_family' => '',
	'font_weight' => '',
	'font_size' => '',
	'text_transform' => '',
	'letter_spacing' => '',
) ) );

$title_inline_style = '';
$title_class = 'wvc-post-big-slide-entry-title wvc-entry-title';

if ( $font_size && $responsive ) {
		
	$title_class .= ' wvc-fittext';

} elseif ( $font_size && ! $responsive ) {
	
	$title_inline_style .= 'font-size:' . absint( $font_size ) . 'px;';
}

if ( $font_family && 'default' !== $font_family ) {
	$title_inline_style .= 'font-family:' . esc_attr( $font_family ) . ';';
}

if ( $font_weight ) {
	$title_inline_style .= 'font-weight:' . absint( $font_weight ) . ';';
}

if ( $letter_spacing ) {
	$title_inline_style .= 'letter-spacing:' . intval( $letter_spacing ) . 'px;';
}
?>
<li class="slide wvc-post-big-slide">

	<?php

		do_action( 'wvc_post_big_slide_start' );

		/**
		 * Video background
		 */
		if ( 'video' === get_post_format() && wvc_get_first_video_url() || 'video' === get_post_type() ) {

			$video_bg_url = wvc_get_first_video_url();

			if ( get_post_meta( get_the_ID(), '_wvc_video_post_preview',  true ) ) {
				$video_bg_url = get_post_meta( get_the_ID(), '_wvc_video_post_preview',  true );
			}

			$video_bg_args = array(
				'video_bg_url' => $video_bg_url,
				'video_bg_img' => get_post_thumbnail_id(),
			);

			echo wvc_background_video( $video_bg_args );

		} else {

			echo wvc_background_img( array(
				'background_img' => get_post_thumbnail_id(),
				'background_color' => '#333'
			) );
		}
	?>
	<div class="wvc-last-posts-big-slide-caption-container">
		<div class="wvc-last-posts-big-slide-caption">
			<div class="wvc-last-posts-big-slide-caption-wrapper">
				<div class="wvc-last-posts-big-slide-caption-inner <?php echo apply_filters( 'wvc_last_posts_big_slider_caption_container_additional_class', '' ); ?>">
					
					<?php if ( 'product' === get_post_type() ) : ?>
						<h2 data-max-font-size="<?php echo absint( $font_size ); ?>" style="<?php echo wvc_esc_style_attr( $title_inline_style ); ?>" class="<?php echo wvc_sanitize_html_classes( $title_class ); ?>">
							<a class="wvc-post-slide-entry-link" href="<?php the_permalink(); ?>" rel="bookmark">
								<?php the_title(); ?>
							</a>
						</h2>
						<p class="wvc-last-posts-big-slide-summary">
							<?php echo apply_filters( 'wvc_last_posts_big_slide_summary', wvc_sample( get_the_excerpt(), 14 ) ); ?>
						</p>
						<div class="wvc-last-post-big-slide-button-container">
							<a class="<?php echo esc_attr( apply_filters( 'wvc_last_posts_big_slide_button_class', 'wvc-last-post-big-slide-button' ) ); ?>" href="<?php the_permalink(); ?>">
								<?php echo apply_filters( 'wvc_last_posts_big_slide_button_text', esc_html__( 'View product', 'wolf-visual-composer' ) ); ?>
							</a>
						</div><!-- .wvc-last-post-big-slide-button-container -->

					<?php elseif ( 'video' === get_post_type() && wvc_get_first_video_url() ) : ?>
						
						<div class="wvc-last-post-big-slide-video-opener">
							<a href="<?php echo 	esc_url( wvc_get_first_video_url() ); ?>" class="wvc-video-opener"><span class="video-opener"></span></a>
						</div><!-- .wvc-last-post-big-slide-button-container -->

					<?php else : ?>
						<?php if ( 'post' === get_post_type() ) : ?>
							<span class="wvc-last-posts-big-slide-entry-date">
								<?php echo ( function_exists( 'wvc_entry_date' ) ) ? apply_filters( 'wvc_last_posts_big_slide_date', wvc_entry_date( false ) ) : '';?>
							</span>
						<?php endif; ?>
						
						<h2 data-max-font-size="<?php echo absint( $font_size ); ?>" style="<?php echo wvc_esc_style_attr( $title_inline_style ); ?>" class="<?php echo wvc_sanitize_html_classes( $title_class ); ?>">
							<a class="wvc-post-slide-entry-link" href="<?php the_permalink(); ?>" rel="bookmark">
								<?php the_title(); ?>
							</a>
						</h2>
						<p class="wvc-last-posts-big-slide-summary">
							<?php echo apply_filters( 'wvc_last_posts_big_slide_summary', wvc_sample( get_the_excerpt(), 14 ) ); ?>
						</p>
						<div class="wvc-last-post-big-slide-button-container">
							<a class="<?php echo esc_attr( apply_filters( 'wvc_last_posts_big_slide_button_class', 'wvc-last-post-big-slide-button' ) ); ?>" href="<?php the_permalink(); ?>">
								<?php echo apply_filters( 'wvc_last_posts_big_slide_button_text', esc_html__( 'View post', 'wolf-visual-composer' ) ); ?>
							</a>
						</div><!-- .wvc-last-post-big-slide-button-container -->
					<?php endif; ?>
				</div><!-- .wvc-last-posts-big-slide-caption-inner -->
			</div><!-- .wvc-last-posts-big-slide-caption-wrapper -->
		</div><!-- .wvc-last-posts-big-slide-caption -->
	</div><!-- .wvc-last-posts-big-slide-caption-container -->
</li>