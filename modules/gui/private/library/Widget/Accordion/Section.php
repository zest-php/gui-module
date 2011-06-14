<?php

/**
 * @category Gui
 * @package Gui_Widget
 * @subpackage Accordion
 */
class Gui_Widget_Accordion_Section extends Gui_Object_Html{
	
	/**
	 * @var string
	 */
	protected $_title = null;
	
	/**
	 * @return string
	 */
	public function getTitle(){
		if(is_null($this->_title)){
			return '&nbsp;';
		}
		return $this->_title;
	}
	
	/**
	 * @param string $title
	 * @return Gui_Widget_Accordion_Section
	 */
	public function setTitle($title){
		$this->_title = $title;
		return $this;
	}
	
}