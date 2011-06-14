<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage Element
 */
abstract class Gui_Form_Element_Wysiwyg_Abstract{
	
	/**
	 * @var Zend_View_Interface
	 */
	protected $_view = null;
	
	/**
	 * @var Zest_Module_Manager
	 */
	protected $_manager = null;
	
	/**
	 * @var Zend_Form_Element
	 */
	protected $_element = null;
	
	/**
	 * @param Zend_Form_Element $element
	 * @return void
	 */
	public function __construct(Zend_Form_Element $element){
		$this->_element = $element;
		$this->_manager = Gui_Manager::getInstance();
	}
	
	/**
	 * @return string
	 */
	public function getName(){
		return substr(strrchr(get_class($this), '_'), 1);
	}
	
	/**
	 * @param string $name
	 * @param mixed $value
	 * @return Gui_Form_Element_Wysiwyg_Abstract
	 */
	public function setOption($name, $value){
		$this->_options[$name] = $value;
		return $this;
	}
	
	/**
	 * @param array $options
	 * @return Gui_Form_Element_Wysiwyg_Abstract
	 */
	public function setOptions(array $options){
		foreach($options as $key => $value){
			$this->setOption($key, $value);
		}
		return $this;
	}
	
	/**
	 * @return string
	 */
	protected function _getJsonOptions(){
		if($this->_options){
			return Zend_Json::encode($this->_options);
		}
		else{
			return '{}';
		}
	}
	
	/**
	 * @param Zend_View_Interface $view
	 * @return Gui_Form_Element_Wysiwyg_Abstract
	 */
	public function setView(Zend_View_Interface $view){
		$this->_view = $view;
		return $this;
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
	 * @return void
	 */
	public function render(Zend_View_Interface $view = null){
		if(!is_null($view)){
			$this->setView($view);
		}
		
		$url = dirname($this->_manager->getUrl()).'/'.$this->_manager->getConfig('url.'.strtolower($this->getName()));
		$this->getView()->head()->js($url);
	}
	
}