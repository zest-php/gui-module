<?php

/**
 * @category Gui
 * @package Gui_Manager
 * @subpackage Saver
 */
class Gui_Manager_Saver_Session extends Gui_Manager_Saver_Abstract{
	
	/**
	 * @var Zend_Session_Namespace
	 */
	protected $_session = null;
	
	/**
	 * @return void
	 */
	public function __construct(){
		$this->_session = new Zend_Session_Namespace('Gui_Manager_Saver_Session');
	}
	
	/**
	 * @param string $owner
	 * @param string $key
	 * @param mixed $data
	 * @return Gui_Manager_Saver_Abstract
	 */
	public function save($owner, $key, $data){
		$session = $this->_session->$owner;
		if(!$session){
			$session = array();
		}
		$session[$key] = $data;
		$this->_session->$owner = $session;
		return $this;
	}
	
	/**
	 * @param string $owner
	 * @param string $key
	 * @return mixed
	 */
	public function load($owner, $key){
		$session = $this->_session->$owner;
		if($session && isset($session[$key])){
			return $session[$key];
		}
		return null;
	}
	
}