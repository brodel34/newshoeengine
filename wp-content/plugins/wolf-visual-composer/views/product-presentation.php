<div class="single-product">
	<article id="product-<?php the_ID(); ?>" <?php post_class( apply_filters( 'wvc_product_presentation', 'entry-single entry-single-product entry-product-presentation clearfix' ) ); ?>>
		
		<?php do_action( 'wvc_product_image' ); ?>

		<div class="summary entry-summary">
			<div class="summary-content">
				<?php do_action( 'wvc_product_summary' ); ?>
			</div>
		</div>
	</article>
</div>