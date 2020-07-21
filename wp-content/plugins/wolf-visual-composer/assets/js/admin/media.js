/**
 *  Upload image
 */
 /* global WVCAdminParams */
;( function( $ ) {

	$( document ).on( 'click', '.wvc-set-img, .wvc-set-bg', function( e ) {
		e.preventDefault();
		var $el = $( this ).parent(),
			selection, attachment,
			uploader = wp.media({
				title : WVCAdminParams.chooseImage,
				library : { type : 'image'},
				multiple : false
			} )
			.on( 'select', function(){
				selection = uploader.state().get( 'selection' );
				attachment = selection.first().toJSON();
				$( 'input', $el ).val( attachment.id );
				$( 'img', $el ).attr( 'src', attachment.url ).show();
			} )
		.open();
	} );

	$( document ).on( 'click', '.wvc-set-file', function(e){
		e.preventDefault();
		var $el = $( this ).parent();
		var uploader = wp.media({
			title : WVCAdminParams.chooseFile,
			multiple : false
		} )
		.on( 'select', function(){
			var selection = uploader.state().get( 'selection' );
			var attachment = selection.first().toJSON();
			$( 'input', $el ).val( attachment.url );
			$( 'span', $el ).html( attachment.url ).show();
		} )
		.open();
	} );

	$( document ).on( 'click', '.wvc-set-video-file', function(e){
		e.preventDefault();
		var $el = $( this ).parent();
		var uploader = wp.media({
			title : WVCAdminParams.chooseFile,
			library : { type : 'video'},
			multiple : false

		} )
		.on( 'select', function(){
			var selection = uploader.state().get( 'selection' );
			var attachment = selection.first().toJSON();
			$( 'input', $el ).val(attachment.url);
			$( 'span', $el ).html(attachment.url).show();
		} )
		.open();
	} );

	$( document ).on( 'click', '.wvc-set-audio-file', function(e){
		e.preventDefault();
		var $el = $( this ).parent();
		var uploader = wp.media({
			title : WVCAdminParams.chooseFile,
			library : { type : 'audio'},
			multiple : false

		} )
		.on( 'select', function(){
			var selection = uploader.state().get( 'selection' );
			var attachment = selection.first().toJSON();
			$( 'input', $el ).val(attachment.url);
			$( 'span', $el ).html(attachment.url).show();
		} )
		.open();
	} );

	$( document ).on( 'click', '.wvc-reset-img, .wvc-reset-bg', function(){

		$( this ).parent().find( 'input' ).val( '' );
		$( this ).parent().find( '.wvc-img-preview' ).hide();
		return false;

	} );

	$( document ).on( 'click', '.wvc-reset-file', function(){

		$( this ).parent().find( 'input' ).val( '' );
		$( this ).parent().find( 'span' ).empty();
		return false;

	} );

} )( jQuery );