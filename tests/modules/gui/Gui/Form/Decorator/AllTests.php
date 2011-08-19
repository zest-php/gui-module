<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage UnitTests
 */
class Gui_Form_Decorator_AllTests{

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
		$suite = new PHPUnit_Framework_TestSuite('Gui Module - Gui_Form_Decorator');
		$suite->addTestSuite('Gui_Form_Decorator_ViewHelperTest');
		return $suite;
	}

}

if(!defined('PHPUnit_MAIN_METHOD')){
	define('PHPUnit_MAIN_METHOD', 'Gui_Form_Decorator_AllTests::main');
}

if(PHPUnit_MAIN_METHOD == 'Gui_Form_Decorator_AllTests::main'){
	Gui_Form_Decorator_AllTests::main();
}
else{
	Gui_Form_Decorator_AllTests::suite();
}