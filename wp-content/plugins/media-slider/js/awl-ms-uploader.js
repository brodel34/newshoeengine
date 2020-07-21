jQuery(function(jQuery) {
    
    var file_frame,
    awl_media_slider = {
        ul: '',
        init: function() {
            this.ul = jQuery('.mediabox');
            this.ul.sortable({
                placeholder: '',
				revert: true,
            });			
			
            /**
			 * Add Slide Callback Funtion
			 */
            jQuery('#add-new-media-slider').on('click', function(event) {
                event.preventDefault();
                if (file_frame) {
                    file_frame.open();
                    return;
                }
                file_frame = wp.media.frames.file_frame = wp.media({
                    multiple: true
                });

                file_frame.on('select', function() {
                    var images = file_frame.state().get('selection').toJSON(),
                            length = images.length;
                    for (var i = 0; i < length; i++) {
                        awl_media_slider.get_thumbnail(images[i]['id']);
                    }
                });
                file_frame.open();
            });
			
			/**
			 * Delete Slide Callback Function
			 */
            this.ul.on('click', '#remove-media-slide', function() {
                if (confirm('Are sure to delete this images?')) {
                    jQuery(this).parent().fadeOut(700, function() {
                        jQuery(this).remove();
                    });
                }
                return false;
            });
			
			/**
			 * Delete All Slides Callback Function
			 */
			jQuery('#remove-all-media-slides').on('click', function() {
                if (confirm('Are sure to delete all images?')) {
                    awl_media_slider.ul.empty();
                }
                return false;
            });
           
        },
        get_thumbnail: function(id, cb) {
            cb = cb || function() {
            };
            var data = {
                action: 'media_slider_js',
                slideId: id
            };
            jQuery.post(ajaxurl, data, function(response) {
                awl_media_slider.ul.append(response);
                cb();
            });
        }
    };
    awl_media_slider.init();
});