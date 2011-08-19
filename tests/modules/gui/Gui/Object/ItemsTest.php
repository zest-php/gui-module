<?php

/**
 * @category Gui
 * @package Gui_Object
 * @subpackage UnitTests
 */
class Gui_Object_ItemsTest extends PHPUnit_Framework_TestCase{

	/**
	 * @var Gui_Object_Items
	 */
	protected $_items = null;
	
	protected function setUp(){
		$this->_items = new Gui_Object_ItemsTest_Items();
	}
	
	public function testAddItemItemObject(){
		$item = new Gui_Object_ItemsTest_Item();
		$this->_items->addItem($item);
		list($s) = $this->_items->getItems();
		$this->assertTrue($item === $s);
	}
	
	public function testAddItemNoArgs(){
		$this->_items->addItem();
		list($item) = $this->_items->getItems();
		$this->assertInstanceOf('Gui_Object_ItemsTest_Item', $item);
	}
	
	public function testAddItemArray(){
		$this->_items->addItem(array('label' => 'testAddItemArray'));
		list($item) = $this->_items->getItems();
		$this->assertInstanceOf('Gui_Object_ItemsTest_Item', $item);
		$this->assertEquals('testAddItemArray', $item->getLabel());
	}
	
	public function testAddItemClassName(){
		$this->_items->addItem(new Gui_Object_ItemsTest_Item(), array('label' => 'testAddItemClassName'));
		list($item) = $this->_items->getItems();
		$this->assertInstanceOf('Gui_Object_ItemsTest_Item', $item);
		$this->assertEquals('testAddItemClassName', $item->getLabel());
	}
	
	public function testAddItemNoItemObject(){
		$this->setExpectedException('Zest_Exception');
		$this->_items->addItem(new Gui_Object_ItemsTest_ItemException());
	}
	
	public function testAddItemNoItemObjectString(){
		$this->setExpectedException('Zest_Exception');
		$this->_items->addItem('Gui_Object_ItemsTest_ItemException');
	}
	
}

class Gui_Object_ItemsTest_Items extends Gui_Object_Items{
	protected $_itemClassName = 'Gui_Object_ItemsTest_Item';
}

class Gui_Object_ItemsTest_Item extends Gui_Object_Items_Item{
}

class Gui_Object_ItemsTest_ItemException{
}