<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage Element
 */
class Gui_Form_Element_Wysiwyg extends Gui_Form_Element{
	
	/**
	 * @var string
	 */
	public $helper = 'formTextarea';
	
	/**
	 * @var Gui_Form_Element_Wysiwyg_Abstract
	 */
	protected $_adapter = null;
	
	/**
	 * @param string|Gui_Form_Element_Wysiwyg_Abstract $adapter
	 * @return Gui_Form_Element_Wysiwyg
	 */
	public function setAdapter($adapter){
		if(is_string($adapter)){
			$adapter = 'Gui_Form_Element_Wysiwyg_'.$adapter;
			$adapter = new $adapter($this);
		}
		if(!$adapter instanceof Gui_Form_Element_Wysiwyg_Abstract){
			throw new Zest_Exception('L\'adaptateur doit être une instance de Gui_Form_Element_Wysiwyg_Abstract.');
		}
		$this->_adapter = $adapter;
		return $this;
	}
	
	/**
	 * @return Gui_Form_Element_Wysiwyg_Abstract
	 */
	public function getAdapter(){
		if(!$this->_adapter){
			throw new Zest_Exception('L\'adaptateur doit être défini.');
		}
		return $this->_adapter;
	}
	
	/**
	 * @param string $name
	 * @param mixed $value
	 * @return Gui_Form_Element_Wysiwyg
	 */
	public function setAdapterOption($name, $value){
		$this->getAdapter()->setOption($name, $value);
	}
	
	/**
	 * @param array $options
	 * @return Gui_Form_Element_Wysiwyg
	 */
	public function setAdapterOptions(array $options){
		$this->getAdapter()->setOptions($options);
		return $this;
	}
	
	/**
	 * @param Zend_View_Interface $view
	 * @return string
	 */
	public function render(Zend_View_Interface $view = null){
		return str_replace('</textarea>', '</textarea>'.$this->getAdapter()->render($view), parent::render($view));
	}
	
}