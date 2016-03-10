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
            mainTemplate: '<div id="content" class="<%- data.cclass %>">' +
            '<dl id="questions"><dt id="question"></dt></dl>' +
            '<div id="buttons" class="<%- data.bclass %>">' +
            '<button id="<%- data.bbutton %>" class="in-active <%- data.bbclass %>" data-pointer="0"><span><%- data.bcontent %></span></button>' +
            '<button id="<%- data.nbutton %>" class="in-active <%- data.bbclass %>" data-pointer="0"><span><%- data.ncontent %></span></button>' +
            '</div></div>' +
            '<ul id="history" class="<%- data.hclass %>" style="display: none;"></ul>',
            start: 1
        },
        _create: function () {

            this.options.xml = this._convertXml(this.options.xml);
            this.options.contentCss = "content";
            this.options.buttonsCss = "buttons";
            this.options.buttonsActive = "active";
            this.options.buttonsInActive = "in-active";
            this.options.historyCss = "history";
            this.options.backText = "Previous Question";
            this.options.nextText = "Next Question";
            this.options.backButton = "ffbackbutton";
            this.options.nextButton = "ffnextbutton";

            this.answerTmpl = mageTemplate(this.options.answerTemplate);
            this.mainTmpl = mageTemplate(this.options.mainTemplate);
        },
        _init: function() {

            if(this.options.xml) {
                this.currentNodeId = this.options.start;
                this.currentHistory = false;
                this.nextNode = null;
                this.previousNode = null;
                this.currentAnswer = null;
                this.qHistory = [];
                this.current = 1;
                this._setupStructure();
                this.currentNode = this._getCurrentNode(this.currentNodeId);
                this._renderCurrentNode();
            }
        },
        _setupStructure: function () {

            this.element.append($.proxy(function(){
                var tmplData,  tmpl;

                tmplData = {
                    cclass:this.options.contentCss,
                    bclass:this.options.buttonsCss,
                    bbclass:this.options.buttonsCss,
                    bbutton:this.options.backButton,
                    nbutton:this.options.nextButton,
                    bcontent:this.options.backText,
                    ncontent:this.options.nextText,
                    hclass:this.options.historyCss
                };

                tmpl = this.mainTmpl ({
                    data: tmplData
                });

                return $(tmpl);

            },this));

            this.content = this.element.find('#content');
            this.question = this.element.find('#question');
            this.questions = this.element.find('#questions');
            this.buttons = this.element.find('#buttons');
            this.history = this.element.find('#history');
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
            var node = $(xmlDoc).find("branch[id='" + id + "']");
            if(node.length){
                return node;
            }
            return false;
        },
        _getCurrentNode: function(id){ 

            return this._getNode(id);
        },
        _emptyNode: function(node){

            $(node).empty();
        },
        _renderHistory: function(){

            this._emptyNode(this.history);
            if(this.qHistory.length) {
                $(this.qHistory).each($.proxy(function (key, child) {
                    var node = this._getNode(child.node);
                    var question = this._getQuestion(node);
                    $(this.history).append('<li>' + question + '</li>');
                }, this));
                $(this.history).show();
            }
        },
        _renderCurrentNode: function(){

            var node = this._getCurrentNode(this.currentNodeId);

            var nodeType = this._getNodeType(node);
            console.log(nodeType);
            this._emptyNode(this.questions);
            this._renderQuestion(node);
            this._renderAnswers(node);
            this._renderButtons();
            this._renderHistory();
        },
        _renderQuestion: function(node){

            var question = this._getQuestion(node);
            $(this.question).text(question);
        },
        _getQuestion: function(node){

            return this._sanitizeText(this._getContentText(node));
        },
        _getContentText: function(node){
            return $(node).find("content").text();
        },
        _getNodeType: function(node){
            return this._getNodeAttr(node,'nodeType');
        },
        _getContentType: function(node){
            return this._getNodeAttr(node,'contentType');
        },
        _getNodeAttr: function(node,attr){
            return $(node).find("content").attr(attr);
        },
        _renderAnswers: function(node){

            $(node).find("fork").each($.proxy(function(key,child){

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

            }, this));

            this.element.find('dd').click($.proxy(this._answerOnClick, this));
            if(this.qHistory.length) {
                var currentHistory = this.qHistory.slice(-1)[0];
                var pointer = currentHistory.answer;
                $(this.question).find("#" + pointer).addClass('active');
            }
        },
        _answerOnClick: function(event) {

            event.stopPropagation();
            this._clearActive();
            var e = $(event.target);
            var target = $(e).attr('id');
            $(e).addClass('active');
            this._setButtonTarget(this.options.nextButton,target);
        },
        _renderButtons: function(){

            if(this.qHistory.length){
                var currentHistory = this.qHistory.slice(-1)[0]
                var pointer = currentHistory.node;
                this._renderButton(pointer,this.options.backButton);

            }else{
                this.element.find("#" + this.options.backButton).hide();
            }
            this._renderButton(0,this.options.nextButton);
            this.element.find("#" + this.options.backButton).click($.proxy(this._gotoNextOnClick, this));
            this.element.find("#" + this.options.nextButton).click($.proxy(this._gotoNextOnClick, this));
        },
        _renderButton: function(pointer,id){

            this.element.find("#" + id).show().attr('data-pointer',pointer);
        },
        _gotoNextOnClick: function(event) {

            event.stopPropagation();
            var e = $(event.target);

            if($(e).is("span")){
                e = e.parent();
            }

            var type = $(e).attr('id');
            var pointer = $(e).attr('data-pointer');

            if(parseFloat(pointer) !== 0){
                if (type == this.options.nextButton) {
                    var history = {node: this.currentNodeId,answer:pointer};
                    this.qHistory.push(history);
                }else if (type == this.options.backButton){
                    this.currentHistory = this.qHistory.pop();
                }
                this.currentNodeId = pointer;
                this._renderCurrentNode();
            }
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
        _getAjaxContent: function(type,name){

        }
    });

    return $.decisiontree.js;
});
