<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage Element
 */
class Gui_Form_Element_Wysiwyg_CKEditor extends Gui_Form_Element_Wysiwyg_Abstract{
	
	/**
	 * @param Zend_View_Interface $view
	 * @return void
	 */
	public function render(Zend_View_Interface $view = null){
		parent::render($view);
		
		$this->getView()->jquery();
		$this->getView()->head()->jsInline(
			'$(function(){'.
			'CKEDITOR.replace("'.$this->_element->getName().'", '.
			$this->_getJsonOptions().
			');'.
			'});'
		);
	}
	
}