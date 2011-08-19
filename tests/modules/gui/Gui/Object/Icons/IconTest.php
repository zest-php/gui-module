<?php

/**
 * @category Gui
 * @package Gui_Object
 * @subpackage UnitTests
 */
class Gui_Object_Icons_IconTest extends Gui_AbstractTest{

	/**
	 * @var Gui_Object_Icons_Icon
	 */
	protected $_icon = null;
	
	protected function setUp(){
		parent::setUp();
		$this->_icon = new Gui_Object_Icons_Icon();
	}

	public function testGetSetImage(){
		$this->_icon->setImage('image/icon.png');
		$this->assertEquals('image/icon.png', $this->_icon->getImage());
	}
	
	public function testGetSetUrl(){
		$this->_icon->setUrl('testGetSetUrl_action');
		list($action, $controller, $module) = $this->_icon->getUrl();
		$this->assertEquals('testGetSetUrl_action', $action);
		$this->assertNull($controller);
		$this->assertNull($module);
	}
	
	public function testSetUrlArray(){
		$this->_icon->setUrl(array(
			'action' => 'testSetUrlArray_action',
			'controller' => 'testSetUrlArray_controller'
		));
		list($action, $controller, $module) = $this->_icon->getUrl();
		$this->assertEquals('testSetUrlArray_action', $action);
		$this->assertEquals('testSetUrlArray_controller', $controller);
		$this->assertNull($module);
	}
	
}