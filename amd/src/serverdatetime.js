/* jshint ignore:start */
define(['jquery', 'core/log'], function($, log) {

    "use strict"; // jshint ;_;

    log.debug('MooBytes ServerDateTime AMD');

    return {
        init: function(data) {
            $(document).ready(function() {
                log.debug(data.courseurl);
                var sdtb = $('#serverdatetimebtn');
                if (sdtb.length) {
                    var tsdt = $('#theserverdatetime');
                    sdtb.click(function() {
                        $.ajax({
                            url: data.courseurl,
                            statusCode: {
                                404: function() {
                                    log.debug("MooBytes ServerDateTime - url '" + data.courseurl + "' not found.");
                                }
                            }
                        }).done(function(data) {
                            log.debug('MooBytes ServerDateTime: ' + data);
                            tsdt.text(data);
                        }).fail(function(jqXHR, textStatus) {
                            log.debug('MooBytes ServerDateTime request failed: ' + textStatus);
                        });
                    });
                } else {
                    log.debug('MooBytes ServerDateTime: No button.');
                }
            });
            log.debug('MooBytes ServerDateTime AMD init');
        }
    };
});
/* jshint ignore:end */
