<?php
/**
 * Prequelle gallery settings
 *
 * @package WordPress
 * @subpackage Prequelle
 * @version 1.0.4
 */

if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'prequelle_add_media_manager_options' ) ) {
	/**
	 * Add settings to gallery media manager using Underscore
	 *
	 * @see http://wordpress.stackexchange.com/questions/90114/enhance-media-manager-for-gallery
	 */
	function prequelle_add_media_manager_options() {
		/* define your backbone template;
		the "tmpl-" prefix is required,
		and your input field should have a data-setting attribute
		matching the shortcode name */
		?>
		<script type="text/html" id="tmpl-custom-gallery-setting">

			<label class="setting">
				<span><?php esc_html_e( 'Layout', 'prequelle' ); ?></span>
				<select data-setting="layout">
					<option value="simple"><?php esc_html_e( 'Simple', 'prequelle' ); ?></option>
					<option value="mosaic"><?php esc_html_e( 'Mosaic', 'prequelle' ); ?></option>
					<option value="slider"><?php esc_html_e( 'Slider (settings below won\'t be applied)', 'prequelle' ); ?></option>
				</select>
			</label>
			<label class="setting">
				<span><?php esc_html_e( 'Custom size', 'prequelle' ); ?></span>
				<select data-setting="size">
					<option value="prequelle-thumb"><?php esc_html_e( 'Standard', 'prequelle' ); ?></option>
					<option value="prequelle-2x2"><?php esc_html_e( 'Square', 'prequelle' ); ?></option>
					<option value="prequelle-portrait"><?php esc_html_e( 'Portrait', 'prequelle' ); ?></option>
					<option value="thumbnail"><?php esc_html_e( 'Thumbnail', 'prequelle' ); ?></option>
					<option value="medium"><?php esc_html_e( 'Medium', 'prequelle' ); ?></option>
					<option value="large"><?php esc_html_e( 'Large', 'prequelle' ); ?></option>
					<option value="full"><?php esc_html_e( 'Full', 'prequelle' ); ?></option>
				</select>
			</label>
			<label class="setting">
				<span><?php esc_html_e( 'Padding', 'prequelle' ); ?></span>
				<select data-setting="padding">
					<option value="yes"><?php esc_html_e( 'Yes', 'prequelle' ); ?></option>
					<option value="no"><?php esc_html_e( 'No', 'prequelle' ); ?></option>
				</select>
			</label>
			<label class="setting">
				<span><?php esc_html_e( 'Hover effect', 'prequelle' ); ?></span>
				<select data-setting="hover_effect">
					<option value="default"><?php esc_html_e( 'Default', 'prequelle' ); ?></option>
					<option value="scale-to-greyscale"><?php esc_html_e( 'Scale + Colored to Black and white', 'prequelle' ); ?></option>
					<option value="greyscale"><?php esc_html_e( 'Black and white to colored', 'prequelle' ); ?></option>
					<option value="to-greyscale"><?php esc_html_e( 'Colored to Black and white', 'prequelle' ); ?></option>
					<option value="scale-greyscale"><?php esc_html_e( 'Scale + Black and white to colored', 'prequelle' ); ?></option>
					<option value="none"><?php esc_html_e( 'None', 'prequelle' ); ?></option>
				</select>
				<small><?php esc_html_e( 'Note that not all browser support the black and white effect', 'prequelle' ); ?></small>
			</label>
		</script>

		<script>
		jQuery( document ).ready( function() {
			/* add your shortcode attribute and its default value to the
			gallery settings list; $.extend should work as well... */
			_.extend( wp.media.gallery.defaults, {
				size : 'standard',
				padding : 'no',
				hover_effet : 'default'
			} );

			/* merge default gallery settings template with yours */
			wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend( {
				template: function( view ) {
					return wp.media.template( 'gallery-settings' )( view )
					+ wp.media.template( 'custom-gallery-setting' )( view );
				}
			} );
		} );
		</script>
		<?php

	}
	add_action( 'print_media_templates', 'prequelle_add_media_manager_options' );
}