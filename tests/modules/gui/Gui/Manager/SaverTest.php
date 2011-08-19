<?php

/**
 * @category Gui
 * @package Gui_Manager
 * @subpackage UnitTests
 */
class Gui_Manager_SaverTest extends PHPUnit_Framework_TestCase{
	
	/**
	 * @var Gui_Manager_Saver_Abstract
	 */
	protected $_saver = null;
	
	protected function setUp(){
		$this->_saver = new Gui_Manager_Saver_Session();
	}
	
	public function testEmpty(){
	}
	
}