/* jshint ignore:start */
define(['jquery', 'theme_sonofbooster/jquery.countdown'], function($) {
    return {
        initialise: function () {
            $('#clock').countdown('2020/10/10', function(event) {
                $(this).html(event.strftime('%D days %H:%M:%S'));
            });
        }
    };
});