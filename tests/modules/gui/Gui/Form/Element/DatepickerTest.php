<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage UnitTests
 */
class Gui_Form_Element_DatepickerTest extends Gui_AbstractTest{
	
	public function testWidgetName(){
		$element = new Gui_Form_Element_Datepicker('testWidgetName');
		$this->assertEquals('datepicker', $element->getWidgetName());
	}
	
	public function testRender(){
		$form = new Gui_Form();
		$form->addElement('datepicker', 'testRender', array(
			'decorators' => array('viewHelper', 'tdElement'),
			'label' => 'testRender'
		));
		
		$xml = new SimpleXMLElement($form->testRender->render(self::$_view));
		$this->assertEquals('text', (string) $xml->input[0]['type']);
		$this->assertEquals('testRender_picker', (string) $xml->input[0]['name']);
		$this->assertEquals(date('d/m/Y'), (string) $xml->input[0]['value']);
		$this->assertEquals('hidden', (string) $xml->input[1]['type']);
		$this->assertEquals('testRender', (string) $xml->input[1]['name']);
		$this->assertEquals(date('Y-m-d'), (string) $xml->input[1]['value']);
		
		// jquery, ui.core, ui.datepicker, ui.i18n, inlineScript
		$this->assertEquals(5, count(self::$_view->headScript()));
		
		// jquery-ui-[version].css
		$this->assertEquals(1, count(self::$_view->headLink()));
	}
	
	public function testNumericValue(){
		$element = new Gui_Form_Element_Datepicker('testLocale');
		
		$element->setValue(0);
		$this->assertEquals('1970-01-01', $element->getValue());
		
		$element->setValue(60 * 60 * 24 * 365);
		$this->assertEquals('1971-01-01', $element->getValue());
	}
	
	public function testLocale(){
		// fr_FR
		$locale = new Zend_Locale('fr_FR');
		Zend_Registry::set('Zend_Locale', $locale);
		
		$element = new Gui_Form_Element_Datepicker('testLocale');
		$this->assertEquals('dd/mm/yy', $element->getWidgetOption('dateFormat'));
		
		$element = new Gui_Form_Element_Datepicker('testLocale', array('forceYearFourDigitsDisplay' => false));
		$this->assertEquals('dd/mm/y', $element->getWidgetOption('dateFormat'));
		
		// en_GB
		$locale->setLocale('en_GB');
		
		$element = new Gui_Form_Element_Datepicker('testLocale');
		$this->assertEquals('dd/mm/yy', $element->getWidgetOption('dateFormat'));
		
		$element = new Gui_Form_Element_Datepicker('testLocale', array('forceYearFourDigitsDisplay' => false));
		$this->assertEquals('dd/mm/yy', $element->getWidgetOption('dateFormat'));
		
		unset(Zend_Registry::getInstance()->Zend_Locale);
	}
	
}