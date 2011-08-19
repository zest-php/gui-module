<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage UnitTests
 */
class Gui_Form_Decorator_ViewHelperTest extends Gui_AbstractTest{
	
	public function testRender(){
		$elements = array(
			'Zend_Form_Element_Button',
			'Zend_Form_Element_Reset',
			'Zend_Form_Element_Submit',
			'Gui_Form_Element_Button',
			'Gui_Form_Element_Reset',
			'Gui_Form_Element_Submit'
		);
		
		foreach($elements as $name){
			$element = new $name($name, array(
				'label' => 'testRender',
				'decorators' => array(new Gui_Form_Decorator_ViewHelper())
			));
			
			$xml = new SimpleXMLElement('<div>'.$element->render(self::$_view).'</div>');
			if(is_int(strpos($name, 'Button'))){
				$this->assertEquals('testRender', (string) $xml->button);
				$this->assertEquals($name, (string) $xml->button['name']);
			}
			else{
				$this->assertEquals('testRender', (string) $xml->input['value']);
				$this->assertEquals($name, (string) $xml->input['name']);
			}
		}
	}
	
}