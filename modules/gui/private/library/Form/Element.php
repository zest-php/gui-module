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
     * @param string|array|Zend_Config $spec
     * @param array|Zend_Config $options
	 * @return void
	 */
	public function __construct($spec, $options = null){
		$this->_manager = Gui_Manager::getInstance();
		parent::__construct($spec, $options);
	}
	
}