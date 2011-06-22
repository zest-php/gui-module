<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage Element
 */
class Gui_Form_Element_Datepicker extends Gui_Form_Element_Widget{
	
	/**
	 * @var array
	 */
	protected $_availableWidgetOptions = array(
		'altField', 'altFormat', 'appendText', 'autoSize', 'buttonImage', 'buttonImageOnly', 'buttonText', 'calculateWeek', 'changeMonth', 'changeYear',
		'closeText', 'constrainInput', 'currentText', 'dateFormat', 'dayNames', 'dayNamesMin', 'dayNamesShort', 'defaultDate', 'disabled', 'duration',
		'firstDay', 'gotoCurrent', 'hideIfNoPrevNext', 'isRTL', 'maxDate', 'minDate', 'monthNames', 'monthNamesShort', 'navigationAsDateFormat', 'nextText',
		'numberOfMonths', 'prevText', 'selectOtherMonths', 'shortYearCutoff', 'showAnim', 'showButtonPanel', 'showCurrentAtPos', 'showMonthAfterYear', 'showOn', 'showOptions',
		'showOtherMonths', 'showWeek', 'stepMonths', 'weekHeader', 'yearRange', 'yearSuffix'
	);
	
	/**
	 * @var array
	 */
	protected $_availableWidgetEvents = array(
		'beforeShow', 'beforeShowDay', 'create', 'onChangeMonthYear', 'onClose', 'onSelect'
	);
	
	/**
	 * @var array
	 */
	protected $_widgetOptions = array(
		'altFormat' => 'yy-mm-dd',
		'changeYear' => true,
		'firstDay' => 1
	);
	
	/**
	 * @var string
	 */
	public $helper = 'formHidden';
	
	/**
	 * @var boolean
	 */
	protected $_forceYearFourDigitsDisplay = true;
	
	/**
	 * @return void
	 */
	public function init(){
		if(Zend_Registry::isRegistered('Zend_Locale')){
			$locale = Zend_Registry::get('Zend_Locale');
		}
		else{
			$locale = new Zend_Locale();
		}
		$data = Zend_Locale_Data::getList($locale->toString(), 'date');
		if($this->_forceYearFourDigitsDisplay && !is_int(strpos($data['short'], 'yyyy'))){
			$data['short'] = str_replace('yy', 'yyyy', $data['short']);
		}
		if(is_null($this->getWidgetOption('dateFormat'))){
			$this->setWidgetOption('dateFormat', $this->_getJavaScriptFormat($data['short']));
		}
	}
	
	/**
	 * @param boolean $force
	 * @return Gui_Form_Element_Datepicker
	 */
	public function setForceYearFourDigitsDisplay($force){
		$this->_forceYearFourDigitsDisplay = $force;
		return $this;
	}
	
	/**
	 * @param Zend_View_Interface $view
	 * @return string
	 */
	public function render(Zend_View_Interface $view = null){
		$date = new Zend_Date($this->getValue());
		$picker = new Zend_Form_Element_Text($this->_getJqueryIdSelector(), array(
			'decorators' => array('viewHelper'),
			'value' => $date->get($this->_getZendDateFormat($this->getWidgetOption('dateFormat')))
		));
		
		$this->setWidgetOptions(array(
			'altField' => '#'.$this->getName()
		));
		
		return str_replace('<input', $picker->render($view).'<input', parent::render($view));
	}
	
	/**
	 * @return string
	 */
	protected function _getJqueryIdSelector(){
		return $this->getName().'_picker';
	}
	
	/**
	 * @params string $value
	 * @return Gui_Form_Element_Datepicker
	 */
	public function setValue($value){
		if(is_numeric($value)){
			$date = new Zend_Date($value);
			$value = $date->get($this->_getZendDateFormat($this->getWidgetOption('altFormat')));
		}
		parent::setValue($value);
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getValue(){
		if(!parent::getValue()){
			$this->setValue(time());
		}
		return parent::getValue();
	}
	
	/**
	 * formats
	 * 		PHP			d	m	y	Y
	 * 		Zend		dd	MM	yy	yyyy
	 * 		Javascript	dd	mm	y	yy
	 * 
	 * @param string $part
	 * @return string
	 */
	protected function _getZendDateFormat($part){
		$part = str_replace('mm', 'MM', $part);
		
		$fourDigits = is_int(strpos($part, 'yy'));
		if($fourDigits){
			$part = str_replace('yy', 'yyyy', $part);
		}
		else{
			$part = str_replace('y', 'yy', $part);
		}
		
		return $part;
	}
	
	/**
	 * @param string $name
	 * @return string
	 */
	protected function _getJavaScriptFormat($part){
		$part = str_replace('MM', 'mm', $part);
		
		$fourDigits = is_int(strpos($part, 'yyyy'));
		if($fourDigits){
			$part = str_replace('yyyy', 'yy', $part);
		}
		else{
			$part = str_replace('yy', 'y', $part);
		}
		
		return $part;
	}
	
}