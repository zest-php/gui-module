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
	 * @var string
	 */
	protected $_defaultContentObject = 'Gui_Object_Html';
	
	/**
	 * @var array
	 */
	protected $_xhrMethods = array('setPosition', 'setSize');
	
	/**
	 * @return Gui_Object
	 */
	public function getContentObject(){
		if(is_null($this->_contentObject)){
			$this->_contentObject = new $this->_defaultContentObject();
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
	
	/**
	 * @return array
	 */
	public function getOptions(){
		$options = parent::getOptions();
		$widgetOptions = array('position', 'width', 'height');
		foreach($widgetOptions as $widgetOption){
			$value = $this->getWidgetOption($widgetOption);
			if(!is_null($value)){
				$options[$widgetOption] = $value;
			}
		}
		return $options;
	}
	
	/**
	 * @param integer $x
	 * @param integer $y
	 * @return Gui_Windowing_Window
	 */
	public function setPosition($x, $y = null){
		if(is_array($x)){
			list($x, $y) = $x;
		}
		$this->setWidgetOption('position', array(intval($x), intval($y)));
		return $this;
	}
	
	/**
	 * @param integer $x
	 * @return Gui_Windowing_Window
	 */
	public function setLeft($x){
		$position = (array) $this->getWidgetOption('position');
		if(!$position){
			$position = array(0, 0);
		}
		$position[0] = intval($x);
		$this->setWidgetOption('position', $position);
		return $this;
	}
	
	/**
	 * @param integer $y
	 * @return Gui_Windowing_Window
	 */
	public function setTop($y){
		$position = (array) $this->getWidgetOption('position');
		if(!$position){
			$position = array(0, 0);
		}
		$position[1] = intval($y);
		$this->setWidgetOption('position', $position);
		return $this;
	}
	
	/**
	 * @param integer $width
	 * @param integer $height
	 * @return Gui_Windowing_Window
	 */
	public function setSize($width, $height){
		$this->setWidth($width);
		$this->setHeight($height);
		return $this;
	}
	
	/**
	 * @param integer $width
	 * @return Gui_Windowing_Window
	 */
	public function setWidth($width){
		$this->setWidgetOption('width', intval($width));
		return $this;
	}
	
	/**
	 * @param integer $height
	 * @return Gui_Windowing_Window
	 */
	public function setHeight($height){
		$this->setWidgetOption('height', intval($height));
		return $this;
	}
	
}