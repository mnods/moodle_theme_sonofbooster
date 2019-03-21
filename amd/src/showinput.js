/* jshint ignore:start */
define(['jquery', 'core/log'], function($, log) {
    return {
        init: function() {
            $('#submit').on('click', function(e) {
                e.preventDefault(); // Do not submit right away.
                var thisFormData = $('#myForm').serialize(); // Serialize all form data.
                alert(thisFormData); // Alert serialized form data.
                $('#myForm').submit(); // Submit the form after fields/values have been alerted.
            });
            log.debug('sonofbooster showinput AMD init');
        }
    };
});
/* jshint ignore:end */