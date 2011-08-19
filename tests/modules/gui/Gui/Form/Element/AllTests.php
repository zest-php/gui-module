<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage UnitTests
 */
class Gui_Form_Element_AllTests{

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
		$suite = new PHPUnit_Framework_TestSuite('Gui Module - Gui_Form_Element');
		$suite->addTestSuite('Gui_Form_Element_AutocompleteTest');
		$suite->addTestSuite('Gui_Form_Element_ButtonTest');
		$suite->addTestSuite('Gui_Form_Element_DatepickerTest');
		$suite->addTestSuite('Gui_Form_Element_ResetTest');
		$suite->addTestSuite('Gui_Form_Element_SliderTest');
		$suite->addTestSuite('Gui_Form_Element_SubmitTest');
		$suite->addTestSuite('Gui_Form_Element_WidgetTest');
		$suite->addTestSuite('Gui_Form_Element_WysiwygTest');
		return $suite;
	}

}

if(!defined('PHPUnit_MAIN_METHOD')){
	define('PHPUnit_MAIN_METHOD', 'Gui_Form_Element_AllTests::main');
}

if(PHPUnit_MAIN_METHOD == 'Gui_Form_Element_AllTests::main'){
	Gui_Form_Element_AllTests::main();
}
else{
	Gui_Form_Element_AllTests::suite();
}