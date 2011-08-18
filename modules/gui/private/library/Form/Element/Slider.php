<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage Element
 */
class Gui_Form_Element_Slider extends Gui_Form_Element_Widget{
	
	/**
	 * @var array
	 */
	protected $_availableWidgetOptions = array(
		'animate', 'disabled', 'max', 'min', 'orientation', 'range', 'step', 'value', 'values'
	);
	
	/**
	 * @var array
	 */
	protected $_availableWidgetEvents = array(
		'change', 'create', 'slide', 'start', 'stop'
	);
	
	/**
	 * @var array
	 */
	protected $_widgetOptions = array(
		'min' => 0,
		'max' => 100
	);
	
	/**
	 * @var string
	 */
	protected $_rangeValuesSeparator = '~';
	
	/**
	 * @var string
	 */
	public $helper = 'formHidden';
	
	/**
	 * @return string
	 */
	public function getValue(){
		$value = parent::getValue();
		
		$max = $this->getWidgetOption('max');
		$min = $this->getWidgetOption('min');
		
		if($this->getWidgetOption('range')){
			if(!is_int(strpos($value, $this->_rangeValuesSeparator))){
				$value = $value ? $value.$this->_rangeValuesSeparator.$value : '0'.$this->_rangeValuesSeparator.'0';
			}
			$values = explode($this->_rangeValuesSeparator, $value);
			if($values[0] < $min) $values[0] = $min;
			if($values[0] > $max) $values[0] = $max;
			if($values[1] < $min) $values[1] = $min;
			if($values[1] > $max) $values[1] = $max;
			$value = implode($this->_rangeValuesSeparator, $values);
		}
		else{
			$value = intval($value);
			if($value < $min){
				$value = $min;
			}
			if($value > $max){
				$value = $max;
			}
		}
		
		return $value;
	}
	
	/**
	 * @param Zend_View_Interface $view
	 * @return string
	 */
	public function render(Zend_View_Interface $view = null){
		if($this->getWidgetOption('range')){
			$this->setWidgetOption('values', explode($this->_rangeValuesSeparator, $this->getValue()));
			$this->setWidgetEvent('slide', '$("#'.$this->getName().'").val(ui.values.join("'.$this->_rangeValuesSeparator.'"))');
		}
		else{
			$this->setWidgetOption('value', $this->getValue());
			$this->setWidgetEvent('slide', '$("#'.$this->getName().'").val(ui.value)');
		}
		$div = '<div id="'.$this->getJqueryIdSelector().'"></div>';
		return str_replace('<input', $div.'<input', parent::render($view));
	}
	
	/**
	 * @return string
	 */
	public function getJqueryIdSelector(){
		return $this->getName().'_slider';
	}
	
}