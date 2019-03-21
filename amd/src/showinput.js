/* jshint ignore:start */
define(['jquery', 'core/log'], function($, log) {

    "use strict"; // jshint ;_;

    log.debug('sonofbooster showinput AMD');

    return {
        init: function() {
          
                //log.debug(data.courseurl);
                 $('#submit').on('click', function(e){
                 e.preventDefault //do not submit right away
                 var thisFormData = $('#myForm').serialize(); //serialize all form data
                 alert(thisFormData); //alert serialized form data
                 $('#myForm').submit(); //submit the form after fields/values have been alerted
              });
         
            log.debug('sonofbooster showinput AMD init');
        }
    };
});
/* jshint ignore:end */

