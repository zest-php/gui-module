<?php

/**
 * @category Gui
 * @package Gui_Windowing
 * @subpackage UnitTests
 */
class Gui_Windowing_Window_Main_IconsTest extends Gui_AbstractTest{
	
	protected static $_moduleName = 'windowing';
	
	public static function setUpBeforeClass(){
		parent::setUpBeforeClass();
		
		$front = Zest_Controller_Front::getInstance();
		$front->addControllerDirectory(Gui_AllTests::getDataDir().'/'.self::$_moduleName.'/controllers', self::$_moduleName);
	}
	
	public function testGetIcons(){
		$icons = Gui_Windowing_Manager::getInstance()->getMainWindow()->getContentObject();
		$this->assertEquals(2, count($icons->getItems()));
	}
	
	public function testClick(){
		$icons = Gui_Windowing_Manager::getInstance()->getMainWindow()->getContentObject();
		$icons->click(self::$_moduleName.'-1');
		$front = Zest_Controller_Front::getInstance();
		$this->assertEquals('ok', $front->getResponse()->getBody('testClickAction'));
	}
	
	public function testClickException(){
		$this->setExpectedException('Zest_Exception');
		$icons = Gui_Windowing_Manager::getInstance()->getMainWindow()->getContentObject();
		$icons->click(self::$_moduleName.'-2');
	}
	
	public function testGetViewScript(){
		$icons = Gui_Windowing_Manager::getInstance()->getMainWindow()->getContentObject();
		
		// ne doit pas être gui/windowing/window/main/icons.phtml
		$this->assertEquals('gui/object/icons.phtml', $icons->getViewScript());
	}
	
}