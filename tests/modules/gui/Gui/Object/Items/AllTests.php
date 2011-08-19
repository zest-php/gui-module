<?php

/**
 * @category Gui
 * @package Gui_Object
 * @subpackage UnitTests
 */
class Gui_Object_Items_AllTests{

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
		$suite = new PHPUnit_Framework_TestSuite('Gui Module - Gui_Object_Items');
		$suite->addTestSuite('Gui_Object_Items_ItemTest');
		return $suite;
	}

}

if(!defined('PHPUnit_MAIN_METHOD')){
	define('PHPUnit_MAIN_METHOD', 'Gui_Object_Items_AllTests::main');
}

if(PHPUnit_MAIN_METHOD == 'Gui_Object_Items_AllTests::main'){
	Gui_Object_Items_AllTests::main();
}
else{
	Gui_Object_Items_AllTests::suite();
}