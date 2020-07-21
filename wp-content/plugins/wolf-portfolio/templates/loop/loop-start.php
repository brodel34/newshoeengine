<?php
/**
 * Portfolio Loop Start
 *
 * @author WpWolf
 * @package WolfPortfolio/Templates
 * @since 1.1.2
 */
$columns = wolf_portfolio_get_option( 'col', 4 );
?>
<div class="works <?php echo sanitize_html_class( 'works-grid-col-' . $columns ); ?>">