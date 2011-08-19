<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage UnitTests
 */
class Gui_Form_Element_WidgetTest extends Gui_AbstractTest{
	
	/**
	 * @var Gui_Widget
	 */
	protected $_widget = null;
	
	protected function setUp(){
		parent::setUp();
		$this->_widget = new Ns_Form_Element_WidgetTest_Widget_Special();
	}

	public function testGetSetWidgetOption(){
		$this->_widget->setWidgetOption('auth_option', 'testGetSetWidgetOption');
		$this->assertEquals('testGetSetWidgetOption', $this->_widget->getWidgetOption('auth_option'));
	}
	
	public function testGetSetWidgetOptionException(){
		$this->setExpectedException('Zest_Exception');
		$this->_widget->setWidgetOption('not_auth_option', true);
	}
	
	public function testSetWidgetOptions(){
		$this->_widget->setWidgetOptions(array('auth_option' => 'testSetWidgetOptions'));
		$this->assertEquals('testSetWidgetOptions', $this->_widget->getWidgetOption('auth_option'));
	}
	
	public function testGetSetWidgetEvent(){
		$this->_widget->setWidgetEvent('auth_event', 'testGetSetWidgetEvent');
		$this->assertEquals('testGetSetWidgetEvent', $this->_widget->getWidgetEvent('auth_event'));
	}
	
	public function testSetWidgetEvents(){
		$this->_widget->setWidgetEvents(array('auth_event' => 'testGetSetWidgetEvent'));
		$this->assertEquals('testGetSetWidgetEvent', $this->_widget->getWidgetEvent('auth_event'));
	}
	
	public function testGetWidgetName(){
		$this->assertEquals('special', $this->_widget->getWidgetName());
	}
	
	public function testRender(){
		$this->_widget->setViewScript('widget/testRender.phtml');
		$render = $this->_widget->render();
		
		// jquery, ui.core, ui.special, inline
		$this->assertEquals(4, count(self::$_view->headScript()));
		
		// jquery-ui-[version].css
		$this->assertEquals(1, count(self::$_view->headLink()));
		
		$this->assertContains('$("#ns-form-element-widgettest-widget-special").special({});', $render);
	}
	
	public function testGetJqueryIdSelector(){
		$this->assertEquals('ns-form-element-widgettest-widget-special', $this->_widget->getJqueryIdSelector());
	}
	
	public function testGetJsonOptions(){
		$this->assertEquals('{}', $this->_widget->getJsonOptions());
		
		$this->_widget->setWidgetOption('auth_option', 'testGetJsonOptions');
		$this->assertEquals('{"auth_option":"testGetJsonOptions"}', $this->_widget->getJsonOptions());
		
		$this->_widget->setWidgetEvent('auth_event', 'console.debug(ui);');
		$this->assertEquals('{"auth_option":"testGetJsonOptions","auth_event":function(event, ui){console.debug(ui);}}', $this->_widget->getJsonOptions());
	}
	
}

class Gui_Form_Element_WidgetTest_Widget extends Gui_Widget{
}

class Ns_Form_Element_WidgetTest_Widget_Special extends Gui_Widget{
	protected $_availableWidgetOptions = array('auth_option');
	protected $_availableWidgetEvents = array('auth_event');
	public function getJqueryIdSelector(){
		return $this->_getJqueryIdSelector();
	}
	public function getJsonOptions(){
		return $this->_getJsonOptions();
	}
}