/**
 * Created by robert on 2/09/2015.
 */
jQuery(document).ready(function ($) {

    if ($('body').hasClass ('post-type-property') && $('body').hasClass ('post-new-php')) {
        $(window).on ('load', function () {
            $('#avia-builder-button').click ();
        });
    }

});