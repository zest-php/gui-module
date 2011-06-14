<?php

/**
 * @category Gui
 * @package Gui_Manager
 */
class Gui_Manager extends Zest_Module_Manager{
	
	/**
	 * @var Gui_Manager
	 */
	protected static $_instance = null;
	
	/**
	 * @var Gui_Manager_Loader
	 */
	protected $_loader = null;
	
	/**
	 * @return void
	 */
	protected function __construct(){
		$view = Zest_View::getStaticView();
		
		$scriptPaths = $view->getScriptPaths();
		$scriptPaths[] = $this->getDirectory().'/views/scripts';
		$scriptPaths = array_reverse($scriptPaths);
		
		$view->setScriptPath(array_shift($scriptPaths));
		foreach($scriptPaths as $scriptPath){
			$view->addScriptPath($scriptPath);
		}
		
		$view->addHelperPath($this->getDirectory().'/views/helpers', 'Gui_View_Helper');
	}
	
	/**
	 * @return Gui_Manager
	 */
	public static function getInstance(){
		if(is_null(self::$_instance)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * @param string $module
	 * @param string $resourceType
	 * @return Gui_Manager
	 */
	public function addModuleResourceType($module, $resourceType){
		$this->getLoader()->addModuleResourceType($module, $resourceType);
		return $this;
	}
	
	/**
	 * @param string $class
	 * @return Gui_Object
	 */
	public function get($class){
		return $this->getLoader()->getObject($class);
	}
	
	/**
	 * @return Gui_Manager_Loader
	 */
	public function getLoader(){
		if(is_null($this->_loader)){
			$this->_loader = new Gui_Manager_Loader($this);
		}
		return $this->_loader;
	}
	
}