<?php

/**
 * @category Gui
 * @package Gui_Widget
 * @subpackage UnitTests
 */
class Gui_Widget_AllTests{

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
		$suite = new PHPUnit_Framework_TestSuite('Gui Module - Gui_Widget');
		$suite->addTestSuite('Gui_Widget_AccordionTest');
		$suite->addTestSuite('Gui_Widget_DialogTest');
		$suite->addTestSuite('Gui_Widget_ProgressbarTest');
		$suite->addTestSuite('Gui_Widget_TabsTest');
		return $suite;
	}

}

if(!defined('PHPUnit_MAIN_METHOD')){
	define('PHPUnit_MAIN_METHOD', 'Gui_Widget_AllTests::main');
}

if(PHPUnit_MAIN_METHOD == 'Gui_Widget_AllTests::main'){
	Gui_Widget_AllTests::main();
}
else{
	Gui_Widget_AllTests::suite();
}