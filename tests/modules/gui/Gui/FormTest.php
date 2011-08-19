<?php

/**
 * @category Gui
 * @subpackage UnitTests
 */
class Gui_FormTest extends Gui_AbstractTest{
	
	/**
	 * @var Gui_Form
	 */
	protected $_form = null;
	
	protected function setUp(){
		$this->_form = new Gui_Form();
	}
	
	public function testPrefixPathElement(){
		$this->_form->addElement('button', 'testPrefixPathElement');
		$this->assertInstanceOf('Gui_Form_Element_Button', $this->_form->testPrefixPathElement);
	}
	
	public function testPrefixPathDecorator(){
		$this->_form->addDecorator('viewHelper');
		$this->assertInstanceOf('Gui_Form_Decorator_ViewHelper', $this->_form->getDecorator('viewHelper'));
	}
	
}