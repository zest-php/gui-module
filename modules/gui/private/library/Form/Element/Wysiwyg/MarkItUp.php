<?php

/**
 * @todo
 * 
 * @category Gui
 * @package Gui_Form
 * @subpackage Element
 */
class Gui_Form_Element_Wysiwyg_MarkItUp extends Gui_Form_Element_Wysiwyg_Abstract{
	
	/**
	 * @param Zend_View_Interface $view
	 * @return void
	 */
	public function render(Zend_View_Interface $view = null){
		throw new Zest_Exception(sprintf('pending "%s"', $this->getName()));
		parent::render($view);
	}
	
}