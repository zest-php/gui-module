<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage Element
 */
abstract class Gui_Form_Element_Widget extends Gui_Form_Element implements Gui_Widget_Interface{
	
	/**
	 * @var array
	 */
	protected $_availableWidgetOptions = array();
	
	/**
	 * @var array
	 */
	protected $_widgetOptions = array();
	
	/**
	 * @var array
	 */
	protected $_availableWidgetEvents = array();
	
	/**
	 * @var array
	 */
	protected $_widgetEvents = array();
	
	/**
	 * @param string $name
	 * @return mixed
	 */
	public function getWidgetOption($name){
		if(isset($this->_widgetOptions[$name])){
			return $this->_widgetOptions[$name];
		}
		return null;
	}
	
	/**
	 * @param string $name
	 * @param mixed $value
	 * @return Gui_Form_Element_Widget
	 */
	public function setWidgetOption($name, $value){
		if(in_array($name, $this->_availableWidgetOptions)){
			$this->_widgetOptions[$name] = $value;
		}
		else{
			throw new Zest_Exception(sprintf('L\'option "%s" n\'est pas disponible sur le widget "%s".', $name, $this->getWidgetName()));
		}
		return $this;
	}
	
	/**
	 * @param array $options
	 * @return Gui_Form_Element_Widget
	 */
	public function setWidgetOptions(array $options){
		foreach($options as $key => $value){
			$this->setWidgetOption($key, $value);
		}
		return $this;
	}
	
	/**
	 * @param string $name
	 * @return Gui_Form_Element_Widget
	 */
	public function getWidgetEvent($name){
		if(isset($this->_widgetEvents[$name])){
			return $this->_widgetEvents[$name];
		}
		return null;
	}
	
	/**
	 * @param string $name
	 * @param string $jsInline
	 * @return Gui_Form_Element_Widget
	 */
	public function setWidgetEvent($name, $jsInline){
		if(in_array($name, $this->_availableWidgetEvents)){
			$this->_widgetEvents[$name] = $jsInline;
		}
		else{
			throw new Zest_Exception(sprintf('L\'évènement "%s" n\'est pas disponible sur le widget "%s".', $name, $this->getWidgetName()));
		}
		return $this;
	}
	
	/**
	 * @param array $events
	 * @return Gui_Form_Element_Widget
	 */
	public function setWidgetEvents(array $events){
		foreach($events as $key => $value){
			$this->setWidgetEvent($key, $value);
		}
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getWidgetName(){
		$class = get_class($this);
		return strtolower(substr($class, strrpos($class, '_')+1));
	}
	
	/**
	 * @param Zend_View_Interface $view
	 * @return string
	 */
	public function render(Zend_View_Interface $view = null){
		$render = parent::render($view);
		
		$widget = $this->getWidgetName();
		
		$this->getView()->jquery()->ui('ui.'.$widget);
		$this->getView()->head()->jsInline(
			'$(function(){'.
			'$("#'.$this->_getJqueryIdSelector().'").'.$widget.'('.$this->_getJsonOptions().');'.
			'});'
		);
		
		return $render;
	}
	
	/**
	 * @return string
	 */
	protected function _getJqueryIdSelector(){
		return $this->getName();
	}
	
	/**
	 * @return string
	 */
	protected function _getJsonOptions(){
		$options = $this->_widgetOptions;
		
		foreach(array_keys($this->_widgetEvents) as $event){
			$options[$event] = '[event:'.$event.']';
		}
		
		if($options){
			$options = Zend_Json::encode($options);
		}
		else{
			$options = '{}';
		}
		
		foreach($this->_widgetEvents as $event => $jsInline){
			$options = str_replace('"[event:'.$event.']"', 'function(event, ui){'.$jsInline.'}', $options);
		}
		
		return $options;
	}
	
}