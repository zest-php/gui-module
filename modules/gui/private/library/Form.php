<?php

/**
 * @category Gui
 * @package Gui_Form
 */
class Gui_Form extends Zest_Form{
	
	/**
	 * @var Gui_Manager
	 */
	protected $_manager = null;
	
	/**
	 * @param mixed $options
	 * @return void
	 */
	public function __construct($options = null){
		$this->_manager = Gui_Manager::getInstance();
		parent::__construct($options);
	}
	
	/**
	 * @return void
	 */
	protected function _initPrefixPath(){
		parent::_initPrefixPath();
		$this->addPrefixPath('Gui_Form_Element', $this->_manager->getDirectory().'/library/Form/Element', Zend_Form::ELEMENT);
		$this->addPrefixPath('Gui_Form_Decorator', $this->_manager->getDirectory().'/library/Form/Decorator', Zend_Form::DECORATOR);
	}
	
}