define([
    "jquery",
    "jquery/ui"

], function($){
    "use strict";

    $.widget('tree.js', {
        options: {
        },
        _init: function () {
            this.xml = null;
        },
        _convertXml: function (xml) {

            try {
                var xmlDoc = $.parseXML(xml);
                return $(xmlDoc);
            } catch (err) {
                return false;
            }
        }, 
        _getNodeByValue: function(id,element,attr){

            var path = element + '[' + attr + '=' + id + ']';
            return this._getNode(path);
        },
        _getNode: function(path){

            var node = this.xml.find(path);
            if(node.length){
                return node;
            }
            return false;
        },
        setXml: function(xml){
            this.xml = this._convertXml(xml);
        }
    });

    return $.tree.js;
});
