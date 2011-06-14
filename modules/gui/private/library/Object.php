<?php

/**
 * @category Gui
 * @package Gui_Object
 */
abstract class Gui_Object{
	
	/**
	 * @var Gui_Manager
	 */
	protected $_manager = null;
	
	/**
	 * @var Zend_View_Interface
	 */
	protected $_view = null;
	
	/**
	 * @var string
	 */
	protected $_id = null;
	
	/**
	 * @var array
	 */
	protected $_lastsInNamespaces = null;
	
	/**
	 * @var array
	 */
	protected $_vars = array();
	
	/**
	 * @return void
	 */
	public function __construct(array $options = array()){
		$this->_manager = Gui_Manager::getInstance();
		$this->setOptions($options);
	}
	
	/**
	 * @param array $options
	 * @return Gui_Object
	 */
	public function setOptions(array $options){
		foreach($options as $key => $value){
			$key = ucwords(str_replace('_', ' ', $key));
			$method = 'set'.str_replace(' ', '', $key);
			if(method_exists($this, $method)){
				$this->$method($value);
			}
		}
		return $this;
	}
	
	/**
	 * @return void
	 */
	protected function _initLastInNamespace(){
		if(is_null($this->_lastsInNamespaces)){
			$this->_lastsInNamespaces = array();
			$classTree = $this->_manager->getLoader()->getClassTree(get_class($this));
			foreach(array_reverse($classTree) as $className){
				$pos = strpos($className, '_');
				$namespace = substr($className, 0, $pos);
				$this->_lastsInNamespaces[$namespace] = $className;
			}
			$this->_lastsInNamespaces = array_reverse($this->_lastsInNamespaces);
		}
	}
	
	/**
	 * @return string
	 */
	public function getId(){
		if(is_null($this->_id)){
			$this->_initLastInNamespace();
			if(count($this->_lastsInNamespaces) == 1){
				// utilisation direct d'un objet Gui
				$this->_id = 'gui-object-' . mt_rand();
			}
			else{
				// le namespace juste avant Gui
				end($this->_lastsInNamespaces);
				$prevLast = prev($this->_lastsInNamespaces);
				$this->_id = strtolower(str_replace('_', '-', $prevLast));
			}
		}
		return $this->_id;
	}
	
	/**
	 * @return Gui_Object
	 */
	public function assign($name, $value = null){
		if(is_string($name)){
			$this->_vars[$name] = $value;
		}
		else if(is_array($name)){
			foreach($name as $key => $value){
				$this->assign($key, $value);
			}
		}
		else{
			throw new Zest_Exception(sprintf('La méthode "assign" attend un type array ou string (%s).', gettype($name)));
		}
		return $this;
	}
	
	/**
	 * @return array
	 */
	public function getVars(){
		return $this->_vars;
	}
	
	/**
	 * @return Gui_Object
	 */
	public function clearVars(){
		$this->_vars = array();
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getViewScript(){
		return $this->_getViewScript('.phtml');
	}
	
	/**
	 * @param string $suffix
	 * @return string
	 */
	protected function _getViewScript($suffix){
		$this->_initLastInNamespace();
		$scriptPaths = $this->getView()->getScriptPaths();
		
		$viewScript = null;
		$defaultViewScript = null;
		foreach($this->_lastsInNamespaces as $namespace => $class){
			$viewScript = ($namespace == 'Gui' ? '' : 'gui/').str_replace('_', '/', strtolower($class)).$suffix;
			if(!$defaultViewScript){
				$defaultViewScript = $viewScript;
			}
			foreach($scriptPaths as $scriptPath){
				if(file_exists($scriptPath.$viewScript)){
					return $viewScript;
				}
			}
		}
		return $defaultViewScript;
	}
	
	/**
	 * @return Zend_View_Interface
	 */
	public function getView(){
		if(is_null($this->_view)){
			$this->setView(Zest_View::getStaticView());
		}
		return $this->_view;
	}
	
	/**
	 * @param Zend_View_Interface $view
	 * @return Gui_Object
	 */
	public function setView(Zend_View_Interface $view = null){
		$this->_view = $view;
		return $this;
	}
	
	/**
	 * @param Zend_View_Interface $view
	 * @return string
	 */
	public function render($view = null){
		if(!is_null($view)){
			$this->setView($view);
		}
		return $this->_render($this->getViewScript());
	}
	
	/**
	 * @param Zend_View_Interface $view
	 * @param string $viewScript
	 * @return string
	 */
	protected function _render($viewScript){
		return $this->getView()->partial($viewScript, array_merge($this->getVars(), array('object' => $this)));
	}
	
}