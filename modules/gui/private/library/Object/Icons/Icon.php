<?php

/**
 * @category Gui
 * @package Gui_Object
 * @subpackage Icons
 */
class Gui_Object_Icons_Icon extends Gui_Object_Items_Item{
	
	/**
	 * @var string
	 */
	protected $_image = null;
	
	/**
	 * @var array
	 */
	protected $_url = null;
	
	/**
	 * @return string
	 */
	public function getImage(){
		return $this->_image;
	}
	
	/**
	 * @param string $image
	 * @return Gui_Object_Icons_Icon
	 */
	public function setImage($image){
		$this->_image = $image;
		return $this;
	}
	
	/**
	 * @param string|array $action
	 * @param string $controller
	 * @param string $module
	 * @return Gui_Object_Icons_Icon
	 */
	public function setUrl($action, $controller = null, $module = null){
		if(is_array($action)){
			extract($action);
		}
		$this->_url = array($action, $controller, $module);
		return $this;
	}
	
	/**
	 * @return array
	 */
	public function getUrl(){
		return $this->_url;
	}
	
}