<?php

/**
 * @category Gui
 * @package Gui_Windowing
 * @subpackage UnitTests
 */
class Gui_Windowing_Frameset_FrameTest extends PHPUnit_Framework_TestCase{

	/**
	 * @var Gui_Windowing_Frameset_Frame
	 */
	protected $_frame = null;
	
	protected function setUp(){
		$this->_frame = new Gui_Windowing_Frameset_Frame();
	}
	
	public function getContentObjectException(){
		$this->setExpectedException('Zest_Exception');
		$this->_frame->getContentObject();
	}
	
	public function testSetContentObject(){
		$accordion = new Gui_Widget_Accordion();
		$this->_frame->setContentObject($accordion);
		$this->assertTrue($this->_frame->getContentObject() === $accordion);
	}
	
	public function testCall(){
		$accordion = new Gui_Widget_Accordion();
		$this->_frame->setContentObject($accordion);
		$this->_frame->addSection();
		$this->assertEquals(1, count($accordion->getSections()));
	}
	
}