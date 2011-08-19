<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage UnitTests
 */
class Gui_Form_Element_WysiwygTest extends Gui_AbstractTest{

	public function testRenderException(){
		$this->setExpectedException('Zest_Exception');
		
		$form = new Gui_Form();
		$form->addElement('wysiwyg', 'testRender', array(
			'decorators' => array('viewHelper', 'tdElement'),
			'label' => 'testRender'
		));
		
		$form->testRender->getAdapter();
	}

	public function testRender(){
		$form = new Gui_Form();
		$form->addElement('wysiwyg', 'testRender', array(
			'adapter' => 'ckeditor',
			'adapterOptions' => array(
				'resize_enabled' => false
			),
			'decorators' => array('viewHelper', 'tdElement'),
			'label' => 'testRender'
		));
		
		$xml = new SimpleXMLElement($form->testRender->render(self::$_view));
		$this->assertEquals('testRender', (string) $xml->textarea[0]['name']);
		
		// ckeditor.js, jquery-1.6.1.min.js, inlineScript
		$this->assertEquals(3, count(self::$_view->headScript()));
	}
	
}