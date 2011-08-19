<?php

/**
 * @category Gui
 * @package Gui_Windowing
 * @subpackage UnitTests
 */
class Gui_Windowing_Frameset_AllTests{

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
		$suite = new PHPUnit_Framework_TestSuite('Gui Module - Gui_Windowing_Frameset');
		$suite->addTestSuite('Gui_Windowing_Frameset_FrameTest');
		return $suite;
	}

}

if(!defined('PHPUnit_MAIN_METHOD')){
	define('PHPUnit_MAIN_METHOD', 'Gui_Windowing_Frameset_AllTests::main');
}

if(PHPUnit_MAIN_METHOD == 'Gui_Windowing_Frameset_AllTests::main'){
	Gui_Windowing_Frameset_AllTests::main();
}
else{
	Gui_Windowing_Frameset_AllTests::suite();
}