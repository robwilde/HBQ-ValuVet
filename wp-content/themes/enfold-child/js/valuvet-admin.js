/**
 * Created by robert on 2/09/2015.
 * Fixed by Justin Graham 16/09/2015 - add line 14
 */
jQuery(document).ready(function ($) {

    $body = $('body');

    if ($body.hasClass ('post-type-property') && $body.hasClass ('post-new-php')) {
        $(window).on ('load', function () {
            $('#avia-builder-button').click();

            //avia-template-list-wrap
            $('.avia-template-list-wrap a:eq(0)').click();
        });
    }

});

