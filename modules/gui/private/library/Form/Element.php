<?php

/**
 * @category Gui
 * @package Gui_Form
 */
class Gui_Form_Element extends Zend_Form_Element{
	
	/**
	 * @var Gui_Manager
	 */
	protected $_manager = null;
	
	/**
	 * @return void
	 */
	public function init(){
		$this->_manager = Gui_Manager::getInstance();
	}
	
}