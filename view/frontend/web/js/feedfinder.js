define([
    "jquery",
    "jquery/ui"
], function($){
    "use strict";

    $.widget('feedfinder.js', {
        options: {
        },
        _create: function() {
            this.options.xml = this._convertXml(this.options.xml);
            console.log(this.options.xml);
        },
        _init: function() {

        },
        _convertXml: function(xml){
            try {
                var xmlDoc = $.parseXML(xml);
            } catch (err) {
                console.log(err);
            }
            return xmlDoc;
        },
        _setOption: function( key, value ) {
            if ( key === "xml" ) {
                value = this._convertXml( value );
            }
            this._super( key, value );
        },
        _setOptions: function( options ) {
            this._super( options );
        }

    });

    return $.feedfinder.js;
});
