<?php

/**
 * @category Gui
 * @package Gui_Widget
 * @subpackage UnitTests
 */
class Gui_Widget_ProgressbarTest extends PHPUnit_Framework_TestCase{

	/**
	 * @var Gui_Widget_Progressbar
	 */
	protected $_progressbar = null;
	
	protected function setUp(){
		$this->_progressbar = new Gui_Widget_Progressbar();
	}
	
	public function testRender(){
		$xml = new SimpleXMLElement('<root>'.$this->_progressbar->render().'</root>');
		
		$this->assertEquals($this->_progressbar->getId(), (string) $xml->div[0]['id']);
		$this->assertEquals('gui-widget-progressbar', (string) $xml->div[0]['class']);
	}
	
}