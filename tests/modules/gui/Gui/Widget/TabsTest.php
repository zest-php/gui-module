<?php

/**
 * @category Gui
 * @package Gui_Widget
 * @subpackage UnitTests
 */
class Gui_Widget_TabsTest extends Gui_AbstractTest{

	/**
	 * @var Gui_Widget_Tab
	 */
	protected $_tabs = null;
	
	protected function setUp(){
		parent::setUp();
		$this->_tabs = new Gui_Widget_Tabs();
	}
	
	public function testAddTabTabObject(){
		$tab = new Gui_Widget_Tabs_Tab();
		$this->_tabs->addTab($tab);
		list($t) = $this->_tabs->getTabs();
		$this->assertTrue($tab === $t);
	}
	
	public function testAddTabNoArgs(){
		$this->_tabs->addTab();
		list($tab) = $this->_tabs->getTabs();
		$this->assertInstanceOf('Gui_Widget_Tabs_Tab', $tab);
	}
	
	public function testAddTabArray(){
		$this->_tabs->addTab(array('title' => 'testAddTabArray'));
		list($tab) = $this->_tabs->getTabs();
		$this->assertInstanceOf('Gui_Widget_Tabs_Tab', $tab);
		$this->assertEquals('testAddTabArray', $tab->getTitle());
	}
	
	public function testAddTabClassName(){
		$this->_tabs->addTab(new Gui_Widget_TabsTest_Tab(), array('title' => 'testAddTabClassName'));
		list($tab) = $this->_tabs->getTabs();
		$this->assertInstanceOf('Gui_Widget_TabsTest_Tab', $tab);
		$this->assertEquals('testAddTabClassName', $tab->getTitle());
	}
	
	public function testAddTabNoTabObject(){
		$this->setExpectedException('Zest_Exception');
		$this->_tabs->addTab(new Gui_Widget_TabsTest_TabException());
	}
	
	public function testAddTabNoTabObjectString(){
		$this->setExpectedException('Zest_Exception');
		$this->_tabs->addTab('Gui_Widget_TabsTest_TabException');
	}
	
	public function testSetTabs(){
		$this->_tabs->setTabs(array(
			new Gui_Widget_Tabs_Tab(array('title' => 'title 1')),
			'Ns_Widget_TabsTest_Tab' => array('title' => 'title 2')
		));
		$titles = array();
		foreach($this->_tabs as $tab){
			$titles[] = $tab->getTitle();
		}
		$this->assertEquals(array('title 1', 'title 2'), $titles);
	}
	
	public function testIterator(){
		$this->_tabs->addTab();
		$this->_tabs->addTab();
		$count = 0;
		foreach($this->_tabs as $tab){
			$count++;
		}
		$this->assertEquals(2, $count);
	}
	
	public function testRender(){
		$this->_tabs->addTab(array(
			'title' => 'testRender title',
			'content' => 'testRender content'
		));
		list($tab) = $this->_tabs->getTabs();
		
		$xml = new SimpleXMLElement('<root>'.$this->_tabs->render().'</root>');
		
		// tabs
		$this->assertEquals($this->_tabs->getId(), (string) $xml->div[0]['id']);
		$this->assertEquals('gui-widget-tabs', (string) $xml->div[0]['class']);
		
		// tab
		$this->assertEquals($tab->getId().'-title', (string) $xml->div[0]->ul[0]->li[0]['id']);
		$this->assertEquals($tab->getId().'-content', (string) $xml->div[0]->div[0]['id']);
		
		$this->assertEquals('testRender title', (string) $xml->div[0]->ul[0]->li[0]->a[0]->span);
		$this->assertEquals('testRender content', (string) $xml->div[0]->div[0]);
	}
	
}

class Gui_Widget_TabsTest_Tab extends Gui_Widget_Tabs_Tab{
}

class Ns_Widget_TabsTest_Tab extends Gui_Widget_Tabs_Tab{
}

class Gui_Widget_TabsTest_TabException{
}