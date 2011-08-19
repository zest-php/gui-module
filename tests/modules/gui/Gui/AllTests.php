<?php

/**
 * Hooks
 *	  setUpBeforeClass, setUp, assertPreConditions
 *	  # runTest #
 *	  assertPostConditions
 *	  tearDown, tearDownAfterClass
 *	  onNotSuccessfulTest
 */

/**
 * @category Gui
 * @package Gui
 * @subpackage UnitTests
 */
class Gui_AllTests{

	public static function main(){
//		// Run buffered tests as a separate suite first
//		ob_start();
//		PHPUnit_TextUI_TestRunner::run(self::suiteBuffered());
//		if(ob_get_level()){
//			ob_end_flush();
//		}

		PHPUnit_TextUI_TestRunner::run(self::suite());
	}

	/**
	 * Buffered test suites
	 *
	 * These tests require no output be sent prior to running as they rely
	 * on internal PHP functions.
	 *
	 * @return PHPUnit_Framework_TestSuite
	 */
	public static function suiteBuffered(){
		$suite = new PHPUnit_Framework_TestSuite('Gui Module - Gui - Buffered Test Suites');

		// // These tests require no output be sent prior to running as they rely
		// // on internal PHP functions
		// $suite->addTestSuite('Zend_OpenIdTest');
		// $suite->addTest(Zend_OpenId_AllTests::suite());
		// $suite->addTest(Zend_Session_AllTests::suite());
		// $suite->addTest(Zend_Soap_AllTests::suite());

		return $suite;
	}

	/**
	 * Regular suite
	 *
	 * All tests except those that require output buffering.
	 *
	 * @return PHPUnit_Framework_TestSuite
	 */
	public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('Gui Module - Gui');
		$suite->addTest(Gui_Form_AllTests::suite());
		$suite->addTest(Gui_Manager_AllTests::suite());
		$suite->addTest(Gui_Object_AllTests::suite());
		$suite->addTest(Gui_Widget_AllTests::suite());
		$suite->addTest(Gui_Windowing_AllTests::suite());
		$suite->addTestSuite('Gui_FormTest');
		$suite->addTestSuite('Gui_ManagerTest');
		$suite->addTestSuite('Gui_ObjectTest');
		$suite->addTestSuite('Gui_WidgetTest');
		return $suite;
	}
	
	public static function getDataDir(){
		return dirname(dirname(__FILE__)).'/data';
	}
	
//	public static function getTempDir(){
//		return rtrim(sys_get_temp_dir(), '/\\');
//	}

}

if(!defined('PHPUnit_MAIN_METHOD')){
	define('PHPUnit_MAIN_METHOD', 'Gui_AllTests::main');
}

if(PHPUnit_MAIN_METHOD == 'Gui_AllTests::main'){
	Gui_AllTests::main();
}
else{
	Gui_AllTests::suite();
}