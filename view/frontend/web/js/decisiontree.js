define([
    "jquery",
    'mage/template',
    "jquery/ui"

], function($, mageTemplate){
    "use strict";

    $.widget('decisiontree.js', {
        options: {
            buttonTemplate:
            '<span class="response" id="<%- data.value %>">' +
            '<%- data.title %>' +
            '</span>'
        },
        _create: function() {
            this.options.xml = this._convertXml(this.options.xml);
            this.questionContainer  = this.element.find(this.options.question);
            this.buttonsContainer  = this.element.find(this.options.buttons);
            this.historyContainer  = this.element.find(this.options.history);
            this.buttonTmpl = mageTemplate(this.options.buttonTemplate);
        },
        _init: function() {

            this.current = 1;
            this.currentNode = this._getCurrent();
            if(this.currentNode.length > 0){
                this.currentNode.children().each($.proxy(function(key,node){
                    switch (node.tagName) {
                        case 'content':
                            console.log(node.tagName);
                            console.log(node.textContent);
                            this._renderQuestion(this.questionContainer,this.current,node.textContent);
                            break;
                        case 'fork':
                            var target = $(node).attr('target');
                            this._renderQuestion(this.buttonsContainer,target,node.textContent);
                            break;
                    }
                }, this));
            }
        },
        _convertXml: function(xml){
            try {
                var xmlDoc = $.parseXML(xml);
                return $(xmlDoc);
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
        },
        _getCurrent: function(){
            var xmlDoc = this.options.xml;
            var node = xmlDoc.find("branch[id=" + this.current + "]");
            return node;
        },
        _setCurrent: function(current){
            this.current = current;
        },
        _renderQuestion: function(feedElement, tagName, textContent){

            console.log(tagName);
            console.log(textContent);

            feedElement.append($.proxy(function () {

                var text = textContent.replace(/[!"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~]/g, '\\$&'),
                    tmplData,
                    tmpl;

                tmplData = {
                    value: tagName,
                    title: text
                };
                tmpl = this.buttonTmpl ({
                    data: tmplData
                });

                return $(tmpl);

            },this));

            this.element.find('.response').click($.proxy(this._answerEvent, this));

        },
        _answerEvent: function(event) {
            event.stopPropagation();
            console.log(event.target);
            alert('you clicked ' + $(event.target).attr('id'));
            var current = $(event.target).attr('id');
            this._setCurrent(current);
        },
        _clearData: function(){

        }

    });

    return $.decisiontree.js;
});
