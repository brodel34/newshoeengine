/**
 * TinyMCE plugin
 *
 * Add shortcode dropdown menu to tinyMCE
 */
;( function( $ ) {
	'use strict';

	var fontMenu = [];

	//console.log( fontMenu );

	//Shortcodes
	tinymce.PluginManager.add( 'WVCShortcodesTinyMce', function( editor, url ) {

		editor.addCommand( 'WVCPopup', function ( a, params )
		{
			var popup = params.identifier;
			// console.log( popup );
			tb_show( WVCTinyMceParams.insertText, url + "/popup.php?popup=" + popup + "&width=800" );

		} );

		editor.addButton( 'wvc_shortcodes_tiny_mce_button', {
			type: 'splitbutton',
			image : url + '/icons/icon.png',
			title:  'Shortcodes',
			menu: [
				{ text: WVCTinyMceParams.anchor, onclick:function() {
					editor.execCommand( 'WVCPopup', false, { title: WVCTinyMceParams.anchor, identifier: 'anchor' } )
				} },
				{ text: WVCTinyMceParams.dropcap, onclick:function() {
					editor.execCommand( 'WVCPopup', false, { title: WVCTinyMceParams.dropcap, identifier: 'dropcap' } )
				} },
				// { text: WVCTinyMceParams.button, onclick:function() {
				// 	editor.execCommand( 'WVCPopup', false, { title: WVCTinyMceParams.button, identifier: 'button' } )
				// } },
				// { text: 'Mailchimp', onclick:function() {
				// 	editor.execCommand( 'WVCPopup', false, { title: 'Mailchimp', identifier: 'mailchimp' } )
				// } },
				// { text: WVCTinyMceParams.alert, onclick:function() {
				// 	editor.execCommand( 'WVCPopup', false, { title: WVCTinyMceParams.alert, identifier: 'alert' } )
				// } },
				{ text: WVCTinyMceParams.highlight, onclick:function() {
					editor.execCommand( 'WVCPopup', false, { title: WVCTinyMceParams.highlight, identifier: 'highlight' } )
				} },
				{ text: WVCTinyMceParams.spacer, onclick:function() {
					editor.execCommand( 'WVCPopup', false, { title: WVCTinyMceParams.spacer, identifier: 'spacer' } )
				} }
				// { text: WVCTinyMceParams.fittext, onclick:function() {
				// 	editor.execCommand( 'WVCPopup', false, { title: WVCTinyMceParams.fittext, identifier: 'fittext' } )
				// } },
				// { text: WVCTinyMceParams.socials, onclick:function() {
				// 	editor.execCommand( 'WVCPopup', false, { title: WVCTinyMceParams.socials, identifier: 'socials' } )
				// } }
			]
		} );
	} );

} )( jQuery );