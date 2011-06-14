<?php

/**
 * @category Gui
 * @package Gui_Widget
 * @subpackage Tabs
 */
class Gui_Widget_Tabs_Tab extends Gui_Object_Html{
	
	/**
	 * @var string
	 */
	protected $_title = null;
	
	/**
	 * @var string
	 */
	protected $_url = null;
	
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
	 * @return Gui_Widget_Tabs_Tab
	 */
	public function setTitle($title){
		$this->_title = $title;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getUrl(){
		return $this->_url;
	}
	
	/**
	 * @param string $url
	 * @return Gui_Object_Html
	 */
	public function setUrl($url){
		$this->_url = $url;
		return $this;
	}
	
}