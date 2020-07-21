<?php
/**
 * Template part for displaying social share buttons
 *
 * @package WordPress
 * @subpackage Wolf Share
 * @version 1.0.7
 */
$services = wolf_share_get_option( 'services' );
?>
<div class="wolf-share-buttons-container" data-post-id="<?php the_ID(); ?>">

	<span class="wolf-share-button wolf-share-button-count" title="<?php printf( esc_html__( 'Shared %s times', 'wolf-share' ), wolf_share_count( false ) ); ?>">
		<span class="wolf-share-count-number">
			<?php wolf_share_count(); ?>
		</span>
	</span><!-- .wolf-share-count -->

	<?php if ( isset( $services['facebook'] ) ) : ?>
		<span class="wolf-share-button wolf-share-button-facebook">
			<a
				data-popup="true"
				data-width="580"
				data-height="320"
				href="http://www.facebook.com/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>&amp;t=<?php echo urlencode( get_the_title() ); ?>"
				class="socicon-facebook wolf-share-link no-link-style wolf-share-link-facebook" title="<?php printf( esc_html__( 'Share on %s', 'wolf-share' ), ucfirst( 'facebook' ) ); ?>">
				<span class="wolf-share-link-text">
					<?php esc_html_e( 'Facebook', 'wolf-share' ); ?>
				</span>
			</a>
		</span><!-- .wolf-share-facebook -->
	<?php endif; ?>

	<?php if ( isset( $services['twitter'] ) ) : ?>
		<span class="wolf-share-button wolf-share-button-twitter">
			<a
				data-popup="true"
				href="http://twitter.com/home?status=<?php echo urlencode( get_the_title() ) . ' - ' . urlencode( get_permalink() ); ?>"
				class="socicon-twitter wolf-share-link no-link-style wolf-share-link-twitter"
				title="<?php printf( esc_html__( 'Share on %s', 'wolf-share' ), ucfirst( 'twitter' ) ); ?>">
				<span class="wolf-share-link-text">
					<?php esc_html_e( 'Twitter', 'wolf-share' ); ?>
				</span>
			</a>
		</span><!-- .wolf-share-twitter -->
	<?php endif; ?>

	<?php if ( isset( $services['reddit'] ) ) : ?>
		<span class="wolf-share-button wolf-share-button-reddit">
			<a
				data-popup="true"
				href="//www.reddit.com/submit?url=<?php echo urlencode( get_permalink() ); ?>"
				class="socicon-reddit wolf-share-link no-link-style wolf-share-link-reddit"
				title="<?php printf( esc_html__( 'Share on %s', 'wolf-share' ), ucfirst( 'reddit' ) ); ?>">
				<span class="wolf-share-link-text">
					<?php esc_html_e( 'Twitter', 'wolf-share' ); ?>
				</span>
			</a>
		</span><!-- .wolf-share-twitter -->
	<?php endif; ?>

	<?php if ( isset( $services['pinterest'] ) ) : ?>
		<span class="wolf-share-button wolf-share-button-pinterest">
			<a
				data-popup="true"
				data-width="580"
				data-height="300"
				href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode( get_permalink() ); ?>&amp;media=<?php echo get_the_post_thumbnail_url( get_the_ID(), 'large' ); ?>&amp;description=<?php echo urlencode( get_the_title() ); ?>"
				class="socicon-pinterest wolf-share-link no-link-style wolf-share-link-pinterest"
				title="<?php printf( esc_html__( 'Share on %s', 'wolf-share' ), ucfirst( 'pinterest' ) ); ?>">
				<span class="wolf-share-link-text">
					<?php esc_html_e( 'Pinterest', 'wolf-share' ); ?>
				</span>
			</a>
		</span><!-- .wolf-share-pinterest -->
	<?php endif; ?>

	<?php if ( isset( $services['tumblr'] ) ) : ?>
		<span class="wolf-share-button wolf-share-button-tumblr">
			<a
				data-popup="true"
				href="http://tumblr.com/share/link?url=<?php echo urlencode( get_permalink() ); ?>&amp;name=<?php echo urlencode( get_the_title() ); ?>"
				class="socicon-tumblr wolf-share-link no-link-style wolf-share-link-tumblr"
				title="<?php printf( esc_html__( 'Share on %s', 'wolf-share' ), ucfirst( 'tumblr' ) ); ?>">
				<span class="wolf-share-link-text">
					<?php esc_html_e( 'Tumblr', 'wolf-share' ); ?>
				</span>
			</a>
		</span><!-- .wolf-share-tumblr -->
	<?php endif; ?>

	<?php if ( isset( $services['google'] ) ) : ?>
		<span class="wolf-share-button wolf-share-button-google">
			<a
				data-popup="true"
				data-height="500"
				href="https://plus.google.com/share?url=<?php echo urlencode( get_permalink() ); ?>"
				class="socicon-google wolf-share-link no-link-style wolf-share-link-google"
				title="<?php printf( esc_html__( 'Share on %s', 'wolf-share' ), ucfirst( 'google plus' ) ); ?>">
				<span class="wolf-share-link-text">
					<?php esc_html_e( 'Google Plus', 'wolf-share' ); ?>
				</span>
			</a>
		</span><!-- .wolf-share-google -->
	<?php endif; ?>

	<?php if ( isset( $services['linkedin'] ) ) : ?>
		<span class="wolf-share-button wolf-share-button-linkedin">
			<a
				data-popup="true"
				data-height="380" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode( get_permalink() ); ?>&amp;title=<?php echo urlencode( get_the_title() ); ?>"
				class="socicon-linkedin wolf-share-link no-link-style wolf-share-link-linkedin"
				title="<?php printf( esc_html__( 'Share on %s', 'wolf-share' ), ucfirst( 'linkedin' ) ); ?>">
				<span class="wolf-share-link-text">
					<?php esc_html_e( 'LinkedIn', 'wolf-share' ); ?>
				</span>
			</a>
		</span><!-- .wolf-share-linkedin -->
	<?php endif; ?>

	<?php if ( isset( $services['stumbleupon'] ) ) : ?>
		<span class="wolf-share-button wolf-share-button-stumbleupon">
			<a
				data-popup="true"
				data-width="800"
				data-height="600"
				href="http://www.stumbleupon.com/submit?url=<?php echo urlencode( get_permalink() ); ?>&amp;title=<?php echo urlencode( get_the_title() ); ?>"
				class="socicon-stumbleupon wolf-share-link no-link-style wolf-share-link-stumbleupon"
				title="<?php printf( esc_html__( 'Share on %s', 'wolf-share' ), ucfirst( 'stumbleupon' ) ); ?>">
				<span class="wolf-share-link-text">
					<?php esc_html_e( 'StumbleUpon', 'wolf-share' ); ?>
				</span>
			</a>
		</span><!-- .wolf-share-stumbleupon -->
	<?php endif; ?>

	<?php if ( isset( $services['vk'] ) ) : ?>
		<span class="wolf-share-button wolf-share-button-vk">
			<a
				data-popup="true"
				data-width="800"
				data-height="600"
				href="http://vk.com/share.php?url=<?php echo urlencode( get_permalink() ); ?>"
				class="socicon-vkontakte wolf-share-link no-link-style wolf-share-link-vk"
				title="<?php printf( esc_html__( 'Share on %s', 'wolf-share' ), ucfirst( 'VKontakte' ) ); ?>">
				<span class="wolf-share-link-text">
					<?php esc_html_e( 'VKontakte', 'wolf-share' ); ?>
				</span>
			</a>
		</span><!-- .wolf-share-vk -->
	<?php endif; ?>

	<?php if ( isset( $services['xing'] ) ) : ?>
		<span class="wolf-share-button wolf-share-button-xing">
			<a
				data-popup="true"
				data-width="800"
				data-height="600"
				href="https://www.xing.com/app/user?op=share&url=<?php echo urlencode( get_permalink() ); ?>"
				class="socicon-xing wolf-share-link no-link-style wolf-share-link-vk"
				title="<?php printf( esc_html__( 'Share on %s', 'wolf-share' ), ucfirst( 'Xing' ) ); ?>">
				<span class="wolf-share-link-text">
					<?php esc_html_e( 'Xing', 'wolf-share' ); ?>
				</span>
			</a>
		</span><!-- .wolf-share-xing -->
	<?php endif; ?>

	<?php if ( isset( $services['email'] ) ) : ?>
		<span class="wolf-share-button wolf-share-button-email">
			<a
				data-popup="true"
				href="mailto:?subject=<?php echo urlencode( get_the_title() ); ?>&amp;body=<?php echo urlencode( get_permalink() ); ?>"
				class="socicon-mail wolf-share-link no-link-style wolf-share-link-email"
				title="<?php printf( esc_html__( 'Share by %s', 'wolf-share' ), ucfirst( 'email' ) ); ?>">
				<!-- <span class="wolf-share-link-text"> -->
					<?php //esc_html_e( 'Email', 'wolf-share' ); ?>
				<!-- </span> -->
			</a>
		</span><!-- .wolf-share-email -->
	<?php endif; ?>
</div><!-- .wolf-share-buttons-container -->



<?php

$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div id="wc-tabs-container" class="woocommerce-tabs wc-tabs-wrapper">
		<div class="tabs-container">
			<ul class="tabs wc-tabs" role="tablist">
				<?php foreach ( $tabs as $key => $tab ) : ?>
					<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
						<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div><!-- .tabs-container -->
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
				<?php call_user_func( $tab['callback'], $key, $tab ); ?>
			</div>
		<?php endforeach; ?>
	</div>

<?php endif; ?>