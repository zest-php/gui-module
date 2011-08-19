<?php

/**
 * @category Gui
 * @package Gui_Widget
 * @subpackage UnitTests
 */
class Gui_Widget_AccordionTest extends Gui_AbstractTest{

	/**
	 * @var Gui_Widget_Accordion
	 */
	protected $_accordion = null;
	
	protected function setUp(){
		parent::setUp();
		$this->_accordion = new Gui_Widget_Accordion();
	}
	
	public function testAddSectionSectionObject(){
		$section = new Gui_Widget_Accordion_Section();
		$this->_accordion->addSection($section);
		list($s) = $this->_accordion->getSections();
		$this->assertTrue($section === $s);
	}
	
	public function testAddSectionNoArgs(){
		$this->_accordion->addSection();
		list($section) = $this->_accordion->getSections();
		$this->assertInstanceOf('Gui_Widget_Accordion_Section', $section);
	}
	
	public function testAddSectionArray(){
		$this->_accordion->addSection(array('title' => 'testAddSectionArray'));
		list($section) = $this->_accordion->getSections();
		$this->assertInstanceOf('Gui_Widget_Accordion_Section', $section);
		$this->assertEquals('testAddSectionArray', $section->getTitle());
	}
	
	public function testAddSectionClassName(){
		$this->_accordion->addSection(new Gui_Widget_AccordionTest_Section(), array('title' => 'testAddSectionClassName'));
		list($section) = $this->_accordion->getSections();
		$this->assertInstanceOf('Gui_Widget_AccordionTest_Section', $section);
		$this->assertEquals('testAddSectionClassName', $section->getTitle());
	}
	
	public function testAddSectionNoSectionObject(){
		$this->setExpectedException('Zest_Exception');
		$this->_accordion->addSection(new Gui_Widget_AccordionTest_SectionException());
	}
	
	public function testAddSectionNoSectionObjectString(){
		$this->setExpectedException('Zest_Exception');
		$this->_accordion->addSection('Gui_Widget_AccordionTest_SectionException');
	}
	
	public function testSetSections(){
		$this->_accordion->setSections(array(
			new Gui_Widget_Accordion_Section(array('title' => 'title 1')),
			'Ns_Widget_AccordionTest_Section' => array('title' => 'title 2')
		));
		$titles = array();
		foreach($this->_accordion as $section){
			$titles[] = $section->getTitle();
		}
		$this->assertEquals(array('title 1', 'title 2'), $titles);
	}
	
	public function testIterator(){
		$this->_accordion->addSection();
		$this->_accordion->addSection();
		$count = 0;
		foreach($this->_accordion as $section){
			$count++;
		}
		$this->assertEquals(2, $count);
	}
	
	public function testRender(){
		$this->_accordion->addSection(array(
			'title' => 'testRender title',
			'content' => 'testRender content'
		));
		list($section) = $this->_accordion->getSections();
		
		$xml = new SimpleXMLElement('<root>'.$this->_accordion->render().'</root>');
		
		// accordion
		$this->assertEquals($this->_accordion->getId(), (string) $xml->div[0]['id']);
		$this->assertEquals('gui-widget-accordion', (string) $xml->div[0]['class']);
		
		// section
		$this->assertEquals($section->getId().'-title', (string) $xml->div[0]->h3[0]['id']);
		$this->assertEquals($section->getId().'-content', (string) $xml->div[0]->div[0]['id']);
		
		$this->assertEquals('testRender title', (string) $xml->div[0]->h3[0]->a[0]);
		$this->assertEquals('testRender content', (string) $xml->div[0]->div[0]);
	}
	
}

class Gui_Widget_AccordionTest_Section extends Gui_Widget_Accordion_Section{
}

class Ns_Widget_AccordionTest_Section extends Gui_Widget_Accordion_Section{
}

class Gui_Widget_AccordionTest_SectionException{
}