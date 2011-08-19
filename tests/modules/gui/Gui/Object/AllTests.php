<?php

/**
 * @category Gui
 * @package Gui_Object
 * @subpackage UnitTests
 */
class Gui_Object_AllTests{

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
		$suite = new PHPUnit_Framework_TestSuite('Gui Module - Gui_Object');
		$suite->addTest(Gui_Object_Icons_AllTests::suite());
		$suite->addTest(Gui_Object_Items_AllTests::suite());
		$suite->addTestSuite('Gui_Object_HtmlTest');
		$suite->addTestSuite('Gui_Object_IconsTest');
		$suite->addTestSuite('Gui_Object_ItemsTest');
		return $suite;
	}

}

if(!defined('PHPUnit_MAIN_METHOD')){
	define('PHPUnit_MAIN_METHOD', 'Gui_Object_AllTests::main');
}

if(PHPUnit_MAIN_METHOD == 'Gui_Object_AllTests::main'){
	Gui_Object_AllTests::main();
}
else{
	Gui_Object_AllTests::suite();
}