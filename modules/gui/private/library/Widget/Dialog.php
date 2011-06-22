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
	protected $_contentObject = null;
	
	/**
	 * @return Gui_Object
	 */
	public function getContentObject(){
		if(is_null($this->_contentObject)){
			$this->_contentObject = new Gui_Object_Html();
		}
		return $this->_contentObject;
	}
	
	/**
	 * @param Gui_Object|string $contentObject
	 * @return Gui_Object
	 */
	public function setContentObject($contentObject){
		if(is_string($contentObject)){
			$contentObject = $this->_manager->get($contentObject);
		}
		if(!$contentObject instanceof Gui_Object){
			throw new Zest_Exception('L\'objet de contenu doit être une instance de Gui_Object.');
		}
		$this->_contentObject = $contentObject;
	}
	
	/**
	 * @param string $method
	 * @param array $args
	 * @return mixed
	 */
	public function __call($method, $args){
		$object = $this->getContentObject();
		if(method_exists($object, $method)){
			return call_user_func_array(array($object, $method), $args);
		}
		throw new Zest_Exception(sprintf('La méthode "%s" n\'existe pas.', $method));
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