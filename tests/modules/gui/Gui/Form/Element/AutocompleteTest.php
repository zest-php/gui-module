<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage UnitTests
 */
class Gui_Form_Element_AutocompleteTest extends Gui_AbstractTest{
	
	public function testRender(){
		$form = new Gui_Form();
		$form->addElement('autocomplete', 'testRender', array(
			'decorators' => array('viewHelper', 'tdElement'),
			'label' => 'testRender'
		));
		
		$xml = new SimpleXMLElement($form->testRender->render(self::$_view));
		$this->assertEquals('text', (string) $xml->input[0]['type']);
		$this->assertEmpty((string) $xml->input[0]['value']);
		
		// jquery, ui.core, ui.widget, ui.position, ui.autocomplete, inlineScript
		$this->assertEquals(6, count(self::$_view->headScript()));
		
		// jquery-ui-[version].css
		$this->assertEquals(1, count(self::$_view->headLink()));
	}
	
}