<?php

/**
 * @category Gui
 * @package Gui_Object
 * @subpackage UnitTests
 */
class Gui_Object_Items_ItemTest extends Gui_AbstractTest{

	/**
	 * @var Gui_Object_Items_Item
	 */
	protected $_item = null;
	
	protected function setUp(){
		parent::setUp();
		$this->_item = new Gui_Object_Items_ItemTest_Item();
	}

	public function testGetSetLabel(){
		$this->_item->setLabel('testGetSetLabel');
		$this->assertEquals('testGetSetLabel', $this->_item->getLabel());
	}

	public function testGetSetId(){
		$this->_item->setId('testGetSetId');
		$this->assertEquals('testGetSetId', $this->_item->getId());
	}

	public function testGetIdException(){
		$this->setExpectedException('Zest_Exception');
		$this->_item->getId();
	}
	
}

class Gui_Object_Items_ItemTest_Item extends Gui_Object_Items_Item{
}