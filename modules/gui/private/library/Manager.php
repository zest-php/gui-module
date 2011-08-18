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
	 * @var Gui_Manager_Saver_Abstract
	 */
	protected $_saver = null;
	
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
	 * @return Gui_Manager_Saver_Abstract
	 */
	public function getSaver(){
		if(is_null($this->_saver)){
			$this->_saver = new Gui_Manager_Saver_Session();
		}
		return $this->_saver;
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
	
	/**
	 * @param string $class
	 * @param array $options
	 * @return Gui_Object
	 */
	public function get($class, array $options = array()){
		return $this->getLoader()->getObject($class, $options);
	}
	
	/**
	 * @param string $module
	 * @return string
	 */
	public function getViewGuiDir($module){
		$controller = Zest_Controller_Front::getInstance();
		return $controller->getModuleDirectory($module).'/views/gui';
	}
	
	/**
	 * @param string $config
	 * @param string $sprintf
	 * @return string
	 */
	public function getConfigUrl($config, $sprintf = null){
		$url = dirname($this->getUrl()).'/'.$this->getConfig($config);
		if($sprintf){
			$url = sprintf($url, $sprintf);
		}
		return $url;
	}
	
	/**
	 * @param string $config
	 * @param string $sprintf
	 * @return string
	 */
	public function getConfigDirectory($config, $sprintf = null){
		$url = dirname($this->getDirectory()).'/'.$this->getConfig($config);
		if($sprintf){
			$url = sprintf($url, $sprintf);
		}
		return $url;
	}
	
}