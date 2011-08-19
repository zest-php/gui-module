<?php

/**
 * @category Gui
 * @package Gui_Windowing
 * @subpackage UnitTests
 */
class Gui_Windowing_ManagerTest extends Gui_AbstractTest{

	/**
	 * @var Gui_Windowing_Manager
	 */
	protected static $_manager = null;
	
	public static function setUpBeforeClass(){
		self::$_manager = Gui_Windowing_ManagerTest_Manager::getInstance();
	}
	
	protected function setUp(){
		parent::setUp();
		self::$_manager->resetOpenedWindow();
	}
	
	public function testGetMainWindow(){
		$this->assertInstanceOf('Gui_Windowing_Window_Main', self::$_manager->getMainWindow());
	}
	
	public function testOpenWindowGetOpenedWindows(){
		$window = Gui_Manager::getInstance()->get('Ns_Windowing_ManagerTest_Window', array('left' => 10));
		
		self::$_manager->openWindow($window);
		$openedWindows = self::$_manager->getOpenedWindows();
		$this->assertTrue($openedWindows['Ns_Windowing_ManagerTest_Window'] === $window);
		
		self::$_manager->resetOpenedWindow();
		$openedWindows = self::$_manager->getOpenedWindows();
		$restoredWindow = $openedWindows['Ns_Windowing_ManagerTest_Window'];
		$this->assertFalse($restoredWindow === $window);
		$this->assertEquals(array(10, 0), $restoredWindow->getWidgetOption('position'));
	}
	
	public function testCloseWindow(){
		$window = Gui_Manager::getInstance()->get('Ns_Windowing_ManagerTest_Window');
		
		self::$_manager->openWindow($window);
		$openedWindows = self::$_manager->getOpenedWindows();
		$this->assertTrue($openedWindows['Ns_Windowing_ManagerTest_Window'] === $window);
		
		self::$_manager->closeWindow($window);
		$openedWindows = self::$_manager->getOpenedWindows();
		$this->assertArrayNotHasKey('Ns_Windowing_ManagerTest_Window', $openedWindows);
	}
	
	public function testSend(){
		$window = Gui_Manager::getInstance()->get('Ns_Windowing_ManagerTest_Window');
		self::$_manager->send($window);
		$this->assertArrayHasKey($window->getId(), self::$_manager->getSendedObjects());
	}
	
	public function testRender(){
		$window = Gui_Manager::getInstance()->get('Ns_Windowing_ManagerTest_Window', array('left' => 10));
		self::$_manager->openWindow($window);
		
		$object = new Gui_Object_Html(array('viewScript' => 'widget/testRender.phtml'));
		self::$_manager->send($object);
		
		$xml = new SimpleXMLElement('<root>'.self::$_manager->render(self::$_view).'</root>');
		$this->assertEquals('gui-windowing-window-main', (string) $xml->div[0]['id']);
		
		/**
		 * 3 (jquery, ui, datepicker locale)
		 * 1 inline main icons, 1 window
		 * 1 manager, 1 inline manager, 1 manager plugin
		 */
		$this->assertEquals(8, self::$_view->headScript()->count());
		
		// jqueryui, main, icons
		$this->assertEquals(3, self::$_view->headLink()->count());
		
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		
		$render = Zend_Json::decode(self::$_manager->render(self::$_view));
		$this->assertArrayHasKey('objects', $render);
		$this->assertArrayHasKey('assets', $render);
		
		$this->assertArrayHasKey($window->getId(), $render['objects']);
		$this->assertArrayHasKey('render', $render['objects'][$window->getId()]);
		$this->assertArrayHasKey('options', $render['objects'][$window->getId()]);
		$this->assertArrayHasKey('class_name', $render['objects'][$window->getId()]);
		$this->assertTrue($render['objects'][$window->getId()]['is_window']);
		$this->assertEquals(10, $render['objects'][$window->getId()]['options']['position'][0]);
		
		$this->assertArrayHasKey($object->getId(), $render['objects']);
		$this->assertArrayHasKey('render', $render['objects'][$object->getId()]);
		$this->assertArrayHasKey('options', $render['objects'][$object->getId()]);
		$this->assertArrayHasKey('class_name', $render['objects'][$object->getId()]);
		$this->assertFalse($render['objects'][$object->getId()]['is_window']);
		
		unset($_SERVER['HTTP_X_REQUESTED_WITH']);
	}
	
}

class Gui_Windowing_ManagerTest_Manager extends Gui_Windowing_Manager{
	public function resetOpenedWindow(){
		$this->_openedWindows = null;
	}
	public function getSendedObjects(){
		return $this->_sendedObjects;
	}
	public static function getInstance(){
		return new Gui_Windowing_ManagerTest_Manager();
	}
}

class Ns_Windowing_ManagerTest_Window extends Gui_Windowing_Window{
}