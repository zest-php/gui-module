<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage UnitTests
 */
class Gui_Form_Element_SubmitTest extends Gui_AbstractTest{
	
	public function testWidgetName(){
		$element = new Gui_Form_Element_Submit('testWidgetName');
		$this->assertEquals('button', $element->getWidgetName());
	}
	
	public function testRender(){
		$form = new Gui_Form();
		$form->addElement('submit', 'testRender', array(
			'decorators' => array('viewHelper', 'tdElement'),
			'label' => 'testRender'
		));
		
		$xml = new SimpleXMLElement($form->testRender->render(self::$_view));
		$this->assertEquals('submit', (string) $xml->input[0]['type']);
		$this->assertEquals('testRender', (string) $xml->input[0]['value']);
		
		// jquery, ui.core, ui.widget, ui.button, inlineScript
		$this->assertEquals(5, count(self::$_view->headScript()));
		
		// jquery-ui-[version].css
		$this->assertEquals(1, count(self::$_view->headLink()));
	}
	
}