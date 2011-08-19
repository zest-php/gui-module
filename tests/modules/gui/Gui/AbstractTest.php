<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage UnitTests
 */
class Gui_AbstractTest extends PHPUnit_Framework_TestCase{
	
	/**
	 * @var string
	 */
	protected static $_environment = 'test';
	
	/**
	 * @var Zest_View
	 */
	protected static $_view = null;
	
	public static function setUpBeforeClass(){
		if(!is_null(self::$_view)) return;
		
		// vue
		self::$_view = Zest_View::getStaticView();
		self::$_view->setDoctype('xhtml1_transitional');
		self::$_view->addHelperPath(MODULE_PATH.'/views/helpers', 'Gui_View_Helper');
		self::$_view->addScriptPath(Gui_AllTests::getDataDir());
		
		// front controller
		$front = Zest_Controller_Front::getInstance();
		$front->getRouter()->addDefaultRoutes();
		$front->setRequest(new Zend_Controller_Request_Http());
		$front->setResponse(new Zend_Controller_Response_Http());
		$front->addControllerDirectory(MODULE_PATH.'/controllers', 'gui');
		$front->setRequest(new Zend_Controller_Request_Http());
		
		// configuration
		$options = array(
			'pathname' => self::_getPathname(),
			'modules_config_format' => '/configs/module.ini'
		);
		Zest_Config_Application::initInstance(self::$_environment, $options, 'Gui_Form_Element_ButtonTest_GetModulesDirectories');
		
		// init view paths
		Gui_Manager::getInstance();
	}
	
	protected static function _getPathname(){
		return Gui_AllTests::getDataDir().'/application.ini';
	}
	
	protected function setUp(){
		self::$_view->jquery()->reset();
		$this->_unsetAll(self::$_view->headLink());
		$this->_unsetAll(self::$_view->headScript());
	}
	
	protected function _unsetAll($arrayObject){
		$offsets = array();
		foreach($arrayObject as $offset => $value){
			$offsets[] = $offset;
		}
		foreach($offsets as $offset){
			unset($arrayObject[$offset]);
		}
	}
	
}

if(!function_exists('Gui_Form_Element_ButtonTest_GetModulesDirectories')){
	function Gui_Form_Element_ButtonTest_GetModulesDirectories(){
		return array(
			'gui' => MODULE_PATH
		);
	}
}