<?php

class Loader_Model_TestGetObject extends Gui_Object{
	
	protected $_arg = null;
	
	public function setArg($arg){
		$this->_arg = $arg;
	}
	
	public function getArg(){
		return $this->_arg;
	}
	
}