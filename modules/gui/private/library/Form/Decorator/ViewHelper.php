<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage Decorator
 */
class Gui_Form_Decorator_ViewHelper extends Zend_Form_Decorator_ViewHelper{
	
	/**
	 * @var array
	 */
	protected $_buttonTypes = array(
		'Zend_Form_Element_Button',
		'Zend_Form_Element_Reset',
		'Zend_Form_Element_Submit',
		'Gui_Form_Element_Button',
		'Gui_Form_Element_Reset',
		'Gui_Form_Element_Submit'
	);
	
	/**
	 *
	 * @param Zend_Form_Element $element
	 * @return string|null
	 */
	public function getValue($element){
		if(!$element instanceof Zend_Form_Element){
			return null;
		}

		foreach($this->_buttonTypes as $type){
			if ($element instanceof $type){
				return $element->getLabel();
			}
		}

		return $element->getValue();
	}
	
}