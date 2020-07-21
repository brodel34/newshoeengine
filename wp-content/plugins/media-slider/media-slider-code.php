<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//js & css
wp_enqueue_script('imagesloaded');
wp_enqueue_script('awl-ms-jquery-sliderPro-min-js',  MS_PLUGIN_URL .'js/jquery.sliderPro.min.js');
wp_enqueue_style('awl-ms-slider-pro-min-css', MS_PLUGIN_URL .'css/awl-ms-slider-pro.min.css');
// custom 
wp_enqueue_style('awl-ms-bootstrap-css', MS_PLUGIN_URL .'css/bootstrap.css');

//Id
$media_slider_id = $post_id['id'];
 
$all_sliders = array(  'p' => $media_slider_id, 'post_type' => 'media_slider', 'orderby' => 'ASC');
$loop = new WP_Query( $all_sliders );

if ( $loop->have_posts() ) {
	while ( $loop->have_posts() ) : $loop->the_post();

	$post_id = get_the_ID();
	$slider_settings = unserialize(base64_decode(get_post_meta( $post_id, 'awl_ms_settings_'.$post_id, true)));
	
	//Slide
	$width = $slider_settings['width'];
	$height = $slider_settings['height'];
	$slide_autoheight = $slider_settings['slide_autoheight'];
	$slide_imagescalemode = $slider_settings['slide_imagescalemode'];
	$slide_imagecenter = $slider_settings['slide_imagecenter'];
	$slide_scaleup = $slider_settings['slide_scaleup'];
	$slide_autoslidesize = $slider_settings['slide_autoslidesize'];
	$shuffle_slide = $slider_settings['shuffle_slide'];
	$slide_caption = $slider_settings['slide_caption'];
	$slide_loop = $slider_settings['slide_loop'];
	$slide_visiblesize = $slider_settings['slide_visiblesize'];
	//Autoplay
	$slide_autoplay = $slider_settings['slide_autoplay'];
	$slide_autoplay_delay = $slider_settings['slide_autoplay_delay'];
	$slide_autoplay_hover = $slider_settings['slide_autoplay_hover'];
	//Arrows
	$slide_arrows = $slider_settings['slide_arrows'];
	//FullScreen Button	
	$slide_fullscreen_btn = $slider_settings['slide_fullscreen_btn'];
	//Layers
	$slide_waitforlayers = $slider_settings['slide_waitforlayers'];
	$slide_autoscalelayers = $slider_settings['slide_autoscalelayers'];
	//Thumbnails
	$slide_thumb = $slider_settings['slide_thumb'];
	$slide_thumb_width = $slider_settings['slide_thumb_width'];
	$slide_thumb_height = $slider_settings['slide_thumb_height'];
	$slide_thumb_pos = $slider_settings['slide_thumb_pos'];
	$slide_thumb_arrows = $slider_settings['slide_thumb_arrows'];
	$slide_thumb_touchswipe = $slider_settings['slide_thumb_touchswipe'];
	//Video
	$videoaction_play = $slider_settings['videoaction_play'];
	$videoaction_pause = $slider_settings['videoaction_pause'];
	//Text Area
	$slide_text = $slider_settings['slide_text'];
	$slide_text_pos = $slider_settings['slide_text_pos'];
	$custom_css = $slider_settings['custom_css'];
	
	// start the Media Slider contents
	?>
	<div id="image_gallery_<?php echo $media_slider_id; ?>" class="row all-images">
		<div class="slider-pro" id="my-slider-<?php echo $media_slider_id; ?>">
			<div class="sp-slides">
			<?php
				if(isset($slider_settings['media-slide-ids']) && count($slider_settings['media-slide-ids']) > 0) {
					$count = 0;
					foreach($slider_settings['media-slide-ids'] as $attachment_id) {
						$thumb = wp_get_attachment_image_src($attachment_id, 'thumb', true);
						$thumbnail = wp_get_attachment_image_src($attachment_id, 'thumbnail', true);
						$medium = wp_get_attachment_image_src($attachment_id, 'medium', true);
						$large = wp_get_attachment_image_src($attachment_id, 'large', true);
						$full = wp_get_attachment_image_src($attachment_id, 'full', true);
						$attachment_details = get_post( $attachment_id );
							$title = $attachment_details->post_title;
							$description = $attachment_details->post_content;
						$slide_type =  $slider_settings['media-slide-type'][$count];
						$slide_link =  $slider_settings['media-slide-link'][$count];
						
						if($slide_text_pos == "topleft" || $slide_text_pos == "top" || $slide_text_pos == "topright" ||
							$slide_text_pos == "bottomleft" || $slide_text_pos == "bottom" || $slide_text_pos == "bottomright") {
							$dv1 = 35;
							$dh1 = 10;
						}
						if($slide_text_pos == "left" || $slide_text_pos == "center" || $slide_text_pos == "right") {
							$dv1 = 0;
							$dh1 = 60;
						}
						if($slide_text_pos == "topright" || $slide_text_pos == "right" || $slide_text_pos == "bottomright") {
							$align = "right";
						}
						if($slide_text_pos == "top" || $slide_text_pos == "center" || $slide_text_pos == "bottom") {
							$align = "center";
						} ?>
						<div class="sp-slide">
							<?php if($slide_type == "i") { ?>
									<img class="sp-image" src="<?php echo MS_PLUGIN_URL ?>/css/images/blank.gif"
										data-src="<?php echo $full[0]; ?>"
										data-small="<?php echo $thumb[0]; ?>"
										data-medium="<?php echo $full[0]; ?>"
										data-large="<?php echo $large[0]; ?>"
										data-retina="<?php echo $full[0]; ?>"
										/>
									
									<?php if($slide_text == "true") {?>
									<p class="sp-layer sp-white sp-padding" align="<?php echo $align; ?>"
										data-position="<?php echo $slide_text_pos; ?>" data-vertical="<?php echo $dv1; ?>" data-horizontal="<?php echo $dh1; ?>" 
										data-show-delay="500">
										<?php if($title != NULL) { ?><span class="title-css"><?php echo $title; ?></span><br><?php } ?>
										<?php if($description != NULL) { ?><span class="desc-css"><?php echo $description;  ?></span><br><?php } ?>
									</p>
									<?php } ?>
									
									<?php if($slide_caption == "true") { ?><p class="sp-caption"><span class="caption-css"><?php echo $title; ?></span></p> <?php } ?>
							<?php } ?>
							<?php if($slide_type == "v") { ?>
									<a class="sp-video" href="<?php echo $slide_link; ?>" >
										<img class="sp-image" src="<?php echo $full[0]; ?>">
									</a>
									<?php if($slide_caption == "true") { ?><p class="sp-caption"><span class="caption-css"><?php echo $title; ?></span></p> <?php } ?>
							<?php } ?>
						</div>
						<?php
						$count++;
					}// end of attachment foreach
				} else {
					_e('Sorry! No media slider found', MSP_TXTDM);
					echo ": [MD-SL id=$post_id]";
				} // end of if else of slides avaialble check into slider
				?>
			</div>	
			<?php if($slide_thumb == "true") {?>
			<div class="sp-thumbnails">
				<?php
				if(isset($slider_settings['media-slide-ids']) && count($slider_settings['media-slide-ids']) > 0) {
					$count = 0;
					foreach($slider_settings['media-slide-ids'] as $attachment_id) {
						$thumb = wp_get_attachment_image_src($attachment_id, 'thumb', true);
						$thumbnail = wp_get_attachment_image_src($attachment_id, 'thumbnail', true);
						$medium = wp_get_attachment_image_src($attachment_id, 'medium', true);
						$large = wp_get_attachment_image_src($attachment_id, 'large', true);
						$full = wp_get_attachment_image_src($attachment_id, 'full', true);
						?><img class="sp-thumbnail" src="<?php echo $full[0]; ?>"/><?php
						$count++;
					}// end of attachment foreach
				} else {
					_e('Sorry! No media slider found', MSP_TXTDM);
					echo ": [MD-SL id=$post_id]";
				} // end of if else of slides avaialble check into slider
				?>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php
	endwhile;
} //end if
wp_reset_query();
?>
<style>
.title-css {
	font-size : 18px;
	font-weight: bolder;
	text-transform: uppercase;
}
.desc-css {
	font-size : 16px;
}
.caption-css {
	font-size : 16px;
	font-weight: bolder;
	text-transform: uppercase;
}
a.sp-video:after {
    box-sizing: unset;
}
<?php echo $custom_css; ?>
</style>
<script type="application/javascript">
jQuery( document ).ready(function( jQuery ) {
	jQuery( "#my-slider-<?php echo $media_slider_id; ?>").sliderPro({
		width : <?php echo $width; ?>,
		height : <?php echo $height; ?>,   
		//Slide
		centerImage : <?php echo $slide_imagecenter; ?>,
		allowScaleUp : <?php echo $slide_scaleup; ?>,
		autoSlideSize : <?php echo $slide_autoslidesize; ?>,
		autoHeight: <?php echo $slide_autoheight; ?>,
		shuffle : <?php echo $shuffle_slide ?>,
		loop : <?php echo $slide_loop; ?>,
		visibleSize : '<?php echo $slide_visiblesize; ?>',
		waitForLayers : <?php echo $slide_waitforlayers; ?>,
		autoScaleLayers : <?php echo $slide_autoscalelayers; ?>,
		//Auto
		autoplay : <?php echo $slide_autoplay; ?>,
		autoplayDelay : <?php echo $slide_autoplay_delay; ?>,
		autoplayOnHover : '<?php echo $slide_autoplay_hover; ?>',
		//Navigation
		arrows: <?php echo $slide_arrows; ?>,
		fadeArrows: false,
		buttons: false,
		keyboard : false,
		fullScreen : <?php echo $slide_fullscreen_btn; ?>,
		fadeFullScreen : false,
		//Video
		playVideoAction : '<?php echo $videoaction_play; ?>',
		pauseVideoAction : '<?php echo $videoaction_pause; ?>',
		//Thumbnails
		thumbnailWidth : <?php echo $slide_thumb_width; ?>,
		thumbnailHeight : <?php echo $slide_thumb_height; ?>,
		thumbnailsPosition : '<?php echo $slide_thumb_pos; ?>',
		thumbnailArrows : <?php echo $slide_thumb_arrows; ?>,
		fadeThumbnailArrows : false,
		thumbnailTouchSwipe : <?php echo $slide_thumb_touchswipe; ?>
	});
});
</script>