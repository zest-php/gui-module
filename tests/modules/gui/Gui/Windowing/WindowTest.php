<?php

/**
 * @category Gui
 * @package Gui_Windowing
 * @subpackage UnitTests
 */
class Gui_Windowing_WindowTest extends Gui_AbstractTest{

	/**
	 * @var Gui_Windowing_Manager
	 */
	protected static $_manager = null;
	
	/**
	 * @var Gui_Windowing_Window
	 */
	protected $_window = null;
	
	public static function setUpBeforeClass(){
		self::$_manager = Gui_Windowing_WindowTest_Manager::getInstance();
	}
	
	public static function tearDownAfterClass(){
		Gui_Windowing_WindowTest_Manager::resetInstance();
	}
	
	protected function setUp(){
		parent::setUp();
		$this->_window = new Gui_Windowing_Window();
		self::$_manager->resetOpenedWindow();
	}
	
	public function testDefaultContentObject(){
		$this->assertInstanceOf('Gui_Windowing_Frameset', $this->_window->getContentObject());
	}
	
	public function testGetWidgetName(){
		$this->assertEquals('dialog', $this->_window->getWidgetName());
	}
	
	public function testXhrMethods(){
		$this->assertTrue($this->_window->isXhrMethod('open'));
		$this->assertTrue($this->_window->isXhrMethod('close'));
		$this->assertTrue($this->_window->isXhrMethod('setPosition'));
		$this->assertTrue($this->_window->isXhrMethod('setSize'));
	}
	
	public function testOpenClose(){
		$this->_window->open();
		$openedWindows = self::$_manager->getOpenedWindows();
		$this->assertTrue($openedWindows['Gui_Windowing_Window'] === $this->_window);
		
		$this->_window->close();
		$openedWindows = self::$_manager->getOpenedWindows();
		$this->assertArrayNotHasKey('Gui_Windowing_Window', $openedWindows);
	}
	
	public function testRender(){
		$xml = new SimpleXMLElement('<root>'.$this->_window->render(self::$_view).'</root>');
		$this->assertEquals($this->_window->getId(), (string) $xml->div[0]['id']);
		$this->assertEquals($this->_window->getContentObject()->getId(), (string) $xml->div[0]->div[0]['id']);
	}
	
}

class Gui_Windowing_WindowTest_Manager extends Gui_Windowing_Manager{
	public function resetOpenedWindow(){
		$this->_openedWindows = null;
	}
	public static function getInstance(){
		self::$_instance = new self();
		return self::$_instance;
	}
	public static function resetInstance(){
		self::$_instance = null;
	}
}