$.gui = $.gui || {};
$.gui.windowing = $.gui.windowing || {};

$.gui.windowing.window = function(id, class_name, options){
	options = options || {};
	
	this.class_name = class_name;
	this.id = id;
	this.selector = $('#' + this.id);
	if(this.selector.length == 0){
		this.selector = $('<div id="' + this.id + '" />');
		$('body').append(this.selector);
	}
	
	if(this.class_name){
		options.close = $.proxy(this.sendClose, this);
		options.dragStop = $.proxy(this.sendPosition, this);
		options.resizeStop = $.proxy(this.sendSize, this);
	}
		
	this.dialog = this.selector.dialog(options).parent();
};

$.gui.windowing.window.prototype.setLoading = function(){
	return this;
};

$.gui.windowing.window.prototype.sendClose = function(){
	manager.action(this, 'close');
	return this;
};

$.gui.windowing.window.prototype.sendPosition = function(){
	manager.action(this, 'setPosition', [parseInt(this.dialog.css('left')), parseInt(this.dialog.css('top'))]);
	return this;
};

$.gui.windowing.window.prototype.sendSize = function(){
	manager.action(this, 'setSize', [parseInt(this.dialog.width()), parseInt(this.dialog.height())]);
	return this;
};

$.gui.windowing.window.prototype.reload = function(){
	manager.action(this, 'open');
	return this;
};