<?php
/**
 * Post index Visual Composer template
 *
 * The arguments are passed to the prequelle_posts hook so we can do whatever we want with it
 *
 * @author WolfThemes
 * @category Core
 * @package %PACKAGENAME%/Templates
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* retrieve shortcode attributes */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

$atts['post_type'] = 'post';

/* hook passing VC arguments */
do_action( 'prequelle_posts', $atts );