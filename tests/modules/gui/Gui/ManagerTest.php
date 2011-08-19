<?php

/**
 * @category Gui
 * @subpackage UnitTests
 */
class Gui_ManagerTest extends Gui_AbstractTest{
	
	/**
	 * @var Gui_Manager
	 */
	protected $_manager = null;
	
	protected function setUp(){
		parent::setUp();
		$this->_manager = Gui_Manager::getInstance();
	}
	
	public function testDefaultLoader(){
		$this->assertInstanceOf('Gui_Manager_Loader', $this->_manager->getLoader());
	}
	
	public function testDefaultSaver(){
		$this->assertInstanceOf('Gui_Manager_Saver_Session', $this->_manager->getSaver());
	}
	
	public function testGetViewDir(){
		$this->assertRegExp('#system/modules/gui/private/views/gui$#', $this->_manager->getViewGuiDir('gui'));
	}
	
	public function testGetConfigUrl(){
		$this->assertRegExp('#system/modules/gui/public/js/gui/%s$#', $this->_manager->getConfigUrl('url.gui.js'));
		$this->assertRegExp('#system/modules/gui/public/js/gui/testGetConfigUrl$#', $this->_manager->getConfigUrl('url.gui.js', 'testGetConfigUrl'));
	}
	
	public function testGetConfigDirectory(){
		$start = implode(DIRECTORY_SEPARATOR, array_slice(explode(DIRECTORY_SEPARATOR, __FILE__), 0, 2));
		$this->assertRegExp('#^'.preg_quote($start).'#', $this->_manager->getConfigDirectory('url.gui.js'));
		$this->assertRegExp('#system/modules/gui/public/js/gui/%s$#', $this->_manager->getConfigDirectory('url.gui.js'));
		$this->assertRegExp('#system/modules/gui/public/js/gui/testGetConfigUrl$#', $this->_manager->getConfigDirectory('url.gui.js', 'testGetConfigUrl'));
	}
	
	public function testViewScriptPaths(){
		$scriptPaths = self::$_view->getScriptPaths();
		$this->assertEquals($this->_manager->getDirectory().'/views/scripts/', end($scriptPaths));
	}
	
	public function testViewHelperPaths(){
		$helperPaths = self::$_view->getHelperPaths();
		$this->assertArrayHasKey('Gui_View_Helper_', $helperPaths);
		$this->assertEquals($this->_manager->getDirectory().'/views/helpers/', $helperPaths['Gui_View_Helper_'][0]);
	}
	
}