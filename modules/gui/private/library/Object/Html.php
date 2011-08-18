<?php

/**
 * @category Gui
 * @package Gui_Object
 */
class Gui_Object_Html extends Gui_Object{
	
	/**
	 * @var string
	 */
	protected $_content = null;
	
	/**
	 * @var string
	 */
	protected $_contentViewScript = null;
	
	/**
	 * @return string
	 */
	public function getContent(){
		return $this->_content;
	}
	
	/**
	 * @param string $content
	 * @return Gui_Object_Html
	 */
	public function setContent($content){
		$this->_content = $content;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getContentViewScript(){
		if(is_null($this->_contentViewScript)){
			$this->_initLastInNamespace();
			if(count($this->_lastsInNamespaces) == 1){
				throw new Zest_Exception(sprintf('Aucun script de vue renseigné pour l\'objet "%s".', get_class($this)));
			}
			$this->_contentViewScript = $this->_script('-content.phtml');
		}
		return $this->_contentViewScript;
	}
	
	/**
	 * @param string $contentViewScript
	 * @return Gui_Object_Html
	 */
	public function setContentViewScript($contentViewScript){
		$this->_contentViewScript = $contentViewScript;
		return $this;
	}
	
	/**
	 * @param Zend_View_Interface $view
	 * @return string
	 */
	public function renderContent($view = null){
		if(!is_null($view)){
			$this->setView($view);
		}
		if(is_null($this->_content)){
			$this->_content = $this->_render($this->getContentViewScript());
		}
		return $this->_content;
	}
	
}