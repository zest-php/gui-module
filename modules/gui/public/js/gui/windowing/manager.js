$.gui = $.gui || {};
$.gui.windowing = $.gui.windowing || {};

$.gui.windowing.manager = function(){
	this.plugins = [];
};

$.gui.windowing.manager.prototype.plugin = function(callback){
	this.plugins.push(callback);
	return this;
};

$.gui.windowing.manager.prototype.action = function(object, action, args){
	if(typeof(object) == 'object'){
		object = object.class_name;
	}
	this.ajax(call_url, {gui_object: object, call: action, args: args});
	return this;
};

$.gui.windowing.manager.prototype.ajax = function(url, data, callback){
	data = data || {};
	var settings = {
		complete: callback,
		data: data,
		dataType: 'json',
		success: $.proxy(this.ajaxSuccess, this),
		error: $.proxy(this.ajaxError, this),
		type: 'post',
		url: url
	};
	$.ajax(settings);
	return this;
};

$.gui.windowing.manager.prototype.ajaxError = function(xhr, status){
	var id = 'error-' + String(Math.random()).replace(/^[0-9]\./, '');
	this.openWindow(id, null, {title: 'Dysfonctionnement de l\'application', width: 800, height: 300});
	$('#' + id).html('<pre>' + xhr.responseText + '</pre>');
	return this;
};

$.gui.windowing.manager.prototype.ajaxSuccess = function(json, status, xhr){
	if(typeof(json) != 'object'){
		return this.ajaxError(xhr, status);
	}
	var target, render;
	for(var i in json.objects){
		target = $('#' + i);
		if(!target.length && json.objects[i].is_window){
			target = this.openWindow(i, json.objects[i].class_name, json.objects[i].options).selector;
		}
		render = $('<div>' + json.objects[i].render + '</div>').find('#' + i).html();
		target.html(render);
		this.applyPlugins(target);
	}
	if(json.assets){
		$('head').append($(json.assets));
	}
	return this;
};

$.gui.windowing.manager.prototype.applyPlugins = function(selector){
	for(var i in this.plugins){
		this.plugins[i](selector);
	}
	return this;
};

$.gui.windowing.manager.prototype.openWindow = function(id, class_name, options){
	var window = new $.gui.windowing.window(id, class_name, options);
	return window;
};

var manager = new $.gui.windowing.manager();
$(function(){
	manager.applyPlugins($('#gui-windowing-window-main'));
	for(var i=0; i<windows.length; i++){
		manager.openWindow(windows[i].id, windows[i].class_name, windows[i].options).reload();
	}
});