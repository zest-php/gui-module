manager.plugin(function(selector){
	selector.find('.gui-object-icons').children().click(function(){
		var $this = $(this);
		manager.action($this.parent().data('class'), 'click', [$this.data('id')]);
	});
});