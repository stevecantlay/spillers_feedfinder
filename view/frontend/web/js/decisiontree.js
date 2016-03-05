define([
    "jquery",
    'mage/template',
    "jquery/ui"

], function($, mageTemplate){
    "use strict";

    $.widget('decisiontree.js', {
        options: {
            answerTemplate: '<dd class="<%- data.class %>" id="<%- data.target %>">' +
            '<%- data.title %>' +
            '</dd>',
            buttonTemplate: '<div id="<%- data.bid %>" class="<%- data.class %>" data-pointer="<%- data.pointer %>">' +
            '<%- data.title %>' +
            '</div>',
            start: 1
        },
        _create: function () {

            this.options.xml = this._convertXml(this.options.xml);
            this.options.contentCss = "content";
            this.options.buttonsCss = "buttons";
            this.options.buttonsActive = "active";
            this.options.buttonsInActive = "in-active";
            this.options.historyCss = "history";
            this.options.backText = "previous question";
            this.options.nextText = "next question";
            this.options.backButton = "ffbackbutton";
            this.options.nextButton = "ffnextbutton";

            this.answerTmpl = mageTemplate(this.options.answerTemplate);
            this.buttonTmpl = mageTemplate(this.options.buttonTemplate);
        },
        _init: function () {

            if(this.options.xml) {
                this.currentNodeId = this.options.start;
                this.nextNode = null;
                this.previousNode = null;
                this.currentAnswer = null;
                this.history = [];
                this.current = 1;
                this._setupStructure();
                this.currentNode = this._getCurrentNode(this.currentNodeId);
                this._renderCurrentNode();
            }
        },
        _setupStructure: function () {

            this.content = document.createElement( "div" );
            this.question = document.createElement( "dt" );
            this.questions = document.createElement( "dl" );
            this.buttons = document.createElement( "div" );
            this.history = document.createElement( "ul" );

            $(this.content).attr("id", "content").addClass(this.options.contentCss);
            $(this.questions).attr("id", "questions");
            $(this.buttons).attr("id", "buttons").addClass(this.options.buttonsCss);
            $(this.history).attr("id", "history").addClass(this.options.historyCss).hide();

            $(this.questions).append(this.question);
            $(this.content).append(this.questions);
            $(this.content).append(this.history);
            this.element.append(this.content);
            this.element.append(this.buttons);

        },
        _convertXml: function (xml) {

            try {
                var xmlDoc = $.parseXML(xml);
                return $(xmlDoc);
            } catch (err) {
                return false;
            }
        }, 
        _getNode: function(id){
            var xmlDoc = this.options.xml;
            var node = xmlDoc.find("branch[id=" + id + "]");
            if(node.length){
                return node;
            }
            return false;
        },
        _getCurrentNode: function(id){ 

            return this._getNode(id);
        },
        _renderCurrentNode: function(){
            var node = this._getCurrentNode(this.currentNodeId);
            this._renderQuestion(node);
            this._renderAnswers(node);
            this._renderButtons();
        },
        _renderQuestion: function(node){

            var question = this._getQuestion(node);
            $(this.question).text(question);

        },
        _getQuestion: function(node){

            return this._sanitizeText(node.find("content").text());
        },
        _renderAnswers: function(node){

            node.find("fork").each($.proxy(function(key,child){

                $(this.questions).append($.proxy(function(){
                    var tmplData,  tmpl;

                    tmplData = {
                        class:$(child).attr('class'),
                        target:$(child).attr('target'),
                        title:$(child).text()
                    };

                    tmpl = this.answerTmpl ({ 
                        data: tmplData 
                    });  

                    return $(tmpl);

                },this));

                $(this.questions).find('dd').click($.proxy(this._answerEvent, this));
            }, this)); 
        },
        _renderButtons: function(){

            if(this.history.length){
                var node = this.history.slice(-1)[0];
                var pointer = $(node).attr('id');
                this._renderButton(this.options.backText,pointer,this.options.backButton);
            }
            this._renderButton(this.options.nextText,0,this.options.nextButton);
            $(this.buttons).find('div').click($.proxy(this._buttonEvent, this));
        },
        _answerEvent: function(event) {

            event.stopPropagation();
            this._clearActive();
            var e = $(event.target);
            var target = $(e).attr('id');
            $(e).addClass('active');
            this._setButtonTarget(this.options.nextButton,target);
        },
        _buttonEvent: function(event) {

            event.stopPropagation();
            this._processSelected($(event.target));
        },
        _setButtonTarget: function(b,target){

            var button = $(this.buttons).find("#" + b).attr("data-pointer",target);
            this._toggleButton(button);
        },
        _toggleButton: function(button){

            if($(button).hasClass(this.options.buttonsInActive)){
                $(button).removeClass(this.options.buttonsInActive);
                $(button).addClass(this.options.buttonsActive);
            }
        },
        _sanitizeText: function(text){
            return text.replace(/[!"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~]/g, '\\$&');
        },
        _clearActive:function(){
            $(this.questions).find('dd').removeClass('active');
        },
        _renderButton: function(text,pointer,id){

            var t = text;
            var p = pointer;
            var bid = id;

            $(this.buttons).append($.proxy(function(){

                var tmplData,  tmpl;
                var state = this.options.buttonsActive;
                if(pointer < 1){
                    state = this.options.buttonsInActive;
                }
                tmplData = {
                    bid:bid,
                    class:state,
                    pointer:p,
                    title:t
                };

                tmpl = this.buttonTmpl ({
                    data: tmplData
                });

                return $(tmpl);

            },this));

            $(this.buttons).children().addClass(this.options.buttonsCss);
        },
        _processSelected: function(target){
            var type = target.attr('id');
            var pointer = target.attr('data-pointer');

            if(pointer > 0) {
                console.log(pointer);
                var nextNode = this._getNode(pointer);
                if (type == this.options.nextButton) {
                    this.history.push([this.currentNodeId,pointer]);

                } else if (type == this.options.backButton) {

                }

                return true;
            }



                // pop history set current then render current
            //if next
                //push to history
                //then check if end
                    //if end reder outcome
                    // else render node
        }

    });

    return $.decisiontree.js;
});
