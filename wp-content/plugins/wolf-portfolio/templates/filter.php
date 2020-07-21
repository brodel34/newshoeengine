<?php
/**
 * The Portfolio category filter
 *
 * @author WpWolf
 * @package WolfPortfolio/Templates
 * @since 1.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$tax_args = array(
	'taxonomy'     => 'work_type',
	'orderby'      => 'slug',
	'show_count'   => 0,
	'pad_counts'   => 0,
	'hierarchical' => 0,
	'title_li'     => '',
);

$tax = get_categories( $tax_args );
$active_class = ( is_page( wolf_portfolio_get_page_id() ) ) ? ' class="active"' : '';
$current_tax_slug = get_query_var( 'work_type' );

if ( $tax != array() ) :
?>
<div id="work-filter-container">
	<ul id="work-filter">
		<li><a data-filter="work"<?php echo $active_class; ?> href="<?php echo esc_url( wolf_get_portfolio_url() ); ?>"><?php _e( 'All', 'wolf' ); ?></a></li>
	<?php foreach ( $tax as $t ) : ?>
		<?php if ( 0 != $t->count ) : ?>
			<li>
				<a<?php if ( $current_tax_slug == $t->slug ) echo ' class="active"';  ?> data-filter="<?php echo sanitize_title( $t->slug ); ?>" href="<?php echo esc_url( get_term_link( $t ) ); ?>"><?php echo sanitize_text_field( $t->name ); ?></a>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>