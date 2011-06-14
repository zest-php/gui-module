<?php

/**
 * @category Gui
 * @package Gui_Form
 * @subpackage Element
 */
class Gui_Form_Element_Autocomplete extends Gui_Form_Element_Widget{
	
	/**
	 * @var array
	 */
	protected $_availableWidgetOptions = array(
		'appendTo', 'delay', 'disabled', 'minLength', 'source'
	);
	
	/**
	 * @var array
	 */
	protected $_availableWidgetEvents = array(
		'change', 'close', 'create', 'focus', 'open', 'search', 'select'
	);
	
	/**
	 * @var string
	 */
	public $helper = 'formText';
	
}