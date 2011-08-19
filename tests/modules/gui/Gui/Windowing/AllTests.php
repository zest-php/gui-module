<?php

/**
 * @category Gui
 * @package Gui_Windowing
 * @subpackage UnitTests
 */
class Gui_Windowing_AllTests{

	/**
	 * @return void
	 */
	public static function main(){
		PHPUnit_TextUI_TestRunner::run(self::suite());
	}

	/**
	 * @return PHPUnit_Framework_TestSuite
	 */
	public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('Gui Module - Gui_Windowing');
		$suite->addTest(Gui_Windowing_Window_AllTests::suite());
		$suite->addTest(Gui_Windowing_Frameset_AllTests::suite());
		$suite->addTestSuite('Gui_Windowing_FramesetTest');
		$suite->addTestSuite('Gui_Windowing_ManagerTest');
		$suite->addTestSuite('Gui_Windowing_WindowTest');
		return $suite;
	}

}

if(!defined('PHPUnit_MAIN_METHOD')){
	define('PHPUnit_MAIN_METHOD', 'Gui_Windowing_AllTests::main');
}

if(PHPUnit_MAIN_METHOD == 'Gui_Windowing_AllTests::main'){
	Gui_Windowing_AllTests::main();
}
else{
	Gui_Windowing_AllTests::suite();
}