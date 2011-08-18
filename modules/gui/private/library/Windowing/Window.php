<?php

/**
 * @category Gui
 * @package Gui_Window
 */
class Gui_Windowing_Window extends Gui_Widget_Dialog{
	
	/**
	 * @var string
	 */
	protected $_defaultContentObject = 'Gui_Windowing_Frameset';
	
	/**
	 * @var array
	 */
	protected $_xhrMethods = array('open', 'close', 'setPosition', 'setSize');
	
	/**
	 * @return string
	 */
	public function getWidgetName(){
		return 'dialog';
	}
	
	/**
	 * @return Gui_Windowing_Window
	 */
	public function open(){
		Gui_Windowing_Manager::getInstance()->openWindow($this);
		return $this;
	}
	
	/**
	 * @return Gui_Windowing_Window
	 */
	public function close(){
		Gui_Windowing_Manager::getInstance()->closeWindow($this);
	}
	
	/**
	 * @param Zend_View_Interface $view
	 * @return string
	 */
	public function render(Zend_View_Interface $view = null){
		$render = parent::render($view);
		$this->getView()->head()->js($this->_manager->getConfigUrl('url.gui.js', 'windowing/window.js'));
		return $render;
	}
	
}