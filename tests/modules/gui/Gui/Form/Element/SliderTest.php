<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage UnitTests
 */
class Gui_Form_Element_SliderTest extends Gui_AbstractTest{
	
	public function testWidgetName(){
		$element = new Gui_Form_Element_Slider('testWidgetName');
		$this->assertEquals('slider', $element->getWidgetName());
	}
	
	public function testRender(){
		$form = new Gui_Form();
		$form->addElement('slider', 'testRender', array(
			'decorators' => array('viewHelper', 'tdElement'),
			'label' => 'testRender'
		));
		
		$xml = new SimpleXMLElement($form->testRender->render(self::$_view));
		$this->assertEquals('testRender_slider', (string) $xml->div[0]['id']);
		$this->assertEquals('hidden', (string) $xml->input[0]['type']);
		$this->assertEquals('testRender', (string) $xml->input[0]['name']);
		
		// jquery, ui.core, ui.widget, ui.mouse, ui.slider, inlineScript
		$this->assertEquals(6, count(self::$_view->headScript()));
		
		// jquery-ui-[version].css
		$this->assertEquals(1, count(self::$_view->headLink()));
	}
	
	public function testMin(){
		$element = new Gui_Form_Element_Slider('testWidgetName');
		$this->assertEquals(0, $element->getValue());
		
		$element = new Gui_Form_Element_Slider('testWidgetName', array(
			'value' => -10
		));
		$this->assertEquals(0, $element->getValue());
		
		$element = new Gui_Form_Element_Slider('testWidgetName', array(
			'widgetOptions' => array('min' => 10)
		));
		$this->assertEquals(10, $element->getValue());
		
		$element = new Gui_Form_Element_Slider('testWidgetName', array(
			'widgetOptions' => array('min' => 10),
			'value' => 5
		));
		$this->assertEquals(10, $element->getValue());
	}
	
	public function testMax(){
		$element = new Gui_Form_Element_Slider('testWidgetName', array(
			'value' => 110
		));
		$this->assertEquals(100, $element->getValue());
		
		$element = new Gui_Form_Element_Slider('testWidgetName', array(
			'widgetOptions' => array('max' => 90),
			'value' => 100
		));
		$this->assertEquals(90, $element->getValue());
	}
	
	public function testRange(){
		$element = new Gui_Form_Element_Slider('testWidgetName', array(
			'widgetOptions' => array(
				'range' => true
			)
		));
		$this->assertEquals('0~0', $element->getValue());
		
		$element = new Gui_Form_Element_Slider('testWidgetName', array(
			'widgetOptions' => array(
				'min' => 10,
				'range' => true
			)
		));
		$this->assertEquals('10~10', $element->getValue());
		
		$element = new Gui_Form_Element_Slider('testWidgetName', array(
			'widgetOptions' => array(
				'min' => 10,
				'range' => true
			),
			'value' => '50'
		));
		$this->assertEquals('50~50', $element->getValue());
		
		$element = new Gui_Form_Element_Slider('testWidgetName', array(
			'widgetOptions' => array(
				'min' => 90,
				'range' => true
			),
			'value' => '50'
		));
		$this->assertEquals('90~90', $element->getValue());
		
		$element = new Gui_Form_Element_Slider('testWidgetName', array(
			'widgetOptions' => array(
				'min' => 90,
				'range' => true
			),
			'value' => '50~50'
		));
		$this->assertEquals('90~90', $element->getValue());
		
		$element = new Gui_Form_Element_Slider('testWidgetName', array(
			'widgetOptions' => array(
				'max' => 10,
				'range' => true
			),
			'value' => '50'
		));
		$this->assertEquals('10~10', $element->getValue());
		
		$element = new Gui_Form_Element_Slider('testWidgetName', array(
			'widgetOptions' => array(
				'max' => 10,
				'range' => true
			),
			'value' => '50~50'
		));
		$this->assertEquals('10~10', $element->getValue());
		
		$element = new Gui_Form_Element_Slider('testWidgetName', array(
			'widgetOptions' => array(
				'range' => true
			),
			'value' => '50~50'
		));
		$this->assertEquals('50~50', $element->getValue());
	}
	
}