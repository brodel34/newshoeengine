/**
 * Stickybox plugin for jQuery.
 *
 * @copyright  Copyright (c) 2017 Jörg Moldenhauer
 * @author     Jörg Moldenhauer
 * @license    https://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 *
 * @link       https://github.com/joergmoldenhauer/jquery-stickybox
 */

(function($) {
    jQuery.fn.stickyBox = function(options) {
        // Set default configuration and extend it with given options
        var defaults = {
            notStickyBreakpoint: 767, // From this point on and below, boxes are not sticky
            spaceTop: 20, // Space between window top and boxes
            stoppper: false, // False or elements which stop the boxes (jQuery selektor e.g. '#footer' or '.sticky-box-stopper')
            stopperSpace: 20 // Space between stopper elements and boxes
        };
        var config = $.extend(defaults, options);

        // If display is smaller than defined breakpoint, do nothing
        if ($(window).innerWidth() <= config.notStickyBreakpoint) {
            return this;
        }

        // Get stopper (if set in options)
        var stopper;
        if (config.stopper !== false) {
            stopper = $(config.stopper).first();
        }

        // Make every element of the collection sticky
        return this.each(function() {
            // Get current element
            var box = $(this);

            // Save box style (for resetting box)
            box.initialStyle = box.attr('style');

            // Save box previous element and parent (for resetting box)
            box.parentElement = box.parent();

            // Set box already stopped flag (will be set to true when box is already below stopper element)
            box.alreadyStopped = false;

            // Set box properties and assign resize listener
            setBoxProperties(box);
            $(window).on('resize', function() {
                setBoxProperties(box);
                setBoxPosition(box);
            });

            // Set box position and assign scroll listener
            setBoxPosition(box);
            $(window).on('scroll', function() {
                setBoxPosition(box);
            });
        });

        /**
         * Sets properties of a given box based on the values when the box is not fixed
         */
        function setBoxProperties(box) {
            // Reset box
            resetBox(box);

            // Get values
            var offsetTop = box.offset().top;
            var offsetLeft = box.offset().left;
            var boxSizing = box.css('box-sizing');
            var width;
            if (boxSizing == 'border-box') {
                width = box.outerWidth();
            } else {
                width = box.width();
            }

            // Set box properties
            box.intialOffsetTop = offsetTop;
            box.intialOffsetLeft = offsetLeft;
            box.initialWidth = width;
        }

        /**
         * Positions a given box according to scroll level
         */
        function setBoxPosition(box) {
            // Check if box should be sticky or stopped
            if (!box.alreadyStopped && (($(window).scrollTop() >= box.intialOffsetTop - config.spaceTop) || (box.stopPosition !== undefined && $(window).scrollTop() >= box.stopPosition))) {
                // Set box parent container position relative
                // @todo: reset when box is not sticky anymore
                box.parentElement.css({
                    position: 'relative'
                });

                // Set css values for fixed state
                var position = 'fixed';
                var top = config.spaceTop;

                // Check if box should be stopped and set css styles accordingly
                if (box.stopPosition !== undefined && $(window).scrollTop() >= box.stopPosition) {
                    position = 'absolute';
                    top = box.stopPosition + config.spaceTop - box.parentElement.offset().top;
                }

                // Aply css styles
                box.css({
                    position: position,
                    top: top,
                    marginTop: 0,
                    width: box.initialWidth
                });
            } else {
                resetBox(box);
            }
        }

        /**
         * Resets a box to the state before it was sticky
         */
        function resetBox(box) {
            // Reset initial style or remove style-attribute completly
            if (box.initialStyle !== undefined) {
                box.attr('style', box.initialStyle);
            } else {
                box.removeAttr('style');
            }

            // Set box stop position (or set already stopped flag)
            if (config.stopper !== false && stopper.length > 0) {
                var stopperTop = stopper.offset().top;
                if (stopperTop > box.offset().top + box.outerHeight() + config.stopperSpace) {
                    box.alreadyStopped = false;
                    box.stopPosition = stopperTop - (config.spaceTop + box.outerHeight() + config.stopperSpace);
                } else {
                    box.alreadyStopped = true;
                }
            }
        }
    };
})(jQuery);
