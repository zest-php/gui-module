<?php

/**
 * @category Gui
 * @package Gui_Widget
 */
class Gui_Widget_Dialog extends Gui_Widget{
	
	/**
	 * @var array
	 */
	protected $_availableWidgetOptions = array(
		'autoOpen', 'buttons', 'closeOnEscape', 'closeText', 'dialogClass', 'disabled', 'draggable', 'height', 'hide', 'maxHeight',
		'maxWidth', 'minHeight', 'minWidth', 'modal', 'position', 'resizable', 'show', 'stack', 'title', 'width',
		'zIndex'
	);

	/**
	 * @var array
	 */
	protected $_availableWidgetEvents = array(
		'beforeClose', 'close', 'create', 'drag', 'dragStart', 'dragStop', 'focus', 'open', 'resize', 'resizeStart',
		'resizeStop'
	);
	
	/**
	 * @var Gui_Object
	 */
	protected $_content = null;
	
	/**
	 * @return Gui_Object
	 */
	public function getContent(){
		if(is_null($this->_content)){
			$this->_content = new Gui_Object_Html();
		}
		return $this->_content;
	}
	
	/**
	 * @param string $viewScript
	 * @return Gui_Widget_Dialog
	 */
	public function setContentViewScript($viewScript){
		$content = $this->getContent();
		if($content instanceof Gui_Object_Html){
			$content->setContentViewScript($viewScript);
			return $this;
		}
		throw new Zest_Exception('Pour utiliser la méthode setContentViewScript, le contenu doit être un objet graphique Gui_Object_Html.');
	}
	
	/**
	 * @param Zend_View_Interface $view
	 * @return string
	 */
	public function render(Zend_View_Interface $view = null){
		$render = parent::render($view);
		if($this->getWidgetOption('draggable')){
			$this->getView()->jquery()->ui('ui.draggable');
		}
		if($this->getWidgetOption('resizable')){
			$this->getView()->jquery()->ui('ui.resizable');
		}
		return $render;
	}
	
}