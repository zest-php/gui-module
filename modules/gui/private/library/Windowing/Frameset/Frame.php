<?php

/**
 * @category Gui
 * @package Gui_Frameset
 */
class Gui_Windowing_Frameset_Frame extends Gui_Object{
	
	/**
	 * @var Gui_Object
	 */
	protected $_contentObject = null;
	
	/**
	 * @return Gui_Object
	 */
	public function getContentObject(){
		if(is_null($this->_contentObject)){
			throw new Zest_Exception('Aucun objet de contenu renseigné.');
		}
		return $this->_contentObject;
	}
	
	/**
	 * @param Gui_Object|string $contentObject
	 * @return Gui_Object
	 */
	public function setContentObject($contentObject){
		if(is_string($contentObject)){
			$contentObject = $this->_manager->get($contentObject);
		}
		if(!$contentObject instanceof Gui_Object){
			throw new Zest_Exception('L\'objet de contenu doit être une instance de Gui_Object.');
		}
		$this->_contentObject = $contentObject;
	}
	
	/**
	 * @param string $method
	 * @param array $args
	 * @return mixed
	 */
	public function __call($method, $args){
		$object = $this->getContentObject();
		if(method_exists($object, $method)){
			return call_user_func_array(array($object, $method), $args);
		}
		throw new Zest_Exception(sprintf('La méthode "%s" n\'existe pas.', $method));
	}
	
}