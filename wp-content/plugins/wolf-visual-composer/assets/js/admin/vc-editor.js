/*
Custom Content Block Backend view
*/
/* global vc */
;( function( $ ) {

	//var Shortcodes = vc.shortcodes;

	window.WvcContentBlockView = vc.shortcode_view.extend( {
		changeShortcodeParams: function ( model ) {
			window.WvcContentBlockView.__super__.changeShortcodeParams.call( this, model );
			var wrap = this.$el.closest( '.wpb_element_wrapper' ),
				container = this.$el.find( '.wpb_element_wrapper' ),
				row = this.$el.closest( '.wpb_vc_row' );
			if ( this.model.getParam( 'inside_column' ) !== 'yes' ) {
				wrap.css( 'padding','0' );
				container.css( 'backgroundColor','#e6e6e6' );
				row.find( '.vc_column-add' ).remove();
				row.find( '.vc_row_layouts' ).remove();
				row.find( '.vc_column-edit' ).remove();
				row.find( '.vc_control-column' ).remove();
				row.find( '.vc_control-btn-clone' ).remove();
				row.find( '.vc_control-btn-delete' ).remove();
				row.find( '.vc_column-toggle' ).remove();
				row.find( '.vc_column-toggle' ).remove();
				row.find( '.vc_column-clone' ).remove();
				row.find( '.vc_control-btn .vc-c-icon-dragndrop' ).remove();
				row.find( '.vc_btn-content' ).removeAttr( 'title' );
				// disable sortable for content block
				row.find( '.wpb_wvc_content_block' ).sortable( { disabled: false } );

			} else {
				wrap.removeAttr( 'style' );
				container.removeAttr( 'style' );
				row.find( '.vc_row_layouts' ).show();
				row.find( '.vc_column-edit' ).show();
				row.find( '.vc_control-column' ).show();
			}
		}
	} );

	$( document ).ready( function() {} );

} )( window.jQuery );