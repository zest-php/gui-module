<?php

/**
 * @category Gui
 * @package Gui_Windowing
 * @subpackage UnitTests
 */
class Gui_Windowing_FramesetTest extends PHPUnit_Framework_TestCase{

	/**
	 * @var Gui_Windowing_Frameset
	 */
	protected $_frameset = null;
	
	protected function setUp(){
		$this->_frameset = new Gui_Windowing_Frameset();
	}
	
	public function testAddFrameFrameObject(){
		$frame = new Gui_Windowing_Frameset_Frame();
		$this->_frameset->addFrame($frame);
		list($s) = $this->_frameset->getFrames();
		$this->assertTrue($frame === $s);
	}
	
	public function testAddFrameNoArgs(){
		$this->_frameset->addFrame();
		list($frame) = $this->_frameset->getFrames();
		$this->assertInstanceOf('Gui_Windowing_Frameset_Frame', $frame);
	}
	
	public function testAddFrameArray(){
		$this->_frameset->addFrame(array('label' => 'testAddItemArray'));
		list($frame) = $this->_frameset->getFrames();
		$this->assertInstanceOf('Gui_Windowing_Frameset_Frame', $frame);
	}
	
	public function testAddFrameClassName(){
		$this->_frameset->addFrame(new Gui_Windowing_FramesetTest_Frame(), array('label' => 'testAddFrameClassName'));
		list($frame) = $this->_frameset->getFrames();
		$this->assertInstanceOf('Gui_Windowing_Frameset_Frame', $frame);
		$this->assertEquals('testAddFrameClassName', $frame->getLabel());
	}
	
	public function testAddFrameNoFrameObject(){
		$this->setExpectedException('Zest_Exception');
		$this->_frameset->addFrame(new Gui_Windowing_FramesetTest_FrameException());
	}
	
	public function testAddFrameNoFrameObjectString(){
		$this->setExpectedException('Zest_Exception');
		$this->_frameset->addFrame('Gui_Windowing_FramesetTest_FrameException');
	}
	
}

class Gui_Windowing_FramesetTest_Frame extends Gui_Windowing_Frameset_Frame{
	protected $_label = null;
	public function setLabel($label){
		$this->_label = $label;
	}
	public function getLabel(){
		return $this->_label;
	}
}

class Gui_Windowing_FramesetTest_FrameException{
}