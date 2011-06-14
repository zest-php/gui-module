<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage Element
 */
class Gui_Form_Element_Button extends Gui_Form_Element_Widget{
	
	/**
	 * @var array
	 */
	protected $_availableWidgetOptions = array(
		'disabled', 'icons', 'label', 'text'
	);
	
	/**
	 * @var array
	 */
	protected $_availableWidgetEvents = array(
		'create'
	);
	
	/**
	 * @var string
	 */
	public $helper = 'formButton';
	
	/**
	 * @return string
	 */
	public function getWidgetName(){
		return 'button';
	}
	
	/**
	 * @param Zend_View_Interface $view
	 * @return string
	 */
	public function render(Zend_View_Interface $view = null){
		$this->setWidgetOption('text', $this->getLabel());
		return parent::render($view);
	}
	
}