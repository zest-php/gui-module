<?php

/**
 * @category Gui
 * @package Gui_Widget
 * @subpackage UnitTests
 */
class Gui_Widget_DialogTest extends PHPUnit_Framework_TestCase{

	/**
	 * @var Gui_Widget_Dialog
	 */
	protected $_dialog = null;
	
	protected function setUp(){
		$this->_dialog = new Gui_Widget_Dialog();
	}
	
	public function testDefaultContentObject(){
		$this->assertInstanceOf('Gui_Object_Html', $this->_dialog->getContentObject());
	}
	
	public function testSetContentObject(){
		$accordion = new Gui_Widget_Accordion();
		$this->_dialog->setContentObject($accordion);
		$this->assertTrue($this->_dialog->getContentObject() === $accordion);
	}
	
	public function testCall(){
		// Gui_Object_Html
		$this->_dialog->setContent('testCall');
		
		// Gui_Widget_Accordion
		$this->_dialog->setContentObject(new Gui_Widget_Accordion());
		$this->_dialog->addSection();
	}
	
	public function testCallException(){
		$this->setExpectedException('Zest_Exception');
		$this->_dialog->testCallException();
	}
	
	public function testSetContentObjectException(){
		$this->setExpectedException('Zest_Exception');
		$this->_dialog->setContentObject(new stdClass());
	}
	
	public function testRenderDefault(){
		$this->_dialog->setContent('testRender');
		
		$xml = new SimpleXMLElement('<root>'.$this->_dialog->render().'</root>');
		
		$this->assertEquals($this->_dialog->getId(), (string) $xml->div[0]['id']);
		$this->assertEquals('gui-widget-dialog', (string) $xml->div[0]['class']);
		
		$this->assertEquals($this->_dialog->getContentObject()->getId(), (string) $xml->div[0]->div[0]['id']);
		$this->assertEquals('gui-object-html', (string) $xml->div[0]->div[0]['class']);
	}
	
	public function testRenderAccordion(){
		$accordion = new Gui_Widget_Accordion();
		
		$this->_dialog->setContentObject($accordion);
		$this->_dialog->addSection(array(
			'title' => 'testRenderAccordion',
			'contentViewScript' => 'widget/dialog/testRenderAccordion.phtml'
		));
		
		$xml = new SimpleXMLElement('<root>'.$this->_dialog->render().'</root>');
		
		$this->assertEquals($this->_dialog->getId(), (string) $xml->div[0]['id']);
		$this->assertEquals('gui-widget-dialog', (string) $xml->div[0]['class']);
		
		$this->assertEquals($this->_dialog->getContentObject()->getId(), (string) $xml->div[0]->div[0]['id']);
		$this->assertEquals('gui-widget-accordion', (string) $xml->div[0]->div[0]['class']);
	}
	
	public function testXhrMethods(){
		$this->assertTrue($this->_dialog->isXhrMethod('setPosition'));
		$this->assertTrue($this->_dialog->isXhrMethod('setSize'));
	}
	
	public function testGetOptions(){
		$this->_dialog->setParam('param', 1);
		$this->_dialog->setWidgetOption('position', 2);
		$this->_dialog->setWidgetOption('width', 3);
		$this->_dialog->setWidgetOption('height', 4);
		$this->assertEquals(array(
			'params' => array('param' => 1),
			'position' => 2,
			'width' => 3,
			'height' => 4
		), $this->_dialog->getOptions());
	}
	
	public function testSetPosition(){
		$this->_dialog->setPosition(10, 20);
		$this->assertEquals(array(10, 20), $this->_dialog->getWidgetOption('position'));
	}
	
	public function testSetLeft(){
		$this->_dialog->setLeft(10);
		$this->assertEquals(array(10, 0), $this->_dialog->getWidgetOption('position'));
	}
	
	public function testSetTop(){
		$this->_dialog->setTop(20);
		$this->assertEquals(array(0, 20), $this->_dialog->getWidgetOption('position'));
	}
	
	public function testSetSize(){
		$this->_dialog->setSize(100, 200);
		$this->assertEquals(100, $this->_dialog->getWidgetOption('width'));
		$this->assertEquals(200, $this->_dialog->getWidgetOption('height'));
	}
	
	public function testSetWidth(){
		$this->_dialog->setWidth(100);
		$this->assertEquals(100, $this->_dialog->getWidgetOption('width'));
	}
	
	public function testSetHeight(){
		$this->_dialog->setHeight(200);
		$this->assertEquals(200, $this->_dialog->getWidgetOption('height'));
	}
	
}