<?php

/**
 * @category Gui
 * @package Gui_Manager
 * @subpackage UnitTests
 */
class Gui_Manager_AllTests{

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
		$suite = new PHPUnit_Framework_TestSuite('Gui Module - Gui_Manager');
		$suite->addTestSuite('Gui_Manager_LoaderTest');
		$suite->addTestSuite('Gui_Manager_SaverTest');
		return $suite;
	}

}

if(!defined('PHPUnit_MAIN_METHOD')){
	define('PHPUnit_MAIN_METHOD', 'Gui_Manager_AllTests::main');
}

if(PHPUnit_MAIN_METHOD == 'Gui_Manager_AllTests::main'){
	Gui_Manager_AllTests::main();
}
else{
	Gui_Manager_AllTests::suite();
}