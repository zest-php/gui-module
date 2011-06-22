<?php

/**
 * @category Gui
 * @package Gui_Widget
 */
interface Gui_Widget_Interface{
	
	/**
	 * @param string $name
	 * @return mixed
	 */
	public function getWidgetOption($name);
	
	/**
	 * @param string $name
	 * @param mixed $value
	 * @return Gui_Widget_Interface
	 */
	public function setWidgetOption($name, $value);
	
	/**
	 * @param array $options
	 * @return Gui_Widget_Interface
	 */
	public function setWidgetOptions(array $options);
	
	/**
	 * @param string $name
	 * @return Gui_Widget_Interface
	 */
	public function getWidgetEvent($name);
	
	/**
	 * @param string $name
	 * @param string $jsInline
	 * @return Gui_Widget_Interface
	 */
	public function setWidgetEvent($name, $jsInline);
	
	/**
	 * @param array $events
	 * @return Gui_Widget_Interface
	 */
	public function setWidgetEvents(array $events);
	
	/**
	 * @return string
	 */
	public function getWidgetName();
	
	/**
	 * @param Zend_View_Interface $view
	 * @return string
	 */
	public function render(Zend_View_Interface $view = null);
	
}