(function($) {
    'use strict';
    $(window).on("load", function(e) {
        // ______________ Page loading
        $("#global-loader").fadeOut("slow");

    })
})(jQuery);


window.setTimeout(function() {
    $(".alert").hide()
}, 3000);
