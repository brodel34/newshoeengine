<?php
/**
 * The category filter for portfolio posts
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

// Get template vars
extract( wp_parse_args( $filter_args, array(
	'work_type_include' => '',
	'work_type_exclude' => '',
	'work_category_filter_text_alignment' => 'center',
) ) );

/* Term query args */
$terms_args = array(
	'taxonomy' => 'work_type',
	'hide_empty' => true,
);

/* If work types are defined, add them to the arguments */
if ( $work_type_include ) {

	$work_types_ids = array();
	$work_types_array = prequelle_list_to_array( $work_type_include );

	if ( array() !== $work_types_array ) {
		foreach ( $work_types_array as $slug ) {

			$term = get_term_by( 'slug', $slug, 'work_type' );

			if ( is_object( $term ) ) {
				$work_types_ids[] = $term->term_id;
			}
		}
	}

	$terms_args['include'] = $work_types_ids;
}

/* If exlucded work types are defined, add them to the arguments */
if ( $work_type_exclude ) {

	$work_types_ids = array();
	$work_types_array = prequelle_list_to_array( $work_type_exclude );

	if ( array() !== $work_types_array ) {
		foreach ( $work_types_array as $slug ) {

			$term = get_term_by( 'slug', $slug, 'work_type' );

			if ( is_object( $term ) ) {
				$work_types_ids[] = $term->term_id;
			}
		}
	}

	$terms_args['exclude'] = $work_types_ids;
}

// Get terms
$terms = get_terms( $terms_args );

if ( array() === $terms ) {
	return;
}

$filter_class = 'category-filter category-filter-work';

$filter_class .= " category-filter-text-align-$work_category_filter_text_alignment";

$portfolio_url = ( function_exists( 'wolf_get_portfolio_url' ) && wolf_get_portfolio_url() ) ? wolf_get_portfolio_url() : home_url();

$all_active_class = ( ! is_tax( 'work_type' ) ) ? 'active' : '';
?>
<div class="<?php echo prequelle_sanitize_html_classes( $filter_class ); ?>">
	<ul>
		<li><a class="filter-link <?php echo esc_attr( $all_active_class ); ?>" href="<?php echo esc_url( $portfolio_url ); ?>" data-filter="work"><?php esc_html_e( 'All', 'prequelle' ) ?></a></li>
		<?php foreach ( $terms as $term ) :
			$term_active_class = ( $term->slug === get_query_var( 'work_type' ) ) ? 'active' : '';
		?>
			<li>
				<a class="filter-link <?php echo esc_attr( $term_active_class ); ?>" data-filter="work_type-<?php echo sanitize_title( $term->slug ); ?>" href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo sanitize_text_field( $term->name ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div><!-- .category-filter -->