<?php

/**
 * @category Gui
 * @package Gui_Object
 * @subpackage Items
 */
abstract class Gui_Object_Items_Item extends Gui_Object{
	
	/**
	 * @var string
	 */
	protected $_label = null;
	
	/**
	 * @return string
	 */
	public function getLabel(){
		return $this->_label;
	}
	
	/**
	 * @param string $label
	 * @return Gui_Object_Icons_Icon
	 */
	public function setLabel($label){
		$this->_label = $label;
		return $this;
	}
	
	/**
	 * @return string|integer
	 */
	public function getId(){
		if(is_null($this->_id)){
			throw new Zest_Exception('Un item doit avoir un id.');
		}
		return parent::getId();
	}
	
	/**
	 * @param string|integer $id
	 * @return Gui_Object_Items_Item
	 */
	public function setId($id){
		$this->_id = $id;
		return $this;
	}
	
}