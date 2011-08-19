<?php

/**
 * @category Gui
 * @package Gui_Object
 * @subpackage UnitTests
 */
class Gui_Object_IconsTest extends Gui_AbstractTest{

	/**
	 * @var Gui_Object_Icons
	 */
	protected $_icons = null;
	
	protected function setUp(){
		parent::setUp();
		$this->_icons = new Gui_Object_Icons();
	}
	
	public function testItemClass(){
		$this->_icons->addItem();
		list($item) = $this->_icons->getItems();
		$this->assertInstanceOf('Gui_Object_Icons_Icon', $item);
	}
	
	public function testXhrMethods(){
		$this->assertTrue($this->_icons->isXhrMethod('click'));
	}
	
//	public function testClick(){
//	}
	
	public function testRender(){
		$this->_icons->addItem(array('id' => 1));
		
		$xml = new SimpleXMLElement('<root>'.$this->_icons->render(self::$_view).'</root>');
		
		$this->assertEquals($this->_icons->getId(), (string) $xml->div[0]['id']);
		$this->assertEquals('gui-object-icons', (string) $xml->div[0]['class']);
		
		$this->assertEquals('gui-object-icons-icon', (string) $xml->div[0]->a[0]['class']);
		$this->assertEquals(1, (string) $xml->div[0]->a[0]['data-id']);
	}
	
}