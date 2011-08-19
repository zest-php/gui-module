<?php

/**
 * @category Gui
 * @package Gui_Windowing
 * @subpackage UnitTests
 */
class Gui_Windowing_Window_MainTest extends Gui_AbstractTest{
	
	public function testDefaultContentObject(){
		$main = Gui_Windowing_Manager::getInstance()->getMainWindow();
		$this->assertInstanceOf('Gui_Windowing_Window_Main_Icons', $main->getContentObject());
	}
	
	public function testRender(){
		$main = Gui_Windowing_Manager::getInstance()->getMainWindow();
		$main->render();
		
		// jquery-ui, main, icons
		$this->assertEquals(3, count(self::$_view->head()->css()));
		
		// 5 js dialog, 1 js icons, 1 js inline icons, 1 js window (il ne faut pas de .dialog() sur main)
		$this->assertEquals(8, self::$_view->headScript()->count());
	}
	
}