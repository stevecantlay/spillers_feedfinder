define([
    "jquery",
    "jquery/ui"
], function($){
    "use strict";

    $.widget('feedfinder.js', {
        options: {
        },
        _create: function() {
            console.log(this.options.xml);
        },
        _init: function() {

        }
    });

    return $.feedfinder.js;
});
