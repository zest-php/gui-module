<?php

/**
 * @category Gui
 * @package Gui_Windowing
 * @subpackage UnitTests
 */
class Gui_Windowing_Window_Main_AllTests{

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
		$suite = new PHPUnit_Framework_TestSuite('Gui Module - Gui_Windowing_Window_Main');
		$suite->addTestSuite('Gui_Windowing_Window_Main_IconsTest');
		return $suite;
	}

}

if(!defined('PHPUnit_MAIN_METHOD')){
	define('PHPUnit_MAIN_METHOD', 'Gui_Windowing_Window_Main_AllTests::main');
}

if(PHPUnit_MAIN_METHOD == 'Gui_Windowing_Window_Main_AllTests::main'){
	Gui_Windowing_Window_Main_AllTests::main();
}
else{
	Gui_Windowing_Window_Main_AllTests::suite();
}